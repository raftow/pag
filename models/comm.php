<?php


class Comm extends AFWObject{

	public static $DATABASE		= ""; 
	public static $MODULE		    = "pag"; 
	public static $TABLE			= ""; 
	public static $DB_STRUCTURE = null; /* = array(
		"id" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "PK"),
		"titre" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "UTF8" => true, "SIZE" => 255, "TYPE" => "TEXT"),
		"titre_short" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "UTF8" => true, "SIZE" => 40, "TYPE" => "TEXT"),
		
                "id_stakeholder_dest" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, 
                                                TYPE => FK, ANSWER => orgunit, ANSMODULE => hrm,  
                                                "SIZE" => 40, "DEFAULT" => 0),
		"id_resp_dest" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "auser", ANSMODULE => "ums", "SIZE" => 40, "DEFAULT" => 0),
		"date_comm" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "DATE"),
		"id_atable" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "atable", "SIZE" => 40, "DEFAULT" => 0),
                "id_theme" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "theme", "SIZE" => 40, "DEFAULT" => 0),
		"ident_record" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "INT"),
		"id_ptext" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "ptext", "SIZE" => 40, "DEFAULT" => 0),
                
                "id_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"avail" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "TYPE" => "YN"),
		"version" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		
	);
	*/
	
	public function __construct($tablename="comm"){
		parent::__construct($tablename,"id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
	}
}
?>