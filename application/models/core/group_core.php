<?php

class Group_Core extends CI_Model{

	var $id = null;
	var $name = null;
	var $password = null;
	var $url = null;

	function __construct(){
		parent::__construct();
	}


	public function getId(){
		 return $this->id;
	}


	public function setName($name){
		$this->name = $name;
	}


	public function getName(){
		 return $this->name;
	}


	public function setPassword($password){
		$this->password = $password;
	}


	public function getPassword(){
		 return $this->password;
	}


	public function setUrl($url){
		$this->url = $url;
	}


	public function getUrl(){
		 return $this->url;
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
		$query = $this->db->get("group");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$Group = self::toObject($row);
				$result[] = $Group;
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
		$query = $this->db->get('group');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('group');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('group');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('group',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('group',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('group', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['name'] = $this->name;
		$array['password'] = $this->password;
		$array['url'] = $this->url;
		return $array;
	}


	protected function toObject($row){
		$Group = new Group();
		$Group->id = $row['id'];
		$Group->setName($row['name']);
		$Group->setPassword($row['password']);
		$Group->setUrl($row['url']);
		return $Group;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setName($object['name']);
			$this->setPassword($object['password']);
			$this->setUrl($object['url']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setName($object->getName());
			$this->setPassword($object->getPassword());
			$this->setUrl($object->getUrl());
		}
	}

}

?>