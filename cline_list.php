<?php
    
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code with params ".var_export($command_line_words, true));
    // ex list index fields from table booking
    // ex list original fields from table travel 
    // ex list all goals (will take the domain of current module if same code)
    // ex list all goals of domain hr (explicit if not same code) 
    $setted_phrase = "";
    $object_filter = $command_line_words[1];
    // $command_mode="RETRIEVE";
    
    $object_list_attribute_origin = $object_list_attribute = $command_line_words[2];
    if($object_filter != "all")
    {
        $object_list_attribute = $object_filter . "_" . $object_list_attribute;
    }
    $object_list_source_type = $command_line_words[3];
    $object_entity = $command_line_words[4];
    if(!$object_entity and ($object_list_attribute_origin=="options")) $object_entity = "field";
    if(!$object_entity and ($object_list_attribute_origin=="fields")) $object_entity = "table";
    if(!$object_entity and ($object_list_attribute_origin=="relations")) $object_entity = "table";

    if(!$object_entity and ($object_list_attribute_origin=="bfs" or $object_list_attribute_origin=="bf")) 
    {
        $object_entity = "table";
        $object_list_attribute = "bfunctionList";
    }

    if(!$object_entity and ($object_list_attribute_origin=="roles"))
    {
        $object_entity = "module";
        $object_list_attribute = "allRolesAndSubRoles";
    }
    
    if(!$object_entity and ($object_list_attribute_origin=="levels"))
    {
        $object_entity = "module";
        $object_list_attribute = "allLevels";
    }

    if($object_list_attribute_origin=="options")
    {
        $object_list_attribute="afieldOptionValueList";
    }

    if($object_list_attribute_origin=="tables")
    {
        $object_entity = "module";
        $object_list_attribute="allMyTables";                
    }

    if($object_list_attribute_origin=="fields")
    {
        $object_list_attribute="origFieldList";
            
        if($object_filter == "name") $object_list_attribute="nameFieldList";
        if($object_filter == "audit") $object_list_attribute="auditFieldList";
        if($object_filter == "index") $object_list_attribute="indexFieldList";
        if($object_filter == "virtual") $object_list_attribute="virtFieldList";
        if($object_filter == "additional") $object_list_attribute="addiFieldList";
    }
    
    if($object_list_attribute_origin=="goals")
    {
        if(!$object_entity) $object_entity = "domain";
        
        if($object_entity=="domain") 
        {
            $object_list_attribute="goalList";
            $setted_phrase .= "object_entity setted to $object_entity, ";
            
        }
        elseif($object_entity=="table")
        {
            $object_list_attribute="concernedGoalList";
        }
        $setted_phrase .= "object_list_attribute setted to $object_list_attribute, "; 
        

        
        if($setted_phrase) $command_line_result_arr[] = hzm_format_command_line("warning", $setted_phrase);
    }

    if($object_list_attribute_origin=="jobs")
    {
        if(!$object_entity) $object_entity = "domain";
        
        if($object_entity=="domain") 
        {
            $object_list_attribute="jobroleList";
            $setted_phrase .= "object_entity setted to $object_entity, ";
            
        }
        
        $setted_phrase .= "object_list_attribute setted to $object_list_attribute, "; 
        

        
        if($setted_phrase) $command_line_result_arr[] = hzm_format_command_line("warning", $setted_phrase);
    }

    if(!$object_entity)                
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "Error 0003 : missed word-4 object_entity in your command (note that object_list_attribute_origin=$object_list_attribute_origin)");
        $nb_errors++;$command_finished = true;return;
    }

    list($object_table, $object_module) = ClineUtils::parse_table_and_module($object_entity);
    if(!$object_table and !$object_module)                
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "Error 0004 : ClineUtils::parse_table_and_module($object_entity) returned nothing see why with framework expert");
        $nb_errors++;$command_finished = true;return;
    }
    
    if(!$object_module) $object_module = $currmod;
    
    $object_codeOrId = $command_line_words[5];
    if((!$object_codeOrId) and ($object_entity == "table") and $currtbl) 
    {
        $object_codeOrId = $currtbl;
        
    }

    if((!$object_codeOrId) and ($object_entity == "field") and $currfld_id) 
    {
        $object_codeOrId = $currfld_id;
        
    }
    
    if(!$object_codeOrId) 
    {
        if($object_entity == "domain")
        {
            $object_codeOrId = Module::moduleCodeToDomainId($currmod);  
            //die("object_codeOrId=$object_codeOrId = Module::moduleCodeToDomainId($currmod);  ");
        }
        elseif($object_entity == "module")
        {
            $object_codeOrId = $currmod;  
        }
        
        // die("$object_codeOrId = Module::moduleCodeToDomainId($currmod)");
        $setted_phrase .= "object_codeOrId setted to $object_codeOrId from $currmod, ";
    }
    
    $object_code = is_numeric($object_codeOrId) ? "" : $object_codeOrId;

    $object_id   = is_numeric($object_codeOrId) ? intval($object_codeOrId) : "";
    $objToShow = null;
    $module_path = "$file_dir_name/../$object_module/models";
    if(file_exists("$module_path/$object_table.php"))
    {
            require_once("$module_path/$object_table.php");
            $object_class = AfwStringHelper::tableToClass($object_table);
            
            if($object_code and (!$object_id)) 
            {
                        if(method_exists($object_class, "loadByCodes"))
                        {
                                $object_code_arr = explode(".",$object_code);
                                $objToShow = $object_class::loadByCodes($object_code_arr);
                        }
                        else
                        {
                                $command_line_result_arr[] = hzm_format_command_line("error", "load $object_class by code still not implemented in Momken framework comand line");
                                $nb_errors++;$command_finished = true;return;
                        }
            }
            
            if($object_id)
            {
                $objToShow = $object_class::loadById($object_id); 
            }
    }
    else
    {
            $command_line_result_arr[] = hzm_format_command_line("error", "Error 0002 please check that the file '$object_table.php' file exists in module path '$module_path'"); $nb_errors++;$command_finished = true;return;
    }
    
    if($objToShow and (!$objToShow->isEmpty()))
    {
        // $arrAttributes = AfwFrameworkHelper::getColsByMode($objToShow, $command_mode);
        $module_translated = $objToShow->translate("$object_table.single",$lang);
        if($lang!="ar") $arrow = "&rarr;";
        else $arrow = "&larr;";
        if($object_list_attribute=="relations") 
        {
            $liste_obj = $objToShow->getAllTablesRelatedWithMeFields();
        }
        elseif($object_list_attribute=="allMyTables") 
        {
            $liste_obj = $objToShow->getAllMyTables();
        }
        else 
        {
            $liste_obj = $objToShow->get($object_list_attribute);
        }

        if(is_array($liste_obj) and (count($liste_obj)==0)) 
        {
            $command_line_result_arr[] = hzm_format_command_line("warning", $module_translated." : ".$objToShow->getDisplay($lang)." ($object_class) => get ($object_list_attribute) returned empty"); $command_finished = true;return;
        }
        elseif(!$liste_obj) 
        {
            $command_line_result_arr[] = hzm_format_command_line("error", $module_translated." : ".$objToShow->getDisplay($lang)." ($object_class) => get ($object_list_attribute) returned null"); $nb_errors++;$command_finished = true;return;
        }
        else
        {
            $command_line_result_arr[] = hzm_format_command_line("success", $module_translated." : ".$objToShow->getDisplay($lang)." ($object_class) $arrow ". $objToShow->translate($object_list_attribute,$lang), $lang);
            $command_code = "retrieve";
        }
        
        
    }
    else
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "object [Class=$object_class  CodeOrId=$object_codeOrId] not found"); $nb_errors++;$command_finished = true;return;
    }
    
    $command_done = true;