// dashboard.php
<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE user_id = $user_id ORDER BY booking_date DESC";
$result = $conn->query($sql);
$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
$sql_av = "SELECT * FROM availabilities WHERE user_id = $user_id";
$result_av = $conn->query($sql_av);
$avail = [];
if ($result_av->num_rows > 0) {
    while ($row = $result_av->fetch_assoc()) {
        $avail[$row['weekday']] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ScheduleMe</title>
    <style>
        body {
            background-color: #87CEEB;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #DCAE96;
            color: white;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #DCAE96;
            color: white;
        }
        form div {
            margin: 10px 0;
        }
        input[type="time"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        button {
            background-color: #DCAE96;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #C07F80;
        }
        a.btn {
            background-color: #DCAE96;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
        }
        @media (max-width: 600px) {
            .container {
                padding: 20px;
                margin: 20px;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Your Dashboard</h1>
    </header>
    <div class="container">
        <h2>Your Booking Link</h2>
        <p>Share this to let others book: http://<?php echo $_SERVER['HTTP_HOST']; ?>/schedule.php?user=<?php echo $_SESSION['username']; ?></p>
        <h2>Set Availability</h2>
        <form method="post" action="set_availability.php">
            <?php $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; ?>
            <?php for ($i = 0; $i < 7; $i++): ?>
                <div>
                    <label><?php echo $days[$i]; ?>:</label>
                    <input type="time" name="start[<?php echo $i; ?>]" value="<?php echo isset($avail[$i]) ? $avail[$i]['start_time'] : ''; ?>">
                    to
                    <input type="time" name="end[<?php echo $i; ?>]" value="<?php echo isset($avail[$i]) ? $avail[$i]['end_time'] : ''; ?>">
                </div>
            <?php endfor; ?>
            <button type="submit">Save Availability</button>
        </form>
        <h2>Bookings</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Booker</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['booking_date']; ?></td>
                    <td><?php echo $booking['start_time'] . ' - ' . $booking['end_time']; ?></td>
                    <td><?php echo $booking['booker_name']; ?></td>
                    <td><?php echo $booking['booker_email']; ?></td>
                    <td><?php echo $booking['status']; ?></td>
                    <td><a href="cancel.php?id=<?php echo $booking['id']; ?>" class="btn">Cancel</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
