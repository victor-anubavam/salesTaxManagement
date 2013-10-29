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
		// convert simple xml element object to array for better manipulation
		$results = (array) $results->table->records->record;    
		if (array_key_exists ('f', $results) ) {
			$records = $results['f'];
			$records['result'] = $records;
			
   		} else {
     			$records['result'] = 'no matching record found';
   		}
	} catch (Exception $e) {
   		$records['result'] = 'no matching record found';
	}
	
	return $records;
}
?>
