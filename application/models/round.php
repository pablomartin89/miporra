<?php 

class Round extends Round_Core{


	function __construct(){
		parent::__construct();
	}
        
        public function __toString() {
            return $this->getId();
        }
        
        public function getByCompetition($competition){
            $sql = 'select * from round where competition_id = ?';
            $query = $this->db->query($sql, array($competition));
            
            $rounds = $query->result();
            
            $roundKeyOrder = array();
            foreach ($rounds as $round){
                $roundKeyOrder[$round->id] = $round;
            }
            
            return $roundKeyOrder;
            
        }

}

?>