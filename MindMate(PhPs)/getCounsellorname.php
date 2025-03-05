<?php
// Database connection
$servername = "localhost";
$username = "s2555500";
$password = "s2555500";
$dbname = "d2555500";

$counsellor = $_REQUEST["email"];

// Create connection
$conn = new mysqli("127.0.0.1", $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query
$stmt = $conn->prepare("SELECT counsellor FROM USERS WHERE email = ?");
$stmt->bind_param("s", $counsellor);
$stmt->execute();
$stmt->bind_result($username);

// Fetch the results into an array
$usernames = array();
while ($stmt->fetch()) {
    $usernames[] = $username;
}

// Close statement and database connection
$stmt->close();
$conn->close();

// Encode the usernames array as a JSON string
$usernamesJson = json_encode($usernames);

// Output the JSON string
echo $usernamesJson;
?>
