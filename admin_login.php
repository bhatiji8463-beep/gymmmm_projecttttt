<?php
include "../config/db.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND role='admin'");
    if(mysqli_num_rows($res)==1){
        $row = mysqli_fetch_assoc($res);
        if(password_verify($password,$row['password'])){
            $_SESSION['admin_id'] = $row['id'];
            header("Location: dashboard.php");
        }else{
            $error="Invalid password";
        }
    }else{
        $error="Admin not found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body{background:#f4f4f4;font-family:Arial}
.box{width:320px;margin:80px auto;background:#fff;padding:25px;border-radius:10px}
input,button{width:100%;padding:10px;margin-bottom:12px}
button{background:#111;color:#fff;border:none}
</style>
</head>
<body>

<div class="box">
<h2>Admin Login</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="POST">
<input type="email" name="email" placeholder="Admin Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>
</div>

</body>
</html>
