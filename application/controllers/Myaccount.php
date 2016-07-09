<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount extends MS_Controller {

    function __construct() {

        parent::__construct();
        if (!$this->session->has_userdata('LoggedIN')) {
            redirect('login');
        }


        $this->load->model('user');


        $this->data['sidebar'] = $this->load->view($this->front_folder . 'myaccount/myaccount-sidebar', $this->data, true);
    }

    public function index() {
        $this->data['myaccountContent'] = $this->load->view($this->front_folder . 'myaccount/myaccount-index', $this->data, true);
        $this->data['pageContent'] = $this->load->view($this->front_folder . 'myaccount/myaccount-layout', $this->data, true);


        $this->load->view($this->front_folder . 'layout/layout', $this->data);
    }

    public function results($groupName = null, $competitionName = null, $seasonNumber = null) {
        $this->load->model('user_group');
        $this->load->model('group');
        $this->load->model('group_competition');
        $this->load->model('competition');
        $this->load->model('match');
        $this->load->model('season');
        $this->load->model('round');
        $this->load->model('user_match');

        if ($groupName != null) {
            $group = $this->group->fill(array('url' => $groupName), true);
            if (!$group) {
                redirect('myaccount/results');
            }
            $this->data['group'] = $group;
        }

        if ($competitionName != null) {
            $competition = $this->competition->fill(array('url' => $competitionName), true);
            if (!$competition) {
                redirect('myaccount/results');
            }
            $this->data['competition'] = $competition;
        }

        if ($seasonNumber != null) {
            $season = $this->season->fill(array('number' => $seasonNumber,'competition_id'=>$competition->id), true);
            if (!$season) {
                redirect('myaccount/results');
            }
            $this->data['season'] = $season;
        }
        

        $this->data['breadcrump'] = array('pagename' => 'Mis Resultados', 'section' => 'Resultados');
        if (isset($group) && $group != null && isset($competition) && $competition != null && isset($season) && $season != null) {
            $user_group = $this->user_group->fill(array('user_id' => $this->session->userdata('id'), 'group_id' => $group->id), true);
            $group_competition = $this->group_competition->fill(array('group_id' => $group->id, 'competition_id' => $competition->id, 'season_id' => $season->id), true);
            
            if (!$user_group || !$group_competition) {
                redirect('myaccount/results');
            }

            if ($this->input->post()) {
                
                if ($this->input->post('register-form-submit')) {
                    $array_score_local = $this->input->post('results-score-local') ;
                    $array_score_visitor = $this->input->post('results-score-visitor') ;
                    foreach ($array_score_local as $match_id => $score_local) {
                        
                        if(($array_score_local[$match_id] || $array_score_local[$match_id]=='0') && ($array_score_visitor[$match_id] || $array_score_visitor[$match_id]=='0' )){
                            $user_match = null;
                            if(!$user_match = $this->user_match->fill(array('user_id'=>$this->session->userdata('id'),'match_id'=>$match_id,'group_competition'=>$group_competition->id),true)){
                                
                                $user_match = new UserMatch();
                                $user_match->user_id=$this->session->userdata('id');
                                $user_match->match_id = $match_id;
                                $user_match->group_competition=$group_competition->id;
                            }
                            
                            $user_match->score_local=$array_score_local[$match_id];
                            $user_match->score_visitor=$array_score_visitor[$match_id];
                            $user_match->save();
                            
                            
                        }
                    }
                }

                
            }

            $userMatches = $group_competition->getUserMatches($this->session->userdata('id'));

            $userMatchsByRound = array();
            $rounds = $this->round->getByCompetition($competition->id);
            $this->data['rounds'] = $rounds;

            foreach ($userMatches as $key => $m) {
                //$m->round = $this->round->fill(array('id'=>$m->round_id),true);
                $userMatchsByRound[$m->round_id][] = $m;
            }


            $this->data['userMatchsByRound'] = $userMatchsByRound;
            $this->data['breadcrump']['subsection'] = $group->name;
        }
        $this->data['pageTitle'] = $this->load->view($this->front_folder . 'layout/pagetitle', $this->data, true);






        $this->data['myaccountContent'] = $this->load->view($this->front_folder . 'myaccount/myaccount-results', $this->data, true);
        $this->data['pageContent'] = $this->load->view($this->front_folder . 'myaccount/myaccount-layout', $this->data, true);


        $this->load->view($this->front_folder . 'layout/layout', $this->data);
    }

    public function logout() {
        $array_items = array('id', 'nick', 'firstname', 'email', 'LoggedIN', 'newLogin');
        $this->session->unset_userdata($array_items);
        redirect('myaccount');
    }
    
    public function groups() {
        $this->data['breadcrump'] = array('pagename' => 'Mis grupos', 'section' => 'Mis grupos');
        $this->data['pageTitle'] = $this->load->view($this->front_folder . 'layout/pagetitle', $this->data, true);
        $this->data['myaccountContent'] = $this->load->view($this->front_folder . 'myaccount/myaccount-groups', $this->data, true);
        $this->data['pageContent'] = $this->load->view($this->front_folder . 'myaccount/myaccount-layout', $this->data, true);


        $this->load->view($this->front_folder . 'layout/layout', $this->data);
    }

    public function calendar() {
        $this->_addJS("js/jquery.calendario.js");
        $this->_addJS("js/events-data.js");
        $this->_addCSS("css/calendar.css");

        $this->_assign(array(
            'breadcrump' => array('pagename' => 'Mi cuenta', 'section' => 'Mi cuenta', 'subsection' => 'Calendario'),
            'pageTitle' => $this->load->view($this->front_folder . 'layout/pagetitle', $this->data, true),
            'pageContent' => $this->load->view($this->front_folder . 'myaccount/myaccount-calendar', $this->data, true)
        ));

        $this->load->view($this->front_folder . 'layout/layout', $this->data);
    }

    public function _username_check($nick) {
        if ($this->user->fill(array('nick' => $nick))) {
            $this->form_validation->set_message('_username_check', '{field} must be unique');
            return FALSE;
        }

        return TRUE;
    }

    public function _email_check($email) {
        if ($this->user->fill(array('email' => $email))) {
            $this->form_validation->set_message('_email_check', '{field} must be unique');
            return FALSE;
        }

        return TRUE;
    }

}
