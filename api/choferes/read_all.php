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
$database = new Database();
$db = $database->getConnection();

// Initialize object
$driver = new Chofer($db);

// Query
$stmt = $driver->readAll(); // returns statement.
$num = $stmt->rowCount();

$driver_array = array();
    $driver_array["records"] = array();
// Are there records?
if($num>0){
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // Extract row... This will make $row["name"] to just $name
        extract($row);
        $driver_item = array(
            "chofer_id"=>$chofer_id,
            "apellido"=>$apellido,
            "nombre"=>$nombre,
            "documento"=>$documento,
            "email"=>$email,
            "vehiculo_id"=>$vehiculo_id,
            "sistema_id"=>$sistema_id,
            "created"=>$created,
            "updated"=>$updated
        );
        // Push record found to array
        array_push($driver_array["records"], $driver_item);
    }
    // Echo array in JSON format
    echo json_encode($driver_array);
} else {
    echo json_encode(
        array("message" => "No se encuentran choferes guardados.")
    );
}

// Ex. http://localhost/proyecto/api/sistemas_transporte/read_all.php
?>
