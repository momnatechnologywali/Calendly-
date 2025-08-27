// schedule.php
<?php
include 'db.php';
if (!isset($_GET['user'])) {
    echo "<script>alert('No user specified'); window.location.href = 'index.php';</script>";
    exit;
}
$username = mysqli_real_escape_string($conn, $_GET['user']);
$sql = "SELECT id FROM users WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "<script>alert('User not found'); window.location.href = 'index.php';</script>";
    exit;
}
$row = $result->fetch_assoc();
$user_id = $row['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book with <?php echo $username; ?> - ScheduleMe</title>
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
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .day {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            border-radius: 6px;
            background: #f9f9f9;
            transition: background-color 0.3s;
        }
        .day:hover {
            background: #e0e0e0;
        }
        .header {
            background: #DCAE96;
            color: white;
            cursor: default;
        }
        #slots button {
            background-color: #DCAE96;
            color: white;
            padding: 12px;
            margin: 10px 0;
            border: none;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #slots button:hover {
            background-color: #C07F80;
        }
        form input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }
        form button {
            background-color: #DCAE96;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
        }
        @media (max-width: 600px) {
            .container {
                padding: 20px;
                margin: 20px;
            }
            .calendar {
                gap: 5px;
            }
            .day {
                padding: 10px;
            }
        }
    </style>
    <script>
        function generateCalendar() {
            let date = new Date();
            let month = date.getMonth();
            let year = date.getFullYear();
            let firstDay = new Date(year, month, 1).getDay();
            let daysInMonth = new Date(year, month + 1, 0).getDate();
            let calendar = document.getElementById('calendar');
            calendar.innerHTML = '';
            let headers = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            headers.forEach(h => {
                let div = document.createElement('div');
                div.textContent = h;
                div.classList.add('day', 'header');
                calendar.appendChild(div);
            });
            for (let i = 0; i < firstDay; i++) {
                let div = document.createElement('div');
                div.classList.add('day');
                calendar.appendChild(div);
            }
            for (let d = 1; d <= daysInMonth; d++) {
                let div = document.createElement('div');
                div.textContent = d;
                div.classList.add('day');
                div.onclick = () => showSlots(`${year}-${(month+1).toString().padStart(2, '0')}-${d.toString().padStart(2, '0')}`);
                calendar.appendChild(div);
            }
        }
        function showSlots(date) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_slots.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let slots = JSON.parse(xhr.responseText);
                    let slotsDiv = document.getElementById('slots');
                    slotsDiv.innerHTML = '';
                    slots.forEach(slot => {
                        let btn = document.createElement('button');
                        btn.textContent = `${slot.start} - ${slot.end}`;
                        btn.onclick = () => bookSlot(date, slot.start, slot.end);
                        slotsDiv.appendChild(btn);
                    });
                }
            };
            xhr.send(`user_id=<?php echo $user_id; ?>&date=${date}`);
        }
        function bookSlot(date, start, end) {
            document.getElementById('booking_date').value = date;
            document.getElementById('start_time').value = start;
            document.getElementById('end_time').value = end;
            document.getElementById('booking_form').style.display = 'block';
        }
        window.onload = generateCalendar;
    </script>
</head>
<body>
    <header>
        <h1>Book a Meeting with <?php echo $username; ?></h1>
    </header>
    <div class="container">
        <h2>Select a Date</h2>
        <div id="calendar" class="calendar"></div>
        <h2>Available Slots</h2>
        <div id="slots"></div>
        <form id="booking_form" style="display:none;" method="post" action="book_slot.php">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" id="booking_date" name="date">
            <input type="hidden" id="start_time" name="start">
            <input type="hidden" id="end_time" name="end">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <button type="submit">Book Now</button>
        </form>
    </div>
</body>
</html>
