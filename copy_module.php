<?php
/*
rafik @todo the copy of module should replace answer_table_id in the copied tables by the correspondant copied answer table
            and not let the link with original tables in original module

*/


require_once("../external/db.php");
require_once("afw_rights.php");
require_once("afw_config.php");
require_once("afw_shower.php");

$mod1_id = $_REQUEST["source"];
$mod2_id = $_REQUEST["destination"];
$merge = $_REQUEST["merge"];
$merge_module = $_REQUEST["mergemod"];
$no_submodule = $_REQUEST["nosubmod"];
$no_copy_of_fields_for_existing_tables = $_REQUEST["nomergefields"];



$mod1 = new Module();
if(!$mod1->load($mod1_id))
{
        $out_scr .= "module source (id=$mod1_id) not found";
        $mod1 = null;
}

$mod2 = new Module();
if(!$mod2->load($mod2_id))
{
        $out_scr .= "module destination (id=$mod2_id) not found";
        $mod2 = null;
}

$sys2 = $mod2->getSys();
//die(var_export($sys2,true));
//$parent2 = $mod2->getParent();

$cloned_submodules = 0;
$cloned_tables = 0;
$not_cloned_tables = 0;
$nb_fields_copied = 0;

if($mod1 and $mod2)
{
        
        if(($mod2->getATableCount() >0) and (!$merge))
        {
            $out_scr .= "<div class='error'>Error : can't copy tables to destination module $mod2, it has already tables and you are not merging</div>";
            return -1;
        }
        
        if(($mod2->getATableCount() >0) and (!$merge))
        {
            $out_scr .= "<div class='error'>Error : can't copy tables to destination module $mod2, it has already tables and you are not merging</div>";
            return -1;
        }

        $mod2_smd = $mod2->get("smd");
        $mod_smd = $mod1->get("smd");
        
        $mod_clonage = array();
        $table_clonage = array();
        
        require("$file_dir_name/../ums/temp_copy_${mod1_id}_in_${mod2_id}_params.php");
        
        if((count($mod2_smd)==0) or ($merge_module)) 
        {
              foreach($mod_smd as $mod_smd_id => $mod_smd_item)
              {
                   list($cloned, $mod_smd_item_clone) = $mod_smd_item->cloneMe($mod2->getId(),$sys2->getId());
                   if($cloned) $cloned_submodules++;
                   $mod_clonage[$mod_smd_item->getId()] = $mod_smd_item_clone->getId();
              }
        
        }
        elseif(!$no_submodule)
        {
              $out_scr .= "<div class='error'> : sub modules exists in module : $mod2, use (mergemod or nosubmod) option or empty this module from sub modules</div>";
              return -1;
        }
        
        $tbl_list = $mod1->getMyAllTables();
        //die("tbl_list=".var_export($tbl_list,true));
        foreach($tbl_list as $tbl_id => $tbl_item)
        {
               if(!$table_clonage[$tbl_id])
               {
                       $new_sub_module_id = $mod_clonage[$tbl_item->getVal("id_sub_module")];
                       if(!$new_sub_module_id) $new_sub_module_id = 0;  
                       $tabDestObj = $mod2->getTableByName($tbl_item->getVal("atable_name"));
                       if($tabDestObj)
                       {
                            $not_cloned_tables++;
                            if(!$no_copy_of_fields_for_existing_tables)
                            {
                                    //if($tbl_item->getId()==426) die("tbl_id=$tbl_id, ".var_export($table_clonage,true));
                                    $tbl_nb_fields_copied = $tbl_item->copyMyFieldsTo($tabDestObj);
                                    $tabDestObj->set("id_module", $mod2->getId());
                                    $tabDestObj->set("id_sub_module", $new_sub_module_id);
                                    $tabDestObj->update();
                                    
                                    if(!$tbl_nb_fields_copied)
                                    {
                                         $tbl_item->throwError("copyMyFieldsTo failed");
                                    }
                                    $nb_fields_copied += $tbl_nb_fields_copied;
                            }
                       }
                       else
                       {
                            $new_module_id = $mod2->getId();
                            list($tbl_item_cloned, $tbl_nb_fields_copied) = $tbl_item->cloneMe($new_module_id,$new_sub_module_id);
                            $out_scr .= "<div class='information'> : cloned table : $tbl_item, in ($new_module_id,$new_sub_module_id) to $tbl_item_cloned : nb fields copied : $tbl_nb_fields_copied</div>";
                            $cloned_tables++;
                            $nb_fields_copied += $tbl_nb_fields_copied;
                       }
               }
               else
               {
                       // la table existe pas de clonage
                       $not_cloned_tables++;
                       if((!$no_copy_of_fields_for_existing_tables) and ($table_clonage[$tbl_id] != 9999999))
                       {
                               //if($tbl_id==426) die(var_export($table_clonage,true));
                               
                               $tbl_nb_fields_copied = $tbl_item->copyMyFieldsTo($table_clonage[$tbl_id]);
                               $tabDestObj = $tbl_item->getTableObj($table_clonage[$tbl_id]);
                               $tabDestObj->set("id_module", $mod2->getId());
                               $tabDestObj->set("id_sub_module", $new_sub_module_id);
                               $tabDestObj->update();
                               
                               if(!$tbl_nb_fields_copied)
                               {
                                   $tbl_item->throwError("copyMyFieldsTo failed");
                               }
                               $nb_fields_copied += $tbl_nb_fields_copied;
                       }
               }
               
        }
        
        $out_scr .= "<div class='success'> : cloned modules : $cloned_submodules, cloned tables : $cloned_tables, not cloned tables : $not_cloned_tables, nb fields copied : $nb_fields_copied</div>";                
}        



?>