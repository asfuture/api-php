<?php
// app/repositories/UserRepository.php

require_once __DIR__ . '/../models/User.php';

class UserRepository {
    private $conn;
    private $table = "users";

    public function __construct($db){
        $this->conn = $db;
    }

    // Obter todos os usuários
    public function getAll(){
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $users[] = new User($row['id'], $row['nome'], $row['email'], $row['telefone'], $row['endereco']);
        }

        return $users;
    }

    // Obter um usuário por ID
    public function getById($id){
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            return new User($row['id'], $row['nome'], $row['email'], $row['telefone'], $row['endereco']);
        }

        return null;
    }

    // Criar um novo usuário
    public function create(User $user){
        $query = "INSERT INTO " . $this->table . " SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco";
        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $user->nome = htmlspecialchars(strip_tags($user->nome));
        $user->email = htmlspecialchars(strip_tags($user->email));
        $user->telefone = htmlspecialchars(strip_tags($user->telefone));
        $user->endereco = htmlspecialchars(strip_tags($user->endereco));

        // Bind de parâmetros
        $stmt->bindParam(':nome', $user->nome);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':telefone', $user->telefone);
        $stmt->bindParam(':endereco', $user->endereco);

        if($stmt->execute()){
            $user->id = $this->conn->lastInsertId();
            return $user;
        }

        return null;
    }

    // Atualizar um usuário
    public function update(User $user){
        $query = "UPDATE " . $this->table . " SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $user->nome = htmlspecialchars(strip_tags($user->nome));
        $user->email = htmlspecialchars(strip_tags($user->email));
        $user->telefone = htmlspecialchars(strip_tags($user->telefone));
        $user->endereco = htmlspecialchars(strip_tags($user->endereco));
        $user->id = htmlspecialchars(strip_tags($user->id));

        // Bind de parâmetros
        $stmt->bindParam(':nome', $user->nome);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':telefone', $user->telefone);
        $stmt->bindParam(':endereco', $user->endereco);
        $stmt->bindParam(':id', $user->id);

        return $stmt->execute();
    }

    // Deletar um usuário
    public function delete($id){
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $id = htmlspecialchars(strip_tags($id));

        // Bind de parâmetros
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
