<?php

class Usuario{
    // database connection and table name
    private $connection;
    private $table_name = "users";

    // properties
    public $id;
    public $username;
    public $password;
    public $role;
    public $created;
    public $updated;

    // constructor
    public function __construct($db){
        $this->connection = $db;
    }

    // Create

    public function create(){
        // Query
        $query = "INSERT INTO ". $this->table_name ." SET username=:username, password=:password, created=:created, rol=:role";
        $stmt = $this->connection->prepare($query);

        // Sanitize
        $this->username=strip_tags($this->username);
        $this->password=strip_tags($this->password);
        $this->created=strip_tags($this->created);
        $this->role=strip_tags($this->role);

        // Bind
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':created', $this->created);
        $stmt->bindParam(":role", $this->role);

        // Password hashing
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        // execute the query, also check if query was successful
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    public function update(){
        $query = "UPDATE ". $this->table_name ." SET username = :username WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(':user_id', $this->id);
        $stmt->bindParam(":username", $this->username);

        $stmt->execute();
    }

    public function delete(){
        // Query
        $query = "DELETE FROM ". $this->table_name ." WHERE username=:username";
        $stmt = $this->connection->prepare($query);

        // Sanitize and bind
        $this->username=strip_tags($this->username);
        $stmt->bindParam(':username', $this->username);

        // Execute
        try{
            $this->connection->beginTransaction();
            $stmt->execute();
            if($this->connection->commit()){
                return true;
            }
        }catch(Exception $e){
            $this->connection->rollBack();
            return false;
        }

        /*
        if($stmt->execute()){
            return true;
        }else{
            return false;
        };*/
    }

    public function getHash(){
        // Query
        $query = "SELECT password FROM " . $this->table_name . " WHERE username = :usr LIMIT 0,1";
        $stmt = $this->connection->prepare($query);

        // Sanitize
        $this->username = strip_tags($this->username);

        // Bind
        $stmt->bindParam(":usr", $this->username);

        // Execute
        $stmt->execute();

        // Assign data to object properties
        if($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["password"];
        }
    }

}