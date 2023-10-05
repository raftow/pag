<?php


class Domain extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
		"id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "PK"),
		
                domain_code => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, 
                                      SEARCH => true,  QSEARCH => true,
                                      "TYPE" => "TEXT", "REQUIRED" => true, SIZE=>"16"),
                'application_code' => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, 
                                        SEARCH => true,  QSEARCH => true, EDIT => true, 
                                        "TYPE" => "TEXT", "REQUIRED" => true, SIZE=>"16"),

                "short_name_ar" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, 
                                          SEARCH => true,  QSEARCH => true, EDIT => true, UTF8=>true, 
                                          "TYPE" => "TEXT", "REQUIRED" => true, SIZE=>"48"),
		"short_name_en" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => false, 
                                           SEARCH => true,  QSEARCH => true, EDIT => true,  
                                           "TYPE" => "TEXT", "REQUIRED" => true, SIZE=>"48"),
                
                "domain_name_ar" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, 
                                          SEARCH => true,  QSEARCH => true, EDIT => true,  UTF8=>true, 
                                          "TYPE" => "TEXT", "REQUIRED" => true, SIZE=>"80"),
		
                "domain_name_en" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => false, 
                                          SEARCH => true,  QSEARCH => true, EDIT => true, 
                                          "TYPE" => "TEXT", "REQUIRED" => true, SIZE=>"80"),
                
                mainApplication => array(STEP => 2, TYPE => FK, ANSWER => module, ANSMODULE => ums, CATEGORY => FORMULA, 
                                          SHOW => true, EDIT => true, QEDIT => false, READONLY => true, 
                                          RELATION =>OneToOneU),
                
                jobroleList => array(STEP => 2, TYPE => FK, ANSWER => jobrole, ANSMODULE => pag, CATEGORY => ITEMS, ITEM => 'id_domain', 
                                     WHERE=>'', "MANDATORY" => true,
                                     SHOW => true, FORMAT=>retrieve, EDIT => true, QEDIT => false, READONLY => true, ICONS=>true, 'DELETE-ICON'=>true, BUTTONS=>true, "NO-LABEL"=>false),
                
                

                // jobsddList => array(TYPE => FK, ANSWER => jobsdd, ANSMODULE => sdd, CATEGORY => ITEMS, ITEM => 'id_domain', 
                //                      WHERE=>'', 
                //                     SHOW => true, FORMAT=>retrieve, EDIT => false, ICONS=>true, 'DELETE-ICON'=>true, BUTTONS=>true, "NO-LABEL"=>false),

                // moduleList => array(TYPE => FK, ANSWER => module, ANSMODULE => ums, CATEGORY => ITEMS, ITEM => 'id_pm', 
                //                      WHERE=>'id_module_type in (4,5,7)', SHOW => true, FORMAT=>retrieve, EDIT => false, ICONS=>true, 
                //                     'DELETE-ICON'=>false, BUTTONS=>true, "NO-LABEL"=>false),                     
		
                
                goalList => array(STEP => 3, TYPE => FK, ANSWER => goal, ANSMODULE => bau, CATEGORY => ITEMS, ITEM => 'domain_id', 
                                        WHERE=>'', 
                                        SHOW => true, FORMAT=>retrieve, EDIT => true, QEDIT => false, READONLY => true, ICONS=>true, 'DELETE-ICON'=>true, BUTTONS=>true, "NO-LABEL"=>false),
                
                "id_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "GDAT"),
		"id_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "GDAT"),
		"id_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "GDAT"),
		"avail" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "EDIT-ADMIN" => true, "QEDIT" => false, "TYPE" => "YN"),
		"version" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
	);
	
	*/ public function __construct(){
		parent::__construct("domain","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
                $this->DISPLAY_FIELD = "";
                $this->ORDER_BY_FIELDS = "domain_name_ar";
                $this->editByStep = true;
                $this->editNbSteps = 3;
                $this->UNIQUE_KEY = array('domain_code');
                $this->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
	}
        
        public function getDisplay($langue="ar")        
        {
            global $lang;
            if(!$langue)   $langue = $lang;
            if(!$langue)   $langue = "ar";
               $data = array();
               $link = array();
 
               list($data["ar"],$link["ar"]) = $this->displayAttribute("short_name_ar",false, $lang);
               list($data["en"],$link["en"]) = $this->displayAttribute("short_name_en",false, $lang);
 
 
               return $data[$langue];
        }
        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             global $lang;
             $objme = AfwSession::getUserConnected();
             $me = ($objme) ? $objme->id : 0;

             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             if($mode=="mode_jobroleList")
             {
                   unset($link);
                   $my_id = $this->getId();
                   $link = array();
                   $title = "إدارة المسؤوليات  الوظيفية ";
                   $title_detailed = $title ."لـ : ". $displ;
                   $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Jobrole&currmod=pag&id_origin=$my_id&class_origin=Domain&module_origin=pag&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=id_domain=$my_id&sel_id_domain=$my_id";
                   $link["TITLE"] = $title;
                   $link["UGROUPS"] = array();
                   $otherLinksArray[] = $link;
             }
             
             if($mode=="mode_goalList")
             {
                   unset($link);
                   $my_id = $this->getId();
                   $link = array();
                   $title = "إدارة الأهداف ";
                   $title_detailed = $title ."لـ : ". $displ;
                   $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Goal&currmod=bau&id_origin=$my_id&class_origin=Domain&module_origin=pag&newo=3&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=domain_id=$my_id&sel_domain_id=$my_id";
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
            $title_ar = "توليد المسؤوليات النموذجية"; 
            $pbms["xab5cB"] = array("METHOD"=>"createStandardJobResp","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
            
            
            return $pbms;
        }
        
        public function createStandardJobResp($lang="ar")
        {
              $cjr = $this->getCommonJobResp($create_obj_if_not_found=true,$always_update_name=true);
              list($djr, $dataGoalObj, $d_message) = $this->getDataJobResp($create_obj_if_not_found=true,$always_update_name=true);
              list($ljr, $lkpGoalObj, $l_message) = $this->getLookupJobResp($create_obj_if_not_found=true,$always_update_name=true);

              $info = "";
              $err = "";
              
              if($ljr) list($err,$info) = $ljr->genereMainGoal($lang);
              
              if($cjr)
              {
                   if($cjr->is_new) $info .= "$cjr created <br>";
                   else $info .= "$cjr exists already <br>";
              } 
              else $err .= "Common Job Resp not created <br>";
              
              if($djr)
              {
                   if($djr->is_new) $info .= "$djr created <br>";
                   else $info .= "$djr exists already <br>";
              }
              else $err .= "Data Job Resp not created : $d_message<br>";
              
              if($ljr)
              {
                   if($ljr->is_new) $info .= "$ljr created <br>";
                   else $info .= "$ljr exists already <br>";
              }
              else $err .= "Lookup Job Resp not created : $l_message<br>";
              
              return array($err,$info); 
        }
        
        public function getCommonJobResp($create_obj_if_not_found=true,$always_update_name=false)
        {
              $domain_code = $this->getVal("domain_code");
              if(!$domain_code) return null;
              $code_jr = "common-".strtolower($domain_code);
              
              
              $file_dir_name = dirname(__FILE__); 
              
              $jrObj = Jobrole::loadByMainIndex($this->getId(), $code_jr,$create_obj_if_not_found);
              if($jrObj->is_new or $always_update_name)
              {
                  $jrObj->set("titre_en",$this->getShortDisplay("en")." employee common responsibility");
                  $jrObj->set("titre","مسؤوليات موظف " . $this->getShortDisplay("ar"));
                  $jrObj->set("titre_short_en",$this->getShortDisplay("en")." employee  ");
                  $jrObj->set("titre_short","موظف " . $this->getShortDisplay("ar"));
                  $jrObj->update();                  
              }
              
              
              return $jrObj;   
        
        }
        
        public function getDataJobResp($create_obj_if_not_found=true,$always_update_name=false)
        {
              global $lang;
              
              $mainApplication = $this->get("mainApplication");
              if(!$mainApplication) return array(null, null, "no main application defined");
              if($mainApplication->getVal("id_pm") != $this->getId()) return array(null, null, "id of domain in main application is different than this DOMAIN-ID");
              
              list($jrObj, $goalObj) = $mainApplication->getDataJobResp($create_obj_if_not_found,$always_update_name);
              
              return array($jrObj, $goalObj, ""); 
        }
        
        public function getLookupJobResp($create_obj_if_not_found=true,$always_update_name=false)
        {
              global $lang;
              
              $mainApplication = $this->get("mainApplication");
              if(!$mainApplication) return array(null, null, "no main application defined");
              if($mainApplication->getVal("id_pm") != $this->getId()) return array(null, null, "id of domain in main application is different than this DOMAIN-ID");
              
              list($jrObj, $goalObj) = $mainApplication->getLookupJobResp($create_obj_if_not_found,$always_update_name);
              
               return array($jrObj, $goalObj, "");    
        
        }
        
        public function getRAMObjectData()
        {
                  $category_id = 13;

                  $type_id = 1204;
                  
                  /*$code = $this->getVal("goal_code");
                  if(!$code)*/ 
                  
                  $code = "domain-".$this->getId(); 
                  
                  $name_ar = $this->getVal("domain_name_ar");
                  $name_en = $this->getVal("domain_name_en");
                  $specification = $this->getVal("domain_name_ar")."\n------- english : ---------\n".$this->getVal("domain_name_en");
                  
                  $childs = array();
                  //$childs[3] =  $this->get("jobroleList");
                  
                  
                  return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
        
        }
        
        
        public function beforeMAJ($id, $fields_updated) 
        {
              global $lang;  //// old require of common_string
                
                
                if((!$this->getVal("domain_code")) or ($this->getVal("domain_code")=="--")) 
                {
                           $this->set("domain_code",strtoupper(self::javaNaming($this->getVal("domain_name_en"))));
                }
                
                if((!$this->getVal("short_name_ar")) or ($this->getVal("short_name_ar")=="--")) 
                {
                           $this->set("short_name_ar",$this->getVal("domain_name_ar"));
                }
                
                
                if((!$this->getVal("short_name_en")) or ($this->getVal("short_name_en")=="--")) 
                {
                           $this->set("short_name_en",$this->getVal("domain_name_en"));
                }
                
		return true;
	}
        
        public function getFormuleResult($attribute, $what='value') 
        {
            global $me, $server_db_prefix;    
               
               $file_dir_name = dirname(__FILE__); 
               
             
               
	       switch($attribute) 
               {
                    case "mainApplication" :
                        
                        $application_code = strtolower($this->getVal("application_code"));
                        if(!$application_code)
                        {
                                $domain_code = strtolower($this->getVal("domain_code"));
                                $application_code = $domain_code."u";
                        }
                        
                        $mainApplication = new Module();
                        
                        
                        $mainApplication->clearSelect();
                        $mainApplication->where("avail='Y' and id_module_type = 5 and (module_code='$application_code' or module_code='$domain_code')");
                        $mainApplication->load();
                        
                        return $mainApplication;                     
		    break;
                    
               }
        }
}
?>