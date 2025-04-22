<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/admin', 'AdminController::dashboard');

// Grouping route admin (biar rapi)
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('lapangan', 'LapanganController::index');
    $routes->get('lapangan/create', 'LapanganController::create');
    $routes->post('lapangan/store', 'LapanganController::store');
    $routes->get('lapangan/edit/(:num)', 'LapanganController::edit/$1');
    $routes->post('lapangan/update/(:num)', 'LapanganController::update/$1');
    $routes->put('lapangan/update/(:num)', 'LapanganController::update/$1');
    $routes->get('lapangan/delete/(:num)', 'LapanganController::delete/$1');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('pengaturan', 'PengaturanController::index');
    $routes->post('pengaturan/update', 'PengaturanController::update');
});

// Routing untuk Kelola Pemesanan - Admin
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('pemesanan', 'PemesananController::index');
    $routes->get('pemesanan/edit/(:num)', 'PemesananController::edit/$1');
    $routes->post('pemesanan/update/(:num)', 'PemesananController::update/$1');
    $routes->get('pemesanan/delete/(:num)', 'PemesananController::delete/$1');
});

// Route untuk pelanggan - pemesanan
$routes->group('pelanggan', function ($routes) {
    $routes->get('pemesanan', 'Pelanggan\PemesananController::index');
    $routes->get('pemesanan/detail/(:num)', 'Pelanggan\PemesananController::detail/$1');
    $routes->post('pemesanan/simpan', 'Pelanggan\PemesananController::simpan');
});

$routes->group('api', function ($routes) {
    $routes->post('pemesanan/update-status', 'Pelanggan\PemesananController::updateStatus');
});

$routes->group('pelanggan', ['namespace' => 'App\Controllers\Pelanggan'], function($routes) {
    $routes->get('akun', 'AkunController::index');
    $routes->post('akun/update', 'AkunController::update');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('pelanggan', 'PelangganController::index');
    $routes->get('pelanggan/edit/(:num)', 'PelangganController::edit/$1');
    $routes->post('pelanggan/update/(:num)', 'PelangganController::update/$1');
    $routes->get('pelanggan/delete/(:num)', 'PelangganController::delete/$1');
});

$routes->get('login', 'AuthController::loginForm');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::register');
$routes->post('/register/process', 'AuthController::processRegister');



