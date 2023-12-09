<?php


class ScenarioItem extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
		"id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),
		"atable_id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => false, "QEDIT" => true, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "atable", "ANSMODULE" => "pag", 
                                     "SIZE" => 40, "DEFAULT" => 0, "SHORTNAME" => "table"), // , "WHERE"=>"id_module = 44"
		"step_num" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "TYPE" => "INT"),
		"step_name_ar" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "QEDIT" => true, "EDIT" => true, "UTF8" => true, "SIZE" => 64, "TYPE" => "TEXT"),
		"step_name_en" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "QEDIT" => true, "EDIT" => true, "UTF8" => true, "SIZE" => 64, "TYPE" => "TEXT"),
		"help_text" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 128, "UTF8" => true, "TYPE" => "TEXT"),
                max_order => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "INT"),

		"avail" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "QEDIT" => true, "QEDIT-ADMIN" => false, "DEFAULT" => "Y", "EDIT-ADMIN" => true, "TYPE" => "YN"),
		"id_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "GDAT"),
		"id_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "GDAT"),
		"id_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "GDAT"),
		"version" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
	);
	
	*/ public function __construct(){
		parent::__construct("scenario_item","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                $this->DISPLAY_FIELD = "step_name_ar";
                $this->ORDER_BY_FIELDS = "atable_id,step_num, id";
                $this->UNIQUE_KEY = array('atable_id','step_num');
	}
        
        public static function loadById($id)
        {
           $obj = new ScenarioItem();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
 
        public static function loadByMainIndex($atable_id, $step_num, $step_name_ar, $create_obj_if_not_found=false)
        {
 
                if(!$atable_id) throw new RuntimeException("loadByMainIndex : atable_id is mandatory field");
                if(!$step_num) throw new RuntimeException("loadByMainIndex : step_num is mandatory field");
                if(!$step_name_ar) throw new RuntimeException("loadByMainIndex : step_name_ar is mandatory field");

                $obj = new ScenarioItem();
                $obj->select("atable_id",$atable_id);
                $obj->select("step_num",$step_num);
        
                if($obj->load())
                {
                        $obj->set("step_name_ar",$step_name_ar);
                        if($create_obj_if_not_found) $obj->activate();
                        return $obj;
                }
                elseif($create_obj_if_not_found)
                {
                        $obj->set("atable_id",$atable_id);
                        $obj->set("step_num",$step_num);
                        $obj->set("step_name_ar",$step_name_ar);
        
                        $obj->insert();
                        $obj->is_new = true;
                        return $obj;
                }
                else return null;
 
        }
 
 
               
        
        public function getNextStepNum() 
        {
               
               $this->select("atable_id", $this->getVal("atable_id"));
               return $this->func("IF(ISNULL(max(step_num)), -1, max(step_num))+1");
        
        }
        
        public function beforeMAJ($id, $fields_updated) 
        {
                $objme = AfwSession::getUserConnected();
             
                // old require of common_string
                
                if($this->getVal("step_num")=="") {
                        
                        $this->set("step_num",$this->getNextStepNum());
                }
                
		return true;
	}
        
        public function getPreviousStep()
        {
            $my_tab = $this->get("atable_id");
            return $my_tab->getStepBefore($this);
        }

        public function getNextStep()
        {
            $my_tab = $this->get("atable_id");
            return $my_tab->getStepAfter($this);
        }
        
        public function getRAMObjectData()
        {
                  $category_id = 9;

                  $type_id = 532;
                  
                  $code = "step".$this->getVal("step_num");
                  $name_ar = $this->getVal("step_name_ar");
                  $name_en = $this->getVal("step_name_en");
                  $specification = $this->getVal("help_text");
                  
                  $childs = array();
                  
                  return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
        
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
        
        public function isTechField($attribute) {
            return (($attribute=="id_aut") or ($attribute=="date_aut") or ($attribute=="id_mod") or ($attribute=="date_mod") or ($attribute=="id_valid") or ($attribute=="date_valid") or ($attribute=="version"));  
        }
        
        
}
?>