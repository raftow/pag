<?php
  if($loopCount>1)
  {
    $command_finished = true;
    AfwRunHelper::safeDie("loopArr= ".var_export($loopArr,true)."command_line_result_arr= ".var_export($command_line_result_arr,true));
  }
   $LOOP_MAX = 5;
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

   $loopCount = 0;
   $loopArr = [];
   
   if($command_line)
   {
      $loadByCodeArr = array();
      $loadByCodeArr["module"] = true;
      $loadByCodeArr["atable"] = true;
      $loadByCodeArr["afield"] = true;



      
      
      $command_line_words = explode(" ", $command_line);
      $command_code = $command_line_words[0];
      
      $command_done = false;
      $command_finished = false;
      
      $command_code = ClineUtils::formatCommand($command_code);
      //die("command_code=$command_code");
      
      while(!$command_finished)
      {
        $file_dir_name = dirname(__FILE__); // becuase after the below include $file_dir_name may change        
        $cmd_file_path = "$file_dir_name/cline_$command_code.php";
        $loopArr[] = $cmd_file_path;
        // die($cmd_file_path);
        include $cmd_file_path;
        //die("command_code=$command_code");
        //echo $cmd_file_path;
        $loopCount++;
        if($loopCount>$LOOP_MAX)
        {
          $command_finished = true;
          AfwRunHelper::safeDie("loopArr= ".var_export($loopArr,true)."command_line_result_arr= ".var_export($command_line_result_arr,true));
        }
      }
      
      if(!$command_done)
      {
          $command_line_result_arr[] = hzm_format_command_line("warning", "The command $command_code has failed !");
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
          $command_line_result_arr[] = "<div class='tamakkan_hiostory'><div class='tamakkan_rt'>$kord. Momken> </div> " .hzm_format_command_line($log_hist_class, $hist_item)."</div>";
      }
   }
   $hist = implode("\n", $hist_arr);
   $data_tokens = array();
   
   $html_template_file = "$file_dir_name/tpl/cline_tpl.php";
   $data_tokens["command_line_result"] = implode("<br>\n",$command_line_result_arr);
   $data_tokens["newsug_command_line"] = $data_token_new_suggested_command_line;
   $data_tokens["currmod"] = $currmod;
   /*
   if($objAtable) 
   {
        $currtbl = $objAtable->id;
        $currtbl_code = $objAtable->getVal("atable_name");
   }
   else
   {
        $currtbl = 0;
        $currtbl_code = "";
   }
  */ 
   $data_tokens["currtbl"] = $currtbl;
   $data_tokens["currtbl_code"] = $currtbl_code;
   $data_tokens["currobj"] = $currobj;
   $data_tokens["currfld"] = $currfld;
   if($currmod) 
   {
        $context = $currmod;
        if($currtbl_code) $context .= "." . $currtbl_code;
        else $context .= ".*";
   }     
   else $context = "Momken";


   $data_tokens["context"] = $context;

   $data_tokens["hist"] = $hist;
   // die("data_tokens=".var_export($data_tokens,true));             
   echo showUsingHzmTemplate($html_template_file, $data_tokens);
   
   
   
?>
