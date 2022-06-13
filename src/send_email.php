<?php
function send_email($address, $activation_code, $username, $password, $type)
{
    if ($type == 1)
    {
        $recipient = $address;
        $subject = "Camagru Account Verification";
        $content = "Hello there! Activate your Camagru account by clicking the link provided in this e-mail!" . PHP_EOL . "http://localhost:8081/camagru/src/account_verification.php?code=$activation_code";
        mail($recipient, $subject, $content);
    }
}
?>