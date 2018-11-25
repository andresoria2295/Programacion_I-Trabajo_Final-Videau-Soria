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

// Make sure data is not empty
if( !empty($data->name) && !empty($data->surname) && !empty ($data->dni) && !empty($data->email)){
    // Set property values
    $driver->name = $data->name;
    $driver->surname = $data->surname;
    $driver->dni = $data->dni;
    $driver->email = $data->email;
    $driver->created = date('Y-m-d H:i:s');
    // Create
    if($driver->create()){
        echo json_encode(array("message" => "Se ha creado nuevo chofer."));
    } else {
        echo json_encode(array("message" => "No se ha creado chofer."));
    }
} else {
    // Data incomplete
    echo json_encode(array("message" => "No se ha creado chofer. Faltan datos."));
}
