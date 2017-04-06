<?php

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
$routes->get('/asia/new', function() {
    AsiaController::create();
});
$routes->post('/asia/:id/edit', function($id) {
    // Pelin muokkaaminen
    AsiaController::update($id);
});
$routes->get('/asia/:id/edit', function($id) {
    // Pelin muokkauslomakkeen esittäminen
    AsiaController::edit($id);
});

$routes->post('/asia', function() {
    AsiaController::store();
});
$routes->post('/asia/:id/destroy', function($id) {
    // Pelin poisto
    AsiaController::destroy($id);
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
