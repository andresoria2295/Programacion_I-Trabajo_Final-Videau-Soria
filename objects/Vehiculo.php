<?php

Class Vehiculo{
    // Table name and connection instance
    private $connection;
    private $table_name = "vehiculo";

    // Properties
    public $id;
    public $marca;
    public $modelo;
    public $patente;
    public $sistema_id;
    public $created;
    public $updated;

    // Construct
    public function __construct($db){
        $this->connection = $db;
    }

    // CRUD

    public function getSistemaId($argnombre){
        $query = "SELECT sistema_id FROM sistema_transporte WHERE nombre=:nombre";
        $statement = $this->connection->prepare($query);
        // Sanitize
        $nombre=htmlspecialchars(strip_tags($argnombre));
        // Bind
        $statement->bindParam(":nombre", $nombre);
        if($statement->execute()){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $this->sistema_id = $data["sistema_id"];
            //print_r($data);
            return true;
        }else{
            return false;
        }
    }
}