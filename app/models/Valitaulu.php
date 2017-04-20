<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Valitaulu1
 *
 * @author tierahir
 */
class Valitaulu extends BaseModel {

    public $id, $luoja_id, $asia_id, $Huutaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Valitaulu (luoja_id, asia_id) VALUES (:luoja_id, :asia_id) RETURNING id');

        $query->execute(array('luoja_id' => $this->luoja_id, 'asia_id' => $this->asia_id));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Valitaulu SET (Huutaja_id) = (:Huutaja_id) WHERE id = :id');

        $query->execute(array('Huutaja_id' => $this->Huutaja_id));

        $row = $query->fetch();
    }
    
        public static function find($asia_id) {
        $query = DB::connection()->prepare('SELECT * FROM Valitaulu WHERE asia_id = :asia_id LIMIT 1');
        $query->execute(array('asia_id' => $asia_id));
        $row = $query->fetch();

        if ($row) {
            $valitustaulu = new Valitaulu(array(
                'id' => $row['id'],
                'luoja_id' => $row['luoja_id'],
                'asia_id' => $row['asia_id'],
                'huutaja_id' => $row['huutaja_id']
            ));

            return $valitustaulu;
        }

        return null;
    }
    
    

}
