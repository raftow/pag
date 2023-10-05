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
      
      $theme[$numtheme] = "إدارة المشاريع و الأنظمة";
      $subtheme[$numtheme][$numsubtheme] = "المشاريع و الأنظمة";
      $subtheme_class[$numtheme][$numsubtheme] = "";
      $subtheme_title_class[$numtheme][$numsubtheme] = "database";     
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++]  =  array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Module", "png"=>"../lib/images/settingicon.png", "titre"=>"الوحدات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++]  =  array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=ModuleType", "png"=>"../lib/images/settingicon.png", "titre"=>"أنواع الوحدات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] =  array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=ModuleStatus", "png"=>"../lib/images/settingicon.png", "titre"=>"حالات المشاريع", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++]  =  array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=ModuleSh", "png"=>"../lib/images/settingicon.png", "titre"=>"علاقة الجهات بالوحدات أو المشاريع", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numsubtheme++;

      $numfrontclass = ($numfrontclass + 1) % 15;  
      $subtheme[$numtheme][$numsubtheme] = "الصلاحيات";    
      $menu[$numtheme][$numsubtheme][$nummenu++]  =  array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Arole", "png"=>"../lib/images/settingicon.png", "titre"=>"الصلاحيات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>$numsubtheme);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] =  array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Bfunction", "png"=>"../lib/images/settingicon.png", "titre"=>"الخدمات العملية", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] =  array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=BfunctionType", "png"=>"../lib/images/settingicon.png", "titre"=>"أنواع الخدمات العملية", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] =  array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Ugroup", "png"=>"../lib/images/settingicon.png", "titre"=>"مجموعات المستخدمين", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] =  array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=UgroupType", "png"=>"../lib/images/settingicon.png", "titre"=>"متعلقات مجموعات المستخدمين", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] =  array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=UgroupScope", "png"=>"../lib/images/settingicon.png", "titre"=>"مجالات مجموعات المستخدمين", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      
      $numsubtheme++;
      
      //
      $numfrontclass = ($numfrontclass + 1) % 15;
      $subtheme[$numtheme][$numsubtheme] = "إدارة المستخدمين";
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Auser", "png"=>"../lib/images/profile.png", "titre"=>"المستخدمون", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>2);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++]  =  array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=ModuleAuser", "png"=>"../lib/images/settingicon.png", "titre"=>"صلاحيات المستخدم", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>1);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=Jobrole", "png"=>"../lib/images/profile.png", "titre"=>"الأدوار الوظيفية", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>2);
      $numsubtheme++;

      $subtheme[$numtheme][$numsubtheme] = "إدارة الهيكل التنظيمي"; 
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=ShType", "png"=>"../lib/images/schoolinfo.png", "titre"=>"أنواع عنصر الهيكل التنظيمي", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>3);
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Stakeholder", "png"=>"../lib/images/schoolinfo.png", "titre"=>"عناصر الهيكل التنظيمي", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>3);
      $numsubtheme++;

      $subtheme[$numtheme][$numsubtheme] = "تحرير النصوص";   
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=PtextType", "png"=>"../lib/images/schoolinfo.png", "titre"=>"أنواع النصوص ", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>4);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=PtextCat", "png"=>"../lib/images/schoolinfo.png", "titre"=>"أصناف النصوص", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>4);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&ids=all&cl=PtextStatus", "png"=>"../lib/images/schoolinfo.png", "titre"=>"حالات النصوص", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>4);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Ptext", "png"=>"../lib/images/schoolinfo.png", "titre"=>"النصوص", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>4);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Comm", "png"=>"../lib/images/profile.png", "titre"=>"المراسلات", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
      $numfrontclass = ($numfrontclass + 1) % 15;
      $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Theme", "png"=>"../lib/images/profile.png", "titre"=>"المواضيع", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);

      $numsubtheme++;
      $subtheme[$numtheme][$numsubtheme] = "القوائم الثابتة";
      
      $at = new Atable();
      $at->select("id_module",4);
      $at->select("id_sub_module",71);
      $at->select("avail",'Y');
      $at_list = $at->loadMany($limit = "", $order_by = "id_sub_module asc");
      if(is_array($at_list) and count($at_list)) 
      {
                foreach($at_list as $atb_id => $atb_obj)
                {
                             $atb_obj_class = $atb_obj->getTableClass();
                             $atb_obj_desc =  $atb_obj->getVal("titre_short");
                             $atb_obj_name =  $atb_obj->getVal("titre_u");  
                             
                             if($atb_obj->isOriginal()) {
                                     if(($atb_obj->getRowCount()<= 15) and ($atb_obj->_isLookup()))
                                     {
                                             $fixmtit = "إدارة ".$atb_obj_desc;
                                             $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_qedit.php&cl=$atb_obj_class&currmod=$currmod&ids=all&newo=3&fixmtit=$fixmtit", "png"=>"../lib/images/profile.png", "titre"=>"$fixmtit", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
                                             $numfrontclass = ($numfrontclass + 1) % 15; 
                                             
                                     }
                                     else
                                     {
                                             $tit = "البحث في ".$atb_obj_desc;
                                             $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=$atb_obj_class&currmod=$currmod", "png"=>"../lib/images/profile.png", "titre"=>"$tit", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
                                             $numfrontclass = ($numfrontclass + 1) % 15; 
                                     }
                             }
                             else
                             {
                                     $rc = $atb_obj->getRowCount();
                                     if($rc<= 15)
                                     {
                                             if(!$rc) $rc = 0;
                                             $tit = "البحث في ".$atb_obj_desc;
                                             $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=rfw_mode_search.php&tblid=$atb_id", "png"=>"../lib/images/profile.png", "titre"=>"$tit", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
                                             $numfrontclass = ($numfrontclass + 1) % 15; 

                                             
                                             $fixmtit = "إدارة ".$atb_obj_desc;
                                             $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=rfw_mode_qedit.php&tblid=$atb_id&ids=all&newo=3&fixmtit=$fixmtit&limit=15", "png"=>"../lib/images/profile.png", "titre"=>"$fixmtit", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
                                             $numfrontclass = ($numfrontclass + 1) % 15; 
                                             
                                     }
                                     else
                                     {
                                             $tit = "البحث في ".$atb_obj_desc;
                                             $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>"main.php?Main_Page=rfw_mode_search.php&tblid=$atb_id", "png"=>"../lib/images/profile.png", "titre"=>"$tit", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
                                             $numfrontclass = ($numfrontclass + 1) % 15; 
                                     }
                             
                             }
                             //$atb_obj->getVal("atable_name")
                                        
                }
                $numsubtheme++;
                
       }
              
      if($bootstrapMenu)
          include "menu_bootstrap.php";
      else
          include "menu_constructor.php";
?>

