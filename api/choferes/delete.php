<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../../config/Database.php';
include_once '../../objects/Chofer.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$driver = new Chofer($db);

// Get POSTed data
$data = json_decode(file_get_contents("php://input"));

// set product id to be deleted
$driver->driver_id = $data->driver_id;

// delete the product
if($data->driver_id != null){
    if($driver->delete()){
        echo json_encode(array("message" => "Se ha eliminado chofer seleccionado."));
    }else{
        echo json_encode(array("message" => "El chofer seleccionado no existe."));
    }
} else {
    echo json_encode(array("message" => "No es posible eliminar chofer seleccionado. Faltan datos"));
}


?>
