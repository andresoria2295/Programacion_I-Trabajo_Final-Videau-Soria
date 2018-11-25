<?php

Class Vehiculo{
    // Table name and connection instance
    private $connection;
    private $table_name = "vehiculo";

    // Properties
    public $vehicle_id;
    public $patent;
    public $patent_date;
    public $fabrication_date;
    public $brand;
    public $model;
    public $created;
    public $updated;

    // Construct
    public function __construct($connection){
        $this->connection = $connection;
    }

    // CRUD
    /*
    public function getVehiculoId($argmarca){
        $query = "SELECT vehiculo_id FROM vehiculo WHERE marca=:mar";
        $statement = $this->connection->prepare($query);
        // Sanitize
        $brand=htmlspecialchars(strip_tags($argmarca));
        // Bind
        $statement->bindParam(":mar", $brand);
        if($statement->execute()){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $this->vehicle_id = $data["vehiculo_id"];
            //print_r($data);
            return true;
        }else{
            return false;
        }
    }
    */

    // CRUD operations

    public function readAll(){
        $query = "SELECT vehiculo_id, patente, anho_patente, anho_fabricacion, marca, modelo FROM ". $this->table_name ." ORDER BY marca";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read(){
        $query = "SELECT vehiculo_id, patente, anho_patente, anho_fabricacion, marca, modelo FROM ". $this->table_name ." WHERE marca=:smarca";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":snmarca", $this->brand);
        $stmt->execute();

        // Get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set values to object properties
        $this->vehicle_id = $row['vehiculo_id'];
        $this->patent = $row['patente'];
        $this->patent_date = $row['anho_patente'];
        $this->fabrication_date = $row['anho_fabricacion'];
        $this->brand = $row['marca'];
        $this->model = $row['modelo'];
        $this->created = $row['created'];
        $this->updated = $row['updated'];
    }

    public function create(){
        $query = "INSERT INTO ". $this->table_name ." SET patente=:pat, anho_patente=:anho_pat, anho_fabricacion=:anho_fab, marca=:mar, modelo=:mod, created=:created";
        $stmt = $this->connection->prepare($query);

        // Sanitize - Security
        $this->patent=htmlspecialchars(strip_tags($this->patent));
        $this->patent_date=htmlspecialchars(strip_tags($this->patent_date));
        $this->fabrication_date=htmlspecialchars(strip_tags($this->fabrication_date));
        $this->brand=htmlspecialchars(strip_tags($this->brand));
        $this->model=htmlspecialchars(strip_tags($this->model));
        $this->created=htmlspecialchars(strip_tags($this->created));

        // Bind
        $stmt->bindParam(":pat", $this->patent);
        $stmt->bindParam(":anho_pat", $this->patent_date);
        $stmt->bindParam(":anho_fab", $this->fabrication_date);
        $stmt->bindParam(":mar", $this->brand);
        $stmt->bindParam(":mod", $this->model);
        $stmt->bindParam(":created", $this->created);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function update(){
        $query = "UPDATE ". $this->table_name ." SET patente=:pat, anho_patente=:anho_pat, anho_fabricacion=:anho_fab, marca=:mar, modelo=:mod WHERE vehiculo_id = :id";

        $stmt = $this->connection->prepare($query);

        // Sanitize - Security
        $this->patent=htmlspecialchars(strip_tags($this->patent));
        $this->patent_date=htmlspecialchars(strip_tags($this->patent_date));
        $this->fabrication_date=htmlspecialchars(strip_tags($this->fabrication_date));
        $this->brand=htmlspecialchars(strip_tags($this->brand));
        $this->model=htmlspecialchars(strip_tags($this->model));
        $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));

        // Bind
        $stmt->bindParam(":pat", $this->patent);
        $stmt->bindParam(":anho_pat", $this->patent_date);
        $stmt->bindParam(":anho_fab", $this->fabrication_date);
        $stmt->bindParam(":mar", $this->brand);
        $stmt->bindParam(":mod", $this->model);
        $stmt->bindParam(":id", $this->vehicle_id);

        // Execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete(){
        $query = "DELETE FROM ". $this->table_name . " WHERE vehiculo_id=:id";
        $stmt = $this->connection->prepare($query);

        // Sanitize - Security
        $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));

        // Bind
        $stmt->bindParam(":id", $this->vehicle_id;

        // Execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}
