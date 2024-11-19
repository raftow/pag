<?php
$struc = "applicant_api_request
applicant_id	1					N	integer	المتقدم	The applicant	UK	OneToMany
api_endpoint_id	2					N	integer	الخدمة الالكترونية	Api	UK	
run_date	3					N	date	تاريخ  التنفيذ	Run Date		
need_refresh	4					N	CHAR(1)	يحتاج تحديث	need refresh		";


// main.php?Main_Page=afw_mode_edit.php&cl=Domain&currmod=pag&id=25
$module = null;
if(isset($_GET["m"])) $module = $_GET["m"];
if(!$module) die("please set module ex icode.php?m=adm");
$direct_dir_name = $file_dir_name = dirname(__FILE__);
$start_file = "$file_dir_name/../$module/$module"."_start.php";
if(!file_exists($start_file))
{
      die("please define your start file $start_file");
}

include($start_file);

$actv_fld = $TECH_FIELDS[$MODULE]["ACTIVE_FIELD"];
$cre_u_id = $TECH_FIELDS[$MODULE]["CREATION_USER_ID_FIELD"]; 
$cre_date = $TECH_FIELDS[$MODULE]["CREATION_DATE_FIELD"]; 
$mod_u_id = $TECH_FIELDS[$MODULE]["UPDATE_USER_ID_FIELD"]; 
$mod_date = $TECH_FIELDS[$MODULE]["UPDATE_DATE_FIELD"]; 
$val_u_id = $TECH_FIELDS[$MODULE]["VALIDATION_USER_ID_FIELD"]; 
$val_date = $TECH_FIELDS[$MODULE]["VALIDATION_DATE_FIELD"]; 
$ver_fld = $TECH_FIELDS[$MODULE]["VERSION_FIELD"];

$moduleFUC = AfwStringHelper::firstCharUpper($module);



