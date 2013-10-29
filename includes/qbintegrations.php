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
	  
	  if($res) { return $res; }
	  else { return 'failed to update'; }
}
?>
