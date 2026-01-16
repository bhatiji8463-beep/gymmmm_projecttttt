<?php
// STEP 10 – SMS REMINDER ENGINE

$conn = mysqli_connect("localhost","root","","gym_project");
if(!$conn){ exit; }

$today = date("Y-m-d");

/* MSG91 DETAILS */
$AUTH_KEY = "YOUR_MSG91_AUTH_KEY";
$SENDER  = "GYMGYM";

/* Fetch users + memberships */
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

        $mobile = $row['mobile'];

        $message = "Hello {$row['name']}, your {$row['membership_type']} gym membership will expire on {$row['end_date']}. Please renew on time.";

        /* MSG91 API URL */
        $url = "https://api.msg91.com/api/v2/sendsms";

        $data = [
            "sender" => $SENDER,
            "route"  => "4",
            "country"=> "91",
            "sms" => [
                [
                    "message" => $message,
                    "to" => [$mobile]
                ]
            ]
        ];

        $headers = [
            "authkey: $AUTH_KEY",
            "Content-Type: application/json"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);
        curl_close($ch);

        echo "SMS sent to {$row['name']}<br>";
    }
}
+