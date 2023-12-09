<?php

$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Eimport extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "pag"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
		"id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		"orgunit_id" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "QEDIT" => false, "EDIT" => true, "SIZE" => 40, "SEARCH-ADMIN" => true, 
                                          "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "FK", "ANSWER" => orgunit, "ANSMODULE" => "hrm", "DEFAULT" => 0),  //, "READONLY"=>true
                                          
                "atable_id" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => false, "SIZE" => 40, 
                                     TYPE => FK, ANSWER => atable, ANSMODULE => pag, WHERE => "avail='Y' and tboption_mfk like '%,1,%'",
                                                "DEFAULT" => 0, AUTOCOMPLETE=>false, "SEARCH-BY-ONE"=>true, SHORTNAME => table,),

                "overwrite_data" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, 
                                  "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "YN", "DEFAULT" => "Y"),
                                  
                "skip_error" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, 
                                  "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "YN", "DEFAULT" => "N"),

                "always_commit" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, 
                                  "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "YN", "DEFAULT" => "N"),

		"afile_id" => array("IMPORTANT" => "IN", "SEARCH" => false, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 40, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, 
                                    "TYPE" => "FK", "ANSWER" => afile, "WHERE"=>"(stakeholder_id=§orgunit_id§ or owner_id=§ME§) and doc_type_id in (14)", "DEFAULT" => 0, "ANSMODULE" => "pag",
                                    "SHOW-AS-ROW" => true, "MANDATORY"=>true, SHORTNAME => file,
                                    "DISPLAY"=>"SHOW", "STYLE"=>"width: 197px !important;   height: 240px !important;", "PILLAR-PART" =>true,    
                                    ),

                curr_page => array(SEARCH => false,  QSEARCH => false,  SHOW => true,  RETRIEVE => false,  
				EDIT => true,  QEDIT => true,  
				SIZE => 32,  UTF8 => false,  
				TYPE => "INT",  READONLY => false, "DEFAULT"=>1),

                
                preview 	    => array("TYPE" => "TEXT", "CATEGORY" => "FORMULA", "SHOW"=>true, "EDIT" => true, 'STEP' =>2, READONLY=>true, FORM_HEIGHT=>"600px", SIZE => 255,  ),
                
                option_mfk => array("SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, SHORTNAME => options, 
                                      "TYPE" => "MFK", "ANSWER" => several_option, "ANSMODULE" => pag, 
                                      WHERE=>"(atable_id=§atable_id§ or atable_id=0 or atable_id is null) and option_table_id = 3604", 'STEP' =>3,),

                analysis 	    => array("TYPE" => "TEXT", "CATEGORY" => "FORMULA", "SHOW"=>true, "EDIT" => true, 'STEP' =>3, READONLY=>true, FORM_HEIGHT=>"200px"),
		
                "date_format" 	    => array("TYPE" => "TEXT", "CATEGORY" => "FORMULA", "SHOW"=>true, "EDIT" => true, 'STEP' =>3, READONLY=>true),
                "hdate_format" 	    => array("TYPE" => "TEXT", "CATEGORY" => "FORMULA", "SHOW"=>true, "EDIT" => true, 'STEP' =>3, READONLY=>true),
                "lang" 	    => array("TYPE" => "TEXT", "CATEGORY" => "FORMULA", "SHOW"=>true, "EDIT" => true, 'STEP' =>3, READONLY=>true),

		"titre" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "UTF8" => true, "SIZE" => 255, "TYPE" => "TEXT", 
                                 TITLE_AFTER=>"", HELP=>"next step will be the import execution", 'STEP' =>3,),
                
                "executed" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, 
                                  "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "YN", "DEFAULT" => "N", 'STEP' =>4, READONLY=>true),
                "succeeded" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => true, "SIZE" => 32, 
                                  "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "YN", "DEFAULT" => "N", 'STEP' =>4, READONLY=>true),
                "exec_date" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true,  STEP=>4, READONLY=>true, TYPE => DATE),
		"exec_start_time" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, RETRIEVE => true, TYPE => TIME, 'STEP' =>4, READONLY=>true),
		"exec_end_time" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, RETRIEVE => true, TYPE => TIME, 'STEP' =>4, READONLY=>true),
                "result" 	    => array("TYPE" => "TEXT", "CATEGORY" => "FORMULA", "SHOW"=>true, "EDIT" => true, 'STEP' =>4, READONLY=>true, FORM_HEIGHT=>"500px"),

                "records_processed" => array("CATEGORY" => "FORMULA", "EDIT" => true, "SHOW" => true, "RETRIEVE" => true, "READONLY" => true, "TYPE" => "INT", 'STEP' =>5, READONLY=>true),
                "records_updated" => array("CATEGORY" => "FORMULA", "EDIT" => true, "SHOW" => true, "RETRIEVE" => true, "READONLY" => true, "TYPE" => "INT", 'STEP' =>5, READONLY=>true),
                "records_new" => array("CATEGORY" => "FORMULA", "EDIT" => true, "SHOW" => true, "RETRIEVE" => true, "READONLY" => true, "TYPE" => "INT", 'STEP' =>5, READONLY=>true),
                "records_erroned" => array("CATEGORY" => "FORMULA", "EDIT" => true, "SHOW" => true, "RETRIEVE" => true, "READONLY" => true, "TYPE" => "INT", 'STEP' =>5, READONLY=>true),
                
                records => array(TYPE => FK, ANSWER => eimport_record, ANSMODULE => pag, CATEGORY => ITEMS, ITEM => 'eimport_id', WHERE=>'', 
                                       SHOW => true, FORMAT=>retrieve, EDIT => true, READONLY => true, DATA_TABLE=>"eimport_records", FORM_HEIGHT=>"900px", 
                                       ICONS=>true, 'DELETE-ICON'=>false, BUTTONS=>true, "NO-LABEL"=>true, 'STEP' =>6),
                
		"id_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"avail" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "EDIT-ADMIN" => true, "TYPE" => "YN"),
		"version" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
	);
	        
	*/ public function __construct(){
		parent::__construct("eimport","id","pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                $this->DISPLAY_FIELD = "titre";
                $this->ORDER_BY_FIELDS = "orgunit_id, atable_id, titre";
                $this->UNIQUE_KEY = array('orgunit_id','atable_id','titre');
                $this->editByStep = true;
                $this->editNbSteps = 6;
                $this->finishOnlyLastStep = true;
                $this->datatable_on_for_mode["edit"] = true;
                $this->datatable_on_for_mode["display"] = true;
                        
	}
        
        public static function loadByMainIndex($orgunit_id, $atable_id, $titre)
        {
           $obj = new Bfunction();
           $obj->select("orgunit_id",$orgunit_id);
           $obj->select("atable_id",$atable_id);
           $obj->select("titre",$titre);

           if($obj->load())
           {
                return $obj;
           }
           else return null;
           
        }
        
        
        
        public function beforeMAJ($id, $fields_updated) 
        {
            $me = AfwSession::getUserIdActing();
                if(!$this->getVal("titre")) 
                {
                           $orgunit_id = $this->getVal("orgunit_id");
                           $atable = $this->get("atable_id");
                           $atable_name = $atable->getVal("atable_name");
                           $yyyymmddhhiiss = date("YmdHis");
                           $this->set("titre","import-$yyyymmddhhiiss-$orgunit_id-$me-$atable_name");
                }
                
                if(!$this->getVal("option_mfk")) 
                {
                           if($this->getVal("atable_id")==13361) $this->set("option_mfk",",1,2,3,4,");
                }
                else
                {
                     // die("option_mfk = ".$this->getVal("option_mfk"));
                }
                
                

		return true;
	}
        
        public function getFormuleResult($attribute, $what='value') 
        {
            global $lang,$LANG_NAMES;    
               
	       switch($attribute) 
               {
                    case "preview" :
                            $curr_page = $this->getVal("curr_page");
                            return $this->getFile()->previewMe(($curr_page-1)*1000,$curr_page*1000-1);
                    break;
                    
                    case "analysis" :
                            return $this->showImportDataAnalysis();
                    break;
                    
                    case "result" :
                            return $this->showImportedDataResult($lang);
                    break;
                    
                    case "date_format" :
                            return $this->translateMessage("DD/MM/YYYY",$lang)." ".$this->translateOperator("example",$lang)." 21/06/2017";
                    break;

                    case "hdate_format" :
                            return $this->translateMessage("DD/MM/YYYY",$lang)." ".$this->translateOperator("example",$lang)." 27/09/1438";
                    break;

                    case "lang" :
                            return $LANG_NAMES[$lang][$lang];
                    break;
                    
                    case "records_processed" :
                            return count($this->getRecords());
                    break;
                    
                    case "records_erroned" :
                            return count($this->getErronedRecordList());
                    break;
                    
                    case "records_new" :
                            return count($this->getInsertedRecordList());
                    break;
                    
                    case "records_updated" :
                            return count($this->getUpdatedRecordList());
                    break;
                    
                    

               }
        }
        
        public function getErronedRecordList()
        {
            $recordList = $this->getRecords();
            
            $resultList = [];
            
            foreach($recordList as $recordId => $recordObj)
            {
                if(!$recordObj->_isSuccess())
                {
                    $resultList[$recordId] = $recordObj;
                }
            }
            
            return $resultList;
            
        }
        
        public function getInsertedRecordList()
        {
            $recordList = $this->getRecords();
            
            $resultList = [];
            
            foreach($recordList as $recordId => $recordObj)
            {
                if($recordObj->_isSuccess() and $recordObj->_isNew())
                {
                    $resultList[$recordId] = $recordObj;
                }
            }
            
            return $resultList;
            
        }
        
        public function getUpdatedRecordList()
        {
            $recordList = $this->getRecords();
            
            $resultList = [];
            
            foreach($recordList as $recordId => $recordObj)
            {
                if($recordObj->_isSuccess() and (!$recordObj->_isNew()))
                {
                    $resultList[$recordId] = $recordObj;
                }
            }
            
            return $resultList;            
        }
        
        public function showImportDataAnalysis($lang="ar")
        {
                list($errors_arr,$warnings_arr,$infos_arr) = $this->getImportDataAnalysis($lang);
                
                $errors_html = implode("<br>",$errors_arr);
                $warnings_html = implode("<br>",$warnings_arr);
                $infos_html = implode("<br>",$infos_arr);
                
                $html = "";
                
                if($errors_html) $html .=   "<div class='alert alert-danger  alert-dismissable' role='alert'>الأخطاء : <br>$errors_html</div>";        
                if($warnings_html) $html .= "<div class='alert alert-warning alert-dismissable' role='alert'>التنبيهات : <br>$warnings_html</div>";
                if($infos_html) $html .=    "<div class='alert alert-info    alert-dismissable' role='alert' >الملاحظات : <br>$infos_html</div>";

                if(!$html)
                {
                      $success_message = $this->translateMessage("data_ok_message");
                      $html .=    "<div class='alert alert-success    alert-dismissable' role='alert' >$success_message</div>";
                }

                return $html;
        }
        
        public function getImportDataAnalysis($lang="ar")
        {
             $curr_page = $this->getVal("curr_page");
             $rows_from = ($curr_page-1)*1000;
             $rows_to = $curr_page*1000-1;
             list($excel, $my_head, $my_data) = $this->getFile()->getExcelData($rows_from,$rows_to, "getImportDataAnalysis");
             
             $tbl = $this->hetTable();
             
             $errors_arr = [];
             $warnings_arr = [];
             $infos_arr = [];
             
             $row_count = $excel->rowCount();
             
             
             $infos_arr[] = "row count : " . $row_count;
             if($row_count > 1000)
             {
                $infos_arr[] = "Big data file to avoid full memory errors we will proceed import by page";
                $infos_arr[] = "Current page : $curr_page rows ($rows_from, $rows_to)";
             } 
             
             
             if($tbl)
             {
                     list($importParamsFileName,$importParamsClassName,$importParamsShouldFileName) = $tbl->getImportParams();
                     if($importParamsFileName)
                     {
                           require $importParamsFileName;
                     }

                     if((!$importRequirement) or (!is_array($importRequirement)) or (count($importRequirement)==0))
                     {
                          $errors_arr[] = $this->translateMessage("Missed the requirement table for this import, please define it in [$importParamsShouldFileName] !");
                     }
                     else
                     {
                             list($ok,$errors,$warnings,$infos) = $excel->meetsRequirement($importRequirement,$lang);
                             // die(var_export($errors,true));
                             $errors_arr = array_merge($errors_arr,$errors);
                             // die(var_export($errors_arr,true));
                             $warnings_arr = array_merge($warnings_arr,$warnings);
                             $infos_arr = array_merge($infos_arr,$infos);
                     }
             }
             else
             {
                     $errors_arr[] = $this->translateMessage("Missed the target table for this import, please define it !");
             }
             
             return [$errors_arr,$warnings_arr,$infos_arr];     
             
        }
        
        public function showImportedDataResult($lang="ar")
        {
                list($records, $importedObjects, $errors_arr, $warnings_arr, $infos_arr) = $this->executeDataImport($lang);
                // $nb_importedObjects = count($importedObjects);
                // $nb_records = ;
                $errors_html = implode("<br>",$errors_arr);
                $warnings_html = implode("<br>",$warnings_arr);
                $infos_html = implode("<br>",$infos_arr);
                
                $html = "";
                
                if($errors_html) $html .=   "<div class='alert alert-danger  alert-dismissable' role='alert'>الأخطاء : <br>$errors_html</div>";        
                if($warnings_html) $html .= "<div class='alert alert-warning alert-dismissable' role='alert'>التنبيهات : <br>$warnings_html</div>";
                if($infos_html) $html .=    "<div class='alert alert-info    alert-dismissable' role='alert' >الملاحظات : <br>$infos_html</div>";

                if(!$errors_html)
                {
                      $success_message = $this->translateMessage("data_import_success") . "";
                      $html .=    "<div class='alert alert-success    alert-dismissable' role='alert' >$success_message</div>";
                }
                

                return $html;
        }
        
        public function cleanRecords()
        {
             list($eimport_record_fileName,) = AfwStringHelper::getHisFactory("eimport_record", "pag");
             require_once($eimport_record_fileName);
             $eirec = new EimportRecord;
             $eirec->select("eimport_id",$this->getId());
             $eirec->logicDelete(true,false);
        }
        
        public function executeDataImport($lang="ar")
        {
             $me = AfwSession::getUserIdActing();
             if(!$me) return array("no user connected", "no user connected");             
             $file_dir_name = dirname(__FILE__);

             $errors_arr = [];
             $warnings_arr = [];
             $informations_arr = [];
             
             $curr_page = $this->getVal("curr_page");

             list($excel, $my_head, $my_data) = $this->getFile()->getExcelData(($curr_page-1)*1000,$curr_page*1000-1,"executeDataImport");
             //die(var_export($my_data,true));
             $tbl = $this->hetTable();
             $options = $this->getOptions();
             $orgunit_id = $this->getVal("orgunit_id");
             $overwrite_data = $this->is("overwrite_data");
             $skip_error = $this->is("skip_error");
             $always_commit = $this->is("always_commit");
             
             $okImport = false;
             
             $this->cleanRecords();
             
             if($tbl)
             {
                     list($importParamsFileName,$importParamsClassName,$importParamsShouldFileName) = $tbl->getImportParams();
                     
                     if($importParamsFileName)
                     {
                           require $importParamsFileName;
                     }
                     
                     if((!$importRequirement) or (!is_array($importRequirement)) or (count($importRequirement)==0))
                     {
                          $errors_arr[] = $this->translateMessage("Missed the requirement table for this import, please define it in [$importParamsShouldFileName] !");
                     }
                     else
                     {
                             list($okImport,$errors,$warnings,$infos) = $excel->meetsRequirement($importRequirement,$lang);
        
                             $errors_arr = array_merge($errors_arr,$errors);
                             // die(var_export($errors_arr,true));
                             $warnings_arr = array_merge($warnings_arr,$warnings);
                             $infos_arr = array_merge($infos_arr,$infos);
                             
                             if($okImport)
                             {
                                     list($myFileName,$myClassName) = $tbl->getFileAndClass();
                                     $importClassesList = [];
                                     $importClassesList[$myClassName] = ['table_id'=>$tbl->getId(),'file'=>$myFileName];
                                     
                                     require_once $myFileName;
                                     $myObjImport = new $myClassName();
                                     
                                     $relatedClassesForImport = $myObjImport->getRelatedClassesForImport($options);
                                     if(count($relatedClassesForImport)>0)
                                     {
                                         die("rafik : I put this die temporary to see if can be optimized and to not be reason of memory crash");
                                     }
                                     
                                     foreach($relatedClassesForImport as $relClassName => $relFileName)
                                     {
                                           $importClassesList[$relClassName] = $relFileName;
                                     }
                                  
                                     foreach($importClassesList as $myClassImport => $myFileImport)
                                     {   
                                            if($okImport or $skip_error)
                                            {
                                                    if(!$myFileImport["table_id"]) throw new RuntimeException("myFileImport[table_id] should be defined for class $myClassImport in $myClassName::getRelatedClassesForImport(), choof : myFileImport =".var_export($myFileImport,true));
                                                    require_once $myFileImport["file"];
                                                    unset($myObjImport);
                                                    $myObjImport = new $myClassImport();
                                                    list($okImport,
                                                         $records[$myFileImport["table_id"]], 
                                                         $importedObjects[$myFileImport["table_id"]], 
                                                         $errors,$warnings,$infos) = AfwImportHelper::importData($myObjImport,$this->getId(), $myFileImport["table_id"], $my_data, $orgunit_id, $overwrite_data, $skip_error, $always_commit, $options,$lang, $excel->getDataStartRow());
                                                    //die(var_export($errors,true));
                                                    $errors_arr = array_merge($errors_arr,$errors);
                                                     // die(var_export($errors_arr,true));
                                                    $warnings_arr = array_merge($warnings_arr,$warnings);
                                                    $infos_arr = array_merge($infos_arr,$infos);
                                            }
                                            else
                                            {
                                                    $errors_arr[] = $this->translateMessage("Import has been halted because of errors",$lang);
                                            }        
                                     }
                                     unset($my_data);
                                     unset($excel);
                                    
                             }
                     
                     }
                     $curr_page++;
                     $this->set("curr_page", $curr_page);
                     $this->commit();
                     
                     
             }
             else
             {
                     $errors_arr[] = $this->translateMessage("Missed the target table for this import, please define it !",$lang);
             }
             
             
        
             return array($records, $importedObjects, $errors_arr, $warnings_arr, $infos_arr);     
             
        }
        
        public function executeTheImport($lang="ar")
        {
            list($records, $importedObjects, $errors_arr, $warnings_arr, $infos_arr) = $this->executeDataImport($lang);
            
            if(count($errors_arr)==0) $infos_arr[] = "imported sucessfully. record count : ".count($importedObjects);
            $infos_arr = array_merge($warnings_arr,$infos_arr);
            
            return array(implode("<br>\n",$errors_arr), implode("<br>\n",$infos_arr));
        }
        

        protected function getPublicMethods()
        {
            $pbm = [];                      
            
            $pbm["xY01ab"] = array("METHOD"=>"executeTheImport", "LABEL_AR"=>"تنفيذ عملية إستيراد الملف", "LABEL_EN"=>"genere school days with omalqura hijri system", "ADMIN-ONLY"=>"true");
            
            return $pbm;  
        }                
}
?>
