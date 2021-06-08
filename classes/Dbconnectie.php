<?php

class Dbconnectie
{
    private $mysqli;
    private $host = "mysql";
    private $username = "root";
    private $password = "root";
    private $dbname = "stully";

    public function __construct() {
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        // Controle connectie
        if ($this->mysqli->connect_errno) {
            trigger_error("Connect failed: %s\n" . $this->mysqli->connect_error, E_USER_ERROR);
        }
    }

    // Get mysqli connection
    public function getConnection() {
        return $this->mysqli;
    }
}