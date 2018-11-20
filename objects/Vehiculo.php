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
    public $sistema_id;
    public $created;
    public $updated;

    // Construct
    public function __construct($db){
        $this->connection = $db;
    }

    // Utility functions
    private function getSistemaId($argnombre){
        $query = "SELECT sistema_id FROM sistema_transporte WHERE nombre=:nombre";
        $statement = $this->connection->prepare($query);
        // Sanitize
        $nombre=htmlspecialchars(strip_tags($argnombre));
        // Bind
        $statement->bindParam(":nombre", $nombre);
        if($statement->execute()){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            return $data["sistema_id"];
        }else{
            return 0;
        }
    }

    // CRUD

    public function create(){
        //$this->sistema_id = $this->getSistemaId($this->sistema_nombre); Si quisiera poner el nombre en vez del id del sistema
        // Query - main
        $query = "INSERT INTO ". $this->table_name ." SET marca=:marca, modelo=:modelo, patente=:patente, created=:created";
        $stmt = $this->connection->prepare($query);

        // Query - intermedia
        $query_intermediate = "INSERT INTO ". $this->table2 ." SET vehiculo_id=:vehiculo_id, sistema_id=:sistema_id, created=:created";
        $stmt_intermediate = $this->connection->prepare($query_intermediate);

        // Bind parameters for main table
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":patente", $this->patente);
        $stmt->bindParam(":created", $this->created);
        
        // Bind parameters for intermediate table
        $stmt_intermediate->bindParam(":vehiculo_id", $this->id);
        $stmt_intermediate->bindParam(":sistema_id", $this->sistema_id);
        $stmt_intermediate->bindParam(":created", $this->created);

        // Insert into main table
       
        if($stmt->execute()){
            // If it is inserted correctly. Retrieve the ID of the inserted record and set.
            $this->id = $this->connection->lastInsertId();
            if($stmt_intermediate->execute()){ // Insert record into intermediate table.
                return true;
            }else{
                return false;
            }
        }
    }

    // Hace una funcion para leer por patente y otra para leer por id
    public function read(){
         // Paso 1: Con la patente saco el id del vehiuclo de la tabla vehículo
        $query1 = "SELECT vehiculo_id FROM vehiculo WHERE patente=:patente";
        $stmt = $this->connection->prepare($query1);
        $stmt->bindParam(":patente", $this->patente);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $result["vehiculo_id"];
        
        echo "Vehiculo id del paso 1: " . $this->id . "      ";

        // Paso 2: De la tabla intermedia saco el id del sistema
        $query2 = "SELECT sistema_id FROM sistema_vehiculo WHERE vehiculo_id=:vehiculo_id";
        $stmt2 = $this->connection->prepare($query2);
        $stmt2->bindParam(":vehiculo_id", $this->id);
        $stmt2->execute();

        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $this->sistema_id = $result2["sistema_id"];

        echo "Sistema_id del paso 2: " . $this->sistema_id;

        // Paso 3: Con el id del sistema y el id del vehiculo hago un left join de las tablas de vehiculo y sistema
        $query3 = "SELECT s.nombre, v.marca, v.modelo, v.patente, v.created, v.updated FROM ". $this->table_name ." 
        v LEFT JOIN sistema_transporte s on s.sistema_id = :sid";
        $stmt3 = $this->connection->prepare($query3);
        $stmt3->bindParam(":sid", $this->sistema_id);
        $stmt3->execute();
        
        // Get retrieved row
        $row = $stmt3->fetch(PDO::FETCH_ASSOC);

         // Set values to object properties
         $this->marca = $row['marca'];
         $this->modelo = $row['modelo'];
         $this->patente = $row["patente"];
         $this->sistema_nombre = $row["nombre"];
         $this->created = $row['created']; 
         $this->updated = $row["updated"];
    }

    public function readAll(){

    }

    public function update(){

    }

    public function delete(){  
        // Query intermediate
        $query_intermediate = "DELETE FROM ". $this->table2." WHERE vehiculo_id=:id";
        $stmt_intermediate = $connection->prepare($query_intermediate);
       
        // Query main
        $query = "DELETE FROM ". $this->table_name ." WHERE vehiculo_id=:id";
        $stmt = $connection->prepare($query);

        // Bind parameters
        $stmt_intermediate->bindParam(":id", $this->id);
        $stmt->bindParam(":id", $this->id);

        // Delete from intermediate table
        if($stmt_intermediate->execute() && $stmt->execute()){
            return true;
        } else {
            return false;
        }
        // TESTEAR
    }

    
}