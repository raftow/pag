<?php


class DocType extends AFWObject{
        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "pag"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null; 
        /* = array(
		"id" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),
		
                lookup_code => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true, SHORTNAME=>code),
                
		"titre_short" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "TEXT", "UTF8"=>true, SIZE => 64, ),
                "titre" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "TEXT", "UTF8"=>true, SIZE => 196),
                 
                 valid_ext => array(SEARCH => true,  QSEARCH => true,  SHOW => true,  RETRIEVE => false,  
				EDIT => true,  QEDIT => true,  
				SHORT_SIZE => 120, SIZE => 255,  "MIN-SIZE" => 2,  CHAR_TEMPLATE => "",  MANDATORY => true,  UTF8 => true,  
				TYPE => "TEXT",  READONLY => false, ),
                 
                 extentions => array(STEP => 5, SIZE => 255,  SHOW=> false, RETRIEVE => true, CATEGORY => FORMULA, TYPE => TEXT, ),
                 
		"avail" => array(SHOW => true, RETRIEVE => true, EDIT => true,  QEDIT => true, "TYPE" => "YN", "DEFAULT" => "Y"),

                "id_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
		"date_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
		"date_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
		"date_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"version" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "scenario_item"),
	);*/
	
	public function __construct($tablename="doc_type"){
		parent::__construct($tablename,"id","pag");
                $this->public_display = true;
	}
         
        public static function loadAll($ids="", $order_by="")
        {
           $obj = new DocType();
           $obj->select_visibilite_horizontale();
           if($ids) $obj->where("id in ($ids)");
           return $obj->loadMany($limit = "", $order_by);
        }
        
        public static function loadById($id)
        {
           $obj = new DocType();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public function getDisplay($lang="ar")
        {
               return $this->getVal("titre_short");
        }
        
        public static function getExentionsAllowed($ids, $upper=true)
        {
              $dt = new DocType();
              $cond = "avail='Y' and id in ($ids)";
              $dt->where($cond);
              
              $dtList = $dt->loadMany();
              
              $ft_arr = array();
              $ft_used = array();
              $ext_arr = array();
              $ext_used = array();
              
              foreach($dtList as $dtItem)
              {
                  $valid_ext = $dtItem->getVal("valid_ext");
                  $valid_ext_arr = explode(",", $valid_ext);
                  foreach($valid_ext_arr as $valid_ext_item)
                  {
                      if($upper) $valid_ext_item = trim(strtoupper($valid_ext_item));
                      else $valid_ext_item = trim(strtolower($valid_ext_item));
                      
                      if(!$ext_used[$valid_ext_item])
                      {
                         $ext_used[$valid_ext_item] = true;
                         $ext_arr[] = $valid_ext_item; 
                      }
                  }
                  $valid_ft = $dtItem->getDisplay();
                  if(!$ft_used[$valid_ft])
                  {
                       $ft_used[$valid_ft] = true;
                       $ft_arr[] = $valid_ft; 
                  }
              }
              //$ext_arr[] = $cond;
              return array($ext_arr, $ft_arr);
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
 
 
        protected function beforeDelete($id,$id_replace) 
        {
            
 
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); 
                   // FK part of me - not deletable 
 
 
                   // FK part of me - deletable 
 
 
                   // FK not part of me - replaceable 
                       // pag.afile-نوع المستند	doc_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}pag.afile set doc_type_id='$id_replace' where doc_type_id='$id' ");
 
 
 
                   // MFK
                       // mcc.content_type-أنواع المستندات	doc_type_mfk  
                        $this->execQuery("update ${server_db_prefix}mcc.content_type set doc_type_mfk=REPLACE(doc_type_mfk, ',$id,', ',') where doc_type_mfk like '%,$id,%' ");
 
               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","c0"); 
                        // FK on me 
                       // pag.afile-نوع المستند	doc_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}pag.afile set doc_type_id='$id_replace' where doc_type_id='$id' ");
 
 
                        // MFK
                       // mcc.content_type-أنواع المستندات	doc_type_mfk  
                        $this->execQuery("update ${server_db_prefix}mcc.content_type set doc_type_mfk=REPLACE(doc_type_mfk, ',$id,', ',$id_replace,') where doc_type_mfk like '%,$id,%' ");
 
 
               } 
               return true;
            }    
	}
        
        public function calcExtentions()
        {
             $ext = $this->getVal("valid_ext");
             $ext = strtoupper(str_replace(",", " / ", $ext));
             return $ext;
        }    
}
?>