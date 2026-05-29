<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Test extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        if ($db) {
            echo "Koneksi database berhasil! yeaaay";
        } else {
            echo "Koneksi gagal!";
        }
    }
}