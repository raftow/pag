<?php
// ------------------------------------------------------------------------------------
// 6/6/2022 rafik :
//  alter table c0pag.afield_option_value change option_value_comments option_value_comments text NULL;
// 
                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AfieldOptionValue extends AFWObject{

        public static $MY_ATABLE_ID=3589; 

        
	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array(SHOW => true, RETRIEVE => true, EDIT => true, TYPE => PK),

		
		afield_id => array(SHORTNAME => afield, SEARCH => true, QSEARCH => false, SHOW => true, RETRIEVE => false, EDIT => true, QEDIT => true, SIZE => 40, MANDATORY => true, UTF8 => false, TYPE => FK, ANSWER => afield, ANSMODULE => pag, RELATION => OneToMany, READONLY => false),

		foption_id => array(SHORTNAME => foption, SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 32, MANDATORY => true, UTF8 => false, TYPE => FK, ANSWER => foption, ANSMODULE => pag, RELATION => ManyToOne, READONLY => false),

		option_value => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 128, "MIN-SIZE" => 5, CHAR_TEMPLATE => "ARABIC-CHARS,SPACE", MANDATORY => true, UTF8 => true, TYPE => "TEXT", READONLY => false),

		option_value_comments => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => "AREA", "MIN-SIZE" => 10, CHAR_TEMPLATE => "ALL", MANDATORY => false, UTF8 => true, TYPE => "TEXT", READONLY => false),

                
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
		parent::__construct("afield_option_value","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "";
                $this->ORDER_BY_FIELDS = "afield_id, foption_id";
                 
                
                $this->UNIQUE_KEY = array('afield_id','foption_id');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
	}
        
        public static function loadById($id)
        {
           $obj = new AfieldOptionValue();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($afield_id, $foption_id,$create_obj_if_not_found=false)
        {
           $obj = new AfieldOptionValue();
           if(!$afield_id) throw new AfwRuntimeException("loadByMainIndex : afield_id is mandatory field");
           if(!$foption_id) throw new AfwRuntimeException("loadByMainIndex : foption_id is mandatory field");


           $obj->select("afield_id",$afield_id);
           $obj->select("foption_id",$foption_id);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("afield_id",$afield_id);
                $obj->set("foption_id",$foption_id);

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
               list($data[1],$link[1]) = $this->displayAttribute("foption_id",false, $lang);

               
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
        
        
        protected function beforeDelete($id,$id_replace) 
        {
            
            
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK part of me - not deletable 

                        
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}
?>