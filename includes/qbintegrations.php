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

function addCertificateQB ($docType, $i, $quickbaseCert){
    $status = true;
    if ($docType == 'Resale Certificate') {
        $uploadFile  = 'cResellerDoc_'.$i;
        $uploadState = 'selectResellerState_'.$i;
        $certType = 'Resale Certificate';
    }else {
        $uploadFile  = 'cTaxExmptDoc_'.$i;
        $uploadState = 'selectTaxExmptState_'.$i;
        $certType    = 'Tax Exemption Document';
    }
    
    $uploads = '';
    if($_FILES[$uploadFile]['name']) {
        $file_name = $_FILES[$uploadFile]['name'];
        $f_tmp_name = $_FILES[$uploadFile]['tmp_name'];
        $file_size = $_FILES[$uploadFile]['size'];
        
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
            'value' => $_POST[$uploadState]),
        array(
            'fid'   => '8',
            'value'=> date('Y-m-d')),
        array(
            'fid'   => '10',
            'value'=> $docType,
        array(
            'fid'   => '11',
            'value'=> $_POST['cNumber']),
        array(
            'fid'   => '12',
            'value'=> $certType)
        ));

        $res = $quickbaseCert->add_record($fields, $uploads);
    
        
        if($res->errcode == 0) 
        {
            $fields = array(
                    array(
                        'fid'   => '11',
                        'value' => $_POST['cNumber']),
                    array(
                        'fid'   => '12',
                        'value'=> $certType)
            );
        
            $rid = $res->rid;
            //echo 'rid:' . $rid;
            //echo 'cno:'. $_POST['cNumber'];
            $res = $quickbaseCert->edit_record($rid, $fields);
            /*if ($docType != 'Resale Certificate') {   
                echo '<pre>';
                echo 'rid:'.$rid;
                print_r($fields);
                print_r($res);
            } */
            if($res->errcode != 0) { $status = false; }
        } else {
            $status = false;
        }
        return $status;
}

function addCertificates($quickbaseCert){
	//$sellerCnt = 0; $txEmptCnt = 0;
    $sellerCnt = $_POST['totalSellerCert'];
    $txEmptCnt = $_POST['totalTaxCert'];
    $status = true;
    if ($sellerCnt > 0) {
        for ($i=1; $i<= $sellerCnt; $i++){            
            $status = addCertificateQB ('Resale Certificate', $i, $quickbaseCert);            
        }
    }
	
    if ($txEmptCnt > 0) {
        for ($i=1; $i<= $txEmptCnt; $i++){            
            $status = addCertificateQB ('Tax Exempt Document', $i, $quickbaseCert);            
        }
    }
    
    return $status;
}

?>
