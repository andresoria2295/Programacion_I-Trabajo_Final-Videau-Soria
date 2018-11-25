<?php
Class Chofer{
    // Database connection and table name
    private $connection;
    private $table_name = "chofer";

    // Object propierties
    public $driver_id;
    public $name;
    public $surname;
    public $dni;
    public $email;
    public $vehicle_id;
    public $system_id;
    public $created;
    public $updated;

    // Construct with database connection
    public function __construct($connection){
        $this->connection = $connection;
    }

    // CRUD
    /*
    public function getSistemaId($argapellido){
        $query = "SELECT sistema_id FROM chofer WHERE apellido=:ape";
        $statement = $this->connection->prepare($query);
        // Sanitize
        $surname=htmlspecialchars(strip_tags($argapellido));
        // Bind
        $statement->bindParam(":ape", $surname);
        if($statement->execute()){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $this->system_id = $data["sistema_id"];
            //print_r($data);
            return true;
        }else{
            return false;
        }
    }
    */

    // CRUD operations

    public function readAll(){
        $query = "SELECT * FROM ". $this->table_name ." ORDER BY nombre";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read(){
        $query = "SELECT chofer_id, nombre, apellido, documento, email, vehiculo_id, sistema_id FROM ". $this->table_name ." WHERE apellido=:apellido";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":apellido", $this->surname);
        $stmt->execute();

        // Get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set values to object properties
        $this->driver_id = $row['chofer_id'];
        $this->name = $row['nombre'];
        $this->surname = $row['apellido'];
        $this->dni = $row['documento'];
        $this->email = $row['email'];
        $this->vehicle_id = $row['vehiculo_id'];
        $this->system_id = $row['sistema_id'];
        $this->created = $row['created'];
        $this->updated = $row['updated'];
    }

    public function create(){
        $query = "INSERT INTO chofer SET nombre=:nombre, apellido=:apellido, documento=:documento, email=:email, vehiculo_id=:vid, sistema_id=:sid, created=:created";
        $stmt = $this->connection->prepare($query);
        // Sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->surname=htmlspecialchars(strip_tags($this->surname));
        $this->dni=htmlspecialchars(strip_tags($this->dni));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->system_id=htmlspecialchars(strip_tags($this->system_id));
        $this->vehicle_id = htmlspecialchars(strip_tags($this->vehicle_id));
        // Bind
        $stmt->bindParam(":nombre", $this->name);
        $stmt->bindParam(":apellido", $this->surname);
        $stmt->bindParam(":dni", $this->dni);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":vid", $this->vehicle_id);
        $stmt->bindParam(":sid", $this->system_id);
        // Execution
        if($stmt->execute()){
            echo json_encode(Array("Works"=>"works"));
            return true;
        }else{
            echo json_encode(Array("Works"=>"Nope"));
            return false;
        }
    }

    public function update(){
        $query = "UPDATE ". $this->table_name ." SET nombre = :nom, apellido = :ape, documento = :doc, email = :mail WHERE sistema_id = :id";

        $stmt = $this->connection->prepare($query);

        // Sanitize - Security
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->surname=htmlspecialchars(strip_tags($this->surname));
        $this->dni=htmlspecialchars(strip_tags($this->dni));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->system_id=htmlspecialchars(strip_tags($this->system_id));

        // Bind
        $stmt->bindParam(":nom", $this->name);
        $stmt->bindParam(":ape", $this->surname);
        $stmt->bindParam(":doc", $this->dni);
        $stmt->bindParam(":mail", $this->email);
        $stmt->bindParam(":id", $this->system_id);

        // Execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete(){
        $query = "DELETE FROM ". $this->table_name . " WHERE chofer_id=:id";
        $stmt = $this->connection->prepare($query);

        // Sanitize - Security
        $this->system_id=htmlspecialchars(strip_tags($this->driver_id));

        // Bind
        $stmt->bindParam(":id", $this->driver_id);

        // Execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}
?>
