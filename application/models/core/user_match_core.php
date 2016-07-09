<?php

class UserMatch_Core extends CI_Model{

	var $id = null;
	var $user_id = null;
	var $match_id = null;
	var $group_competition = null;
	var $score_local = null;
	var $score_visitor = null;
	var $points_win = null;

	function __construct(){
		parent::__construct();
	}


	public function getId(){
		 return $this->id;
	}


	public function setUserId($user_id){
		$this->user_id = $user_id;
	}


	public function getUserId(){
		 return $this->user_id;
	}


	public function setMatchId($match_id){
		$this->match_id = $match_id;
	}


	public function getMatchId(){
		 return $this->match_id;
	}


	public function setGroupCompetition($group_competition){
		$this->group_competition = $group_competition;
	}


	public function getGroupCompetition(){
		 return $this->group_competition;
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


	public function setPointsWin($points_win){
		$this->points_win = $points_win;
	}


	public function getPointsWin(){
		 return $this->points_win;
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
		$query = $this->db->get("user_match");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$UserMatch = self::toObject($row);
				$result[] = $UserMatch;
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
		$query = $this->db->get('user_match');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('user_match');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('user_match');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('user_match',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('user_match',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('user_match', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['user_id'] = $this->user_id;
		$array['match_id'] = $this->match_id;
		$array['group_competition'] = $this->group_competition;
		$array['score_local'] = $this->score_local;
		$array['score_visitor'] = $this->score_visitor;
		$array['points_win'] = $this->points_win;
		return $array;
	}


	protected function toObject($row){
		$UserMatch = new UserMatch();
		$UserMatch->id = $row['id'];
		$UserMatch->setUserId($row['user_id']);
		$UserMatch->setMatchId($row['match_id']);
		$UserMatch->setGroupCompetition($row['group_competition']);
		$UserMatch->setScoreLocal($row['score_local']);
		$UserMatch->setScoreVisitor($row['score_visitor']);
		$UserMatch->setPointsWin($row['points_win']);
		return $UserMatch;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setUserId($object['user_id']);
			$this->setMatchId($object['match_id']);
			$this->setGroupCompetition($object['group_competition']);
			$this->setScoreLocal($object['score_local']);
			$this->setScoreVisitor($object['score_visitor']);
			$this->setPointsWin($object['points_win']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setUserId($object->getUserId());
			$this->setMatchId($object->getMatchId());
			$this->setGroupCompetition($object->getGroupCompetition());
			$this->setScoreLocal($object->getScoreLocal());
			$this->setScoreVisitor($object->getScoreVisitor());
			$this->setPointsWin($object->getPointsWin());
		}
	}

}

?>