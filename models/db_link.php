<?php


class DbLink extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array( 

                "id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "PK"),
                "id_module_parent" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "module", "DEFAULT" => 0, "SHORTNAME"=>"parent"),
                "mod1_id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "module", "DEFAULT" => 0, "SHORTNAME"=>"module1"),
                "mod2_id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "module", "DEFAULT" => 0, "SHORTNAME"=>"module2"),
		"field_id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "afield", "DEFAULT" => 0, "SHORTNAME"=>"field"),
                "tab1_id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "atable", "DEFAULT" => 0, "SHORTNAME"=>"table1"),
                "tab2_id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "atable", "DEFAULT" => 0, "SHORTNAME"=>"table2"),
                entity_relation_type_id => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 40, 
                                          "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, 
                                          "TYPE" => "FK", "ANSWER" => entity_relation_type, "ANSMODULE" => pag, "DEFAULT" => 0, 
                                          "MINIBOX"=>false, "READONLY" => true,
                                          "CATEGORY" => "SHORTCUT", "SHORTCUT"=>"field_id.entity_relation_type_id","CAN-BE-SETTED"=>false,),
		
		"bfsol_id" => array("TYPE" => "FK", "ANSWER" => "bfunction", "ANSMODULE" => "ums", "CATEGORY" => "FORMULA",  
                                    "RETRIEVE" => true, "SHOW" => true, "EDIT" => true, "QEDIT" => true, "READONLY"=>true, "SHORTNAME"=>"bfsolution"),
                
                "id_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"avail" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "EDIT-ADMIN" => true, "QEDIT" => false, "TYPE" => "YN"),
		"version" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
	);
	
	*/ public function __construct(){
		parent::__construct("db_link","id","pag");
                $this->ORDER_BY_FIELDS = "mod1_id, mod2_id, field_id";
                $this->IS_VIEW = true;
	}
        
        
        public function getFormuleResult($attribute, $what='value') 
        {
            $me = AfwSession::getUserIdActing();    
               
               $file_dir_name = dirname(__FILE__);
               
               $lang = "ar"; 
        
        
               
               
	       switch($attribute) 
               {
                    case "bfsol_id" :
                        /*require_once("$file_dir_name/bfunction.php");
                        $bfsol  = new Bfunction();*/
                        $at = $this->get("tab2_id");
                        if(!$at)
                        {
                             return null;
                        }
                        $module = $at->getModule();
                        if(!$module)
                        {
                             return null;
                        }
                        $module_code = $module->getVal("module_code");
                        if(!$module_code)
                        {
                             return null;
                        }
                        $at_id = $at->getId();
                        $atable_name = $at->getVal("atable_name"); 
                        $operation = "web_serv_lkup_";
                        
                        $bfsol_file_name =  "hzm_".$operation.$module_code."_".$atable_name;
                        $operationLabel = $this->operationLabel($operation, $lang, $at_id);
                        list($bfsol,$isnew) = Bfunction::getBF(0, "pag", $bfsol_file_name, $module_code, $at_id, "", $operationLabel, 'N', 'N', 10, "web-serv-lkup-$module_code-$atable_name",0,0,"get bfsol_id formula value of $this");
                        
                        return $bfsol;
                    break;   
               }
               
        }         
}
        
        
        
?>