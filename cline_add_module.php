<?php
    
    if(!$parent_project_path)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "Please add parent_project_path config variable in your system config");
        $nb_errors++;$command_finished = true;return;
    }

    $module_code = $object_code_arr[0];
    if($module_code)
    {
        if((!$restriction) or $restriction=="paths")
        {
            $objModule = Module::loadByMainIndex($module_code);

            $sys_commands_for_new_module_arr = include("cline_new_module_sys_cmd.php");
            $vars = [];
            $vars["module_code"] = $module_code;
            foreach($sys_commands_for_new_module_arr as $system_command)
            {                
                list($res, $retval, $output) = ClineUtils::systemCommand($system_command, $vars);
                if(!$res)
                {
                    $command_line_result_arr[] = hzm_format_command_line("warning", "system command $system_command failed with ret=$retval output=".var_export($output,true));
                    $nb_warnings++;
                }
            }

            // @todo auto - generation of :
            // application_config.php
            $command_line_result_arr[] = hzm_format_command_line("warning", "generate application_config.php");
            $nb_warnings++;
            
            // module_config.php
            $command_line_result_arr[] = hzm_format_command_line("warning", "generate module_config.php for dev purpose to remove");
            $nb_warnings++;

            // xxxx_start.php
            $command_line_result_arr[] = hzm_format_command_line("warning", "generate $module_code"."_start.php for dev purpose to remove");
            $nb_warnings++;
            

        }
        
        if((!$restriction) or $restriction=="ini")
        {
            $command_line_result_arr[] = hzm_format_command_line("info", "generating ini.php file : ");
            $phpIni = $objModule->genereIniPhpFile();
            
            $command_line_result_arr[] = hzm_format_command_line("php", $phpIni, "en", "cline php struct");
        }
        
        
        

    }
    elseif(!$module_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "add command need the module code !! object_code=$object_code");
        $nb_errors++;$command_finished = true;return;
    }


