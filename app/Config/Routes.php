<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =======================
// AUTH
// =======================
$routes->get('login', 'Auth::login');
$routes->post('auth/attempt', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

// =======================
// PUBLIC (SCAN IZIN)
// =======================
$routes->get('/', 'Izin::index');
$routes->post('scan/store', 'Izin::store');
$routes->post('izin/process', 'Izin::process');
$routes->get('izin/riwayat', 'Izin::riwayat');

// =======================
// ADMIN AREA
// =======================
// Namespace diarahkan ke App\Controllers\Admin agar lebih rapi
$routes->group('admin', ['filter' => 'authadmin'], function($routes) {
    
    // Dashboard Admin (Opsional jika ada)
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // --- MANAJEMEN SISWA ---
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/profile', 'Admin\Settings::updateProfile');
    $routes->post('settings/password', 'Admin\Settings::updatePassword');

        
    // 1. Letakkan rute statis di atas rute dengan parameter (:any)
    $routes->get('siswa/downloadTemplate', 'Admin\Siswa::downloadTemplate'); // PERBAIKAN: Hapus 'Admin\'
    $routes->post('siswa/import', 'Admin\Siswa::import'); 
    
    // 2. Rute utama dan tambah
    $routes->get('siswa', 'Admin\Siswa::index');
    $routes->get('siswa/create', 'Admin\Siswa::create');
    $routes->post('siswa/saveSiswa', 'Admin\Siswa::saveSiswa');
    
    // 3. Rute dengan parameter (Selalu di bawah rute statis)
    $routes->get('siswa/show/(:any)', 'Admin\Siswa::show/$1');
    $routes->get('siswa/edit/(:any)', 'Admin\Siswa::edit/$1');
    $routes->post('siswa/update/(:any)', 'Admin\Siswa::update/$1');
    $routes->get('siswa/delete/(:any)', 'Admin\Siswa::delete/$1');
    $routes->get('siswa/cetak_qr', 'Admin\Siswa::cetak_qr');
    $routes->get('admin/siswa/cetak-qr-massal', 'Admin\Siswa::cetakSemuaQR');


    // USERS / GURU (Menggunakan UserController)
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserController::delete/$1');
    $routes->get('users/show/(:num)', 'Admin\UserController::show/$1');

    // WALI KELAS (tb_walikelas)
    $routes->get('walikelas', 'Admin\WaliKelas::index');
    $routes->post('walikelas/store', 'Admin\WaliKelas::store');
    $routes->post('walikelas/update/(:num)', 'Admin\WaliKelas::update/$1');
    $routes->get('walikelas/delete/(:num)', 'Admin\WaliKelas::delete/$1');

    // IZIN & LAPORAN
    $routes->get('riwayat', 'Admin\Izin::index');
    $routes->get('laporan', 'Admin\LaporanIzin::index');
    $routes->get('laporan/export', 'Admin\LaporanIzin::exportExcel');
});

$routes->group('guru', ['filter' => 'authguru'], function($routes) {
    $routes->get('dashboard', 'Guru\Dashboard::index');

    // --- MANAJEMEN SISWA ---
    $routes->get('settings', 'Guru\Settings::index');
    $routes->post('settings/profile', 'Guru\Settings::updateProfile');
    $routes->post('settings/password', 'Guru\Settings::updatePassword');

        
    // 1. Letakkan rute statis di atas rute dengan parameter (:any)
    $routes->get('siswa/downloadTemplate', 'Guru\Siswa::downloadTemplate'); 
    $routes->post('siswa/import', 'Guru\Siswa::import'); 
    
    // 2. Rute utama dan tambah
    $routes->get('siswa', 'Guru\Siswa::index');
    $routes->get('siswa/create', 'Guru\Siswa::create');
    $routes->post('siswa/saveSiswa', 'Guru\Siswa::saveSiswa');
    
    // 3. Rute dengan parameter (Selalu di bawah rute statis)
    $routes->get('siswa/show/(:any)', 'Guru\Siswa::show/$1');
    $routes->get('siswa/edit/(:any)', 'Guru\Siswa::edit/$1');
    $routes->post('siswa/update/(:any)', 'Guru\Siswa::update/$1');
    $routes->get('siswa/delete/(:any)', 'Guru\Siswa::delete/$1');

    // IZIN & LAPORAN
    $routes->get('riwayat', 'Guru\Izin::index');
    $routes->get('laporan', 'Guru\LaporanIzin::index');
    $routes->get('laporan/export', 'Guru\LaporanIzin::exportExcel');
});



$routes->get('login-siswa', 'LoginSiswa::index');
$routes->post('loginsiswa/cekLogin', 'LoginSiswa::cekLogin');

// --- Rute Dashboard Siswa (Setelah Login) ---
$routes->group('siswa', ['filter' => 'authSiswa'], function($routes) {
    $routes->get('dashboard', 'SiswaDashboard::index');
    $routes->get('logout', 'LoginSiswa::logout');
    $routes->get('dashboard', 'SiswaDashboard::index');
    $routes->get('izin/excel', 'SiswaDashboard::exportExcel');
    $routes->get('izin/pdf', 'SiswaDashboard::exportPdf');

});

// =======================
// WALI AREA
// =======================
$routes->group('wali', ['namespace' => 'App\Controllers\Wali', 'filter' => 'auth:wali'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('siswa', 'Siswa::index');
    $routes->get('izin', 'Izin::index');
});
