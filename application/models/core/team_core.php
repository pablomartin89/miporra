<?php

class Team_Core extends CI_Model{

	var $id = null;
	var $sport_id = null;
	var $name = null;
	var $scrap_name = null;

	function __construct(){
		parent::__construct();
	}


	public function getId(){
		 return $this->id;
	}


	public function setSportId($sport_id){
		$this->sport_id = $sport_id;
	}


	public function getSportId(){
		 return $this->sport_id;
	}


	public function setName($name){
		$this->name = $name;
	}


	public function getName(){
		 return $this->name;
	}


	public function setScrapName($scrap_name){
		$this->scrap_name = $scrap_name;
	}


	public function getScrapName(){
		 return $this->scrap_name;
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
		$query = $this->db->get("team");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$Team = self::toObject($row);
				$result[] = $Team;
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
		$query = $this->db->get('team');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('team');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('team');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('team',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('team',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('team', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['sport_id'] = $this->sport_id;
		$array['name'] = $this->name;
		$array['scrap_name'] = $this->scrap_name;
		return $array;
	}


	protected function toObject($row){
		$Team = new Team();
		$Team->id = $row['id'];
		$Team->setSportId($row['sport_id']);
		$Team->setName($row['name']);
		$Team->setScrapName($row['scrap_name']);
		return $Team;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setSportId($object['sport_id']);
			$this->setName($object['name']);
			$this->setScrapName($object['scrap_name']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setSportId($object->getSportId());
			$this->setName($object->getName());
			$this->setScrapName($object->getScrapName());
		}
	}

}

?>