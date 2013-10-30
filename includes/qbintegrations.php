<?php
function getCustomerDetails($quickbase, $customerNumber) {
	$queries = array(
            array(
                'fid'   => '6',        // field id to be searched
                'ev'    => 'EX',       // EX - look for exact match
                'cri'   => $customerNumber)    // value to be searched
             );

	try { 
		$results = $quickbase->do_query($queries, '', '');  
		//echo '<pre>';		
		//print_r($results);		
		// convert simple xml element object to array for better manipulation
		$results = (array) $results->table->records->record;    
		if (array_key_exists ('f', $results) ) {
			$res['recs'] = $results['f'];
			$res['rid'] =  $results['@attributes']['rid'];
			$records['result'] = $res;
			
   		} else {
     			$records['result'] = 'no matching record found';
   		}
	} catch (Exception $e) {
   		$records['result'] = 'no matching record found';
	}
	
	return $records;
}

function updateCustomerData ($quickbase, $dataArray) {
	$fields = array(
	    array(
		'fid'   => '14',
		'value' => $dataArray['cContactName']),
	    array(
		'fid'   => '15',
		'value' => $dataArray['cEmail']),
	    array(
		'fid'   => '16',
		'value'=>  $dataArray['cTele']),
	    array(
		'fid'   => '17',
		'value'=>  $dataArray['cFax']),
	    array(
		'fid'   => '18',
		'value'=> $dataArray['cWebsite'])
	  );
	  //echo 'rid: '.$dataArray['rid'].'<br>';
	  //print_r($fields);
	$res = $quickbase->edit_record($dataArray['rid'], $fields);
	  
	if($res != '') { 
		return  $res ; 
	}
	 else { 
		return false; 
	}

}

function addCertificates($quickbaseCert){
	//print_r($_POST);
	//echo '<pre>';
	//print_r($_FILES);
	//echo 'cust num:'.$_POST['cNumber'].'<br>';
	// any file upload?
	if($_FILES['cResellerDoc']['name']) {
		$file_name = $_FILES['cResellerDoc']['name'];
		$f_tmp_name = $_FILES['cResellerDoc']['tmp_name'];
		$file_size = $_FILES['cResellerDoc']['size'];
		$fh = fopen($f_tmp_name, 'r');
		$content = fread($fh, $file_size);
		$content = base64_encode($content);
		fclose($fh);
		$uploads = array( array('fid' => '7',
		'filename' => $file_name,
		'value' => $content) );
	}
	$fields = array(
            array(
                'fid'   => '6',
                'value' => $_POST['selectResellerState']),
            array(
                'fid'   => '8',
                'value'=> date('Y-m-d')),
            array(
                'fid'   => '10',
                'value'=> 'Resale Certificate',
            array(
                'fid'   => '11',
                'value'=> $_POST['cNumber']),
            array(
                'fid'   => '12',
                'value'=> 'Resale Certificate')
            ));
	$res = $quickbaseCert->add_record($fields, $uploads);
    //echo '<pre>aaa';
    //print_r($res);
    if($res->errcode == 0) {
        $fields = array(
            array(
                'fid'   => '11',
                'value' => $_POST['cNumber']),
            array(
                'fid'   => '12',
                'value'=> 'Resale Certificate')
	    );
        
        $rid = $res->rid;
        //echo 'rid:' . $rid;
        //echo 'cno:'. $_POST['cNumber'];
        $res = $quickbaseCert->edit_record($rid, $fields);
    }
    
    if($res->errcode == 0) {
        return true;
    }
    
    return false;
}

?>
