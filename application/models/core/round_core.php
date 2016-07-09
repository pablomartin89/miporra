<?php

class Round_Core extends CI_Model{

	var $id = null;
	var $competition_id = null;
	var $name = null;
	var $number = null;
	var $date = null;

	function __construct(){
		parent::__construct();
	}


	public function getId(){
		 return $this->id;
	}


	public function setCompetitionId($competition_id){
		$this->competition_id = $competition_id;
	}


	public function getCompetitionId(){
		 return $this->competition_id;
	}


	public function setName($name){
		$this->name = $name;
	}


	public function getName(){
		 return $this->name;
	}


	public function setNumber($number){
		$this->number = $number;
	}


	public function getNumber(){
		 return $this->number;
	}


	public function setDate($date){
		$this->date = $date;
	}


	public function getDate(){
		 return $this->date;
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
		$query = $this->db->get("round");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$Round = self::toObject($row);
				$result[] = $Round;
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
		$query = $this->db->get('round');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('round');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('round');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('round',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('round',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('round', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['competition_id'] = $this->competition_id;
		$array['name'] = $this->name;
		$array['number'] = $this->number;
		$array['date'] = $this->date;
		return $array;
	}


	protected function toObject($row){
		$Round = new Round();
		$Round->id = $row['id'];
		$Round->setCompetitionId($row['competition_id']);
		$Round->setName($row['name']);
		$Round->setNumber($row['number']);
		$Round->setDate($row['date']);
		return $Round;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setCompetitionId($object['competition_id']);
			$this->setName($object['name']);
			$this->setNumber($object['number']);
			$this->setDate($object['date']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setCompetitionId($object->getCompetitionId());
			$this->setName($object->getName());
			$this->setNumber($object->getNumber());
			$this->setDate($object->getDate());
		}
	}

}

?>