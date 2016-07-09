<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competitions extends MS_Controller {
        
        function __construct()
        {
            
            parent::__construct();
           
           $this->load->model('competition');
           $this->load->model('sport');
           $this->load->model('round');
           $this->load->model('season');
           $this->load->model('match');
           
           
        }
        
        function _remap($method)
        {
            $param_offset = 2;
            $segmentsuri = $this->uri->rsegment_array();
            if(count($segmentsuri)>2){  
               
                $method = $segmentsuri[3];
            }
            
            // Default to index
            
            if ( ! method_exists($this, $method))
            {
              // We need one more param              
              $method = 'index';
            }
            $param_offset = 1;
            
            // Since all we get is $method, load up everything else in the URI
            $params = array_slice($this->uri->rsegment_array(), $param_offset);
            
            // Call the determined method with all params
            call_user_func_array(array($this, $method), $params);
        }
        
	public function index($competitionName=null,$task=null)
	{
            if($competitionName==null || $competitionName=='index'){
                
                $this->_competition_home();
            }
            else{
                $this->_competition_detail($competitionName);
            }
           
            
        }
        
        private function _competition_home(){
            
            $competitions = $this->competition->fill();
            $this->load->model('match');
            $this->load->model('team');
            
            foreach ($competitions as &$c){
                $sport = $this->sport->fill(array('id'=>$c->sport_id),true);
                $c->sportname = $sport->name;
            }
            
            $this->_assign(array(
                'breadcrump' => array('pagename'=>'Competitions','section'=>'Competitions',     
            )));

            $competitionData = array('competitions' => $competitions);
            
            $this->_assign(array(
                    'menu' => $this->load->view($this->front_folder.'layout/menu', $this->data, true),
                   'pageTitle' => $this->load->view($this->front_folder.'layout/pagetitle', $this->data, true),
                    'pageContent' => $this->load->view($this->front_folder.'competition-home', $competitionData, true)
                ));
            $this->load->view($this->front_folder.'layout/layout',$this->data);
        }
        
        private function _competition_detail($competitionName,$seasonNumber=null){
            $competition = $this->competition->fill(array('url'=>$competitionName),true);
            if(!$competition){
                redirect('competitions');
            }
            
            $season = $this->season->fill(array('competition_id'=>$competition->id, 'number'=>$seasonNumber),true);
            if(!$season){
                $season = $this->season->fill(array('competition_id'=>$competition->id),true);
                if(!$season){
                    redirect('competitions');
                }
            }
            
            
            $matchs = $this->competition->getMatches();
            
            //@TODO: añadir temporada
            $clasificacion = $season->getClasificacion();
            
            
            
            $matchsByRound = array();
            
            foreach($matchs as $key => $m){
                $m->round = $this->round->fill(array('id'=>$m->round_id),true);
                $matchsByRound[$m->round_id][] = $m;
            }
            
            
            
            
            
            $this->_assign(array(
                'breadcrump' => array('pagename'=>$competition->name,'section'=>'Competitions',  'subsection' => $competition->name ),
                'matchsByRound'=>$matchsByRound,
                'clasificacion'=>$clasificacion));
            
            $this->_assign(array(
                    'menu' => $this->load->view($this->front_folder.'layout/menu', $this->data, true),
                   'pageTitle' => $this->load->view($this->front_folder.'layout/pagetitle', $this->data, true),
                    'pageContent' => $this->load->view($this->front_folder.'competition-detail', $this->data, true)
                ));
            $this->load->view($this->front_folder.'layout/layout',$this->data);
            
        }
        
       
        
}
