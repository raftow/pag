<?php
require_once("../config/global_config.php");
// here was old const php

require_once("afw_config.php");
require_once ('afw_rights.php');

$objme = AfwSession::getUserConnected();
$me = ($objme) ? $objme->id : 0;


////AFWObject::setDebugg(true);
//AFWDebugg::initialiser($START_TREE.$TMP_DIR,"afw-debugg".$g_array_user["PAGE_NUMBER"].".txt");
$my_debug_file = "debugg_".date("Ymd")."_$me.txt";
AFWDebugg::initialiser($DEBUGG_SQL_DIR,$my_debug_file);
AFWDebugg::setEnabled(true);

$pack     = ((isset($_REQUEST['pk']) and $_REQUEST['pk']) ? $_REQUEST['pk'].'_':'' );
$sub_pack = ((isset($_REQUEST['spk']) and $_REQUEST['spk']) ? $_REQUEST['spk'].'_':'' );

if(isset($_REQUEST['cl']))
	$cl = $_REQUEST['cl'];
elseif(!$cl)
	die("le param 'cl' est indispensable");

if(isset($_REQUEST['ids']))
	$ids = $_REQUEST['ids'];
/*
elseif(!$id)
{
        $id = $afw_object_id;    
}	
elseif(!$id)
	die("le param 'id' est indispensable");
*/

$my_class = new $cl();
//echo "factory_result";
//print_r($my_class);
//die();
$out_scr = "";
if($ids)
{
        $my_class->where("avail='Y' and id in ($ids)");
        $obj_list = $my_class->loadMany();
        $nb_items = count($obj_list);
        $out_scr .= "تم العثور على ".$nb_items . "سجل<br>";
        $nb_updated = 0;	
        foreach($obj_list as $obj_id => $obj_item)
        {
                //print_r($my_class);
                if(!AfwUmsPagHelper::userCanDoOperationOnObject($obj_item,$objme,'edit'))
                {
			$out_scr .= "لا يمكن تعديل ".$obj_item . ", لا توجد عندك صلاحية<br>";
		}
		else
                {
			$date_last_comm = date("Y-m-d H:i:s");
                        $obj_item->set("date_last_comm",$date_last_comm);
                        $obj_item->update();
                        $nb_updated++;
		}
		
	}
}

$out_scr .= "تم تعديل تاريخ آخر تواصل بالنسبة لـ $nb_updated سجل<br>";
$out_scr .= "<a target='_commDone' href='main.php?Main_Page=comm_not_done.php&cl=Gfield&ids=$ids'>عفوا لم تتم المراسلة الآن. الرجاء إلغاء الطلب</a><br><hr><br>";

?>