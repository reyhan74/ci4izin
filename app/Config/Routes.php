<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =======================
// AUTH
// =======================
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

// =======================
// PUBLIC (SCAN IZIN)
// =======================
$routes->get('/', 'Izin::index');
// $routes->get('scan', 'Izin::index');
$routes->post('scan/store', 'Izin::store');
// Pastikan baris ini ada agar form POST bisa diterima
$routes->post('izin/process', 'Izin::process');
$routes->get('izin/riwayat', 'Izin::riwayat');

// =======================
// ADMIN AREA
// =======================
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {

    // DASHBOARD
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // =======================
    // SISWA
    // =======================
    $routes->get('siswa', 'Admin\Siswa::index');
    $routes->get('siswa/create', 'Admin\Siswa::create');
    $routes->post('siswa/store', 'Admin\Siswa::store');
    $routes->get('siswa/edit/(:num)', 'Admin\Siswa::edit/$1');
    $routes->post('siswa/update/(:num)', 'Admin\Siswa::update/$1');
    $routes->get('siswa/delete/(:num)', 'Admin\Siswa::delete/$1');
    $routes->get('siswa/show/(:num)', 'Admin\Siswa::show/$1');
    $routes->get('siswa/download-template', 'Admin\Siswa::downloadTemplate');
    $routes->post('siswa/import', 'Admin\Siswa::import');
    $routes->get('siswa/cetak/(:num)', 'Admin\Siswa::cetak/$1');

    // =======================
    // USERS / GURU
    // =======================
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserController::delete/$1');
    $routes->get('users/show/(:num)', 'Admin\UserController::show/$1');

    // =======================
    // WALI KELAS
    // =======================
    $routes->get('walikelas', 'Admin\WaliKelas::index');
    $routes->post('walikelas/store', 'Admin\WaliKelas::store');
    $routes->post('walikelas/update/(:num)', 'Admin\WaliKelas::update/$1');
    $routes->get('walikelas/delete/(:num)', 'Admin\WaliKelas::delete/$1');

    // =======================
    // IZIN & LAPORAN
    // =======================
    $routes->get('riwayat', 'Admin\Izin::index');
    $routes->get('laporan-izin', 'Admin\LaporanIzin::index');
    $routes->get('laporan-izin/export', 'Admin\LaporanIzin::exportExcel');
});


$routes->group('wali', ['filter' => 'auth:wali'], function ($routes) {

    $routes->get('dashboard', 'Wali\Dashboard::index');
    $routes->get('siswa', 'Wali\Siswa::index');
    $routes->get('izin', 'Wali\Izin::index');
});