$phpTemplate = "<?php
        class [CLASS_NAME] extends $moduleFUC"."Object{

                public static \$DATABASE		= \"\"; 
                public static \$MODULE		    = \"$module\"; 
                public static \$TABLE			= \"[TABLE_NAME]\"; 
                public static \$DB_STRUCTURE = null;
                // public static \$copypast = true;

                public function __construct(){
                        parent::__construct(\"[TABLE_NAME]\",\"id\",\"$module\");
                        $moduleFUC"."[CLASS_NAME]AfwStructure::initInstance(\$this);
                        
                }

                public static function loadById(\$id)
                {
                        \$obj = new [CLASS_NAME]();
                        
                        if(\$obj->load(\$id))
                        {
                                return \$obj;
                        }
                        else return null;
                }

                public function getDisplay(\$lang = 'ar')
                {
                        return \$this->getDefaultDisplay(\$lang);
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

        }
?>


";

$uk_disable = "// ";
$df_disable = "";

$structTemplate = "<?php 
        class $moduleFUC"."[CLASS_NAME]AfwStructure
        {
        
                public static function initInstance(&\$obj)
                {
                        if (\$obj instanceof [CLASS_NAME]) 
                        {
                                \$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $df_disable \$obj->DISPLAY_FIELD = \"[TABLE_NAME]_name_ar\";
                                // \$obj->ORDER_BY_FIELDS = \"xxxx, yyyy\";
                                $uk_disable \$obj->UNIQUE_KEY = array([UK_ARR]);
                                // \$obj->public_display = true;
                                // \$obj->IS_LOOKUP = true;

                                \$obj->editByStep = true;
                                \$obj->editNbSteps = [STEPS]; 
                                // \$obj->after_save_edit = array(\"class\"=>'aconditionOriginType',\"attribute\"=>'acondition_origin_type_id', \"currmod\"=>'$module',\"currstep\"=>1);
                                \$obj->after_save_edit = array(\"mode\"=>\"qsearch\", \"currmod\"=>'adm', \"class\"=>'[CLASS_NAME]',\"submit\"=>true);
                        }
                        else 
                        {
                                [CLASS_NAME]ArTranslator::initData();
                                [CLASS_NAME]EnTranslator::initData();
                        }
                }
                
                
                public static \$DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        [FIELDS_STRUCT]


                                        '$actv_fld' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
        
                                        '$cre_u_id' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        '$cre_date' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        '$mod_u_id' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        '$mod_date' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        '$val_u_id' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        '$val_date' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        


                                        '$ver_fld'                  => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                        'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),

                                        'update_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                        'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                                        'delete_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                        'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                                        'display_groups_mfk'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                        'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                                        'sci_id'                        => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                        'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>";
                

$F_TEMPLATE = [];

$F_TEMPLATE["FK"] = "'[ANSWER_TABLE_NAME]_id' => array([FGROUP]'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'FK',  'ANSWER' => '[ANSWER_TABLE_NAME]',  'ANSMODULE' => '$module',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => [STEP],  'RELATION' => '[RELATION]', 'MANDATORY' => [MAND], 'READONLY'=>false, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_[PCT]', ),	
";

$F_TEMPLATE["MFK"] = "'[ANSWER_TABLE_NAME]_mfk' => array([FGROUP]'IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false, 'MANDATORY' => [MAND],  
        'TYPE' => 'MFK',  'ANSWER' => '[ANSWER_TABLE_NAME]',  'ANSMODULE' => '$module',    'DISPLAY' => true,  'STEP' => [STEP],  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_[PCT]',),

";

$F_TEMPLATE["TEXT"] = "'[FIELD_NAME]' => array([FGROUP]'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-[LANG]' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '[SIZE]', 'MAXLENGTH' => '[MAXLENGTH]', 'UTF8' => [UTF8],  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => [STEP], 'MANDATORY' => [MAND],  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_[PCT]',),
        
";

$F_TEMPLATE["TEXTAEREA"] = "'[FIELD_NAME]' => array([FGROUP]'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => [UTF8],  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => [STEP], 'MANDATORY' => [MAND],   
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_[PCT]',),        

";


$F_TEMPLATE["YN"] = "'[FIELD_NAME]' => array([FGROUP]'RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
        'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => [STEP], 'MANDATORY' => [MAND], 'QSEARCH' => false, 
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_[PCT]',),

";

$F_TEMPLATE["INT"] = "'[FIELD_NAME]' => array([FGROUP]
        'IMPORTANT' => 'IN',
        'SHOW' => true,
        'RETRIEVE' => false,
        'QEDIT' => true,
        'EDIT' => true,
        'TYPE' => 'INT', 'MANDATORY' => [MAND], 
        'STEP' => [STEP],
        'DISPLAY-UGROUPS' => '',
        'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_[PCT]',),

";

$F_TEMPLATE["FLOAT"] = "'[FIELD_NAME]' => array([FGROUP]
        'IMPORTANT' => 'IN',
        'SHOW' => true,
        'RETRIEVE' => false,
        'QEDIT' => true,
        'EDIT' => true,
        'SIZE' => 32, 
        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 'MANDATORY' => [MAND], 
        'STEP' => [STEP],
        'DISPLAY' => true,
        'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_[PCT]',),

";



$F_TEMPLATE["ENUM"] = "'[FIELD_NAME]' => array([FGROUP]'IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
        'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),	
";


$F_TEMPLATE["GDAT"] = "'[FIELD_NAME]' => [[FGROUP]
        'IMPORTANT' => 'IN',
        'SEARCH' => true,
        'SHOW' => true,
        'RETRIEVE' => true,
        'EDIT' => true,
        'QEDIT' => true,
        'SEARCH-ADMIN' => true,
        'SHOW-ADMIN' => true,
        'EDIT-ADMIN' => true,
        'UTF8' => false,
        'TYPE' => 'GDAT',
        'STEP' => [STEP],
        'DISPLAY-UGROUPS' => '',
        'EDIT-UGROUPS' => '',
        
        'CSS' => 'width_pct_25',
    ],
";


$F_TEMPLATE["TIME"] = "'[FIELD_NAME]' => [[FGROUP]
        'IMPORTANT' => 'IN',
        'SEARCH' => true,
        'SHOW' => true,
        'RETRIEVE' => true,
        'EDIT' => true,
        // 'READONLY' => true,
        'UTF8' => false,
        'TYPE' => 'TIME',
        // 'FORMAT' => 'CLOCK',
        // 'ANSWER_LIST' => '6/10/22',
        // 'ANSWER_METHOD'=>'getXXXTimeList', 'FORMAT' => 'OBJECT', 
        'DISPLAY' => true,
        'STEP' => [STEP],
        'DISPLAY-UGROUPS' => '',
        'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_25',
    ],
