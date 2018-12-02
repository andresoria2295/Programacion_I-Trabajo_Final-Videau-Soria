<?php
include_once "..\users\validate_token.php";

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

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$vehicle = new Vehiculo($db);

switch($_SERVER["REQUEST_METHOD"]){
    case "POST":
        // Get POSTed data
        $data = json_decode(file_get_contents("php://input"));

        // Make sure data is not empty
        if(!empty($data->marca) && !empty($data->modelo) && !empty($data->patente) && !empty($data->sistema)){
            // Setting object properties
            $vehicle->marca = $data->marca;
            $vehicle->modelo = $data->modelo;
            $vehicle->patente = $data->patente;
            //$vehicle->sistema_nombre = $data->sistema; Si quisiera poner el nombre en vez del id del sistema
            $vehicle->sistema_id = $data->sistema;
            $vehicle->created = date('Y-m-d H:i:s');
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
        if(isset($_GET["patente"])){
            $vehicle->patente = $_GET["patente"];
            $vehicle->read();
    
            if($vehicle->marca!=null && $vehicle->modelo != null){
            // Create array
            $vehicleArray = array(
                "marca"=>$vehicle->marca,
                "modelo"=>$vehicle->modelo,
                "patente"=>$vehicle->patente,
                "created"=>$vehicle->created,
                "updated"=>$vehicle->updated,
                "sistema"=>$vehicle->sistema_nombre
            );
            
            // Send array in JSON format
            echo json_encode($vehicleArray);
        }else{
            // Data does not exist.
            echo json_encode(array("message" => "El servicio de transporte no existe."));
        }
        }else{
            $data = $vehicle->readAll();
            $records_array = array();
            for($i=0; $i<count($data); $i++){
                array_push($records_array, $data[$i]);
            }
            echo json_encode(Array("data"=>$records_array));
        }
    
        
        
        break;

    case "PUT":
        // Get POSTed data
        $data = json_decode(file_get_contents("php://input"));

        print_r($data);
        $vehicle->marca = $data->marca;
        $vehicle->modelo = $data->modelo;
        $vehicle->patente = $data->patente;
        $vehicle->id = $data->id;

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