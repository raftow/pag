<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table lookup_value : lookup_value - مفردات لقائمة إختيارات ثابتة 
// ------------------------------------------------------------------------------------
 
 
$file_dir_name = dirname(__FILE__); 
 
// old include of afw.php
 
class LookupValue extends AFWObject{
 
        public static $MY_ATABLE_ID=13698; 
 
 
	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array(SHOW => true, RETRIEVE => true, EDIT => true, TYPE => PK),
 
 
		"atable_id" => array("SHORTNAME" => atable, "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => false, "SIZE" => 40, "MANDATORY" => true, "UTF8" => false, "TYPE" => "FK", "ANSWER" => atable, "ANSMODULE" => pag, "DEFAULT" => 0),
		"vcode" => array("SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "MANDATORY" => true, "UTF8" => true, "TYPE" => "TEXT"),
		"pkey" => array("SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "MANDATORY" => true, "UTF8" => false, "TYPE" => "INT"),
		"value" => array("SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 255, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "MANDATORY" => true, "UTF8" => true, "TYPE" => "TEXT"),
 
                id_aut => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_aut => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                id_mod => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_mod => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                id_valid => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_valid => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                avail => array("SHOW-ADMIN" => true, RETRIEVE => true, EDIT => false, "DEFAULT" => 'Y', TYPE => YN),
                version => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => INT),
                update_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                delete_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                display_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                sci_id => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => scenario_item, ANSMODULE => pag),
                tech_notes 	    => array(TYPE => TEXT, CATEGORY => FORMULA, "SHOW-ADMIN" => true, 'STEP' =>"all", TOKEN_SEP=>"§", READONLY=>true, "NO-ERROR-CHECK"=>true),
	);
 
	*/ public function __construct(){
		parent::__construct("lookup_value","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "value";
                $this->ORDER_BY_FIELDS = "atable_id, vcode";
 
 
                $this->UNIQUE_KEY = array('atable_id','vcode');
 
	}
 
        public static function loadById($id)
        {
           $obj = new LookupValue();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
 
 
 
        public static function loadByMainIndex($atable_id, $vcode,$create_obj_if_not_found=false)
        {
           $obj = new LookupValue();
           if(!$atable_id) $obj->throwError("loadByMainIndex : atable_id is mandatory field");
           if(!$vcode) $obj->throwError("loadByMainIndex : vcode is mandatory field");
 
 
           $obj->select("atable_id",$atable_id);
           $obj->select("vcode",$vcode);
 
           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("atable_id",$atable_id);
                $obj->set("vcode",$vcode);
 
                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
 
        }
 
 
        public function getDisplay($lang="ar")
        {
               if($this->getVal("value")) return $this->getVal("value");
               $data = array();
               $link = array();
 
 
               list($data[0],$link[0]) = $this->displayAttribute("atable_id",false, $lang);
               list($data[1],$link[1]) = $this->displayAttribute("vcode",false, $lang);
 
 
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