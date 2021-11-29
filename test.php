<?php
// echo 'begin ';
// $context = stream_context_create( array(
//                         'ssl' => array(
// 			'verify_peer'      => false,
//                         'verify_peer_name' => false,
// )
// ) );
// $res = file_get_contents( 'https://172.217.26.138/maps/api/geocode/json?address=Centrepoint%20Bandar%20Utama&amp;key=AIzaSyCp3Hxu8t-cUuEcPh68Jv-0BEMHWALGMNk&amp;components=country:MY', FALSE, $context );
/*
$curl = curl_init();
curl_setopt_array( $curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://172.217.26.138/maps/api/geocode/json?address=Centrepoint%20Bandar%20Utama&amp;key=AIzaSyCp3Hxu8t-cUuEcPh68Jv-0BEMHWALGMNk&amp;components=country:MY'
) );
$res = curl_exec( $curl );
curl_close( $curl );
*/
// echo 'Result '.$res;
// echo ' End';

header( 'Access-Control-Allow-Origin: *' );
require_once( 'config.php' );
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
    //$mail->addAddress( 'capecoi@yahoo.com', 'rusman' );
    // $mail->addAddress( 'hafizpras@gmail.com', 'Hafiz' );
    $mail->addAddress( 'jeevan@zoomitnow.co', 'Jeevan' );
    $mail->Subject = 'Zoom Delivery Status';

    $strHTML =  file_get_contents( 'template1.html' );
    // echo $strHTML;
    // exit;
    $mail->MsgHTML( $strHTML );
    $mail->AltBody = 'Testing Template';

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
