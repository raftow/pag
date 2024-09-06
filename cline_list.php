<?php
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code with params ".var_export($command_line_words, true));
    // ex list index fields from table booking
    // ex list original fields from table travel 
    $object_filter = $command_line_words[1];
    // $command_mode="RETRIEVE";
    
    $object_list_attribute_origin = $object_list_attribute = $command_line_words[2];
    if($object_filter != "all")
    {
        $object_list_attribute = $object_filter . "_" . $object_list_attribute;
    }
    $object_list_source_type = $command_line_words[3];
    $object_entity = $command_line_words[4];
    if(!$object_entity and ($object_list_attribute_origin=="fields")) $object_entity = "table";
    if(!$object_entity)                
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "Error 0003 : missed word-4 object_entity in your command (note that object_list_attribute_origin=$object_list_attribute_origin)");$nb_errors++;
    }

    list($object_class_file, $object_module) = parse_table_and_module($object_entity);
    if(!$object_class_file and !$object_module)                
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "Error 0004 : parse_table_and_module($object_entity) returned nothing see why with framework expert");$nb_errors++;
    }
    
    if(!$object_module) $object_module = $currmod;
    
    $object_codeOrId = $command_line_words[5];
    if((!$object_codeOrId) and ($object_entity == "table") and $currtbl) $object_codeOrId = $currtbl;

    $object_code = is_numeric($object_codeOrId) ? "" : $object_codeOrId;
    $object_id   = is_numeric($object_codeOrId) ? intval($object_codeOrId) : "";
    $objToShow = null;
    $module_path = "$file_dir_name/../$object_module/models";
    if(file_exists("$module_path/$object_class_file.php"))
    {
            require_once("$module_path/$object_class_file.php");
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
                                $command_line_result_arr[] = hzm_format_command_line("error", "load $object_class by code still not implemented in Momken framework comand line");$nb_errors++;
                        }
            }
            
            if($object_id)
            {
                $objToShow = $object_class::loadById($object_id); 
            }
    }
    else
    {
            $command_line_result_arr[] = hzm_format_command_line("error", "Error 0002 please check that the file '$object_class_file.php' file exists in module path '$module_path'");$nb_errors++;
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