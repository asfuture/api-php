<?php
// app/controllers/UserController.php

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../../helpers/Response.php';

class UserController {
    private $userService;

    public function __construct($db){
        $this->userService = new UserService($db);
    }

    // GET /users
    public function getAll(){
        $users = $this->userService->getAllUsers();
        Response::json($users, 200);
    }

    // GET /users/{id}
    public function getById($id){
        $user = $this->userService->getUserById($id);
        if($user){
            Response::json($user, 200);
        } else {
            Response::json(['message' => 'Usuário não encontrado'], 404);
        }
    }

    // POST /users
    public function create(){
        $data = json_decode(file_get_contents("php://input"), true);
        if(!$data || !isset($data['nome']) || !isset($data['email'])){
            Response::json(['message' => 'Dados inválidos'], 400);
            return;
        }

        $user = $this->userService->createUser($data);
        if($user){
            Response::json($user, 201);
        } else {
            Response::json(['message' => 'Erro ao criar usuário'], 500);
        }
    }

    // PUT /users/{id}
    public function update($id){
        $data = json_decode(file_get_contents("php://input"), true);
        if(!$data || !isset($data['nome']) || !isset($data['email'])){
            Response::json(['message' => 'Dados inválidos'], 400);
            return;
        }

        $updated = $this->userService->updateUser($id, $data);
        if($updated){
            Response::json(['message' => 'Usuário atualizado com sucesso'], 200);
        } else {
            Response::json(['message' => 'Erro ao atualizar usuário'], 500);
        }
    }

    // DELETE /users/{id}
    public function delete($id){
        $deleted = $this->userService->deleteUser($id);
        if($deleted){
            Response::json(['message' => 'Usuário deletado com sucesso'], 200);
        } else {
            Response::json(['message' => 'Erro ao deletar usuário'], 500);
        }
    }
}
