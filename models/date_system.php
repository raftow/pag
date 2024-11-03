<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table date_system : date_system - الأنظمة التأريخية 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class DateSystem extends AFWObject{

        public static $MY_ATABLE_ID=3485; 
        // إدارة الأنظمة التأريخية 
        public static $BF_QEDIT_DATE_SYSTEM = 103304; 
        // عرض تفاصيل نظام تأريخي 
        public static $BF_DISPLAY_DATE_SYSTEM = 103306; 
        // مسح نظام تأريخي 
        public static $BF_DELETE_DATE_SYSTEM = 103305; 


 // lookup Value List codes 

        
	public static $DATABASE		= ""; 
   public static $MODULE		    = "pag"; 
   public static $TABLE			= ""; 
   public static $DB_STRUCTURE = null; /* = array(
                id => array(SHOW => true, RETRIEVE => true, EDIT => true, TYPE => PK),

		
		"lookup_code" => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true, SHORTNAME=>code),

		date_system_name => array(SEARCH => true, QSEARCH => false, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 48, MANDATORY => true, UTF8 => true, TYPE => "TEXT", READONLY => false),

		name_ar => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 128, MANDATORY => true, UTF8 => true, TYPE => "TEXT", READONLY => false),

		name_en => array(SEARCH => true, QSEARCH => true, SHOW => true, RETRIEVE => true, EDIT => true, QEDIT => true, SIZE => 128, MANDATORY => true, UTF8 => false, TYPE => "TEXT", READONLY => false),

                
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
	
	*/ 
         public function __construct()
         {
		         parent::__construct("date_system","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "";
                $this->ORDER_BY_FIELDS = "lookup_code";
                $this->IS_LOOKUP = true; 
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array('lookup_code');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
	      }
        
        public static function loadById($id)
        {
           $obj = new DateSystem();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public static function loadAll()
        {
           $obj = new DateSystem();
           $obj->select("active",'Y');

           $objList = $obj->loadMany();
           
           return $objList;
        }

        
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           $obj = new DateSystem();
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
               
               $data = array();
               $link = array();
               

               list($data[0],$link[0]) = $this->displayAttribute("name_ar",false, $lang);
               list($data[1],$link[1]) = $this->displayAttribute("name_en",false, $lang);

               
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
                       // pag.country-النظام التأريخي	date_system_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}pag.country set date_system_id='$id_replace' where date_system_id='$id' ");

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 
                       // pag.country-النظام التأريخي	date_system_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}pag.country set date_system_id='$id_replace' where date_system_id='$id' ");

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}
?>