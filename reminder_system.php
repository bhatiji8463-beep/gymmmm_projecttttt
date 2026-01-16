<?php
include "../config/db.php";

/* ===============================
   ADMIN LOGIN CHECK
=============================== */
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

/* ===============================
   TODAY DATE
=============================== */
$today = date("Y-m-d");

/* ===============================
   FETCH USER + MEMBERSHIP DATA
=============================== */
$sql = "
SELECT 
    u.name,
    u.email,
    u.mobile,
    u.dob,
    m.membership_type,
    m.end_date
FROM users u
INNER JOIN memberships m ON u.id = m.user_id
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Membership Reminder System</title>

<style>
body{
    font-family: Arial, Helvetica, sans-serif;
    background:#f4f4f4;
    padding:20px;
}

.box{
    background:#fff;
    padding:15px;
    margin-bottom:12px;
    border-left:5px solid #ff9800;
    border-radius:5px;
}

.expired{
    border-left-color:#f44336;
}

.birthday{
    border-left-color:#4caf50;
}

h2{
    text-align:center;
}
</style>
</head>

<body>

<h2>Membership Expiry Reminders</h2>

<?php
while ($row = mysqli_fetch_assoc($result)) {

    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $type = $row['membership_type'];
    $end_date = $row['end_date'];

    /* ===============================
       DAYS LEFT CALCULATION
    =============================== */
    $days_left = floor((strtotime($end_date) - strtotime($today)) / 86400);

    /* ===============================
       EXPIRY REMINDER
    =============================== */
    if (in_array($days_left, [7, 3, 1])) {
        echo "
        <div class='box'>
            <b>Reminder:</b> $name <br>
            Plan: <b>$type</b><br>
            Expiry Date: <b>$end_date</b><br>
            Email: $email | Mobile: $mobile<br>
            <b>$days_left day(s) left</b>
        </div>
        ";
    }

    /* ===============================
       EXPIRED MEMBERSHIP
    =============================== */
    if ($days_left < 0) {
        echo "
        <div class='box expired'>
            <b>Expired:</b> $name <br>
            Plan: $type <br>
            Expired on: <b>$end_date</b>
        </div>
        ";
    }

    /* ===============================
       BIRTHDAY WISH
    =============================== */
    if (!empty($row['dob'])) {
        if (date("m-d", strtotime($row['dob'])) == date("m-d")) {
            echo "
            <div class='box birthday'>
                🎉 Happy Birthday <b>$name</b> 🎂
            </div>
            ";
        }
    }
}
?>

</body>
</html>
