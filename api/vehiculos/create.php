<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
date_default_timezone_set("America/Argentina/Mendoza");

// Include database and object files
include_once '../../config/Database.php';
include_once '../../objects/Vehiculo.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$vehicle = new Vehiculo($db);

// Get POSTed data
$data = json_decode(file_get_contents("php://input"));

// Make sure data is not empty
if(!empty($data->marca) && !empty($data->modelo) && !empty($data->patente) && !empty($data->sistema)){
    // Setting object properties
    $vehicle->marca = $data->marca;
    $vehicle->modelo = $data->modelo;
    $vehicle->patente = $data->patente;
    //$vehicle->sistema_nombre = $data->sistema; Si quisiera poner el nombre en vez del id del sistema
    $vehicle->sistema_id = $data->sistema;
    $vehicle->created = date('Y-m-d H:i:s');
    
    if($vehicle->create()){
        echo json_encode(array("message" => "Vehículo creado correctamente"));
    }else{
        echo json_encode(array("message" => "No se pudo crear el vehículo"));
    }
    
}else{ // if some of the fields are empty...
    echo json_encode(array("message" => "Datos insuficientes"));
}

// $algo = "Uber"; $vehicle->getSistemaId($algo); // WORKS. 
