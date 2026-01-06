<?php
$goal_id = $object_code_arr[0];
if ($goal_id) {
    $goalObj = Goal::loadById($goal_id);


    if ($goalObj) {
        $moduleObj = $goalObj->het('module_id');
        if ($moduleObj) {
            $moduleCode = $moduleObj->getVal("module_code");
            $jobGoalCode = $goalObj->valCode();
            $role_code = "goal-$jobGoalCode";
            $aroleObj = Arole::loadByMainIndex($goalObj->getVal('module_id'), $role_code);
            if ($aroleObj) {
                if ((!$restriction) or $restriction == "previleges") {
                    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating previleges for goal $goal_id : ");
                    list($role_infoItem, $fileName, $php_code, $mv_cmd) = UmsManager::genereRolePrevilegesFile($moduleCode, $aroleObj, true);
                    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generated : $fileName : ");
                    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("php", $php_code, "en", "cline goal previleges php");
                    $mv_cmd_lines[] = $mv_cmd;
                }
            }
        }
    }
}
if (!$goal_id or !$goalObj or !$aroleObj) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "generate command need the goal id !! object_code=$object_code goalObj=$goalObj aroleObj=$aroleObj");
    $nb_errors++;
    $command_finished = true;
    return;
}
