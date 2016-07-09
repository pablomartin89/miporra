<?php 

class Competition extends Competition_Core{


	function __construct(){
		parent::__construct();
	}
        
        public function getMatches(){
            $sql = 'select m.id, m.round_id, m.season_id, match_type, t1.name name_local, score_local, t2.name name_visitor, score_visitor from `match` m 
            left join team t1 on m.team_local = t1.id
            left join team t2 on m.team_visitor = t2.id
            where  exists (select round_id from round r where competition_id = ? and r.id = m.round_id)
            ';
            
            $query = $this->db->query($sql, array($this->id));
            return $query->result();
        }

}

?>