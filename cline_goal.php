<?php
$command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code with params ".var_export($command_line_words, true));
// ex goal 180 +t app_model_api : to add table api_endpoint to the goal 180 (ie. settings management for example)
//           -> the impact is to find business functions such as quick search on api_endpoint in the menu role of this goal 180
// ex goal 180 -t api_endpoint : to remove table api_endpoint from the goal 180 
//
$setted_phrase = "";
$goal_id = $command_line_words[1];
$action = $command_line_words[2];
$atable_name = $command_line_words[3];
if(!$atable_name) $atable_name = $currtbl_code;
$framework_mode = $command_line_words[4];
if(!$framework_mode) $framework_mode = "qsearch";
$full = $command_line_words[5];
$jobrole_id = $command_line_words[6];

AfwAutoLoader::addModule("bau");
if($goal_id>0)
{
    if(($action=="+t") or ($action=="-t"))
    {
        
        if(!$atable_name)
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "goal command need that you specify the table name see {help goal} examples");
            $nb_errors++;$command_finished = true;return;
        }

        if(!$currmod)
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "goal command need that you select the current module");
            $nb_errors++;$command_finished = true;return;
        }
        $objModule = Module::getModuleByCode(0, $currmod);
        if(!$objModule)
        {
                $command_line_result_arr[] = hzm_format_command_line("error", "failed to load module with code = $currmod");
                $nb_errors++;$command_finished = true;return;
        }
        else
        {
                $idMod = $objModule->getId();
                $objAtable = Atable::loadByMainIndex($idMod, $atable_name);
                if($objAtable and (!$objAtable->isEmpty()))
                {
                        $idTab = $objAtable->getId();
                        $currtbl_code = $atable_name;
                        $currtbl = $idTab;                        
                        $atable_translated = $objAtable->translate("atable.single",$lang);

                        
                        if($full) 
                        {
                            $goalObj = Goal::loadById($goal_id);

                            if(!$goalObj)
                            {
                                    $command_line_result_arr[] = hzm_format_command_line("error", "failed to load goal with id = $goal_id");
                                    $nb_errors++;$command_finished = true;return;
                            }
                            list($error, $info) = $goalObj->fullManageTable($idTab, $jobrole_id, $action);
                            $what_done = "fullManageTable($idTab, $jobrole_id, $action)";
                        }
                        else 
                        {
                            list($info, $goalObj) = $objAtable->manageMeInMenuOf($goal_id, $jobrole_id, $framework_mode, $action="+t");
                            $what_done = "manageMeInMenuOf($goal_id, $jobrole_id, $framework_mode, $action)";
                        }

                        if($error)
                        {
                            $command_line_result_arr[] = hzm_format_command_line("error", "error while doing $what_done");
                            $nb_errors++;$command_finished = true;return;
                        }

                        $command_line_result_arr[] = hzm_format_command_line("info", "while doing $what_done result was :");
                        $command_line_result_arr[] = hzm_format_command_line("success", $info);
                        $command_line_result_arr[] = hzm_format_command_line("info", $atable_translated." has been managed by goal ".$goalObj->getDisplay($lang), $lang);
                        $command_line_result_arr[] = hzm_format_command_line("warning", "You can check now if your menus are changed", $lang);
                        $command_finished = true;
                        $command_done = true;
                }
                else
                {
                        $command_line_result_arr[] = hzm_format_command_line("error", "table $atable_name not found in module $currmod/$idMod");
                        $nb_errors++;$command_finished = true;return;
                }
        }

        
        
    }
    else
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "action $action not found for goal command");
        $nb_errors++;$command_finished = true;return;
    }

    
}