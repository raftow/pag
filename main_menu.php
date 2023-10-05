<?php
      
      $module = AfwUrlManager::currentURIModule();         
      // here was old const php
      
      $nummenu = 1;
      $numtheme = 0;
      $numsubtheme = 0;
      $numfrontclass = 4;
      
      $theme[$numtheme] = "إدارة البيانات";
      $subtheme_class[$numtheme][$numsubtheme] = "front";
      $subtheme_title_class[$numtheme][$numsubtheme] = "database"; 
      $subtheme[$numtheme][$numsubtheme] = "إدارة بياناتي الشخصية";
      
      if($mySemplObj)
      {
              $sempl_me = $mySemplObj->getId();   
              $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_edit.php&cl=Sempl&id=$sempl_me&currmod=sdd", "png"=>"../lib/images/emprofile.png", "titre"=>"تعديل سيرتي الذاتية", "id"=>"", "class"=>"${"front_$numfrontclass"}", "subtheme"=>0);
              $numfrontclass = ($numfrontclass + 1) % 15;  
      }
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"afw_my_files.php?popup=1", "target"=>"popup", "png"=>"../lib/images/attachements.png", "titre"=>"إدارة المرفقات", "id"=>"", "class"=>"${"front_$numfrontclass"}", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15;

      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Sempl&currmod=sdd", "png"=>"../lib/images/emsearch.png", "titre"=>"البحث في الموظفين", "id"=>"", "class"=>"${"front_$numfrontclass"}", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15;
      
      include "../pag/menu_constructor.php";
      
       
      
      


?>

