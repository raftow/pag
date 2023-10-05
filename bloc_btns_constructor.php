<?php
    $menu_class_ul = "hzm-btn-blocs";
    
    if(!$class_div_btns_tpl) $class_div_btns_tpl = "hzm-quick-view";
    
    
    $html_btns = "<div class='$class_div_btns_tpl'>\n
        <ul class='$menu_class_ul settingsul $btns_special'>\n";
                       foreach($menuList as $menu_id => $menu_item)
                       {
                               $menu_afw  = $menu_item["afw"];
                               $menu_mod  = $menu_item["mod"];
                               $menu_operation  = $menu_item["operation"];
                               
                               // if no user is connected or user connected is not admin (normal user)
                               // and there's a class (menu_afw,menu_mod i.e. class module) used by this page that need user authorisation to do (menu_operation) on this (class, module) 
                               if(((!$objme) or (!$objme->isAdmin())) and ($menu_afw and $menu_mod and $menu_operation))
                               {
                                    $myObj = new $menu_afw();
                                    if(true) //was if($objme) <= rafik : but even if logged out sometime edit menu is allowed (mousabaqat for example)  
                                    {
                                         $can_see_menu = false;
                                         $can_t_see_menu_reason = "";
                                         if($menu_operation=="edit")
                                         {
                                                list($can_see_menu, $can_t_see_menu_reason) = $myObj->userCanEditMe($objme);
                                         }       
                                         if(!$can_see_menu) list($can_see_menu,$bf_id, $reason) = $myObj->userCan($objme, $menu_mod, $menu_operation);
                                    }
                                    else
                                    {
                                    
                                    }    
                               }
                               else $can_see_menu = true;
                               
                               if($can_see_menu)
                               {
                                       $menu_id  = $menu_item["id"];
                                       $menu_title  = $menu_item["titre"];
                                       $menu_help  = $menu_item["help"];
                                       $btn_class = $menu_item["btn_class"];
                                       if($menu_help) 
                                       {
                                          $menu_title .= "</span><br><span class='prog-help help-$menu_id'>$menu_help";
                                       } 
                                       $menu_page  = $menu_item["page"];
                                       $menu_png  = $menu_item["png"];
                                       $menu_class  = $menu_item["class"];
                                       $menu_sub_class  = $menu_item["sub_class"];
                                       $target_b = $menu_item["target"];
                                       $info_square_text = $menu_item["square_text"];
                                       $info_square_color = $menu_item["square_color"];
                                       $menu_description = $menu_item["description"];
                                       
                                       if($info_square_text)
                                       {
                                            if(!$info_square_color) $info_square_color = "orange";
                                            $info_square= "<div class='info-square nice_small_button nice_$info_square_color'>$info_square_text</div>";
                                       }
                                       else $info_square= "";
                                       
                                       if($target_b) $target_balise = "target='$target_b'"; else $target_balise = "";       
                                       $html_btns .= "
                                                        <li>
                                                                <div class='progcard card-$menu_id'>
                							$info_square
                                                                        <div  class='$btn_class'>
                                                                                <a class='$menu_class' $target_balise href='$menu_page' onclick='return true'>
                									<span class='niceicon'><img src='$menu_png' width=32/></span>
                									<span class='prog-name prog-$menu_id $menu_sub_class'>$menu_title</span>
                                                                                        <span class='prog-description'>$menu_description</span>
                                                                                </a>
                							</div>
                
                						</div>
                					</li>\n";
                               }
                               else
                               {
                                      $html_btns .= "<!-- can't special edit reason : $can_t_see_menu_reason, can't  [$menu_operation] with role reason : $reason -->";
                               }                     
                       }
                       $html_btns .= "
                                </ul>
                                   <div class='clear'></div>
        </div>
        ";
?>