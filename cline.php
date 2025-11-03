<?php
  $immediate_output = false;
  $LOOP_MAX = 5;
  if(!$lang) $lang = "ar";
  $file_dir_name = dirname(__FILE__);
  $command_line_result_arr = array();
  require_once("$file_dir_name/../lib/afw/afw_utils.php");
  


  if($clinego and (!$command_line))
  {
    $command_line_result_arr[] = hzm_format_command_line("error", "No command line written"); $nb_errors++;$command_finished = true;
  }

  AfwAutoloader::addMainModule('pag');
  AfwAutoloader::addMainModule('bau');

  $objme = AfwSession::getUserConnected();
  if(!$objme)
  {
    $command_line_result_arr[] = hzm_format_command_line("error", "Your are not logged in !!"); $nb_errors++;$command_finished = true;
    $command_line = "";
  }
  else
  {
    // die(var_export($objme, true));
  }

  
  /*
  if($loopCount>1)
  {
    $command_finished = true;
    AfwRunHelper::safeDie("loopArr= ".var_export($loopArr,true)." command_line_result_arr= ".var_export($command_line_result_arr,true));
  }*/

  if($command_line)
  {
      
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
   
      // short commands
      if($command_line=="usa") $command_line = "upgrade show all";
      if($command_line=="ust") $command_line = "upgrade show todo";
      if($command_line=="urtodo") $command_line = "upgrade run todo";
      
      if($command_line=="l") $command_line = "list all fields";
      if($command_line=="lf") $command_line = "list all fields";
      if($command_line=="lv") $command_line = "list virtual fields";
      if($command_line=="lt") $command_line = "list all tables";
      if($command_line=="lg") $command_line = "list all goals";
      if($command_line=="lj") $command_line = "list all jobs";
      if($command_line=="lr") $command_line = "list all roles";
      if($command_line=="ll") $command_line = "list all levels";
      if($command_line=="lb") $command_line = "list all bfs";
      
      
      if($command_line=="sm") $command_line = "show module";
      if($command_line=="st") $command_line = "show table";
      if($command_line=="sf") $command_line = "show field";
      if($command_line=="gm") $command_line = "g module";
      if($command_line=="gt") $command_line = "g table";
      if($command_line=="gf") $command_line = "g field";
      if($command_line=="sql") $command_line = "g-sql table";
      if($command_line=="revall") $command_line = "reverse-erase module";
      
   
      $command_line = trim($command_line);
      // ignore double space
      $command_line = str_replace("   ", " ", $command_line);
      $command_line = str_replace("  ", " ", $command_line);
      $command_line = str_replace("  ", " ", $command_line);
      $command_line = str_replace("  ", " ", $command_line);

      $command_line_words = explode(" ", $command_line);
      
      list($command_code, $restriction) = explode("-", $command_line_words[0]);
      
      $command_done = false;
      $command_finished = false;
      $original_command_code = $command_code;
      list($command_code, $command_code_option) = ClineUtils::formatCommand($command_code);

      $modeSuperDeveloper = AfwSession::config("super-dev", true);
      // die("modeSuperDeveloper=$modeSuperDeveloper");
      
      while(!$command_finished)
      {
        $file_dir_name = dirname(__FILE__); // becuase after the below include $file_dir_name may change        
        $cmd_file_path = "$file_dir_name/cline_$command_code.php";
        $loopArr[] = $cmd_file_path;
        // die($cmd_file_path);
        try
        {
          if(!file_exists($cmd_file_path))
          {
            // throw new AfwRuntimeException("the command line $command_code not found");
            $command_line_result_arr[] = hzm_format_command_line("error", "the command $command_code not found"); $nb_errors++;
            $command_finished = true;
          }
          else include $cmd_file_path;
        }
        catch(Exception $e)
        {
            if($modeSuperDeveloper) throw $e;
            $command_line_result_arr[] = hzm_format_command_line("error", $e->getMessage()); $nb_errors++;
            $command_finished = true;
        }
        catch(Error $e)
        {
            $command_line_result_arr[] = hzm_format_command_line("error", $e->__toString()); $nb_errors++;
            $command_finished = true;
        } 
        
        //die("command_code=$command_code");
        //echo $cmd_file_path;
        $loopCount++;
        if($loopCount>$LOOP_MAX)
        {
          $command_finished = true;
          throw new RuntimeException("loopArr= ".var_export($loopArr,true)."command_line_result_arr= ".var_export($command_line_result_arr,true));
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
      
      $command_line_hist_arr = [];
      $command_line_hist_arr[] = hzm_format_command_line("normal", "Your command history : ");
      
      $log_hist_class = "";
      
      $hist_toshow_arr = array_reverse($hist_arr);
      foreach($hist_toshow_arr as $hord => $hist_item)
      {
          if($log_hist_class != "log_odd") $log_hist_class = "log_odd"; else $log_hist_class = "log";
          $kord = count($hist_arr) - $hord;
          $command_line_hist_arr[] = "<div class='tamakkan_hiostory'>
              <div class='tamakkan_rt'>
                  <span class='bcounter' id='bcounter-$kord'>$kord</span> 
              </div> " .hzm_format_command_line($log_hist_class, $hist_item, "en", false, false, $kord, "hist")."</div>";
      }

      $hist = implode("\n", $hist_arr);
   }
   
   $data_tokens = array();

   $file_dir_name = dirname(__FILE__);
   $html_template_file = "$file_dir_name/tpl/cline_tpl.php";
   $data_tokens["command_line_result"] = "";
   foreach($arr_cmd_lines as $cmd_group => $cmd_lines)
   {
      $data_tokens["command_line_result"] .= "<div class='cmdgroup'>$cmd_group</div><br>\n";
      $data_tokens["command_line_result"] .= implode("<br>\n", $cmd_lines);
   }
   $data_tokens["command_line_result"] .= implode("<br>\n",$command_line_result_arr);
   
   $data_tokens["command_line_history"] = "";
   if(is_array($command_line_hist_arr)) $data_tokens["command_line_history"] .= implode("\n",$command_line_hist_arr);
   
   // die("arr_cmd_lines = ".var_export($arr_cmd_lines, true));
   
   //die("data_tokens = ".var_export($data_tokens, true));
   $data_tokens["newsug_command_line"] = $data_token_new_suggested_command_line;
   $data_tokens["currmod"] = $currmod;
    
   $data_tokens["currtbl"] = $currtbl;
   $data_tokens["currtbl_code"] = $currtbl_code;
   $data_tokens["currobj"] = $currobj;
   $data_tokens["currfld"] = $currfld;
   $data_tokens["currfld_id"] = $currfld_id;
   $data_tokens["db_prefix"] = AfwSession::currentDBPrefix();
   if($currmod) 
   {
        $context = $currmod;
        if($currtbl_code) $context .= "." . $currtbl_code;
        else $context .= ".*";
   }     
   else $context = "Momken";


   $data_tokens["context"] = $context;

   $data_tokens["hist"] = $hist;
   
   echo showUsingHzmTemplate($html_template_file, $data_tokens);
   
   echo "<div id='analysis_log'><div class=\"fleft\"><h1><b>System LOG activated :</b></h1></div><br><br>";
   echo "_sql_picture=".var_export($_sql_picture, true)."<br>";
   echo AfwSession::getLog();
  
   echo "</div>";