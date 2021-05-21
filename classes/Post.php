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

    public function htmlSpecialCharArray($array) {
        foreach ($array as $key=>$value) {
        $clearedarray[$key] = htmlspecialchars($value);
        }
        return $clearedarray;
    }

    public function createPost($username, $info) {
        $id = $this->getAccountId($username);
        $title = $info['title'];
        $code = $info['code'];
        $subtext = $info['subtext'];

        $stmt = $this->mysqli->prepare("INSERT INTO posts (account_id, title, code, subtext, timestamp) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isss", $id, $title, $code, $subtext);
        if ($stmt->execute()) {
            return true;
        } else {
            return $this->mysqli->error;
        }
    }

    public function showPost($id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM posts WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $posts[] = $row;
            }
            return $posts;
        }else{
            return $this->mysqli->error;
        }
    }

    public function showComments($id) {
        $stmt = $this->mysqli->prepare("SELECT comment_id, comment, punten, account_id FROM comments WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $comments[] = $row;
            }
            return $comments;
        }else{
            return $this->mysqli->error;
        }
    }

    public function addComment($comment, $username, $id) {
        $accountid = $this->getAccountId($username);
        $stmt1 = $this->mysqli->prepare("INSERT INTO comments (comment, punten, post_id, account_id) VALUES (?, 0, ?, ?)");
        $stmt1->bind_param("sii", $comment, $id, $accountid);
        if($stmt1->execute()){
            return true;
        }else{
            return $this->mysqli->error;
        }
    }

    private function getAccountId($username) {
        $stmt = $this->mysqli->prepare("SELECT account_id FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $accountid = $result->fetch_array(MYSQLI_ASSOC);
        return $accountid['account_id'];
    }
}