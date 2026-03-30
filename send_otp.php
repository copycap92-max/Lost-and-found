<?php

session_start();

require_once __DIR__ . '/config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/PHPMailer-master/src/Exception.php';
require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';


if(isset($_POST['email'])){

$email = $_POST['email'];
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "Email not registered";
    exit();
}

$otp = rand(100000,999999);

$_SESSION['otp'] = $otp;
$_SESSION['email'] = $email;
$_SESSION['otp_expiry'] = time() + 300; 

$mail = new PHPMailer(true);

try {

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;

$mail->Username = 'youremail';
$mail->Password = 'your password'; 

$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;

$mail->setFrom('copycap92@gmail.com', 'Lost & Found System');
$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject = 'Password Reset OTP';
$mail->Body = "Your OTP is: <b>$otp</b>";

$mail->send();

header("Location: verify_otp.php");
exit();

}catch(Exception $e){

echo "Mailer Error: " . $mail->ErrorInfo;

}

}else{

echo "Invalid Request";

}

?>
