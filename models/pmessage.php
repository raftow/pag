<?php


class Pmessage extends AFWObject{

        public static $COMPTAGE_BEFORE_LOAD_MANY = true;

	public static $DATABASE		= ""; 
	public static $MODULE		    = "pag"; 
	public static $TABLE			= ""; 
	public static $DB_STRUCTURE = null; /* = array(
		"id" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "PK"),
		"stakeholder_id" => array(QSEARCH => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, TYPE => FK, ANSWER => orgunit, ANSMODULE => hrm, "SIZE" => 40, "QEDIT" => true, "DEFAULT" => 0, "IMPORTANT"=>"CM"),
		"module_id" => array(QSEARCH => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "module", "SIZE" => 40, "DEFAULT" => 0, "QEDIT" => true, "WHERE"=>"(id_main_sh=§stakeholder_id§ or §stakeholder_id§=0)", "ANSMODULE" => "ums"),
                "atable_id" => array(QSEARCH => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "atable", "SIZE" => 40, "QEDIT" => true, "DEFAULT" => 0, "WHERE"=>"id_module=§module_id§"),
                "pmessage_type_id" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "pmessage_type", "QEDIT" => true, "SIZE" => 40, "DEFAULT" => 0),
                 
		"message_code" => array(QSEARCH => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "UTF8" => false, "SIZE" => 64, "TYPE" => "TEXT"),
                
                "message_ar" => array(QSEARCH => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "UTF8" => true, "SIZE" => 255, "TYPE" => "TEXT"),
                "message_en" => array(QSEARCH => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "UTF8" => false, "SIZE" => 255, "TYPE" => "TEXT"),
		
		"id_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
		"id_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
		"id_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                "avail" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "QEDIT" => true, "QEDIT-ADMIN" => false, "DEFAULT" => "Y", "EDIT-ADMIN" => true, "TYPE" => "YN"),
		"version" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "ANSMODULE" => "pag", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),

	);
    */    
        
    public $details = array();
        
	public function __construct(){
		parent::__construct($tablename="pmessage","id","pag");
                $this->DISPLAY_FIELD = "message_ar";
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 20;
                $this->copypast = true;
	}

        
        
    public function getOrderByFields()
	{
		return "stakeholder_id,module_id,atable_id,pmessage_type_id,message_ar";
	}
}
?>