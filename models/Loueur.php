<?php
class Loueur {
    public $id;
    public $nom;
    public $nbAppelsKO;
    public $nbTimeouts;
    public $date;

    public function __construct($id, $nom, $nbAppelsKO, $nbTimeouts, $date) {
        $this->id = $id;
        $this->nom = $nom;
        $this->nbAppelsKO = $nbAppelsKO;
        $this->nbTimeouts = $nbTimeouts;
        $this->date = $date;
    }
}
