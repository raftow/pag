<?php
      // here was old const php
      
      $nummenu = 1;
      $numtheme = 0;
      $numsubtheme = 0;
      $numfrontclass = 0;
      
      
      $role_item = new Arole();

      $theme[$numtheme] = $role_item->getDisplay($lang);;
      $subtheme[$numtheme][$numsubtheme] = "";
      
      if($role_item->load($id)) 
      {
                
                $role_item_folders = $role_item->get("childList");
                              
                array_multisort($role_item_folders, $role_item_folders);
              
                foreach($role_item_folders as $folder_item)
                {
                         if($folder_item and (is_object($folder_item)))
                         {
                             
                         }
                             
                }
                
              $role_item_bfs = $role_item->get("bfunction_mfk");
                              
              $role_item_bfs_atable_arr = array();
              
              foreach($role_item_bfs as $bf_index => $bf_item)
              {
                   if($bf_item and (is_object($bf_item)))
                   {
                       $role_item_bfs_atable_arr[$bf_index] = $bf_item->getVal("curr_class_atable_id");
                   }
                   else
                   {
                       unset($role_item_bfs[$bf_index]);
                   }    
              }
              
              array_multisort($role_item_bfs_atable_arr, $role_item_bfs);
              
              foreach($role_item_bfs as $bf_item)
              {
                 if($bf_item and (is_object($bf_item)))
                 {
                     $menu_arr[$role_item->getId()]["items"][$bf_item->getId()] = array();
                     $title_lang =  $bf_item->getDisplay($lang);
                     $bf_item_id =  $bf_item->getId();
                     if(!$title_lang) $title_lang = "bf-$bf_item_id-$lang";
                     $bf_url = $bf_item->getUrl();
                     
                     $menu[$numtheme][$numsubtheme][$nummenu++] = array("page"=>$bf_url, "png"=>"../lib/images/profile.png", "titre"=>"$title_lang", "id"=>"", "class"=>"front_$numfrontclass", "subtheme"=>0);
                     $numfrontclass = ($numfrontclass + 1) % 15;
                     
                 }
                     
              }
                
                
              $numsubtheme++;
                
       }
              
      if($bootstrapMenu)
          include "menu_bootstrap.php";
      else
          include "menu_constructor.php";
?>