";


$F_TEMPLATE["DATE"] = "'[FIELD_NAME]' => array([FGROUP]'IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                'TYPE' => 'DATE',  'STEP' => [STEP],    'DISPLAY' => true, 'MANDATORY' => true, 
                                /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                'CSS' => 'width_pct_25',),
";


$F_TEMPLATE["::additional"] = "'[FIELD_NAME]' => array([FGROUP]'IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                'TYPE' => '::additional',  'STEP' => [STEP],    'DISPLAY' => true, 'MANDATORY' => true,                                 
                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                'CSS' => 'width_pct_50',),
";

$objme = AfwSession::getUserConnected();
//if(!$objme) $studentMe = AfwSession::getStudentConnected();
$studentMe = null;
if(!$lang) $lang = "ar";


$trad = "";

$struc_lines_arr = explode("\n", $struc);

$TABLE_NAME = strtolower(trim($struc_lines_arr[0]));
unset($struc_lines_arr[0]);
//unset($struc_lines_arr[1]);
$CLASS_NAME = AfwStringHelper::tableToClass($TABLE_NAME); 

$FIELDS_STRUCT_ARR = [];
$FIELDS_TRAD_ARR = [];



function oracleTypeToAfwType($field_name, $otype)
{
        $otype = strtoupper($otype);
        $otype = trim($otype);
        $otype = str_replace(" Byte", "", $otype);
        $otype = str_replace(" BYTE", "", $otype);
        $otype = trim($otype,")");

        list($otype, $osize) = explode("(", $otype);
        $otype = trim($otype);
        $afwType = "???";
        $maxlength = "";
        $utf8 = "true";
        $pct = "25";
        $lang = "";
        $tsize = "";
        
        if(($otype=="VARCHAR") or ($otype=="VARCHAR2")) 
        {
                $lang = "AR";
                $afwType = "TEXT";
                $maxlength = "";
                if($osize>255) 
                {
                        $tsize = "AEREA";
                        $asize = "AEREA";
                        $pct = "100";
                }
                else 
                {
                        $maxlength = $osize;
                        $asize = $maxlength;
                }

                if(($osize==8) and (AfwStringHelper::stringEndsWith($field_name,"_date")))
                {
                        $afwType = "DATE"; 
                        $maxlength = "";
                        $asize = "";
                } 

                if((($osize==5) or ($osize==8)) and (AfwStringHelper::stringEndsWith($field_name,"_time")))
                {
                        $afwType = "TIME"; 
                        $maxlength = "";
                        $asize = "";
                } 

                if(AfwStringHelper::stringEndsWith($field_name,"_en")) 
                {
                        $lang = "EN";
                        $utf8 = "false";
                }

                
                if(AfwStringHelper::stringEndsWith($field_name,"_mfk"))
                {
                        $afwType = "MFK"; 
                        $maxlength = "";
                        $asize = "";
                        $tsize = "";
                        $pct = "50";
                        $fk_table = substr($field_name,0,strlen($field_name)-4);                                                
                }

                
        }
        elseif(($otype=="CHAR") and ($osize=="1")) 
        {
                $afwType = "YN";
                $maxlength = "";
                $asize = "";
        }
        elseif($otype=="DATETIME")
        {
                $afwType = "GDAT";
                $maxlength = "";
                $asize = "";
        }
        elseif($otype=="DATE")
        {
                $afwType = "GDAT";
                $maxlength = "";
                $asize = "";
        }
        elseif($otype=="FLOAT" or $otype=="DECIMAL")
        {
                $afwType = "FLOAT";
                $maxlength = "";
                $asize = "";
        }
        elseif(($otype=="INTEGER") or ($otype=="NUMBER"))
        {
                $afwType = "INT";
                if(AfwStringHelper::stringEndsWith($field_name,"_id"))
                {
                        $afwType = "FK";
                        $fk_table = substr($field_name,0,strlen($field_name)-3);
                }

                if(AfwStringHelper::stringEndsWith($field_name,"_enum"))
                {
                        $afwType = "ENUM";
                        $fk_table = "FUNCTION";
                }

                

                $maxlength = "";
                $asize = "";
        }
        elseif($otype=="ADDITIONAL")
        {
                $afwType = "::additional";
                $maxlength = "";
                $asize = "";
        }
        
        
        /*elseif($this->getId()==AfwUmsPagHelper::$afield_type_int)
                return "";
        elseif($this->getId()==AfwUmsPagHelper::$afield_type_bigint)
                return "INT";
        elseif($this->getId()==AfwUmsPagHelper::$afield_type_nmbr)
                return "INT";
        elseif($this->getId()==AfwUmsPagHelper::$afield_type_enum)
                return "ENUM";
        elseif($this->getId()==AfwUmsPagHelper::$afield_type_enum)
                return "ENUM";
        elseif($this->getId()==AfwUmsPagHelper::$afield_type_menum)
                return "MENUM";
        elseif($this->getId()==AfwUmsPagHelper::$afield_type_pctg)
                return "PCTG";
        elseif($this->getId()==AfwUmsPagHelper::$afield_type_time)
                return "TIME";
        elseif($this->getId()==AfwUmsPagHelper::$afield_type_float)                
                return "FLOAT";
        else{ 
                return "UNKNOWN AFW TYPE for type : ".$this." id = ".$this->getId();
        }*/


        return [$afwType, $asize, $tsize, $maxlength, $utf8, $fk_table, $pct, $lang];
}





