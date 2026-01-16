<?php
session_start();
$conn = mysqli_connect("localhost","root","","gym");

$user_id = $_SESSION['user_id'];
$payment_id = $_GET['payment_id'];
$amount = 2000;

/* Save payment */
mysqli_query($conn,"
INSERT INTO payments (user_id, payment_id, amount, payment_date)
VALUES ('$user_id','$payment_id','$amount',NOW())
");

/* Renew membership */
mysqli_query($conn,"
UPDATE memberships
SET end_date = DATE_ADD(end_date, INTERVAL 1 MONTH)
WHERE user_id = '$user_id'
");

echo "<h2>Payment Successful ✅</h2>";
echo "<p>Your membership has been renewed.</p>";
