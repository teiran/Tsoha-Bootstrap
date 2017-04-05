<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KayttajaController
 *
 * @author tierahir
 */
class KayttajaController extends BaseController {

    public static function index() {
        // Haetaan kaikki pelit tietokannasta
        $kayttaja = Kayttaja::all();
        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
        View::make('kayttaja/index.html', array('kayttajat' => $kayttaja));
    }

}
