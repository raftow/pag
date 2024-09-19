<?php

function afw_struct_array($arr)
{
        $return = var_export($arr,true);
        
        $return = str_replace('\n',' ', $return);
        $return = str_replace('\r',' ', $return);
        // die("xp=$return");
        return $return;
}

function getPhpAfwAttribute($db_structure, $field_name)
{
        global $lang;
        
        // $scis = $mytable->get("scis");
        // list($phpDesc,$php_errors) = $this->generePhpDesc($scis);
        $fn = "'".$field_name."' => array(";
        $tempRdesc = array();
        $no_css_width = true;
        if(empty($db_structure[$field_name])) die("empty db_structure[$field_name] => ".var_export($db_structure,true));
        foreach($db_structure[$field_name] as $prop => $val)
        {
                if($prop=='CSS') $no_css_width = false;
                if($prop=="DEFAULT") $prop="DEFAUT";
                
                if(($val === true) or ($val === false))
                {
                        if($val === true)  array_push($tempRdesc, "'$prop' => true, ");
                        if($val === false) array_push($tempRdesc, "'$prop' => false, ");
                }
                elseif(is_array($val))
                {
                        array_push($tempRdesc, "\n\t\t\t\t'$prop' => ".afw_struct_array($val).", ");
                }
                elseif(is_numeric($val) and ($prop != "TYPE"))
                {
                        array_push($tempRdesc, "'$prop' => $val, "); 
                }
                elseif(($prop=="TYPE") or ($prop=="RELATION") or ($prop=="SIZE") or ($prop=="CATEGORY") or ($prop=="CSS") or ($prop=="DISPLAY-UGROUPS"))
                {
                        array_push($tempRdesc, "\n\t\t\t\t'$prop' => '$val', ");
                }
                elseif(($prop=="WHERE") or ($prop=="WHERE-SEARCH")  or ($prop=="FIELD-FORMULA") or ($prop=="HELP"))
                {
                        array_push($tempRdesc, "\n\t\t\t\t'$prop' => \"$val\", \n\t\t\t\t");
                }                                
                elseif(($prop=="TYPE") or ($prop=="DEPENDENCIES") or ($prop=="DEPENDENT_OFME"))
                {
                        array_push($tempRdesc, "\n\t\t\t\t'$prop' => '$val', \n\t\t\t\t");
                }
                else
                {
                        array_push($tempRdesc, "'$prop' => '$val', ");
                }
                
        }

        $fn .= implode(" ", $tempRdesc);
        if($no_css_width) $fn .= "\n\t\t\t\t'CSS' => 'width_pct_100',";
        $fn .= "),\n";


        return $fn; 
}

