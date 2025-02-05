<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST["send"])){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ucupsucipto6@gmail.com';
    $mail->Password = 'oczf zgpr sqjm dkwz';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = '8080';
    
    $mail->setFrom('ucupsucipto6@gmail.com');
    $mail->addAddress($_POST['message']);
    $mail->isHTML(true);
    $mail->Subject = $_POST["subject"];
    $mail->Body = $_POST["message"];
    $mail->send();

    echo
    "
    <script>alert('Sent Succesfully');
    document.location.href = 'index.php'
    </script>
    ";
}

?>