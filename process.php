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


$quickbase = new QuickBase($usrName, $pwd, true, $dbIdCustomer,$appToken, $qbDomain, $expTime);

$type = $_POST['type'];
//echo '<pre>';
//print_r($quickbase);

switch ($type) {
    case 'validateCustomerNumber':
        echo json_encode(getCustomerDetails($quickbase, $_POST['cNumber']));
        break;
    case 'postdata' :
	echo '<pre>';
	echo updateCustomerData($quickbase, $_POST);
	
	//print_r($_POST);
	//print_r($_FILES);
	break;
    
}


?>

