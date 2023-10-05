<?php
    $out_scr .= "<div class='hzm3-row-padding hzm3-center hzm3-small hzm_home_bloc' style='margin:0 -16px'>";
    if(!$objme) $objme = AfwSession::getUserConnected();
    $iamAdmin = $objme->isAdmin();
    if($m=="control")
    {
           $out_scr .= "<div id='menu-item-control-options' class='bf hzm-menu-item hzm3-col l3 m3 s12'>
                                <a class='hzm3-button hzm3-light-grey hzm3-block' href='main.php?Main_Page=toggle_option.php&My_Module=pag' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                    <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                      <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                        <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-settings\"></i>
                                      </div>
                                    </div>
                                    الخيارات
                                </a>
                             </div>
                             
                         <div id='menu-item-files-upload' class='bf hzm-menu-item hzm3-col l3 m3 s12'>
                                <a class='hzm3-button hzm3-light-grey hzm3-block' href='afw_my_files.php' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                    <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                      <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                        <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-std fa-cloud-upload\"></i>
                                      </div>
                                    </div>
                                    تحميل الملفات
                                </a>
                             </div>
                             
                         <div id='menu-item-files-upload' class='bf hzm-menu-item hzm3-col l3 m3 s12'>
                                <a class='action_lourde hzm3-button hzm3-light-grey hzm3-block' href='afw_my_account.php' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                    <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                      <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                        <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-std fa-user\"></i>
                                      </div>
                                    </div>
                                    حسابي
                                </a>
                             </div>        
                             
                             ";
                             
                             
    }
    else
    {
            $file_dir_name = dirname(__FILE__);
            
            $module_items[] = array();
            if($m)
            {
                $module_items[$m] = Module::loadById($m);
            }    
            else
            {
                $module_items = Module::getSystemList($done);
            }
            
            foreach($module_items as $menu_folder_item_id => $menu_folder_item)
            {
                $menu_item_id = $menu_folder_item_id;
                $menu_item_icon = $menu_icons_arr["mod-".$menu_item_id];
                if(!$menu_item_icon) $menu_item_icon = "globe";
                $menu_item_title = $menu_folder_item->getShortDisplay($lang);
                $menu_item_page = "main.php?Main_Page=afw_mode_edit.php&cl=Module&currmod=ums&id=$menu_item_id&popup=";
                $menu_item_css = "hzm_module";

                $out_scr .= "<div id='menu-item-$menu_item_id' class='$menu_item_css hzm-menu-item hzm3-col l3 m3 s12'>
                                <a class='action_lourde hzm3-button hzm3-light-grey hzm3-block' href='$menu_item_page' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                    <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                      <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                        <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-$menu_item_icon\"></i>
                                      </div>
                                    </div>
                                    $menu_item_title
                                </a>
                             </div>";

            }
            
    }

    
        
        
        
            
    $out_scr .= "</div>";    
?>