$pct_total = 0;
$steps = 0;
$uk_arr=[];
foreach($struc_lines_arr as $struc_line)
{        
        list($field_name, $field_order, $size_pct, $tsize, $step, $fgroup, $optional, $oracle_type, $title_ar, $title_en, $uk, $relation) = explode("\t", $struc_line);
        if(!$step) $step = 1;
        if($steps<$step) $steps=$step;
        if($fgroup) $fgroup = "'FGROUP'=>'$fgroup', ";
        $relation = trim($relation);
        if(!$relation) $relation = "ManyToOne-OneToMany";
        
        $mandatory_php = ($optional=="N") ? "true" : "false";
        $field_name = strtolower($field_name);
        if($uk=="UK") $uk_arr[] = $field_name;

        if(($field_name != "id") and 
           ($field_name != "creation_user_id") and 
           ($field_name != "creation_date") and 
           ($field_name != "update_user_id") and 
           ($field_name != "update_date") and 
           ($field_name != "active") and 
           ($field_name != "version") and 
           ($field_name != "update_roles_mfk") and
           ($field_name != "delete_roles_mfk") and 
           ($field_name != "display_roles_mfk"))
        {
                list($afwType, $asize, $tsize, $maxlength, $utf8, $fk_table, $pct, $lang) = oracleTypeToAfwType($field_name, $oracle_type);

                $afwTypeFull = $afwType.$tsize;
                $php_c = $F_TEMPLATE[$afwTypeFull];
                if(!$php_c) die("no template for fn=$field_name, ot=$oracle_type => F_TEMPLATE[$afwTypeFull] not found after list($afwType, $asize, $tsize, $maxlength, $utf8, $fk_table, $pct, $lang) = oracleTypeToAfwType($field_name, $oracle_type) 
                     after2 (size_pct=$size_pct, tsize=$tsize, step=$step, fgroup=$fgroup, optional=$optional, oracle_type=$oracle_type, title_ar=$title_ar, title_en=$title_en, uk=$uk, relation=$relation)");
                $php_c = str_replace("[FIELD_NAME]",$field_name, $php_c);                        
                $php_c = str_replace("[ANSWER_TABLE_NAME]",$fk_table, $php_c);                        
                $php_c = str_replace("[SIZE]",$asize, $php_c);
                $php_c = str_replace("[SIZE_PCT]",$size_pct, $php_c);
                $php_c = str_replace("[STEP]",$step, $php_c);
                $php_c = str_replace("[FGROUP]",$fgroup, $php_c);
                
                $php_c = str_replace("[MAXLENGTH]",$maxlength, $php_c);
                $php_c = str_replace("[UTF8]",$utf8, $php_c);
                $php_c = str_replace("[PCT]",$pct, $php_c);
                $php_c = str_replace("[LANG]",$lang, $php_c);
                $php_c = str_replace("[MAND]",$mandatory_php, $php_c);
                //
                $php_c = str_replace("[RELATION]",$relation, $php_c);
                

                $pct_total += $pct;
                
                
                $FIELDS_STRUCT_ARR[] = $php_c;
                
                $FIELDS_TRAD_ARR[$field_name] = ["ar"=>$title_ar, "en"=>$title_en];
                
        }

}

$nb_steps = round($pct_total / 500);

$phpTrad_ar = "class ".$CLASS_NAME."ArTranslator{

    public static function initData()
    {
        \$trad = [];
";
$phpTrad_en = "class ".$CLASS_NAME."EnTranslator{

    public static function initData()
    {
        \$trad = [];
";

$ar_title_step = [];
$en_title_step = [];

$ar_title_step[1] = "التعريف";
$en_title_step[1] = "Definition";

$ar_title_step[2] = "معلومات متقدمة";
$en_title_step[2] = "Advanced infos";

for($step=1; $step<=$nb_steps; $step++)
{
        $phpTrad_ar .= "	\$trad[\"$TABLE_NAME\"][\"step$step\"] = \"".$ar_title_step[$step]."\";\n";
        $phpTrad_en .= "	\$trad[\"$TABLE_NAME\"][\"step$step\"] = \"".$en_title_step[$step]."\";\n";
        
}

$phpTrad_ar .= "\n";
$phpTrad_en .= "\n";

$TABLE_NAME_SHORTED = str_replace('_','',$TABLE_NAME);



$phpTrad_ar .= "	\$trad[\"$TABLE_NAME\"][\"$TABLE_NAME_SHORTED.single\"] = \"xxxxx\";\n";
$phpTrad_ar .= "	\$trad[\"$TABLE_NAME\"][\"$TABLE_NAME_SHORTED.new\"] = \"جديد ة\";\n";
$phpTrad_ar .= "	\$trad[\"$TABLE_NAME\"][\"$TABLE_NAME\"] = \"xxxxx\";\n";

$single_en = AfwStringHelper::toEnglishText(strtolower($TABLE_NAME));
$plural_en = AfwStringHelper::toEnglishText(strtolower($TABLE_NAME))."s";

$phpTrad_en .= "	\$trad[\"$TABLE_NAME\"][\"$TABLE_NAME_SHORTED.single\"] = \"$single_en\";\n";
$phpTrad_en .= "	\$trad[\"$TABLE_NAME\"][\"$TABLE_NAME_SHORTED.new\"] = \"new\";\n";
$phpTrad_en .= "	\$trad[\"$TABLE_NAME\"][\"$TABLE_NAME\"] = \"$plural_en\";\n";






foreach($FIELDS_TRAD_ARR as $field_name => $trad)
{
        $trad_ar = trim($trad["ar"]);
        $trad_en = trim($trad["en"]);
        if((!$trad_en) or ($trad_en==$trad_ar) or AfwStringHelper::stringStartsWith($trad_en, "??")) 
        {
                $trad_en = AfwStringHelper::toEnglishText($field_name);
        }

        $phpTrad_ar .= "	\$trad[\"$TABLE_NAME\"][\"$field_name\"] = \"$trad_ar\";\n";
        $phpTrad_en .= "	\$trad[\"$TABLE_NAME\"][\"$field_name\"] = \"$trad_en\";\n";
}

$phpTrad_ar .= "        return \$trad;
        }

        public static function getInstance()
	{
		return new $CLASS_NAME();
	}
}

";

$phpTrad_en .= "        return \$trad;
        }

        public static function getInstance()
	{
		return new $CLASS_NAME();
	}
}

