<?php

class User_Core extends CI_Model{

	var $id = null;
	var $email = null;
	var $nick = null;
	var $password = null;
	var $firstname = null;
	var $lastname = null;

	function __construct(){
		parent::__construct();
	}


	public function getId(){
		 return $this->id;
	}


	public function setEmail($email){
		$this->email = $email;
	}


	public function getEmail(){
		 return $this->email;
	}


	public function setNick($nick){
		$this->nick = $nick;
	}


	public function getNick(){
		 return $this->nick;
	}


	public function setPassword($password){
		$this->password = $password;
	}


	public function getPassword(){
		 return $this->password;
	}


	public function setFirstname($firstname){
		$this->firstname = $firstname;
	}


	public function getFirstname(){
		 return $this->firstname;
	}


	public function setLastname($lastname){
		$this->lastname = $lastname;
	}


	public function getLastname(){
		 return $this->lastname;
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
		$query = $this->db->get("user");
		if($query->num_rows()>0){
			if($singleResult){
				$row = $query->row_array();
				$this->reasignThis($row);
				return self::toObject($row);
			}
			$rows = $query->result_array();
			$result = array();
			foreach($rows as $row){
				$User = self::toObject($row);
				$result[] = $User;
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
		$query = $this->db->get('user');
		return $query->result();
	}

	public function save(){
		$this->db->where(array('id' => $this->id));
		$query = $this->db->get('user');
		if($query->num_rows()>0){
			$this->update();
		}
		else{
			$this->insert();
			/*$this->db->where(array('id' => $this->id));
			$query = $this->db->get('user');
			$row = $query->row_array();
			$this->reasignThis($row);*/
		}
	}

	protected function insert(){
		$this->db->insert('user',$this->toArray());
		$this->id = $this->db->insert_id();
	}

	protected function update(){
		$this->db->where(array('id' => $this->id));
		$this->db->update('user',$this->toArray());
		return $this;
	}

	public function deleteWhere($where){
		$this->db->delete('user', $where);
	}


	public function toArray(){
		$array = array();
		$array['id'] = $this->id;
		$array['email'] = $this->email;
		$array['nick'] = $this->nick;
		$array['password'] = $this->password;
		$array['firstname'] = $this->firstname;
		$array['lastname'] = $this->lastname;
		return $array;
	}


	protected function toObject($row){
		$User = new User();
		$User->id = $row['id'];
		$User->setEmail($row['email']);
		$User->setNick($row['nick']);
		$User->setPassword($row['password']);
		$User->setFirstname($row['firstname']);
		$User->setLastname($row['lastname']);
		return $User;
	}


	public function reasignThis($object){
		if(is_array($object)){
			$this->id = $object['id'];
			$this->setEmail($object['email']);
			$this->setNick($object['nick']);
			$this->setPassword($object['password']);
			$this->setFirstname($object['firstname']);
			$this->setLastname($object['lastname']);
		}
		else if(is_object($object)){
			$this->id = $object->id;
			$this->setEmail($object->getEmail());
			$this->setNick($object->getNick());
			$this->setPassword($object->getPassword());
			$this->setFirstname($object->getFirstname());
			$this->setLastname($object->getLastname());
		}
	}

}

?>