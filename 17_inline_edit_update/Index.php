<?php
require_once("dbcontroller.php");
$db_handle = new DBController("edit");

$sql = "SELECT * FROM posts"; // Fixed table name from 'post' to 'posts'
$posts = $db_handle->runSelectQuery($sql); // Fixed variable name from $post to $posts
?>

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function createNew() { // Fixed function name (was createnew)
    $("#add-more").hide();
    var data = '<tr class="table-row" id="new_row_ajax">' +
        '<td contenteditable="true" id="txt_title" onBlur="addToHiddenField(this, \'title\')" onClick="editRow(this);"></td>' +
        '<td contenteditable="true" id="txt_description" onBlur="addToHiddenField(this, \'description\')" onClick="editRow(this);"></td>' +
        '<td><input type="hidden" id="title" /><input type="hidden" id="description" />' +
        '<span id="confirmAdd"><a onClick="addToDatabase()" class="ajax-action-links">Save</a> / ' +
        '<a onclick="cancelAdd();" class="ajax-action-links">Cancel</a></span></td>' +
        '</tr>';
    $("#table-body").append(data);
}

function cancelAdd() {
    $("#add-more").show();
    $("#new_row_ajax").remove();
}

function editRow(editableObj) {
    $(editableObj).css("background", "#FFF");
}

function saveToDatabase(editableObj, column, id) {
    $(editableObj).css("background", "#FFF url(loaderIcon.gif) no-repeat right");
    $.ajax({
        url: "edit.php",
        type: "POST",
        data: 'column=' + column + '&editval=' + $(editableObj).text() + '&id=' + id,
        success: function(data) {
            $(editableObj).css("background", "#FDFDFD");
        }
    });
}

function addToDatabase() {
    var title = $("#title").val();
    var description = $("#description").val();

    $("#confirmAdd").html('<img src="loadericon.gif" />'); // Fixed 'scr' to 'src'
    $.ajax({
        url: "add.php",
        type: "POST",
        data: 'title=' + encodeURIComponent(title) + '&description=' + encodeURIComponent(description), // Encode URI components
        success: function(data) {
            $("#new_row_ajax").remove();
            $("#add-more").show();
            $("#table-body").append(data);
        }
    });
}

function addToHiddenField(addColumn, hiddenField) {
    var columnValue = $(addColumn).text();
    $("#" + hiddenField).val(columnValue);
}

function deleteRecord(id) {
    if (confirm("Are you sure you want to delete this row?")) {
        $.ajax({
            url: "delete.php",
            type: "POST",
            data: 'id=' + id,
            success: function(data) {
                $("#table-row-" + id).remove();
            }
        });
    }
}
</script>

<style>
body { width: 615px; }
.tbl-qa { width: 98%; font-size: 0.9em; background-color: #f5f5f5; }
.tbl-qa th.table-header { padding: 10px; text-align: left; }
.tbl-qa .table-row td { padding: 10px; background-color: #FDFDFD; }
.ajax-action-links { color: #09F; margin: 10px 0; cursor: pointer; }
.ajax-action-button { border: #094 1px solid; color: #09F; margin: 10px 0; cursor: pointer; display: inline-block; padding: 10px 20px; }
</style>

<table class="tbl-qa">
    <thead>
        <tr>
            <th class="table-header">Title</th>
            <th class="table-header">Description</th>
            <th class="table-header">Actions</th>
        </tr>
    </thead>
    <tbody id="table-body">
        <?php
        if (!empty($posts)) {
            foreach ($posts as $k => $v) {
        ?>
                <tr class="table-row" id="table-row-<?php echo htmlspecialchars($posts[$k]["id"]); ?>">
                    <td contenteditable="true" onBlur="saveToDatabase(this, 'post_title', '<?php echo htmlspecialchars($posts[$k]["id"]); ?>')" onClick="editRow(this);"><?php echo htmlspecialchars($posts[$k]["post_title"]); ?></td>
                    <td contenteditable="true" onBlur="saveToDatabase(this, 'description', '<?php echo htmlspecialchars($posts[$k]["id"]); ?>')" onClick="editRow(this);"><?php echo htmlspecialchars($posts[$k]["description"]); ?></td>
                    <td><a class="ajax-action-links" onclick="deleteRecord(<?php echo $posts[$k]["id"]; ?>);">Delete</a></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<div class="ajax-action-button" id="add-more" onClick="createNew();">Add More</div>
