<?php
include "includes/db.php";

$name    = $_POST['name'];
$address = $_POST['address'];
$phone   = $_POST['phone'];
$email   = $_POST['email'];

$query = "INSERT INTO businesses (name, address, phone, email) 
          VALUES ('$name', '$address', '$phone', '$email')";

mysqli_query($conn, $query);

echo "success";