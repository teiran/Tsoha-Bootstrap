<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/kirjaudu', function() {
    HelloWorldController::kirjautumunen();
});

$routes->get('/asiansivu', function() {
    HelloWorldController::asiansivu();
});

$routes->get('/listautumissivu', function() {
    HelloWorldController::listautumissivu();
});

$routes->get('/tarkasteleasiaa', function() {
    HelloWorldController::tarkasteleasiaa();
});
