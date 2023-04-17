<?php
session_start();
ini_set('upload_max_filesize', '40000M');
ini_set('post_max_size', '40000M');
ini_set('max_input_time', 300000);
ini_set('max_execution_time', '-1');

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/*Email Template Render*/
function render_email($email, $data) {
    ob_start();
    include "contact-us-mail.phtml";
    return ob_get_contents();
}

if($_POST)
{
	$data['fullname'] = isset($_POST['fullname']) ? $_POST['fullname']:'';
	// $data['companyname'] = isset($_POST['companyname']) ? $_POST['companyname']:'';
	$data['useremail'] = isset($_POST['useremail']) ? $_POST['useremail']:'';
	// $data['mobnum'] = isset($_POST['mobnum']) ? $_POST['mobnum']:'';
	// $data['address'] = isset($_POST['address']) ? $_POST['address']:'';
	// $data['city'] = isset($_POST['city']) ? $_POST['city']:'';
	// $data['country'] = isset($_POST['country']) ? $_POST['country']:'';
	// $data['pin'] = isset($_POST['pin']) ? $_POST['pin']:'';
	$data['message'] = isset($_POST['message']) ? $_POST['message']:'';
	$body = render_email('email', $data);

	$subject = "You have a message from your client from contact us";

	$to = "arunkumarddd12@gmail.com";
    //$to = "prasannakanthan@gmail.com";
	$from = "arunkumarddd12@gmail.com";

	//PHPMailer Object
	$mail = new PHPMailer\PHPMailer\PHPMailer(); //Argument true in constructor enables exceptions

	 // $mail->SMTPDebug = 3;  
	$mail->SMTPDebug = false;  
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();            
	//Set SMTP host name                          
	$mail->Host = "smtp.gmail.com";
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;                          
	//Provide username and password     
	$mail->Username = "arunkumarddd12@gmail.com";                 
	$mail->Password = "lbuueoyvnsjtwnml";                           
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "ssl";                           
	//Set TCP port to connect to
	$mail->Port = 465; 

	//From email address and name
	$mail->From = $from;
	$mail->FromName = "contact us details";

	//To address and name
	//$mail->addAddress("limtion.digital@gmail.com", "Limtion Site");
	$mail->addAddress($to); //Recipient name is optional

	//Address to which recipient will reply
	// $mail->addReplyTo("aaranrims@yourdomain.com", "Reply");

	//CC and BCC
	//$mail->addCC("aaranrims@gmail.com");
	//$mail->addBCC("bcc@example.com");

	//Send HTML or Plain Text email
	$mail->isHTML(true);

	$mail->Subject = $subject;
	$mail->Body = $body;


try {
    $mail->send();
     echo "sent";
     $_SESSION['status'] = "success";
} catch (Exception $e) {
    print_r(error_get_last());
	    echo "Error: Message not accepted";
	    $_SESSION['status'] = "failure";
}

}
 header("Location:https://roamino.netlify.app/");
//header("Location: ". $_SERVER['HTTP_REFERER']);
exit;
?>
