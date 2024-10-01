<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table tboption : tboption - خيارات الجداول 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class SeveralOption extends AFWObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "pag"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null; 
        
        public function __construct(){
		parent::__construct("several_option","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "option_name_ar";
                $this->ORDER_BY_FIELDS = "option_name_ar";
                
                
	}
}
?>