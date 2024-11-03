<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table foption : foption - خيارات الحقول 
// ------------------------------------------------------------------------------------
// 6/7/2021 :
// ALTER TABLE `foption` CHANGE `foption_desc_en` `foption_desc_en` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL; 
// ALTER TABLE `foption` CHANGE `afield_type_mfk` `afield_type_mfk` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ','; 
// ALTER TABLE `foption` CHANGE `foption_type` `foption_type` SMALLINT(6) NOT NULL DEFAULT '1'; 
                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Foption extends AFWObject{
        
        
        // lookup Value List codes 
        // EXP - خيارات الاستيراد  
        public static $FOPTION_TYPE_EXP = 2; 
 
        // HZM - خيارات الكود لإطار العمل  
        public static $FOPTION_TYPE_HZM = 1; 
        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "pag"; 
        public static $TABLE			= "foption"; 
        public static $DB_STRUCTURE = null; 
        
        
        public function __construct(){
		parent::__construct("foption","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "foption_name_ar";
                $this->ORDER_BY_FIELDS = "foption_name_ar desc";
                $this->UNIQUE_KEY = array("lookup_code");
                /*
                $this-> class_inputText = "xqe_inputtext";
                $this->class_of_input_computed_readonly = "xqe_footer_sum_input ";
                $this->class_js_computed = "xqe_js_computed";
                $this->class_footer_sum_input = "xqe_footer_sum_input";                */
	}
        
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           $obj = new Foption();
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
        
        public function list_of_foption_type() { 
            $list_of_items = array(); 
            $list_of_items[2] = "خيارات الاستيراد";  //     code : EXP 
            $list_of_items[1] = "خيارات الكود لإطار العمل";  //     code : HZM 
           return  $list_of_items;
        }
        
        
        public function isHzm()
        {
            return ($this->getVal("foption_type")==self::$FOPTION_TYPE_HZM);
        }
        
        public function getDisplay($lang="ar")
        {
               //if(trim($this->getVal("foption_name_$lang"))) return trim($this->getVal("foption_name_$lang"));
               $data = array();

               $data[] = trim($this->getVal("foption_name_$lang"));
               $data[] = $this->getVal("lookup_code");
               $data[] = $this->showAttribute("data_type_id");
               
 
 
 
 
               return implode("-",$data);
        }
 
 
 
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             global $lang;
             $otherLinksArray = array();
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
 
             if($mode=="mode_foptionCaseList")
             {
                   unset($link);
                   $my_id = $this->getId();
                   $link = array();
                   $title = "إدارة حالات خيارات الحقول ";
                   $title_detailed = $title ."لـ : ". $displ;
                   $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=FoptionCase&currmod=pag&id_origin=$my_id&class_origin=Foption&module_origin=pag&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=foption_id=$my_id&sel_foption_id=$my_id";
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
 
 
        public function beforeDelete($id,$id_replace) 
        {
            
 
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 
 
 
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 
                       // pag.foption_case-خيار الحقل	foption_id  أنا تفاصيل لها-OneToMany
                        $this->execQuery("delete from ${server_db_prefix}pag.foption_case where foption_id = '$id' ");
 
 
                   // FK not part of me - replaceable 
 
 
 
                   // MFK
                       // pag.afield-الخيارات المتقدمة	foption_mfk  
                        $this->execQuery("update ${server_db_prefix}pag.afield set foption_mfk=REPLACE(foption_mfk, ',$id,', ',') where foption_mfk like '%,$id,%' ");
 
               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 
                       // pag.foption_case-خيار الحقل	foption_id  أنا تفاصيل لها-OneToMany
                        $this->execQuery("update ${server_db_prefix}pag.foption_case set foption_id='$id_replace' where foption_id='$id' ");
 
 
                        // MFK
                       // pag.afield-الخيارات المتقدمة	foption_mfk  
                        $this->execQuery("update ${server_db_prefix}pag.afield set foption_mfk=REPLACE(foption_mfk, ',$id,', ',$id_replace,') where foption_mfk like '%,$id,%' ");
 
 
               } 
               return true;
            }    
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
            return (($attribute=="id_aut") or ($attribute=="date_aut") or ($attribute=="id_mod") or ($attribute=="date_mod") 
                      or ($attribute=="id_valid") or ($attribute=="date_valid") or ($attribute=="version"));  
        } 
}
?>