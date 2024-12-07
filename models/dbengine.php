<?php


class Dbengine extends AFWObject{

	public static $DATABASE		= ""; 
	public static $MODULE		    = "pag"; 
	public static $TABLE			= "dbengine"; 
	public static $DB_STRUCTURE = null; 
	
	public function __construct(){
		parent::__construct("dbengine","id","pag");
		$this->DISPLAY_FIELD = "dbengine_name";
	}

	public static function loadById($id)
	{
		$obj = new Dbengine();
		$obj->select_visibilite_horizontale();
		if($obj->load($id))
		{
			return $obj;
		}
		else return null;
	}
}
?>