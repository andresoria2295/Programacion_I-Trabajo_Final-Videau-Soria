<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../../config/Database.php';
include_once '../../objects/Vehiculo.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$vehicle = new Vehiculo($db);

if(isset($_GET["patente"])){
    $vehicle->patente = $_GET["patente"];
}else{
    die();
}

$vehicle->read();

if($vehicle->marca!=null && $vehicle->modelo != null){
    // Create array
    $vehicleArray = array(
        "marca"=>$vehicle->marca,
        "modelo"=>$vehicle->modelo,
        "patente"=>$vehicle->patente,
        "created"=>$vehicle->created,
        "updated"=>$vehicle->updated,
        "sistema"=>$vehicle->sistema_nombre
    );

    // Send array in JSON format
    echo json_encode($vehicleArray);
}else{
    // Data does not exist.
    echo json_encode(array("message" => "El servicio de transporte no existe."));
}

// Ex. http://localhost/proyecto/api/sistemas_transporte/read.php/?nombre=Cabify

?>