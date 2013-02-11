<?php
require_once ('sfdc/SforcePartnerClient.php');
require_once ('sfdc/SforceHeaderOptions.php');
 
// Salesforce.com credentials
$sfdcUsername = "fatibhussain@eocean.com.pk";
$sfdcPassword = "fati7132567";
$sfdcToken = "jg1TA1dktbaTvtZMsqG6PaGh";
// the email address to search for. could also use a post/get variable
$searchEmail = 'phpblogtest@noemail.com';

 
$sfdc = new SforcePartnerClient();
// create a connection using the partner wsdl
$SoapClient = $sfdc->createConnection("sfdc/partner.wsdl.xml");
$loginResult = false;
 
try {
    // log in with username, password and security token if required
    $loginResult = $sfdc->login($sfdcUsername, $sfdcPassword.$sfdcToken);
} catch (Exception $e) {
    global $errors;
    $errors = $e->faultstring;
    echo "Fatal Login Error <b>" . $errors . "</b>";
    die;
}
 
// setup the SOAP client modify the headers
$parsedURL = parse_url($sfdc->getLocation());
define ("_SFDC_SERVER_", substr($parsedURL['host'],0,strpos($parsedURL['host'], '.')));
define ("_WS_NAME_", "PersonService");
define ("_WS_WSDL_", "sfdc/" . _WS_NAME_ . ".wsdl.xml");
define ("_WS_ENDPOINT_", 'https://' . _SFDC_SERVER_ . '.salesforce.com/services/wsdl/class/' . _WS_NAME_);
define ("_WS_NAMESPACE_", 'http://soap.sforce.com/schemas/class/' . _WS_NAME_);
 
$client = new SoapClient(_WS_WSDL_);
$sforce_header = new SoapHeader(_WS_NAMESPACE_, "SessionHeader", array("sessionId" => $sfdc->getSessionId()));
$client->__setSoapHeaders(array($sforce_header));
 
//echo _SFDC_SERVER_."br";
//echo _WS_NAME_."br";
//echo _WS_WSDL_."br";
//echo _WS_ENDPOINT_."br";
//echo _WS_NAMESPACE_."p";
 
try {
 
    // call the web service via post
    $wsParams=array('email'=>$searchEmail);
    $response = $client->searchByEmail($wsParams);
    // dump the response to the browser
    //print_r($response);
    var_dump($response);
 
// this is really bad.
} catch (Exception $e) {
    global $errors;
    $errors = $e->faultstring;
    echo "Ooop! Error: <b>" . $errors . "</b>";
    die;
}
?>