";

$FIELDS_STRUCT = implode("\n\n",$FIELDS_STRUCT_ARR);


$php_code = "$TABLE_NAME.php \n";
$php_code .= $phpTemplate;
$php_code .= "// ------------------------ \n\n";
$php_code .= $TABLE_NAME."_afw_structure.php \n";
$php_code .= $structTemplate;
$php_code .= "// ------------------------ \n\n";
$php_code .= "trad_ar_".$TABLE_NAME.".php \n<?php\n";

$php_code .= $phpTrad_ar;
$php_code .= "// ------------------------ \n\n";
$php_code .= "trad_en_".$TABLE_NAME.".php \n<?php\n";
$php_code .= $phpTrad_en;
$php_code .= "// ------------------------ \n\n";
$php_code .= "// Reverse engineering with PAG web plateform \n\n";
$php_code .= "http://localhost/pag/m.php?mp=pag_me.php&cl=$CLASS_NAME&cm=$module&uie=1 \n\n";
$php_code .= "// Reverse engineering with command line \n\n";
$php_code .= "<b>reverse table $TABLE_NAME.$module</b>";


$php_code = str_replace("[FIELDS_STRUCT]", $FIELDS_STRUCT, $php_code);
$php_code = str_replace("[TABLE_NAME]", $TABLE_NAME, $php_code);
$php_code = str_replace("[CLASS_NAME]", $CLASS_NAME, $php_code);
$php_code = str_replace("[STEPS]", $steps, $php_code);


