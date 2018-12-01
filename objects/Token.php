<?php
include_once "../../libs/jwt/vendor/autoload.php";
use \Firebase\JWT\JWT;

class Token{
    private $key = "my_secret_key";
    private $alg = "HS256";
    
    public $token;

    public function generateToken($data){
        $issuedAt = time();
        $expirationTime = $issuedAt + 30;

        $payload = array(
            "iat" => $issuedAt, // Los campos DEBEN ser llamados "iat" y "exp".
            "exp" => $expirationTime,
            "data" => $data
        );
        
        $this->token = JWT::encode($payload, $this->key, $this->alg); /* Setting the algorithm is optional */
        return $this->token;
    }
    
    public function decodeToken($tkn){
        $data = JWT::decode($tkn, $this->key, array($this->alg))->data;
        return (array) $data;
    }

    public function validateToken($jwt){
        if($jwt){
            try {
                // Decode jwt
                $this->decodeToken($jwt);
                echo json_encode(array("message" => "Access granted."));
                return true;
            }catch (Exception $e){ // If decode fails, it means JWT is invalid
              echo json_encode(array("message" => "Access denied.", "error" => $e->getMessage()));
              //return false;
              exit; // Cambiar exit por return false para hacer auditorías. Si se termina el programa, no puedo hacer auditoría.
            }
        } else { // JWT is empty...
            echo json_encode(array("message" => "Access denied."));
            //return false
            exit; // Cambiar exit por return false para hacer auditorías. Si se termina el programa, no puedo hacer auditoría.
        };
    }
};

?>