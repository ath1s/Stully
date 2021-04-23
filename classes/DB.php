<?php

class DB {
    private $host = "mysql";
    private $username = "root";
    private $password = "root";
    private $database = "chatapp";

    public function __construct() {
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->database);
    }

    public function register($username, $password, $password_repeat, $email, $age)
    {
        if ($password === $password_repeat) {
            if (!$this->checkDuplicateEmail($email)) {
                return false;
            }
            $username = trim($this->mysqli->real_escape_string($username));
            $password = $this->mysqli->real_escape_string($password);
            $email = trim(strtolower($this->mysqli->real_escape_string($email)));
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->mysqli->prepare("INSERT INTO users (username, pass_hash, email, age) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $hash, $email, $age);
            if ($stmt->execute()) {
                return true;
            } else {
                return $this->mysqli->error;
            }
        } else {
            return false;
        }
    }

    public function checkDuplicateEmail($email)
    {
        $email = trim(strtolower($this->mysqli->real_escape_string($email)));
        $stmt = $this->mysqli->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function inloggen($username, $password)
    {
        $stmt = $this->mysqli->prepare("SELECT pass_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["pass_hash"])) {
                return true;
            } else {
                return false;
            }
        } else {
            return $this->mysqli->error;
        }
    }
}