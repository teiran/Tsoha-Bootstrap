<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author tierahir
 */
class User extends BaseModel {

    public $id, $nimi, $salasana, $tili, $kate, $yllapitaja;

    //put your code here


    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_salasana');
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

    public function validate_salasana() {
        $errors = array();
        if ($this->salasana == '' || $this->salasana == null) {
            $errors[] = 'Aalasana ei saa olla tyhjä!';
        }
        if (strlen($this->salasana) < 8) {
            $errors[] = 'Salasana pituuden tulee olla vähintään kahdeksan merkkiä!';
        }

        return $errors;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, salasana, tili, kate) VALUES (:nimi, :salasana, :tili, :kate) RETURNING id');

        $query->execute(array('nimi' => $this->nimi, 'salasana' => $this->salasana, 'tili' => $this->tili, 'kate' => $this->kate));

        $row = $query->fetch();

        $this->id = $row['id'];
        
    }

    public static function authenticate($nimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'salasana' => $row['salasana'],
                'tili' => $row['tili'],
                'kate' => $row['kate'],
                'yllapitaja' => $row['yllapitaja']
            ));
            return $user;
        } else {
            return null;
        }
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'salasana' => $row['salasana'],
                'tili' => $row['tili'],
                'kate' => $row['kate'],
                'yllapitaja' => $row['yllapitaja']
            ));

            return $user;
        }

        return null;
    }

}
