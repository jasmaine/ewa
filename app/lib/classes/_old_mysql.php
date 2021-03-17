<?php

/*
 * Dynamic JS queries
 *
 */

class Mysql {
	
	static private $where;
	static private $limit;
	static private $orderby;
	
	public function __construct() { 
		
		$this->db = \Database::initConnection(); 
	
	}
	
	
	static private function _where($info, $type = 'AND'){
		
		foreach($info as $row => $value){
			
			if(empty($where)){
				
				$where = sprintf("WHERE %s='%s'", $row, $value);				
				
				
			} else {
				
				$where .= sprintf(" %s %s='%s'", $type, $row, $value);
				
			}
			
		}
		
		self::$where = $where;
		
		
	}
	
	
	static private function _limit($from, $end) {
		
		if($end == '') {
			
			$limit = sprintf("LIMIT %s", $from);
			
		} else {
			
			$limit = sprintf("LIMIT %s, %s", $from, $end);
			
		}
		
		self::$limit = $limit;
		
		
	}
	
	static private function _orderby($field, $direction) {
		
		$orderby = sprintf("ORDER BY %s %s", $field, $direction);
		
		self::$orderby = $orderby;
		
	}
	
	static private function _extra() {
		
		$extra = '';
		
		if(self::$where != NULL) { $extra .= ' '.self::$where; }
		if(self::$orderby != NULL) { $extra .= ' '.self::$orderby; }
		if(self::$limit != NULL) { $extra .= ' '.self::$limit; }
		
		return $extra;
		
	}
	
	
	public function where($field, $equal = NULL) {
		
		if(is_array($field)){
			
			self::_where($field);
			
		} else {
			
			self::_where(array($field => $equal));
		}
		
		return $this;
		
	}


	public function limit($from, $end = '') {
		
		self::_limit($from, $end);
		
		return $this;
		
	}
	
	
	public function orderby($field, $direction = 'DESC') {
		
		self::_orderby($field, $direction);
			
		return $this;
			
	}
	

	public function get($table, $select = '*') {
		
		$sql = sprintf("SELECT %s FROM %s%s", $select, $table, self::_extra());
		
		$stmt = $this->db->prepare($sql);
		
		$stmt->execute();
		
		$result = $stmt->get_result();
		
		/*
		if(!$result) {
			
			echo $this->db->error;
		}
		*/
		
		if($result->num_rows == 0) {
			
			$data = false;
			
		} elseif($result->num_rows == 1){
			
			$data = $result->fetch_object();
			
		} else {
			
			$data = array();
			
			while($row = $result->fetch_object()) {
				
				$data[] = $row;
				
			}
			
		}
		
		return $data;
		
	}
	
	
	public function query($sql) {
		
		$result = $this->db->query($sql);
		
		if($result->num_rows == 0) {
			
			$data = false;
			
		} elseif($result->num_rows == 1){
			
			$data = $result->fetch_object();
			
		} else {
			
			$data = array();
			
			while($row = $result->fetch_object()) {
				
				$data[] = $row;
				
			}
			
		}
		
		return $data;
		
	}
	
}
