<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asia
 *
 * @author tierahir
 */
class Asia extends BaseModel {

    public $id, $nimi, $hinta, $huutoaika, $lisatty, $hintaosta, $ostettu, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Asia (nimi, hinta, huutoaika, hintaosta, lisatty, kuvaus) VALUES (:nimi, :hinta, :huutoaika, :hintaosta, :lisatty, :kuvaus) RETURNING id');
        
        $query->execute(array('nimi' => $this->nimi, 'hinta' => $this->hinta, 'huutoaika' => $this->huutoaika, 'hintaosta' => $this->hintaosta, 'lisatty' => $this->lisatty, 'kuvaus' => $this->kuvaus));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Asia');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $asiat = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $asiat[] = new Asia(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'hinta' => $row['hinta'],
                'huutoaika' => $row['huutoaika'],
                'lisatty' => $row['lisatty'],
                'hintaosta' => $row['hintaosta'],
                'ostettu' => $row['ostettu'],
                'kuvaus' => $row['kuvaus']
            ));
        }

        return $asiat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Asia WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $asia = new Asia(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'hinta' => $row['hinta'],
                'huutoaika' => $row['huutoaika'],
                'lisatty' => $row['lisatty'],
                'hintaosta' => $row['hintaosta'],
                'ostettu' => $row['ostettu'],
                'kuvaus' => $row['kuvaus']
            ));

            return $asia;
        }

        return null;
    }

}
