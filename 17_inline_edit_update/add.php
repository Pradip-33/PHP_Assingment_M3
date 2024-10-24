<?php
require_once("dbcontroller.php");
$db_handle = new DBController("edit");

if (!empty($_POST["title"])) {
    // Sanitize input
    $title = strip_tags($_POST["title"]);
    $description = strip_tags($_POST["description"]);

    // Use a prepared statement for secure insertion
    $sql = "INSERT INTO posts (post_title, description) VALUES (?, ?)";
    $params = ['ss', $title, $description]; // 'ss' indicates two string parameters
    $faq_id = $db_handle->executeInsert($sql, $params);

    if (!empty($faq_id)) {
        $sql = "SELECT * FROM posts WHERE id = ?";
        $params = ['i', $faq_id]; // 'i' indicates an integer parameter
        $posts = $db_handle->runSelectQuery($sql, $params);
    }

    if (!empty($posts)) {
        ?>
        <tr class="table-row" id="table-row-<?php echo htmlspecialchars($posts[0]["id"]); ?>">
            <td contenteditable="true" onBlur="saveToDatabase(this,'post_title','<?php echo htmlspecialchars($posts[0]["id"]); ?>')" onClick="editRow(this);">
                <?php echo htmlspecialchars($posts[0]["post_title"]); ?>
            </td>
            <td contenteditable="true" onBlur="saveToDatabase(this,'description','<?php echo htmlspecialchars($posts[0]["id"]); ?>')" onClick="editRow(this);">
                <?php echo htmlspecialchars($posts[0]["description"]); ?>
            </td>
            <td><a class="ajax-action-links" onclick="deleteRecord(<?php echo $posts[0]["id"]; ?>);">Delete</a></td>
        </tr>
        <?php
    }
}
?>
