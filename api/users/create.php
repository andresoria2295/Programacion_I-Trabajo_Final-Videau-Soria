<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
date_default_timezone_set('America/Argentina/Mendoza');

// Required files
include_once '../../config/Database.php';
include_once '../../objects/Usuario.php';

// Connect to database and instantiate user object
$database = new Database;
$db = $database->getConnection();
$user = new Usuario($db);

// Get data (POST)
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->username) || !empty($data->password)){
    // Set object properties
    $user->username = $data->username;
    $user->password = $data->password;
    $user->created = date('Y-m-d H:i:s');
    
    // Create the user
    if($user->create()){
        echo json_encode(array("message" => "User was created."));
    } else {
        echo json_encode(array("message" => "Unable to create user."));
    }
} else {
    echo json_encode(array("message" => "Unable to create sistema_transporte. Data is incomplete."));
}