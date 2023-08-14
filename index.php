<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);



    if ($parts[1] != "sommalife_task_php" && $parts[2] != "api") {
        http_response_code(404);
        exit;
    }else{
        
    $id = $parts[4] ?? null;

    $database = new Database("localhost", "product_db", "root", "");
    if($parts[3] == "survey"){
        $gateway = new SurveyGateway($database);

        $controller = new SurveyController($gateway);
    
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
    }else if($parts[3] == "question"){

    }else if($parts[3] == "response"){

    }
}













