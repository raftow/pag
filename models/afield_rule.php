<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table afield_rule : afield_rule - قواعد عمل الحقول 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AfieldRule extends AFWObject{

        public static $MY_ATABLE_ID=13706; 

        
	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array(SHOW => true, RETRIEVE => true, EDIT => true, TYPE => PK),

		
		afield_id => array(SHORTNAME => field, 
                                  SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 40, MANDATORY => true, UTF8 => false, 
                                   TYPE => FK, ANSWER => afield, ANSMODULE => pag, 
                                   WHERE => "0 and 0", 
                                   RELATION => OneToMany, READONLY => false),

		afield_rule_type_id => array(SHORTNAME => rule_type, WHERE => "", SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 32, MANDATORY => true, UTF8 => false, TYPE => FK, ANSWER => afield_rule_type, ANSMODULE => pag, RELATION => ManyToOne, READONLY => false),

		related_afield_id => array(SHORTNAME => related, SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 40, UTF8 => false, 
                                           TYPE => FK, ANSWER => afield, ANSMODULE => pag, 
                                           WHERE=>"atable_id = (select atable_id from ".$server_db_prefix."pag.afield where id = §afield_id§) and id != §afield_id§",
                                           RELATION => ManyToOne, READONLY => false),

		rule_params => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SHORT_SIZE => 64, SIZE => 255, "MIN-SIZE" => 2, CHAR_TEMPLATE => "", UTF8 => true, TYPE => "TEXT", READONLY => false),

		rule_code => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => false, EDIT => true, QEDIT => true, SIZE => 32, "MIN-SIZE" => 5, CHAR_TEMPLATE => "ALPHABETIC,NUMERIC,UNDERSCORE", UTF8 => false, TYPE => "TEXT", READONLY => false),

		rule_source => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => false, EDIT => true, QEDIT => true, SHORT_SIZE => 64, SIZE => 255, "MIN-SIZE" => 3, CHAR_TEMPLATE => "ALPHABETIC,ARABIC-CHARS,BRACKETS,COMMAS,MARKS,MATH-SYMBOLS,NUMERIC,OTHER-SYMBOLS,SPACE,UNDERSCORE", UTF8 => true, TYPE => "TEXT", READONLY => false),

		rule_desc => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => false, EDIT => true, QEDIT => false, SIZE => "AREA", UTF8 => false, TYPE => "TEXT", READONLY => false),

                
                id_aut => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_aut => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                id_mod => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_mod => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                id_valid => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_valid => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                avail => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, "DEFAULT" => 'Y', TYPE => YN),
                version => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => INT),
                update_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                delete_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                display_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                sci_id => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => scenario_item, ANSMODULE => pag),
                tech_notes 	    => array(TYPE => TEXT, CATEGORY => FORMULA, "SHOW-ADMIN" => true, 'STEP' =>"all", TOKEN_SEP=>"§", READONLY=>true, "NO-ERROR-CHECK"=>true),
	);
	
	*/ public function __construct(){
		parent::__construct("afield_rule","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "";
                $this->ORDER_BY_FIELDS = "afield_id, afield_rule_type_id, related_afield_id, rule_params";
                 
                
                $this->UNIQUE_KEY = array('afield_id','afield_rule_type_id','related_afield_id','rule_params');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
	}
        
        public static function loadById($id)
        {
           $obj = new AfieldRule();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($afield_id, $afield_rule_type_id, $related_afield_id, $rule_params,$create_obj_if_not_found=false)
        {
           $obj = new AfieldRule();
           if(!$afield_id) throw new AfwRuntimeException("loadByMainIndex : afield_id is mandatory field");
           if(!$afield_rule_type_id) throw new AfwRuntimeException("loadByMainIndex : afield_rule_type_id is mandatory field");


           $obj->select("afield_id",$afield_id);
           $obj->select("afield_rule_type_id",$afield_rule_type_id);
           $obj->select("related_afield_id",$related_afield_id);
           $obj->select("rule_params",$rule_params);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("afield_id",$afield_id);
                $obj->set("afield_rule_type_id",$afield_rule_type_id);
                $obj->set("related_afield_id",$related_afield_id);
                $obj->set("rule_params",$rule_params);

                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               
               $data = array();
               $link = array();
               

               list($data[0],$link[0]) = $this->displayAttribute("afield_id",false, $lang);
               list($data[1],$link[1]) = $this->displayAttribute("related_afield_id",false, $lang);
               list($data[2],$link[2]) = $this->displayAttribute("rule_code",false, $lang);

               
               return implode(" - ",$data);
        }
        
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            //$pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
            
            
            
            return $pbms;
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
            
            
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 

                        
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
        
        public function beforeMAJ($id, $fields_updated) 
        {
        
                if((!$this->getVal("rule_params")) or ($this->getVal("rule_params")=="--"))
                {         
                     $field = $this->hetField();
                     $related = $this->hetRelated();
                     
                     if($field and $related)
                     {
                           $anstable = $field->hetAnstable();
                           if($anstable)
                           {
                               $at_origFieldList = $anstable->get("origFieldList");
                               $relatedFieldList = array();
                               $relatedFieldList[$related->getId()] = $related;
                               
                               $intersectionFieldList = AfwWizardHelper::afwListObjInstersection($relatedFieldList, $at_origFieldList, $compareMethod="myAnswerTableName", $keepEmpty=false);
                               // die("intersectionFieldList = ".var_export($intersectionFieldList,true));
                               $rule_params_arr = array();
                               
                               foreach($intersectionFieldList as $intersectionFieldArr)
                               {
                                     $item1 = $intersectionFieldArr["item1"]->valField_name();
                                     $item2 = $intersectionFieldArr["item2"]->valField_name();
                                     
                                     $rule_params_arr[] = "$item2 = §${item1}§";
                               }
                               
                               $this->set("rule_params",implode(" and ",$rule_params_arr));
                           }
                           else $this->set("rule_params","error : ans tab of $field not defined");
                     }      
                           
                           
                           
                }
                
		return true;
	}
        
        
             
}
?>