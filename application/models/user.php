<?php

class User extends User_Core {

    function __construct() {
        parent::__construct();
    }

    public function valid_nick() {

        $this->form_validation->set_message('valid_nick', 'The {field} field can not be the word "test"');
        return FALSE;
    }

    public function getCompetitions() {
        $sql = 'select user_id, gc.group_id, g.name group_name, g.url group_url, c.name competition_name, c.url competition_url, s.name temporada, s.number season_number from user_group ug 
                left join `group` g on ug.group_id = g.id
                left join `group_competition` gc on gc.group_id = g.id
                left join competition c on c.id = gc.competition_id
                left join season s on s.id= gc.season_id
                where ug.user_id = ?
                ';

        $query = $this->db->query($sql, array($this->id));

        $competitionsUser = array();
        foreach ($query->result() as $c) {
            $competitionsUser[$c->group_id][] = $c;
        }

        return $competitionsUser;
    }

}

?>