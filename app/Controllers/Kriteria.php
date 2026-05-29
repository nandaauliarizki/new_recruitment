<?php

namespace App\Controllers;

use App\Models\KriteriaModel;

class Kriteria extends BaseController
 {
    protected $kriteriaModel;

    public function __construct()
 {
        $this->kriteriaModel = new KriteriaModel();
    }

    public function index( $id_lowongan )
 {
        $kriteria = $this->kriteriaModel
        ->where( 'id_lowongan', $id_lowongan )
        ->findAll();

        return view( 'kriteria/index', [
            'kriteria' => $kriteria,
            'id_lowongan' => $id_lowongan
        ] );
    }

    public function tambah( $id_lowongan )
 {
        return view( 'kriteria/tambah', [
            'id_lowongan' => $id_lowongan
        ] );
    }

    public function simpan()
 {
        $this->kriteriaModel->save( [
            'nama_kriteria' => $this->request->getPost( 'nama_kriteria' ),
            'bobot' => $this->request->getPost( 'bobot' ),
            'atribut' => $this->request->getPost( 'atribut' ),
            'id_lowongan' => $this->request->getPost( 'id_lowongan' )
        ] );

        return redirect()->to(
            '/kriteria/' . $this->request->getPost( 'id_lowongan' )
        );
    }

    public function hapus( $id )
 {
        $kriteria = $this->kriteriaModel->find( $id );

        $this->kriteriaModel->delete( $id );

        return redirect()->to(
            '/kriteria/' . $kriteria[ 'id_lowongan' ]
        );
    }
}