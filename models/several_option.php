<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table tboption : tboption - خيارات الجداول 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class SeveralOption extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                "id" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		"option_name_ar" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 128, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "RETRIEVE-ADMIN" => true, "EDIT-ADMIN" => true, "QEDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),
		"option_name_en" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 128, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "RETRIEVE-ADMIN" => true, "EDIT-ADMIN" => true, "QEDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),

                "atable_id" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => true, "SIZE" => 40, 
                                       TYPE => FK, ANSWER => atable, ANSMODULE => pag, 
                                       WHERE => "",
                                       "DEFAULT" => 0, AUTOCOMPLETE=>true, "SEARCH-BY-ONE"=>true, ),

                "option_table_id" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => true, "SIZE" => 40, "TYPE" => "FK", "ANSWER" => "atable", "ANSMODULE" => "pag", 
                                                "DEFAULT" => 0, AUTOCOMPLETE=>true, "SEARCH-BY-ONE"=>true, WHERE => "tboption_mfk like '%,2,%'",),
                
                "id_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                "id_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                "id_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                "avail" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "TYPE" => "YN"),
                "version" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
                "update_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "pag", "TYPE" => "MFK"),
                "delete_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "pag", "TYPE" => "MFK"),
                "display_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "pag", "TYPE" => "MFK"),
                "sci_id" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "scenario_item", "ANSMODULE" => "pag"),
	);
	
	*/ public function __construct(){
		parent::__construct("several_option","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "option_name_ar";
                $this->ORDER_BY_FIELDS = "option_name_ar";
                
                
	}
}
?>