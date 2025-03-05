<?php
// Database connection
$servername = "localhost";
$username = "s2555500";
$password = "s2555500";
$dbname = "d2555500";

$counsellor = $_REQUEST["counsellor"];
$User = $_REQUEST["username"];

$sender1 = $counsellor;
$sender2 = $User;
$receiver1 = $counsellor;
$receiver2 = $User;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query
$stmt = $conn->prepare("SELECT sender, messagetext FROM MESSAGES WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?)");
$stmt->bind_param("ssssssss", $sender1, $receiver1, $sender1, $receiver2, $sender2, $receiver1, $sender2, $receiver2);
$stmt->execute();
$stmt->bind_result($sender, $messagetext);

// Fetch the results into an array
$messages = array();
while ($stmt->fetch()) {
    $message = array(
        'sender' => $sender,
        'messagetext' => $messagetext
    );
    $messages[] = $message;
}

// Close statement and database connection
$stmt->close();
$conn->close();

// Encode the messages array as a JSON string
$messagesJson = json_encode($messages);

// Output the JSON string
echo $messagesJson;
?>
