<?php

namespace App\Controllers;

use App\Libraries\DocumentUploadService;
use App\Libraries\LamaranStatusService;
use App\Models\LamaranModel;
use Config\Services;

class Lamaran extends BaseController
{
    protected LamaranModel $lamaranModel;

    protected DocumentUploadService $uploadService;

    public function __construct()
    {
        $this->lamaranModel   = new LamaranModel();
        $this->uploadService  = new DocumentUploadService();
        helper(['lamaran', 'form', 'database']);
    }

    public function form($id)
    {
        if (session()->get('role') !== 'pelamar') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $lowongan = $db->table('lowongan')->where('id', $id)->get()->getRowArray();

        if (! $lowongan) {
            return redirect()->to('/pelamar/dashboard');
        }

        $kriteria = $db->table('kriteria')
            ->where('id_lowongan', $id)
            ->get()->getResultArray();

        $sub = [];
        foreach ($kriteria as $k) {
            $sub[$k['id_kriteria']] = $db->table('sub_kriteria')
                ->where('id_kriteria', $k['id_kriteria'])
                ->get()->getResultArray();
        }

        $pelamar = $db->table('pelamar')
            ->where('id_user', session()->get('id_user'))
            ->get()->getRowArray();

        return view('lamaran/form', [
            'lowongan'    => $lowongan,
            'id_lowongan' => $id,
            'kriteria'    => $kriteria,
            'sub'         => $sub,
            'pelamar'     => $pelamar,
            'validation'  => Services::validation(),
        ]);
    }

   
    public function simpan()
    {
        if (session()->get('role') !== 'pelamar') {
            return redirect()->to('/login');
        }

        $validation = Services::validation();
        $db         = \Config\Database::connect();

        $pelamar = $db->table('pelamar')
            ->where('id_user', session()->get('id_user'))
            ->get()->getRowArray();

        if (! $pelamar) {
            return redirect()->to('/login');
        }

        $idLowongan = (int) $this->request->getPost('id_lowongan');

        $rules = array_merge(
            config('Validation')->lamaran_profil,
            config('Validation')->lamaran_dokumen
        );

        $validation->setRules($rules);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $pendidikan = trim((string) $this->request->getPost('pendidikan'));

        // UPDATE DATA PELAMAR
        $db->table('pelamar')
        ->where('id_pelamar', $pelamar['id_pelamar'])
        ->update([

            'nama_lengkap'  => trim((string) $this->request->getPost('nama_lengkap')),
            'no_hp'         => trim((string) $this->request->getPost('no_hp')),
            'tempat_lahir'  => trim((string) $this->request->getPost('tempat_lahir')),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => trim((string) $this->request->getPost('jenis_kelamin')),
            'pendidikan'    => $pendidikan,

        ]);

        // CEK SUDAH MELAMAR ATAU BELUM
        $existing = $db->table('lamaran')
            ->where('id_pelamar', $pelamar['id_pelamar'])
            ->where('id_lowongan', $idLowongan)
            ->get()->getRowArray();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah pernah melamar posisi ini');
        }

        // VALIDASI KRITERIA
        $kriteria = $db->table('kriteria')
            ->where('id_lowongan', $idLowongan)
            ->get()->getResultArray();

        foreach ($kriteria as $k) {
            $key = 'kriteria_' . $k['id_kriteria'];

            if (! $this->request->getPost($key)) {
                return redirect()->back()->withInput()->with(
                    'error',
                    'Semua kriteria wajib dipilih sebelum mengirim lamaran.'
                );
            }
        }

