// book.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Meeting - ScheduleMe</title>
    <style>
        body {
            background-color: #87CEEB;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }
        button {
            background-color: #DCAE96;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #C07F80;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        @media (max-width: 600px) {
            .container {
                margin: 50px 20px;
                padding: 20px;
            }
        }
    </style>
    <script>
        function redirectToSchedule(e) {
            e.preventDefault();
            let user = document.getElementById('username').value;
            window.location.href = 'schedule.php?user=' + encodeURIComponent(user);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Enter Username to Book</h2>
        <form onsubmit="redirectToSchedule(event)">
            <input type="text" id="username" placeholder="Username" required>
            <button type="submit">Find Schedule</button>
        </form>
    </div>
</body>
</html>
