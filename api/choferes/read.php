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
include_once '../../objects/Chofer.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$driver = new Chofer($db);

if(isset($_GET["apellido"])){
    $driver->surname = $_GET["apellido"];
}else{
    die();
}

$driver->read();

if($driver->surname!=null){
    // Create array
    $driver_array = array(
        "chofer_id"=>$driver->driver_id,
        "nombre"=>$driver->name,
        "apellido"=>$driver->surname,
        "documento"=>$driver->dni,
        "email"=>$driver->email,
        "vehiculo_id"=>$driver->vehicle_id,
        "sistema_id"=>$driver->system_id,
        "created"=>$driver->created,
        "updated"=>$driver->updated
    );

    // Send array in JSON format
    echo json_encode($driver_array);
}else{
    // Data does not exist.
    echo json_encode(array("message" => "Chofer no existente."));
}

// Ex. http://localhost/proyecto/api/sistemas_transporte/read.php/?nombre=Cabify

?>
