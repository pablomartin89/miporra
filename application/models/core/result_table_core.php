<?php

class ResultTable_Core extends CI_Model{

	var $id = null;
	var $match_id = null;
	var $team_id = null;
	var $pos = null;

	function __construct(){
		parent::__construct();
	}


	public function getId(){
		 return $this->id;
	}


	public function setMatchId($match_id){
		$this->match_id = $match_id;
	}


	public function getMatchId(){
		 return $this->match_id;
	}


	public function setTeamId($team_id){
		$this->team_id = $team_id;
	}


	public function getTeamId(){
		 return $this->team_id;
	}


	public function setPos($pos){
		$this->pos = $pos;
	}


	public function getPos(){
		 return $this->pos;
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
		$query = $this->db->get("result_table");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$ResultTable = self::toObject($row);
				$result[] = $ResultTable;
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
		$query = $this->db->get('result_table');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('result_table');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('result_table');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('result_table',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('result_table',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('result_table', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['match_id'] = $this->match_id;
		$array['team_id'] = $this->team_id;
		$array['pos'] = $this->pos;
		return $array;
	}


	protected function toObject($row){
		$ResultTable = new ResultTable();
		$ResultTable->id = $row['id'];
		$ResultTable->setMatchId($row['match_id']);
		$ResultTable->setTeamId($row['team_id']);
		$ResultTable->setPos($row['pos']);
		return $ResultTable;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setMatchId($object['match_id']);
			$this->setTeamId($object['team_id']);
			$this->setPos($object['pos']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setMatchId($object->getMatchId());
			$this->setTeamId($object->getTeamId());
			$this->setPos($object->getPos());
		}
	}

}

?>