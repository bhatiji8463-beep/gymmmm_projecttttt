<?php
// STEP 9 – WHATSAPP REMINDER

$conn = mysqli_connect("localhost","root","","gym");
if(!$conn){ exit; }

$today = date("Y-m-d");

/* Twilio Credentials */
$ACCOUNT_SID = "YOUR_ACCOUNT_SID";
$AUTH_TOKEN  = "YOUR_AUTH_TOKEN";
$FROM        = "whatsapp:+14155238886";

/* Fetch expiring memberships */
$sql = "
SELECT 
    user.name,
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

        $to = "whatsapp:+91".$row['mobile'];

        $message = "Hello {$row['name']} 👋
Your {$row['membership_type']} gym membership will expire on {$row['end_date']}.
Please renew on time 💪";

        $data = [
            'From' => $FROM,
            'To'   => $to,
            'Body' => $message
        ];

        $ch = curl_init("https://api.twilio.com/2010-04-01/Accounts/$ACCOUNT_SID/Messages.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_USERPWD, "$ACCOUNT_SID:$AUTH_TOKEN");

        curl_exec($ch);
        curl_close($ch);

        echo "WhatsApp sent to {$row['name']}<br>";
    }
}
