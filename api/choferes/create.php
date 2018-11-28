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


if(isset($data->nombre) && isset($data->apellido) && isset($data->documento) && isset($data->sistema) && isset($data->vehiculo) && isset($data->email)){
    $driver->name = $data->nombre;
    $driver->surname = $data->apellido;
    $driver->dni = $data->documento;
    $driver->email = $data->email;
    $driver->vehicle_id = $data->vehiculo;
    $driver->system_id = $data->sistema;
    $driver->created = date('Y-m-d H:i:s');

    if($driver->create()){
        echo json_encode(Array("Message" => "Se creo el chofer correctamente"));
    }else{
        echo json_encode(Array("Message" => "No se pudo crear el chofer"));
    };

}else{
    echo json_encode(Array("Message" => "Faltan datos"));
}