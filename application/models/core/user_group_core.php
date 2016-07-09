<?php

class UserGroup_Core extends CI_Model{

	var $group_id = null;
	var $user_id = null;

	function __construct(){
		parent::__construct();
	}


	public function getGroupId(){
		 return $this->group_id;
	}


	public function getUserId(){
		 return $this->user_id;
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
		$query = $this->db->get("user_group");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$UserGroup = self::toObject($row);
				$result[] = $UserGroup;
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
		$query = $this->db->get('user_group');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('group_id' => $this->group_id, 'user_id' => $this->user_id));
		$query = $this->db->get('user_group');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('group_id' => $this->group_id, 'user_id' => $this->user_id));
			$query = $this->db->get('user_group');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('user_group',$this->toArray());
		$this->group_id = $this->db->insert_id();
		$this->user_id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('group_id' => $this->group_id, 'user_id' => $this->user_id));
		$this->db->update('user_group',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('user_group', $where);
	}


	public function toArray(){
		$array = array();
		$array['group_id'] = $this->group_id;
		$array['user_id'] = $this->user_id;
		return $array;
	}


	protected function toObject($row){
		$UserGroup = new UserGroup();
		$UserGroup->group_id = $row['group_id'];
		$UserGroup->user_id = $row['user_id'];
		return $UserGroup;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->group_id = $object['group_id'];
			$this->user_id = $object['user_id'];
		}
		else if(is_object($object)){
			$this->group_id = $object->group_id;
			$this->user_id = $object->user_id;
		}
	}

}

?>