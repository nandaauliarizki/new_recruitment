<?php

namespace App\Controllers;

use App\Models\LowonganModel;
use App\Models\LamaranModel;

class Dashboard extends BaseController
{
    protected $lowonganModel;
    protected $lamaranModel;

    public function __construct()
    {
        $this->lowonganModel = new LowonganModel();
        $this->lamaranModel  = new LamaranModel();
    }

    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // Auto-expire jobs whose end_date has passed
        $db->query("UPDATE lowongan SET status='expired' WHERE end_date IS NOT NULL AND end_date < CURDATE() AND status = 'active'");

        $total_lowongan = $this->lowonganModel->countAll();
        $total_pelamar  = $this->lamaranModel->countAll();

        $total_hired = $this->lamaranModel
            ->where('status_lamaran', 'diterima')
            ->countAllResults();

        $open_jobs      = $this->lowonganModel->where('status', 'active')->countAllResults();
        $expired_jobs   = $this->lowonganModel->where('status', 'expired')->countAllResults();

        $statusSelect = "
        CASE 
            WHEN l.status_lamaran IS NULL 
                OR l.status_lamaran = ''
            THEN 'belum divalidasi'
            ELSE 'sudah divalidasi'
        END as status
        ";

        $recent = $db->table('lamaran l')
            ->select("l.id_lamaran, l.tanggal, {$statusSelect}, p.nama_pelamar, low.nama_pekerjaan", false)
            ->join('pelamar p',    'p.id_pelamar = l.id_pelamar')
            ->join('lowongan low', 'low.id = l.id_lowongan')
            ->orderBy('l.id_lamaran', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // Active/draft jobs with duration, days remaining, applicant count
        $job_postings = $db->table('lowongan l')
            ->select('l.id, l.nama_pekerjaan, l.start_date, l.end_date, l.status, COUNT(lm.id_lamaran) as total_applicants')
            ->join('lamaran lm', 'lm.id_lowongan = l.id', 'left')
            ->whereIn('l.status', ['active', 'draft'])
            ->groupBy('l.id')
            ->orderBy('l.end_date', 'ASC')
            ->get()->getResultArray();

        return view('dashboard/index', [
            'title'          => 'Dashboard Admin',
            'menu'           => 'dashboard',
            'total_lowongan' => $total_lowongan,
            'total_pelamar'  => $total_pelamar,
            'total_hired'    => $total_hired,
            'open_jobs'      => $open_jobs,
            'expired_jobs'   => $expired_jobs,
            'recent'         => $recent,
            'job_postings'   => $job_postings,
        ]);
    }
}
