<?php
   if(!$lang) $lang = "ar";
   $file_dir_name = dirname(__FILE__);
   require_once("$file_dir_name/../lib/afw/afw_utils.php");
   echo "<link href=\"../pag/cline.css\" rel=\"stylesheet\" type=\"text/css\">";
   $command_line_result_arr = array();
   $hist = trim($hist);
   if($hist) $hist_arr = explode("\n", $hist);
   else $hist_arr = array();
   
   $last_hist = "";
   if(count($hist_arr)>0)
   {
       $last_hist = $hist_arr[count($hist_arr)-1];
   }

   $nb_errors = 0;
   $nb_warnings = 0;
   
   if($command_line=="recall")
   {
      if($last_hist) 
      {
              $command_line = $last_hist;
              $command_line_result_arr[] = hzm_format_command_line("warning", "last history command recalled"); $nb_warnings++;
      }
      else
      {
              $command_line_result_arr[] = hzm_format_command_line("error", "no history command to recall"); $nb_errors++;
              $command_line = "";
      }
   }
   
   
   $data_token_new_suggested_command_line = "";
   
   if($command_line)
   {
      $loadByCodeArr = array();
      $loadByCodeArr["module"] = true;
      $loadByCodeArr["atable"] = true;
      $loadByCodeArr["afield"] = true;

      $reverseByCodeArr = array();
      $reverseByCodeArr["module"] = true;
      $reverseByCodeArr["atable"] = true;

      
      
      $command_line_words = explode(" ", $command_line);
      $command_code = $command_line_words[0];
      
      $command_done = false;
      
      if($command_code=="help")
      {
          $command_to_help = $command_line_words[1];
          $command_line_result_arr[] = hzm_attribute_command_line("info", "header", "COMMAND", "DESCRIPTION", "en", "info");
          $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "curr module", "to change the current module", "en", "log");
          $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "find table[.module] filter find-method find-param", "to find an object into a specific module", "en", "log");
          $command_line_result_arr[] = hzm_format_command_line("warning", "        ex : find module all like app");
          $command_line_result_arr[] = hzm_format_command_line("warning", "        command line kernal try to be intelligent to find the object into the correct module if it fail it looks for into the current module");

          $command_done = true;
      }
      
      if($command_code=="curr")
      {
          $currmod_code = $command_line_words[1];
          
          $objModule = Module::getModuleByCode(0, $currmod_code);
          if($objModule and (!$objModule->isEmpty()))
          {
                $currmod = $objModule->getVal("module_code");
                $idMod = $objModule->getId();
                $nbTables = $objModule->getVal("tablecount");
                
                $module_translated = $objModule->translate("module.single",$lang);
                $command_line_result_arr[] = hzm_format_command_line("info", "current module changed to $currmod, id of module is $idMod , it contain $nbTables table(s)");
                $command_line_result_arr[] = hzm_format_command_line("success", $module_translated." : ".$objModule->getDisplay($lang), $lang);
          }
          else
          {
                $command_line_result_arr[] = hzm_format_command_line("error", "module $currmod_code not found");
                $nb_errors++;
          }
          $command_done = true;
      }

      if(($command_code=="curo") or ($command_code=="curro"))
      {
          
          $objModule = Module::getModuleByCode(0, $currmod);
          if(!$objModule)
          {
                  $command_line_result_arr[] = hzm_format_command_line("error", "current module not set (use curr command)");
                  $nb_errors++;
          }
          else
          {
                  $idMod = $objModule->getId();
                  $atable_name = $command_line_words[1];
                  
                  $objAtable = Atable::loadByMainIndex($idMod, $atable_name);
                  if($objAtable and (!$objAtable->isEmpty()))
                  {
                        $atable_class = AfwStringHelper::tableToClass($atable_name);
                        $idTab = $objAtable->getId();
                        $nbFields = $objAtable->getVal("fieldcount");
                        
                        $atable_translated = $objAtable->translate("atable.single",$lang);
                        $command_line_result_arr[] = hzm_format_command_line("info", "current object class changed to $atable_class, id of entity is $idMod , it contain $nbFields field(s)");
                        $command_line_result_arr[] = hzm_format_command_line("success", $atable_translated." : ".$objAtable->getDisplay($lang), $lang);
                        $command_line_result_arr[] = hzm_format_command_line("log", " to see the field(s) of this table : ", $lang);
                        $command_line_result_arr[] = hzm_attribute_command_line("info", "header", "COMMAND", "DESCRIPTION", "en", "info");
                        $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "list original fields from table $currmod-$atable_name", "to see the original fields", "en", "log");
                        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "list index fields from table $currmod-$atable_name", "to see the index fields", "en", "log");
                        $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "list audit fields from table $currmod-$atable_name", "to see the audit fields", "en", "log");
                        
                        
                                  // ex  booking
          // ex list  fields from table travel 

                  }
                  else
                  {
                        $command_line_result_arr[] = hzm_format_command_line("error", "table $atable_name not found in module $currmod");
                        $nb_errors++;
                  }
          }
          $command_done = true;
      }
      
      if($command_code=="curf")
      {
          
          $objModule = Module::getModuleByCode(0, $currmod);
          if(!$objModule)
          {
                  $command_line_result_arr[] = hzm_format_command_line("error", "current module not set (use curr command)");
                  $nb_errors++;
          }
          else
          {
                  $idMod = $objModule->getId();
                  $atable_name = $command_line_words[1];
                  
                  $objAtable = Atable::loadByMainIndex($idMod, $atable_name);
                  if($objAtable and (!$objAtable->isEmpty()))
                  {
                        $atable_class = AfwStringHelper::tableToClass($atable_name);
                        $idTab = $objAtable->getId();
                        $nbFields = $objAtable->getVal("fieldcount");
                        
                        $atable_translated = $objAtable->translate("atable.single",$lang);
                        $command_line_result_arr[] = hzm_format_command_line("info", "current object class changed to $atable_class, id of module is $idMod , it contain $nbFields field(s)");
                        $command_line_result_arr[] = hzm_format_command_line("success", $atable_translated." : ".$objAtable->getDisplay($lang), $lang);
                  }
                  else
                  {
                        $command_line_result_arr[] = hzm_format_command_line("error", "table $atable_name not found in module $currmod");
                        $nb_errors++;
                  }
          }
          $command_done = true;
      }
      
      
      if($command_code=="find")
      {
         // ex find module all like app
          list($object_class_file, $object_module) = parse_table_and_module($command_line_words[1]);
          $filter_method = $command_line_words[2];
          $find_method = $command_line_words[3];
          $find_param = $command_line_words[4];
          $objMain = null;
          if(file_exists("$file_dir_name/../$object_module/$object_class_file.php"))
          {
                  require_once("$file_dir_name/../$object_module/$object_class_file.php");
                  $object_class = AfwStringHelper::tableToClass($object_class_file);
                  
                  $objMain = new $object_class();
          }
          else
          {
                  $command_line_result_arr[] = hzm_format_command_line("error", "please check that class $object_class_file file exists in module '$object_module'");$nb_errors++;
          }


          if($objMain)
          {
                  $words = $find_param;
                  if($filter_method != "all")
                  {
                      $objMain->applyFilter($filter_method);
                  }
                  if($find_method=="like") $liste_obj = AfwFrameworkHelper::qfind($objMain,$words);
                  $command_code = "retrieve";
          }
      }
      
      if($command_code=="list")
      {
          // ex list index fields from table booking
          // ex list original fields from table travel 
          $object_filter = $command_line_words[1];
          // $command_mode="RETRIEVE";
          
          $object_list_attribute = $command_line_words[2];
          if($object_filter != "all")
          {
              $object_list_attribute = $object_filter . "_" . $object_list_attribute;
          }
          $object_list_source_type = $command_line_words[3];
          list($object_class_file, $object_module) = parse_table_and_module($command_line_words[4]);
          
          if(!$object_module) $object_module = $currmod;
          
          $object_codeOrId = $command_line_words[5];
          $object_code = is_numeric($object_codeOrId) ? "" : $object_codeOrId;
          $object_id   = is_numeric($object_codeOrId) ? intval($object_codeOrId) : "";
          $objToShow = null;
          if(file_exists("$file_dir_name/../$object_module/$object_class_file.php"))
          {
                  require_once("$file_dir_name/../$object_module/$object_class_file.php");
                  $object_class = AfwStringHelper::tableToClass($object_class_file);
                  
                  if($object_code and (!$object_id)) 
                  {
                                if($loadByCodeArr[$object_class_file])
                                {
                                     $object_code_arr = explode("-",$object_code);
                                     $objToShow = $object_class::loadByCodes($object_code_arr);
                                }
                                else
                                {
                                     $command_line_result_arr[] = hzm_format_command_line("error", "load $object_class by code still not implemented in tamakan framework comand line");$nb_errors++;
                                }
                  }
                  
                  if($object_id)
                  {
                        $objToShow = $object_class::loadById($object_id); 
                  }
          }
          else
          {
                  $command_line_result_arr[] = hzm_format_command_line("error", "please check that class $object_class_file file exists in module '$object_module'");$nb_errors++;
          }
          
          if($objToShow and (!$objToShow->isEmpty()))
          {
                // $arrAttributes = $objToShow->getColsByMode($command_mode);
                $module_translated = $objToShow->translate("$object_class_file.single",$lang);
                if($lang!="ar") $arrow = "&rarr;";
                else $arrow = "&larr;";
                
                $liste_obj = $objToShow->get($object_list_attribute);
                $command_line_result_arr[] = hzm_format_command_line("success", $module_translated." : ".$objToShow->getDisplay($lang)." $arrow ". $objToShow->translate($object_list_attribute,$lang), $lang);
                $command_code = "retrieve";
                
          }
          else
          {
                $command_line_result_arr[] = hzm_format_command_line("error", "object $object_class [$object_codeOrId] not found");$nb_errors++;
          }
          
          $command_done = true;
      }
      
      if($command_code=="reverse")
      {
          list($object_class_file, $object_module) = parse_table_and_module($command_line_words[1]);
          if(!$object_module) $object_module = $currmod;
          
          $object_code = $command_line_words[2];
          
          if(file_exists("$file_dir_name/../$object_module/$object_class_file.php"))
          {
                  require_once("$file_dir_name/../$object_module/$object_class_file.php");
                  $object_class = AfwStringHelper::tableToClass($object_class_file);
                  
                  if($object_code) 
                  {
                          if($reverseByCodeArr[$object_class_file])
                          {
                             $object_code_arr = explode("-",$object_code);
                             $objToShow = $object_class::reverseByCodes($object_code_arr);
                          }
                          else
                          {
                             $command_line_result_arr[] = hzm_format_command_line("error", "reverse $object_class by code still not implemented in tamakan framework comand line");$nb_errors++;
                          }
                        
                  }
                  if($object_id)
                  {
                        $objToShow = $object_class::loadById($object_id); 
                  }
          }
          else
          {
                  $command_line_result_arr[] = hzm_format_command_line("error", "please check that class $object_class_file file exists in module '$object_module'");$nb_errors++;
          }
          
          

          $command_code="show";
      }
      
      if(($command_code=="show") or ($command_code=="view") or ($command_code=="more"))
      {
          
          if(count($command_line_words)>3) 
          {
               $command_line_result_arr[] = hzm_format_command_line("error", "command line $command_code does'nt need all these params, see help.");$nb_errors++;
               $command_mode = "";
          }    
          else $command_mode = $command_code;
          
          if($command_code=="show") $command_mode="SHOW";
          if($command_code=="view") $command_mode="RETRIEVE";
          if($command_code=="more") $command_mode="MINIBOX";
          
          if(!$command_mode)
          {
                $command_line_result_arr[] = hzm_format_command_line("error", "can't complete display command, template not found");$nb_errors++;
          }
          
          list($object_class_file, $object_module) = parse_table_and_module($command_line_words[1]);
          
          
          if(!$object_module) $object_module = $currmod;
          
          $object_codeOrId = $command_line_words[2];
          $object_code = is_numeric($object_codeOrId) ? "" : $object_codeOrId;
          $object_id   = is_numeric($object_codeOrId) ? intval($object_codeOrId) : "";
          
          $objToShow = null;
          if(file_exists("$file_dir_name/../$object_module/$object_class_file.php"))
          {
                  require_once("$file_dir_name/../$object_module/$object_class_file.php");
                  $object_class = AfwStringHelper::tableToClass($object_class_file);
                  
                  if($object_code and (!$object_id)) 
                  {
                        if($loadByCodeArr[$object_class_file])
                        {
                             $object_code_arr = explode("-",$object_code);
                             $objToShow = $object_class::loadByCodes($object_code_arr);
                        }
                        else
                        {
                             $command_line_result_arr[] = hzm_format_command_line("error", "load $object_class by code still not implemented in tamakan framework comand line");$nb_errors++;
                        }
                        
                  }
                  if($object_id)
                  {
                        $objToShow = $object_class::loadById($object_id); 
                  }
          }
          else
          {
                  $command_line_result_arr[] = hzm_format_command_line("error", "please check that class $object_class_file file exists in module '$object_module'");$nb_errors++;
          }
          
          if($objToShow and (!$objToShow->isEmpty()))
          {
                $arrAttributes = $objToShow->getColsByMode($command_mode);
                $module_translated = $objToShow->translate("module.single",$lang);
                $command_line_result_arr[] = hzm_format_command_line("success", $module_translated." : ".$objToShow->getDisplay($lang), $lang);
                $odd_oven = "odd";
                foreach($arrAttributes as $attribute)
                {
                    $val_att = $objToShow->previewAttribute($attribute);
                    
                    $name_att = $attribute." - ".$objToShow->translate($attribute,$lang);
                    
                    $command_line_result_arr[] = hzm_attribute_command_line("info", $odd_oven, $name_att, $val_att, $lang);
                    if($odd_oven != "odd") $odd_oven = "odd";
                    else $odd_oven = "oven";
                }
          }
          else
          {
                $command_line_result_arr[] = hzm_format_command_line("error", "object $object_class [$object_codeOrId] not found");$nb_errors++;
          }
          $command_done = true;
      }
      
      if($command_code=="retrieve")
      {
                if(count($liste_obj)>0)
                {
                        reset($liste_obj);
                        $obj_first = current($liste_obj);
                        if($obj_first) $object_first_class_file = $obj_first->getMyTable();
                        else $object_first_class_file = "empty";
                        $command_line_result_arr[] = hzm_format_command_line("title", "retrieve list of [$object_first_class_file] : ", $lang);
                        
                        $odd_oven = "odd";
                        foreach($liste_obj as $oneObj)
                        {
                             list($is_ok, $dataErr) = $oneObj->isOk($force=true, $returnErrors=true);                             
                             $dataErrors = truncateArabicJomla(implode(", ", $dataErr), $maxlen=56);
                             
                             if($dataErrors) $errorClass = "error";
                             else $errorClass = "success";
                             
                             $dataErrors = "<span class='object_code'>".$oneObj->getMyCode("")."</span> ".$dataErrors;
                             
                             $oneObjIdLinked = $oneObj->showAttributeAsLinkMode("id","EDIT");
                             $command_line_result_arr[] = hzm_object_command_line("info", $odd_oven, $oneObjIdLinked, $oneObj->getDisplay($lang), $dataErrors, $errorClass, $lang);
                             if($odd_oven != "odd") $odd_oven = "odd";
                             else $odd_oven = "oven";
                             unset($oneObj);
                        }
                }
                else
                {
                         $command_line_result_arr[] = hzm_format_command_line("warning", "no record");$nb_warnings++;
                }
                $command_done = true;
      
      }
      
      if(!$command_done)
      {
          $command_line_result_arr[] = hzm_format_command_line("error", "command unknown $command_code");$nb_errors++;
      }
      

      $command_line_result_arr[] = "";
      $command_line_result_arr[] = "______________________________________________________________________________________________________";
      $command_line_result_arr[] = "";

      if((!$nb_errors) and (!$nb_warnings))
      { 
              $command_line_result_arr[] = hzm_format_command_line("normal", "Your last command : ");                          
              $command_line_result_arr[] = hzm_format_command_line("log", $command_line);
              
              if($last_hist != $command_line)
              {
                   $hist_arr[] = $command_line;
              }
              $data_token_new_suggested_command_line = "";
      }
      else
      {
              if($nb_errors) $command_line_result_arr[] = hzm_format_command_line("error", "$nb_errors error(s)");
              if($nb_warnings) $command_line_result_arr[] = hzm_format_command_line("warning", "$nb_warnings warning(s)");
              $data_token_new_suggested_command_line = $command_line;
              //die("data_token_new_suggested_command_line=$data_token_new_suggested_command_line");
      }
      
      
      $command_line_result_arr[] = hzm_format_command_line("normal", "Your command history : ");
      
      $log_hist_class = "";
      
      $hist_toshow_arr = array_reverse($hist_arr);
      foreach($hist_toshow_arr as $hord => $hist_item)
      {
          if($log_hist_class != "log_odd") $log_hist_class = "log_odd"; else $log_hist_class = "log";
          $kord = count($hist_arr) - $hord;
          $command_line_result_arr[] = "<div class='tamakkan_hiostory'><div class='tamakkan_rt'>$kord. tmkn> </div> " .hzm_format_command_line($log_hist_class, $hist_item)."</div>";
      }
   }
   $hist = implode("\n", $hist_arr);
   $data_tokens = array();

   $html_template_file = "$file_dir_name/../pag/tpl/cline_tpl.php";
   $data_tokens["command_line_result"] = implode("<br>\n",$command_line_result_arr);
   $data_tokens["newsug_command_line"] = $data_token_new_suggested_command_line;
   $data_tokens["currmod"] = $currmod;
   $data_tokens["currobj"] = $currobj;
   $data_tokens["currfld"] = $currfld;
   $data_tokens["hist"] = $hist;
   // die("data_tokens=".var_export($data_tokens,true));             
   echo showUsingHzmTemplate($html_template_file, $data_tokens);
   
   
   
?>