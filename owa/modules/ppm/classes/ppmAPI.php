<?php 

class owa_ppmAPI {
	
	var $db;
	
	function __construct(){
		$this->db = owa_coreAPI::dbSingleton();
	}
	
	function getAllPPMUserNames(){
		$this->db->selectFrom('owa_visitor');
		$this->db->selectColumn('user_name');
		$results = $this->db->getAllRows();
		$rs = $this->columnResultToArray($results, 'user_name');
		return array_unique($rs);
	}
	
	function columnResultToArray($results, $colName){
		$array = array();
		foreach ($results as $result){
			if (!(array_key_exists($colName, $result)))
				continue;
			$array[] = $result[$colName];
		} 
		return $array;
	}
	
	function getUserActions($user){
		$this->db->selectFrom('owa_action_fact');
		$this->db->selectColumn('timestamp,action_group,action_name,action_label');
		$this->db->where('user_name', $user);
		$results = $this->db->getAllRows();
		return $results;
	}
}

?>