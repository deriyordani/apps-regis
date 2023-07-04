<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Class Email extends CI_Controller{
	function __construct(){
		parent::__construct();

		require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';
        //require 'PHPMailer-master/PHPMailerAutoload.php';
	}

	function send(){

		$mail = new PHPMailer;
		//$mail->SMTPDebug = 2;
		$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP(); 

		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
		);

                                     // Set mailer to use SMTP
	    $mail->Host     = 'mail.imahsoft.online'; //sesuaikan sesuai nama domain hosting/server yang digunakan
	    $mail->SMTPAuth = true;
	    $mail->Username = 'auto-reply@imahsoft.online'; // user email
	    $mail->Password = 'Kania123!'; // password email
	    // $mail->SMTPSecure = 'tls';
	    $mail->SMTPSecure = 'ssl';
		//$mail->SMTPAutoTLS = false;
	    $mail->Port     = 465;                                  // TCP port to connect to

		$mail->From = 'hello@imahsoft.online';
		$mail->FromName = 'Test phpmailer coba lagi';
		$mail->addAddress('dyordhanideri@gmail.com');               // Name is optional

		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Here is the subject';
		$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}


		
		// PHPMailer object
    //  $response = false;
    //  $mail = new PHPMailer();
   

    // // SMTP configuration
    // $mail->isSMTP();
    // $mail->Host     = 'mail.kpu-cimahi.com'; //sesuaikan sesuai nama domain hosting/server yang digunakan
    // $mail->SMTPAuth = true;
    // $mail->Username = 'info@kpu-cimahi.com'; // user email
    // $mail->Password = 'Merdeka2022!'; // password email
    // $mail->SMTPSecure = 'ssl';
    // $mail->Port     = 465;

    // $mail->setFrom('info@kpu-cimahi.com', ''); // user email
    // //$mail->addReplyTo('xxx@hostdomain.com', ''); //user email

    // // Add a recipient
    // $mail->addAddress('dyordhanideri@gmail.com'); //email tujuan pengiriman email

    // // Email subject
    // $mail->Subject = 'SMTP Codeigniter'; //subject email

    // // Set email format to HTML
    // $mail->isHTML(true);

    // // Email body content
    // $mailContent = "<h1>SMTP Codeigniterr</h1>
    //     <p>Laporan email SMTP Codeigniter.</p>"; // isi email

    // $mailContent = "<h3>Dokumen Terbaru</h3>
    //                 <p>Hallo Sahabat KPU, <br/></p>"; // isi email
    // $mail->Body = $mailContent;

    // // Send email
    // if(!$mail->send()){
    //     echo 'Message could not be sent.';
    //     echo 'Mailer Error: ' . $mail->ErrorInfo;
    // }else{
    //     echo 'Message has been sent';
    // }

	}
}