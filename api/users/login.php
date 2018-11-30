<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once '../../libs/vendor/autoload.php';
use \Firebase\JWT\JWT;
// files needed to connect to database
include_once '../../config/Database.php';
// instantiate vehiculo object
include_once '../../objects/user.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
// instantiate product object
$user = new User($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
// set product property values
if(
    !empty($data->username) &&
    !empty($data->password)
){
// set product property values
$user->username = $data->username;
$user->password = $data->password;
$user_exists = $user->userExists();
// generate json web token
include_once '../../config/core.php';
// check if email exists and if password is correct
if($user_exists && password_verify($data->password, $user->password)){
    $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "user_id" => $user->user_id,
           "username" => $user->username
       )
    );
    // set response code
    http_response_code(200);
    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt
            )
        );
}
else{
   // set response code
   http_response_code(401);
   // tell the user login failed
   echo json_encode(array("message" => "Login failed."));
}
}
// tell the user data is incomplete
else{
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to login. Data is incomplete."));
}