<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table foption_case : foption_case - حالات خيارات الحقول 
// ------------------------------------------------------------------------------------
// ALTER TABLE `foption_case` CHANGE `foption_case_name_ar` `foption_case_name_ar` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL; 
// ALTER TABLE `foption_case` CHANGE `foption_case_name_en` `foption_case_name_en` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
// ALTER TABLE `foption_case` CHANGE `afield_type_mfk` `afield_type_mfk` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ','; 
                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class FoptionCase extends AFWObject{

        public static $MY_ATABLE_ID=3588; 

        
	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array(SHOW => true, RETRIEVE => true, EDIT => true, TYPE => PK),

		
		foption_id => array(SHORTNAME => foption, SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => false, EDIT => true, QEDIT => false, SIZE => 32, MANDATORY => true, UTF8 => false, TYPE => FK, ANSWER => foption, ANSMODULE => pag, RELATION => OneToMany, READONLY => false),

		foption_case => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 16, "MIN-SIZE" => 3, CHAR_TEMPLATE => "ALPHABETIC,NUMERIC,UNDERSCORE", MANDATORY => true, UTF8 => true, TYPE => "TEXT", READONLY => false),

		foption_case_name_ar => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => false, SIZE => 128, "MIN-SIZE" => 5, CHAR_TEMPLATE => "ARABIC-CHARS,SPACE", MANDATORY => true, UTF8 => true, TYPE => "TEXT", READONLY => false),

		foption_case_name_en => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 128, "MIN-SIZE" => 5, CHAR_TEMPLATE => "ALPHABETIC,SPACE", MANDATORY => true, UTF8 => false, TYPE => "TEXT", READONLY => false),

		foption_case_desc_ar => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => false, SIZE => "AREA", UTF8 => true, TYPE => "TEXT", READONLY => false),

		foption_case_desc_en => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => "AREA", UTF8 => false, TYPE => "TEXT", READONLY => false),

		afield_type_mfk => array(SHORTNAME => types, SEARCH => true, QSEARCH => false, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 32, MANDATORY => true, UTF8 => false, TYPE => MFK, ANSWER => afield_type, ANSMODULE => pag, READONLY => false),

		afield_category_mfk => array(SHORTNAME => categorys, SEARCH => true, QSEARCH => false, SHOW => true, RETRIEVE => false, EDIT => true, QEDIT => false, SIZE => 32, UTF8 => false, TYPE => MFK, ANSWER => afield_category, ANSMODULE => pag, READONLY => false),

                
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
		parent::__construct("foption_case","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "";
                $this->ORDER_BY_FIELDS = "foption_id, foption_case";
                 
                
                $this->UNIQUE_KEY = array('foption_id','foption_case');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
	}
        
        public static function loadById($id)
        {
           $obj = new FoptionCase();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($foption_id, $foption_case,$create_obj_if_not_found=false)
        {
          if(strlen($foption_case)>24) return null;
           $obj = new FoptionCase();
           if(!$foption_id) throw new AfwRuntimeException("foption_case::loadByMainIndex : foption_id is mandatory field");
           //if(!$foption_case) throw new AfwRuntimeException("loadByMainIndex : foption_case is mandatory field");


           $obj->select("foption_id",$foption_id);
           if(is_array($foption_case))
           {
                $foption_case = var_export($foption_case,true);
           }
           $obj->select("foption_case",$foption_case);

           if($obj->load())
           {
                if(!$obj->id) die("foption_case::loadByMainIndex : obj empty = ".var_export($obj,true));
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("foption_id",$foption_id);
                $obj->set("foption_case",$foption_case);

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
               

               list($data[0],$link[0]) = $this->displayAttribute("foption_id",false, $lang);
               list($data[1],$link[1]) = $this->displayAttribute("foption_case",false, $lang);

               
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
             
}
?>