<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_booking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$customer_name = $_POST['customer_name'];
$room_id = $_POST['room_id'];
$booking_type = $_POST['booking_type'];

if ($booking_type === 'half_day') {
    $date = $_POST['half_day_date'];
    $slot = $_POST['half_day_slot'];

    // Define start and end time based on slot selection
    if ($slot === 'morning') {
        $start_time = $date . ' 08:00:00';
        $end_time = $date . ' 18:00:00';
    } else if ($slot === 'evening') {
        $start_time = $date . ' 19:00:00';
        $end_time = date('Y-m-d H:i:s', strtotime($date . ' +1 day 07:00:00'));
    }
} else if ($booking_type === 'full_day') {
    // Logic for full day booking
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $start_time = $checkin_date . ' 00:00:00';
    $end_time = $checkout_date . ' 23:59:59';
} else if ($booking_type === 'custom') {
    // Logic for custom booking
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
}

// Insert booking data into the database
$sql = "INSERT INTO bookings (room_id, booking_type, booking_start, booking_end, customer_name) 
        VALUES ('$room_id', '$booking_type', '$start_time', '$end_time', '$customer_name')";

if ($conn->query($sql) === TRUE) {
    echo "Room booked successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
