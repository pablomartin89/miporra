<?php

class Season_Core extends CI_Model{

	var $id = null;
	var $competition_id = null;
	var $name = null;
	var $number = null;
	var $date_start = null;
	var $active = null;

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


	public function setDateStart($date_start){
		$this->date_start = $date_start;
	}


	public function getDateStart(){
		 return $this->date_start;
	}


	public function setActive($active){
		$this->active = $active;
	}


	public function getActive(){
		 return $this->active;
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
		$query = $this->db->get("season");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$Season = self::toObject($row);
				$result[] = $Season;
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
		$query = $this->db->get('season');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('season');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('season');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('season',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('season',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('season', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['competition_id'] = $this->competition_id;
		$array['name'] = $this->name;
		$array['number'] = $this->number;
		$array['date_start'] = $this->date_start;
		$array['active'] = $this->active;
		return $array;
	}


	protected function toObject($row){
		$Season = new Season();
		$Season->id = $row['id'];
		$Season->setCompetitionId($row['competition_id']);
		$Season->setName($row['name']);
		$Season->setNumber($row['number']);
		$Season->setDateStart($row['date_start']);
		$Season->setActive($row['active']);
		return $Season;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setCompetitionId($object['competition_id']);
			$this->setName($object['name']);
			$this->setNumber($object['number']);
			$this->setDateStart($object['date_start']);
			$this->setActive($object['active']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setCompetitionId($object->getCompetitionId());
			$this->setName($object->getName());
			$this->setNumber($object->getNumber());
			$this->setDateStart($object->getDateStart());
			$this->setActive($object->getActive());
		}
	}

}

?>