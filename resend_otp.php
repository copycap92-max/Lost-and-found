<?php

session_start();

$_POST['email'] = $_SESSION['email'];

include 'send_otp.php';

?>