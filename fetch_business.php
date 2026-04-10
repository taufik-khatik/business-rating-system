<?php
include "includes/db.php";
include "includes/functions.php";

$query = "SELECT * FROM businesses ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$output = "";

while ($row = mysqli_fetch_assoc($result)) {

    $avgRating = getAverageRating($row['id'], $conn);

    $output .= "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['address']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['email']}</td>

            <td>
                <button class='btn btn-sm btn-info editBtn m-1' data-id='{$row['id']}'>Edit</button>
                <button class='btn btn-sm btn-danger deleteBtn m-1' data-id='{$row['id']}'>Delete</button>
                <button class='btn btn-sm btn-warning rateBtn m-1' data-id='{$row['id']}'>Rate</button>
            </td>

            <td>
                <div class='avgRating' data-rating='{$avgRating}'></div>
            </td>
        </tr>
    ";
}

echo $output;