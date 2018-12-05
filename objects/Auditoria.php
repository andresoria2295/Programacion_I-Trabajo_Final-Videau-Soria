<?php

class Auditoria{
    // Database parameters
    private $connection;
    private $table_name = "auditoria";
    public $audit_dir = "/audit";

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

    /*public function exportAudit($fecha1, $fecha2){
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

        $algo = $_SERVER["DOCUMENT_ROOT"] . $this->audit_dir;

        if (!file_exists($algo)) {
            //si lo que esta en $carpeta no existe se hace lo siguiente
            if (mkdir($algo, 0777, true));
            //se crea lo que esta en $carpeta con los permisos 0777
        };
        
        
        // Open file
        $file = fopen($algo. "/audit.txt", "w");
       
        // Fetch
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $str = $row["auditoria_id"] . " " . $row["fecha_acceso"] . " " . $row["user"] . " " . $row["response_time"] . " " . $row["created"] . "," . PHP_EOL;
            fwrite($file, $str);
        }

        // Close file
        fclose($file);
    }*/

    function exportAudit($fecha1, $fecha2){
    
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
    
        // Create temp file
        $tmpName = tempnam(sys_get_temp_dir(), 'data'); // Gets temp directory
        $file = fopen($tmpName, 'w'); // Creates file in temp directory
    
        // Writes on temp file
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $str = $row["auditoria_id"] . " " . $row["fecha_acceso"] . " " . $row["user"] . " " . $row["response_time"] . " " . $row["created"] . "," . PHP_EOL;
            echo $str;
            fwrite($file, $str);
        }
    
        // Headers to download file
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=audits.txt');
        header('Content-Length: ' . filesize($tmpName));
    
        ob_clean(); // This function discards the contents of the output buffer.
        flush(); // Flushes the system write buffers of PHP and whatever backend PHP is using (CGI, a web server, etc). 
        readfile($tmpName);
    }
}

?>