<?php

$routes->get('/', function() {
    AsiaController::index();
});
// Pelien listaussivu
$routes->get('/asia', function() {
    AsiaController::index();
});

// Pelin esittelysivu
/*$routes->get('/asia/:id', function($id) {
    AsiaController::show($id);
});
*/
$routes->post('/asia', function() {
    AsiaController::store();
});
// Pelin lisäyslomakkeen näyttäminen
$routes->get('/asia/new', function() {
    AsiaController::create();
});
