<?php
// helpers/Response.php

class Response {
    public static function json($data, $status = 200){
        header_remove();
        http_response_code($status);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
        exit;
    }
}
