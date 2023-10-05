<?php
// ------------------------------------------------------------------------------------
// 6/6/2022 rafik :
// mysql> alter table  c0pag.afield_group change fgroup_name_ar fgroup_name_ar varchar(64);
// mysql> alter table  c0pag.afield_group change fgroup_name_en fgroup_name_en varchar(64);

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AfieldGroup extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		
		"atable_id" => array("IMPORTANT" => "IN", "SEARCH" => false, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => true, "SIZE" => 40, "UTF8" => false, "TYPE" => "FK", "ANSWER" => atable, "ANSMODULE" => pag, "DEFAULT" => 0),
		"fgcode" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 16, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "TEXT"),
		"fgroup_num" => array("IMPORTANT" => "IN", "SEARCH" => false, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 32, "UTF8" => false, "TYPE" => "INT"),
		"fgroup_name_ar" => array("IMPORTANT" => "IN", "SEARCH" => false, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 32, "UTF8" => true, "TYPE" => "TEXT"),
		"fgroup_name_en" => array("IMPORTANT" => "IN", "SEARCH" => false, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 32, "UTF8" => true, "TYPE" => "TEXT"),
		"help_text" => array("IMPORTANT" => "IN", "SEARCH" => false, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 80, "UTF8" => true, "TYPE" => "TEXT"),
		"help_text_en" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 80, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),
                afieldList => array(TYPE => FK, ANSWER => afield, ANSMODULE => pag, CATEGORY => ITEMS, ITEM => 'afield_group_id', WHERE=>'', SHOW => true, FORMAT=>retrieve, EDIT => false, ICONS=>true, 'DELETE-ICON'=>false, BUTTONS=>true, "NO-LABEL"=>true),

                id_aut => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                date_aut => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                id_mod => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                date_mod => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                id_valid => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                date_valid => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                avail => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "TYPE" => "YN"),
                version => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
                update_groups_mfk => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                delete_groups_mfk => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                display_groups_mfk => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                sci_id => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "scenario_item", "ANSMODULE" => "pag"),
                tech_notes 	    => array(TYPE => TEXT, CATEGORY => FORMULA, "SHOW-ADMIN" => true, 'STEP' =>"all", TOKEN_SEP=>"§", READONLY=>true, "NO-ERROR-CHECK"=>true),
	);
	
	*/ public function __construct(){
		parent::__construct("afield_group","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "fgroup_name_ar";
                $this->ORDER_BY_FIELDS = "atable_id, fgcode";
                 
                
                $this->UNIQUE_KEY = array('atable_id','fgcode');
                
	}
        
        public static function loadById($id)
        {
           $obj = new AfieldGroup();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($atable_id, $fgcode,$create_obj_if_not_found=false)
        {
           $obj = new AfieldGroup();
           $obj->select("atable_id",$atable_id);
           $obj->select("fgcode",$fgcode);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("atable_id",$atable_id);
                $obj->set("fgcode",$fgcode);

                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               if($this->getVal("fgroup_name_$lang")) return $this->getVal("fgroup_name_$lang");
               $data = array();
               $link = array();
               

               list($data[0],$link[0]) = $this->displayAttribute("atable_id",false, $lang);
               list($data[1],$link[1]) = $this->displayAttribute("fgcode",false, $lang);

               
               return implode(" - ",$data);
        }
        
        
        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             global $lang;
             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             if($mode=="mode_afieldList")
             {
                   unset($link);
                   $my_id = $this->getId();
                   $link = array();
                   $title = "إدارة حقول البيانات ";
                   $title_detailed = $title ."لـ : ". $displ;
                   $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&id_origin=$my_id&class_origin=AfieldGroup&module_origin=pag&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=afield_group_id=$my_id&sel_afield_group_id=$my_id";
                   $link["TITLE"] = $title;
                   $link["UGROUPS"] = array();
                   $otherLinksArray[] = $link;
             }
             
             
             
             return $otherLinksArray;
        }
        
        public function getRAMObjectData()
        {
                  $category_id = 10;

                  $type_id = 533;
                  
                  $code = $this->getVal("fgcode");
                  $name_ar = $this->getVal("fgroup_name_ar");
                  $name_en = $this->getVal("fgroup_name_en");
                  $specification = $this->getVal("help_text");
                  
                  $childs = array();
                  $childs[8] =  $this->get("afieldList");
                  
                  
                  return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
        
        } 
             
}
?>