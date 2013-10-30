<?php
include_once('./includes/quickbase.php');
include_once('./includes/qbintegrations.php');
// Quickbase credentials
$usrName      = 'qb@metro.com';
$pwd          = 'vv05052012';
$appToken     = 'cwfcy7gdzqrsyncqbi2bn4u4kr';
$qbDomain     = 'intermetro';
$expTime      = '10'; //in minutes

$dbIdCustomer = 'bihs6kh6p';
$dbIdCert     = 'bihs6kh9m';


$quickbase = new QuickBase($usrName, $pwd, true, $dbIdCustomer,$appToken, $qbDomain, $expTime);

$type = $_POST['type'];
//echo '<pre>';
//print_r($quickbase);

switch ($type) {
    case 'validateCustomerNumber':
        echo json_encode(getCustomerDetails($quickbase, $_POST['cNumber']));
        break;
    case 'postdata' :
	//echo '<pre>';
	$quickbaseCert = new QuickBase($usrName, $pwd, true, $dbIdCert,$appToken, $qbDomain, $expTime);
	if (addCertificates ($quickbaseCert)){
        echo '<b style="color:#076F1A;font-size:14px;">Certificates has been sccessfully uploaded ...</b>';        
    }else {
        echo '<b style="color:#FF001A;font-size:14px;">Failed to upload certificates</b>';        
    }
    echo '<br>';
	if( updateCustomerData($quickbase, $_POST)) {
		echo '<b style="color:#076F1A;font-size:14px;">Customer information has been successfully updated ...</b>';
	} else {
		echo '<b style="color:#FF001A;font-size:14px;">Failed to update the customer information</b>';
	}
	
	//print_r($_POST);
	//print_r($_FILES);
	break;
    
}


?>

