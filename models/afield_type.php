<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table afield_type : afield_type - أنواع الحقول 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AfieldType extends AFWObject{

        public static $MY_ATABLE_ID=422; 
        // إدارة أنواع الحقول 
        public static $BF_QEDIT_AFIELD_TYPE = 103292; 
        // عرض تفاصيل نوع الحقل 
        public static $BF_DISPLAY_AFIELD_TYPE = 103294; 
        // مسح نوع الحقل 
        public static $BF_DELETE_AFIELD_TYPE = 103293; 


 // lookup Value List codes 
        // AMNT - مبلغ من المال  
        public static $AFIELD_TYPE_AMNT = 3; 

        // BIGINT - قيمة عددية كبيرة  
        public static $AFIELD_TYPE_BIGINT = 14; 

        // DATE - تاريخ  
        public static $AFIELD_TYPE_DATE = 2; 

        // ENUM - إختيار من قائمة قصيرة  
        public static $AFIELD_TYPE_ENUM = 12; 

        // FLOAT - قيمة عددية كسرية  
        public static $AFIELD_TYPE_FLOAT = 16; 

        // GDAT - تاريخ نصراني  
        public static $AFIELD_TYPE_GDAT = 9; 

        // ITEMS - قائمة تفاصيل  
        public static $AFIELD_TYPE_ITEMS = 17; 

        // LIST - اختيار من قائمة  
        public static $AFIELD_TYPE_LIST = 5; 

        // MENUM - إختيار متعدد من قائمة قصيرة  
        public static $AFIELD_TYPE_MENUM = 15; 

        // MLST - اختيار متعدد من قائمة  
        public static $AFIELD_TYPE_MLST = 6; 

        // MTXT - نص طويل  
        public static $AFIELD_TYPE_MTXT = 11; 

        // NMBR - قيمة عددية متوسطة  
        public static $AFIELD_TYPE_NMBR = 1; 

        // PCTG - نسبة مائوية  
        public static $AFIELD_TYPE_PCTG = 7; 

        // SMALLINT - قيمة عددية صغيرة  
        public static $AFIELD_TYPE_SMALLINT = 13; 

        // TEXT - نص قصير  
        public static $AFIELD_TYPE_TEXT = 10; 

        // TIME - وقت  
        public static $AFIELD_TYPE_TIME = 4; 

        // YN - نعم/لا  
        public static $AFIELD_TYPE_YN = 8; 


        
	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array(SHOW => true, RETRIEVE => true, EDIT => true, TYPE => PK),

		
		'titre' => array(SEARCH => false,  QSEARCH => false,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => false,  
				SIZE => 255,  "MIN-SIZE" => 3,  CHAR_TEMPLATE => "ARABIC-CHARS,SPACE",  MANDATORY => false,  UTF8 => true,  
				TYPE => "TEXT",  READONLY => false, ),

		titre_short => array(SEARCH => false,  QSEARCH => false,  SHOW => true,  RETRIEVE => false,  
				EDIT => true,  QEDIT => true,  
				SIZE => 40,  "MIN-SIZE" => 5,  CHAR_TEMPLATE => "ARABIC-CHARS,SPACE",  MANDATORY => true,  UTF8 => true,  SHORTNAME => "title",  
				TYPE => "TEXT",  READONLY => false, ),

		afield_type_code => array(SEARCH => false,  QSEARCH => false,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 16,  "MIN-SIZE" => 2,  CHAR_TEMPLATE => "ALPHABETIC,NUMERIC,UNDERSCORE",  MANDATORY => true,  UTF8 => false,  
				TYPE => "TEXT",  READONLY => false, SHORTNAME=>lookup_code, ),

		sql_field_type => array(SEARCH => false,  QSEARCH => false,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 20,  MANDATORY => true,  UTF8 => false,  
				TYPE => "TEXT",  READONLY => false, ),

		oracle_field_type => array(SEARCH => true,  QSEARCH => true,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 32,  MANDATORY => false,  UTF8 => false,  
				TYPE => "TEXT",  READONLY => false, ),

		is_numeric => array(SEARCH => false,  QSEARCH => false,  SHOW => true,  RETRIEVE => true,  
				EDIT => true,  QEDIT => true,  
				SIZE => 32,  MANDATORY => false,  UTF8 => false,  
				TYPE => "YN",  READONLY => false, ),

                mask => array(SHOW => true,  RETRIEVE => true, SIZE => 32,  UTF8 => false, TYPE => "TEXT", CATEGORY => FORMULA ),                                

                foptionList => array(TYPE => FK, ANSWER => foption, ANSMODULE => pag, CATEGORY => ITEMS, ITEM => 'data_type_id', WHERE=>'', 
                                        SHOW => true, FORMAT=>retrieve, QEDIT => false, EDIT => false, READONLY=> true, ICONS=>true, 'DELETE-ICON'=>true, BUTTONS=>true, "NO-LABEL"=>false),

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
		parent::__construct("afield_type","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "titre_short";
                $this->ORDER_BY_FIELDS = "titre_short";
                
                // contain many business rules and could be loaded one by one so not lookup
                $this->IS_LOOKUP = false;  // @KEEP-PLEASE
                
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array('afield_type_code');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
	}
        
        public static function loadById($id)
        {
           $obj = new AfieldType();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           $obj = new AfieldType();
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


        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             global $lang;
             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);;
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             if($mode=="mode_foptionList")
             {
                   unset($link);
                   $my_id = $this->getId();
                   $link = array();
                   $title = "إدارة خيارات الحقول ";
                   $title_detailed = $title ."لـ : ". $displ;
                   $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Foption&currmod=pag&id_origin=$my_id&class_origin=AfieldType&module_origin=pag&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=data_type_id=$my_id&sel_data_type_id=$my_id";
                   $link["TITLE"] = $title;
                   $link["UGROUPS"] = array();
                   $otherLinksArray[] = $link;
             }
             
             
             
             return $otherLinksArray;
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
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 

                        
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 
                       // pag.foption-نوع القيمة	data_type_id  أنا تفاصيل لها-OneToMany
                        $this->execQuery("delete from ${server_db_prefix}pag.foption where data_type_id = '$id' ");

                   
                   // FK not part of me - replaceable 
                       // pag.afield-نوع الحقل	afield_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}pag.afield set afield_type_id='$id_replace' where afield_type_id='$id' ");
                       // mcc.publication_field-نوع الحقل	field_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}mcc.publication_field set field_type_id='$id_replace' where field_type_id='$id' ");
                       // sms.c_system-نوع الحقل 1	field1_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field1_type='$id_replace' where field1_type='$id' ");
                       // sms.c_system-نوع الحقل 2	field2_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field2_type='$id_replace' where field2_type='$id' ");
                       // sms.c_system-نوع الحقل 3	field3_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field3_type='$id_replace' where field3_type='$id' ");
                       // sms.c_system-نوع الحقل 4	field4_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field4_type='$id_replace' where field4_type='$id' ");
                       // sms.c_system-نوع الحقل 5	field5_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field5_type='$id_replace' where field5_type='$id' ");
                       // sms.c_system-نوع الحقل 6	field6_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field6_type='$id_replace' where field6_type='$id' ");
                       // sms.c_system-نوع الحقل 7	field7_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field7_type='$id_replace' where field7_type='$id' ");
                       // sms.c_system-نوع الحقل 8	field8_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field8_type='$id_replace' where field8_type='$id' ");
                       // sms.c_system-نوع الحقل 9	field9_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field9_type='$id_replace' where field9_type='$id' ");

                        
                   
                   // MFK
                       // pag.foption-أنواع الحقول	afield_type_mfk  
                        $this->execQuery("update ${server_db_prefix}pag.foption set afield_type_mfk=REPLACE(afield_type_mfk, ',$id,', ',') where afield_type_mfk like '%,$id,%' ");
                       // pag.foption_case-أنواع الحقول	afield_type_mfk  
                        $this->execQuery("update ${server_db_prefix}pag.foption_case set afield_type_mfk=REPLACE(afield_type_mfk, ',$id,', ',') where afield_type_mfk like '%,$id,%' ");

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 
                       // pag.foption-نوع القيمة	data_type_id  أنا تفاصيل لها-OneToMany
                        $this->execQuery("update ${server_db_prefix}pag.foption set data_type_id='$id_replace' where data_type_id='$id' ");
                       // pag.afield-نوع الحقل	afield_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}pag.afield set afield_type_id='$id_replace' where afield_type_id='$id' ");
                       // mcc.publication_field-نوع الحقل	field_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}mcc.publication_field set field_type_id='$id_replace' where field_type_id='$id' ");
                       // sms.c_system-نوع الحقل 1	field1_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field1_type='$id_replace' where field1_type='$id' ");
                       // sms.c_system-نوع الحقل 2	field2_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field2_type='$id_replace' where field2_type='$id' ");
                       // sms.c_system-نوع الحقل 3	field3_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field3_type='$id_replace' where field3_type='$id' ");
                       // sms.c_system-نوع الحقل 4	field4_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field4_type='$id_replace' where field4_type='$id' ");
                       // sms.c_system-نوع الحقل 5	field5_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field5_type='$id_replace' where field5_type='$id' ");
                       // sms.c_system-نوع الحقل 6	field6_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field6_type='$id_replace' where field6_type='$id' ");
                       // sms.c_system-نوع الحقل 7	field7_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field7_type='$id_replace' where field7_type='$id' ");
                       // sms.c_system-نوع الحقل 8	field8_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field8_type='$id_replace' where field8_type='$id' ");
                       // sms.c_system-نوع الحقل 9	field9_type  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}sms.c_system set field9_type='$id_replace' where field9_type='$id' ");

                        
                        // MFK
                       // pag.foption-أنواع الحقول	afield_type_mfk  
                        $this->execQuery("update ${server_db_prefix}pag.foption set afield_type_mfk=REPLACE(afield_type_mfk, ',$id,', ',$id_replace,') where afield_type_mfk like '%,$id,%' ");
                       // pag.foption_case-أنواع الحقول	afield_type_mfk  
                        $this->execQuery("update ${server_db_prefix}pag.foption_case set afield_type_mfk=REPLACE(afield_type_mfk, ',$id,', ',$id_replace,') where afield_type_mfk like '%,$id,%' ");

                   
               } 
               return true;
            }    
	}
        
        public function getAfwType(){
        
        
		if($this->getId()==AfwUmsPagHelper::$afield_type_yn)
			return "YN";
		elseif($this->getId()==AfwUmsPagHelper::$afield_type_mtxt || $this->getId()==AfwUmsPagHelper::$afield_type_text)
			return "TEXT";
		elseif($this->getId()==AfwUmsPagHelper::$afield_type_list)
			return "FK";
		elseif($this->getId()==AfwUmsPagHelper::$afield_type_date)
			return "DATE";
                elseif($this->getId()==AfwUmsPagHelper::$afield_type_Gdat)
			return "GDAT";        
		elseif($this->getId()==AfwUmsPagHelper::$afield_type_int)
			return "INT";
		elseif($this->getId()==AfwUmsPagHelper::$afield_type_bigint)
			return "INT";
		elseif($this->getId()==AfwUmsPagHelper::$afield_type_nmbr)
			return "INT";
                elseif($this->getId()==AfwUmsPagHelper::$afield_type_enum)
			return "ENUM";
                elseif($this->getId()==AfwUmsPagHelper::$afield_type_enum)
			return "ENUM";
                elseif($this->getId()==AfwUmsPagHelper::$afield_type_menum)
			return "MENUM";
                elseif($this->getId()==AfwUmsPagHelper::$afield_type_pctg)
			return "PCTG";
                elseif($this->getId()==AfwUmsPagHelper::$afield_type_time)
			return "TIME";
                elseif($this->getId()==AfwUmsPagHelper::$afield_type_float)                
			return "FLOAT";
		else{ 
			return "UNKNOWN AFW TYPE for type : ".$this." id = ".$this->getId();
		}
	}
        
        public function isToDecode(){
          // to decode these types "MFK", "FK", "ANSWER","YN","ENUM","MENUM"
        
             return  (($this->getId()==AfwUmsPagHelper::$afield_type_mlst) or 
                      ($this->getId()==AfwUmsPagHelper::$afield_type_list) or
                      ($this->getId()==AfwUmsPagHelper::$afield_type_enum) or
                      ($this->getId()==AfwUmsPagHelper::$afield_type_menum) or
                      ($this->getId()==AfwUmsPagHelper::$afield_type_yn)); 
        }
        
        public function isText(){
             return  (($this->getId()==AfwUmsPagHelper::$afield_type_mtxt) or 
                      ($this->getId()==AfwUmsPagHelper::$afield_type_text)); 
        }


        public function calcMask()
        {
                if($this->getId()==AfwUmsPagHelper::$afield_type_Gdat) return "Gregorian YYYY-MM-DD  تاريخ نصراني";
                if($this->getId()==AfwUmsPagHelper::$afield_type_date) return "hijri YYYYmmDD  تاريخ هجري";
                if($this->getId()==AfwUmsPagHelper::$afield_type_yn)   return "Y/N   تعني نعم/لا";
                
                
                return "--";
        }
             
}
?>