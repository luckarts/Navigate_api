<?php

use Controllers\StepsController;


require '../vendor/autoload.php';

/** start session if not already start */
if(!isset($_SESSION)) session_start();

if($_ENV['ENV'] == "dev") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$controller = new StepsController();


try{
    header('Content-Type: application/json');
    echo json_encode($controller->index());

}catch (\Exception $e) {
    echo $e->getMessage();
}


