<?php

namespace App\Controllers;

use App\Models\LowonganModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;

class Lowongan extends BaseController
{
    protected $lowonganModel;
    protected $kriteriaModel;
    protected $subKriteriaModel;

    public function __construct()
    {
        $this->lowonganModel    = new LowonganModel();
        $this->kriteriaModel    = new KriteriaModel();
        $this->subKriteriaModel = new SubKriteriaModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        // Auto-expire jobs whose end_date has passed
        $db->query("UPDATE lowongan SET status='expired' WHERE end_date IS NOT NULL AND end_date < CURDATE() AND status = 'active'");

        $filter  = $this->request->getGet('status');
        $builder = $this->lowonganModel->orderBy('id', 'DESC');
        if ($filter && in_array($filter, ['draft', 'active', 'expired'])) {
            $builder->where('status', $filter);
        }
        $lowongan = $builder->findAll();

        $counts = [
            'all'     => $this->lowonganModel->countAll(),
            'draft'   => $this->lowonganModel->where('status', 'draft')->countAllResults(),
            'active'  => $this->lowonganModel->where('status', 'active')->countAllResults(),
            'expired' => $this->lowonganModel->where('status', 'expired')->countAllResults(),
        ];

        return view('lowongan/index', [
            'title'    => 'Manage Jobs',
            'menu'     => 'lowongan',
            'lowongan' => $lowongan,
            'filter'   => $filter,
            'counts'   => $counts,
        ]);
    }

    // Quick create from modal — no kriteria yet, redirect to edit
    public function simpanBasic()
    {
        $start  = $this->request->getPost('start_date') ?: null;
        $end    = $this->request->getPost('end_date')   ?: null;
        $status = $this->request->getPost('status')     ?: 'draft';
        $today  = date('Y-m-d');

        // Auto-compute status from dates if not explicitly set to draft
        if ($status !== 'draft' && $start && $end) {
            if ($today < $start)      $status = 'draft';
            elseif ($today > $end)    $status = 'expired';
            else                      $status = 'active';
        }

        $this->lowonganModel->save([
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'start_date'     => $start,
            'end_date'       => $end,
            'status'         => $status,
        ]);

        $id = $this->lowonganModel->getInsertID();

        return redirect()
            ->to('/lowongan/edit/' . $id)
            ->with('success', 'Lowongan berhasil dibuat. Tambahkan kriteria SAW di bawah ini.');
    }

    public function list()
    {
        $db       = \Config\Database::connect();
        $lowongan = $this->lowonganModel->findAll();

        foreach ($lowongan as &$l) {
            $kriteria = $db->table('kriteria')->where('id_lowongan', $l['id'])->get()->getResultArray();
            foreach ($kriteria as &$k) {
                $k['sub'] = $db->table('sub_kriteria')->where('id_kriteria', $k['id_kriteria'])->get()->getResultArray();
            }
            $l['kriteria'] = $kriteria;
        }

        return view('lowongan/list', ['lowongan' => $lowongan]);
    }

    public function tambah()
    {
        return view('lowongan/tambah');
    }

    public function simpan()
    {
        $bobot = $this->request->getPost('bobot') ?: [];

        if (array_sum($bobot) != 100) {
            return redirect()->back()->withInput()->with('error', 'Total bobot harus 100%');
        }

        $start  = $this->request->getPost('start_date') ?: null;
        $end    = $this->request->getPost('end_date')   ?: null;
        $status = $this->request->getPost('status')     ?: 'draft';

        $this->lowonganModel->save([
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'start_date'     => $start,
            'end_date'       => $end,
            'status'         => $status,
        ]);

        $id_lowongan   = $this->lowonganModel->getInsertID();
        $namaKriteria  = $this->request->getPost('nama_kriteria');
        $atribut       = $this->request->getPost('atribut');
        $subNama       = $this->request->getPost('sub_nama');
        $subNilai      = $this->request->getPost('sub_nilai');

        foreach ($namaKriteria as $i => $kriteria) {
            $this->kriteriaModel->save([
                'id_lowongan'   => $id_lowongan,
                'nama_kriteria' => $kriteria,
                'bobot'         => $bobot[$i],
                'atribut'       => $atribut[$i],
            ]);
            $id_kriteria = $this->kriteriaModel->getInsertID();

            if (isset($subNama[$i])) {
                foreach ($subNama[$i] as $x => $sub) {
                    $this->subKriteriaModel->save([
                        'id_kriteria' => $id_kriteria,
                        'nama_sub'    => $sub,
                        'nilai'       => $subNilai[$i][$x],
                    ]);
                }
            }
        }

        return redirect()->to('/admin/lowongan')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $db       = \Config\Database::connect();
        $lowongan = $this->lowonganModel->find($id);

        $kriteria = $db->table('kriteria')->where('id_lowongan', $id)->get()->getResultArray();
        foreach ($kriteria as &$k) {
            $k['sub'] = $db->table('sub_kriteria')->where('id_kriteria', $k['id_kriteria'])->get()->getResultArray();
        }
        $lowongan['kriteria'] = $kriteria;

        return view('lowongan/edit', ['lowongan' => $lowongan]);
    }

    public function update($id)
    {
        $db    = \Config\Database::connect();
        $start = $this->request->getPost('start_date') ?: null;
        $end   = $this->request->getPost('end_date')   ?: null;
        $status = $this->request->getPost('status')    ?: 'draft';

        $db->transStart();

        $this->lowonganModel->update($id, [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'start_date'     => $start,
            'end_date'       => $end,
            'status'         => $status,
        ]);

        // Delete old kriteria + sub-kriteria
        $kriteria_lama = $db->table('kriteria')->where('id_lowongan', $id)->get()->getResultArray();
        foreach ($kriteria_lama as $k) {
            $db->table('sub_kriteria')->where('id_kriteria', $k['id_kriteria'])->delete();
        }
        $db->table('kriteria')->where('id_lowongan', $id)->delete();

        // Insert new kriteria
        $nama_kriteria = $this->request->getPost('nama_kriteria') ?: [];
        $bobot         = $this->request->getPost('bobot')         ?: [];
        $atribut       = $this->request->getPost('atribut')       ?: [];
        $nama_sub      = $this->request->getPost('nama_sub')      ?: [];
        $nilai_sub     = $this->request->getPost('nilai_sub')     ?: [];

        foreach ($nama_kriteria as $i => $nk) {
            $db->table('kriteria')->insert([
                'nama_kriteria' => $nk,
                'bobot'         => $bobot[$i],
                'atribut'       => $atribut[$i],
                'id_lowongan'   => $id,
            ]);
            $id_kriteria = $db->insertID();

            if (isset($nama_sub[$i])) {
                foreach ($nama_sub[$i] as $j => $ns) {
                    $db->table('sub_kriteria')->insert([
                        'id_kriteria' => $id_kriteria,
                        'nama_sub'    => $ns,
                        'nilai'       => $nilai_sub[$i][$j],
                    ]);
                }
            }
        }

        $db->transComplete();

        return redirect()->to('/admin/lowongan')->with('success', 'Lowongan berhasil diupdate');
    }

    public function hapus($id)
    {
        $this->lowonganModel->delete($id);
        return redirect()->to('/admin/lowongan');
    }

    public function pelamar()
    {
        $lowongan = $this->lowonganModel->findAll();
        return view('pelamar/lowongan', ['lowongan' => $lowongan]);
    }
}
