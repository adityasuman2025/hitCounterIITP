<?php

require './libphp-phpmailer/class.phpmailer.php';
require './libphp-phpmailer/class.smtp.php';
$base_url = 'http://172.16.26.43/'; 

$mail = new PHPMailer;

//Truncated many lines 

if ($query1->num_rows != 0)
{
	$mail->setFrom('no-reply@iitp.ac.in');//no-reply@cse.iitp.ac.in
	$mail->addAddress($email);
	if ($flag_co_supervisor ==1)
	{$mail->addAddress($cemail);}

	$mail->Subject = 'Thesis For approval';
	$mail->Body ="Dear Professor, <br><br> Roll Number: ".$rollno." <br>  Name : ".$name." <br>  Thesis Title : ".$thesis_title."  <br><br> has requested for thesis approval. <br>  In case 
		the student has a Co-Supervisor, he/she will also receive a copy of this email.	Either of you can approve the thesis. <p> <br>Thesis Download link : ".$linkt."<br>Certificate Download link : ".$linkc."<br>Approve thesis link : ".$linka;
	//$mail->AddAttachment("thesis_pdfs/".$roll."_thesis.pdf");
	$mail->IsSMTP();
	$mail->isHTML(true);
	$mail->SMTPSecure = '';
	$mail->Host = '172.16.1.2'; //'ssl://smtp.gmail.com'; :995/pop3/ssl/novalidate-cert
	$mail->SMTPAuth = false;
	$mail->Port =25;

	if(!$mail->send())
	{
		echo 'Email is not sent.';
		echo 'Email error: ' . $mail->ErrorInfo;
	}
	else
	{
		echo 'You will shortly recieve a Mail.. ';
	}
}
else
	echo "Invalid Faculty email";

	}
?>



