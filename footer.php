<?php

$objme = AfwSession::getUserConnected();

/*
if($objme) //die(var_export($objme,true));
{
    $lang = $_SES SION["lang"];
    die("lang=$lang");
    if(!$lang) $lang = "ar";
} 
else $lang = "ar";

$lang = strtolower($lang);
*/

if(!$footer_call) $footer_call = 1;
else $footer_call++;
if($footer_call>1)
{
    if($objme) throw new AfwRuntimeException("footer called more than once : $footer_call");
}

 if($lang=="ar")
 {
   $system_date =AfwDateHelper::currentHijriDate("hdate_long") . "هـ  الموافق لـ : ".date("d/m/Y");
 }
 else
 {
   $system_date = "Date : ".date("d/m/Y")." eq ".AfwDateHelper::currentHijriDate("hdate");
 }
 if($objme)
 {
         $are_you_sure = $objme->translateMessage("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_RECORD",$lang);
         $once_deleted = $objme->translateMessage("ONCE_DELETED_YOU_WILL_NOT_BE_ABLE_TO_GO_BACK",$lang);
         $has_been_deleted = $objme->translateMessage("THE_FOLLOWING_RECORD_HAS_BEEN_DELETED",$lang);
         $you_dont_have_rights = $objme->translateMessage("CANT_DELETE_THE_ROW",$lang);
         $safely_cancelled = $objme->translateMessage("DELETE_HAVE_BEEN_SAFELY_CANCELLED",$lang);
 }
 

include_once("../lib/hzm/web/hzm_footer_features_js.php");
?>
<!-- #Footer -->


</div>
</center>
<?php
  if((!$nomenu) and ((!AfwSession::hasOption("FULL_SCREEN"))))
  {
    $copyright_infos = "";
    if($copyright_infos)
    {
?>
	<div class="footer">
		<div class="innercontainer faqdiv"></div>
		<div class="copyright">
			<div class="innercontainer">
				<span class="footericon fright"><?php echo $copyright_infos ?></span>
                                <br>
			</div>
		</div>
	</div>
<?php
    }
  }
  else
  {
?>
      <center><a href="index.php">home</a></center>

<?php
  }
?>

		<!-- #Loading -->
	</div>

