<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../../config/Database.php';
include_once '../../objects/Chofer.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$driver = new Chofer($db);

// Query
$stmt = $driver->readAll(); // returns statement.
$num = $stmt->rowCount();

// Are there records?
if($num>0){
    $driver_array = array();
    $driver_array["records"] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // Extract row... This will make $row["name"] to just $name
        extract($row);
        $driver_item = array(
            "chofer_id"=>$sistema_id,
            "apellido"=>$surname,
            "nombre"=>$name,
            "documento"=>$dni,
            "email"=>$email,
            "vehiculo_id"=>$vehicle_id,
            "sistema_id"=>$system_id,
            "created"=>$created,
            "updated"=>$updated
        );
        // Push record found to array
        array_push($driver_array["records"], $driver_item);
    }
    // Echo array in JSON format
    echo json_encode($driver_aArray);
} else {
    echo json_encode(
        array("message" => "No hay choferes guardados.")
    );
}

// Ex. http://localhost/proyecto/api/sistemas_transporte/read_all.php
?>
