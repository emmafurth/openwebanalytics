<?php 
// An example of a class for an OWA module
class owa_exampleClass {
	
	var $db;
	
	function __construct(){
		// get db object
		$this->db = owa_coreAPI::dbSingleton();
	}
	
	// Gets the user name associated with all vistors to the site(s) you are tracking
	function getAllUserNames(){
		$this->db->selectFrom('owa_visitor');
		$this->db->selectColumn('user_name');
		$results = $this->db->getAllRows();
		$rs = $this->columnResultToArray($results, 'user_name');
		return array_unique($rs); // Filters out duplicate results (OWA is bad at recognizing when a visitor is a repeat visitor)
	}
	
	// If you're only selecting a single column from the db, use this method to convert your results to a simple, one-dimensional array
	function columnResultToArray($results, $colName){
		$array = array();
		foreach ($results as $result){
			if (!(array_key_exists($colName, $result)))
				continue;
			$array[] = $result[$colName];
		} 
		return $array;
	}
	
	// Weirdly, the existing API does not have a method like this
	function getDimensionsForPicker(){
		$dims = owa_coreAPI::getAllDimensions();
		
		$pickerDims = array();
		
		foreach ($dims as $dimName => $dim){
			if (array_key_exists($dim['family'], $pickerDims))
				array_push($pickerDims[$dim['family']], array('label'=>$dim['label'], 'name'=>$dim['name']));
			else
				$pickerDims[$dim['family']] = array(array('label'=>$dim['label'], 'name'=>$dim['name']));
		}
		return $pickerDims;
	}
	
	function getMetricsForPicker(){
		$mets = owa_coreAPI::getAllMetrics();
		
		$pickerMets = array();
		
		foreach ($mets as $metName => $met){
			$tmp = $met[0];
			
			if (array_key_exists($tmp['group'], $pickerMets))
				array_push($pickerMets[$tmp['group']], array('label'=>$tmp['label'], 'name'=>$tmp['name']));
			else
				$pickerMets[$tmp['group']] = array(array('label'=>$tmp['label'], 'name'=>$tmp['name']));
		}
		return $pickerMets;
	}
}

?>