<?php

header( 'Access-Control-Allow-Origin: *' );
// require_once( 'config.php' );
require_once( 'mail_config.php' );
require 'PHPMailerAutoload.php';

try {

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Timeout = 10;
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = $ZOOM_SMTP_SERVER;
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Username = $ZOOM_EMAIL_INFO;
    $mail->Password = $ZOOM_EMAIL_PASSWORD;
    $mail->setFrom( $ZOOM_EMAIL_INFO, $ZOOM_NAME_INFO );
    $mail->addReplyTo( $ZOOM_EMAIL_INFO, $ZOOM_NAME_INFO );
    $mail->addAddress( 'hafizpras@gmail.com', 'Hafiz' );
    // $mail->addAddress( 'jeevan@zoomitnow.co', 'Jeevan' );
    // $mail->addAddress( 'billy.tanudjaja@gmail.com', 'Billy' );
    // $mail->addAddress( 'vinod@zoomitnow.co', 'Vinod' );
    // $mail->addAddress( 'devan@zoomitnow.co', 'Devan' );
    $mail->Subject = 'Zoom Delivery Status';

    // $strHTML =  file_get_contents( 'template_default.html' );
    // $strHTML =  file_get_contents( 'template_with_banner.html' );
    // echo $strHTML;
    // exit;
    // $mail->MsgHTML( $strHTML );
    // $mail->AltBody = 'Testing Template';

    $email_template = 'template_default.html';
    $email_template2 = 'template_with_banner.html';

    $RECEIVER_NAME = 'Hafiz';
    $CLIENT_NAME = 'Vega';
    $TRACKING_ID = '3ce656a';
    $BANNER = '';
    if ( $BANNER == '' ) {

        $message = file_get_contents( $email_template );
        $message = str_replace( '%RECEIVER_NAME%', $RECEIVER_NAME, $message );
        $message = str_replace( '%CLIENT_NAME%', $CLIENT_NAME, $message );
        $message = str_replace( '%TRACKING_ID%', $TRACKING_ID, $message );
    } else {
        $message = file_get_contents( $email_template2 );
        $message = str_replace( '%RECEIVER_NAME%', $RECEIVER_NAME, $message );
        $message = str_replace( '%CLIENT_NAME%', $CLIENT_NAME, $message );
        $message = str_replace( '%TRACKING_ID%', $TRACKING_ID, $message );
        $message = str_replace( '%BANNER%', $BANNER, $message );
    }
    $mail->MsgHTML( $message );
    $mail->SMTPOptions = array (
        'ssl' => array(
            'verify_peer'  => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        )
    );

    $mail->send();

    echo 'success';
} catch ( phpmailerException $e ) {
    echo $e->errorMessage();
    //Pretty error messages from PHPMailer
} catch( Exception $e ) {
    $msg = $e->getMessage();
    echo '{"message":"Error : '.$msg.'"}';
}

?>
