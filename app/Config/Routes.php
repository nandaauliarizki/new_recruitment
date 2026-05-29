<?php

use CodeIgniter\Router\RouteCollection;

/**
* @var RouteCollection $routes
*/
$routes->get( '/', 'Home::index' );
$routes->get( '/test', 'Test::index' );
$routes->get( '/pelamar', 'Pelamar::index' );
$routes->get( '/pelamar/tambah', 'Pelamar::tambah' );
$routes->post( '/pelamar/simpan', 'Pelamar::simpan' );
$routes->get( '/pelamar/edit/(:num)', 'Pelamar::edit/$1' );
$routes->post( '/pelamar/update/(:num)', 'Pelamar::update/$1' );
$routes->get( '/pelamar/hapus/(:num)', 'Pelamar::hapus/$1' );
$routes->get( '/kriteria', 'Kriteria::index' );
$routes->get( '/kriteria/tambah', 'Kriteria::tambah' );
$routes->post( '/kriteria/simpan', 'Kriteria::simpan' );
$routes->get( '/penilaian', 'Penilaian::index' );
$routes->post( '/penilaian/simpan', 'Penilaian::simpan' );
$routes->get( '/subkriteria', 'SubKriteria::index' );
$routes->get( '/subkriteria/tambah', 'SubKriteria::tambah' );
$routes->post( '/subkriteria/simpan', 'SubKriteria::simpan' );
$routes->get( '/dashboard', 'Dashboard::index' );
$routes->get( '/lamar/(:num)', 'Lamaran::form/$1' );
$routes->post( '/lamaran/simpan', 'Lamaran::simpan' );
$routes->get( '/lamaran/hasil/(:num)', 'Lamaran::hasil/$1' );
$routes->get( '/admin/lowongan', 'Lowongan::index' );
$routes->get( '/lowongan/list', 'Lowongan::list' );
//$routes->get( '/perhitungan', 'Perhitungan::index' );
$routes->get( '/lowongan/list', 'Lowongan::list' );
$routes->get( '/lowongan/tambah', 'Lowongan::tambah' );
$routes->post( '/lowongan/simpan', 'Lowongan::simpan' );
$routes->get( '/lowongan/edit/(:num)', 'Lowongan::edit/$1' );
$routes->post( '/lowongan/update/(:num)', 'Lowongan::update/$1' );
$routes->get( '/lowongan/hapus/(:num)', 'Lowongan::hapus/$1' );
$routes->get( '/kriteria/(:num)', 'Kriteria::index/$1' );
$routes->get( '/kriteria/tambah/(:num)', 'Kriteria::tambah/$1' );
$routes->post( '/kriteria/simpan', 'Kriteria::simpan' );
$routes->get( '/kriteria/hapus/(:num)', 'Kriteria::hapus/$1' );
$routes->get( '/subkriteria/(:num)', 'SubKriteria::index/$1' );
$routes->get( '/subkriteria/tambah/(:num)', 'SubKriteria::tambah/$1' );
$routes->post( '/subkriteria/simpan', 'SubKriteria::simpan' );
$routes->get( '/subkriteria/hapus/(:num)', 'SubKriteria::hapus/$1' );
$routes->get( '/lowongan', 'Lowongan::pelamar' );
$routes->get( '/lamaran/(:num)', 'Lamaran::form/$1' );
$routes->post( '/lamaran/simpan', 'Lamaran::simpan' );
$routes->get( '/login', 'Auth::login' );
$routes->post( '/login/proses', 'Auth::prosesLogin' );
$routes->get( '/logout', 'Auth::logout' );
$routes->get( '/register', 'Auth::register' );
$routes->post( '/register/proses', 'Auth::prosesRegister' );
$routes->get( '/lamaran/status', 'Lamaran::status' );
$routes->post( '/lamaran/update-status', 'Lamaran::updateStatus' );
$routes->get( '/perhitungan', 'Perhitungan::listLowongan' );
$routes->get( '/perhitungan/hasil/(:num)', 'Perhitungan::index/$1' );
$routes->post( '/lamaran/update-status', 'Lamaran::updateStatus' );
$routes->get( '/pelamar/dashboard', 'Pelamar::dashboard' );
$routes->get( '/lamaran/seleksi/(:num)', 'Lamaran::seleksi/$1' );
$routes->post( '/lamaran/update-seleksi', 'Lamaran::updateSeleksi' );
//$routes->get('/admin/applicants','Pelamar::admin');
$routes->get('/admin/ranking', 'Ranking::index');
$routes->get('/lamaran/proses/(:num)','Lamaran::proses/$1');
$routes->post('/lamaran/updateTahap/(:num)','Lamaran::updateTahap/$1');
$routes->get('/perhitungan/luluskan/(:num)','Perhitungan::luluskan/$1');
$routes->post(
    '/pelamar/update-tahap',
    'Pelamar::updateTahap'
);

$routes->get(
    '/pelamar/detail/(:num)',
    'Pelamar::detail/$1'
);

$routes->post('/lowongan/simpan-basic', 'Lowongan::simpanBasic');

$routes->get('lamaran/download/(:num)/(:segment)', 'Lamaran::download/$1/$2');
$routes->post('lamaran/validasi-administrasi/(:num)', 'Lamaran::validasiAdministrasi/$1');
$routes->get('lamaran/dokumen-seleksi/(:num)', 'Lamaran::downloadDokumenSeleksi/$1');
$routes->get('/profile', 'Profile::index');
$routes->post('/profile/update', 'Profile::update');
$routes->post('/profile/password', 'Profile::changePassword');
$routes->get('pelamar/profile', 'PelamarProfile::index');
$routes->post('pelamar/profile/update', 'PelamarProfile::update');
$routes->post('pelamar/profile/password', 'PelamarProfile::changePassword');
$routes->get('pelamar/profile', 'Profile::index');
$routes->post('pelamar/profile/update', 'Profile::update');
$routes->post('pelamar/profile/change-password', 'Profile::changePassword');