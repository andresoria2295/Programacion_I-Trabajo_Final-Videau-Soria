<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include objects
include_once "../../config/Database.php";
include_once "../../objects/Usuario.php";
include_once "../../objects/Token.php";

// Database connection and instantiation
$database = new Database();
$db = $database->getConnection();
$user = new Usuario($db);
$Token = new Token();

// Get data
$data = json_decode(file_get_contents("php://input"));

// Set object properties
if(!empty($data->username) && !empty($data->password)){ // Generate JSON Web Token if the data is correct
    $user->username = $data->username;
    if(password_verify($data->password, $user->getHash())){ // If password given matches with the decrypted password hash from database...
        // Data array
        $jwt_data = array("user_id" => $user->id, "username" => $user->username);
        // Generate JWT
        $tkn = $Token->generateToken($jwt_data);
        // Extract data from JWT
        $usr = $Token->decodeToken($tkn)["username"];
        // Send results.
        echo json_encode(array("JWT" => $tkn, "username" => $usr));
    } else {
        echo json_encode(array("message" => "Login failed. Password incorrect"));
    };
}else{
    echo json_encode(array("message" => "Unable to login. Data is incomplete."));
}