<!--<div id="textarea_simulator" style="position: absolute; top: 0px; left: 0px; visibility: hidden;"></div>
<div id="headerId:growl_container" class="ui-growl ui-widget" style="z-index: 1001;"></div>
<div class="ui-dialog-docking-zone"></div>-->
<?
  if($datatable_on) include("../rfw/datatable_js.php");
  
  
  
  if(!$custom_header) 
  {
        $date_color = "";
        $date_pos_left = "";
        $date_pos_top = "";
        $date_font_weight = "";
        $date_font_size = "";
        $date_font_family = "";
        $date_bgcolor = "";
  
        $welcome_bgcolor = $date_bgcolor;
        $welcome_color = $date_color;
        $welcome_pos_left = "";
        $welcome_pos_top = "";
        $welcome_font_weight = "";
  }      

  if(!$date_color) $date_color = "#000";
  if(!$date_pos_left) $date_pos_left = "47%";
  if(!$date_pos_top) $date_pos_top = "29px";
  if(!$date_font_weight) $date_font_weight = "normal";
  if(!$date_font_size) $date_font_size = "14px";
  if(!$date_font_family) $date_font_family = "maghreb";
  if(!$date_bgcolor) $date_bgcolor = "#fff";
  
  if(!$welcome_bgcolor) $welcome_bgcolor = $date_bgcolor;
  if(!$welcome_color) $welcome_color = "#00d";
  if(!$welcome_pos_left) $welcome_pos_left = "50%";
  if(!$welcome_pos_top) $welcome_pos_top = "5px";
  if(!$welcome_font_weight) $welcome_font_weight = "bold";
  // if(!$date_other_styles) 
  $date_other_styles = "padding-top: 4px;padding-bottom: 4px;padding-left: 4px;padding-right: 4px;text-overflow: clip;text-align: left; overflow: hidden;min-height: 20px;max-width: 960px; width:300px; border-width: 0px;border-radius: 6px;";
  
  $welcome_user = "";
  if($objme)
  {
        $welcome_user = $objme->translate("welcome",$lang) ." " . $objme->getDisplay($lang);
  }
  
  $welcome_other_styles = "padding-top: 4px;padding-bottom: 4px;padding-left: 4px;padding-right: 4px;text-overflow: clip;overflow: hidden;min-height: 20px;max-width: 15%;border-width: 0px;border-radius: 6px;"; 
  
  if((!$nomenu) and ((!AfwSession::hasOption("FULL_SCREEN"))))
  {
    if(!$front_header)
    {
?>
<div style="position: absolute;left: <?=$date_pos_left?>;top: <?=$date_pos_top?>;font-family: <?=$date_font_family?>;font-size: <?=$date_font_size?>;font-weight: <?=$date_font_weight?>;color: <?=$date_color?>;background-color:<?=$date_bgcolor?>;<?=$date_other_styles?>"><?=$system_date?></div>
<div style="position: absolute;left: <?=$welcome_pos_left?>;top: <?=$welcome_pos_top?>;font-family: <?=$date_font_family?>;font-size: <?=$date_font_size?>;font-weight: <?=$welcome_font_weight?>;color: <?=$welcome_color?>;background-color:<?=$welcome_bgcolor?>;<?=$welcome_other_styles?>"><?=$welcome_user?></div>
<!--<div id="pageloader" class="modal"> Place at bottom of page</div> -->
<?php
    }
    else
    {
?>    
<div class="section fp-auto-height-responsive footer_bg" id="footer_div">
	        <div class="rowfooter expanded rowfooter<?=$MODULE?>">
			<div class="large-12 columns">
		  		<img src="../lib/images/sm-01.png" alt="" class="footer_img effectscale sm-icon">
		  		<img src="../lib/images/sm-02.png" alt="" class="footer_img effectscale sm-icon">
		  		<img src="../lib/images/sm-03.png" alt="" class="footer_img effectscale sm-icon">
		  		<img src="../lib/images/sm-04.png" alt="" class="footer_img effectscale sm-icon">
		  		<img src="../lib/images/sm-05.png" alt="" class="footer_img effectscale sm-icon">
		  		<img src="../lib/images/sm-06.png" alt="" class="footer_img effectscale sm-icon">
		  		 
		  	</div>
		</div>
		<div class="rowfooter footer footer<?=$MODULE?> padding-top-3">
			<div class="footer_container columns">
				<div class="rowfooter small-up-1 medium-up-1 large-up-2 text-right">
					<div class="column column-block padding-left-1">
						<h3>روابط سريعة</h3>
						<ul class="row small-up-1 medium-up-1 large-up-2 whiteFont footerlinks padding-right-2">
<?php
      $file_dir_name = dirname(__FILE__); 
      $quick_links_arr = array();
      include("$file_dir_name/../external/quick_links.php");
      if($objme and (!$objme->isCustomer()))
      {
           $mauList = $objme->loadMyModules();
           foreach($mauList as $mauItem)
           {
               $moduleItem = $mauItem->hetModule();
               if($moduleItem and $moduleItem->isRunnable())
               {
                   $quick_links_arr[] = array('target'=>$moduleItem->getVal("module_code"), 
                                              'name_ar'=>$moduleItem->getShortDisplay("ar"), 
                                              'name_en'=>$moduleItem->getShortDisplay("en"), 
                                              'url'=>$moduleItem->getMyURL($lang));
               }
           }
           
      }
      
      foreach($quick_links_arr as $quick_link)
      {
          if(!$quick_link["target"]) $quick_link["target"] = "new";
?>                                                
        <li class="column column-block"><a target="page_<?php echo $quick_link["target"]?>" href="<?php echo $quick_link["url"]?>" class="whiteFont"><?php echo $quick_link["name_$lang"]?></a></li>
<?php
      }
?>   
						</ul>					  
					</div>
					<div class="column column-block padding-left-1">
						<h1 class="color-light-blue">قالو عنا</h1>
						<p class="whiteFont">
							“ مستوى عالي من الإحترافية و الدقة، شكرا جزيلاً على كل المجهودات الرائعة”
								
						</p>
						<br>
					  <p class="color-light-blue">محمد أحمد</p>
						<br>
					  <a href="#features" class="buttonfooter secondary padding-left-3 padding-right-3 ">المزيد  &gt;&gt; </a>
				  </div>
				  <div class="column column-block padding-top-1 padding-left-3">
					<h2 class="footer_news">ليصلك جديدنا أول بأول :</h2>
					<p class="whiteFont">اشترك في قائمة المراسلة</p>
					<div class="footer-input-group padding-left-3">
					  <input class="footer-input-group-field" type="text">
					  <div class="footer-input-group-button">
						<input type="submit" class="hollow button subscr_alert" value="اشترك">
					  </div>
					</div>

				  </div>
				  <div class="column column-block padding-top-1 padding-left-1">
					<h6 class="stats">آخر الإحصائيات</h6>
					<div class="row small-up-2 medium-up-2 large-up-2 text-right">
						<div class="column column-block whiteFont">
							<a href="#" class="whiteFont">عدد ااشعارات المرسلة</a><br>
							15005 مراسلة

						</div>

						<div class="column column-block whiteFont">
							<a href="#" class="whiteFont">تاريخ آخر ارسال</a><br>
							10/10/2009<br>
							01:51:39 م

						</div>
					</div>

					<a href="#features" class="buttonfooter secondary padding-left-3 padding-right-3">المزيد &gt;&gt; </a>

				  </div>
					  
				</div>
				<div class="row">
						<div class="large-12 columns">
							<p class="whiteFont">
								 <?php echo $copyright_phrase; // site.inc?>
							</p>
						</div>
				</div>
				
			</div>
		</div>
				
	</div>    
        <div class="footer-p hzm-loader-div hide" id="myloader">
          <div class="hzm-loading-div" id="myloading">
                  الرجاء الانتظار جارٍ معالجة الطلب                   
          </div>
        </div>
<?php
    }
  }
