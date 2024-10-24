<?php
require_once("dbcontroller.php");
$db_handle = new DBController("edit");

if (!empty($_POST["column"]) && !empty($_POST["id"]) && !empty($_POST["editval"])) {
    $allowed_columns = ['post_title', 'description'];
    $column = $_POST["column"];
    
    if (in_array($column, $allowed_columns)) {
        $id = intval($_POST["id"]);
        $editval = strip_tags($_POST["editval"]); // Sanitize input
        
        $sql = "UPDATE posts SET $column = ? WHERE id = ?";
        $params = ['si', $editval, $id]; // 'si' indicates a string and an integer
        $db_handle->executeUpdate($sql, $params);
    } else {
        die("Invalid column name");
    }
}
?>
