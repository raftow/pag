<?php
/** Error reporting */
error_reporting(E_ALL);
        

require_once("../external/db.php");
require_once("../external/config.php");
require_once('afw_rights.php');

require_once('afw_config.php');

require_once('excel_lib.php');


// require_once('atable.php');
// require_once('afield.php');
// require_once('db_link.php');

$genere_xls = true; // @todo : possible aussi de generer html 

$objme = AfwSession::getUserConnected();

if($genere_xls)
{

        
        /** Include PHPExcel */
        // require_once dirname(__FILE__) . '/../lib/xlsapp/Classes/PHPExcel.php';
        // require_once dirname(__FILE__) . '/../lib/xlsapp/Classes/PHPExcel/IOFactory.php';
        die("PHPExcel.php is no more supported and not compatible with PHP 8.0 to be migrated to PhpSpreadsheet class see https://phpspreadsheet.readthedocs.io/en/latest/");
        
        // Create new PHPExcel object
        //echo date('H:i:s') , " Create new PHPExcel object" , EOL;
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        //echo date('H:i:s') , " Set document properties" , EOL;
        $objPHPExcel->getProperties()->setCreator($objme->getDisplay())
        							 ->setLastModifiedBy($objme->getDisplay())
        							 ->setTitle($result_page_title)
        							 ->setSubject($result_page_title)
        							 ->setDescription($result_page_title)
        							 ->setKeywords($result_page_title)
        							 ->setCategory("data dictionary - قاموس البيانات");
                                                                 
        $objPHPExcel->createSheet(1);
        $objPHPExcel->createSheet(2);
        $objPHPExcel->createSheet(3);
        $objPHPExcel->createSheet(4);
        $objPHPExcel->createSheet(5);
                                                                 
}

$mod  = new Module();
$mod->select("avail", 'Y');
$mod->where("id_module_parent = $mod_id or id = $mod_id");
$liste_mod       = $mod->loadMany();

$parent_module = $liste_mod[$mod_id];

$liste_active_module_ids = "";
     
if($genere_xls)
{
     $objPHPExcel->setActiveSheetIndex(0);
     $active_sheet = &$objPHPExcel->getActiveSheet();
     
     
     
     
     list($header_mod, $data_mod, $isAvail_mod, $liste_active_module_ids) = prepareDataGridForWorksheet($mod, $liste_mod, $objme);
     fill_worksheet($active_sheet, "الوحدات", $header_mod, $data_mod, $isAvail_mod);
     if(!$liste_active_module_ids) $liste_active_module_ids = "0";
     $liste_active_module_ids = "$liste_active_module_ids,$mod_id";
}



$tab  = new Atable();
$tab->select("avail", 'Y');
$tab->where("(id_module in ($liste_active_module_ids) or id_sub_module in ($liste_active_module_ids))");
$liste_tab       = $tab->loadMany();
$liste_active_table_ids = "";

if($genere_xls)
{
     $objPHPExcel->setActiveSheetIndex(1);
     $active_sheet = &$objPHPExcel->getActiveSheet();
     
     
     list($header_tab, $data_tab, $isAvail_tab, $liste_active_table_ids) = prepareDataGridForWorksheet($tab, $liste_tab, $objme);
     fill_worksheet($active_sheet, "الجداول", $header_tab, $data_tab, $isAvail_tab);
     if(!$liste_active_table_ids) $liste_active_table_ids = "0";
     //@todo add module, atable, bfunction, afield in list of tables $liste_active_table_ids = "$liste_active_table_ids,";
     

}


$fld  = new Afield();
$fld->select("avail", 'Y');
$fld->where("atable_id in ($liste_active_table_ids)");
$liste_fld       = $fld->loadMany();
$liste_active_fields_ids = "";

if($genere_xls)
{
     $objPHPExcel->setActiveSheetIndex(2);
     $active_sheet = &$objPHPExcel->getActiveSheet();
     
     
     list($header_fld, $data_fld, $isAvail_fld, $liste_active_fields_ids) = prepareDataGridForWorksheet($fld, $liste_fld, $objme);
     fill_worksheet($active_sheet, "الحقول", $header_fld, $data_fld, $isAvail_fld);
     if(!$liste_active_fields_ids) $liste_active_fields_ids = "0";

}




$bfn  = new Bfunction();
$bfn->select("avail", 'Y');
$bfn->select("curr_class_module_id",$mod_id);
$liste_bfn       = $bfn->loadMany();
$liste_active_bfn_ids = "";
     
