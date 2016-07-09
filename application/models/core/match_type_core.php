<?php

class MatchType_Core extends CI_Model{

	var $match_type = null;
	var $name = null;

	function __construct(){
		parent::__construct();
	}


	public function getMatchType(){
		 return $this->match_type;
	}


	public function setName($name){
		$this->name = $name;
	}


	public function getName(){
		 return $this->name;
	}


	public function get($property){
		if(property_exists($this,$property)){
			return $this->$property;
		}
	}


	public function set($property,$value){
		if(property_exists($this,$property)){
			$this->$property = $value;;
		}
		return $this;
	}


	public function fill($where = null, $singleResult=false, $orderby=null){
		if($where != null && $where!=""){
			if(is_array(reset($where))){
				list($key, $value) = each($where);
				$this->db->where_in($key,$value);
			}
			else{
				$this->db->where($where);
			}
		}
		if($orderby != null){
			$this->db->order_by($orderby);
		}
		$query = $this->db->get("match_type");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$MatchType = self::toObject($row);
				$result[] = $MatchType;
			}
			return $result;
		}
		else{
			if($singleResult){
				return false;
			}
			else{
				return array();
			}
		}
	}


	public function distinct($distinct, $where = null, $orderby=null){
		$this->db->distinct();
		$this->db->select($distinct);
		if($where != null && is_array($where)){
			$this->db->where($where);
		}
		if($orderby != null){
			$this->db->order_by($orderby);
		}
		$query = $this->db->get('match_type');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('match_type' => $this->match_type));
		$query = $this->db->get('match_type');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('match_type' => $this->match_type));
			$query = $this->db->get('match_type');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('match_type',$this->toArray());
		$this->match_type = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('match_type' => $this->match_type));
		$this->db->update('match_type',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('match_type', $where);
	}


	public function toArray(){
		$array = array();
		$array['match_type'] = $this->match_type;
		$array['name'] = $this->name;
		return $array;
	}


	protected function toObject($row){
		$MatchType = new MatchType();
		$MatchType->match_type = $row['match_type'];
		$MatchType->setName($row['name']);
		return $MatchType;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->match_type = $object['match_type'];
			$this->setName($object['name']);
		}
		else if(is_object($object)){
			$this->match_type = $object->match_type;
			$this->setName($object->getName());
		}
	}

}

?>