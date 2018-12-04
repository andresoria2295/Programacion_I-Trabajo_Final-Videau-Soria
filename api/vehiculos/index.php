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
include_once '../../objects/Vehiculo.php';
include_once '../../objects/Token.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$vehicle = new Vehiculo($db);

// Token
$Token = new Token($db);

switch($_SERVER["REQUEST_METHOD"]){
    case "POST":
        // Get POSTed data
        $data = json_decode(file_get_contents("php://input"));

        // Validate token
        $Token->validateToken($data->jwt);

        // Make sure data is not empty
        if(!empty($data->marca) && !empty($data->modelo) && !empty($data->patente) && !empty($data->sistema) && !empty($data->anho_fabricacion) && !empty($data->anho_patente)){
            // Setting object properties
            $vehicle->marca = $data->marca;
            $vehicle->modelo = $data->modelo;
            $vehicle->patente = $data->patente;
            //$vehicle->sistema_nombre = $data->sistema; Si quisiera poner el nombre en vez del id del sistema
            $vehicle->sistema_id = $data->sistema;
            $vehicle->created = date('Y-m-d H:i:s');
            $vehicle->anho_fabricacion = $data->anho_fabricacion;
            $vehicle->anho_patente = $data->anho_patente;
            if($vehicle->create()){
                echo json_encode(Array("message" => "Vehículo creado correctamente"));
            }else{
                echo json_encode(Array("message" => "No se pudo crear el vehículo"));
            }
        }else{ // if some of the fields are empty...
            echo json_encode(Array("message" => "Datos insuficientes"));
        }
        
        break;

    case "GET": // NO FUNCIONA READ SINGLE
        $Token->validateToken($_GET["jwt"]);
        
        if(isset($_GET["patente"])){
            $vehicle->patente = $_GET["patente"];
            $vehicle->read();
        }else{
            $vehicle->readAll();
        }

        break;

    case "PUT":
        // Get POSTed data
        $data = json_decode(file_get_contents("php://input"));

        // Validate token
        $Token->validateToken($data->jwt);

        //print_r($data);
        $vehicle->marca = $data->marca;
        $vehicle->modelo = $data->modelo;
        $vehicle->patente = $data->patente;
        $vehicle->id = $data->id;
        $vehicle->sistema_id = $data->sistema;
        $vehicle->anho_fabricacion = $data->anho_fabricacion;
        $vehicle->anho_patente = $data->anho_patente;
        $vehicle->created = date('Y-m-d H:i:s');

        if($vehicle->id!=null){
            if($vehicle->update()){
                echo json_encode(Array("Message"=>"Se modifico el vehiculo exitosamente"));
            }else{
                echo json_encode(Array("Message"=>"No se pudo modificar el vehiculo"));
            }
        } else {
            echo json_encode(Array("Message"=>"No se pudo modificar el vehiculo. Faltan datos"));
        }
        
        break;

    case "DELETE":
        // Get POSTed data
        $data = json_decode(file_get_contents("php://input"));

        // Validate token
        $Token->validateToken($data->jwt);

        if(!empty($data->patente)){
            $vehicle->patente = $data->patente;
            if($vehicle->delete()){
                echo json_encode(Array("message"=>"Se eliminó el vehículo correctamente"));
            }else{
                echo json_encode(Array("message"=>"No se eliminó el vehículo"));
            }
        }else{
            echo json_encode(Array("message"=>"No se cumple que !empty(data->patente)"));
        }
        
        break;

}

?>