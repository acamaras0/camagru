<?php
function print_msg($message)
{
    ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <link rel="stylesheet" type="text/css" href="../style.css">
        </head>
        <body>
            <div class="php-messages"><?php echo $message;?></div>
        </body>
        </html>
    <?php
}
?>