<?php

namespace App\Controllers;

use App\Libraries\LamaranStatusService;

class Perhitungan extends BaseController
{
    public function __construct()
    {
        helper('lamaran');
    }

    public function listLowongan()
    {
        if(session()->get('role') != 'admin'){
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $lowongan = $db->query("
            SELECT * FROM lowongan
        ")->getResultArray();

        return view('perhitungan/list_lowongan', [
            'lowongan' => $lowongan,
            'title'    => 'Ranking SAW',
            'menu'     => 'ranking',
        ]);
    }

    /**
     * Setelah ranking SAW: tandai pelamar menunggu validasi dokumen admin.
     * Status "Lolos Administrasi" hanya via Lamaran::validasiAdministrasi().
     */
    public function luluskan($id_lamaran)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db     = \Config\Database::connect();
        $status = LamaranStatusService::MENUNGGU_VALIDASI;

        LamaranStatusService::sync($db, (int) $id_lamaran, $status);

        $db->table('tahapan_rekrutmen')->insert([
            'id_lamaran' => $id_lamaran,
            'tahapan'    => $status,
            'catatan'    => 'Ranking SAW selesai — menunggu validasi dokumen administrasi.',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with(
            'success',
            'Pelamar ditandai menunggu validasi administrasi. Silakan periksa dokumen lalu setujui.'
        );
    }

    public function index($id_lowongan)
    {
        if(session()->get('role') != 'admin'){
            return redirect()->to('/login');
        }
        $db = \Config\Database::connect();

        $statusExpr = LamaranStatusService::statusSelectExpression($db, 'l');

        // ambil semua data penilaian
        $data = $db->query("
        SELECT 
        l.id_lamaran,
        {$statusExpr} as status,
        p.nama_pelamar as nama,
        k.id_kriteria,
        k.bobot,
        k.atribut,
        pen.nilai
        FROM lamaran l
        JOIN pelamar p ON p.id_pelamar = l.id_pelamar
        JOIN penilaian pen ON pen.id_lamaran = l.id_lamaran
        JOIN kriteria k ON k.id_kriteria = pen.id_kriteria
        WHERE l.id_lowongan = $id_lowongan
        ")->getResultArray();

        // susun matrix
        $matrix = [];
        foreach ($data as $d) {
            $matrix[$d['id_lamaran']]['nama'] = $d['nama'];
            $matrix[$d['id_lamaran']]['status'] = $d['status'];
            $matrix[$d['id_lamaran']]['nilai'][$d['id_kriteria']] = $d['nilai'];
        }

        $hasil = [];

        foreach ($matrix as $id_lamaran => $m) {

            $total = 0;

            foreach ($m['nilai'] as $id_kriteria => $nilai) {

                // ambil semua nilai pada kriteria ini
                $all = array_map(function($x) use ($id_kriteria) {
                    return $x['nilai'][$id_kriteria] ?? 0;
                }, $matrix);

                $max = max($all);
                $min = min($all);

                // ambil atribut & bobot
                foreach ($data as $d) {
                    if ($d['id_kriteria'] == $id_kriteria) {
                        $atribut = $d['atribut'];
                        $bobot = $d['bobot'];
                        break;
                    }
                }

                // normalisasi
                if ($atribut == 'benefit') {
                    $r = $nilai / $max;
                } else {
                    $r = $min / $nilai;
                }

                // hitung
                $total += $bobot * $r;
            }

            $hasil[] = [

                'id_lamaran' => $id_lamaran,

                'nama' => $m['nama'],

                'nilai' => $total,

                'status' => $m['status']

            ];
        }

        // ranking
        usort($hasil, function($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        return view('perhitungan/index', [
            'title'       => 'Ranking SAW',
            'menu'        => 'ranking',
            'hasil'       => $hasil,
            'id_lowongan' => $id_lowongan,
        ]);
    }

}