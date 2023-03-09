<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require '../../vendor/autoload.php';
require '../../../vendors.v2/PHPMailer/src/PHPMailer.php';
require '../../../vendors.v2/PHPMailer/src/SMTP.php';
function sendEmailAttachment($sender, $password, $recipient, $replyTo, $attachment, $message){
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $sender["Email"];                     //SMTP username
        $mail->Password   = $password;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($sender["Email"], $sender["Name"]);
        $mail->addAddress($recipient["Email"], $recipient["Name"]);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo($replyTo["Email"], $replyTo["Name"]);
    

        //Attachments
        if($attachment <> null ){
            foreach($attachment as $files){

                $mail->addAttachment("../files/temp/$files"); 
            }  
        }      //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $message["subject"];
        $mail->Body    = $message["body"];

        $mail->send(); 
        return array("response"=>"success","data"=> "success" );
                    
    } 
    catch (Exception $e) {
        return array("response"=>"success","data"=> "Message could not be sent. Mailer Error: {$mail->ErrorInfo}" );
        // return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}