<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ORMGenerator extends CI_Controller {

	
	public function index()
	{
            $this->load->view('orm/ormgenerator');
                
	}
        public function withForeing(){
            $tableData = array();
            $tables = $this->db->list_tables();
            
            foreach($tables as $table){                    
                $fields = $this->db->field_data($table);
                foreach($fields as $field){
                    $tableData[$table][] = $field;
                } 
            }
            $data['tables'] = json_encode($tableData);
            $this->load->view('orm/foreing',$data);
        }
        
        public function prueba(){
            ;
            echo $string."<br/>";
            echo $this->encrypt->decode($string);
        }
        private function __Obj2ArrRecursivo($Objeto) {
		if (is_object ( $Objeto ))
		$Objeto = get_object_vars ( $Objeto );
		if (is_array ( $Objeto ))
		foreach ( $Objeto as $key => $value )
		$Objeto [$key] =  $this->__Obj2ArrRecursivo ( $Objeto [$key] );
		return $Objeto;
	}
        
        public function withoutForeing(){
            if(ENVIRONMENT=='development'){
                $this->load->config('orm_config',true);
                $ORMOutput = array();
                
                $database =  $this->db->database;
                $tables = $this->db->list_tables();
                if($this->input->post('data')){
                    $model_file = APPPATH.'models/FKModel.orm';  
                    file_put_contents($model_file, $this->encrypt->encode($this->input->post('data')));

                }
                
                //$foreings = $this->__Obj2ArrRecursivo(json_decode('{"ground":{"league":{"league":["league_id"]}},"league":{"sport":{"league_sport":["sport_id"]}},"league_admin":{"league":{"league":["league_id"]}},"league_division":{"league":{"league":["league_id"]}},"league_option":{"league":{"league":["league_id"]}},"match":{"league":{"match_league":["league_id"]},"match_type":{"match_type":["match_type_id"]},"team":{"match_visitor_team":["team_id"],"match_home_team":["team_id"]}},"player":{"team":{"team":["team_id"]},"user":{"user":["user_id"]}},"schedule":{"ground":{"ground":["ground_id"]}},"team_league":{"league":{"league":["league_id"]},"team":{"team":["team_id"]}}}'));
                $foreings = $this->__Obj2ArrRecursivo(json_decode($this->input->post('data')));
                foreach($tables as $tableName){                    
                    
                    $className = str_replace('_', ' ', $tableName);
                    $className = str_replace(' ','',ucwords($className));
                    
                    
                    $ORMOutput[$tableName] = $this->__createClassCore($tableName, $className,$foreings);
                    $this->__createClass($tableName, $className);
                    //$this->__createForms($tableName,$className);
                }
                
                $this->__output($ORMOutput);                
                
            }
            else{
                redirect('');
            }
        }
        
        private function __createClassCore($tableName, $className, $foreings){
            $ORMOutput = array();
            $fileContent = "<?php\n\n";
            $fileContent .= "class ".$className."_Core extends CI_Model{\n\n";

            $fields = $this->db->field_data($tableName); 
            $fieldsNames = array();
            $primaryKeys = array();
            foreach($fields as $key => $field){
                $fieldsNames[] = $field->name;
                if($field->primary_key){
                    $primaryKeys[] = $field->name;
                }
                $foreingAux = array();
                if(isset($foreings[$tableName])) $foreingAux = $foreings[$tableName];
                
            }            
            
            
            $fileContent .= $this->__vars($fieldsNames);                 
            $fileContent .= $this->__genConstruct($foreingAux);
            $fileContent .= $this->__getters_setters($fieldsNames, $primaryKeys, $ORMOutput,$foreingAux);
            $fileContent .= $this->__fill($tableName, $className);
            $fileContent .= $this->__distinct($tableName, $className);
            $fileContent .= $this->__save($tableName,$primaryKeys);
            $fileContent .= $this->__insert($tableName, $primaryKeys);
            $fileContent .= $this->__update($tableName, $className, $primaryKeys);    
            $fileContent .= $this->__deleteWhere($tableName);
            $fileContent .= $this->__toArray($fieldsNames, $className, $primaryKeys);
            $fileContent .= $this->__fillObject($fieldsNames, $className, $primaryKeys);  
            $fileContent .= $this->__reasignThis($fieldsNames, $className, $primaryKeys); 
            

            

            $fileContent .= "}\n\n?>";

            $model_file = APPPATH.'models/core/'.$tableName.'_core.php';                
            file_put_contents($model_file, $fileContent);
            
            return $ORMOutput;
        }
        
        private function __createClass($tableName, $className){
            $model_file = APPPATH.'models/'.$tableName.'.php';  
            if(!file_exists($model_file)){

                $fileContent = "<?php \n\n";                            
                $fileContent .= "class ".$className." extends ".$className."_Core{\n\n";
                $fileContent .= "\n\tfunction __construct(){";
                $fileContent .= "\n\t\tparent::__construct();";            
                $fileContent .= "\n\t}\n\n";  
                $fileContent .= "}\n\n?>";
                file_put_contents($model_file, $fileContent);                       

            }
        }       
        
        
        
        private function __vars($fields){
            $code = "";
            foreach($fields as $field){
                $code .= "\tvar $".$field." = null;\n";
            }
            
            return $code;
        }
        
        /* CORE CLASS FUNCTIONS */
        private function __genConstruct($foreing){
            $code = "\n\tfunction __construct(){";
            $code .= "\n\t\tparent::__construct();";
            foreach($foreing as $table => $field){
                $className = str_replace('_', ' ', $table);
                $className = str_replace(' ','',ucwords($className));
                $code .= "\n\t\t".'$this->load->model(\''.strtolower($table).'\');';
            }
            
            
            
            $code .= "\n\t}\n\n"; 
            
            return $code;
        }
        
        private function __getters_setters($fields, $primaryKeys, &$ORMOutput,$foreing){
            
            $code = "";
            foreach($fields as $field){
                $foreingFlag = false;
                
                $fieldName = str_replace(array('_','-'), ' ', $field);
                $fieldName = str_replace(' ','',ucwords($fieldName));
                if(!in_array($field, $primaryKeys)){
                    $code .= "\n\tpublic function set".$fieldName."($".$field."){";
                    $code .= "\n\t\t".'$this->'.$field.' = $'.$field.";";
                    $code .= "\n\t}\n\n";
                }

                $code .= "\n\tpublic function get".$fieldName."(){";
                foreach($foreing as $table => $ffield){
                    foreach($ffield as $ffieldName => $foreingField){
                        if($ffieldName==$field){
                            $foreingTable = $table;
                            $foreingFlag = true;
                            $foreingValue = $foreingField[0];
                        }
                    }
                }
                if(!$foreingFlag)
                    $code .= "\n\t\t return ".'$this->'.$field.";";
                else{
                    $code .= "\n\t\t".'$ci =& get_instance();';                
                    $code .= "\n\t\t return ".'$ci->'.strtolower($foreingTable).'->fill(array(\''.$foreingValue.'\'=>$this->'.$field.'),true);';
                }
                $code .= "\n\t}\n\n";                
                
                $ORMOutput[] = $field;
            }
            
            $code .= "\n\tpublic function get(".'$property){';
            $code .= "\n\t\t".'if(property_exists($this,$property)){';
            $code .= "\n\t\t\t".'return $this->$property;';
            $code .= "\n\t\t".'}';
            $code .= "\n\t}\n\n";

            $code .= "\n\tpublic function set(".'$property,$value){';
            $code .= "\n\t\t".'if(property_exists($this,$property)){';
            $code .= "\n\t\t\t".'$this->$property = $value;;';
            $code .= "\n\t\t".'}';
            $code .= "\n\t\t".'return $this;';
            $code .= "\n\t}\n\n";
            
            return $code;
        }
        
        private function __fill($tableName,$className){
            $code = "\n\t".'public function fill($where = null, $singleResult=false, $orderby=null){';
            $code .= "\n\t\t".'if($where != null && $where!=""){';
            $code .= "\n\t\t\t".'if(is_array(reset($where))){';
            $code .= "\n\t\t\t\t".'list($key, $value) = each($where);';
            $code .= "\n\t\t\t\t".'$this->db->where_in($key,$value);';
            $code .= "\n\t\t\t".'}';
            $code .= "\n\t\t\t".'else{';
            $code .= "\n\t\t\t\t".'$this->db->where($where);';
            $code .= "\n\t\t\t".'}';
            $code .= "\n\t\t".'}';
            $code .= "\n\t\t".'if($orderby != null){';
            $code .= "\n\t\t\t".'$this->db->order_by($orderby);';
            $code .= "\n\t\t".'}';
            $code .= "\n\t\t".'$query = $this->db->get("'.$tableName.'");';
            $code .= "\n\t\t".'if($query->num_rows()>0){';
            $code .= "\n\t\t\t".'if($singleResult){';
            $code .= "\n\t\t\t\t".'$row = $query->row_array();';
            $code .= "\n\t\t\t\t".'$this->reasignThis($row);';
            $code .= "\n\t\t\t\t".'return self::toObject($row);';
            $code .= "\n\t\t\t".'}';
            $code .= "\n\t\t\t".'$rows = $query->result_array();';
            $code .= "\n\t\t\t".'$result = array();';
            $code .= "\n\t\t\t".'foreach($rows as $row){';
            $code .= "\n\t\t\t\t$".$className.' = self::toObject($row);';
            $code .= "\n\t\t\t\t".'$result[] = $'.$className.';';
            $code .= "\n\t\t\t".'}';
            $code .= "\n\t\t\t".'return $result;';
            $code .= "\n\t\t".'}';
            $code .= "\n\t\t".'else{';
            $code .= "\n\t\t\t".'if($singleResult){';
            $code .= "\n\t\t\t\t".'return false;';
            $code .= "\n\t\t\t".'}';
            $code .= "\n\t\t\t".'else{';
            $code .= "\n\t\t\t\t".'return array();';
            $code .= "\n\t\t\t".'}';
            $code .= "\n\t\t".'}';                    
            $code .= "\n\t}\n\n";
            
            return $code;
        }
        
        private function __distinct($tableName,$className){
            $code = "\n\t".'public function distinct($distinct, $where = null, $orderby=null){';
            $code .= "\n\t\t".'$this->db->distinct();';
            $code .= "\n\t\t".'$this->db->select($distinct);';
            $code .= "\n\t\t".'if($where != null && is_array($where)){';
            $code .= "\n\t\t\t".'$this->db->where($where);';
            $code .= "\n\t\t".'}';
            $code .= "\n\t\t".'if($orderby != null){';
            $code .= "\n\t\t\t".'$this->db->order_by($orderby);';
            $code .= "\n\t\t".'}';         
            $query = 
            $code .= "\n\t\t".'$query = $this->db->get(\''.$tableName.'\');';   
            $code .= "\n\t\t".'return $query->result();';
            $code .= "\n\t}\n\n";
            
            return $code;
        }
        
        private function __fillObject($fields, $className,$primaryKeys){
            $code = "\n\t".'protected function toObject($row){';
            $code .= "\n\t\t$".$className.' = new '.$className.'();';
            foreach($fields as $field){
                $fieldName = str_replace(array('_','-'), ' ', $field);
                $fieldName = str_replace(' ','',ucwords($fieldName));
                if(!in_array($field, $primaryKeys)){
                    $code .= "\n\t\t$".$className.'->set'.$fieldName.'($row[\''.$field.'\']);';
                }
                else{
                    $code .= "\n\t\t$".$className.'->'.$field.' = $row[\''.$field.'\'];';
                }
            }                
            $code .= "\n\t\t".'return $'.$className.';';

            $code .= "\n\t}\n\n";
            return $code;
        } 
        
        private function __save($tableName,$primaryKeys){
            $code = "\t".'public function save(){';     
            $arrayParams = '';
            foreach($primaryKeys as $key => $field){
                if($key!=0) $arrayParams.=', ';
                $arrayParams .= "'".$field."' => ".'$this->'.$field;
            }
            $code .= "\n\t\t".'$this->db->where(array('.$arrayParams.'));';
            $code .= "\n\t\t".'$query = $this->db->get(\''.$tableName.'\');';
            $code .= "\n\t\t".'if($query->num_rows()>0){';
            $code .= "\n\t\t\t".'$this->update();';
            $code .= "\n\t\t".'}';            
            $code .= "\n\t\t".'else{';
            $code .= "\n\t\t\t".'$this->insert();';
            $code .= "\n\t\t\t".'/*$this->db->where(array('.$arrayParams.'));';
            $code .= "\n\t\t\t".'$query = $this->db->get(\''.$tableName.'\');';
            $code .= "\n\t\t\t".'$row = $query->row_array();';
            $code .= "\n\t\t\t".'$this->reasignThis($row);*/';
            $code .= "\n\t\t".'}';
            // $code .= "\n\t\t".'$this->db->close();'; // Problems with CodeIgniter 3.0
            $code .= "\n\t}\n\n";
            return $code;
        }
        
        private function __insert($tableName,$primaryKeys){
            $code = "\t".'protected function insert(){';            
            $code .= "\n\t\t".'$this->db->insert(\''.$tableName.'\',$this->toArray());';
            foreach($primaryKeys as $key => $field){
            $code .= "\n\t\t".'$this->'.$field.' = $this->db->insert_id();';
            }
            $code .= "\n\t}\n\n";
            return $code;
        }
        
        
        private function __delete($tableName, $primaryKeys){
            $code = "\t".'public function delete(){';
            $arrayDelete = '';
            foreach($primaryKeys as $key => $field){
                if($key!=0) $arrayDelete.=', ';
                $arrayDelete .= "'".$field."' => ".'$this->'.$field;
            }
            $code .= "\n\t\t".'$this->db->delete(\''.$tableName.'\', array('.$arrayDelete.'));';

            $code .= "\n\t}\n\n";
            return $code;
        }
        
        private function __deleteWhere($tableName){
            $code = "\t".'public function deleteWhere($where){';
            $code .= "\n\t\t".'$this->db->delete(\''.$tableName.'\', $where);';
            $code .= "\n\t}\n\n";
            return $code;
        }
        
        private function __update($tableName, $className, $primaryKeys){
            $code = "\t".'protected function update(){';
            $arrayParams = '';
            foreach($primaryKeys as $key => $field){
                if($key!=0) $arrayParams.=', ';
                $arrayParams .= "'".$field."' => ".'$this->'.$field;
            }
            
            $code .= "\n\t\t".'$this->db->where(array('.$arrayParams.'));';
            //$code .= "\n\t\t".'var_dump($this);';
            $code .= "\n\t\t".'$this->db->update(\''.$tableName.'\',$this->toArray());';
            $code .= "\n\t\t".'return $this;';
            $code .= "\n\t}\n\n";
            return $code;
        }
        
        private function __toArray($fields,$className,$primaryKeys){
            $code = "\n\t".'public function toArray(){';
            $code .= "\n\t\t".'$array = array();';
            foreach($fields as $field){
                $fieldName = str_replace(array('_','-'), ' ', $field);
                $fieldName = str_replace(' ','',ucwords($fieldName));
                $code .= "\n\t\t".'$array[\''.$field.'\'] = $this->'.$field.';';
                
            }                
            $code .= "\n\t\t".'return $array;';

            $code .= "\n\t}\n\n";
            return $code;
        } 
        
        private function __reasignThis($fields,$className,$primaryKeys){
            $code = "\n\t".'public function reasignThis($object){';   
            $code .= "\n\t\t".'if(is_array($object)){';
            foreach($fields as $field){
                $fieldName = str_replace(array('_','-'), ' ', $field);
                $fieldName = str_replace(' ','',ucwords($fieldName));
                
                if(!in_array($field, $primaryKeys)){
                    $code .= "\n\t\t\t".'$this->set'.$fieldName.'($object[\''.$field.'\']);';
                }
                else{
                    $code .= "\n\t\t\t".'$this->'.$field.' = $object[\''.$field.'\'];';
                }
                
                
            }   
            $code .= "\n\t\t".'}';
            
            $code .= "\n\t\t".'else if(is_object($object)){';
            foreach($fields as $field){
                $fieldName = str_replace(array('_','-'), ' ', $field);
                $fieldName = str_replace(' ','',ucwords($fieldName));
                
                if(!in_array($field, $primaryKeys)){
                    $code .= "\n\t\t\t".'$this->set'.$fieldName.'($object->get'.$fieldName.'());';
                }
                else{
                    $code .= "\n\t\t\t".'$this->'.$field.' = $object->'.$field.';';
                }
                
                
            }
            $code .= "\n\t\t".'}';

            $code .= "\n\t}\n\n";
            return $code;
        }
        /* END CORE CLASS FUNCTIONS */
        
        /* FORM FUNCTIONS */
        private function __createForms($tableName, $className){
            $library_file = APPPATH.'libraries/forms/'.$tableName.'_form.php';  
            //if(!file_exists($library_file)){
                $fields = $this->db->field_data($tableName);    
                
                $fileContent = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); \n\n";
                $fileContent .= "class ".$className."_Form {\n\n";
                
                $fileContent .= $this->__configVars($fields);
                $fileContent .= $this->__renderForm($fields);
                $fileContent .= $this->__renderInputs($fields);
                $fileContent .= $this->__styledInput();
                $fileContent .= $this->__renderTypeInput();
                
                $fileContent .= "}\n\n";
                file_put_contents($library_file, $fileContent);
            //}
        }
        
        private function __configVars($fields){
            $code = "";
            foreach($fields as $field){
                if(!$field->primary_key){
                    $fieldName = str_replace(array('_','-'), ' ', $field->name);
                    $fieldName = str_replace(' ','',ucwords($fieldName));
                    if(in_array($field->type, $this->config->item('textTypes','orm_config'))) $type = 'textarea';
                    else if(in_array($field->type, $this->config->item('booleanTypes','orm_config'))) $type = 'checkbox';
                    else $type = 'normal';
                    $code .= "\n\t".'var $config'.$fieldName.' = array("type"=>"'.$type.'","label"=>"'.$field->name.'","attr"=>array("name"=>"'.$field->name.'","id"=>"'.$field->name.'","maxlength"=>"'.$field->max_length.'"));';
                }
                
            }
            
            $code .= "\n\n";
            return $code;
            
        }
        
        private function __renderForm($fields){
            $code = "\n\t".'public function render($action=""){';
            $code .= "\n\t\t".'$code = form_open($action);';
            foreach($fields as $field){
                $fieldName = str_replace(array('_','-'), ' ', $field->name);
                $fieldName = str_replace(' ','',ucwords($fieldName));
                if($field->primary_key!=1){
                    $code .= "\n\t\t".'$code .= $this->render'.$fieldName.'();';  
                }
            }            
            $code .= "\n\t\t".'$code .= form_close();';  
            $code .= "\n\t\t".'return $code;';  
            $code .= "\n\t}\n\n";
            
            return $code;
        }
        
        private function __renderInputs($fields){
            $code = "";
            foreach($fields as $field){
                $fieldName = str_replace(array('_','-'), ' ', $field->name);
                $fieldName = str_replace(' ','',ucwords($fieldName));
                if($field->primary_key!=1){
                     $code .= "\n\t".'public function render'.$fieldName.'(){';
                     $code .= "\n\t\t".'$code = "";';
                     $code .= "\n\t\t".'$code .= form_label($this->config'.$fieldName.'["label"],$this->config'.$fieldName.'["attr"]["id"]);';
                     $code .= "\n\t\t".'$code .= self::renderTypeInput($this->config'.$fieldName.');';
                     $code .= "\n\t\t".'return self::styledInput($code);';
                     $code .= "\n\t}\n\n";
                }
            }  
            
            return $code;
        }
        
        private function __renderTypeInput(){
            $code = "\n\t".'private function renderTypeInput($config){';  
            $code .= "\n\t\t".'if($config["type"]=="normal") return form_input($config["attr"]);';
            $code .= "\n\t\t".'else if($config["type"]=="password") return form_password($config["attr"]);';
            $code .= "\n\t\t".'else if($config["type"]=="textarea") return form_textarea($config["attr"]);';
            $code .= "\n\t\t".'else if($config["type"]=="checkbox") return form_checkbox($config["attr"]);';
            $code .= "\n\t\t".'else if($config["type"]=="radio") return form_radio($config["attr"]);';
            $code .= "\n\t\t".'else if($config["type"]=="submit") return form_submit($config["attr"]);';
            $code .= "\n\t\t".'else if($config["type"]=="button") return form_button($config["attr"]);';
            $code .= "\n\t\t".'else if($config["type"]=="reset") return form_reset($config["attr"]);';
            $code .= "\n\t}\n\n";
            
            return $code;
        }
        
        private function __styledInput(){
            $code = "\n\t".'private function styledInput($code,$topInput=null,$botInput=null){';  
            $code .= "\n\t\t".'if($topInput==null) $topInput = "<div>";';
            $code .= "\n\t\t".'if($botInput==null) $botInput = "<div>";';
            $code .= "\n\t\t".'return $topInput.$code.$botInput;';
            $code .= "\n\t}\n\n";
            
            return $code;
        }
        /* END FORM FUNCTIONS */
        
        
        private function __output($ORMOutput){
            echo "CodeIgniter ORM Generator v1.1 <br/><br/>";
            echo count($ORMOutput)." models generated:<br />";
            foreach($ORMOutput as $key => $table){
                echo $key." --> ";
                foreach($table as $key => $field){
                    if($key!=0) echo ', ';
                    echo $field;
                }
                echo '<br />';

            }
            echo "<br />Developed By Daniel Martín Domenech and Pablo Martín Carpio";
        }
}

