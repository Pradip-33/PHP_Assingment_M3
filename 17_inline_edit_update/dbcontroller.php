<?php
class DBController {
    private $con;

    function __construct($db) {
        $this->con = new mysqli("localhost", "root", "", $db);
        if ($this->con->connect_error) {
            die("Connection failed: " . $this->con->connect_error);
        }
    }

    function runSelectQuery($query) {
        $result = $this->con->query($query);
        if (!$result) {
            die("Query Failed: " . $this->con->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function executeInsert($query, $params) {
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->con->error);
        }
        $stmt->bind_param(...$params);
        $stmt->execute();
        return $stmt->insert_id;
    }

    function executeUpdate($query, $params) {
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->con->error);
        }
        $stmt->bind_param(...$params);
        return $stmt->execute();
    }

    function closeConnection() {
        if ($this->con) {
            $this->con->close();
        }
    }
}
?>
