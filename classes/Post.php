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
//            Moet nog kijken hoeveel punten je krijgt
            $this->updatePoints($username, 1);
            return true;
        } else {
            return $this->mysqli->error;
        }
    }

    public function deletePost($id) {
        $stmt = $this->mysqli->prepare("DELETE FROM posts WHERE post_id = ?");
        $stmt->bind_param("i", $id);
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
            $posts[0]['timestamp'] = $this->time_elapsed_string($posts[0]['timestamp']);
            return $posts;
        } else {
            return $this->mysqli->error;
        }
    }

    public function showComments($id) {
        $stmt = $this->mysqli->prepare("SELECT comment_id, comment, punten, account_id FROM comments WHERE post_id = ? ORDER BY punten DESC");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $comments[] = $row;
            }
            return $comments;
        } else {
            return $this->mysqli->error;
        }
    }

    public function addComment($comment, $username, $id) {
        $accountid = $this->getAccountId($username);
        $stmt = $this->mysqli->prepare("INSERT INTO comments (comment, punten, post_id, account_id) VALUES (?, 0, ?, ?)");
        $stmt->bind_param("sii", $comment, $id, $accountid);
        if($stmt->execute()){
//            Moet nog kijken hoeveel punten je krijgt
            $this->updatePoints($username, 1);
            return true;
        } else {
            return $this->mysqli->error;
        }
    }

    public function upvote($comment_id) {
        $stmt = $this->mysqli->prepare("UPDATE comments SET punten = punten + 1 WHERE comment_id = ?");
        $stmt->bind_param("i", $comment_id);
        if($stmt->execute()){
            $stmt = $this->mysqli->prepare("SELECT username FROM account WHERE account_id = (SELECT account_id FROM comments WHERE comment_id = ?)");
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $commentuser = $result->fetch_array(MYSQLI_ASSOC)['username'];

//            Moet nog kijken hoeveel punten je krijgt
            $this->updatePoints($commentuser, 1);
            return true;
        } else {
            return false;
        }
    }

    public function getPosts() {
        if ($stmt = $this->mysqli->query("SELECT post_id, account_id, title, code, subtext, timestamp FROM posts ORDER BY timestamp DESC")) {
            if ($stmt->num_rows > 0) {
                while ($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
                    $posts[] = $row;
                }
                $nr = count($posts);
                for ($i = 0; $i < $nr; $i++) {
                    $posts[$i]['timestamp'] = $this->time_elapsed_string($posts[$i]['timestamp']);
                }
                return $posts;
            }
        } else {
            return $this->mysqli->error;
        }
    }

    public function getAccountId($username) {
        $stmt = $this->mysqli->prepare("SELECT account_id FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $accountid = $result->fetch_array(MYSQLI_ASSOC);
        return $accountid['account_id'];
    }

    private function updatePoints($username, $points) {
        $stmt = $this->mysqli->prepare("UPDATE account SET punten = punten + ? WHERE username = ?");
        $stmt->bind_param("is", $points, $username);
        if ($stmt->execute()) {
            return true;
        } else {
            return $this->mysqli->error;
        }
    }

    private function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}