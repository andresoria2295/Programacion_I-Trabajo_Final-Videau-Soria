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
        
        $stmt_intermediate->bindParam(":created", $this->created);

        // Insertion
        
        if($this->checkSystemExistence()){ // Check if the transportation system exists
            $this->id = $this->connection->lastInsertId(); // If it is inserted correctly. Retrieve the ID of the inserted record and set.
            $stmt_intermediate->bindParam(":vehiculo_id", $this->id);
            try{
                $this->connection->beginTransaction();
                $stmt->execute();
                for($i=0; $i<count($this->sistema_id); $i++){
                    $aux = $this->sistema_id[$i];
                    echo "Sistema: ". $aux;
                    $stmt_intermediate->bindParam(":sistema_id", $aux);
                    $stmt_intermediate->execute();
                }
                if($this->connection->commit()){
                    return true;
                };
            }catch(Exception $e){
                $this->connection->rollBack();
                //echo "Error: " . $e->getMessage();
                return false;
            }
        }else{
            //echo json_encode(array("Message"=>"El ID del sistema especificado no existe"));
            return false;
        }
    }

    public function read(){
        
    }

    public function readAll(){
        
    }

    public function update(){
        $query = "UPDATE ". $this->table_name ." SET marca = :marca, modelo = :modelo, patente = :patente WHERE vehiculo_id = :id";
        $stmt = $this->connection->prepare($query);

        // Sanitize - Security!
        $this->marca=htmlspecialchars(strip_tags($this->marca));
        $this->modelo=htmlspecialchars(strip_tags($this->modelo));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->patente=htmlspecialchars(strip_tags($this->patente));

        // Bind
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":patente", $this->patente);
        $stmt->bindParam(":id", $this->id);

        // Execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete(){
        // Set vehicle ID
        $this->setVehiculoID();

        // Query intermediate
        $query_intermediate = "DELETE FROM ". $this->table2 ." WHERE vehiculo_id=:id";
        $stmt_intermediate = $this->connection->prepare($query_intermediate);
        // Query main
        $query = "DELETE FROM ". $this->table_name ." WHERE vehiculo_id=:id";
        $stmt = $this->connection->prepare($query);
        // Sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->patente=htmlspecialchars(strip_tags($this->patente));
        // Bind
        $stmt_intermediate->bindParam(":id", $this->id);
        $stmt->bindParam(":id", $this->id);
        
        // Execution
        if($stmt_intermediate->execute() && $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}