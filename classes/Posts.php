<?php
require_once 'Dbconnectie.php';

class Post
{
    private $mysqli;

    public function __construct()
    {
        $con = new Dbconnectie();
        $this->mysqli = $con->getConnection();
    }

    public function showPost($id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM posts WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $test[] = $row;
            }
            return $test;
        }else{
            return $this->mysqli->error;
        }
    }

    public function showComments($id) {
        $stmt = $this->mysqli->prepare("SELECT comment_id,comment,punten,account_id FROM comments WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $test[] = $row;
            }
            return $test;
        }else{
            return $this->mysqli->error;
        }
    }

    public function addComment($comment, $username, $id) {
        $stmt = $this->mysqli->prepare("SELECT account_id FROM account WHERE username = ?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $stmt1 = $this->mysqli->prepare("INSERT INTO comments (`comment_id`, `comment`, `punten`, `post_id`,`account_id`) VALUES (NULL, ?, 0, ?, ?)");
        $stmt1->bind_param("sii", $comment, $id, $row["account_id"]);
        if($stmt1->execute()){
            return true;
        }else{
            return $this->mysqli->error;
        }
    }

}