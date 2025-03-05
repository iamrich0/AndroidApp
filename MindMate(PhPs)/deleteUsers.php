<?php
// Database connection
$servername = "127.0.0.1";
$username = "s2555500";
$password = "s2555500";
$dbname = "d2555500";

$User = $_REQUEST["username"];
$Counsellor = $_REQUEST["counsellor"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query
$stmt = $conn->prepare("UPDATE COUNSELLORS SET numClients= numClients - 1 WHERE username = ?");
$stmt->bind_param("s", $Counsellor);


$stmt = $conn->prepare("DELETE FROM MESSAGES SET where sender = ? OR receiver = ? ");
$stmt->bind_param("ss", $User, $User);


$stmt = $conn->prepare("DELETE FROM USERS WHERE username = ?");
$stmt->bind_param("s", $User);

if ($stmt->execute()) {
   echo "Record deleted successfully";
} else {
   echo "Error deleting record: " . $conn->error;
}
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>

