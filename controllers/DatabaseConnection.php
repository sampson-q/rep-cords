<?php
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of DatabaseConnection
*
* @author Hash 👽
*/

class DatabaseConnection {
    private $host;
    private $username;
    private $password;

    public function __construct($host, $username, $password) {
        $this -> host = $host;
        $this -> username = $username;
        $this -> password = $password;
    }

    public function ConnectDB() {
        try {
            $connection = new PDO("mysql:host=" . $this -> host . ";dbname=repnotes", "" . $this -> username . "", "" . $this -> password);
            $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (Exception $e) {
            die("Error: " . $e -> getMessage());
        }
    }
}
?>