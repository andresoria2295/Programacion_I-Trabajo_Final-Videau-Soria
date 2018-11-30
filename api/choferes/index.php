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

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$driver = new Chofer($db);

switch($_SERVER["REQUEST_METHOD"]){
    case "POST":
        // Get data
        $data = json_decode(file_get_contents("php://input"));

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

        break;

    case "GET": // NO FUNCIONA
    
        if(isset($_GET["id"])){
            $driver->driver_id = $_GET["id"];
        }else{
            $driver->readAll();
        }
    
        $driver->read();
    
        if($driver->driver_id!=null){
            // Create array
            $driver_array = array(
                "chofer_id"=>$driver->driver_id,
                "nombre"=>$driver->name,
                "apellido"=>$driver->surname,
                "documento"=>$driver->dni,
                "email"=>$driver->email,
                "vehiculo_id"=>$driver->vehicle_id,
                "sistema_id"=>$driver->system_id,
                "created"=>$driver->created,
                "updated"=>$driver->updated
            );
    
            // Send array in JSON format
            print_r($driver_array);
            echo json_encode($driver_array);
        }else{
            // Data does not exist.
            echo json_encode(array("message" => "Chofer no existente."));
        }
        
        break;
        
    case "PUT":
        // Get POSTed data
        $data = json_decode(file_get_contents("php://input"));
        // Set defaults

        //$driver->getData($data->id);

        // Set new property values
        if(isset($data->id)){
            //echo json_encode(array("mensaje"=>"data id isset"));
            $driver->driver_id = $data->id;
            $driver->name = $data->nombre;
            $driver->surname = $data->apellido;
            $driver->dni = $data->documento;
            $driver->email = $data->email;
            $driver->vehicle_id = $data->vehiculo_id;
            $driver->system_id = $data->sistema_id;

            // update the product
            if($driver->update()){
                echo json_encode(array("message" => "Se ha acualizado chofer seleccionado."));
            }else{
                echo json_encode(array("message" => "No es posible actualizar chofer seleccionado."));
            }
        }

        break;
    case "DELETE":
        // Get data
        $data = json_decode(file_get_contents("php://input"));
        // set product id to be deleted
        $driver->driver_id = $data->id;

        // delete the product
        if($data->id != null){
            if($driver->delete()){
                echo json_encode(array("message" => "Se ha eliminado chofer seleccionado."));
            }else{
                echo json_encode(array("message" => "El chofer seleccionado no existe."));
            }
        } else {
            echo json_encode(array("message" => "No es posible eliminar chofer seleccionado. Faltan datos"));
        }
        
        break;
}
?>