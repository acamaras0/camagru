<?php
function send_email($address, $activation_code, $username, $password, $type)
{
    if ($type == 1)
    {
        $recipient = $address;
        $subject = "Camagru Account Verification";
        $content = "Hello there! Activate your Camagru account by clicking the link provided in this e-mail!" . PHP_EOL . PHP_EOL . "http://localhost:8080/camagru/src/account_verification.php?code=$activation_code";
        mail($recipient, $subject, $content);
    }
    else if ($type == 2)
    {
        $recipient = $address;
        $subject = "Reset your password";
        $content = "Hello there! Reset your password by clicking the link provided in this e-mail!" . PHP_EOL . PHP_EOL . "http://localhost:8080/camagru/src/reset_password.php?user=$username&pwd=$password&mail=$address";
        mail($recipient, $subject, $content);
    }
    else if ($type == 3)
    {
        $recipient = $address;
        $subject = "You've got a new comment on your picture!";
        $content = "It seems someone's been commenting on your post! Go check it out fast!" . PHP_EOL . PHP_EOL . "http://localhost:8080/camagru/src/profile.php";
        mail($recipient, $subject, $content);
    }
    else if ($type == 4)
    {
        $recipient = $address;
        $subject = "You've got a new like on your picture!";
        $content = "It seems someone liked your picture! Go check it out fast!" . PHP_EOL . PHP_EOL . "http://localhost:8080/camagru/src/profile.php";
        mail($recipient, $subject, $content);
    }
}
?>