        // UPLOAD DOKUMEN
        try {

            $cvMeta = $this->uploadService->uploadPdf(
                $this->request->getFile('cv'),
                'cv'
            );

            $suratMeta = $this->uploadService->uploadPdf(
                $this->request->getFile('surat_lamaran'),
                'surat_lamaran'
            );

            $ijazahMeta = $this->uploadService->uploadPdf(
                $this->request->getFile('ijazah'),
                'ijazah'
            );

            $pendukungMeta = null;

            $pendukungFile = $this->request->getFile('dokumen_pendukung');

            if ($pendukungFile && $pendukungFile->isValid() && ! $pendukungFile->hasMoved()) {

                $pendukungMeta = $this->uploadService->uploadPdf(
                    $pendukungFile,
                    'dokumen_pendukung'
                );
            }

        } catch (\Throwable $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $status = LamaranStatusService::PENDING;

        // DATA LAMARAN
        $lamaranData = array_merge([
            'id_pelamar'  => $pelamar['id_pelamar'],
            'id_lowongan' => $idLowongan,
            'tanggal'     => date('Y-m-d'),
        ], LamaranStatusService::statusPayload($db, $status), [

            'cv_filename'               => $cvMeta['filename'],
            'cv_path'                   => $cvMeta['path'],
            'cv_uploaded_at'            => $cvMeta['uploaded_at'],

            'surat_lamaran_filename'    => $suratMeta['filename'],
            'surat_lamaran_path'        => $suratMeta['path'],
            'surat_lamaran_uploaded_at' => $suratMeta['uploaded_at'],

            'ijazah_filename'           => $ijazahMeta['filename'],
            'ijazah_path'               => $ijazahMeta['path'],
            'ijazah_uploaded_at'        => $ijazahMeta['uploaded_at'],

        ]);

        // DOKUMEN PENDUKUNG OPSIONAL
        if ($pendukungMeta) {

            $lamaranData['dokumen_pendukung_filename']    = $pendukungMeta['filename'];
            $lamaranData['dokumen_pendukung_path']        = $pendukungMeta['path'];
            $lamaranData['dokumen_pendukung_uploaded_at'] = $pendukungMeta['uploaded_at'];
        }

        // INSERT LAMARAN
        $db->table('lamaran')
            ->insert($lamaranData);

        $idLamaran = (int) $db->insertID();

        // INSERT PENILAIAN
        foreach ($this->request->getPost() as $key => $value) {

            if (strpos($key, 'kriteria_') !== 0) {
                continue;
            }

            $idKriteria = str_replace('kriteria_', '', $key);

            $sub = $db->table('sub_kriteria')
                ->where('id_sub', $value)
                ->get()
                ->getRowArray();

            $nilai = $sub ? $sub['nilai'] : 0;

            $db->table('penilaian')->insert([
                'id_lamaran'  => $idLamaran,
                'id_kriteria' => $idKriteria,
                'nilai'       => $nilai,
            ]);
        }

        // RIWAYAT TAHAPAN
        $db->table('tahapan_rekrutmen')->insert([
            'id_lamaran' => $idLamaran,
            'tahapan'    => $status,
            'catatan'    => 'Lamaran berhasil dikirim',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/pelamar/dashboard')
            ->with('success', 'Lamaran berhasil dikirim!');
    }


    public function download(int $idLamaran, string $type)
    {
        $db      = \Config\Database::connect();
        $lamaran = $db->table('lamaran')->where('id_lamaran', $idLamaran)->get()->getRowArray();

        if (! $lamaran) {
            return redirect()->back()->with('error', 'Lamaran tidak ditemukan.');
        }

        if (! $this->canAccessLamaranDocuments($lamaran)) {
            return redirect()->to('/login');
        }

        $documents = $this->lamaranModel->getDocumentMap($lamaran);

        if (! isset($documents[$type])) {
            return redirect()->back()->with('error', 'Dokumen tidak tersedia.');
        }

        $relative = $documents[$type]['path'];
        $fullPath = FCPATH . ltrim(str_replace(['../', '..\\'], '', $relative), '/');

        if (! is_file($fullPath)) {
            return redirect()->back()->with('error', 'File dokumen tidak ditemukan di server.');
        }

        return $this->response->download($fullPath, null);
    }

    public function validasiAdministrasi(int $idLamaran)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db      = \Config\Database::connect();
        $lamaran = $db->table('lamaran')->where('id_lamaran', $idLamaran)->get()->getRowArray();

        if (! $lamaran) {
            return redirect()->back()->with('error', 'Lamaran tidak ditemukan.');
        }

        $documents = $this->lamaranModel->getDocumentMap($lamaran);
        $required  = ['cv', 'surat_lamaran', 'ijazah'];

        foreach ($required as $doc) {
            if (! isset($documents[$doc])) {
                return redirect()->back()->with(
                    'error',
                    'Dokumen wajib belum lengkap. Validasi administrasi tidak dapat dilakukan.'
                );
            }
        }

        $status = LamaranStatusService::LULUS_ADMINISTRASI;
        LamaranStatusService::sync($db, $idLamaran, $status);

        $db->table('lamaran')
            ->where('id_lamaran', $idLamaran)
            ->update([
                'admin_validated_at' => date('Y-m-d H:i:s'),
                'admin_validated_by' => session()->get('id_user'),
            ]);

        $db->table('tahapan_rekrutmen')->insert([
            'id_lamaran' => $idLamaran,
            'tahapan'    => $status,
            'catatan'    => 'Dokumen administrasi telah divalidasi dan disetujui oleh admin.',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with(
            'success',
            'Pelamar lolos administrasi dan sekarang tampil di menu Manage Applicants.'
        );
    }

    public function status()
    {
        if (session()->get('role') !== 'pelamar') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $pelamar = $db->table('pelamar')
            ->where('id_user', session()->get('id_user'))
            ->get()->getRowArray();

        $lamaran = [];
        if ($pelamar) {
            $lamaran = $db->table('lamaran l')
                ->select('l.*, low.nama_pekerjaan, low.deskripsi')
                ->join('lowongan low', 'low.id = l.id_lowongan')
                ->where('l.id_pelamar', $pelamar['id_pelamar'])
                ->orderBy('l.id_lamaran', 'DESC')
                ->get()->getResultArray();
        }

        return view('lamaran/status', ['lamaran' => $lamaran]);
    }

    public function updateStatus()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db         = \Config\Database::connect();
        $idLamaran  = (int) $this->request->getPost('id_lamaran');
        $status     = (string) $this->request->getPost('status');

        $db->table('lamaran')
            ->where('id_lamaran', $id)
            ->update([
                'status' => $status,
                'status_lamaran' => $status,
            ]);

        //LamaranStatusService::sync($db, $idLamaran, $status);

        $db->table('tahapan_rekrutmen')->insert([
            'id_lamaran' => $idLamaran,
            'tahapan'    => LamaranStatusService::normalize($status),
            'catatan'    => 'Status diperbarui dari halaman ranking.',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    public function seleksi($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $lamaran = $db->table('lamaran l')
            ->select('l.*, p.nama_pelamar, p.email, p.pendidikan, low.nama_pekerjaan')
            ->join('pelamar p', 'p.id_pelamar = l.id_pelamar')
            ->join('lowongan low', 'low.id = l.id_lowongan')
            ->where('l.id_lamaran', $id)
            ->get()->getRowArray();

        if (! $lamaran) {
            return redirect()->to('/pelamar')->with('error', 'Data lamaran tidak ditemukan.');
        }

        $documents = $this->lamaranModel->getDocumentMap($lamaran);
        $status    = lamaran_status_from_row($lamaran);

        return view('lamaran/seleksi', [
            'menu'      => 'pelamar',
            'title'     => 'Seleksi Kandidat',
            'lamaran'   => $lamaran,
            'documents' => $documents,
            'status'    => $status,
        ]);
    }

    public function updateSeleksi()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db         = \Config\Database::connect();
        $idLamaran  = (int) $this->request->getPost('id_lamaran');
        $status     = (string) $this->request->getPost('status');
        $catatan    = (string) $this->request->getPost('catatan');

        LamaranStatusService::sync($db, $idLamaran, $status);

        $db->table('tahapan_rekrutmen')->insert([
            'id_lamaran' => $idLamaran,
            'tahapan'    => LamaranStatusService::normalize($status),
            'catatan'    => $catatan,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/lamaran/proses/' . $idLamaran)
            ->with('success', 'Status seleksi berhasil diperbarui');
    }

    public function hasil($id)
    {
        return redirect()->to('/perhitungan/hasil/' . $id);
    }

    public function proses($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $lamaran = $db->table('lamaran l')
            ->select('l.*, p.nama_pelamar, p.email, p.pendidikan, low.nama_pekerjaan')
            ->join('pelamar p', 'p.id_pelamar = l.id_pelamar')
            ->join('lowongan low', 'low.id = l.id_lowongan')
            ->where('l.id_lamaran', $id)
            ->get()->getRowArray();

        if (! $lamaran) {
            return redirect()->to('/pelamar')->with('error', 'Data lamaran tidak ditemukan.');
        }

        $riwayat = $db->table('tahapan_rekrutmen')
            ->where('id_lamaran', $id)
            ->orderBy('id_tahapan', 'DESC')
            ->get()->getResultArray();

        $documents = $this->lamaranModel->getDocumentMap($lamaran);
        $status    = lamaran_status_from_row($lamaran);

        return view('lamaran/proses', [
            'menu'       => 'pelamar',
            'lamaran'    => $lamaran,
            'riwayat'    => $riwayat,
            'documents'  => $documents,
            'status'     => $status,
            'validation' => Services::validation(),
        ]);
    }

    public function updateTahap($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $validation = Services::validation();
        $db         = \Config\Database::connect();

        $rules = [
            'status'  => 'required',
            'catatan' => 'permit_empty|max_length[1000]',
        ];

        $hasFile = $this->request->getFile('dokumen')
            && $this->request->getFile('dokumen')->isValid()
            && ! $this->request->getFile('dokumen')->hasMoved();

        if ($hasFile) {
            $validation->setRules(config('Validation')->dokumen_seleksi);
            if (! $validation->withRequest($this->request)->run()) {
                return redirect()->back()->with('errors', $validation->getErrors());
            }
        } elseif (! $validation->setRules($rules)->run($this->request->getPost())) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $status  = (string) $this->request->getPost('status');
        $catatan = (string) $this->request->getPost('catatan');

        LamaranStatusService::sync($db, (int) $id, $status);

        $tahapanData = [
            'id_lamaran' => $id,
            'tahapan'    => LamaranStatusService::normalize($status),
            'catatan'    => $catatan,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($hasFile) {
            try {
                $meta = $this->uploadService->uploadPdf(
                    $this->request->getFile('dokumen'),
                    'dokumen_seleksi'
                );
                $tahapanData['dokumen']             = basename($meta['path']);
                $tahapanData['dokumen_filename']    = $meta['filename'];
                $tahapanData['dokumen_path']        = $meta['path'];
                $tahapanData['dokumen_uploaded_at'] = $meta['uploaded_at'];
                $tahapanData['jenis_dokumen']       = $this->request->getPost('jenis_dokumen');
            } catch (\Throwable $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }

        $db->table('tahapan_rekrutmen')->insert(filter_table_columns('tahapan_rekrutmen', $tahapanData));

        return redirect()->to('/lamaran/proses/' . $id)
            ->with('success', 'Tahapan berhasil diperbarui');
    }

    public function downloadDokumenSeleksi(int $idTahapan)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db     = \Config\Database::connect();
        $tahapan = $db->table('tahapan_rekrutmen')->where('id_tahapan', $idTahapan)->get()->getRowArray();

        if (! $tahapan) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        $path = $tahapan['dokumen_path'] ?? null;

        if (empty($path) && ! empty($tahapan['dokumen'])) {
            $path = 'uploads/dokumen_seleksi/' . $tahapan['dokumen'];
            if (! is_file(FCPATH . $path)) {
                $path = 'uploads/tahapan/' . $tahapan['dokumen'];
            }
        }

        if (empty($path)) {
            return redirect()->back()->with('error', 'Path dokumen tidak tersedia.');
        }

        $fullPath = FCPATH . ltrim(str_replace(['../', '..\\'], '', $path), '/');

        if (! is_file($fullPath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return $this->response->download($fullPath, null);
    }

    private function canAccessLamaranDocuments(array $lamaran): bool
    {
        if (session()->get('role') === 'admin') {
            return true;
        }

        if (session()->get('role') !== 'pelamar') {
            return false;
        }

        $db = \Config\Database::connect();
        $pelamar = $db->table('pelamar')
            ->where('id_user', session()->get('id_user'))
            ->get()->getRowArray();

        return $pelamar && (int) $pelamar['id_pelamar'] === (int) $lamaran['id_pelamar'];
    }
}
