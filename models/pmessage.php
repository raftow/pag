<?php


class Pmessage extends AFWObject{

        public static $COMPTAGE_BEFORE_LOAD_MANY = true;

	public static $DATABASE		= ""; 
	public static $MODULE		    = "pag"; 
	public static $TABLE			= "pmessage"; 
	public static $DB_STRUCTURE = null; 
	
	
        
    public $details = array();
        
	public function __construct(){
		parent::__construct($tablename="pmessage","id","pag");
                $this->DISPLAY_FIELD = "message_ar";
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 20;
                $this->copypast = true;
	}

        
        
    public function getOrderByFields($join = true)
	{
		return "stakeholder_id,module_id,atable_id,pmessage_type_id,message_ar";
	}
}
?>