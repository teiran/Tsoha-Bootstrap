<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AsiaController
 *
 * @author tierahir
 */
class AsiaController extends BaseController {

    public static function index() {
        // Haetaan kaikki pelit tietokannasta
        $asiat = Asia::all();
        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
        View::make('asia/index.html', array('asiat' => $asiat));
    }

    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $asia = new Asia(array(
            'nimi' => $params['nimi'],
            'hinta' => $params['hinta'],
            'huutoaika' => $params['huutoaika'],
            'hintaosta' => $params['hintaosta'],
            'lisätty' => $params['lisätty'],
            'kuvaus' => $params['kuvaus']
        ));

        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $asia->tallenna();

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/asia/' . $asia->id, array('message' => 'Asia on lisätty huutokauppaan!'));
    }
    
    public static function create() {
        View::make('asia/new.html');
    }

}
