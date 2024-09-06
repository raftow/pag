<?php
                
                $TECH_FIELDS = array();
                $MODULE = "pag";
                $THIS_MODULE_ID = 4;
                $MODULE_FRAMEWORK[$THIS_MODULE_ID] = 1;
                
        	$TECH_FIELDS[$MODULE]["CREATION_USER_ID_FIELD"]="id_aut";
        	$TECH_FIELDS[$MODULE]["CREATION_DATE_FIELD"]="date_aut";
        	$TECH_FIELDS[$MODULE]["UPDATE_USER_ID_FIELD"]="id_mod";
        	$TECH_FIELDS[$MODULE]["UPDATE_DATE_FIELD"]="date_mod";
        	$TECH_FIELDS[$MODULE]["VALIDATION_USER_ID_FIELD"]="id_valid";
        	$TECH_FIELDS[$MODULE]["VALIDATION_DATE_FIELD"]="date_valid";
        	$TECH_FIELDS[$MODULE]["VERSION_FIELD"]="version";
        	$TECH_FIELDS[$MODULE]["ACTIVE_FIELD"]="avail";
                
                
                $TECH_FIELDS_TYPE = array("id_aut"=>"FK", "date_aut"=>"DATETIME", "id_mod"=>"FK", "date_mod"=>"DATETIME", "id_valid"=>"FK", "date_valid"=>"DATE", "version"=>"INT");
                
                $LANGS_MODULE = array("ar"=>true,"fr"=>false,"en"=>true);
                /*
                global $nb_passages_ici;
                if(!$nb_passages_ici) $nb_passages_ici = 1;
                else $nb_passages_ici++;
                
                if($nb_passages_ici>20000)
                {
                    throw new AfwRuntimeException(" too much passages ici : $nb_passages_ici");
                }*/
                
                
                $MENU_ICONS[1] = "cogs";
                $MENU_ICONS[9] = "sitemap";
                $MENU_ICONS[3] = "building";
                $MENU_ICONS[5] = "pie-chart";
                /*
                $date_pos_left = "40%";
                $date_pos_top = "1.5%";
                $date_color = "#294eb9";
                $date_bgcolor = "rgba(255, 255, 255, 0.32)";
                $header_bg_color = "#fff";
                //$date_font_weight = "bold";
                //$date_color = "#1e620b";
                $date_font_size = "14px";
                $date_font_family = "maghreb";
                */
                $MODE_DEVELOPMENT = false;                
                $module_config_token["file_types"] = "1,2,3,4,5,6,14";
                
                $front_header = true;
                $front_application = true;
                
                //$config["img-path"] = "../external/pic/";
                $config["img-path"] = "pic/";
                $config["img-company-path"] = "../external/pic/";
                
                $jstree_activate = true;
                $display_in_edit_mode["*"] = true;
                // $display_in_display_mode["Module"] = true;
                $disable_select_view_in_qsearch_mode["Pmessage"] = true;
                $header_style = "header_thin";
                $banner = true;
                
                $out_index_page = "Momken_command_line.php";  
                
?>