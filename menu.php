obsolete 5
<?php
/*
$user_titre_short = $_SESS ION["user_titre_short"];
if(!$user_titre_short) $user_titre_short = $_SE SSION["user_titre"];
if(!$user_titre_short) $user_titre_short = $_SES SION["user_firstname"];
 
$menu[0][0] = array("page"=>"menu.php?showmenu=1&pere=1", "png"=>false, "titre"=>"الطلبة", "id"=>"", "class"=>"parent", "sousmenu"=>1);
if(!AfwSession::getSessionVar("user_id"))
{
        $menu[1][] = array("page"=>"login.php", "titre"=>"تسجيل الدخول", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
$menu[1][] = array("page"=>"inscription.php", "titre"=>"مطلب عضوية جديدة", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[1][] = array("page"=>"profil.php", "titre"=>"تغيير المعطيات الخاصة بي", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[1][] = array("page"=>"invitation_ami.php?but=2", "titre"=>"اقتراح صديق لدعوته إلى الله", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[1][] = array("page"=>"invitation_ami.php?but=1", "titre"=>"اقتراح صديق ليكون من طلبة المعهد", "id"=>"", "class"=>"", "sousmenu"=>-1);

if($je_suis_admin)
{
   $menu[1][] = array("page"=>"mas_find_taleb000.php", "titre"=>"البحث في الأعضاء", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
//if($je_suis_taleb or $je_suis_membre)
{
   $menu[1][] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Taleb", "titre"=>"البحث في الطلبة", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
//**************************************************************************************************************
$menu[0][1] = array("page"=>"menu.php?showmenu=1&pere=2", "png"=>false, "titre"=>"المعهد", "id"=>"", "class"=>"parent", "sousmenu"=>2);

$menu[2][] = array("page"=>"mas_likae.php", "titre"=>"لقاء اليوم", "id"=>"", "class"=>"", "sousmenu"=>-1);
//$menu[2][] = array("page"=>"mas_taleb_korrassa.php", "titre"=>"صفحتي", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[2][] = array("page"=>"mas_rawda.php", "titre"=>"روضة المذاكرة", "id"=>"", "class"=>"", "sousmenu"=>-1);
//$menu[2][] = array("page"=>"mas_taleb_devoir.php", "titre"=>"الواجبات", "id"=>"", "class"=>"", "sousmenu"=>-1);
//$menu[2][] = array("page"=>"mas_taleb_examins.php", "titre"=>"الإمتحانات", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[2][] = array("page"=>"mas_likae_next.php", "titre"=>"لقاءات علمية", "id"=>"", "class"=>"", "sousmenu"=>-1);
//$menu[2][] = array("page"=>"mas_lib_lu.php", "titre"=>"المكتبة المقروءة", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[2][] = array("page"=>"mas_maktaba_sawtia.php", "titre"=>"المكتبة الصوتية", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[2][] = array("page"=>"contact.php", "titre"=>"اتصل بنا", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[2][] = array("page"=>"index.php", "titre"=>"الصفحة الرئيسية", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[2][] = array("page"=>"mas_dawra.php", "titre"=>"دورة الإمام مالك الأولى", "id"=>"", "class"=>"", "sousmenu"=>-1);
if($je_suis_admin)
{
   $menu[2][] = array("page"=>"mas_find_sj.php", "titre"=>"البحث في مشاركات الطلبة", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
$menu[2][] = array("page"=>"but.php", "titre"=>"الأهداف", "id"=>"", "class"=>"", "sousmenu"=>-1);
//******************************************************************************************************************
$menu[0][2] = array("page"=>"menu.php?showmenu=1&pere=3", "png"=>false, "titre"=>"مذاكرة العلم", "id"=>"", "class"=>"parent", "sousmenu"=>3);
$menu[3][0] = array("page"=>"mas_mourajaa.php?minbar=-2&theme=4", "titre"=>"استشكل على أهل العلم", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[3][1] = array("page"=>"mas_mourajaa.php?minbar=-2&theme=2", "titre"=>"الإستشكالات التي أجيب عليها", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[3][2] = array("page"=>"mas_mourajaa.php?minbar=-2&theme=3", "titre"=>"الإستشكالات التي في انتضار الإجابة", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[3][3] = array("page"=>"mas_mourajaa.php?minbar=-2&theme=1", "titre"=>"الإستشكالات الخاصة بي", "id"=>"", "class"=>"", "sousmenu"=>-1);
$ism = 3;
foreach($anstab_id_rubrique as $rub => $rub_tit)
{
   
   if(($rub!=1) and ($rub>=10) and ($ism<10))
   {
        $ism++;
        $menu[3][$ism] = array("page"=>"lecture.php?rub=$rub", "titre"=>$rub_tit, "id"=>"", "class"=>"", "sousmenu"=>-1);
   }   
}
$ism++;
$menu[3][$ism] = array("page"=>"info_creation.php?categ=D", "titre"=>"انشر فائدة علمية", "id"=>"", "class"=>"", "sousmenu"=>-1);
$ism++;
$menu[3][$ism] = array("page"=>"main.php?Main_Page=ittisal_olama.php", "titre"=>"برنامج التواصل مع أهل العلم", "id"=>"", "class"=>"", "sousmenu"=>-1);

//*******************************************************************************************************************
$menu[0][3] = array("page"=>"menu.php?showmenu=1&pere=4", "png"=>false, "titre"=>"المقالات", "id"=>"", "class"=>"parent", "sousmenu"=>4);
if($je_suis_valide)
{
    $menu[4][21] = array("page"=>"lecture.php?cq=1", "titre"=>"التثبت من المقالات الجديدة", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
else
{
    $menu[4][21] = array("page"=>"lecture.php?mme=1", "titre"=>"مقالاتي", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
$ism = 10;
foreach($anstab_id_rubrique as $rub => $rub_tit)
{
   
   if(($rub!=1) and ($rub<10) and ($ism>0))
   {
        $ism--;
        $menu[4][$ism] = array("page"=>"lecture.php?rub=$rub", "titre"=>$rub_tit, "id"=>"", "class"=>"", "sousmenu"=>-1);
   }   
}
$menu[4][0] = array("page"=>"info_creation.php", "titre"=>"تحرير مقال جديد", "id"=>"", "class"=>"", "sousmenu"=>-1);


//***************************************************************************************************************
$menu[0][4] = array("page"=>"menu.php?showmenu=1&pere=5", "png"=>false, "titre"=>"المحاضرات", "id"=>"", "class"=>"parent", "sousmenu"=>5);
$menu[5][0] = array("page"=>"mas_dawra.php", "titre"=>"دورة الإمام مالك الأولى", "id"=>"", "class"=>"", "sousmenu"=>-1);
if($jai_droit_upload)
{
      $menu[5][1] = array("page"=>"admin_silsila.php", "titre"=>"ساهم في تحميل المحاضرات", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
$menu[5][2] = array("page"=>"mas_maktaba_sawtia.php", "titre"=>"المكتبة الصوتية", "id"=>"", "class"=>"", "sousmenu"=>-1);

//******************************************************************************************************************
$menu[0][5] = array("page"=>"menu.php?showmenu=1&pere=6", "png"=>false, "titre"=>"خدمات", "id"=>"", "class"=>"parent", "sousmenu"=>6);
$menu[6][] = array("page"=>"http://apycom.com/", "titre"=>" ", "id"=>"", "class"=>"", "sousmenu"=>-1);
//$menu[6][] = array("page"=>"ast_mariage_request.php", "titre"=>"أريد الزواج", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[6][] = array("page"=>"ast_mariage_result.php", "titre"=>"خدمة تزويج الطلبة", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[6][] = array("page"=>"daawa_letters.php", "titre"=>"تصفح الرسائل الدعوية الجديدة", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[6][] = array("page"=>"dletter_creation.php", "titre"=>"رسالة دعوية جديدة", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[6][] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Dletter", "titre"=>"البحث في الرسائل الدعوية", "id"=>"", "class"=>"", "sousmenu"=>-1);
//*********************************************************************************************************************
$menu[0][6] = array("page"=>"menu.php?showmenu=1&pere=7", "png"=>false, "titre"=>"$user_titre_short", "id"=>"", "class"=>"parent", "sousmenu"=>7);

$menu[7][] = array("page"=>"invitation_ami.php?but=2", "titre"=>"اقتراح صديق لدعوته إلى الله", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[7][] = array("page"=>"invitation_ami.php?but=1", "titre"=>"اقتراح صديق ليكون من طلبة المعهد", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[7][] = array("page"=>"profil.php", "titre"=>"تغيير المعطيات الخاصة بي", "id"=>"", "class"=>"", "sousmenu"=>-1);
$menu[7][] = array("page"=>"main.php?Main_Page=afw_mode_display.php&cl=Taleb&id=$me", "titre"=>"بطاقتي الشخصية", "id"=>"", "class"=>"", "sousmenu"=>-1);
if(AfwSession::getSessionVar("user_id"))
{
        $menu[7][3] = array("page"=>"logout.php", "titre"=>"تسجيل الخروج", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
//*************************************************************************************************************************
$menu[0][7] = array("page"=>"index.php", "png"=>false, "titre"=>"الصفحة الرئيسية", "id"=>"", "class"=>"parent", "sousmenu"=>8);
//*************************************************************************************************************************
$menu[0][8] = array("page"=>"contact.php", "png"=>false, "titre"=>"اتصل بنا", "id"=>"", "class"=>"parent", "sousmenu"=>9);
//*************************************************************************************************************************
if($me)
{
        $menu[0][9] = array("page"=>"menu.php?showmenu=1&pere=1", "png"=>false, "titre"=>"أصدقائي", "id"=>"", "class"=>"parent", "sousmenu"=>10);
        
        $menu[10][] = array("page"=>"inscription.php", "titre"=>"مطلب عضوية جديدة لأحد أصدقائي", "id"=>"", "class"=>"", "sousmenu"=>-1);
        $menu[10][] = array("page"=>"invitation_ami.php?but=2", "titre"=>"اقتراح صديق لدعوته إلى الله", "id"=>"", "class"=>"", "sousmenu"=>-1);
        $menu[10][] = array("page"=>"invitation_ami.php?but=1", "titre"=>"اقتراح صديق ليكون من طلبة المعهد", "id"=>"", "class"=>"", "sousmenu"=>-1);
        $menu[10][] = array("page"=>"main.php?Main_Page=afw_mode_search.php&cl=Taleb", "titre"=>"البحث عن صديق في الطلبة", "id"=>"", "class"=>"", "sousmenu"=>-1);
        $menu[10][] = array("page"=>"main.php?Main_Page=afw_mode_display.php&cl=Taleb&id=$me", "titre"=>"بطاقتي", "id"=>"", "class"=>"", "sousmenu"=>-1);
}
//**************************************************************************************************************

if($je_suis_admin)
{
        $menu[0][19] = array("page"=>"menu.php?showmenu=1&pere=20", "png"=>false, "titre"=>"الإشراف", "id"=>"", "class"=>"parent", "sousmenu"=>20);
        $menu[20][] = array("page"=>"log.php", "titre"=>"تثبت فني", "id"=>"", "class"=>"", "sousmenu"=>-1);        
        $menu[20][] = array("page"=>"stats.php", "titre"=>"احصائيات", "id"=>"", "class"=>"", "sousmenu"=>-1);
        foreach($adminClasses as $maclasse => $titreclasse)
        {
                $menu[20][] = array("page"=>"admin.php?drh=1&cl=$maclasse", "titre"=>"$titreclasse", "id"=>"", "class"=>"", "sousmenu"=>-1);
        }
}
else
{
        $menu[0][19] = array("page"=>"menu.php?showmenu=1&pere=20", "png"=>false, "titre"=>"الإذاعة", "id"=>"", "class"=>"parent", "sousmenu"=>20);

}
$menu[20][] = array("page"=>"main.php?Main_Page=radio.php", "titre"=>"صفحة البث لإذاعة المعهد", "id"=>"", "class"=>"", "sousmenu"=>-1);


//*************************************************************************************************************************
if(!AfwSession::getSessionVar("user_id"))
{
        $menu[0][20] = array("page"=>"login.php", "png"=>false, "titre"=>"الدخول", "id"=>"", "class"=>"parent", "sousmenu"=>-1);
}
//*************************************************************************************************************************
if(AfwSession::getSessionVar("user_id"))
{
        $menu[0][21] = array("page"=>"logout.php", "png"=>false, "titre"=>"الخروج", "id"=>"", "class"=>"parent", "sousmenu"=>-1);
}



foreach($_GET as $key => $val) ${$key} = $val;

function get_menu_html($num, $idclass="menu")
{
    global $menu, $_SES SION;
    $user_tpl = "img";
    if(isset($_SES SION["user_tpl"]) and ($_SESSIO N["user_tpl"])) $user_tpl = $_SES SION["user_tpl"]; 
    
    if($num<0) return "";
    if(!count($menu[$num])) return "";
    
    if($idclass) 
    {
        $menu_id = "id='menu'";
        $menu_class = "class='menu'";
    }  
    else
    {
        $menu_id = "";
        $menu_class = "";
    }  
    $html = "";
    
    foreach($menu[$num] as $i => $item)
    {
        if($item["titre"])
        {
                if($item["class"]) $item_cls = "class='".$item["class"]."'";
                if($item["png"])
                  $label = "<span><img border='0' src='$user_tpl/menu_${num}_$i.png' /></span>";  
                else
                  $label = "<span>".$item["titre"]."</span>";
                  
                $html_0 = "<li><a href='".$item["page"]."' $item_cls>$label</a>";                
                $html_0 .= get_menu_html($item["sousmenu"],"");                
                $html_0 .= "</li>";
                
                $html = $html_0 . $html;
        }
    
    }
    
    $html_final .= "<div $menu_id><ul $menu_class>$html</ul></div>";
    
    
    return $html_final;
     

}

if($showmenu)
{
  include("com mon.php");
  include("hzm_header.php");
  include("trad.php");
  if(count($menu[$pere])>1)
  {
      $tit_pere = $menu[0][$pere-1]["titre"];
      
      foreach($menu[$pere] as $row_menu)
      {
        $page = $row_menu["page"];
        $titre = $row_menu["titre"];
        $data_menu[][$tit_pere] = "<a href='$page'>$titre</a>";
      }
      //echo print_r($data_menu);
      echo "<center>".display_dataGrid("","",$data_menu)."</center>"; 
  
  }
  else
  {
     echo "<br><br><br><center>هذه الصفحة بصدد الإنجاز. إنتظروها قريبا إن شاء الله</center>";
  }
  include("footer.php");
}
*/

?>
