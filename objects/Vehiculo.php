<?php

Class Vehiculo{
    // Required table names and connection instance
    private $connection;
    private $table_name = "vehiculo";
    private $table2 = "sistema_vehiculo";

    // Properties
    public $id;
    public $marca;
    public $modelo;
    public $patente;
    public $sistema_nombre;
    public $sistema_id = [];
    public $created;
    public $updated;
    public $anho_fabricacion;
    public $anho_patente;

    // Construct
    public function __construct($db){
        $this->connection = $db;
    }

    // Utility functions
    private function setVehiculoID(){
        $query1 = "SELECT vehiculo_id FROM vehiculo WHERE patente=:patente";
        $stmt = $this->connection->prepare($query1);
        $stmt->bindParam(":patente", $this->patente);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $result["vehiculo_id"];
            return true;
        }else{
            return false;
        }
    }

    private function checkSystemExistence(){
        $query = "SELECT * FROM sistema_transporte WHERE sistema_id=:id";
        $stmt = $this->connection->prepare($query);
        for($i=0; $i<count($this->sistema_id); $i++){
            $this->sistema_id[$i]=htmlspecialchars(strip_tags($this->sistema_id[$i]));
            $aux = $this->sistema_id[$i];
            $stmt->bindParam(":id", $this->sistema_id[$i]);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                echo json_encode(Array("Message" => "Alguno de los sistemas de transporte no existe"));
                return false;
            }else{
                break;
            }
        }
        return true;
    }

    // CRUD

    public function create(){
        //$this->sistema_id = $this->getSistemaId($this->sistema_nombre); Si quisiera poner el nombre en vez del id del sistema
        // Query - main
        $query = "INSERT INTO ". $this->table_name ." SET marca=:marca, modelo=:modelo, patente=:patente, anho_patente=:anho_patente, anho_fabricacion=:anho_fabricacion, created=:created";
        $stmt = $this->connection->prepare($query);

        // Query - intermedia
        $query_intermediate = "INSERT INTO ". $this->table2 ." SET vehiculo_id=:vehiculo_id, sistema_id=:sistema_id, created=:created";
        $stmt_intermediate = $this->connection->prepare($query_intermediate);

        // Bind parameters for main table
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":patente", $this->patente);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":anho_fabricacion", $this->anho_fabricacion);
        $stmt->bindParam(":anho_patente", $this->anho_patente);
        
        // Bind parameters for intermediate table
        
        $stmt_intermediate->bindParam(":created", $this->created);

        // Insert into main table
        
        if($this->checkSystemExistence()){ // Check if the transportation system exists
            $stmt_intermediate->bindParam(":vehiculo_id", $this->id);
            try{
                $this->connection->beginTransaction();
                $stmt->execute();
                $this->id = $this->connection->lastInsertId(); // If it is inserted correctly. Retrieve the ID of the inserted record and set.
                for($i=0; $i<count($this->sistema_id); $i++){
                    $aux = $this->sistema_id[$i];
                    $stmt_intermediate->bindParam(":sistema_id", $aux);
                    $stmt_intermediate->execute();
                }
                if($this->connection->commit()){
                    return true;
                };
            }catch(Exception $e){
                $this->connection->rollBack();
                echo json_encode(Array("Error" => $e->getMessage()));
                return false;
            }
        }else{
            echo json_encode(array("Message"=>"El ID del sistema especificado no existe"));
            return false;
        }
    }

    // Hace una funcion para leer por patente y otra para leer por id

    private function sys_names(){
        $this->setVehiculoID();
        $query = "SELECT sistema_transporte.nombre FROM sistema_vehiculo LEFT JOIN sistema_transporte ON sistema_vehiculo.sistema_id = sistema_transporte.sistema_id WHERE sistema_vehiculo.vehiculo_id=:vid";
        $stmt = $this->connection->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":vid", $this->id);
        $stmt->execute();
        $names_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($names_array, $row["nombre"]);
        }

        return json_encode($names_array);
    }

    public function read(){
        $this->setVehiculoID();
        //echo $this->id;
        $query = "SELECT marca, modelo, patente, anho_fabricacion as fabricado, anho_patente as fecha_patente FROM vehiculo WHERE vehiculo_id=:vehiculo_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":vehiculo_id", $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $arr = ["marca"=>$row["marca"], "modelo"=>$row["modelo"], "patente"=>$row["patente"], "fabricado"=>$row["fabricado"], "fecha_patente"=>$row["fecha_patente"], "sistemas" => $this->sys_names()];
        echo json_encode($arr);
    }

    public function readAll(){
        $def = [];
        $query = "SELECT marca, modelo, patente, anho_fabricacion as fabricado, anho_patente as fecha_patente FROM vehiculo";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":vehiculo_id", $this->id);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $this->id = $row["vehiculo_id"];
            $arr = ["marca"=>$row["marca"], "modelo"=>$row["modelo"], "patente"=>$row["patente"], "fabricado"=>$row["fabricado"], "fecha_patente"=>$row["fecha_patente"], "sistemas" => $this->sys_names()];
            array_push($def,$arr);
        };

        echo json_encode(array("data"=>$def));
    }

    public function update(){
        $query = "UPDATE ". $this->table_name ." SET marca = :marca, modelo = :modelo, patente = :patente, anho_fabricacion = :anho_fabricacion, anho_patente = :anho_patente WHERE vehiculo_id = :id";
        $stmt = $this->connection->prepare($query);

        $query2 = "DELETE FROM sistema_vehiculo WHERE vehiculo_id = :id";
        $stmt2 = $this->connection->prepare($query2);

        $query_intermediate = "INSERT INTO sistema_vehiculo SET vehiculo_id=:vehiculo_id, sistema_id=:sistema_id, created=:created";
        $stmt_intermediate = $this->connection->prepare($query_intermediate);

        // Sanitize - Security!
        $this->marca=htmlspecialchars(strip_tags($this->marca));
        $this->modelo=htmlspecialchars(strip_tags($this->modelo));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->patente=htmlspecialchars(strip_tags($this->patente));
        $this->anho_fabricacion=htmlspecialchars(strip_tags($this->anho_fabricacion));
        $this->anho_patente=htmlspecialchars(strip_tags($this->anho_patente));
        $this->created = 
    
        // Bind
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":patente", $this->patente);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":anho_fabricacion", $this->anho_fabricacion);
        $stmt->bindParam(":anho_patente", $this->anho_patente);
        $stmt2->bindParam(":id", $this->id);
        
        // Execute query

        if($this->checkSystemExistence()){ // Check if the transportation system exists
            
            try{
                $this->connection->beginTransaction();
                $stmt->execute();
                $stmt2->execute();
                $stmt_intermediate->bindParam(":vehiculo_id", $this->id);
                $stmt_intermediate->bindParam(":created", $this->created);
                for($i=0; $i<count($this->sistema_id); $i++){
                    $aux = $this->sistema_id[$i];
                    $stmt_intermediate->bindParam(":sistema_id", $aux);
                    $stmt_intermediate->execute();
                };
                if($this->connection->commit()){
                    return true;
                };
            }catch(Exception $e){
                $this->connection->rollBack();
                echo json_encode(Array("Error" => $e->getMessage()));
                return false;
            }
        }else{
            echo json_encode(array("Message"=>"El ID del sistema especificado no existe"));
            return false;
        }
    }

    public function delete(){
        // Set vehicle ID
        $this->setVehiculoID();

        // Query intermediate
        $query_intermediate = "DELETE FROM ". $this->table2 ." WHERE vehiculo_id=:id";
        $stmt_intermediate = $this->connection->prepare($query_intermediate);
        // Query chofer
        $query_chofer = "DELETE FROM chofer WHERE vehiculo_id=:id";
        $stmt_chofer = $this->connection->prepare($query_chofer);
        // Query main
        $query = "DELETE FROM ". $this->table_name ." WHERE vehiculo_id=:id";
        $stmt = $this->connection->prepare($query);
        // Sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->patente=htmlspecialchars(strip_tags($this->patente));
        // Bind
        $stmt_intermediate->bindParam(":id", $this->id);
        $stmt_chofer->bindParam(":id", $this->id);
        $stmt->bindParam(":id", $this->id);
        
        // Execution
        try{
            $this->connection->beginTransaction();
            $stmt_intermediate->execute();
            $stmt_chofer->execute();
            $stmt->execute();
            if($this->connection->commit()){
                return true;
            }
        }catch(Exception $e){
            $this->connection->rollBack();
            echo json_encode(array("Error"=>$e));
            return false;
        }
        
    }

}