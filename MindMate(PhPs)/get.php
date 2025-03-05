<?php
$host = '127.0.0.1';
$username = 's2555500';
$password = 's2555500';
$database = 'd2555500';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    die("Error: " . $e->getMessage());
}

function sendMessage($sender, $receiver, $text) {
    global $pdo;
    $tableName = 'MESSAGES';

    $query = "INSERT INTO $tableName (sender, receiver, messagetext) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    
    try {
        $stmt->execute([$sender, $receiver, $text]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function retrieveMessages($sender, $receiver) {
    global $pdo;
    $tableName = 'MESSAGES';

    $query = "SELECT * FROM $tableName WHERE sender = ? AND receiver = ?";
    $stmt = $pdo->prepare($query);
    
    try {
        $stmt->execute([$sender, $receiver]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return []; 
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $sender = $_POST["sender"];
    $receiver = $_POST["receiver"];
    $text = $_POST["messagetxt"];
    $messageSent = sendMessage($sender, $receiver, $text);

    if ($messageSent) {
        echo "Message sent successfully.\n";
    } else {
        echo "Failed to send message.\n";
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sender = $_GET["sender"];
    $receiver = $_GET["receiver"];
    $messages = retrieveMessages($sender, $receiver);

    if (!empty($messages)) {
        foreach ($messages as $message) {
            echo "Sender: " . $message['sender'] . "\n";
            echo "Receiver: " . $message['receiver'] . "\n";
            echo "Text: " . $message['text'] . "\n";
            echo "\n";
        }
    } else {
        echo "No messages found.\n";
    }
}
?>
