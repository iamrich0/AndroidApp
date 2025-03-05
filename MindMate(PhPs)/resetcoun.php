<?php
$username = "s2555500";
$password = "s2555500";
$database = "d2555500";
$link = mysqli_connect("127.0.0.1", $username, $password, $database);

$email = $_REQUEST["email"];
$username = $_REQUEST["username"];
$password = $_REQUEST["password"];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$updateCounsellorQuery = "UPDATE COUNSELLORS SET password='$hashedPassword' WHERE username='$username' AND email='$email'";

$result = array();

if (mysqli_query($link, $updateCounsellorQuery)) {
    if (mysqli_affected_rows($link) > 0) {

        $result["status"] = true;
    } else {
        $result["status"] = false;
    }
} else {

    $result["status"] = false;
}

mysqli_close($link);

echo json_encode($result);
?>
