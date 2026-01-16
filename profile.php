<?php
include "../config/db.php";

/* ===============================
   LOGIN CHECK
=============================== */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

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
    m.start_date,
    m.end_date,
    m.fees
FROM users u
LEFT JOIN memberships m ON u.id = m.user_id
WHERE u.id = '$user_id'
";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

/* ===============================
   MEMBERSHIP STATUS LOGIC
=============================== */
$status = "No Membership";
if (!empty($data['end_date'])) {
    $today = date("Y-m-d");
    if ($data['end_date'] < $today) {
        $status = "Expired ❌";
    } else {
        $days_left = (strtotime($data['end_date']) - strtotime($today)) / 86400;
        if ($days_left <= 7) {
            $status = "Expiring Soon ⚠️ ($days_left days left)";
        } else {
            $status = "Active ✅";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

    <style>
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            background:#f2f2f2;
        }

        /* NAVBAR */
        .navbar{
            background:#111;
            padding:15px;
            text-align:center;
        }
        .navbar a{
            color:#fff;
            text-decoration:none;
            margin:0 20px;
            font-weight:bold;
        }
        .navbar a:hover{
            color:#ff4d4d;
        }

        /* PROFILE CARD */
        .profile-card{
            background:#fff;
            width:420px;
            margin:40px auto;
            padding:25px;
            border-radius:10px;
            box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }

        .profile-card h2{
            text-align:center;
            margin-bottom:25px;
        }

        .row{
            display:flex;
            justify-content:space-between;
            margin-bottom:15px;
            border-bottom:1px solid #eee;
            padding-bottom:6px;
        }

        .label{
            font-weight:bold;
            color:#555;
        }

        .value{
            color:#222;
            text-align:right;
        }

        @media(max-width:500px){
            .profile-card{
                width:90%;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="../public/index.php">Home</a>
    <a href="profile.php">My Profile</a>
    <a href="../auth/logout.php">Logout</a>
    <a href="join_membership.php">Join Membership</a>

</nav>

<!-- PROFILE CARD -->
<div class="profile-card">
    <h2>My Profile</h2>

    <div class="row">
        <div class="label">Name</div>
        <div class="value"><?php echo $data['name']; ?></div>
    </div>

    <div class="row">
        <div class="label">Email</div>
        <div class="value"><?php echo $data['email']; ?></div>
    </div>

    <div class="row">
        <div class="label">Mobile</div>
        <div class="value"><?php echo $data['mobile']; ?></div>
    </div>

    <div class="row">
        <div class="label">Date of Birth</div>
        <div class="value"><?php echo $data['dob'] ?? 'N/A'; ?></div>
    </div>

    <div class="row">
        <div class="label">Membership Type</div>
        <div class="value"><?php echo $data['membership_type'] ?? 'N/A'; ?></div>
    </div>

    <div class="row">
        <div class="label">Start Date</div>
        <div class="value"><?php echo $data['start_date'] ?? 'N/A'; ?></div>
    </div>

    <div class="row">
        <div class="label">End Date</div>
        <div class="value"><?php echo $data['end_date'] ?? 'N/A'; ?></div>
    </div>

    <div class="row">
        <div class="label">Fees Paid</div>
        <div class="value">₹<?php echo $data['fees'] ?? '0'; ?></div>
    </div>

    <div class="row">
        <div class="label">Status</div>
        <div class="value"><?php echo $status; ?></div>
    </div>

</div>

</body>
</html>
