<?php
include "../config/db.php";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$users = mysqli_query($conn, "SELECT id, name FROM user");

if (isset($_POST['pay'])) {

    $user_id = $_POST['user_id'];
    $membership_id = $_POST['membership_id'];
    $amount = $_POST['amount'];
    $mode = $_POST['payment_mode'];
    $date = date("Y-m-d");

    mysqli_query($conn, "INSERT INTO payments 
        (user_id, membership_id, amount, payment_mode, payment_date)
        VALUES ('$user_id','$membership_id','$amount','$mode','$date')");

    echo "Payment Added Successfully";
}
?>

<h2>Add Payment</h2>

<form method="post">
    <select name="user_id" required>
        <option value="">Select User</option>
        <?php while($u=mysqli_fetch_assoc($users)){ ?>
            <option value="<?= $u['id']; ?>"><?= $u['name']; ?></option>
        <?php } ?>
    </select><br><br>

    <input type="number" name="membership_id" placeholder="Membership ID" required><br><br>

    <input type="number" name="amount" placeholder="Amount" required><br><br>

    <select name="payment_mode">
        <option>Cash</option>
        <option>UPI</option>
        <option>Card</option>
        <option>Net Banking</option>
    </select><br><br>

    <button name="pay">Submit Payment</button>
</form>
