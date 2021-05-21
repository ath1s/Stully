<?php
require_once 'Dbconnectie.php';

class Account
{
    private $mysqli;

    public function __construct()
    {
        $con = new Dbconnectie();
        $this->mysqli = $con->getConnection();
    }

    public function register($username, $password1, $password2, $email)
    {
        if ($password1 === $password2) {
            if ($this->checkDuplicateEmail($email) && $this->checkDuplicateUsername($username)) {
                $username = trim($this->mysqli->real_escape_string($username));
                $password = $this->mysqli->real_escape_string($password1);
                $email = trim(strtolower($this->mysqli->real_escape_string($email)));
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->mysqli->prepare("INSERT INTO account(username, password_hash, email, punten, status)VALUES(?, ?, ?, 0, 'offline')");
                $stmt->bind_param("sss", $username, $hash, $email);
                if ($stmt->execute()) {
                    return true;
                } else {
                    return $this->mysqli->error;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function checkDuplicateEmail($email)
    {
        $email = trim(strtolower($this->mysqli->real_escape_string($email)));
        $stmt = $this->mysqli->prepare("SELECT email FROM account WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function checkDuplicateUsername($username)
    {
        $username = trim($this->mysqli->real_escape_string($username));
        $stmt = $this->mysqli->prepare("SELECT username FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
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
        $username = trim($this->mysqli->real_escape_string($username));
        $stmt = $this->mysqli->prepare("SELECT password_hash FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if(password_verify($password,$row["password_hash"])){
                $this->changeStatus($username, 'online');
                return true;
            }else{
                return false;
            }
        } else {
            return $this->mysqli->error;
        }
    }

    public function logout($username) {
        return $this->changeStatus($username, 'offline');
    }

    public function resetPassword($username, $oldpwd, $newpwd1, $newpwd2)
    {
        if ($newpwd1 === $newpwd2) {
            if ($this->inloggen($username, $oldpwd)) {
                $newhash = password_hash($newpwd1, PASSWORD_DEFAULT);
                $stmt = $this->mysqli->prepare("UPDATE account SET password_hash = ? WHERE username = ?");
                $stmt->bind_param("ss", $newhash, $username);
                if ($stmt->execute()) {
                    return true;
                } else {
                    return $this->mysqli->error;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function changeStatus($username, $status) {
        if ($status == "offline" || $status == "online" || $status == "in call" || $status == "available") {
            if ($this->mysqli->query("UPDATE account SET status = '$status' WHERE username = '$username';")) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function randomMatch($username) {
            $available = $this->statusCheck();
            $array = array_diff($available, array($username));
            return $array[array_rand($array)];
    }

    public function statusCheck() {
        $result = $this->mysqli->query("SELECT username FROM account WHERE status = 'available'");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row["username"];
            }
        } else {
            $users[] = "no-user";
        }
        return $users;
    }

    public function getStatus($username) {
        $stmt = $this->mysqli->prepare("SELECT status FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['status'];
        }
    }
}