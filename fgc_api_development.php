<?php
//Message
$msg = rawurlencode("This is testing message");

//cell/Receiver
//Multi i.e:923337132567,03463965457
//Single i.e:923337132567
$cell = '';
//Masking /Sender
$mask = '';
//Username API
$user = '';
//Password API
$pas = '';
//Api
//Tip Kindly confirm your URL same/match
$url="http://xyz.com/api?action=sendmessage&username=$user&password=$pas&recipient=$cell&originator=$mask&messagedata=$msg";
$data = file_get_contents($url);
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