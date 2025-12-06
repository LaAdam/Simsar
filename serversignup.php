<?php
include "sqlconnect.php";

function createAccount($username, $password,$email,$phone,$location,$name) {
    global $conn;

    $sql = "SELECT * FROM usersauth WHERE username = '$username'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
        return 1;
    
    $sql = "SELECT * FROM usersauth WHERE email = '$email'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
        return 2;


        $sql = "INSERT INTO usersauth (username, password, email,phone,location,name) 
        VALUES ('$username', '$password', '$email','$phone','$location','$name')";

        if ($conn->query($sql)) {
            return 3; 
        }
        else{
            echo "Error: " . $conn->error;
        }
    
    return 0;
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$location = $_POST['location'];
$phone = $_POST['phone'];
$name = $_POST['name'];

$status = createAccount($username, $password,$email,$phone,$location,$name);

if($status == 3){



}




echo $status;
