<?php

namespace App\Controllers;

class Ranking extends BaseController
{
    public function index()
    {
        return redirect()->to('/perhitungan');
    }
}
