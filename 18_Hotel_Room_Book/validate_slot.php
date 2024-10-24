<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_booking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from AJAX request
$date = $_POST['date'];
$slot = $_POST['slot'];
$room_id = $_POST['room_id'];

// Define start and end time for the slot based on selection
if ($slot === 'morning') {
    $start_time = $date . ' 08:00:00';
    $end_time = $date . ' 18:00:00';
} else if ($slot === 'evening') {
    $start_time = $date . ' 19:00:00';
    $end_time = date('Y-m-d H:i:s', strtotime($date . ' +1 day 07:00:00'));
}

// Check if the room is available for the selected time slot
$sql = "SELECT * FROM bookings WHERE room_id = ? AND (
            (booking_start <= ? AND booking_end >= ?) OR
            (booking_start <= ? AND booking_end >= ?)
        )";
$stmt = $conn->prepare($sql);
$stmt->bind_param('issss', $room_id, $start_time, $start_time, $end_time, $end_time);
$stmt->execute();
$result = $stmt->get_result();

// If any booking exists in the slot, it's unavailable
if ($result->num_rows > 0) {
    echo json_encode(['available' => false]);
} else {
    echo json_encode(['available' => true]);
}

$stmt->close();
$conn->close();
?>
