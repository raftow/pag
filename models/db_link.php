<?php


class DbLink extends AFWObject{

	public static $DATABASE		= ""; 
     public static $MODULE		    = "pag"; 
     public static $TABLE			= "db_link"; 
     public static $DB_STRUCTURE = null; 
     
     
     public function __construct(){
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
                        // list($bfsol,$isnew) = Bfunction::getB(0, "pag", $bfsol_file_name, $module_code, $at_id, "", $operationLabel, 'N', 'N', 10, "web-serv-lkup-$module_code-$atable_name",0,0,"get bfsol_id formula value of $this");
                        $bfsol = null;
                        return $bfsol;
                    break;   
               }
               
        }         
}
        
        
        
?>