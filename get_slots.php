// get_slots.php
<?php
include 'db.php';
$user_id = $_POST['user_id'];
$date = $_POST['date'];
$dt = new DateTime($date);
$weekday = $dt->format('w');
$sql = "SELECT start_time, end_time FROM availabilities WHERE user_id = $user_id AND weekday = $weekday";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo json_encode([]);
    exit;
}
$av = $result->fetch_assoc();
$start = strtotime($av['start_time']);
$end = strtotime($av['end_time']);
$slots = [];
$slot_duration = 30 * 60;
for ($t = $start; $t + $slot_duration <= $end; $t += $slot_duration) {
    $slot_start = date('H:i', $t);
    $slot_end = date('H:i', $t + $slot_duration);
    $sql_check = "SELECT id FROM bookings WHERE user_id = $user_id AND booking_date = '$date' AND start_time = '$slot_start' AND status != 'cancelled'";
    $res_check = $conn->query($sql_check);
    if ($res_check->num_rows == 0) {
        $slots[] = ['start' => $slot_start, 'end' => $slot_end];
    }
}
echo json_encode($slots);
?>
