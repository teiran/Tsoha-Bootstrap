<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

$routes->get('/', function() {
    AsiaController::index();
});
// Pelien listaussivu
$routes->get('/asia', function() {
    AsiaController::index();
});

// Pelin esittelysivu
/* $routes->get('/asia/:id', function($id) {
  AsiaController::show($id);
  });
 */
// Pelin lisäyslomakkeen näyttäminen
$routes->get('/asia/new', 'check_logged_in', function() {
    AsiaController::create();
});
$routes->post('/asia/:id/edit', 'check_logged_in', function($id) {
    AsiaController::update($id);
});
$routes->get('/asia/:id/edit', 'check_logged_in', function($id) {
    AsiaController::edit($id);
});

$routes->post('/asia', 'check_logged_in', function() {
    AsiaController::store();
});
$routes->post('/asia/:id/destroy', 'check_logged_in', function($id) {
    // Pelin poisto
    AsiaController::destroy($id);
});
$routes->post('/asia/:id/lyo', 'check_logged_in', function($id) {
    AsiaController::lyo($id);
});

// ...
$routes->get('/login', function() {
    // Kirjautumislomakkeen esittäminen
    UserController::login();
});
$routes->post('/login', function() {
    // Kirjautumisen käsittely
    UserController::handle_login();
});
$routes->post('/login2', function() {
    UserController::store();
});
$routes->post('/logout', function() {
    UserController::logout();
});
$routes->get('/newuser', function() {
    UserController::create();
});



