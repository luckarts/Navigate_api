<?php

use Controllers\StepsController;


require '../vendor/autoload.php';

/** start session if not already start */
if(!isset($_SESSION)) session_start();

if($_ENV['ENV'] == "dev") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}


try{

    $controller = new StepsController();
    // return to json format Api
    header('Content-Type: application/json');
    echo json_encode($controller->index());

}catch (\Exception $e) {

    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}


