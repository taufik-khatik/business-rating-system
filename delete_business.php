<?php
include "includes/db.php";

$id = $_POST['id'];

$query = "DELETE FROM businesses WHERE id=$id";

mysqli_query($conn, $query);

echo "deleted";