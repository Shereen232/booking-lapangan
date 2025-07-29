<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===========================
// AUTH ROUTES
// ===========================
$routes->get('/', 'Home::index');
$routes->get('login', 'AuthController::loginForm', ['filter' => 'alreadyLoggedIn']);
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');
$routes->get('register', 'AuthController::register', ['filter' => 'alreadyLoggedIn']);
$routes->post('register/process', 'AuthController::processRegister');


// ===========================
// ADMIN ROUTES
// ===========================
$routes->group('admin', ['namespace' => 'App\Controllers\Admin','filter' => 'auth'], function($routes) {

    // Dashboard
    $routes->get('/', 'AdminController::dashboard');

    // Kelola Lapangan
    $routes->group('lapangan', function($routes) {
        $routes->get('/', 'LapanganController::index');
        $routes->get('create', 'LapanganController::create');
        $routes->post('store', 'LapanganController::store');
        $routes->get('edit/(:num)', 'LapanganController::edit/$1');
        $routes->post('update/(:num)', 'LapanganController::update/$1');
        $routes->put('update/(:num)', 'LapanganController::update/$1'); // Opsional, tergantung form method
        $routes->post('delete/(:num)', 'LapanganController::delete/$1');
    });

    // Kelola Pemesanan
    $routes->group('pemesanan', function($routes) {
        $routes->get('/', 'PemesananController::index');
        $routes->get('exportPdf', 'PemesananController::exportPdf');
        $routes->get('edit/(:num)', 'PemesananController::edit/$1');
        $routes->post('update/(:num)', 'PemesananController::update/$1');
        $routes->get('delete/(:num)', 'PemesananController::delete/$1');
    });

    // Pengaturan
    $routes->group('pengaturan', function($routes) {
        $routes->get('/', 'PengaturanController::index');
        $routes->post('update', 'PengaturanController::update');
    });

    // Kelola Pelanggan
    $routes->group('pelanggan', function($routes) {
        $routes->get('/', 'PelangganController::index');
        $routes->get('edit/(:num)', 'PelangganController::edit/$1');
        $routes->post('update/(:num)', 'PelangganController::update/$1');
        $routes->post('delete/(:num)', 'PelangganController::delete/$1');
    });

    // Pembayaran
    $routes->group('pembayaran', function ($routes) {
        $routes->get('/', 'PembayaranController::index');
        $routes->get('exportPdf', 'PembayaranController::exportPdf');
    });

});


// ===========================
// PELANGGAN ROUTES
// ===========================
$routes->group('pelanggan', ['namespace' => 'App\Controllers\Pelanggan', 'filter' => 'auth'], function($routes) {

    // Dashboard
    $routes->get('/', 'DashboardController::index');

    // Pemesanan
    $routes->group('pemesanan', function($routes) {
        $routes->get('/', 'PemesananController::index');
        $routes->get('detail/(:num)', 'PemesananController::detail/$1');
        $routes->post('simpan', 'PemesananController::simpan');
        $routes->post('batalkan/(:num)', 'PemesananController::delete/$1');
    });

    // Pembayaran
    $routes->group('pembayaran', function ($routes) {
        $routes->get('/', 'PembayaranController::index');
    });

    // Jadwal Saya
    $routes->group('jadwal-saya', function ($routes) {
        $routes->get('/', 'JadwalController::index');
    });

    // Akun
    $routes->group('akun', function($routes) {
        $routes->get('/', 'AkunController::index');
        $routes->post('update', 'AkunController::update');
    });

});


// ===========================
// API ROUTES
// ===========================
$routes->group('api', ['filter' => 'auth'], function ($routes) {
    $routes->post('pemesanan/update-status', 'Pelanggan\PemesananController::updateStatus');
    $routes->get('cekJamKosong/(:segment)/(:segment)', 'Api\BookingApi::cekJamKosong/$1/$2');
});
