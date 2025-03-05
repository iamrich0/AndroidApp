<?php
$username = "s2555500";
$password = "s2555500";
$database = "d2555500";
$link = mysqli_connect("127.0.0.1", $username, $password, $database);
$email = $_POST["email"];
$username = $_POST["username"];
$category = $_POST["category"];
$password = $_POST["password"];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$insertCounsellorQuery = "INSERT INTO USERS (email, username, category, password) VALUES ('$email', '$username', '$category', '$hashedPassword')";
if (mysqli_query($link, $insertCounsellorQuery)) {
    
    echo "Data inserted successfully";

    $selectUsernameQuery = "SELECT username FROM COUNSELLORS WHERE specialty = '$category' ORDER BY numClients ASC LIMIT 1";
    $result = mysqli_query($link, $selectUsernameQuery);

    if ($row = mysqli_fetch_assoc($result)) {
        $counsellorUsername = $row['username'];

        $updateUserQuery = "UPDATE USERS SET counsellor = '$counsellorUsername' WHERE username = '$username'";
        if (mysqli_query($link, $updateUserQuery)) {
            echo "Counselor assigned successfully";
            $incrementNumClientsQuery = "UPDATE COUNSELLORS SET numClients = numClients + 1 WHERE username = '$counsellorUsername'";
            if (mysqli_query($link, $incrementNumClientsQuery)) {
                echo "NumClients incremented successfully";
            } else {
                echo "Failed to increment NumClients";
            }
        } else {
            echo "Failed to assign counselor";
        }
    } else {
        echo "No counselor found with the specified specialty";
    }
} else {
    echo "Failed to insert data into USERS table";
}
mysqli_close($link);
?>
