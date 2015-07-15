<?php
require 'PHPMailer/PHPMailerAutoload.php';

$response = '';
$contactForm = array();
if (!function_exists('http_response_code')) {
    function http_response_code($newcode = NULL)
    {
        static $code = 200;
        if ($newcode !== NULL) {
            header('X-PHP-Response-Code: ' . $newcode, true, $newcode);
            if (!headers_sent()) {
                $code = $newcode;
            }
        }
        return $code;
    }
}

if (!empty($_POST)) {
    $mail = new PHPMailer();
    $mail->From = $_POST['email'];
    $mail->FromName = $_POST['name'];
    $mail->addAddress('info@softologic.dk');
    $mail->Subject = 'Contact form message';
    $mail->Body = $_POST['message'];

    if ($mail->send()) {
        $response = "Email sent successfully!";
        http_response_code(200);
    } else {
        http_response_code(404);
        error_log($mail->ErrorInfo);
        $response = 'Email sending failed. Please try again!';
    }
} else {
    $response = "No data sent!";
    http_response_code(404);
}

echo json_encode($response);

