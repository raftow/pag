<?php
// upgrade [@action] [@what] @action-default is `show` @what-default is `all`
// 
// example 1 : upgrade [show] [all] : show all migrations
// example 1.1 : upgrade show done : show done migrations
// example 1.2 : upgrade show todo : show todo migrations
// example 2 : upgrade run [all] : upgrade by running all the todo migrations
// example 3 : upgrade run 00005 : run the migration 00005 if not already done
// example 4 : upgrade ignore 00005 : ignore the migration 00005 and make as it is already done manually

$command_action = $command_line_words[1];
$action_on_what = $command_line_words[2];
if(!$command_action) $command_action = "show";
if(!$action_on_what) $action_on_what = "all";

if(!$currmod) 
{
    $command_line_result_arr[] = hzm_format_command_line("error", "upgrade command need you to select the current module");
    $nb_errors++;$command_finished = true;return;
}

$objModule = Module::loadByMainIndex($currmod);

$command_line_result_arr[] = hzm_format_command_line("info", "doing $command_action of $action_on_what migration(s)");

if($command_action == "show")
{
    $migrArr = Migration::getMigrations($objModule->id, $currmod, $action_on_what);
    $odd_oven = "oven";
    foreach($migrArr as $migrCode => $migrRow)
    {
        $migration_code = $migrRow['code'];
        //@todo compile migration and get errors
        $dataErrors = $migrRow['error'];

        if($dataErrors) $errorClass = "error";
        else $errorClass = "success";
        if(!$dataErrors) $dataErrors = "no errors";
        
        $title = $migrRow['title'] . " by " . $migrRow['by'];

        $command_line_result_arr[] = hzm_object_command_line("info", $odd_oven, $migration_code, $title, $dataErrors, $errorClass, $lang);
        if($odd_oven != "odd") $odd_oven = "odd";
        else $odd_oven = "oven";
        unset($oneObj);
    }
}

$stop_if_error = true;
if($command_action == "force")
{
    $command_action = "run";
    $stop_if_error = false;
}

if(($command_action == "run") or ($command_action == "ignore"))
{
    $doneIcon = "<img src=\"../lib/images/done.png\" width=\"24\" heigth=\"24\">";
    $errorIcon = "<img src=\"../lib/images/status_error.png\" width=\"24\" heigth=\"24\">";
    $warningIcon = "<img src=\"../lib/images/warning.png\" width=\"24\" heigth=\"24\">";
    if($action_on_what == "all") $action_on_what = "todo";
    $migrArr = Migration::getMigrations($objModule->id, $currmod, $action_on_what);
    $odd_oven = "oven";
    foreach($migrArr as $migrRow)
    {
        $auser_id = $migrRow['by_id'];
        $title = $migrRow['title'];
        $migrCode = $migrRow['code'];
        if($command_action == "run")
        {
            // die("Migration::runMigration($objModule->id, $currmod, $migrCode, $title, $auser_id)");
            list($error, $info, $warning, $tech) = Migration::runMigration($objModule->id, $currmod, $migrCode, $title, $auser_id);
        }
        else
        {
            // die("Migration::runMigration($objModule->id, $currmod, $migrCode, $title, $auser_id)");
            list($error, $info, $warning, $tech) = Migration::ignoreMigration($objModule->id, $currmod, $migrCode, $title, $auser_id);
        }
        $title = $migrRow['title'] . " by " . $migrRow['by'];
        if($error) 
        {
            $resultIcon = $errorIcon; 
            $errorClass = "error";
            $title .= " failed !!";
            $dataErrors = "see error below";
        } 
        elseif($warning) 
        {
            $resultIcon = $warningIcon; 
            $errorClass = "warning";
        }
        else
        {
            $resultIcon = $doneIcon; 
            $errorClass = "info";
        } 
        

        $command_line_result_arr[] = hzm_object_command_line($errorClass, $odd_oven, $resultIcon, $title, $dataErrors, $errorClass, $lang);
        if($info) $command_line_result_arr[] = hzm_object_command_line("info", $odd_oven, $doneIcon, $info, "", $errorClass, $lang);
        if($error) $command_line_result_arr[] = hzm_object_command_line("error", $odd_oven, $errorIcon, $error, "", $errorClass, $lang);
        if($warning) $command_line_result_arr[] = hzm_object_command_line("warning", $odd_oven, $warningIcon, $warning, "", $errorClass, $lang);
        if($tech) $command_line_result_arr[] = hzm_object_command_line("tech", $odd_oven, $migrCode, $tech, "", $errorClass, $lang);

        if($odd_oven != "odd") $odd_oven = "odd";
        else $odd_oven = "oven";
        unset($oneObj);

        if($error and $stop_if_error) break;
    }
}

$command_done = true;
$command_finished = true;