<?php

$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class EimportRecord extends AFWObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "pag"; 
        public static $TABLE			= "eimport_record"; 
        public static $DB_STRUCTURE = null; 
        
        public function __construct(){
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