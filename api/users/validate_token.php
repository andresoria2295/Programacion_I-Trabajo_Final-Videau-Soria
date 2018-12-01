<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../objects/Token.php';

$Token = new Token();

// Get JWT
$data = json_decode(file_get_contents("php://input"));

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $jwt = $_GET["jwt"];
}else{
    $jwt = isset($data->jwt) ? $data->jwt : "";
}

// If JWT is not empty...
if($jwt){
    try {
        // Decode jwt
        $Token->decodeToken($jwt);
        echo json_encode(array("message" => "Access granted."));
    }catch (Exception $e){ // If decode fails, it means JWT is invalid
      echo json_encode(array("message" => "Access denied.", "error" => $e->getMessage()));
      exit;
      //return false;
    }
} else { // JWT is empty...
    echo json_encode(array("message" => "Access denied."));
    exit;
    //return false;
};

?>