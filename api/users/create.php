<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
date_default_timezone_set('America/Argentina/Mendoza');
// files needed to connect to database
include_once '../../config/Database.php';
// instantiate vehiculo object
include_once '../../objects/User.php';
// get database connection
$database = new Database;
$db = $database->getConnection();
// instantiate product object
$user = new User($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
if(
    !empty($data->username) &&
    !empty($data->password)
){
// set product property values
$user->username = $data->username;
$user->password = $data->password;
$user->created = date('Y-m-d H:i:s');
// create the user
if($user->create()){
    // set response code
    http_response_code(200);
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
// message if unable to create user
else{
    // set response code
    http_response_code(400);
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
  }
}
// tell the user data is incomplete
else{
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create sistema_transporte. Data is incomplete."));
}