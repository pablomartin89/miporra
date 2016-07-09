<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * WebImpacto Consulting S.L.
 */

/**
 *
 * @author Pablo Martín <pmartin@webimpacto.es>
 * @copyright  2007-2012 PrestaShop SA
 * @version 0.1
 * 
 */

class Node {
    
    
    public function get($object)
    {
        $curl = curl_init();
        $fields['query'] = json_encode($object);
          //exit("hdp");  
        $fields_string = "";
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');
            
        curl_setopt($curl, CURLOPT_URL, 'http://webimpacto.net:3000/api/test/');
            
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
        $result = curl_exec($curl);
        
        curl_close($curl); 
        return json_decode($result);
    }
    
    public function post($object){
        $curl = curl_init();
        $fields['query'] = json_encode($object);
          //exit("hdp");  
        /*foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');
            
        curl_setopt($curl, CURLOPT_URL, 'http://webimpacto.net:3000/api/buildings/');
        curl_setopt($curl, CURLOPT_POST, count($fields));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
            
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
        $result = curl_exec($curl);
        curl_close($curl); */
        exit("asds");
        return "asds";
    }
    
    public function put($params){
        
    }
    
    public function delete($params){
        
    }
}