function getPhpOfDbStructure($mytable, $myObj, $module_code)
{
        if($myObj->IS_LOOKUP)
        {
                $fld_active_qedit = "true";
                $fld_active_edit = "true";
        }
        else 
        {
                $fld_active_qedit = "false";
                $fld_active_edit = "false";
        }
        
        $fld_creation_user_id   = $myObj->fld_CREATION_USER_ID();
        $fld_creation_date      = $myObj->fld_CREATION_DATE();
        $fld_update_user_id     = $myObj->fld_UPDATE_USER_ID();
        $fld_update_date        = $myObj->fld_UPDATE_DATE();
        $fld_validation_user_id = $myObj->fld_VALIDATION_USER_ID();
        $fld_validation_date    = $myObj->fld_VALIDATION_DATE();
        $fld_active             = $myObj->fld_ACTIVE();
        $fld_version            = $myObj->fld_VERSION();

        $techFields = [$fld_creation_user_id, 
                        $fld_creation_date, 
                        $fld_update_user_id, 
                        $fld_update_date, 
                        $fld_validation_user_id, 
                        $fld_validation_date, 
                        $fld_version, 
                        "update_groups_mfk",                        
                        "delete_groups_mfk",
                        "display_groups_mfk",
                        "sci_id",
                        "tech_notes",
                ];

        
        $db_structure = $myObj::getDbStructure($return_type="structure", $attribute = "all"); 
        $draft_disable = $db_structure["draft"] ? "" : "//"; 
        if($mytable) $tabName = $mytable->getVal("atable_name");
        else return "error : define table first";

        $classPrefix = ucfirst($module_code).$myObj->getMyClass();
        $tempTdesc = array();
        foreach($db_structure as $field_name => $struct0)
        {
                if(!in_array($field_name, $techFields))
                {
                        if(!$struct0["CATEGORY"]) $tabulation_additionelle = "\t";
                        else $tabulation_additionelle = "";
                        
                        $RDesc = $tabulation_additionelle.getPhpAfwAttribute($db_structure, $field_name);
                        array_push($tempTdesc, $RDesc);         
                }
        }

        


        $TDesc = "\n\t\t".implode("\n\t\t", $tempTdesc);
        // 'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

        $php_struct = "
<?php 
        class ${classPrefix}AfwStructure
        {
                public static \$DB_STRUCTURE = array(

                        ".$TDesc."
                        '$fld_creation_user_id'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        '$fld_creation_date'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),

                        '$fld_update_user_id'           => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        '$fld_update_date'              => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),

                        '$fld_validation_user_id'       => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        '$fld_validation_date'          => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),

                        /* '$fld_active'                   => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => $fld_active_edit, 
                                                                'QEDIT' => $fld_active_qedit, \"DEFAULT\" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),*/

                        '$fld_version'                  => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),

                        $draft_disable 'draft'                         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => $fld_active_edit, 
                        $draft_disable                                        'QEDIT' => $fld_active_qedit, \"DEFAULT\" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),

                        'update_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'delete_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'display_groups_mfk'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'sci_id'                        => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', \"SHOW-ADMIN\" => true, 
                                                                'TOKEN_SEP'=>\"§\", 'READONLY'=>true, \"NO-ERROR-CHECK\"=>true, 'FGROUP' => 'tech_fields'),
                ); 
        } 
?>";


        return array($php_struct, "");
}

require_once ("afw_rights.php");
require_once ("afw_config.php");
include_once "$file_dir_name/../geshi/geshi.php";

$myModule = new Module();
$myModule->load($mod);
$out_scr = "astruct will work on module : ".$myModule->getDisplay($lang);
$mod_code = $myModule->getVal("module_code");

AfwAutoLoader::addModule($mod_code);
require_once ("$file_dir_name/../../external/config.php");
$struct_dir = $START_GEN_TREE."/$mod_code/struct";
$arrTables = $myModule->getMyAllTables();

foreach($arrTables as $idTable => $tabObj)
{
        $cl = $tabObj->getTableClass();
        $tab_name = $tabObj->valAtable_name();
        $php_file_name = "$file_dir_name/../$mod_code/$tab_name.php";
        if(file_exists($php_file_name))
        {
                // die("php_file_name=$php_file_name");
                // require_once $php_file_name;
                $myObj = new $cl();
                
                list($strcucture_php, $info) = getPhpOfDbStructure($tabObj, $myObj, $mod_code);

                if($info) AfwSession::pushInformation($info);

                // generate file
                
                $fileName = $tab_name."_afw_structure.php";
                $fileFullName = $struct_dir."/".$fileName;
                AfwFileSystem::write($fileFullName, $strcucture_php);
                // output on screen
                if(($cl == $cls) or ("all" == $cls))
                {
                        
                        // $language = 'php';
                        // $geshi = new GeSHi($strcucture_php, $language);
                        // $ss = $geshi->parse_code();
                        $out_scr .= "<br><br><br><br><br><br><textarea>$strcucture_php</textarea>";
                }
                else
                {
                        $out_scr .= "$cl structure generation done to $fileFullName<br>";
                }
        }
        else
        {
                $out_scr .= "$php_file_name not found<br>";
        }

        
}
/*

$tabObj->debugg_curr_step = 4;
$out_scr .=  AfwShowHelper::showObject($tabObj,"edit");
*/

?> 