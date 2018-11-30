<?php

class Usuario{
    // database connection and table name
    private $conn;
    private $table_name = "users";

    // properties
    public $id;
    public $username;
    public $password;
    public $created;
    public $updated;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // Create

    public function create(){
        // Query
        $query = "INSERT INTO ". $this->table_name ." SET username=:username, password=:password, created=:created";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->username=strip_tags($this->username);
        $this->password=strip_tags($this->password);
        $this->created=strip_tags($this->created);

        // Bind
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':created', $this->created);

        // Password hashing
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // check if given email exist in the database
    
    public function getHash(){
        // Query
        $query = "SELECT password FROM " . $this->table_name . " WHERE username = :usr LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

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