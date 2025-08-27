// cancel.php
<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    exit;
}
$id = $_GET['id'];
$sql = "UPDATE bookings SET status = 'cancelled' WHERE id = $id AND user_id = {$_SESSION['user_id']}";
$conn->query($sql);
echo "<script>window.location.href = 'dashboard.php';</script>";
?>
