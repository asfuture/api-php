<?php
// app/services/UserService.php

require_once __DIR__ . '/../repositories/UserRepository.php';

class UserService {
    private $userRepository;

    public function __construct($db){
        $this->userRepository = new UserRepository($db);
    }

    public function getAllUsers(){
        return $this->userRepository->getAll();
    }

    public function getUserById($id){
        return $this->userRepository->getById($id);
    }

    public function createUser($data){
        $user = new User(null, $data['nome'], $data['email'], $data['telefone'], $data['endereco']);
        return $this->userRepository->create($user);
    }

    public function updateUser($id, $data){
        $user = new User($id, $data['nome'], $data['email'], $data['telefone'], $data['endereco']);
        return $this->userRepository->update($user);
    }

    public function deleteUser($id){
        return $this->userRepository->delete($id);
    }
}
