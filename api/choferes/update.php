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
// Set property values
$driver->driver_id = $data->driver_id;
$driver->name = $data->name;
$driver->surname = $data->surname;
$driver->dni = $data->dni;
$driver->email = $data->email;
$driver->vehicle_id = $data->vehicle_id;
$driver->system_id = $data->system_id;

// update the product
if($driver->update()){
    echo json_encode(array("message" => "Se ha acualizado chofer seleccionado."));
}else{
     echo json_encode(array("message" => "No es posible actualizar chofer seleccionado."));
}

?>
