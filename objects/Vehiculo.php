<?php

Class Vehiculo{
    // Table name and connection instance
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

    // CRUD

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

    private function getVehiculoId(){
        $query = "SELECT LAST_INSERT_ID()";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $res_id = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res_id->last_insert_id;
    }

    public function create(){
        $this->sistema_id = $this->getSistemaId($this->sistema_nombre);
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

    
}