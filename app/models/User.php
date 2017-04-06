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
