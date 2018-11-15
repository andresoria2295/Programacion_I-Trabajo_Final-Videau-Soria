<?php

class Transporte{
    // Connection instance
    private $connection;

    // Table name
    private $table_name = "sistema_transporte";

    // Table columns
    public $id;
    public $nombre;
    public $pais;
    public $createdAt;
    public $updatedAt;

    // Construct
    public function __construct($connection){
        $this->connection = $connection;
    }

    // CRUD operations

    public function readAll(){
        $query = "SELECT sistema_id, nombre, pais_procedencia FROM ". $this->table_name ." ORDER BY nombre";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
        // NOTE: a table name cannot be a bound parameter... That's why I need to concatenate the table name instead
        // of doing something like :tablename and binding that like bindParam(":tablename", $this->table_name);
    }

    public function read(){
        $query = "SELECT sistema_id, nombre, pais_procedencia FROM ". $this->table_name ." WHERE nombre=:sname";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":sname", $this->nombre);
        $stmt->execute();
        
        // Get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Set values to object properties
        $this->nombre = $row['nombre'];
        $this->pais = $row['pais_procedencia'];
        $this->id = $row['sistema_id'];
        $this->createdAt = $row['created'];
        $this->updatedAt = $row['updated'];
    }

    public function create(){
        $query = "INSERT INTO ". $this->table_name ." SET nombre=:nombre, pais_procedencia=:pais, created=:created";
        $stmt = $this->connection->prepare($query);

        // Sanitize - Security!
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->pais=htmlspecialchars(strip_tags($this->pais));
        $this->createdAt=htmlspecialchars(strip_tags($this->createdAt));

        // Bind
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":pais", $this->pais);
        $stmt->bindParam(":created", $this->createdAt);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function update(){
        $query = "UPDATE ". $this->table_name ." SET nombre = :nombre, pais_procedencia = :pais WHERE sistema_id = :id";
        
        $stmt = $this->connection->prepare($query);

        // Sanitize - Security!
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->pais=htmlspecialchars(strip_tags($this->pais));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":pais", $this->pais);
        $stmt->bindParam(":id", $this->id);

        // Execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete(){
        $query = "DELETE FROM ". $this->table_name . " WHERE sistema_id=:id";
        $stmt = $this->connection->prepare($query);
        
        // Sanitize - Security!
        $this->id=htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(":id", $this->id);

        // Execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}

?>