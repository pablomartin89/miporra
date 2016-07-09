<?php 

class Group extends Group_Core{


	function __construct(){
		parent::__construct();
	}
        
        function getGroupsDetails(){
            $sql = "SELECT 
                        g.id,
                        g.name,
                        IF(`password` IS NULL, 0, 1) isPublic,
                        g.url,
                        COUNT(DISTINCT (gc.competition_id)) nb_competition,
                        COUNT(DISTINCT (ug.user_id)) nb_users
                    FROM
                        `group` g
                            LEFT JOIN
                        group_competition gc ON gc.group_id = g.id
                            LEFT JOIN
                        user_group ug ON ug.group_id = g.id";
            
            $query = $this->db->query($sql);
            return $query->result();
        }
        
        function getGroupCompetitions(){
            $sql = "SELECT 
                    group_id,
                    gc.competition_id,
                    season_id,
                    c.name competition_name,
                    s.name season_name,
                    s.number season_number
                FROM
                    group_competition gc
                        LEFT JOIN
                    competition c ON gc.competition_id = c.id
                        LEFT JOIN
                    season s ON gc.season_id = s.id
                WHERE
                    s.active = 1 AND group_id = ?";
            $query = $this->db->query($sql,array($this->id));
            return $query->result();
        }

}

?>