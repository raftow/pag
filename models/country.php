<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table country : country - البلدان 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Country extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                "id" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		"country_name_ar" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 50, "UTF8" => true, "TYPE" => "TEXT"),
                "country_name_en" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 50, "UTF8" => false, "TYPE" => "TEXT"),
		"abrev" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 3, "UTF8" => false, "TYPE" => "TEXT"),
                "lookup_code" => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true),
		// "date_system_id" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 40, "UTF8" => false, "TYPE" => "FK", "ANSWER" => date_system, "ANSMODULE" => pag, "DEFAULT" => 0),
		// "time_offset" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, "UTF8" => false, "TYPE" => "INT"),
		// "maintenance_start_time" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 32, "UTF8" => false, "TYPE" => "TIME"),
		// "maintenance_end_time" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 32, "UTF8" => false, "TYPE" => "TIME"),
		"nationalty_name_ar" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 48, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),
		"nationalty_name_en" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 48, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),
		// "sa_idn_type_mfk" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => false, "SIZE" => 32, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "MFK", "ANSWER" => idn_type, "ANSMODULE" => pag),
		// "we_days_mfk" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "TEXT", "ANSWER" => wday, "ANSMODULE" => pag),

                "id_aut" 	=> array("TYPE" => "FK", 	"ANSWER" => "auser", "CATEGORY" => "", "SHOW-ADMIN" => true, "ROLES"=>"6", "ANSMODULE" => "ums"), 
		"date_aut" 	=> array("TYPE" => "DATE", 		"CATEGORY" => "", "SHOW-ADMIN" => true, "ROLES"=>"6"), 
		"id_mod"        => array("TYPE" => "FK", "ANSWER" => "auser", "SHOW-ADMIN" => true, "ANSMODULE" => "ums"),
		"date_mod"      => array("TYPE" => "DATE", "SHOW-ADMIN" => true),
		"id_valid"      => array("TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
		"date_valid"     => array("TYPE" => "DATE"),
                "avail" 	=> array("TYPE" => "YN", 		"CATEGORY" => "", "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "ROLES"=>"", "DEFAULT"=>"Y"), 
                "version" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT", "DEFAULT" => 0),
		"update_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "TYPE" => "MFK", "ANSMODULE" => "ums"),
		"delete_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "TYPE" => "MFK", "ANSMODULE" => "ums"),
		"display_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "TYPE" => "MFK", "ANSMODULE" => "ums"),
		"sci_id" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "scenario_item", "ANSMODULE" => "pag"),
	);
	
	*/ public function __construct(){
		parent::__construct("country","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "country_name_ar";
                $this->ORDER_BY_FIELDS = "country_name_ar, nationalty_name_ar";
                
                $this->enableOtherSearch = true;
                $this->IS_LOOKUP = true; 
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array('lookup_code');
                $this->public_display = true;
	}
        
        public static function loadById($id)
        {
           $obj = new Country();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
 
        public static function loadAll()
        {
           $obj = new Country();
           $obj->select("avail",'Y');
 
           $objList = $obj->loadMany();
 
           return $objList;
        }
 
 
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           $obj = new Country();
           if(!$lookup_code) throw new RuntimeException("loadByMainIndex : lookup_code is mandatory field");
 
 
           $obj->select("lookup_code",$lookup_code);
 
           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("lookup_code",$lookup_code);
 
                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
 
        }

        public static function findCountryIdFromListOfNames($country_name_arr, $activate_if_found=false)
        {
                $obj = new Country();
                $where_arr = [];
                foreach($country_name_arr as $country_name)
                {
                        $where_arr[] = "country_name_ar = _utf8'$country_name'";
                        $where_arr[] = "nationalty_name_ar = _utf8'$country_name'";
                }
                
                $where_imploded = "(".implode(" or ", $where_arr).")";
                $obj->where($where_imploded);           

                if($obj->load())
                {
                        if($activate_if_found) $obj->activate();
                        $return = $obj->id;
                        unset($obj);
                        return $return;
                }


                return 0;
        }

        public static function getCountryIdFromName($string)
        {
                global $COUNTRY_ARR;
                if (!$COUNTRY_ARR) $COUNTRY_ARR = array();
                
                if ($COUNTRY_ARR[$string]) {
                        $obj_id = $COUNTRY_ARR[$string];
                        $obj_new = false;
                } else {
                        $obj = Country::loadByNameOrNationality($string, "ar");
                        if (!$obj) $obj_id = 0;
                        else $obj_id = $obj->id;
                        unset($obj);
                }

                if(!$obj_id)
                {
                        // search for similar arabic words
                        $string_arr = AfwStringHelper::similarArabicWords($string);
                        $obj_id = Country::findCountryIdFromListOfNames($string_arr);
                }
                else
                {
                        $string_arr = [];
                        $string_arr[] = $string;
                }
                
                if($obj_id)
                {
                        $COUNTRY_ARR[$string] = $obj_id;                        
                }
                
                return array($obj_id, $string_arr);
        }

        public static function loadByNameOrNationality($name,$lang="ar")
        {
           $obj = new Country();
           $name = trim($name);
           if(!$name) throw new RuntimeException("loadByNameOrNationality : name is mandatory attribute");
 
           if($name == 'ابناء') $name = 'بدون'; 
           if($name == 'بلوشي') $name = 'بدون'; 
           

           if($lang=="ar") $x_utf8 = "_utf8"; else $x_utf8 = "";
           $obj->where("country_name_$lang = $x_utf8'$name' or nationalty_name_$lang = $x_utf8'$name'");
 
           if($obj->load())
           {
                return $obj;
           }
           else return null; 
        }
        
        public function getDisplay($lang="ar")
        {
               if($this->getVal("country_name_$lang")) return $this->getVal("country_name_$lang");
               else return $this->getVal("nationalty_name_$lang");
        }
        
        
        protected function hideDisactiveRowsFor($auser)
        {
              return false;  
        }
        
        
        protected function getPublicMethods()
        {
 
            $pbms = array();
 
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            //$pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
 
 
 
            return $pbms;
        }
 
 
        protected function beforeDelete($id,$id_replace) 
        {
            
 
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK part of me - not deletable 
 
 
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK part of me - deletable 
 
 
                   // FK not part of me - replaceable 
                       // pag.city-البلد	country_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}pag.city set country_id='$id_replace' where country_id='$id' ");
                       // pag.idn_type-البلد	country_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}pag.idn_type set country_id='$id_replace' where country_id='$id' ");
                       // ums.auser-البلد (الدولة)	country_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}ums.auser set country_id='$id_replace' where country_id='$id' ");

                       // sdd.sempl-الجنسية	country_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sdd.sempl set country_id='$id_replace' where country_id='$id' ");
 
 
 
                   // MFK
 
               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK on me 
                       // pag.city-البلد	country_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}pag.city set country_id='$id_replace' where country_id='$id' ");
                       // pag.idn_type-البلد	country_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}pag.idn_type set country_id='$id_replace' where country_id='$id' ");
                       // ums.auser-البلد (الدولة)	country_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}ums.auser set country_id='$id_replace' where country_id='$id' ");

                       // sdd.sempl-الجنسية	country_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sdd.sempl set country_id='$id_replace' where country_id='$id' ");
 
 
                        // MFK
 
 
               } 
               return true;
            }    
	}
        
        public function fld_CREATION_USER_ID()
        {
                return  "id_aut";
        }

        public function fld_CREATION_DATE()
        {
                return  "date_aut";
        }

        public function fld_UPDATE_USER_ID()
        {
                return  "id_mod";
        }

        public function fld_UPDATE_DATE()
        {
                return  "date_mod";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
                return  "id_valid";
        }

        public function fld_VALIDATION_DATE()
        {
                return  "date_valid";
        }
        
        public function fld_VERSION()
        {
                return  "version";
        }

        public function fld_ACTIVE()
        {
                return  "avail";
        }
}
?>