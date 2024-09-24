<?php
// app/config/Database.php

class Database {
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root"; // padrão do WAMP
    private $password = ""; // padrão do WAMP
    public $conn;

    public function getConnection(){
        $this->conn = null;

        try{
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            // Definir o modo de erro do PDO para exceção
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit;
        }

        return $this->conn;
    }
}
