<?php

namespace App\Controllers;

use App\Models\SubKriteriaModel;

class SubKriteria extends BaseController
 {
    protected $subModel;

    public function __construct()
 {
        $this->subModel = new SubKriteriaModel();
    }

    public function index( $id_kriteria )
 {
        $data = $this->subModel
        ->where( 'id_kriteria', $id_kriteria )
        ->findAll();

        return view( 'subkriteria/index', [
            'sub' => $data,
            'id_kriteria' => $id_kriteria
        ] );
    }

    public function tambah( $id_kriteria )
 {
        return view( 'subkriteria/tambah', [
            'id_kriteria' => $id_kriteria
        ] );
    }

    public function simpan()
 {
        $this->subModel->save( [
            'nama_sub' => $this->request->getPost( 'nama_sub' ),
            'nilai' => $this->request->getPost( 'nilai' ),
            'id_kriteria' => $this->request->getPost( 'id_kriteria' )
        ] );

        return redirect()->to(
            '/subkriteria/' .
            $this->request->getPost( 'id_kriteria' )
        );
    }

    public function hapus( $id )
 {
        $sub = $this->subModel->find( $id );

        $this->subModel->delete( $id );

        return redirect()->to(
            '/subkriteria/' .
            $sub[ 'id_kriteria' ]
        );
    }
}