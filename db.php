// db.php
<?php
$servername = "localhost"; // Change this if the database host is different
$username = "uws1gwyttyg2r";
$password = "k1tdlhq4qpsf";
$dbname = "db6ppfljoc0jfr";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
