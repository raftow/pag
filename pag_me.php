<?php

require_once ("../lib/afw/modes/afw_rights.php");


$myObj = new $cl();
if(!$sh) $sh = 3;   // main company
$update_if_exists = $uie;
$mode_pag_me = true;

list($fld_i,$fld_u) = $myObj->pagMe($sh,$update_if_exists);
// die("RAFIK : myObj->pagMe($sh, $update_if_exists) = (fld_i=$fld_i, fld_u=$fld_u)");
if($log_pag_me)
{
        if($fld_i or $fld_u) $out_scr .= "for <b>$currmod</b> $cl : fields inserted : $fld_i, fields updated : $fld_u <br>\n";
        else $out_scr .= "for <b>$currmod</b> $cl : no updates <br>\n";
}
else
{
        if($fld_i or $fld_u) AfwSession::pushInformation("تم إضافة  $fld_i حقول  وتم تعديل$fld_u سجل ");
        else AfwSession::pushInformation("لا يوجد تعديلات");
        $tabObj = AfwUmsPagHelper::getAtableObj($myObj->getMyModule(), $myObj->getMyTable());
        
        $tabObj->debugg_curr_step = 4;
        $out_scr .= AfwShowHelper::showObject($tabObj,"edit");
}
?> 