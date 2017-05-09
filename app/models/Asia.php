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

    public $id, $nimi, $hinta, $huutoaika, $lisatty, $hintaosta, $ostettu, $kuvaus, $huutaja, $sameuser, $nobidder, $luoja, $vanhahinta;

    public function __construct($attributes) {
        if (!is_null($this->hinta)) {
            $this->vanhahinta = $this->hinta;
        }
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_hinta', 'validate_hintaosta');
    }

    public function validate_name() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->nimi) < 5) {
            $errors[] = 'Nimen pituuden tulee olla vähintään viisi merkkiä!';
        }

        return $errors;
    }

    public function validate_hinta() {
        $errors = array();
        if ($this->hinta == '' || $this->hinta == null) {
            $errors[] = 'Hinta ei saa olla tyhjä!';
        }
        if ($this->hinta < 4) {
            $errors[] = 'Minimi hinta 5';
        }
        if (!is_null($this->vanhahinta)) {
            if ($this->hinta <= $this->vanhahinta) {
                $errors[] = 'Huudon tavitsee olla isompi kuin 0';
            }
        }

        return $errors;
    }

    public function validate_hintaosta() {
        $errors = array();
        if ($this->hintaosta == '' || $this->hintaosta == null) {
            $errors[] = 'hintaosta ei saa olla tyhjä!';
        }
        if ($this->hinta > $this->hintaosta) {
            $errors[] = 'ostohinnan tarvitsee olla isompi kui hinnan';
        }

        return $errors;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Asia (nimi, hinta, huutoaika, lisatty, hintaosta, kuvaus) VALUES (:nimi, :hinta, :huutoaika, :lisatty, :hintaosta, :kuvaus) RETURNING id');

        $query->execute(array('nimi' => $this->nimi, 'hinta' => $this->hinta, 'huutoaika' => $this->huutoaika, 'lisatty' => $this->lisatty, 'hintaosta' => $this->hintaosta, 'kuvaus' => $this->kuvaus));

        $row = $query->fetch();

        $this->id = $row['id'];
        return $this->id;
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Asia SET (nimi, hinta, huutoaika, lisatty, hintaosta, kuvaus) = (:nimi, :hinta, :huutoaika, :lisatty, :hintaosta, :kuvaus) WHERE id = :id');

        $query->execute(array('nimi' => $this->nimi, 'hinta' => $this->hinta, 'huutoaika' => $this->huutoaika, 'lisatty' => $this->lisatty, 'hintaosta' => $this->hintaosta, 'kuvaus' => $this->kuvaus, 'id' => $this->id));

        $row = $query->fetch();
    }

    public function update2() {
        $query = DB::connection()->prepare('UPDATE Asia SET (nimi, hinta, huutoaika, lisatty, hintaosta, ostettu, kuvaus) = (:nimi, :hinta, :huutoaika, :lisatty, :hintaosta, :ostettu, :kuvaus) WHERE id = :id');

        $query->execute(array('nimi' => $this->nimi, 'hinta' => $this->hinta, 'huutoaika' => $this->huutoaika, 'lisatty' => $this->lisatty, 'hintaosta' => $this->hintaosta, 'ostettu' => true, 'kuvaus' => $this->kuvaus, 'id' => $this->id));

        $row = $query->fetch();
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Asia WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public static function all($userid) {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Asia');
        $query->execute();
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $asiat = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            $valitaulu = Valitaulu::find($row['id']);
            $huutaja;
            if (is_null($valitaulu->huutaja_id)) {
                $huutaja = null;
            } else {
                $huutaja = User::find($valitaulu->huutaja_id);
                $huutaja = $huutaja->nimi;
            }
            $luoja = User::find($valitaulu->luoja_id);
            $luoja = $luoja->nimi;
            $sameuser2 = $valitaulu->luoja_id == $userid;
            $nobidder = is_null($valitaulu->huutaja_id);
            $asiat[] = new Asia(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'hinta' => $row['hinta'],
                'huutoaika' => $row['huutoaika'],
                'lisatty' => $row['lisatty'],
                'hintaosta' => $row['hintaosta'],
                'ostettu' => $row['ostettu'],
                'huutaja' => $huutaja,
                'kuvaus' => $row['kuvaus'],
                'sameuser' => $sameuser2,
                'nobidder' => $nobidder,
                'luoja' => $luoja
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
