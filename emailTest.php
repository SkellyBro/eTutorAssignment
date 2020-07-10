<?php
require('phpmailer/PHPMailerAutoload.php');

$mail= new PHPMailer();

	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecture = 'ssl';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = '465';
	$mail->isHTML();
	$mail->Username='ewsdgroup2018@gmail.com';
	$mail->Password= 'EWSD2018';
	$mail->SetFrom('no-reply@eTutor.com');
	$mail->Subject='Tutor Allocation';
	$mail->Body= 'Hello Sir/Madam, 
		Please be advised that you have been allocated to one of our tutors! 
		
		Please note that this email is automated, please do not reply to this. 
		
		Kind Regards,
		eTutor Staff';
	$mail->AddAddress('buster0lion@gmail.com');
	
	$mail->Send();

?>