<?php

$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class EimportRecord extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
		"id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		"eimport_id" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false,  
                                          "TYPE" => "FK", "ANSWER" => eimport, "ANSMODULE" => "pag", "DEFAULT" => 0, "READONLY"=>true),
                                          
                "record_num" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "TYPE" => "INT", ),
                "record_atable_id" => array("SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, TYPE => FK, ANSWER => atable, ANSMODULE => pag ),
                "record_id" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "TYPE" => "INT", ),

                "success" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "SIZE" => 32,  "TYPE" => "YN", "DEFAULT" => "Y"),
                "new" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "SIZE" => 32, "TYPE" => "YN", "DEFAULT" => "Y"),
                "titre" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "UTF8" => true, "SIZE" => 64, "TYPE" => "TEXT", ),
		"error_description" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "UTF8" => true, "SIZE" => 120, "TYPE" => "TEXT", ),
		
		"id_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"avail" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "EDIT-ADMIN" => true, "TYPE" => "YN"),
		"version" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
	);
	        
	*/ public function __construct(){
		parent::__construct("eimport_record","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                $this->DISPLAY_FIELD = "titre";
                $this->ORDER_BY_FIELDS = "eimport_id, record_num, record_atable_id, record_id";
                $this->UNIQUE_KEY = array('eimport_id','record_num','record_atable_id');
	}
        
        public static function loadByMainIndex($eimport_id, $record_num, $record_atable_id, $record_id, $titre, $create_obj_if_not_found=false)
        {
           $obj = new EimportRecord();
           $obj->select("eimport_id",$eimport_id);
           $obj->select("record_num",$record_num);
           $obj->select("record_atable_id",$record_atable_id);

           if($obj->load())
           {
                     
                     if($create_obj_if_not_found) 
                     {
                         $obj->set("record_id",$record_id);
                         $obj->set("titre",$titre);
                         $obj->activate();
                     }
                     return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                     $obj->set("eimport_id",$eimport_id);
                     $obj->set("record_num",$record_num);
                     $obj->set("record_atable_id",$record_atable_id);
                     $obj->set("record_id",$record_id);
                     $obj->set("titre",$titre);
                     $obj->insert();
                     return $obj;
           }
           else return null;
           
        }
        
        public function isTechField($attribute) {
		
        	$TECH_FIELDS_TYPE = array("id_aut"=>"FK", "date_aut"=>"DATETIME", "id_mod"=>"FK", "date_mod"=>"DATETIME", "id_valid"=>"FK", "date_valid"=>"DATE", "version"=>"INT");
                return  ($TECH_FIELDS_TYPE[$attribute]);
	}
        
        
        public function fld_CREATION_USER_ID()
        {
                return "id_aut";
        }

        public function fld_CREATION_DATE()
        {
                return "date_aut";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return "id_mod";
        }

        public function fld_UPDATE_DATE()
        {
        	return "date_mod";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return "id_valid";
        }

        public function fld_VALIDATION_DATE()
        {
                return "date_valid";
        }
        
        public function fld_VERSION()
        {
        	return "version";
        }

        public function fld_ACTIVE()
        {
        	return  "avail";
        }
        
                
}
?>