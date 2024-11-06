<?php
if(!defined('DB_SERVER')){
    require_once("../initialize.php");
}
class DBConnection{

    // LIVE SERVER
    // private $host = "127.0.0.1:3306";
    // private $username = "u510162695_ofrs_db";
    // private $password = "1Bantayan_bfp";
    // private $database = "u510162695_ofrs_db";

    // LOCALHOST
    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    
    public $conn;
    
    public function __construct(){

        if (!isset($this->conn)) {
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if (!$this->conn) {
                echo 'Cannot connect to database server';
                exit;
            } 
                       
        }    
        
    }
    public function __destruct(){
        $this->conn->close();
    }
}
?>