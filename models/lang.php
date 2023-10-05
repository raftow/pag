<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table lang : lang - اللغات 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Lang extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                "id" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		"lang_name_ar" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),
                "lookup_code" => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true, "SHORTNAME"=>code),
		"lang_name_en" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "TEXT"),
                
                
                "id_aut" 	=> array("TYPE" => "FK", 	"ANSWER" => "auser", "CATEGORY" => "", "SHOW-ADMIN" => true, "ROLES"=>"6", "ANSMODULE" => "ums"), 
		"date_aut" 	=> array("TYPE" => "DATE", 		"CATEGORY" => "", "SHOW-ADMIN" => true, "ROLES"=>"6"), 
		"id_mod"        => array("TYPE" => "FK", "ANSWER" => "auser", "SHOW-ADMIN" => true, "ANSMODULE" => "ums"),
		"date_mod"      => array("TYPE" => "DATE", "SHOW-ADMIN" => true),
		"id_valid"      => array("TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
		"date_valid"     => array("TYPE" => "DATE"),
                "avail" 	=> array("TYPE" => "YN", 		"CATEGORY" => "", "SHOW-ADMIN" => true    , "ROLES"=>"", "DEFAULT"=>"Y"), 
                "version" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT", "DEFAULT" => 0),
		"update_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "TYPE" => "MFK", "ANSMODULE" => "ums"),
		"delete_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "TYPE" => "MFK", "ANSMODULE" => "ums"),
		"display_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "TYPE" => "MFK", "ANSMODULE" => "ums"),
		"sci_id" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "scenario_item", "ANSMODULE" => "pag"),
	);
	
	*/ public function __construct(){
		parent::__construct("lang","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "lang_name_ar";
                $this->ORDER_BY_FIELDS = "lang_name_ar";
				$this->public_display = true;
	}
        
        
        public function userCan($auser,$operation,$id_main_sh=0, $module="", $classe="")
        {
                if($operation=="display") return true;
                else return false;
        }
}
?>