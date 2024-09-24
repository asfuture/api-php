<?php
// app/models/User.php

class User {
    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $endereco;

    public function __construct($id = null, $nome = null, $email = null, $telefone = null, $endereco = null){
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->endereco = $endereco;
    }
}
