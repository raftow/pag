<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table idn_type : idn_type - أنواع الهويات 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class IdnType extends AFWObject{

        public static $MY_ATABLE_ID=351; 
        // إدارة أنواع الهويات 
        public static $BF_QEDIT_IDN_TYPE = 103322; 
        // عرض تفاصيل نوع الهوية 
        public static $BF_DISPLAY_IDN_TYPE = 103324; 
        // مسح نوع الهوية 
        public static $BF_DELETE_IDN_TYPE = 103323; 


 // lookup Value List codes 
        // AHWAL - بطاقة أحوال  
        public static $IDN_TYPE_AHWAL = 1; 

        // IQAMA - إقامة  
        public static $IDN_TYPE_IQAMA = 2; 

        // OTHER - أخرى  
        public static $IDN_TYPE_OTHER = 99; 


        
	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array(SHOW => true, RETRIEVE => true, EDIT => true, TYPE => PK),

		
		lookup_code => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true, SHORTNAME=>code),

		idn_type_name => array(SEARCH => true,  QSEARCH => false,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 32,  MANDATORY => true,  UTF8 => true,  
				TYPE => "TEXT",  READONLY => false, ),

		country_id => array(SHORTNAME => country,  SEARCH => true,  QSEARCH => true,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 40,  MANDATORY => true,  UTF8 => false,  
				TYPE => FK,  ANSWER => country,  ANSMODULE => pag,  AUTOCOMPLETE => true,  
				RELATION => ManyToOne,  READONLY => false, ),

		idn_type_name_ar => array(SEARCH => true,  QSEARCH => false,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 48,  "MIN-SIZE" => 5,  CHAR_TEMPLATE => "ARABIC-CHARS,SPACE",  MANDATORY => true,  UTF8 => true,  
				TYPE => "TEXT",  READONLY => false, ),

		idn_type_name_en => array(SEARCH => true,  QSEARCH => false,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 48,  "MIN-SIZE" => 5,  CHAR_TEMPLATE => "ALPHABETIC,SPACE",  MANDATORY => true,  UTF8 => false,  
				TYPE => "TEXT",  READONLY => false, ),

		idn_validation_function => array(SEARCH => true,  QSEARCH => false,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 32,  MANDATORY => true,  UTF8 => true,  
				TYPE => "TEXT",  READONLY => false, ),

                
                id_aut => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_aut => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                id_mod => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_mod => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                id_valid => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => auser, ANSMODULE => ums),
                date_valid => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => DATETIME),
                avail => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => true, QEDIT => true, "DEFAULT" => 'Y', TYPE => YN),
                version => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => INT),
                update_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                delete_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                display_groups_mfk => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, ANSWER => ugroup, ANSMODULE => ums, TYPE => MFK),
                sci_id => array("SHOW-ADMIN" => true, RETRIEVE => false, EDIT => false, TYPE => FK, ANSWER => scenario_item, ANSMODULE => pag),
                tech_notes 	    => array(TYPE => TEXT, CATEGORY => FORMULA, "SHOW-ADMIN" => true, 'STEP' =>"all", TOKEN_SEP=>"§", READONLY=>true, "NO-ERROR-CHECK"=>true),
	);
	
	*/ public function __construct(){
		parent::__construct("idn_type","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "idn_type_name_ar";
                $this->ORDER_BY_FIELDS = "lookup_code";
                $this->IS_LOOKUP = true; 
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array('lookup_code');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
                $this->public_display = true;
	}
        
        public static function loadById($id)
        {
           $obj = new IdnType();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public static function loadAll()
        {
           $obj = new IdnType();
           $obj->select("active",'Y');

           $objList = $obj->loadMany();
           
           return $objList;
        }

        
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           $obj = new IdnType();
           if(!$lookup_code) throw new AfwRuntimeException("loadByMainIndex : lookup_code is mandatory field");


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


        public function getDisplay($lang="ar")
        {
               return $this->getVal("idn_type_name_$lang");
        }
        

        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            //$pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
            
            
            
            return $pbms;
        }
        
        public function fld_CREATION_USER_ID()
        {
                return "id_aut";
        }

        public function fld_CREATION_DATE()
        {
                return "date_aut";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return "id_mod";
        }

        public function fld_UPDATE_DATE()
        {
        	return "date_mod";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return "id_valid";
        }

        public function fld_VALIDATION_DATE()
        {
                return "date_valid";
        }
        
        public function fld_VERSION()
        {
        	return "version";
        }

        public function fld_ACTIVE()
        {
        	return  "avail";
        }
        
        public function isTechField($attribute) {
            return (($attribute=="id_aut") or ($attribute=="date_aut") or ($attribute=="id_mod") or ($attribute=="date_mod") or ($attribute=="id_valid") or ($attribute=="date_valid") or ($attribute=="version"));  
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
            
            
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK part of me - not deletable 

                        
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 
                       // ums.auser-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.auser set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // bmu.b_m_employee-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}bmu.b_m_employee set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // bmu.customer_account-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}bmu.customer_account set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // trn.pregistration-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}trn.pregistration set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // crm.crm_customer-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}crm.crm_customer set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // ria.student-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ria.student set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // ria.parent_user-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ria.parent_user set idn_type_id='$id_replace' where idn_type_id='$id' ");

                        
                   
                   // MFK
                       // pag.country-أنواع الهويات في السعودية	sa_idn_type_mfk  
                        $this->execQuery("update ${server_db_prefix}pag.country set sa_idn_type_mfk=REPLACE(sa_idn_type_mfk, ',$id,', ',') where sa_idn_type_mfk like '%,$id,%' ");

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK on me 
                       // ums.auser-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.auser set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // bmu.b_m_employee-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}bmu.b_m_employee set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // bmu.customer_account-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}bmu.customer_account set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // trn.pregistration-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}trn.pregistration set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // crm.crm_customer-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}crm.crm_customer set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // ria.student-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ria.student set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // ria.parent_user-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ria.parent_user set idn_type_id='$id_replace' where idn_type_id='$id' ");

                        
                        // MFK
                       // pag.country-أنواع الهويات في السعودية	sa_idn_type_mfk  
                        $this->execQuery("update ${server_db_prefix}pag.country set sa_idn_type_mfk=REPLACE(sa_idn_type_mfk, ',$id,', ',$id_replace,') where sa_idn_type_mfk like '%,$id,%' ");

                   
               } 
               return true;
            }    
	}
             
}
?>