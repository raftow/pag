<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table entity_relation_type : entity_relation_type - أنواع العلاقات بين الكيانات 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class EntityRelationType extends AFWObject{

        public static $OneToMany = 1;
        public static $ManyToOne = 2;
        public static $OneToOneBidirectional = 4;
        public static $OneToOneUnidirectional = 5;
        public static $EntityRelationTypeUnknown = 3;
        
        public static $MY_ATABLE_ID=3479; 
        // إدارة أنواع العلاقات بين الكيانات 
        public static $BF_QEDIT_ENTITY_RELATION_TYPE = 103295; 
        // عرض تفاصيل نوع علاقة بين كيانين 
        public static $BF_DISPLAY_ENTITY_RELATION_TYPE = 103297; 
        // مسح نوع علاقة بين كيانين 
        public static $BF_DELETE_ENTITY_RELATION_TYPE = 103296; 
 
 
	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                "id" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		"name_ar" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 128, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),
		"name_en" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 128, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "TEXT"),
                "lookup_code" => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true),
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
		parent::__construct("entity_relation_type","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                
                $this->ORDER_BY_FIELDS = "name_ar";
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array("lookup_code");
	}
        
        public function getDisplay($lang="ar")
        {
             return $this->getVal("name_$lang")."-".$this->vallookup_code();
        }
        
        public function isOneToMany()
        {
            return ($this->getId()==self::$OneToMany);
        }

        public function isManyToOne()
        {
            return ($this->getId()==self::$ManyToOne);
        }
        
        public function isOneToOneUnidirectional()
        {
            return ($this->getId()==self::$OneToOneUnidirectional);
        }
        
        public function isOneToOneBidirectional()
        {
            return ($this->getId()==self::$OneToOneBidirectional);
        }
        
        
}
?>  