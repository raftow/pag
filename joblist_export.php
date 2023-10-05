<?php
   $file_dir_name = dirname(__FILE__); 
   

   
   ob_start();
   include("$file_dir_name/../lib/afw/afw_default_word_header.php");
   $tpl_header_content = ob_get_clean();
   
   ob_start();
   include("$file_dir_name/../lib/afw/afw_default_word_footer.php");
   $tpl_footer_content = ob_get_clean();

   $id_sh_org = 3;
   $id_sh_div = 33;

//  class="tab-pane fade[active_div]"

   $job_template = '     <br style="page-break-before: always"> 
                         <div> <h5 class="bluetitle"><i></i>[job_title]</h5>  
                                        <table  style="width: 100%;">                                                          
                                           <tbody>
                                                <tr>                                                                                                 
                                                        <th class="header_plage"><b>تعريف الوظيفة [job_title]</b></th>                                                                          
                                                </tr>
                                                <tr>                                                                                                 
                                                        <td class="empty_plage">
                                                               [job_descr]
                                                        </td>                                                                          
                                                </tr>                                 
                                           </tbody>
                                        </table>
                                        <br style="page-break-before: always">
                                        <table  style="width: 100%;">                                                          
                                           <tbody>
                                                <tr>                                                                                                 
                                                        <th class="header_plage"><b>شروط  الوظيفة [job_title]</b></th>                                                                          
                                                </tr>
                                                <tr>                                                                                                 
                                                        <td class="empty_plage">
                                                               [job_conds]
                                                        </td>                                                                          
                                                </tr>
                                           </tbody>
                                        </table> 
                        </div>';
                        
                        
   
   $jr = new Jobrole();
   $jr->select("id_sh_org",$id_sh_org);
   $jr->select("id_sh_div",$id_sh_div);
   if($one_job) $jr->select("id",$one_job); 
   
   
   $jr_list = $jr->loadMany("","min_exp desc,  min_local_exp desc, min_injob_exp desc");                        
   
   $jobs_html_content = $tpl_header_content;
                                                                
   foreach($jr_list as $jr_id => $jr_item)
   {
           
           $jr_item_descr = "
           <table  style='width: 100%;'>
                <tr>
                    <th style='text-align: right;'>بالعربية</th>
                </tr>
                <tr>
                    <td><pre dir='rtl' style='text-align:right;width:100%;height:100%'>".$jr_item->valDescription()."\n</pre></td>
                </tr>
                <tr>
                    <th style='text-align: left;'>English</th>
                </tr>
                <tr>
                    <td><pre dir='ltr' style='text-align:left;width:100%;height:100%'>".$jr_item->valDescription_en()."</pre></td>
                </tr>
           </table>";
           
           $job_html = $job_template;
           // $job_html = str_replace("[active_div]",$active_div,$job_html); 
           $job_html = str_replace("[job_id]",$jr_id,$job_html);
           $job_html = str_replace("[job_title]",$jr_item->getDisplay(),$job_html);     // $jr_item->getModeDisplayLink()
           $job_html = str_replace("[job_descr]",$jr_item_descr,$job_html);
           $jr_item->disableIcons["conds"] = true;
           $jr_item->force_hide_retrieve_cols = array("is_ok");
           $job_html = str_replace("[job_conds]",$jr_item->showAttribute("conds"),$job_html);
           
           $jobs_html_content .= $job_html;
   }
   
   $jobs_html_content .= $tpl_footer_content;
   
   
   echo $jobs_html_content;
   
   
   
?>