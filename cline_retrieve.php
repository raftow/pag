<?php
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
    $command_finished = true;