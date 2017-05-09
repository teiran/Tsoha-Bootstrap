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
        $_user_logged_in = self::get_user_logged_in();
        if (is_null($_user_logged_in)) {
            $asiat = Asia::all(null);
        } else {
            $asiat = Asia::all($_user_logged_in->id);
        }

        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
        View::make('asia/index.html', array('asiat' => $asiat));
    }

    public static function store() {
        self::check_logged_in();
        $user = self::get_user_logged_in();
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
            $id = $asia->tallenna();
            $valitaulu = new Valitaulu(array(
                'luoja_id' => $user->id,
                'asia_id' => $id
            ));
            $valitaulu->tallenna();
            Redirect::to('/asia', array('message' => 'Asia on lisätty huutokauppaan!'));
        } else {
            // Pelissä oli jotain vikaa :(
            View::make('asia/new.html', array('errors' => $errors, 'attributes' => $asia));
        }



        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
    }

    public static function create() {
        self::check_logged_in();
        View::make('asia/new.html');
    }

    public static function edit($id) {
        self::check_logged_in();
        $valitytaulu = Valitaulu::find($id);
        if (!is_null($valitytaulu->huutaja_id)) {
            Redirect::to('/asia');
        }
        $asia = Asia::find($id);
        View::make('asia/edit.html', array('asia' => $asia));
    }

    public static function huudataiosta($id) {
        self::check_logged_in();
        $asia = Asia::find($id);
        View::make('asia/huudataiosat.html', array('asia' => $asia));
    }

    public static function osta($id) {
        self::check_logged_in();
        $params = $_POST;
        $user = self::get_user_logged_in();
        $valitaulu = Valitaulu::find($id);
        $attributes = array(
            'id' => $valitaulu->id,
            'luoja_id' => $valitaulu->luoja_id,
            'asia_id' => $valitaulu->asia_id,
            'huutaja_id' => $user->id
        );
        $valitaulu2 = new Valitaulu($attributes);
        $valitaulu2->update();
        $asia = Asia::find($id);
        $attributes = array(
            'id' => $id,
            'nimi' => $asia->nimi,
            'hinta' => $asia->hinta,
            'huutoaika' => $asia->huutoaika,
            'hintaosta' => $asia->hintaosta,
            'lisatty' => $asia->lisatty,
            'kuvaus' => $asia->kuvaus
        );
        $asia->update2();
        Redirect::to('/asia', array('message' => 'ostettu onnistuneesti'));
    }

    public static function lyo($id) {
        self::check_logged_in();
        $params = $_POST;
        $user = self::get_user_logged_in();
        $asia = Asia::find($id);
        $attributes = array(
            'id' => $id,
            'nimi' => $asia->nimi,
            'hinta' => $asia->hinta + $params['hinta'],
            'huutoaika' => $asia->huutoaika,
            'hintaosta' => $asia->hintaosta,
            'lisatty' => $asia->lisatty,
            'kuvaus' => $asia->kuvaus
        );
        $asia = new Asia($attributes);
        $errors = $asia->errors();
        if ($asia->hinta + $params['hinta'] <= $asia->hinta) {
            View::make('asia/huudataiosat.html', array('errors' => "huudo tarvitsee olla isompi kuin hinnan (enemmän kuin 0)"));
        }
        if (count($errors) > 0) {
            View::make('asia/huudataiosat.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $asia->update();
            $valitaulu = Valitaulu::find($id);
            $attributes = array(
                'id' => $valitaulu->id,
                'luoja_id' => $valitaulu->luoja_id,
                'asia_id' => $valitaulu->asia_id,
                'huutaja_id' => $user->id
            );
            $valitaulu2 = new Valitaulu($attributes);
            $valitaulu2->update();
            Redirect::to('/asia', array('message' => 'lyötyvetoa onnistuneesti'));
        }
    }

    // Pelin muokkaaminen (lomakkeen käsittely)
    public static function update($id) {
        self::check_logged_in();
        $valitytaulu = Valitaulu::find($id);
        if (!is_null($valitytaulu->huutaja_id)) {
            Redirect::to('/asia');
        }
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
        self::check_logged_in();
        $valitytaulu = Valitaulu::find($id);
        if (!is_null($valitytaulu->huutaja_id)) {
            Redirect::to('/asia');
        }
        // Alustetaan Game-olio annetulla id:llä
        $asia = new Asia(array('id' => $id));
        // Kutsutaan Game-malliluokan metodia destroy, joka poistaa pelin sen id:llä
        $asia->destroy();

        // Ohjataan käyttäjä pelien listaussivulle ilmoituksen kera
        Redirect::to('/asia', array('message' => 'Asia on poistettu onnistuneesti!'));
    }

}
