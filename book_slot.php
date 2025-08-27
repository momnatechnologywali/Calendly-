// book_slot.php
<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $date = $_POST['date'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sql = "INSERT INTO bookings (user_id, booker_name, booker_email, booking_date, start_time, end_time, status) VALUES ($user_id, '$name', '$email', '$date', '$start', '$end', 'confirmed')";
    if ($conn->query($sql) === TRUE) {
        // Send confirmation emails (assuming mail is configured on server)
        mail($email, "Booking Confirmed", "Your booking with ScheduleMe on $date at $start - $end is confirmed.");
        $sql_user = "SELECT email FROM users WHERE id = $user_id";
        $res_user = $conn->query($sql_user);
        $user_email = $res_user->fetch_assoc()['email'];
        mail($user_email, "New Booking", "You have a new booking from $name ($email) on $date at $start - $end.");
        echo "<script>alert('Booked successfully'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error booking: " . addslashes($conn->error) . "');</script>";
    }
}
?>
