<?php
include "../config/db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit;
}

$sql = "
SELECT u.name,u.email,u.mobile,
       m.membership_type,m.end_date
FROM users u
LEFT JOIN memberships m ON u.id=m.user_id
WHERE u.role='user'
";

$res = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Members</title>
<style>
body{font-family:Arial;background:#f4f4f4}
table{width:90%;margin:30px auto;border-collapse:collapse;background:#fff}
th,td{padding:10px;border:1px solid #ddd;text-align:center}
th{background:#111;color:#fff}
</style>
</head>
<body>

<h2 align="center">All Members</h2>
<table>
<tr>
<th>Name</th><th>Email</th><th>Mobile</th><th>Plan</th><th>Expiry</th>
</tr>
<?php while($row=mysqli_fetch_assoc($res)){ ?>
<tr>
<td><?= $row['name']; ?></td>
<td><?= $row['email']; ?></td>
<td><?= $row['mobile']; ?></td>
<td><?= $row['membership_type'] ?? 'N/A'; ?></td>
<td><?= $row['end_date'] ?? 'N/A'; ?></td>
</tr>
<?php } ?>
</table>

</body>
</html>
