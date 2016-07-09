<?php

/*
 * WebImpacto Consulting S.L.
 */

/**
 *
 * @author Pablo Martín <pmartin@webimpacto.es>
 * @copyright  2007-2015 WebImpacto Consulting S.L.
 * @version 0.1
 * 
 */
class MS_Controller extends CI_Controller{
    protected $front_theme;
    protected $back_theme;
    
    protected $front_folder;
    protected $back_folder;
    protected $data;
    
     
  
    
    
    function __construct()
    {
        parent::__construct();
        /**
         * @todo Load themes and variables from MongoDB or config file
         */
        
        $object = "";
        
        $this->back_theme = "miporra";
       
        $this->front_theme = "miporra";
        
        $this->front_folder = "frontoffice/".$this->front_theme."/";
        $this->back_folder = "backoffice/".$this->front_theme."/";
        
        $user = $this->user->fill(array('id' => $this->session->userdata('id')), true);
        $this->data['user'] = $user;
        
        if($user){
            $this->data['user_competitions'] = $user->getCompetitions();
        }
        
        $this->data['front_media_folder'] = base_url()."media/".$this->front_folder;
        $this->data['back_media_folder'] = base_url()."media/".$this->back_folder;
        
        $this->data['menu'] = $this->load->view($this->front_folder . 'layout/menu', $this->data, true);
    }
    
    /**
     * _assign
     * 
     * Set variables to the data object.
     * This variables will be send to the View
     * 
     * @param array $var 
     */
    protected function _assign($var){
        if(is_array($var)){
            foreach ($var as $key => $value) {
                $this->data[$key] = $value;
            }
        }
        /** 
         * @todo Log error or message error if $var is not array, or can't be load a variable.
         */
        
    }
    
    
    protected function _addJS($js_files){
        if(is_array($js_files)){
            foreach ($js_files as $key => $file) {
                $this->data['js'][] = $file;
            }
        }
        else{
            $this->data['js'][] = $js_files;
        }
    }
    
    protected function _addCSS($css_files){
        if(is_array($css_files)){
            foreach (css_files as $key => $file) {
                $this->data['css'][] = $file;
            }
        }
        else{
            $this->data['css'][] = $css_files;
        }
    }
    
    
}
