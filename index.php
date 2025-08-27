// index.php
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScheduleMe - Easy Meeting Scheduling</title>
    <style>
        body {
            background-color: #87CEEB; /* Sky Blue */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #DCAE96; /* Dusty Rose */
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
        .btn {
            background-color: #DCAE96; /* Dusty Rose */
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #C07F80;
        }
        h1, h2 {
            color: #333;
        }
        p {
            line-height: 1.6;
        }
        @media (max-width: 600px) {
            .container {
                padding: 20px;
                margin: 20px;
            }
            header {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to ScheduleMe</h1>
    </header>
    <div class="container">
        <h2>How Scheduling Works</h2>
        <p>ScheduleMe makes it easy to book meetings. Sign up to set your availability, generate a personal booking link, and let others choose time slots that work for you. Visitors can book without an account, and you'll get notifications for new bookings.</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Welcome back, <?php echo $_SESSION['username']; ?>!</p>
            <a href="dashboard.php" class="btn">Go to Dashboard</a>
            <a href="logout.php" class="btn">Logout</a>
        <?php else: ?>
            <a href="register.php" class="btn">Sign Up</a>
            <a href="login.php" class="btn">Log In</a>
        <?php endif; ?>
        <a href="book.php" class="btn">Book a Meeting</a>
    </div>
</body>
</html>
