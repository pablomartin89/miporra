<?php 

class GroupCompetition extends GroupCompetition_Core{


	function __construct(){
		parent::__construct();
	}
        
        public function getUserMatches($user_id){
            $sql = 'select u.id as user_id,
                        m.id as match_id,
                        m.round_id,
                        m.season_id,
                        match_type,
                        t1.name name_local,
                        m.score_local real_score_local,
                        t2.name name_visitor,
                        m.score_visitor real_score_visitor,
                        um.score_local user_score_local,
                        um.score_visitor user_score_visitor from `match` m
                    cross join user u left join user_group ug on ug.user_id = u.id
                    left join user_match um on (um.match_id = m.id and u.id=um.user_id)
                    LEFT JOIN
                        team t1 ON m.team_local = t1.id
                            LEFT JOIN
                        team t2 ON m.team_visitor = t2.id
                    where  u.id=?
                    and season_id = ? and competition_id = ? and group_id = ?
                    order by round_id asc
            ';
            
            
            
            $query = $this->db->query($sql, array($user_id,$this->season_id,$this->competition_id,$this->group_id));
            
            return $query->result();
        }
        
        public function getClasificacion(){
            $sql = "SELECT u.id, u.nick, gc.id,
			IFNULL(SUM(CASE
				 WHEN m.score_local = um.score_local AND m.score_visitor = um.score_visitor THEN 1 END),0) as nb_results,
			IFNULL(SUM(CASE
				WHEN m.score_local = um.score_local AND m.score_visitor = um.score_visitor THEN 0
				 WHEN m.score_local > m.score_visitor AND um.score_local > um.score_visitor THEN 1
               WHEN m.score_local < m.score_visitor AND um.score_local < um.score_visitor THEN 1
               WHEN m.score_local = m.score_visitor AND um.score_local = um.score_visitor THEN 1 END),0) as nb_winner,
            IFNULL(SUM(CASE
               WHEN m.score_local = um.score_local AND m.score_visitor = um.score_visitor THEN gcc.points_result 
               WHEN m.score_local > m.score_visitor AND um.score_local > um.score_visitor THEN gcc.points_winner
               WHEN m.score_local < m.score_visitor AND um.score_local < um.score_visitor THEN gcc.points_winner
               WHEN m.score_local = m.score_visitor AND um.score_local = um.score_visitor THEN gcc.points_winner
            END),0) as `points`
            FROM group_competition gc
            LEFT JOIN user_group ug on gc.group_id=ug.group_id
            LEFT JOIN user u on u.id=ug.user_id
            
            LEFT JOIN user_match um on u.id = um.user_id
            left join `match` m  on (m.id = um.match_id and m.competition_id = gc.id)
            left join group_competition_config gcc on m.match_type = gcc.match_type
            
            where gc.id = ?
            group by u.id
            
            order by points desc";
            
            $query = $this->db->query($sql, array($this->id));
            return $query->result();

        }

}

?>