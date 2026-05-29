<?php

namespace App\Controllers;
use App\Models\PenilaianModel;
use App\Models\PelamarModel;
use App\Models\KriteriaModel;

class Penilaian extends BaseController
{
    public function index()
    {
        $penilaianModel = new PenilaianModel();
        $pelamar = new PelamarModel();
        $kriteria = new KriteriaModel();

        $data['pelamar'] = $pelamar->findAll();
        $data['kriteria'] = $kriteria->findAll();
        $data['penilaian'] = $penilaianModel->findAll(); // 🔥 ini penting


        return view('penilaian/index', $data);
    }

    public function simpan()
    {
        $model = new PenilaianModel();

        // 🔥 HAPUS SEMUA DATA LAMA
        $model->truncate();

        foreach ($this->request->getPost('nilai') as $id_pelamar => $nilai_kriteria) {
            foreach ($nilai_kriteria as $id_kriteria => $nilai) {
                $model->insert([
                    'id_pelamar' => $id_pelamar,
                    'id_kriteria' => $id_kriteria,
                    'nilai' => $nilai
                ]);
            }
        }

        return redirect()->to('/penilaian');
    }
}