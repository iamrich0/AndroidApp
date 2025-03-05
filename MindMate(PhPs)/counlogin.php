<?php
$username = "s2555500";
$password = "s2555500";
$database = "d2555500";
$link = mysqli_connect("127.0.0.1", $username, $password, $database);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

$selectQuery = "SELECT password FROM COUNSELLORS WHERE email = '$email'";
$result = mysqli_query($link, $selectQuery);

$response = array();

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            $response["status"] = true;
        } else {
            $response["status"] = false;
        }
    } else {
        $response["status"] = "none";
    }
} else {
    $response["status"] = "error";
    $response["message"] = mysqli_error($link);
}

mysqli_close($link);

header('Content-Type: application/json');
echo json_encode($response);
?>

