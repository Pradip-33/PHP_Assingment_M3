<?php
require_once("dbcontroller.php");
$db_handle = new DBController("edit");

if (!empty($_POST['id'])) {
    $id = intval($_POST['id']); // Ensure ID is an integer
    $sql = "DELETE FROM posts WHERE id = ?";
    $params = ['i', $id]; // 'i' indicates an integer parameter
    $db_handle->executeUpdate($sql, $params);
}
?>
