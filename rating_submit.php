<?php
include "includes/db.php";

$business_id = $_POST['business_id'];
$name        = $_POST['name'];
$email       = $_POST['email'];
$phone       = $_POST['phone'];
$rating      = $_POST['rating'];

/* 
   RULE 1:
   If same Email OR Phone exists for the SAME BUSINESS → Update existing rating
*/
$check = mysqli_query($conn,
    "SELECT id FROM ratings 
     WHERE business_id=$business_id 
       AND (email='$email' OR phone='$phone')"
);

if (mysqli_num_rows($check) > 0) {
    $existing = mysqli_fetch_assoc($check);
    $rating_id = $existing['id'];

    mysqli_query($conn,
        "UPDATE ratings 
         SET name='$name', rating='$rating' 
         WHERE id=$rating_id"
    );

} else {

    /* RULE 2: Insert new rating */
    mysqli_query($conn,
        "INSERT INTO ratings (business_id, name, email, phone, rating) 
         VALUES ($business_id, '$name', '$email', '$phone', '$rating')"
    );
}

echo "rating_saved";