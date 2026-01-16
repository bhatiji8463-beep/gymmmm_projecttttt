<?php
include "../config/db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit;
}

// Stats
$total_users = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM users WHERE role='user'"))[0];
$active = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM memberships WHERE end_date >= CURDATE()"))[0];
$expired = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM memberships WHERE end_date < CURDATE()"))[0];
$revenue = mysqli_fetch_row(mysqli_query($conn,"SELECT SUM(fees) FROM memberships"))[0];
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{margin:0;font-family:Arial;background:#f2f2f2}
.nav{background:#111;padding:15px;text-align:center}
.nav a{color:#fff;text-decoration:none;margin:0 15px;font-weight:bold}
.boxes{display:flex;gap:20px;justify-content:center;margin:30px}
.card{
    background:#fff;
    width:200px;
    padding:20px;
    border-radius:10px;
    text-align:center;
}
h3{margin:0;color:#ff4d4d}
</style>
</head>
<body>

<div class="nav">
    <a href="dashboard.php">Dashboard</a>
    <a href="members.php">Members</a>
    <a href="gallery_add.php">Add Gallery</a>
<a href="gallery_manage.php">Manage Gallery</a>
<a href="add_payment.php">Add Payment</a>
<a href="payment_history.php">Payment History</a>


    <a href="reminder_system.php">Reminders</a>

    <a href="logout.php">Logout</a>
</div>

<div class="boxes">
    <div class="card"><h3><?php echo $total_users; ?></h3>Total Members</div>
    <div class="card"><h3><?php echo $active; ?></h3>Active</div>
    <div class="card"><h3><?php echo $expired; ?></h3>Expired</div>
    <div class="card"><h3>₹<?php echo $revenue ?? 0; ?></h3>Revenue</div>
</div>

</body>
</html>
