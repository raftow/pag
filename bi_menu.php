<?php
      // here was old const php
      
      $nummenu = 1;
      $numtheme = 0;
      $numsubtheme = 0;
      $numfrontclass = 0;
      
      $theme[$numtheme] = "إدارة ذكاء الأعمال";
      $subtheme_class[$numtheme][$numsubtheme] = "front";
      $subtheme_title_class[$numtheme][$numsubtheme] = "database"; 
      $subtheme[$numtheme][$numsubtheme] = "المعلومات والمؤشرات والمصطلحات"; 
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Gfield", "png"=>"../lib/images/profile.png", "titre"=>"المعلومات والمؤشرات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      if(($objme) and ($objme->isAdmin()))
      {
              $numfrontclass = ($numfrontclass + 1) % 15; 
              $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=GfieldType", "png"=>"../lib/images/settingicon.png", "titre"=>"أنواع المعلومات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
              $numfrontclass = ($numfrontclass + 1) % 15; 
              $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=GfieldCat", "png"=>"../lib/images/settingicon.png", "titre"=>"أصناف المعلومات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
              $numfrontclass = ($numfrontclass + 1) % 15; 
              $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=Aprio", "png"=>"../lib/images/settingicon.png", "titre"=>"أولوية المعلومات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
              $numfrontclass = ($numfrontclass + 1) % 15;
              $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Term", "png"=>"../lib/images/profile.png", "titre"=>"المصطلحات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0); 
              
      }
      $numsubtheme++;
      $numtheme++;
      
      
      if($bootstrapMenu)
          include "menu_bootstrap.php";
      else
          include "menu_constructor.php";
?>

