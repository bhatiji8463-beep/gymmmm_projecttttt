<?php
// STEP 8 – AUTOMATION ENGINE (NO UI)

$conn = mysqli_connect("localhost","root","","gym");
if(!$conn){ exit; }

$today = date("Y-m-d");

$sql = "
SELECT 
    user.name,
    user.email,
    user.mobile,
    memberships.membership_type,
    memberships.end_date
FROM memberships
JOIN user ON memberships.user_id = user.id
";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){

    $days_left = (strtotime($row['end_date']) - strtotime($today)) / 86400;

    if(in_array($days_left,[7,3,1])){

        // Future SMS / WhatsApp
        echo "REMINDER READY → {$row['name']} ({$days_left} days left)\n";
    }

    if($days_left < 0){
        echo "EXPIRED → {$row['name']}\n";
    }
}
