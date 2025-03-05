<?php
// Database connection
$servername = "127.0.0.1";
$username = "s2555500";
$password = "s2555500";
$dbname = "d2555500";

$User = $_REQUEST["username"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query
$stmt = $conn->prepare("UPDATE USERS SET counsellor = NULL WHERE counsellor = ?");
$stmt->bind_param("s", $User);

if ($stmt->execute()) {
    // Delete from COUNSELLORS table
    $stmt = $conn->prepare("DELETE FROM COUNSELLORS WHERE username = ?");
    $stmt->bind_param("s", $User);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Error updating record: " . $conn->error;
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>

