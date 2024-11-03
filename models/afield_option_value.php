<?php
// ------------------------------------------------------------------------------------
// 6/6/2022 rafik :
//  alter table ".$server_db_prefix."pag.afield_option_value change option_value_comments option_value_comments text NULL;
// 
                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AfieldOptionValue extends AFWObject{

        public static $MY_ATABLE_ID=3589; 

        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "pag"; 
        public static $TABLE			= "afield_option_value"; 
        public static $DB_STRUCTURE = null; 
        
        public function __construct(){
		parent::__construct("afield_option_value","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "";
                $this->ORDER_BY_FIELDS = "afield_id, foption_id";
                 
                
                $this->UNIQUE_KEY = array('afield_id','foption_id');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
	}
        
        public static function loadById($id)
        {
           $obj = new AfieldOptionValue();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($afield_id, $foption_id,$create_obj_if_not_found=false)
        {
           $obj = new AfieldOptionValue();
           if(!$afield_id) throw new AfwRuntimeException("loadByMainIndex : afield_id is mandatory field");
           if(!$foption_id) throw new AfwRuntimeException("loadByMainIndex : foption_id is mandatory field");


           $obj->select("afield_id",$afield_id);
           $obj->select("foption_id",$foption_id);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("afield_id",$afield_id);
                $obj->set("foption_id",$foption_id);

                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               
               $data = array();
               $link = array();
               $fo = $this->het("foption_id");
               if($fo) $dis = $fo->getDisplay($lang);
               else $dis = "fo-".$this->getVal("foption_id");

               $data[0] = $this->showAttribute("afield_id",false, $lang);
               $data[1] = $dis;
               $data[2] = $this->showAttribute("option_value",false, $lang);

               
               return implode(" - ",$data);
        }
        
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            //$pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
            
            
            
            return $pbms;
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
            
            
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 

                        
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}
?>