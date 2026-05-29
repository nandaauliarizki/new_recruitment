<?php

namespace App\Controllers;

use App\Libraries\LamaranStatusService;
use App\Models\LamaranModel;
use App\Models\LowonganModel;
use App\Models\PelamarModel;
use App\Models\TahapanRekrutmenModel;

class Pelamar extends BaseController
{
    protected $pelamar;
    protected $lowongan;
    protected $lamaran;
    protected $tahapan;

    public function __construct()
    {
        $this->pelamar  = new PelamarModel();
        $this->lowongan = new LowonganModel();
        $this->lamaran  = new LamaranModel();
        $this->tahapan  = new TahapanRekrutmenModel();
    }

    public function dashboard()
    {
        if (session()->get('role') != 'pelamar') {
            return redirect()->to('/login');
        }

        helper('lamaran');

        $db = \Config\Database::connect();

        $totalLowongan = $db->table('lowongan')
            ->where('status', 'active')
            ->where('end_date >=', date('Y-m-d'))
            ->countAllResults();
            
        $pelamar = $db->table('pelamar')
            ->where('id_user', session()->get('id_user'))
            ->get()->getRowArray();

        $totalLamaran = 0;
        $pending      = 0;
        $diterima     = 0;

        if ($pelamar) {
            $lamaranRows = $db->table('lamaran')
                ->where('id_pelamar', $pelamar['id_pelamar'])
                ->get()->getResultArray();

            $totalLamaran = count($lamaranRows);

            foreach ($lamaranRows as $row) {
                $st = lamaran_status_from_row($row);
                if (in_array($st, ['pending', 'menunggu validasi administrasi'], true)) {
                    $pending++;
                }
                if ($st === 'diterima') {
                    $diterima++;
                }
            }
        }

        $today = date('Y-m-d');

        $lowongan = $db->table('lowongan')
            ->where('status', 'active')
            ->where('end_date >=', $today)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        return view('pelamar/dashboard', [
            'lowongan'      => $lowongan,
            'totalLowongan' => $totalLowongan,
            'totalLamaran'  => $totalLamaran,
            'pending'       => $pending,
            'diterima'      => $diterima,
        ]);
    }

    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/login');
        }

        helper('lamaran');

        $db      = \Config\Database::connect();
        $builder = $db->table('lamaran');

        $builder->select('
            lamaran.*,
            pelamar.nama_pelamar,
            pelamar.email,
            pelamar.pendidikan,
            pelamar.tanggal_lamar,
            pelamar.id_pelamar,
            lowongan.nama_pekerjaan
        ');

        $builder->join('pelamar', 'pelamar.id_pelamar = lamaran.id_pelamar');
        $builder->join('lowongan', 'lowongan.id = lamaran.id_lowongan');

        if ($id_lowongan = $this->request->getGet('lowongan')) {
            $builder->where('lamaran.id_lowongan', $id_lowongan);
        }

        if ($status = $this->request->getGet('status')) {
            $normalized = LamaranStatusService::normalize($status);
            if (LamaranStatusService::isManageEligible($normalized)) {
                $builder->groupStart();
                foreach (LamaranStatusService::statusColumns($db) as $col) {
                    $builder->orWhere("lamaran.{$col}", $normalized);
                }
                $builder->groupEnd();
            }
        }

        if ($keyword = $this->request->getGet('keyword')) {
            $builder->like('pelamar.nama_pelamar', $keyword);
        }

        $builder->orderBy('lamaran.id_lamaran', 'DESC');

        $data['pelamar']  = LamaranStatusService::filterManageRows(
            $builder->get()->getResultArray()
        );
        $data['lowongan'] = $this->lowongan->findAll();
        $data['title']    = 'Manage Applicants';
        $data['menu']     = 'pelamar';

        return view('pelamar/index', $data);
    }

    public function detail($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/login');
        }

        helper('lamaran');

        $db = \Config\Database::connect();

        $pelamar = $db->table('pelamar')
            ->where('id_pelamar', $id)
            ->get()->getRowArray();

        if (!$pelamar) {
            return redirect()->to('/pelamar');
        }

        $lamaran = LamaranStatusService::filterManageRows(
            $db->table('lamaran l')
                ->select('l.*, low.nama_pekerjaan, low.deskripsi')
                ->join('lowongan low', 'low.id = l.id_lowongan')
                ->where('l.id_pelamar', $id)
                ->orderBy('l.id_lamaran', 'DESC')
                ->get()->getResultArray()
        );

        if ($lamaran === []) {
            return redirect()->to('/pelamar')->with(
                'error',
                'Pelamar ini belum lolos validasi administrasi. Kelola dari menu Ranking SAW.'
            );
        }

        $lamaranModel = new LamaranModel();

        return view('pelamar/detail', [
            'menu'         => 'pelamar',
            'title'        => 'Detail Pelamar',
            'pelamar'      => $pelamar,
            'lamaran'      => $lamaran,
            'lamaranModel' => $lamaranModel,
        ]);
    }

    public function edit($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/login');
        }

        $pelamar = $this->pelamar->find($id);

        if (!$pelamar) {
            return redirect()->to('/pelamar');
        }

        return view('pelamar/edit', [
            'menu'    => 'pelamar',
            'title'   => 'Edit Pelamar',
            'pelamar' => $pelamar,
        ]);
    }

    public function update($id)
    {
        $this->pelamar->update($id, [
            'nama_pelamar' => $this->request->getPost('nama'),
            'email'        => $this->request->getPost('email'),
            'pendidikan'   => $this->request->getPost('pendidikan'),
            'pengalaman'   => $this->request->getPost('pengalaman'),
        ]);

        return redirect()->to('/pelamar')->with('success', 'Data pelamar berhasil diperbarui');
    }

    public function hapus($id)
    {
        $db = \Config\Database::connect();

        // hapus penilaian terkait
        $lamaran = $db->table('lamaran')->where('id_pelamar', $id)->get()->getResultArray();
        foreach ($lamaran as $l) {
            $db->table('penilaian')->where('id_lamaran', $l['id_lamaran'])->delete();
            $db->table('tahapan_rekrutmen')->where('id_lamaran', $l['id_lamaran'])->delete();
        }
        $db->table('lamaran')->where('id_pelamar', $id)->delete();
        $this->pelamar->delete($id);

        return redirect()->to('/pelamar')->with('success', 'Data pelamar berhasil dihapus');
    }

    public function tambah()
    {
        $data['lowongan'] = $this->lowongan->findAll();
        return view('pelamar/tambah', $data);
    }

    public function simpan()
    {
        $this->pelamar->save([
            'nama_pelamar' => $this->request->getPost('nama'),
            'id_lowongan'  => $this->request->getPost('id_lowongan'),
            'pendidikan'   => $this->request->getPost('pendidikan'),
            'pengalaman'   => $this->request->getPost('pengalaman'),
        ]);

        return redirect()->to('/pelamar');
    }

    public function admin()
    {
        return view('pelamar/admin');
    }

    public function updateTahap()
    {
        $dokumen     = $this->request->getFile('dokumen');
        $namaDokumen = null;

        if ($dokumen && $dokumen->isValid()) {
            $namaDokumen = $dokumen->getRandomName();
            $dokumen->move('uploads/tahapan', $namaDokumen);
        }

        $this->tahapan->save([
            'id_lamaran'  => $this->request->getPost('id_lamaran'),
            'nama_tahap'  => $this->request->getPost('nama_tahap'),
            'status'      => $this->request->getPost('status'),
            'catatan'     => $this->request->getPost('catatan'),
            'dokumen'     => $namaDokumen,
        ]);

        $db = \Config\Database::connect();
        $db->table('lamaran')
            ->where('id_lamaran', $this->request->getPost('id_lamaran'))
            ->update(['status_lamaran' => $this->request->getPost('status')]);

        return redirect()->back()->with('success', 'Tahapan berhasil diperbarui');
    }
}
