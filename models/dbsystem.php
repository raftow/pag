<?php


class Dbsystem extends AFWObject{

	public static $DATABASE		= ""; 
	public static $MODULE		    = "pag"; 
	public static $TABLE			= "dbsystem"; 
	public static $DB_STRUCTURE = null; 

	private static $syn_list = null;
	
	public function __construct()
	{
		parent::__construct("dbsystem","id","pag");
        $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
		$this->DISPLAY_FIELD = "dbsystem_name";
	}

	public static function loadById($id)
	{
		$obj = new Dbsystem();
		$obj->select_visibilite_horizontale();
		if($obj->load($id))
		{
			return $obj;
		}
		else return null;
	}
        
        public function loadSyntax()
        {
           if(!self::$syn_list) self::$syn_list = $this->get("syn");
           
           $syn_arr = array();
           
           foreach(self::$syn_list as $syn_id => $syn_item)
           {
               $syn_arr[$syn_item->getVal("code_syntax")] =  $syn_item->getVal("value_syntax");
           }
           
           return $syn_arr;
        
        }
}
?>