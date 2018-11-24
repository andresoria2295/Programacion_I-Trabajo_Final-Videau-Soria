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
include_once '../../objects/Transporte.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$transport = new Transporte($db);

// Get POSTed data
$data = json_decode(file_get_contents("php://input"));
print_r($data);

 
// delete the product
if($data->id != null){
    // set product id to be deleted
    $transport->id = $data->id;
    if($transport->delete()){
        echo json_encode(array("message" => "Product was deleted."));
    }else{
        echo json_encode(array("message" => "Unable to delete product."));
    }
} else {
    echo json_encode(array("message" => "Faltan datos"));
}


?>