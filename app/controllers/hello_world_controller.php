<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }

    public static function kirjautumunen() {
        View::make('kirjautumissivu.html');
    }

    public static function listautumissivu() {
        View::make('listaussivu.html');
    }
    
    public static function asiansivu() {
        View::make('asiansivu.html');
    }
    
    public static function tarkasteleasiaa(){
        View::make('huudataiosta.html');
    }
}
