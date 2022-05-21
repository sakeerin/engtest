<?php
$conn = mysqli_connect("localhost", "root", "", "engtest_online");
$conn->set_charset("utf8mb4");
if (!$conn) {
    die("Failed to connect to database " . mysqli_error($conn));
}
// else{
//     echo "Connect Database Success!";
// }
?>