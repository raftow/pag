<?php

    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code with restriction = [$restriction]");

    $command_what_to_do = $command_line_words[1];
    if($command_what_to_do=="r") $command_what_to_do = "erase";
    if($command_what_to_do=="replace") $command_what_to_do = "erase";
    if($command_what_to_do=="a") $command_what_to_do = "add";
    if($command_what_to_do=="+") $command_what_to_do = "add";
    if($command_what_to_do=="e") $command_what_to_do = "update";
    if($command_what_to_do=="u") $command_what_to_do = "update";
    if($command_what_to_do=="edit") $command_what_to_do = "update";
    if($command_what_to_do=="l") $command_what_to_do = "list";

    if($command_what_to_do == "list")
    {
        $command_line_words[2] = 1;
        $command_line_words[3] = "*";
    }
    
    
    
    $command_bf_id = $command_line_words[2];
    /*
    if($command_bf_id != 1)
    {
        $objBF = Bfunction::loadById($command_bf_id);
        if((!$objBF) or (!objBF->id))
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "cron command need the correct BF-ID of your script !! The object is not found for ID = $command_bf_id");
            $nb_errors++;$command_finished = true;return;
        }
    }
    
    */

    

    $command_sched = $command_line_words[3];


    
    
    if((!$command_what_to_do) or (!in_array($command_what_to_do,["erase","add","update","list","run"])))
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "cron command need a correct action todo !! value given $command_bf_id is not correct should be from erase/add/update choices");
        $nb_errors++;$command_finished = true;return;
    }
    elseif((!$command_bf_id) or (!is_numeric($command_bf_id)))
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "cron command need the correct BF-ID of your script !! value given $command_bf_id is not correct");
        $nb_errors++;$command_finished = true;return;
    }
    elseif((!$command_sched) or (!ClineUtils::correctSchedulingParams($command_sched)))
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "cron command need the correct scheduling params for your script !! value given $command_sched is not correct");
        $nb_errors++;$command_finished = true;return;
    }
    else
    {
        $shell_to_show = [];
        $script_to_run = "/var/www/adm/batchs/adm_app_simulator_job.sh";
        $log_path = "/var/www/adm/log/";
        $run_path = "/var/www/adm/batchs/";
        $command_line_result_arr[] = hzm_format_command_line("info", "preparing scripts and log privileges ... ");
        $shell_to_show[] = $shell_to_run = 'chmod 777 '.$log_path;
        $shell_to_show[] = shell_exec($shell_to_run);
        $shell_to_show[] = $shell_to_run = 'chmod 777 '.$script_to_run;
        $shell_to_show[] = shell_exec($shell_to_run);
        $shell_to_show[] = $shell_to_run = 'ls -l '.$log_path;
        $shell_to_show[] = shell_exec($shell_to_run);
        $shell_to_show[] = $shell_to_run = 'ls -l '.$run_path;
        $shell_to_show[] = shell_exec($shell_to_run);
        
        
        
        
        
        if($command_what_to_do=="add")
        {
            // { crontab -l; echo "30 * * * * /path_to/script/"; } | crontab -
        }
        elseif($command_what_to_do=="erase")
        {
            // replace/erase
            
            $shell_to_show[] = $shell_to_run = '{echo "30 * * * * '.$script_to_run.'"; } | crontab - ';
            $shell_to_show[] = shell_exec($shell_to_run);
        }
        elseif($command_what_to_do=="list")
        {
            $shell_to_show[] = $shell_to_run = 'crontab -l';
            $shell_to_show[] = shell_exec($shell_to_run);
        }
        elseif($command_what_to_do=="run")
        {
            $shell_to_show[] = $shell_to_run = $script_to_run;
            $shell_to_show[] = shell_exec($shell_to_run);
        }

        
        $command_line_result_arr[] = hzm_format_command_line("cmd", implode("\n", $shell_to_show), "en", "cline cmd");
    }
    

    $command_done = true;
    $command_finished = true;

