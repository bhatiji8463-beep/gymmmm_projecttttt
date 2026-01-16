<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$amount  = 2000; // example membership fee
?>

<!DOCTYPE html>
<html>
<head>
<title>Renew Membership</title>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body style="text-align:center;font-family:Arial">

<h2>Renew Your Gym Membership</h2>
<h3>Amount: ₹<?php echo $amount; ?></h3>

<button id="payBtn">Pay Now</button>

<script>
var options = {
    "key": "RAZORPAY_KEY_ID",
    "amount": "<?php echo $amount*100; ?>",
    "currency": "INR",
    "name": "Gym Management",
    "description": "Membership Renewal",
    "handler": function (response){
        window.location.href =
        "payment_success.php?payment_id="+response.razorpay_payment_id;
    }
};

var rzp = new Razorpay(options);
document.getElementById('payBtn').onclick = function(e){
    rzp.open();
    e.preventDefault();
}
</script>

</body>
</html>
