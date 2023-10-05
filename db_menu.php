<?php
      // here was old const php
      
      $nummenu = 1;
      $numtheme = 0;
      $numsubtheme = 0;
      $numfrontclass = 0;
      
      $theme[$numtheme] = "إدارة البيانات";
      $subtheme[$numtheme][$numsubtheme] = "قواعد البيانات";
      $subtheme_class[$numtheme][$numsubtheme] = "";
      $subtheme_title_class[$numtheme][$numsubtheme] = "database";
      $numfrontclass = ($numfrontclass + 1) % 15; 
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Atable", "png"=>"../lib/images/settingicon.png", "titre"=>"الجداول", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Afield", "png"=>"../lib/images/settingicon.png", "titre"=>"حقول البيانات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15; 
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=Dbsystem", "png"=>"../lib/images/settingicon.png", "titre"=>"أنظمة قواعد البيانات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15; 
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=Dbengine", "png"=>"../lib/images/settingicon.png", "titre"=>"محركات قواعد البيانات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=AfieldType", "png"=>"../lib/images/settingicon.png", "titre"=>"أنواع حقول البيانات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15; 
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=EntryType", "png"=>"../lib/images/profile.png", "titre"=>"طرق الإدخال", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15; 
      $numsubtheme++;
      $subtheme[$numtheme][$numsubtheme] = "الملفات";
      $subtheme_class[$numtheme][$numsubtheme] = "";
      $subtheme_title_class[$numtheme][$numsubtheme] = "database";
      $numfrontclass = ($numfrontclass + 1) % 15; 
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=DocType", "png"=>"../lib/images/profile.png", "titre"=>"أنواع المرفقات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15; 
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Afile", "png"=>"../lib/images/profile.png", "titre"=>"المرفقات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);              
      $numsubtheme++;
      $numtheme++;
      
              
      if($bootstrapMenu)
          include "menu_bootstrap.php";
      else
          include "menu_constructor.php";
?>

