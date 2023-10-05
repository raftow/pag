<?php
      
      // here was old const php
      
      include_once("module.php");
      
      $module = new Module();
      
      if(!$mid)
      {
              $module->select("id_analyst",$me);
              $module->where("(id_module_parent is null or id_module_parent in(0,21,58))");
              $module->where("id_module_status != 7");
              $module_list = $module->loadMany();
        
              $theme[0] = "لوحة التحكم للمحلل";
              $subtheme[0][0] = "قائمة مشاريعك التي في طور التحليل"; 
              
              $menu_num = 0;
              $numfrontclass = 0;
              foreach($module_list as $module_id => $module_obj)
              {
                   $module_fu_title = $module_obj->valTitle();
                   $menu[0][0][$menu_num] = array("page"=>"panel_analyst.php?mid=$module_id", "png"=>"../lib/images/settingicon.png", "titre"=>$module_fu_title, "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
                   
                   $numfrontclass = ($numfrontclass + 1) % 15;

                   $menu_num++;
              }
      }
      else
      {
              $module->load($mid);
              $module_title = $module->valTitle();  
              $theme[0] = "تحليل المشروع : ".$module_title;
              $subtheme[0][0] = "تتبع المراسلات";
              $menu_num = 0;
              $menu[0][0][$menu_num] = array("page"=>"main.php?Main_Page=rep0002.php&pm_id=$mid", "png"=>"../lib/images/mail.png", "titre"=>"مصادر المدخلات", "id"=>"", "class"=>"front_$menu_num", "subtheme"=>0);
              $menu_num++; 
              $menu[0][0][$menu_num] = array("page"=>"main.php?Main_Page=rep0001.php&pm_id=$mid", "png"=>"../lib/images/mail.png", "titre"=>"تعريف النظام", "id"=>"", "class"=>"front_$menu_num", "subtheme"=>0);
              $menu_num++;
              
              $subtheme[0][1] = "التقارير";
              $menu[0][1][$menu_num] = array("page"=>"doc_needs.php?pm_id=$mid", "png"=>"../lib/images/file-pdf.png", "titre"=>"مصادر المدخلات", "id"=>"", "class"=>"front_$menu_num", "subtheme"=>1);
              $menu_num++; 
              $menu[0][1][$menu_num] = array("page"=>"doc_spec.php?pm_id=$mid", "png"=>"../lib/images/file-pdf.png", "titre"=>"جمع المتطلبات", "id"=>"", "class"=>"front_$menu_num", "subtheme"=>1);
              $menu_num++; 
              
      }
      
      
      include "menu_constructor.php";
      
?>