if($genere_xls)
{
     $objPHPExcel->setActiveSheetIndex(3);
     $active_sheet = &$objPHPExcel->getActiveSheet();
     
     
     list($header_bfn, $data_bfn, $isAvail_bfn, $liste_active_bfn_ids) = prepareDataGridForWorksheet($bfn, $liste_bfn, $objme);
     fill_worksheet($active_sheet, "الوظائف العملية", $header_bfn, $data_bfn, $isAvail_bfn);
     if(!$liste_active_bfn_ids) $liste_active_bfn_ids = "0";
     //@todo $liste_active_bfn_ids = "$liste_active_bfn_ids,?????";
}
/*
drop view if exists db_link;

create view db_link
as
select f.id,f.id_aut, f.date_aut, f.id_mod, f.date_mod, f.id_valid, f.date_valid, f.avail, f.version, f.update_groups_mfk, f.delete_groups_mfk, f.display_groups_mfk, f.sci_id, 
       f.id as field_id, f.titre_short as field_title, 
       mod1.id_module_parent,
       mod1.id as mod1_id, mod1.titre_short as mod1_name,  
       mod2.id as mod2_id, mod2.titre_short as mod2_name, 
       t1.id as tab1_id, t1.titre_u as tab1_name, 
       t2.id as tab2_id, t2.titre_u as tab2_name 
   from afield f 
        inner join atable t1 on t1.id = f.atable_id 
        inner join module mod1 on mod1.id = t1.id_module 
        inner join atable t2 on t2.id = f.answer_table_id 
        inner join module mod2 on mod2.id = t2.id_module 
where mod2.id != mod1.id 
  and f.avail = 'Y';



select mod1.titre_short as mod1_name, mod2.titre_short as mod2_name -- , f.titre_short as field_title, t1.titre_u as tab1_name, t2.titre_u as tab2_name 
   from afield f 
        inner join atable t1 on t1.id = f.atable_id 
        inner join module mod1 on mod1.id = t1.id_sub_module 
        inner join atable t2 on t2.id = f.answer_table_id 
        inner join module mod2 on mod2.id = t2.id_sub_module 
where mod1.id_module_parent = 76 and  mod2.id != mod1.id and f.avail = 'Y'; */

if($parent_module)
{
        // sheet 4 : العلاقات بين مختلف الأنظمة 
        list($dblnk,$liste_dblnk) = $parent_module->genereWebServices();
        
        //die("dblnk = ".var_export($dblnk));

        $liste_active_dblnk_ids = "";
        
        
        if($genere_xls and $dblnk and is_array($liste_dblnk) and (count($liste_dblnk)>0))
        {
             $objPHPExcel->setActiveSheetIndex(4);
             $active_sheet = &$objPHPExcel->getActiveSheet();
             
             
             list($header_dblnk, $data_dblnk, $isAvail_dblnk, $liste_active_dblnk_ids) = prepareDataGridForWorksheet($dblnk, $liste_dblnk, $objme);
             fill_worksheet($active_sheet, "العلاقات بين مختلف الأنظمة", $header_dblnk, $data_dblnk, $isAvail_dblnk);
             if(!$liste_active_dblnk_ids) $liste_active_dblnk_ids = "0";
             //@todo $liste_active_bfn_ids = "$liste_active_bfn_ids,?????";
        }
        
        // sheet 5 : مهمات العمل 
        list($tsk,$liste_tsk) = $parent_module->genereMyTasks();
        
        
        
        if($genere_xls)
        {
             $objPHPExcel->setActiveSheetIndex(5);
             $active_sheet = &$objPHPExcel->getActiveSheet();
             
             
             list($header_tsk, $data_tsk, $isAvail_tsk, $liste_active_tsk_ids) = prepareDataGridForWorksheet($tsk, $liste_tsk, $objme);
             fill_worksheet($active_sheet, "مهمات العمل ", $header_tsk, $data_tsk, $isAvail_tsk);
        }
}


$uploads_root_path = AfwSession::config("uploads_root_path","");

if($genere_xls)
{
       
        $objPHPExcel->setActiveSheetIndex(0);
  
        $ymd = date("Ymd");
  
        $xls_file_name = "data_dic_$ymd";
  
        $exports_file_name = $uploads_root_path."exports/$xls_file_name";
        // die("here 5 : $exports_file_name");
        // Excel2007
        //$callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($exports_file_name.'.xlsx');
        //$callEndTime = microtime(true);
        //$callTime = $callEndTime - $callStartTime;
        
        // Excel5
        //$callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($exports_file_name.'.xls');
        // die("here 6");
}
$upld_path = AfwSession::config("uploads_http_path","");

$out_scr .= "<center><div class='card'><br>تم تصدير ملف الاكسيل لقاموس البيانات <br>

<a href='$upld_path/exports/$xls_file_name.xlsx'>Download Excel2007 version</a>
<br>
<a href='$upld_path/exports/$xls_file_name.xls'>Download Excel5 version</a>
<br></center><br>
";


?>