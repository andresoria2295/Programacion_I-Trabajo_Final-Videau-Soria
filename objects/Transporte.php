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
        $query = "SELECT sistema_id, nombre, pais_procedencia FROM " . $this->table_name . " ORDER BY nombre";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>