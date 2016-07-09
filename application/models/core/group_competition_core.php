<?php

class GroupCompetition_Core extends CI_Model{

	var $id = null;
	var $group_id = null;
	var $competition_id = null;
	var $season_id = null;
	var $group_competition_type = null;

	function __construct(){
		parent::__construct();
	}


	public function getId(){
		 return $this->id;
	}


	public function setGroupId($group_id){
		$this->group_id = $group_id;
	}


	public function getGroupId(){
		 return $this->group_id;
	}


	public function setCompetitionId($competition_id){
		$this->competition_id = $competition_id;
	}


	public function getCompetitionId(){
		 return $this->competition_id;
	}


	public function setSeasonId($season_id){
		$this->season_id = $season_id;
	}


	public function getSeasonId(){
		 return $this->season_id;
	}


	public function setGroupCompetitionType($group_competition_type){
		$this->group_competition_type = $group_competition_type;
	}


	public function getGroupCompetitionType(){
		 return $this->group_competition_type;
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
		$query = $this->db->get("group_competition");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$GroupCompetition = self::toObject($row);
				$result[] = $GroupCompetition;
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
		$query = $this->db->get('group_competition');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('group_competition');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('group_competition');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('group_competition',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('group_competition',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('group_competition', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['group_id'] = $this->group_id;
		$array['competition_id'] = $this->competition_id;
		$array['season_id'] = $this->season_id;
		$array['group_competition_type'] = $this->group_competition_type;
		return $array;
	}


	protected function toObject($row){
		$GroupCompetition = new GroupCompetition();
		$GroupCompetition->id = $row['id'];
		$GroupCompetition->setGroupId($row['group_id']);
		$GroupCompetition->setCompetitionId($row['competition_id']);
		$GroupCompetition->setSeasonId($row['season_id']);
		$GroupCompetition->setGroupCompetitionType($row['group_competition_type']);
		return $GroupCompetition;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setGroupId($object['group_id']);
			$this->setCompetitionId($object['competition_id']);
			$this->setSeasonId($object['season_id']);
			$this->setGroupCompetitionType($object['group_competition_type']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setGroupId($object->getGroupId());
			$this->setCompetitionId($object->getCompetitionId());
			$this->setSeasonId($object->getSeasonId());
			$this->setGroupCompetitionType($object->getGroupCompetitionType());
		}
	}

}

?>