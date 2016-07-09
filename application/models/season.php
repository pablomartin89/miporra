<?php 

class Season extends Season_Core{


	function __construct(){
		parent::__construct();
	}
        
         public function getClasificacion(){
            $sql = "SELECT t.id, t.name, IFNULL(PG,0)+IFNULL(PE,0)+IFNULL(PP,0) PJ, 
				IFNULL(PG,0) PG, IFNULL(PE,0) PE, IFNULL(PP,0) PP, IFNULL(GF,0) GF, IFNULL(GC,0) GC, 
				IFNULL(PG,0)*3+IFNULL(PE,0) PUNTOS FROM team t
			LEFT JOIN
				(SELECT team, SUM(PG) PG FROM
					(SELECT team_local team, count(*) PG FROM `match` 
					WHERE score_local > score_visitor  
					
                                        and competition_id =  ".$this->db->escape($this->id)."
					GROUP BY team_local
                                        UNION ALL
					SELECT team_visitor team, count(*) PG FROM `match` 
					WHERE score_local < score_visitor  
					
                                        and competition_id =  ".$this->db->escape($this->id)."
					GROUP BY team_visitor) PG 
				GROUP BY team) PG ON t.id=PG.team
			LEFT JOIN
				(SELECT team, SUM(PE) PE FROM
					(SELECT team_local team, count(*) PE FROM `match`  
					WHERE score_local = score_visitor  
					
                                        and competition_id =  ".$this->db->escape($this->id)."
					GROUP BY team_local
						UNION ALL
					SELECT team_visitor equipo, count(*) PE FROM `match`
					WHERE score_local = score_visitor  
					
                                        and competition_id =  ".$this->db->escape($this->id)."
					GROUP BY team_visitor) PE 
				GROUP BY team) PE ON t.id=PE.team
			LEFT JOIN
				(SELECT team, SUM(PP) PP FROM
					(SELECT team_local team, count(*) PP FROM `match` 
					WHERE score_local < score_visitor  
					
                                        and competition_id =  ".$this->db->escape($this->id)."
					GROUP BY team_local
						UNION ALL
					SELECT team_visitor team, count(*) PP FROM `match` 
					WHERE score_local > score_visitor  
					
                                        and competition_id =  ".$this->db->escape($this->id)."
					GROUP BY team_visitor) PP
				GROUP BY team) PP ON t.id=PP.team
			LEFT JOIN
				(SELECT team, SUM(GF) GF, SUM(GC) GC FROM(
					SELECT team_local team, SUM(score_local) GF, SUM(score_visitor) GC FROM `match`  
					WHERE match_type=1  
                                        and competition_id =  ".$this->db->escape($this->id)."
                                        GROUP BY team_local					
						UNION ALL
					SELECT team_visitor equipo, SUM(score_local) GF, SUM(score_visitor) GC FROM `match`  
					WHERE match_type=1  
                                        and competition_id =  ".$this->db->escape($this->id)."
                                        GROUP BY team_visitor) GOLES					
				GROUP BY team) GOLES ON t.id=GOLES.team
                        where exists (SELECT distinct(team_local) FROM dev_miporra.`match` m where competition_id = ".$this->db->escape($this->competition_id)." and season_id=".$this->db->escape($this->id)." and m.team_local = t.id)
			ORDER BY PUNTOS DESC, GF-GC DESC, GF DESC";
            
            $query = $this->db->query($sql);
            return $query->result();
        }

}

?>