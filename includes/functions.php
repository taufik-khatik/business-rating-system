<?php

function getAverageRating($business_id, $conn)
{
    $query = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE business_id = $business_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return round($row['avg_rating'], 1);
}

?>