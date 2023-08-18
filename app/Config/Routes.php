<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// preview image
$routes->get('full/(:segment)', 'Home::img_medium/$1');
$routes->get('thumb/(:segment)', 'Home::img_thumb/$1');
// preview pdf
$routes->get('pdf/(:segment)', 'Home::preview_submits/$1');

$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    // Login/out
    $routes->get('users', 'Auth::index');
    $routes->get('login', 'Auth::login', ['as' => 'login']);
    $routes->post('log-in', 'Auth::login');
    $routes->get('logout', 'Auth::logout');

    // // Registration
    // $routes->get('register', 'Auth::register', ['as' => 'register']);
    // $routes->post('register', 'Auth::attemptRegister');

    // Activation
    $routes->get('activate-account/$1/$2', 'Auth::activate/$1/$2', [
        'as' => 'activate-account',
    ]);

    // Forgot/Resets
    $routes->get('forgot-password', 'Auth::forgot_password');
    $routes->post('forgot_password', 'Auth::forgot_password');
    $routes->get('reset-password/:num', 'Auth::reset_password/$1', [
        'as' => 'reset-password',
    ]);
});
$routes->group('', ['filter' => 'role:admin'], function ($routes) {
    // PANGKALAN
    $routes->get('pangkalan', 'Pangkalan::index');
    $routes->get('pangkalan/ajax_request', 'Pangkalan::ajax_request');
    $routes->post('pangkalan/create', 'Pangkalan::create');
    // JABATAN
    $routes->get('jabatan', 'Jabatan::index');
    $routes->get('jabatan/ajax_request', 'Jabatan::ajax_request');
    $routes->post('jabatan/create', 'Jabatan::create');
    //PEGAWAI
    $routes->get('pegawai', 'Pegawai::index');
    $routes->get('pegawai/ajax_request', 'Pegawai::ajax_request');
    $routes->post('pegawai/create', 'Pegawai::create');
    //USERS
    $routes->get('users', 'Auth::index');
    $routes->get('auth/ajax_request', 'Auth::ajax_request');
    $routes->post('auth/create', 'Auth::create');
});

$routes->group('', function ($routes) {
    $routes->get('profile', 'Auth::profile'); // users profile account

    // HOME
    $routes->get('home', 'Home::index');
    $routes->get('home/ajax_request', 'Home::ajax_request');
    $routes->post('home/create', 'Home::create');
    // KUOTA LPG
    $routes->get('kuota-lpg', 'Kuota::index');
    $routes->get('kuota/ajax_request', 'Kuota::ajax_request');
    $routes->post('kuota/create', 'Kuota::create');
});
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
