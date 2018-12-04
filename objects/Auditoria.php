<?php

class Auditoria{
    // Database parameters
    private $connection;
    private $table_name = "auditoria";
    private $audit_dir = "/proyecto/audit/";

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

    public function exportAudit($fecha1, $fecha2){
        // Query and stmt
        $query = "SELECT auditoria_id, fecha_acceso, user, response_time, created from auditoria where fecha_acceso between :f1 and :f2";
        $stmt = $this->connection->prepare($query);

        // Sanitize
        $fecha1= htmlspecialchars(strip_tags($fecha1));
        $fecha2 = htmlspecialchars(strip_tags($fecha2));

        // Bind
        $stmt->bindParam(":f1", $fecha1);
        $stmt->bindParam(":f2", $fecha2);

        // Execute
        $stmt->execute();

        if (!file_exists($this->audit_dir)) {
            //si lo que esta en $carpeta no existe se hace lo siguiente
            if (mkdir($this->audit_dir, 0777, true));
            //se crea lo que esta en $carpeta con los permisos 0777
        };
        
        $algo = $_SERVER["DOCUMENT_ROOT"] . $this->audit_dir;
        // Open file
        $file = fopen($algo. "audit.txt", "w");
       
        // Fetch
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $str = $row["auditoria_id"] . " " . $row["fecha_acceso"] . " " . $row["user"] . " " . $row["response_time"] . " " . $row["created"] . "," . PHP_EOL;
            fwrite($file, $str);
        }

        // Close file
        fclose($file);
    }

}

?>