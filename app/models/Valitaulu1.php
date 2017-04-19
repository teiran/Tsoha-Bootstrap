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
class Valitaulu1 extends BaseModel {

    public $id, $luoja_id, $Asia_id, $Huutaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Valitaulu (luoja_id, Asia_id) VALUES (:luoja_id, :Asia_id) RETURNING id');

        $query->execute(array('luoja_id' => $this->luoja_id, 'Asia_id' => $this->Asia_id));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Valitaulu SET ($Huutaja_id) = (:Huutaja_id) WHERE id = :id');

        $query->execute(array('$Huutaja_id' => $this->$Huutaja_id));

        $row = $query->fetch();
    }

}
