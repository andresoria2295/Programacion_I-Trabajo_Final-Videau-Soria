<?php

class Auditoria{
    // Database parameters
    private $connection;
    private $table_name = "auditoria";

    // Properties
    public $id;
    public $fecha_acceso;
    public $user;
    public $response_time;
    public $endpoint;
    public $created;

    // Constructor

    public function __construct($db){
        $this->connection = $db;
    }

    public function audit($user, $url, $rt){
        $query = "INSERT INTO ". $this->table_name ." SET fecha_acceso = :fecha_acceso, user = :user, response_time = :response_time, endpoint = :endpoint";
        $stmt = $this->connection->prepare($query);

        $this->fecha_acceso = date('Y-m-d H:i:s');
        $this->user = $user;
        $this->endpoint = $url;
        $this->response_time = $rt;

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->fecha_acceso = htmlspecialchars(strip_tags($this->fecha_acceso));
        $this->user = htmlspecialchars(strip_tags($this->user));
        $this->response_time = htmlspecialchars(strip_tags($this->response_time));
        $this->endpoint = htmlspecialchars(strip_tags($this->endpoint));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // Bind
        $stmt->bindParam(":fecha_acceso", $this->fecha_acceso);
        $stmt->bindParam(":user", $this->user);
        $stmt->bindParam(":response_time", $this->response_time);
        $stmt->bindParam(":endpoint", $this->endpoint);

        // Execute
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}

?>