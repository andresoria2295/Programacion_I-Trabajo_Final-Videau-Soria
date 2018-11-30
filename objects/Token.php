<?php
include_once "../../libs/jwt/vendor/autoload.php";
use \Firebase\JWT\JWT;

class Token{
    private $key = "my_secret_key";
    private $alg = "HS256";
    
    public $token;

    public function generateToken($data){
        $issuedAt = time();
        $expirationTime = $issuedAt + 60;

        $payload = array(
            "issued" => $issuedAt,
            "expiration" => $expirationTime,
            "data" => $data
        );
        
        $this->token = JWT::encode($payload, $this->key, $this->alg); /* Setting the algorithm is optional */
        return $this->token;
    }
    
    public function decodeToken($tkn){
        $data = JWT::decode($tkn, $this->key, array($this->alg))->data;
        return (array) $data;
    }

    //public function validateToken($got);
};

?>