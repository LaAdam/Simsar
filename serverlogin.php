<?php
include "sqlconnect.php";

function authorize($username, $password) {
    global $conn;
   $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    $sqllogin = "SELECT * FROM usersauth WHERE username = '$username'";
    $result = $conn->query($sqllogin);

    if($result->num_rows == 0)
        return 1;
    $row = $result->fetch_assoc();
    if($row['password'] === $password)
        return 2;
    else
        return 3;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$status = authorize($username, $password);

if($status == 2){

session_start();
$_SESSION['logged'] = true;
$_SESSION['username'] = $username;

}




echo $status;
