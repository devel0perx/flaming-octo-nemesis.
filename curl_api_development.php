<?php
//Display error while on developmet phase
ini_set('display_errors', '1');
    //msg endode
$msg = rawurlencode("Dear customer Thank you for order no.12345");
//cell/Receiver
//Multi i.e:923337132567,03463965457
//Single i.e:923337132567      923202795373
$cell = '923337132567';
//Masking /Sender/shortcode
$mask = '12345';
//Username API
$user = 'username';
//Password API
$pas = '***********';
//curl Api
//Tip Kindly confirm your URL same/match
$url_sms = "http://xyz.com/api?action=sendmessage&username=$user&password=$pas&recipient=$cell&originator=$mask&messagedata=$msg";
   // curl intiliaze
   $curl_handle = curl_init();
   //// set url
   curl_setopt($curl_handle, CURLOPT_URL, $url_sms);
   //
   curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
   curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl_handle, CURLOPT_POST, 1);
   curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "");   
   $data = curl_exec($curl_handle);
   curl_close($curl_handle);
//Print Response
  // print_r($data);
   
$xml = simplexml_load_string($data);

//Response
$response = $xml->data->acceptreport->statusmessage;
if($response == "Message accepted for delivery"){
  //updation that perticuler message/Query
echo 'Message Succesfully sent';
} else {
    //Exception
    echo 'Message could not sent';
}

?>