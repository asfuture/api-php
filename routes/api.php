<?php
// routes/api.php

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

// Inicializar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Inicializar o controlador
$userController = new UserController($db);

// Obter a URI e o método HTTP
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/api-php/public', '', $uri); // Ajuste conforme seu diretório
$method = $_SERVER['REQUEST_METHOD'];

// Roteamento
$uriSegments = explode('/', trim($uri, '/'));

if($uriSegments[0] !== 'users'){
    Response::json(['message' => 'Rota não encontrada'], 404);
}

$id = isset($uriSegments[1]) ? (int)$uriSegments[1] : null;

switch($method){
    case 'GET':
        if($id){
            $userController->getById($id);
        } else {
            $userController->getAll();
        }
        break;
    case 'POST':
        $userController->create();
        break;
    case 'PUT':
        if($id){
            $userController->update($id);
        } else {
            Response::json(['message' => 'ID não fornecido'], 400);
        }
        break;
    case 'DELETE':
        if($id){
            $userController->delete($id);
        } else {
            Response::json(['message' => 'ID não fornecido'], 400);
        }
        break;
    default:
        Response::json(['message' => 'Método não suportado'], 405);
        break;
}