$php_code = str_replace("[UK_ARR]","'".implode("','",$uk_arr)."'", $php_code);

/*
$struc = "ACONDITION
ID	1	1	1	N	INTEGER	الرقم التسلسلي
ACONDITION_NAME	2			N	VARCHAR2 (128 Byte)	مسمى الشرط بالعربية
ACONDITION_NAME_EN	3			N	VARCHAR2 (128 Byte)	مسمى الشرط بالانجليزية
ACONDITION_DESC	4			N	VARCHAR2 (1000 Byte)	وصف الشرط بالعربية
ACONDITION_DESC_EN	5			N	VARCHAR2 (1000 Byte)	وصف الشرط بالانجليزية
RADICAL	6			N	CHAR (1 Byte)	شرط قطعي
COMPOSED	7			N	CHAR (1 Byte)	شرط مركب
CONDITION_1_ID	8		1	Y	INTEGER	الجزء الأول من الشرط
OPERATOR_ID	9		1	Y	INTEGER	الأداة المنطقية
CONDITION_2_ID	10		1	Y	INTEGER	الجزء الثاني من الشرط
AFIELD_ID	11		1	Y	INTEGER	الحقل
COMPARE_ID	12		1	Y	INTEGER	أداة المقارنة
APARAMETER_ID	13		1	Y	INTEGER	القيمة المعلمة
EXCUSE_TEXT_AR	14			Y	VARCHAR2 (3000 Byte)	نص الاعتذار بالعربية
GENERAL	21			Y	CHAR (1 Byte)	الشرط يطبق في المراحل العامة
ACONDITION_TYPE_ID	22		1	N	INTEGER	نوع الشرط
ACONDITION_ORIGIN_ID	23		1	N	INTEGER	اللائحة أو القرار
EXCUSE_TEXT_EN	27			Y	VARCHAR2 (3000 Byte)	نص الاعتذار بالانجليزية
PRIORITY	28			Y	INTEGER	الأولوية
UNIQUE_APPLY	29			Y	CHAR (1 Byte)	يتم تطبيقه على كل فرع
KNOWN_ALREADY	30			Y	CHAR (1 Byte)	قيمة الحقل معلومة مسبقا
SHOW_FE	31			Y	CHAR (1 Byte)	الاضهار في الواجهة
BFUNCTION_ID	32		1	Y	INTEGER	الخدمة العملية";

$struc = "ACONDITION_TYPE
ID	1	1	1	N	INTEGER		False	None	3	0	0.33333				False
ACONDITION_TYPE_NAME	2			Y	VARCHAR2 (64 Byte)		False	None	3	0	0.33333				False
CREATION_USER_ID	3			Y	INTEGER		False	None	0	3	0				False
CREATION_DATE	4			Y	DATE		False	None	0	3	0				False
UPDATE_USER_ID	5			Y	INTEGER		False	None	0	3	0				False
UPDATE_DATE	6			Y	DATE		False	None	0	3	0				False
ACTIVE	7			Y	CHAR (1 Byte)		False	Frequency	1	0	0.16667				False
VERSION	8			Y	NUMBER (19)		False	None	1	0	1				False
UPDATE_ROLES_MFK	9			Y	VARCHAR2 (100 Byte)		False	None	0	3	0				False
DELETE_ROLES_MFK	10			Y	VARCHAR2 (100 Byte)		False	None	0	3	0				False
DISPLAY_ROLES_MFK	11			Y	VARCHAR2 (100 Byte)		False	None	0	3	0				False";
*/


?>

<textarea><?php echo $php_code ?> </textarea>