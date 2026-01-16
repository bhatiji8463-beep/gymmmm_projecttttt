<?php
// STEP 11 – EMAIL REMINDER SYSTEM

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';

$conn = mysqli_connect("localhost","root","","gym");
if(!$conn){ exit; }

$today = date("Y-m-d");

/* Fetch users + memberships */
$sql = "
SELECT 
    user.name,
    user.email,
    memberships.membership_type,
    memberships.end_date
FROM memberships
JOIN user ON memberships.user_id = user.id
";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){

    $days_left = (strtotime($row['end_date']) - strtotime($today)) / 86400;

    if(in_array($days_left,[7,3,1])){

        $mail = new PHPMailer(true);

        try{
            /* SMTP CONFIG */
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yourgmail@gmail.com';   // your email
            $mail->Password   = 'APP_PASSWORD';           // gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            /* EMAIL DETAILS */
            $mail->setFrom('yourgmail@gmail.com','Gym Management');
            $mail->addAddress($row['email'],$row['name']);

            $mail->isHTML(true);
            $mail->Subject = "Membership Expiry Reminder";

            $mail->Body = "
            <h3>Hello {$row['name']},</h3>
            <p>Your <b>{$row['membership_type']}</b> gym membership will expire on:</p>
            <h3>{$row['end_date']}</h3>
            <p>Please renew within <b>$days_left days</b> to continue your fitness journey 💪</p>
            <br>
            <p>Regards,<br><b>Your Gym Team</b></p>
            ";

            $mail->send();

            echo "Email sent to {$row['name']}<br>";

        }catch(Exception $e){
            echo "Email failed for {$row['email']}<br>";
        }
    }
}
