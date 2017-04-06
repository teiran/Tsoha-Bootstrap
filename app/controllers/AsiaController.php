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
            'lisatty' => $params['lisatty'],
            'kuvaus' => $params['kuvaus']
        ));
        $errors = $asia->errors();

        if (count($errors) == 0) {
            // Peli on validi, hyvä homma!
            $asia->tallenna();

            Redirect::to('/asia', array('message' => 'Asia on lisätty huutokauppaan!'));
        } else {
            // Pelissä oli jotain vikaa :(
            View::make('asia/new.html', array('errors' => $errors, 'attributes' => $asia));
        }



        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
    }

    public static function create() {
        View::make('asia/new.html');
    }

    public static function edit($id) {
        $asia = Asia::find($id);
        View::make('asia/edit.html', array('asia' => $asia));
    }

    // Pelin muokkaaminen (lomakkeen käsittely)
    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'hinta' => $params['hinta'],
            'huutoaika' => $params['huutoaika'],
            'hintaosta' => $params['hintaosta'],
            'lisatty' => $params['lisatty'],
            'kuvaus' => $params['kuvaus']
        );
        // Alustetaan Game-olio käyttäjän syöttämillä tiedoilla
        $asia = new Asia($attributes);
        $errors = $asia->errors();

        if (count($errors) > 0) {
            View::make('asia/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
            $asia->update();

            Redirect::to('/asia', array('message' => 'Asiaa on muokattu onnistuneesti!'));
        }
    }

    // Pelin poistaminen
    public static function destroy($id) {
        // Alustetaan Game-olio annetulla id:llä
        $asia = new Asia(array('id' => $id));
        // Kutsutaan Game-malliluokan metodia destroy, joka poistaa pelin sen id:llä
        $asia->destroy();

        // Ohjataan käyttäjä pelien listaussivulle ilmoituksen kera
        Redirect::to('/asia', array('message' => 'Asia on poistettu onnistuneesti!'));
    }

}
