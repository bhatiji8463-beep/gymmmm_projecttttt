<?php
include "../config/db.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT 
payments.*, 
user.name,
user.email,
memberships.membership_type
FROM payments
JOIN user ON payments.user_id = user.id
JOIN memberships ON payments.membership_id = memberships.id
WHERE payments.id='$id'
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>
<style>
.invoice{
    width:400px;
    margin:40px auto;
    border:1px solid #ccc;
    padding:20px;
}
h2{text-align:center;}
.row{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="invoice">
<h2>Gym Invoice</h2>

<div class="row"><b>Name:</b> <?= $data['name']; ?></div>
<div class="row"><b>Email:</b> <?= $data['email']; ?></div>
<div class="row"><b>Membership:</b> <?= $data['membership_type']; ?></div>
<div class="row"><b>Amount:</b> ₹<?= $data['amount']; ?></div>
<div class="row"><b>Payment Mode:</b> <?= $data['payment_mode']; ?></div>
<div class="row"><b>Date:</b> <?= $data['payment_date']; ?></div>

<hr>
<p style="text-align:center;">Thank you for your payment 💪</p>
</div>

</body>
</html>