if($_GET["tipofday"]==1)
{
?>
<div id="tipofday">
        <div class="HzmModal-bg" style="display: block;">&nbsp;</div>
        <div class="HzmModal" style="display: block;">
                <div class="HzmModal-content">
                        <button class="HzmModal-close-icon HzmModal-close" aria-label="Close">&nbsp;
                        </button>
                        <div id="arvlbdata" style="overflow:visible;width:400px;height:250px;" class="HzmModal-inner">      
                                <div allowtransparency="true" style="overflow:hidden;width:400px;height:250px;" class="fb-page fb_iframe_widget" data-href="https://www.facebook.com/dubaijobz" data-width="400" data-height="250" data-small-header="false" data-adapt-container-width="false" data-hide-cover="true" data-show-facepile="true" data-show-posts="false" fb-xfbml-state="rendered" fb-iframe-plugin-query="adapt_container_width=false&amp;app_id=520401164798256&amp;container_width=400&amp;height=250&amp;hide_cover=true&amp;href=https%3A%2F%2Fwww.facebook.com%2Fdubaijobz&amp;locale=en_US&amp;sdk=joey&amp;show_facepile=true&amp;show_posts=false&amp;small_header=false&amp;width=400">
                                        <span style="vertical-align: bottom; width: 400px; height: 214px;">
                                                معلومة اليوم :
                                                
                                                .......
                                                
                                        </span>
                                </div>
                        </div>
                </div>
        </div>
</div>
<?

}
  if(AfwSession::config("MODE_DEVELOPMENT",false) or AfwSession::hasOption("SQL_LOG"))
  {
          $end_main_time = microtime();
          $duree_ms = round(($end_main_time - $start_main_time)*100000)/100;
          if($duree_ms<0) $duree_ms += 1000;
          AfwSession::hzmLog("end of footer-include $duree_ms milli-sec", $MODULE);

          echo "<div id='analysis_log'><div id=\"analysis_log\"><div class=\"fleft\"><h1><b>System LOG activated :</b></h1></div><br><br>";
          echo AfwSession::getLog();
          
          if($objme)
          {
            if(AfwSession::hasOption("ICAN_DO_LOG")) $objme->showICanDoLog();
            if(AfwSession::hasOption("MEMORY_REPORT")) AfwMemoryHelper::memReport();
          }      
          echo "</div>";


  }
  // else die("analysis_log = ".$_SE SSION["analysis_log"]);

  /*

  if(AfwSession::hasOption("PERFORMANCE_ANALYSIS")) 
  {
          echo "<div id='cache_analysis'>";
          $message = "";
          if($_POST) 
          {
                $message .= "<table dir='ltr'>";
                foreach($_POST as $att => $att_val)
                {
        		$message .= "<tr><td>posted <b>$att : </b></td><td>$att_val</td><td> = ${$att}</td></tr>"; 
        	}
                $message .= "</table><hr>";
          }
          echo $message;
          echo "Start : $time_stamp_end - End : $time_stamp_start<br>Page duration : $time_stamp_page_duration <br>";
          echo "--- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ ---- <br>";
          if($objme and $objme->isSuperAdmin() and $cacheSys) echo $cacheSys->cache_analysis_to_html();
          echo "--- ********************************************************************************************************************* ---- <br>";
          if($objme and $objme->isSuperAdmin()) sql_query_cache_analysis();
          echo "--- ********************************************************************************************************************* ---- <br>";
          if($objme and $objme->isSuperAdmin()) echo show_get_analysis();
          echo "</div>";
          
          
          
  }
  */
?>
  
</body>
</html>
