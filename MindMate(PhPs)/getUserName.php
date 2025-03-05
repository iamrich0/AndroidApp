<?php
// Database connection
$username = "s2555500";
$password = "s2555500";
$dbname = "d2555500";

$emailCondition = $_REQUEST["email"];


// Create connection
$conn = new mysqli("127.0.0.1", $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query
$stmt = $conn->prepare("SELECT username FROM USERS WHERE email = ?");
$stmt->bind_param("s", $emailCondition);
$stmt->execute();
$stmt->bind_result($username);

// Fetch the result
$stmt->fetch();

// Close statement and database connection
$stmt->close();
$conn->close();

// Return the result
echo $username;
?>
