<?php
class ClineUtils
{
    public static function systemCommandFormat($system_command, $vars)
    {
        $parent_project_path = AfwSession::config("parent_project_path", "");
        
        $system_command = str_replace("[project_path]", $parent_project_path, $system_command);
        foreach($vars as $var_name => $var_value)
        {
            $system_command = str_replace("[$var_name]", $var_value, $system_command);
        }
        


        return $system_command;
    }
    public static function systemCommand($system_command, $vars)
    {
        
        $system_command = ClineUtils::systemCommandFormat($system_command, $vars);
        // here to add some security to prevent bad developers to make catastrophe
        // @todo
        $output=null;
        $retval=null;
        $res = exec($system_command, $output, $retval);
        return [$res, $retval, $output];
    }

    public static function similarCommand($command_to_help, $command_similar)
    {
        return (!$command_to_help) or ($command_to_help == $command_similar);
    }

    public static function formatCommand($command_code)
    {
        $command_code_option = "";
        if ($command_code == "help") {
            // nothing to do
        }

        if (($command_code == "curr") or ($command_code == "use") or ($command_code == "curm") or ($command_code == "currm")) {
            $command_code = "curr_mod";
        }

        if (($command_code == "ct") or ($command_code == "cut") or ($command_code == "curt") or ($command_code == "currt")) {
            $command_code = "curr_tbl";
        }

        if (($command_code == "cf") or ($command_code == "cuf") or ($command_code == "curf") or ($command_code == "currf")) {
            $command_code = "curr_fld";
        }

        if ($command_code == "get") {
            $command_code = "list";
        }




        if ($command_code == "find") {
            // nothing to do
        }

        if (($command_code == "ls")  or ($command_code == "lst")) {
            $command_code = "list";
        }

        if ($command_code == "reverse") {
            // nothing to do
        }

        if (($command_code == "rep") or ($command_code == "rp") or ($command_code == "r")) {
            $command_code = "repare";
        }

        if (($command_code == "rev") or ($command_code == "rv") or ($command_code == "v")) {
            $command_code = "reverse";
        }

        if (($command_code == "+l") or ($command_code == "++") or ($command_code == "+++") or ($command_code == "+v") or ($command_code == "+")) {
            $command_code = "add";
            if (($command_code == "+l") or ($command_code == "++")) $command_code_option = "light";
            if (($command_code == "+v") or ($command_code == "+++")) $command_code_option = "very-light";
        }

        if (($command_code == "upgr") or ($command_code == "upg") or ($command_code == "up")or ($command_code == "u")) {
            $command_code = "upgrade";
        }

        

        if (($command_code == "show") or ($command_code == "view") or ($command_code == "more")) {
            $command_code = "show";
        }

        if (($command_code == "gen") or ($command_code == "genere") or ($command_code == "g")) {
            $command_code = "generate";
        }

        if ($command_code == "retrieve") {
            // nothing to do             
        }

        return [$command_code, $command_code_option];
    }

    public static function parse_table_and_module($object_module_table)
    {
        $object_module_table = strtolower($object_module_table);

        if ($object_module_table == "module") {
            $object_table = "module";
            $object_module = "ums";
        } elseif ($object_module_table == "m") {
            $object_table = "module";
            $object_module = "ums";
        } elseif ($object_module_table == "table") {
            $object_table = "atable";
            $object_module = "pag";
        } elseif ($object_module_table == "t") {
            $object_table = "atable";
            $object_module = "pag";
        } elseif ($object_module_table == "field") {
            $object_table = "afield";
            $object_module = "pag";
        } elseif ($object_module_table == "f") {
            $object_table = "afield";
            $object_module = "pag";
        } elseif ($object_module_table == "domain") {
            $object_table = "domain";
            $object_module = "pag";
        } elseif ($object_module_table == "d") {
            $object_table = "domain";
            $object_module = "pag";
        } elseif ($object_module_table == "goal") {
            $object_table = "goal";
            $object_module = "bau";
        } elseif ($object_module_table == "g") {
            $object_table = "goal";
            $object_module = "bau";
        } else {
            list($object_table, $object_module) = explode(".", $object_module_table);
        }

        return array($object_table, $object_module);
    }


    public static function generatePhpFile($module_code, $fileName, $php, $subFolder)
    {
        $php_generation_folder = AfwSession::config("php_generation_folder", "C:/gen/php");
        $dir_sep = AfwSession::config("dir_sep", "/");
        $root_www_path = AfwSession::config("parent_project_path", "C:/dev-folder");
        $merge_tool = AfwSession::config("merge_tool", "ex winmerge");
        $mv_command = AfwSession::config("mv_command", "mv");
        $command_lines_arr = []; 
        if($php_generation_folder!="no-gen")
        {
            $generated_fileName = $php_generation_folder . $dir_sep . $fileName;
            try{
                AfwFileSystem::write($generated_fileName, $php);
                
            }
            catch(Exception $e)
            {
                $command_lines_arr[] = hzm_format_command_line("error", "failed to write php file $generated_fileName\n");
            }
            finally
            {
                $root_module_path = $root_www_path. $dir_sep . $module_code . $dir_sep . $subFolder;
                $destination_fileName = $root_module_path . $dir_sep . $fileName;
                $command_lines_arr[] = hzm_format_command_line("info", "php file $fileName has been generated under $php_generation_folder \n");
                $command_lines_arr[] = hzm_format_command_line("info", "  to install the file :");
                $command_lines_arr[] = hzm_format_command_line("info", "  if the file is not new use your merge tool $merge_tool and do the following command to merge manually : ");
                $command_lines_arr[] = hzm_format_command_line("help", "  $merge_tool $generated_fileName $destination_fileName <br>\n");
                $command_lines_arr[] = hzm_format_command_line("info", "  if the file not do the following command line manually : ");
                $command_lines_arr[] = hzm_format_command_line("help-mv", "  $mv_command $generated_fileName $root_module_path <br>\n");
                $mv_command_line = "$mv_command $generated_fileName $root_module_path";
            }
            
        }
        else
        {
            $command_lines_arr[] = hzm_format_command_line("warning", "  file generation disable");
        }

        return [$command_lines_arr, $mv_command_line];
    }


    public static function makeReplacements($text, $currmod)
    {        
        $file_dir_name = dirname(__FILE__);
        $cline_replacements = include("$file_dir_name/../$currmod/extra/cline_replacements.php");

        foreach($cline_replacements as $substr => $rowSubstr)
        {
            

            $substrclass = $rowSubstr["class"];
            if($substrclass)
            {
                $replace_str = "<span class='cline-rep $substrclass'>$substr</span>";
                $text = str_replace($substr, $replace_str, $text);
            }

            $substradd = $rowSubstr["add"];
            if($substradd)
            {
                $replace_str = $substr.$substradd;
                $text = str_replace($substr, $replace_str, $text);
            }
        }

        return $text;
    }


    public static function correctSchedulingParams($text)
    {
        // @todo
        return true;
    }
}
