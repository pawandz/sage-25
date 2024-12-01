<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$services = str_replace(',', ', ', $_POST['services']);
$date = date('Y-m-d');
$subject = "SageTitans - Enquiry Form Submitted by $name on $date";
$website_url = $_POST["websiteurl"];
$content = $_POST["comments"];

// Build POST request to get the reCAPTCHA v3 score from Google
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_secret = '6LfZU20aAAAAADiKkECzV2ZPOCDi4KgNiFT23o7P';
$recaptcha_response = $_POST['recaptcha_response'];

// Make and decode POST request
$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
$recaptcha = json_decode($recaptcha);

// Take action based on the score returned
// Score less than 0.5 indicates suspicious activity. Return an error
if (!$recaptcha->success == true || $recaptcha->score < 0.5) {
	$data = array(
		"status" => false,
		"message" => "Something went wrong. Please try again later."
	);
	echo json_encode($data); die;
}	
/*
$mail = new PHPMailer(true);
$mail->SMTPDebug = false;
$mail->isSMTP();            
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;                          
$mail->Username = "contact@sagetitans.com";                 
$mail->Password = "HK7bGa@456#";                           
$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->From = $email;
$mail->FromName = $name;
$mail->addAddress("rajiv@sagetitans.com", "Rajiv");
$mail->addReplyTo($email, $name);
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = nl2br("<h2>You have received a new message from SageTitans website contact form.</h2>"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nPhone: $phone\n\nAdditional Information:\n$content\n\n Services Required: \n $services");
if(!empty($website_url)) {
	$mail->Body .= nl2br("\n\n Website URL: \n $website_url");
}*/



$mail = new PHPMailer();
$mail->SMTPDebug = false;
$mail->isSMTP();
$mail->Host = 'smtp-relay.gmail.com';
$mail->SMTPAuth = FALSE;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->XMailer = 'SageTitans Script';
$extra['from'] = 'contact@sagetitans.com';
$extra['fromName'] = 'Sagetitans Team';
$mail->setFrom($extra['from'], $extra['fromName']);
$mail->addaddress('rajiv@sagetitans.com', 'Rajiv');
$mail->addReplyTo($email, $name);
$mail->CharSet = 'utf-8';
$mail->isHTML(true);
$mail->Subject = $subject;
$body = nl2br("<h2>You have received a new message from SageTitans website contact form.</h2>"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nPhone: $phone\n\nAdditional Information:\n$content\n\n Services Required: \n $services");
if(!empty($website_url)) {
	$body .= nl2br("\n\n Website URL: \n $website_url");
}
$mail->msgHTML($body);


try {
	$mail->send();
	$data = array(
	"status" => true,
	"message" => 'Your contact information is received successfully.'
	);
	echo json_encode($data);
} catch (Exception $e) {
	$data = array(
		"status" => false,
		"message" => "Mailer Error: " . $mail->ErrorInfo
	);
	echo json_encode($data);
}