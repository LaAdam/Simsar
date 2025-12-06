<?php
include "sqlconnect.php";
session_start();
if (!isset($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}

$status = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rooms = isset($_POST['rooms']) ? $_POST['rooms'] : null;
    $bathrooms = isset($_POST['bathrooms']) ? $_POST['bathrooms'] : null;
    $floors = isset($_POST['floors']) ? $_POST['floors'] : null;
    $size = isset($_POST['size']) ? $_POST['size'] : null;
    $garage = isset($_POST['garage']) ? $_POST['garage'] : null;
    $propertyType = isset($_POST['propertyType']) ? $_POST['propertyType'] : null;
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $rate = isset($_POST['rate']) ? (int)$_POST['rate'] : null;

    $price = isset($_POST['price']) ? (int)$_POST['price'] : null;
    $location = isset($_POST['location']) ? $_POST['location'] : null;

    $merchant = $_SESSION['username'];

$required = [$rooms, $bathrooms, $floors, $size, $propertyType, $rate,$title,$location,$price];
$status = 1; 
foreach ($required as $field) {
    if ($field === '' || $field === null) {
        echo 0;
        exit;
    }
}




    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images/'; 


    $tmpName = $_FILES['image']['tmp_name'];
    $originalName = basename($_FILES['image']['name']);
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $newName = uniqid('prop_') . '.' . $extension;
    $destination = $uploadDir . $newName;

        if (move_uploaded_file($tmpName, $destination)) {
        $imagePath = $destination; 
    } else {
       $imagePath = "images/default.jpg";
    }

    }else{
      $imagePath = "images/default.jpg";
    }

  if( $propertyType == "land"){
    $rate = 0;
    $rooms = 0;
    $bathrooms = 0;
    $floors = 0;
    $garage = 0;
  }

$stmt = $conn->prepare("
    INSERT INTO properties 
    (title, location, price, rate, merchant, size, type, garage, imgsrc, rooms, bathrooms, floors)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssdssdsisiii",
    $title,
    $location,
    $price,
    $rate,
    $merchant,
    $size,
    $propertyType,
    $garage,
    $imagePath,
    $rooms,
    $bathrooms,
    $floors
);

if ($stmt->execute()) {
    $status = 1;
}

$stmt->close();
$conn->close();




}

echo $status;
?>
