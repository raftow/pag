<?
     // include("$file_dir_name/../pag/context_mandatory.php");
     
     $my_orgunit_id = $objme->getMyOrganizationId();
     
     if(!$my_orgunit_id) 
     {
         echo "No orgunit defined for module $MODULE and user $objme : <br>";
         // if($objme->isSuperAdmin()) echo "<pre>" . var_export($objme,true) . "</pre>";
         exit;
     }
     
     $my_orgunit = Orgunit::loadById($my_orgunit_id);
     
     if(!$my_orgunit) 
     {
         echo "The orgunit [$my_orgunit_id] is not found";
         exit;
     }
     
?>
<link href="../pag/assets/css/style.css" rel="stylesheet" />
<div class="innercontainer">
<div class="uploader_header">
<h1>تحميل الملفات من أجل استيراد البيانات </h1>
<h2><b>الجهة المعنية بعملية الاستيراد</b> : <?=$my_orgunit?></h2>
</div>
                <form id="upload" method="post" action="afw_upload_for_import.php" enctype="multipart/form-data">
			<div id="drop" class='forimport'>
				اسحب الملف إلى هنا لتحميله
                                <br>
				<a>تصفح في قائمة الملفات</a>
				<input type="file" name="upl" multiple />     <br><br>
                                يسمح فقط بالملفات من الأنواع التالية xls, xlsx
			</div>
                        <input type="hidden" name="my_orgunit_id" value="<?=$my_orgunit_id?>">
			<ul>
				<!-- The file uploads will be shown here -->
			</ul>

		</form>

        
		<!-- JavaScript Includes -->
		<script src="../pag/assets/js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="../pag/assets/js/jquery.ui.widget.js"></script>
		<script src="../pag/assets/js/jquery.iframe-transport.js"></script>
		<script src="../pag/assets/js/jquery.fileupload.js"></script>
		<!-- Our main JS file -->
		<script src="../pag/assets/js/script.js"></script>


</div>

<form name="importForm" id="importForm" method="post" action="main.php" >
        <input type="hidden" name="Main_Page" value="afw_mode_edit.php">
        <input type="hidden" name="cl" value="Eimport">
        <input type="hidden" name="currmod" value="pag">
        <table cellspacing="3" cellpadding="1">
        <tbody>
          <tr>
                  <td>
                     <input type="submit" class="redbtn submit-btn fleft" name="submit" id="submit-form" value="تنفيذ عملية استيراد بيانات" style="min-width: 300px !important;">
                  </td>
          </tr>
        </tbody>
        </table>
        
        <input type="hidden" name="sel_orgunit_id" value="<?=$my_orgunit_id?>">
</form>
