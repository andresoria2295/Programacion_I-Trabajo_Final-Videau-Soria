<?php
class Auditoria{

    private $connection;
    private $table = "auditoria";

    public $id;
    public $access_date;
    public $user;
    public $response_time;
    public $consumed_url;

    public function __construct($db){
        $this->connection = $db;
        // $this->access_date = date('Y-m-d H:i:s');
        // $this->response_time = $this->pingDomain($_SERVER["REQUEST_URI"]);
        // $this->consumed_url = $_SERVER["REQUEST_URI"];
    }
    // check responsetime for a webbserver
    private function pingDomain($domain){
        $starttime = microtime(true);
        // supress error messages with @
        $file      = @fsockopen($domain, 80, $errno, $errstr, 10);
        $stoptime  = microtime(true);
        $status    = 0;
        if(!$file){
            $status = -1;  // Site is down
        }else{
            fclose($file);
            $status = ($stoptime - $starttime) * 1000;
            $status = floor($status);
        }
        return $status;
    }
    public function Audit(){
        $this->access_date = date('Y-m-d H:i:s');
        $this->response_time = $this->pingDomain($_SERVER["REQUEST_URI"]);
        $this->consumed_url = $_SERVER["REQUEST_URI"];
        $this->user = "";
        // Set values
        $query = "INSERT INTO ". $this->table ." SET fecha_acceso=:fecha, user=:user, response_time=:rp, endpoint=:url";
        $stmt = $this->connection->prepare($query);
        // Bind
        $stmt->bindParam(":fecha", $this->access_date);
        $stmt->bindParam(":user", $this->user);
        $stmt->bindParam(":rp", $this->response_time);
        $stmt->bindParam(":endpoint", $this->consumed_url);
        // Execute
        if($stmt->execute()){
            return true;
        }else{
            return false;
        };
    }

}
?>
