<?php
include_once "..\users\validate_token.php";

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../../config/Database.php';
include_once '../../objects/Transporte.php';

// Instantiate database object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$transport = new Transporte($db);

switch($_SERVER["REQUEST_METHOD"]){
    case "POST":
        // Get POSTed data
        $data = json_decode(file_get_contents("php://input"));

        // Make sure data is not empty
        if( !empty($data->nombre) && !empty($data->pais_procedencia)){
        // Set property values
        $transport->nombre = $data->nombre;
        $transport->pais = $data->pais_procedencia;
        $transport->createdAt = date('Y-m-d H:i:s');
        // Create
            if($transport->create()){
                echo json_encode(array("message" => "Se creó el servicio de transporte."));
            } else {
                echo json_encode(array("message" => "No se pudo crear el servicio."));
            }
        } else {
            // Data incomplete
            echo json_encode(array("message" => "No se pudo crear el servicio. Faltan datos."));
        }
        
        break;
    
    case "GET":
        if(isset($_GET["nombre"])){
            $transport->nombre = $_GET["nombre"];

            $transport->read();
    
            if($transport->nombre!=null){
                // Create array
                $transportArray = array(
                    "nombre"=>$transport->nombre,
                    "pais_procedencia"=>$transport->pais,
                    "sistema_id"=>$transport->id,
                    "created"=>$transport->createdAt,
                    "updated"=>$transport->updatedAt
                );
                
                // Send array in JSON format
                echo json_encode($transportArray);
            }else{
                // Data does not exist.
                echo json_encode(array("message" => "El servicio de transporte no existe."));
            };

        }else{
            
            // READ ALL
            // Query
            $stmt = $transport->readAll(); // returns statement.
            $num = $stmt->rowCount();

            // Are there records?
            if($num>0){
                $transportArray = array();
                $transportArray["records"] = array();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    // Extract row... This will make $row["name"] to just $name
                    extract($row);
                    $transport_item = array(
                        "id"=>$sistema_id,
                        "nombre"=>$nombre,
                        "pais"=>$pais_procedencia,
                        "created"=>$created,
                        "updated"=>$updated
                    );
                    // Push record found to array
                    array_push($transportArray["records"], $transport_item);
                }
                // Echo array in JSON format
                echo json_encode($transportArray);
            } else {
                echo json_encode(
                    array("message" => "No hay sistemas de transporte guardados.")
                );
            }
        }
        
        break;
    
    case "PUT":
        // Get data
        $data = json_decode(file_get_contents("php://input"));
        // Set property values
        $transport->id = $data->id;
        $transport->nombre = $data->nombre;
        $transport->pais = $data->pais_procedencia;

        // update the product
        if($transport->update()){
            echo json_encode(array("message" => "El sistema de transporte fue modificado."));
        }else{
            echo json_encode(array("message" => "No se pudo modificar el sistema de transporte."));
        }

        break;

    case "DELETE":
        // Get data
        $data = json_decode(file_get_contents("php://input"));
        
        // delete the product
        if($data->id != null){
            // set product id to be deleted
            $transport->id = $data->id;
            
            if($transport->delete()){
                echo json_encode(array("message" => "Sistema de transporte eliminado."));
            }else{
                echo json_encode(array("message" => "No se pudo eliminar el sistema de transporte."));
            }
        } else {
            echo json_encode(array("message" => "Faltan datos"));
        }

        break;
}

?>