<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Room Booking</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body align="center">
    <h1 >Hotel Room Booking</h1>
    <form id="bookingForm" action="book_room.php" method="POST">
        <label for="customer_name">Name:</label>
        <input type="text" id="customer_name" name="customer_name" required><br><br>

        <label for="room">Select Room:</label>
        <select name="room_id" id="room" required>
            <option value="1">Room 101 - Single</option>
            <option value="2">Room 102 - Double</option>
        </select><br><br>

        <label for="booking_type">Booking Type:</label>
        <select name="booking_type" id="booking_type" required>
            <option value="full_day">Full Day</option>
            <option value="half_day">Half Day</option>
            <option value="custom">Custom</option>
        </select><br><br>

        <!-- Full Day Booking Section: Date input only -->
        <div id="full_day_booking" style="display: none;">
            <label for="checkin_date">Check-in Date:</label>
            <input type="date" id="checkin_date" name="checkin_date"><br><br>

            <label for="checkout_date">Check-out Date:</label>
            <input type="date" id="checkout_date" name="checkout_date"><br><br>
        </div>

        <!-- Half Day Booking Section: Date and slot selection -->
        <div id="half_day_booking" style="display: none;">
            <label for="half_day_date">Select Date:</label>
            <input type="date" id="half_day_date" name="half_day_date"><br><br>

            <label for="half_day_slot">Select Slot:</label>
            <select id="half_day_slot" name="half_day_slot">
                <option value="morning">Morning (8 AM - 6 PM)</option>
                <option value="evening">Evening (7 PM - 7 AM)</option>
            </select><br><br>
        </div>

        <!-- Custom Booking Section: Date and time input -->
        <div id="custom_booking" style="display: none;">
            <label for="start_time">Start Time:</label>
            <input type="datetime-local" id="start_time" name="start_time"><br><br>

            <label for="end_time">End Time:</label>
            <input type="datetime-local" id="end_time" name="end_time"><br><br>
        </div>

        <button type="submit" id="submitBtn">Book Now</button>
    </form>

    <script>
        const bookingTypeSelect = document.getElementById('booking_type');
        const fullDayBookingDiv = document.getElementById('full_day_booking');
        const halfDayBookingDiv = document.getElementById('half_day_booking');
        const customBookingDiv = document.getElementById('custom_booking');

        // Show or hide booking options based on selected type
        bookingTypeSelect.addEventListener('change', function() {
            if (this.value === 'full_day') {
                fullDayBookingDiv.style.display = 'block';
                halfDayBookingDiv.style.display = 'none';
                customBookingDiv.style.display = 'none';
            } else if (this.value === 'half_day') {
                halfDayBookingDiv.style.display = 'block';
                fullDayBookingDiv.style.display = 'none';
                customBookingDiv.style.display = 'none';
            } else if (this.value === 'custom') {
                customBookingDiv.style.display = 'block';
                fullDayBookingDiv.style.display = 'none';
                halfDayBookingDiv.style.display = 'none';
            } else {
                fullDayBookingDiv.style.display = 'none';
                halfDayBookingDiv.style.display = 'none';
                customBookingDiv.style.display = 'none';
            }
        });

        // Handle form submission with Ajax to validate half-day slot availability
        $('#bookingForm').on('submit', function(e) {
            e.preventDefault();
            const bookingType = $('#booking_type').val();

            if (bookingType === 'half_day') {
                const date = $('#half_day_date').val();
                const slot = $('#half_day_slot').val();

                // Ajax call to check if the selected slot is available
                $.ajax({
                    url: 'validate_slot.php',
                    type: 'POST',
                    data: {
                        date: date,
                        slot: slot,
                        room_id: $('#room').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.available) {
                            alert('Slot is available, proceeding with booking...');
                            $('#bookingForm')[0].submit(); // submit the form if the slot is available
                        } else {
                            alert('Sorry, this slot is not available. Please choose another.');
                        }
                    }
                });
            } else {
                $('#bookingForm')[0].submit(); // submit the form for full day or custom bookings
            }
        });
    </script>
</body>
</html>
