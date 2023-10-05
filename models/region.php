<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table region : region - المناطق 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Region extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                "id" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		"region_name" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 48, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),
                "lookup_code" => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true),
                
                "id_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                "id_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                "id_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                "avail" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "TYPE" => "YN"),
                "version" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
                "update_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                "delete_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                "display_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                "sci_id" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "scenario_item", "ANSMODULE" => "pag"),
	);
	
	*/ public function __construct(){
		parent::__construct("region","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "region_name";
                $this->ORDER_BY_FIELDS = "region_name";

                $this->UNIQUE_KEY = array('lookup_code');
                
                $this->copypast = true;
                $this->public_display = true;
	}

        public static function loadById($id)
        {
           $obj = new Region();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }

        public static function loadAll()
        {
           $obj = new Region();
           $obj->select("avail",'Y');
 
           $objList = $obj->loadMany();
 
           return $objList;
        }
        
        public static function decodeRegion($region_id,$lang)
        {
           $regObj = Region::loadById($region_id);
           if(!$regObj) return "";
           return $regObj->getDisplay($lang);
        }

        public static function findRegion($lookup_code, $region_name)
        {
           $obj = new Region();
           if(!$lookup_code) $obj->throwError("loadByMainIndex : lookup_code is mandatory field");
           if(!$region_name) $obj->throwError("loadByMainIndex : region_name is mandatory field");
           
 
           $obj->select("region_name",$region_name);     
           if($obj->load())
           {
                // die("region obj loaded with region_name=$region_name : ".var_export($obj,true));
                $obj->set("lookup_code",$lookup_code);
                
                $obj->activate();
                return $obj;
           }

           unset($obj);
           $obj = new Region();
           $obj->select("lookup_code",$lookup_code);
 
           if($obj->load())
           {
                $obj->set("region_name",$region_name);
                $obj->activate();
                return $obj;
           }
           else
           {
                $obj->set("lookup_code",$lookup_code);
                $obj->set("region_name",$region_name);
                $obj->insert();
                $obj->is_new = true;
                return $obj;
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


        protected function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","c0");
            
            if(!$id)
            {
                $id = $this->getId();
                $simul = true;
            }
            else
            {
                $simul = false;
            }
            
            if($id)
            {   
               if($id_replace==0)
               {
                   // FK part of me - not deletable 

                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 
                       // pag.city-region_id	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../pag/city.php";
                            City::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}pag.city set region_id='$id_replace' where region_id='$id' ");
                        }
                       
                       // crm.crm_customer-المنطقة	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../crm/crm_customer.php";
                            // CrmCustomer::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}crm.crm_customer set region_id='$id_replace' where region_id='$id' ");
                        }
                       // license.invester-المنطقة	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../license/invester.php";
                            Invester::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}license.invester set region_id='$id_replace' where region_id='$id' ");
                        }

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
                       // pag.city-region_id	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../pag/city.php";
                            City::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}pag.city set region_id='$id_replace' where region_id='$id' ");
                        }
                       
                       // crm.crm_customer-المنطقة	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../crm/crm_customer.php";
                            // CrmCustomer::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}crm.crm_customer set region_id='$id_replace' where region_id='$id' ");
                        }
                       
                       // license.invester-المنطقة	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../license/invester.php";
                            Invester::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}license.invester set region_id='$id_replace' where region_id='$id' ");
                        }

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
}

