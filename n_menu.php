<?php
      
      // here was old const php
      
      $theme[0] = "الادارة";
      $theme[1] = "المشاريع";
      $theme[2] = "الجهات";
      $theme[3] = "النصوص";
      

  
      $subtheme[1][1] = "إدارة المشاريع";    

      $menu[1][1][1] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Module", "png"=>"../lib/images/settingicon.png", "titre"=>"المشاريع و الوحدات", "id"=>"", "class"=>"opened", "subtheme"=>1);
      $menu[1][1][2] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=ModuleType", "png"=>"../lib/images/settingicon.png", "titre"=>"أنواع الوحدات", "id"=>"", "class"=>"opened", "subtheme"=>1);
      $menu[1][1][3] =  array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=ModuleSh", "png"=>"../lib/images/settingicon.png", "titre"=>"علاقة الجهات بالوحدات أو المشاريع", "id"=>"", "class"=>"opened", "subtheme"=>1);
      $menu[1][1][11] =  array("page"=>"main.php?Main_Page=Main_Page=afw_mode_edit.php&cl=ModuleSh", "png"=>"../lib/images/settingicon.png", "titre"=>"إنشاء علاقة جهة بالوحدات أو المشاريع", "id"=>"", "class"=>"opened", "subtheme"=>1);
      
      //
      
      $subtheme[1][2] = "إدارة الموظفين";
      
      
      
      $menu[1][2][4] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Auser", "png"=>"../lib/images/profile.png", "titre"=>"الموظفين", "id"=>"", "class"=>"opened", "subtheme"=>2);
      $menu[1][2][5] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Jobrole", "png"=>"../lib/images/profile.png", "titre"=>"الأدوار الوظيفية", "id"=>"", "class"=>"opened", "subtheme"=>2);


      $subtheme[2][3] = "إدارة الجهات"; 

      $menu[2][3][6] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=ShType", "png"=>"../lib/images/schoolinfo.png", "titre"=>"أنواع الجهات المعنية", "id"=>"", "class"=>"opened", "subtheme"=>3);
      $menu[2][3][7] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Stakeholder", "png"=>"../lib/images/schoolinfo.png", "titre"=>"الجهات المعنية", "id"=>"", "class"=>"opened", "subtheme"=>3);

      $subtheme[2][4] = "النصوص";   

      $menu[2][4][6] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=PtextType", "png"=>"../lib/images/schoolinfo.png", "titre"=>"أنواع النصوص ", "id"=>"", "class"=>"opened", "subtheme"=>4);
      $menu[2][4][7] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Ptext", "png"=>"../lib/images/schoolinfo.png", "titre"=>"النصوص", "id"=>"", "class"=>"opened", "subtheme"=>4);
      $menu[2][4][12] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=PtextCat", "png"=>"../lib/images/schoolinfo.png", "titre"=>"أصناف النصوص", "id"=>"", "class"=>"opened", "subtheme"=>4);

      $subtheme[0][0] = "الادارة"; 

      $menu[0][0][8] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Atable", "png"=>"../lib/images/settingicon.png", "titre"=>"الكيانات", "id"=>"", "class"=>"opened", "subtheme"=>0);
      $menu[0][0][9] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Stakeholder", "png"=>"../lib/images/schoolinfo.png", "titre"=>"الجهات المعنية", "id"=>"", "class"=>"opened", "subtheme"=>0);
      $menu[0][0][10] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Gfield", "png"=>"../lib/images/profile.png", "titre"=>"المعلومات", "id"=>"", "class"=>"opened", "subtheme"=>0);
      $menu[0][0][13] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Comm", "png"=>"../lib/images/profile.png", "titre"=>"المراسلات", "id"=>"", "class"=>"opened", "subtheme"=>0);
      $menu[0][0][14] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Theme", "png"=>"../lib/images/profile.png", "titre"=>"المواضيع", "id"=>"", "class"=>"opened", "subtheme"=>0);


      $html = "<div class='innercontainer'>\n";

      foreach($theme as $theme_id => $theme_title)
      {
                
          foreach($subtheme[$theme_id] as $subtheme_id => $subtheme_title)
          {
               $html .= "
<h2 class='pagetitle'><i></i>$subtheme_title</h2>\n
<div class='innercontainer'>\n
<div class='col-12'>\n
<ul class='prog-ul settingsul'>\n";
               foreach($menu[$theme_id][$subtheme_id] as $menu_id => $menu_item)
               {
                       $menu_title  = $menu_item["titre"];
                       $menu_page  = $menu_item["page"];
                       $menu_png  = $menu_item["png"];
                       $menu_class  = $menu_item["class"];       
$html .= "
                                        <li>
						<div class='progcard'>
							<div class='front $menu_class'><a href='$menu_page' onclick='mojarra.jsfcljs(document.getElementById('formId'),{'j_idt22':'j_idt22'},'');return false'>
									<span class='txticon'><img src='$menu_png' /></span>
									<span class='prog-name'>$menu_title</span></a>
							</div>

						</div>
					</li>\n";    
               }
               $html .= "
                        </ul>
                           <div class='clear'></div>
					</div></div>";
               
          }
      }
      $html .= "</div>";

      echo $html;
?>

