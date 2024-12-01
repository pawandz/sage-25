<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
error_reporting(E_ALL);
ini_set('display_errors',1);

$mail = new PHPMailer();
$mail->SMTPDebug = 4;
$mail->isSMTP();
$mail->Host = 'smtp-relay.gmail.com';
$mail->SMTPAuth = FALSE;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->XMailer = 'SageTitans Script';
$extra['from'] = 'contact@sagetitans.com';
$extra['fromName'] = 'Sagetitans Team';
$mail->setFrom($extra['from'], $extra['fromName']);
$mail->addaddress('dineshchhabra10641@gmail.com', 'Rajiv');
$mail->CharSet = 'utf-8';
$mail->isHTML(true);
$mail->Subject = 'Test via smtp relay';
$mail->msgHTML('Testing it.');
echo PHP_EOL;
if ($mail->send()) {
    echo 'Sent';
} else {
    echo $mail->ErrorInfo;
}
echo PHP_EOL;
?>