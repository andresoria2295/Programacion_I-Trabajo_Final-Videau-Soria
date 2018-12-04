<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../../config/Database.php';
include_once '../../objects/Chofer.php';
include_once '../../objects/Token.php';
include_once '../../objects/Auditoria.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$driver = new Chofer($db);

// Token
$Token = new Token($db);

// Auditoria
$Auditoria = new Auditoria($db);

switch($_SERVER["REQUEST_METHOD"]){
    case "POST":
        // Get data
        $data = json_decode(file_get_contents("php://input"));
        // Check token
        $Token->validateToken($data->jwt);
        // Auditoria
        $start_time = microtime(true);

        if(isset($data->nombre) && isset($data->apellido) && isset($data->documento) && isset($data->sistema) && isset($data->vehiculo) && isset($data->email)){
            $driver->name = $data->nombre;
            $driver->surname = $data->apellido;
            $driver->dni = $data->documento;
            $driver->email = $data->email;
            $driver->vehicle_id = $data->vehiculo;
            $driver->system_id = $data->sistema;
            $driver->created = date('Y-m-d H:i:s');

            if($driver->create()){
                echo json_encode(Array("Message" => "Se creo el chofer correctamente"));
            }else{
                echo json_encode(Array("Message" => "No se pudo crear el chofer"));
            };
        }else{
            echo json_encode(Array("Message" => "Faltan datos"));
        }

        // Auditoria
        $time = microtime(true) - $start_time;
        $ep = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"] . $_SERVER["REQUEST_METHOD"];
        $Auditoria->audit($Token->decodeToken($data->jwt)["username"], $ep, $time);

        break;

    case "GET":
        // Auditoria
        $start_time = microtime(true);
        
        if(isset($_GET["jwt"])){
            $Token->validateToken($_GET["jwt"]);
        }else{
            exit;
        }

        if(isset($_GET["id"])){
            $driver->driver_id = $_GET["id"];
            $driver->read();
        }else{
            $driver->readAll();
        };

        // Auditoria
        $time = microtime(true) - $start_time;
        $ep = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"] . $_SERVER["REQUEST_METHOD"];
        $Auditoria->audit($Token->decodeToken($_GET["jwt"])["username"], $ep, $time);

        break;
        
    case "PUT":
        // Get data
        $data = json_decode(file_get_contents("php://input"));
        // Validate token
        $Token->validateToken($data->jwt);

        // Auditoria
        $start_time = microtime(true);

        // Set new property values
        if(isset($data->id)){
            $driver->driver_id = $data->id;
            $driver->name = $data->nombre;
            $driver->surname = $data->apellido;
            $driver->dni = $data->documento;
            $driver->email = $data->email;
            $driver->vehicle_id = $data->vehiculo;
            $driver->system_id = $data->sistema;

            // Update
            if($driver->update()){
                echo json_encode(array("message" => "Se ha acualizado chofer seleccionado."));
            }else{
                echo json_encode(array("message" => "No es posible actualizar chofer seleccionado."));
            }
        }

        // Auditoria
        $time = microtime(true) - $start_time;
        $ep = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"] . $_SERVER["REQUEST_METHOD"];
        $Auditoria->audit($Token->decodeToken($data->jwt)["username"], $ep, $time);

        break;

    case "DELETE":
        // Get data
        $data = json_decode(file_get_contents("php://input"));

        // Validate token
        $Token->validateToken($data->jwt);

        // Auditoria
        $start_time = microtime(true);

        // Set id field to be deleted
        $driver->driver_id = $data->id;

        // Delete
        if($data->id != null){
            if($driver->delete()){
                echo json_encode(array("message" => "Se ha eliminado chofer seleccionado."));
            }else{
                echo json_encode(array("message" => "El chofer seleccionado no existe."));
            }
        } else {
            echo json_encode(array("message" => "No es posible eliminar chofer seleccionado. Faltan datos"));
        }
        
        // Auditoria
        $time = microtime(true) - $start_time;
        $ep = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"] . $_SERVER["REQUEST_METHOD"];
        $Auditoria->audit($Token->decodeToken($data->jwt)["username"], $ep, $time);

        break;
}
?>