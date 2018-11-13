<?php
/**
 * Created by PhpStorm.
 * User: romi
 * Date: 01/11/2018
 * Time: 15:14
 */

class Database {
    // DB Params
    private $host = 'localhost';
    private $db_name = 'api';
    private $username = 'root';
    private $pwd = '';
    private $conn;

    //DB Connect
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' .$this->host . ';dbname=' .$this->db_name,
            $this->username, $this->pwd);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception){
            echo 'Connection Error : ' .$exception->getMessage();
        }

        return $this->conn;
    }

}