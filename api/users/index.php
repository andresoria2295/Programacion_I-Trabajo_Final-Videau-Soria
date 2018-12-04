<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../../config/Database.php';
include_once '../../objects/Usuario.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$user = new Usuario($db);

switch($_SERVER["REQUEST_METHOD"]){
    case "POST":
        // Get data (POST)
        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->username) || !empty($data->password)){
            // Set object properties
            $user->username = $data->username;
            $user->password = $data->password;
            if(isset($data->rol) && $data->rol == "1"){
                $user->role = $data->rol;
            }else{
                $user->role = "0";
            }
            $user->created = date('Y-m-d H:i:s');
            
            // Create the user
            if($user->create()){
                echo json_encode(array("message" => "User was created."));
            } else {
                echo json_encode(array("message" => "Unable to create user."));
            }
        } else {
            echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
        }
        
        break;
    
    case "GET":

        break;

    case "PUT":
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->id)){
            $user->id = $data->id;
            $user->username = $data->username;
            $user->update();
        }else {
            echo json_encode(array("Message" => "Faltan datos"));
        }
        break;

    case "DELETE":
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->username)){
            $user->username = $data->username;
            if($user->delete()){
                echo json_encode(array("Message" => "Usuario eliminado"));
            };
        } else {
            echo json_encode(array("Message" => "Faltan datos"));
        }
        break;
}
?>