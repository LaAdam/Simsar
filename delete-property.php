<?php
session_start();
include "sqlconnect.php";

if (!isset($_POST['id']) || !isset($_SESSION['logged'])) {
    echo "ERROR";
    exit();
}

$id = (int)$_POST['id'];

$sql = "SELECT merchant FROM properties WHERE id = $id";
$res = $conn->query($sql);

if ($res->num_rows == 0) {
    echo "ERROR";
    exit();
}
$row = $res->fetch_assoc();

if ($row['merchant'] != $_SESSION['username']) {
    echo "ERROR";
    exit();
}

$delq = "DELETE FROM properties WHERE id = $id";
if ($conn->query($delq)) {
    echo "DELETED";
} else {
    echo $conn->error;
}
