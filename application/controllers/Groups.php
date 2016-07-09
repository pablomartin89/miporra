<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends MS_Controller {
        
        function __construct()
        {
            
            parent::__construct();
           
           $this->load->model('competition');
           $this->load->model('sport');
           $this->load->model('group');
           $this->load->model('group_competition');
           
           
           
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
        
	public function index($groupName=null,$task=null)
	{
            if($groupName==null || $groupName=='index'){
                
                $this->_group_home();
            }
            else{
                $this->_group_detail($groupName);
            }
           
            
        }
        
        private function _group_home(){
            
            $groups = $this->group->getGroupsDetails();
            
            
            
            $this->_assign(array(
                'breadcrump' => array('pagename'=>'Grupos','section'=>'Grupos',     
            )));

            $competitionData = array('groups' => $groups);
            
            $this->_assign(array(
                    'menu' => $this->load->view($this->front_folder.'layout/menu', $this->data, true),
                   'pageTitle' => $this->load->view($this->front_folder.'layout/pagetitle', $this->data, true),
                    'pageContent' => $this->load->view($this->front_folder.'group-home', $competitionData, true)
                ));
            $this->load->view($this->front_folder.'layout/layout',$this->data);
        }
        
        private function _group_detail($groupName){
            $group = $this->group->fill(array('url'=>$groupName),true);
            if(!$group){
                redirect('groups');
            }
            
            $listGroupCompetitions = $group->getGroupCompetitions();
            
            $groupCompetitions_clasificacion = array();
            foreach ($listGroupCompetitions as $key => $gc ){
                $groupCompetitionObj = new GroupCompetition();
                $groupCompetitionObj->id = $gc->competition_id;
                $groupCompetitions_clasificacion[$key] = $groupCompetitionObj->getClasificacion();
            }
            
            
            
            
            
            $this->_assign(array(
                'breadcrump' => array('pagename'=>$group->name,'section'=>'Porras',  'subsection' => $group->name ),
                'competitions'=>$listGroupCompetitions,
                'clasificaciones'=>$groupCompetitions_clasificacion));
            
            $this->_assign(array(
                    'menu' => $this->load->view($this->front_folder.'layout/menu', $this->data, true),
                   'pageTitle' => $this->load->view($this->front_folder.'layout/pagetitle', $this->data, true),
                    'pageContent' => $this->load->view($this->front_folder.'group-detail', $this->data, true)
                ));
            $this->load->view($this->front_folder.'layout/layout',$this->data);
            
        }
        
       
        
}
