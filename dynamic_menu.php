<?php
    throw new AfwRuntimeException("rafik-3 I think it is obsolete now : 10 nov 2021");
    $menu_arr = $objme->getMenuFor(AfwSession::config("application_id",0),$lang);  
    //throw new AfwRuntimeException("objme->getMenuFor($THIS_MODULE_ID,$lang) = ".var_export($menu_arr,true));
    foreach($menu_arr as $menu_item)
    {
?>
           <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=$menu_item["menu_name"]?>
                        <span class="caret" style="padding: 0px 0px 0px 0px !important;"></span></a>
                        <ul class='dropdown-menu'>
                        <?   
                            foreach($menu_item["folders"] as $menu_item_folder_id => $folder_arr)
                            {
                                $menu_item_folder_title = $folder_arr["title"];
                                $menu_item_folder_page = $folder_arr["page"];
                                $menu_item_folder_css = $folder_arr["css"];
                                echo "<li><a href='$menu_item_folder_page' class='$menu_item_folder_css'>$menu_item_folder_title</a></li>\n"; 
                            }
                            
                            foreach($menu_item["items"] as $menu_item_item_id => $item_arr)
                            {
                                $menu_item_title = $item_arr["title"];
                                $menu_item_page = $item_arr["page"];
                                $menu_item_css = $item_arr["css"];
                                echo "<li><a href='$menu_item_page' class='$menu_item_css'>$menu_item_title</a></li>\n"; 
                            }    
                                
                        ?>
                        </ul>
           </li>
    
<?php
    }

?>