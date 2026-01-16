<?php
include "../config/db.php";

/* LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if(isset($_POST['join'])){
    $user_id = $_SESSION['user_id'];
    $type = $_POST['membership_type'];
    $start = $_POST['start_date'];
    $fees = $_POST['fees'];

    // Calculate end date
    if($type == "Monthly"){
        $end = date("Y-m-d", strtotime("+1 month", strtotime($start)));
    }elseif($type == "Quarterly"){
        $end = date("Y-m-d", strtotime("+3 months", strtotime($start)));
    }else{
        $end = date("Y-m-d", strtotime("+1 year", strtotime($start)));
    }

    mysqli_query($conn,"
        INSERT INTO memberships (user_id,membership_type,start_date,end_date,fees)
        VALUES ('$user_id','$type','$start','$end','$fees')
    ");

    header("Location: profile.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Join Membership</title>
<style>
body{background:#f2f2f2;font-family:Arial}
.form-box{
    width:420px;
    background:#fff;
    margin:40px auto;
    padding:25px;
    border-radius:10px;
}
input,select,button{
    width:100%;
    padding:10px;
    margin-bottom:15px;
}
button{background:#111;color:#fff;border:none}
</style>
</head>
<body>

<div class="form-box">
<h2>Join Membership</h2>

<form method="POST">
<label>Membership Type</label>
<select name="membership_type" required>
    <option value="">Select</option>
    <option value="Monthly">Monthly</option>
    <option value="Quarterly">Quarterly</option>
    <option value="Yearly">Yearly</option>
</select>

<label>Start Date</label>
<input type="date" name="start_date" required>

<label>Fees (₹)</label>
<input type="number" name="fees" required>

<button name="join">Join Membership</button>
</form>
</div>

</body>
</html>
