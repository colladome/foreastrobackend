<?php

namespace App\Services;


class MailService
{
  
    
function sendEmail($to_name,$to_email,$subject,$body)
{
   $headers = array(
'Authorization: Bearer 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',
'Content-Type: application/json'
);

$data = array(
"personalizations" => array(
    array(
        "to" => array(
            array(
           "email" => $to_email,
            "name" => $to_name
            )
        )
    )
),

"from" => array(
            "email" => "mohit@bonwic.com",
            "name" => "Gaads"
),
"subject" => $subject,
"content" => array(
    array(
        "type" => "text/html",
        "value" => $body
    )
)
);

$ch = curl_init();
curl_setopt($ch, CURLINFO_HEADER_OUT, true); // enable tracking
curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
$headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT); // request headers
curl_close($ch);

if(isset($response)){
return true;
}else{
return false; 
}
}
   
}