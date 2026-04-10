<?php
include "includes/db.php";

$id = $_POST['id'];

$query = "SELECT * FROM businesses WHERE id = $id";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

echo json_encode($row);