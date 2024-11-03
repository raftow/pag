<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table afield_rule_type : afield_rule_type - أنواع قواعد العمل 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AfieldRuleType extends AFWObject{

        public static $MY_ATABLE_ID=13707; 


 // lookup Value List codes 
        // ACTIVATION - تنشيط الحقل  يتغير حسب الحقل المرتبط  
        public static $AFIELD_RULE_TYPE_ACTIVATION = 3; 

        // APPLICABLE - قابلية التطبيق تتغير حسب الحقل المرتبط  
        public static $AFIELD_RULE_TYPE_APPLICABLE = 2; 

        // DEPENDENCY - قائمة الاختيار تتغير حسب الحقل المرتبط  
        public static $AFIELD_RULE_TYPE_DEPENDENCY = 1; 


        
	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array(SHOW => true, RETRIEVE => true, EDIT => true, TYPE => PK),

		
		"lookup_code" => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true, SHORTNAME=>code),

		afield_rule_type_name_ar => array(SEARCH => false, QSEARCH => false, SHOW => true, RETRIEVE => false, EDIT => true, QEDIT => true, SIZE => 128, "MIN-SIZE" => 5, CHAR_TEMPLATE => "ARABIC-CHARS,SPACE", MANDATORY => true, UTF8 => true, TYPE => "TEXT", READONLY => false),

		afield_rule_type_name_en => array(SEARCH => false, QSEARCH => false, SHOW => true, RETRIEVE => false, EDIT => true, QEDIT => true, SIZE => 128, "MIN-SIZE" => 5, CHAR_TEMPLATE => "ALPHABETIC,SPACE", MANDATORY => true, UTF8 => false, TYPE => "TEXT", READONLY => false),

                
                id_aut => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_aut => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                id_mod => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_mod => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                id_valid => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_valid => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                avail => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => true, "DEFAULT" => 'Y', TYPE => YN),
                version => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => INT),
                update_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                delete_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                display_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                sci_id => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => scenario_item, ANSMODULE => pag),
                tech_notes 	    => array(TYPE => TEXT, CATEGORY => FORMULA, "SHOW-ADMIN" => true, 'STEP' =>"all", TOKEN_SEP=>"§", READONLY=>true, "NO-ERROR-CHECK"=>true),
	);
	
	*/ public function __construct(){
		parent::__construct("afield_rule_type","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "afield_rule_type_name_ar";
                $this->ORDER_BY_FIELDS = "lookup_code";
                $this->IS_LOOKUP = true; 
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array('lookup_code');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
	}
        
        public static function loadById($id)
        {
           $obj = new AfieldRuleType();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           $obj = new AfieldRuleType();
           if(!$lookup_code) throw new AfwRuntimeException("loadByMainIndex : lookup_code is mandatory field");


           $obj->select("lookup_code",$lookup_code);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("lookup_code",$lookup_code);

                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               if($this->getVal("afield_rule_type_name_$lang")) return $this->getVal("afield_rule_type_name_$lang");
               $data = array();
               $link = array();
               


               
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
                       // pag.afield_rule-قاعدة عمل حقل	afield_rule_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}pag.afield_rule set afield_rule_type_id='$id_replace' where afield_rule_type_id='$id' ");

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 
                       // pag.afield_rule-قاعدة عمل حقل	afield_rule_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}pag.afield_rule set afield_rule_type_id='$id_replace' where afield_rule_type_id='$id' ");

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}
?>