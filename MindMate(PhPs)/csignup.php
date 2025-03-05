<?php
$username = "s2555500";
$password = "s2555500";
$database = "d2555500";
$link = mysqli_connect("127.0.0.1", $username, $password, $database);
$email = $_POST["email"];
$username = $_POST["username"];
$specialty = $_POST["specialty"];
$password = $_POST["password"];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$insertCounsellorQuery = "INSERT INTO COUNSELLORS (email, username, specialty, password) VALUES ('$email', '$username', '$specialty', '$hashedPassword')";

if (mysqli_query($link, $insertCounsellorQuery)) {
    $rowsAffected = mysqli_affected_rows($link);
    if ($rowsAffected > 0) {
        $selectUserQuery = "SELECT * FROM USERS WHERE category = '$specialty' AND counsellor IS NULL";
        $userResult = mysqli_query($link, $selectUserQuery);

        if ($userResult) {
            $updateUserQuery = "UPDATE USERS SET counsellor = '$username' WHERE category = '$specialty' AND counsellor IS NULL";
            if (mysqli_query($link, $updateUserQuery)) {
                $rowsAffectedUsers = mysqli_affected_rows($link);

                if ($rowsAffectedUsers > 0) {
                    $incrementClientsQuery = "UPDATE COUNSELLORS SET numClients = numClients + $rowsAffectedUsers WHERE username = '$username'";
                    mysqli_query($link, $incrementClientsQuery);
                } else {
                    echo "No rows affected in USERS table";
                }
            } else {
                echo "Failed to update USERS table";
            }
        } else {
            echo "Failed to query USERS table";
        }
    }
    echo "Data inserted successfully";
} else {
    echo "Failed to insert data into COUNSELLORS table";
}

mysqli_close($link);
?>

