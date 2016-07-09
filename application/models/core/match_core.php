<?php

class Match_Core extends CI_Model{

	var $id = null;
	var $competition_id = null;
	var $round_id = null;
	var $season_id = null;
	var $match_type = null;
	var $group_stage = null;
	var $team_local = null;
	var $team_visitor = null;
	var $score_local = null;
	var $score_visitor = null;
	var $date = null;
	var $is_result_by_time = null;

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


	public function setRoundId($round_id){
		$this->round_id = $round_id;
	}


	public function getRoundId(){
		 return $this->round_id;
	}


	public function setSeasonId($season_id){
		$this->season_id = $season_id;
	}


	public function getSeasonId(){
		 return $this->season_id;
	}


	public function setMatchType($match_type){
		$this->match_type = $match_type;
	}


	public function getMatchType(){
		 return $this->match_type;
	}


	public function setGroupStage($group_stage){
		$this->group_stage = $group_stage;
	}


	public function getGroupStage(){
		 return $this->group_stage;
	}


	public function setTeamLocal($team_local){
		$this->team_local = $team_local;
	}


	public function getTeamLocal(){
		 return $this->team_local;
	}


	public function setTeamVisitor($team_visitor){
		$this->team_visitor = $team_visitor;
	}


	public function getTeamVisitor(){
		 return $this->team_visitor;
	}


	public function setScoreLocal($score_local){
		$this->score_local = $score_local;
	}


	public function getScoreLocal(){
		 return $this->score_local;
	}


	public function setScoreVisitor($score_visitor){
		$this->score_visitor = $score_visitor;
	}


	public function getScoreVisitor(){
		 return $this->score_visitor;
	}


	public function setDate($date){
		$this->date = $date;
	}


	public function getDate(){
		 return $this->date;
	}


	public function setIsResultByTime($is_result_by_time){
		$this->is_result_by_time = $is_result_by_time;
	}


	public function getIsResultByTime(){
		 return $this->is_result_by_time;
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
		$query = $this->db->get("match");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$Match = self::toObject($row);
				$result[] = $Match;
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
		$query = $this->db->get('match');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('match');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('match');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('match',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('match',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('match', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['competition_id'] = $this->competition_id;
		$array['round_id'] = $this->round_id;
		$array['season_id'] = $this->season_id;
		$array['match_type'] = $this->match_type;
		$array['group_stage'] = $this->group_stage;
		$array['team_local'] = $this->team_local;
		$array['team_visitor'] = $this->team_visitor;
		$array['score_local'] = $this->score_local;
		$array['score_visitor'] = $this->score_visitor;
		$array['date'] = $this->date;
		$array['is_result_by_time'] = $this->is_result_by_time;
		return $array;
	}


	protected function toObject($row){
		$Match = new Match();
		$Match->id = $row['id'];
		$Match->setCompetitionId($row['competition_id']);
		$Match->setRoundId($row['round_id']);
		$Match->setSeasonId($row['season_id']);
		$Match->setMatchType($row['match_type']);
		$Match->setGroupStage($row['group_stage']);
		$Match->setTeamLocal($row['team_local']);
		$Match->setTeamVisitor($row['team_visitor']);
		$Match->setScoreLocal($row['score_local']);
		$Match->setScoreVisitor($row['score_visitor']);
		$Match->setDate($row['date']);
		$Match->setIsResultByTime($row['is_result_by_time']);
		return $Match;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setCompetitionId($object['competition_id']);
			$this->setRoundId($object['round_id']);
			$this->setSeasonId($object['season_id']);
			$this->setMatchType($object['match_type']);
			$this->setGroupStage($object['group_stage']);
			$this->setTeamLocal($object['team_local']);
			$this->setTeamVisitor($object['team_visitor']);
			$this->setScoreLocal($object['score_local']);
			$this->setScoreVisitor($object['score_visitor']);
			$this->setDate($object['date']);
			$this->setIsResultByTime($object['is_result_by_time']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setCompetitionId($object->getCompetitionId());
			$this->setRoundId($object->getRoundId());
			$this->setSeasonId($object->getSeasonId());
			$this->setMatchType($object->getMatchType());
			$this->setGroupStage($object->getGroupStage());
			$this->setTeamLocal($object->getTeamLocal());
			$this->setTeamVisitor($object->getTeamVisitor());
			$this->setScoreLocal($object->getScoreLocal());
			$this->setScoreVisitor($object->getScoreVisitor());
			$this->setDate($object->getDate());
			$this->setIsResultByTime($object->getIsResultByTime());
		}
	}

}

?>