<?php
include "../config/db.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($res)==1){
        $row = mysqli_fetch_assoc($res);
        if(password_verify($password,$row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header("Location: ../user/profile.php");
        }else{
            $error = "Invalid password";
        }
    }else{
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body{background:#f4f4f4;font-family:Arial}
.form-box{width:320px;margin:60px auto;background:#fff;padding:25px;border-radius:10px}
input,button{width:100%;padding:10px;margin-bottom:12px}
button{background:#111;color:#fff;border:none}
</style>
</head>
<body>

<div class="form-box">
<h2>User Login</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="POST">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>
</div>

</body>
</html>
