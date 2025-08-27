// set_availability.php
<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    exit;
}
$user_id = $_SESSION['user_id'];
$conn->query("DELETE FROM availabilities WHERE user_id = $user_id");
for ($i = 0; $i < 7; $i++) {
    if (isset($_POST['start'][$i]) && isset($_POST['end'][$i]) && $_POST['start'][$i] && $_POST['end'][$i]) {
        $start = $_POST['start'][$i];
        $end = $_POST['end'][$i];
        $sql = "INSERT INTO availabilities (user_id, weekday, start_time, end_time) VALUES ($user_id, $i, '$start', '$end')";
        $conn->query($sql);
    }
}
echo "<script>alert('Availability saved'); window.location.href = 'dashboard.php';</script>";
?>
