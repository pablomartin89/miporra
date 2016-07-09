<?php

class GroupCompetitionConfig_Core extends CI_Model{

	var $id = null;
	var $group_competition_id = null;
	var $match_type = null;
	var $points_result = null;
	var $points_winner = null;

	function __construct(){
		parent::__construct();
	}


	public function getId(){
		 return $this->id;
	}


	public function setGroupCompetitionId($group_competition_id){
		$this->group_competition_id = $group_competition_id;
	}


	public function getGroupCompetitionId(){
		 return $this->group_competition_id;
	}


	public function setMatchType($match_type){
		$this->match_type = $match_type;
	}


	public function getMatchType(){
		 return $this->match_type;
	}


	public function setPointsResult($points_result){
		$this->points_result = $points_result;
	}


	public function getPointsResult(){
		 return $this->points_result;
	}


	public function setPointsWinner($points_winner){
		$this->points_winner = $points_winner;
	}


	public function getPointsWinner(){
		 return $this->points_winner;
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
		$query = $this->db->get("group_competition_config");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$GroupCompetitionConfig = self::toObject($row);
				$result[] = $GroupCompetitionConfig;
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
		$query = $this->db->get('group_competition_config');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('group_competition_config');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('group_competition_config');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('group_competition_config',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('group_competition_config',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('group_competition_config', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['group_competition_id'] = $this->group_competition_id;
		$array['match_type'] = $this->match_type;
		$array['points_result'] = $this->points_result;
		$array['points_winner'] = $this->points_winner;
		return $array;
	}


	protected function toObject($row){
		$GroupCompetitionConfig = new GroupCompetitionConfig();
		$GroupCompetitionConfig->id = $row['id'];
		$GroupCompetitionConfig->setGroupCompetitionId($row['group_competition_id']);
		$GroupCompetitionConfig->setMatchType($row['match_type']);
		$GroupCompetitionConfig->setPointsResult($row['points_result']);
		$GroupCompetitionConfig->setPointsWinner($row['points_winner']);
		return $GroupCompetitionConfig;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setGroupCompetitionId($object['group_competition_id']);
			$this->setMatchType($object['match_type']);
			$this->setPointsResult($object['points_result']);
			$this->setPointsWinner($object['points_winner']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setGroupCompetitionId($object->getGroupCompetitionId());
			$this->setMatchType($object->getMatchType());
			$this->setPointsResult($object->getPointsResult());
			$this->setPointsWinner($object->getPointsWinner());
		}
	}

}

?>