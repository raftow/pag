<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table genre : genre - الأجناس 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Genre extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                "id" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		"genre_name_ar" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "UTF8" => true, "TYPE" => "TEXT"),
		"genre_name_en" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "UTF8" => true, "TYPE" => "TEXT"),
                
                "lookup_code" => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true),
                
                "id_aut" 	=> array("TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums", "CATEGORY" => "", "SHOW-ADMIN" => true, "ROLES"=>"6"), 
		"date_aut" 	=> array("TYPE" => "DATE", "CATEGORY" => "", "SHOW-ADMIN" => true, "ROLES"=>"6"), 
		"id_mod"        => array("TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums", "SHOW-ADMIN" => true),
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
		parent::__construct("genre","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "genre_name_ar";
                $this->ORDER_BY_FIELDS = "genre_name_ar";
                $this->public_display = true;
	}
        
        public function userCan($auser,$operation,$id_main_sh=0, $module="", $classe="")
        {
                if($operation=="display") return true;
                else return false;
        }
}
?>