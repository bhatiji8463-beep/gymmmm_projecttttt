<?php
include "../config/db.php";

if(isset($_POST['register'])){
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];
    $dob    = $_POST['dob'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
    if(mysqli_num_rows($check)>0){
        $error = "Email already registered!";
    }else{
        mysqli_query($conn,"
            INSERT INTO users (name,email,mobile,dob,password)
            VALUES ('$name','$email','$mobile','$dob','$password')
        ");
        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
body{background:#f4f4f4;font-family:Arial}
.form-box{width:350px;margin:50px auto;background:#fff;padding:25px;border-radius:10px}
input,button{width:100%;padding:10px;margin-bottom:12px}
button{background:#111;color:#fff;border:none}
</style>
</head>
<body>

<div class="form-box">
<h2>Create Account</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="POST">
<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="mobile" placeholder="Mobile" required>
<input type="date" name="dob" required>
<input type="password" name="password" placeholder="Password" required>
<button name="register">Register</button>
</form>
</div>

</body>
</html>
