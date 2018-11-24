<?php

class Transporte{
    // Connection instance
    private $connection;

    // Table name
    private $table_name = "sistema_transporte";
    private $table_2 = "sistema_vehiculo";

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

    // Utility functions

    private function deleteCars(){
            $query = "SELECT vehiculo_id FROM vehiculo";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $query2 = "SELECT * FROM sistema_vehiculo WHERE vehiculo_id=:id";
                $stmt2 = $this->connection->prepare($query2);
                $stmt2->bindParam(":id", $row["vehiculo_id"]);
                $stmt2->execute();
                $counter = 0;
                while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                    $counter++;
                }
                if($counter == 0){
                    try{
                        $query3 = "DELETE FROM vehiculo WHERE vehiculo_id=:id";
                        $stmt3 = $this->connection->prepare($query3);
                        $stmt3->bindParam(":id", $row["vehiculo_id"]);
                        $stmt3->execute();
                        
                        break;
                    } catch(Exception $e){
                        echo "Error: " . $e;
                        return false;
                    }
                }
            
            }

        return true;
        // Paso 2: Con cada entrada de vehículo, agarro el vehículo_id y recorro la tabla intermedia. Si no encuentro ningún vehículo_id de la tabla intermedia que coincida con el guardado, borro la fila de la tabla de vehículos.
    }

    // CRUD operations

    public function readAll(){
        $query = "SELECT sistema_id, nombre, pais_procedencia FROM ". $this->table_name ." ORDER BY nombre";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
        // NOTE: a table name cannot be a bound parameter... That's why you need to concatenate the table name instead
        // of doing something like :tablename and binding that like bindParam(":tablename", $this->table_name);
    }

    public function read(){
        $query = "SELECT sistema_id, nombre, pais_procedencia, created, updated FROM ". $this->table_name ." WHERE nombre=:sname";
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

    public function delete(){// Hay que hacer delete de todos los autos que tengan como sistema el que se está borrando
        $query = "DELETE FROM ". $this->table_name . " WHERE sistema_id=:id";
        $query_intermediate = "DELETE FROM ". $this->table_2 ." WHERE sistema_id=:id";

        $stmt = $this->connection->prepare($query);
        $stmt_intermediate = $this->connection->prepare($query_intermediate);

        // Sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(":id", $this->id);
        $stmt_intermediate->bindParam(":id", $this->id);

        // Execute query
        if($stmt_intermediate->execute() && $stmt->execute()){
            if($this->deleteCars()){
                return true;
            }
        }else{
            return false;
        }
    }
}

?>