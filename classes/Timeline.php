<?php
require_once 'Dbconnectie.php';

class Timeline
{
    private $mysqli;

    public function __construct()
    {
        $con = new Dbconnectie();
        $this->mysqli = $con->getConnection();
    }

    public function setPost() {
        
    }

    public function getPosts() {
        if ($stmt = $this->mysqli->query("SELECT post_id, account_id, title, code, subtext, timestamp FROM posts")) {
            if ($stmt->num_rows > 0) {
                while ($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
                    $test[] = $row;
                }
                return $test;
            }
        } else {
            return $this->mysqli->error;
        }
    }

}