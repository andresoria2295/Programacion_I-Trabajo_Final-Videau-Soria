<?php
// 'user' object
class User{
    // database connection and table name
    private $conn;
    private $table_name = "users";
    // object properties
    public $user_id;
    public $username;
    public $password;
    public $created;
    public $updated;
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
    // create new user record
    function create(){
        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password, created=:created";
        // prepare the query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->username=strip_tags($this->username);
        $this->password=strip_tags($this->password);
        $this->created=strip_tags($this->created);
        // bind the values
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':created', $this->created);
        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // check if given email exist in the database
function userExists(){
    // query to check if email exists
    $query = "SELECT user_id, username, password
            FROM " . $this->table_name . "
            WHERE username = ?
            LIMIT 0,1";
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // sanitize
    $this->email=strip_tags($this->email);
    // bind given email value
    $stmt->bindParam(1, $this->username);
    // execute the query
    $stmt->execute();
    // get number of rows
    $num = $stmt->rowCount();
    // if email exists, assign values to object properties for easy access and use for php sessions
    if($num>0){
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // assign values to object properties
        $this->user_id = $row['user_id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        // return true because email exists in the database
        return true;
    }
    // return false if email does not exist in the database
    return false;
}
// update() method will be here
}