<div class="modal-dialog">
        <div class="modal-content">
                        <?
                         // @todo should be dynamic 
                          //
                         $register_title = AfwLanguageHelper::tarjemMessage("REGISTER_TITLE",$uri_module); 
                         $register_sentence = AfwLanguageHelper::tarjemMessage("REGISTER_SENTENCE",$uri_module);
                         $register_data_type = AfwLanguageHelper::tarjemMessage("REGISTER_DATA_TYPE",$uri_module);
                         $register_conditions = AfwLanguageHelper::tarjemMessage("REGISTER_CONDITIONS",$uri_module);        
                        ?>
       
                
                <div class="modal-header">
                        <span style="float: right;">
                                <a href="index.php" title="الرئيسسة" style="float: right;">
                                        <img src="../<?=$MODULE?>/pic/logo.png" alt="<?=$register_data_type?>" title="<?=$register_title?>"></a>
                                </a>
                                <h1 style="float: right;margin-right: 30px;padding-top: 0px;vertical-align: middle;"><?=$register_title?></h1>
                        </span>
  
                </div>
                
                    <? 
                       if($msgRegister)
                       {
                    ?>
                        <div class="darkbg quote">
                            <div class="quoteinn">
                               <p><font color='red'><?=$msgRegister?></font></p>
                            </div>
                        </div>
                    <? 
                       }
                    ?>
                <div class="modal-body">
                        <h3><?=$register_sentence?></h3>
                        <form id="formRegister" name="formRegister" method="post" action="register.php"  onSubmit="return checkRegisterForm();" dir="rtl" enctype="multipart/form-data">
                            <div class="form-group">
                                    <label>رقم الهوية</label> 
                                    <input class="form-control" id="idn" type="text" name="idn" autocomplete="off"  value="" maxlength="16" tabindex="35" />
                            </div>
                            <div class="form-group">
                                     <label>الجوال مثال 0598112233</label>
                                    <input class="form-control" id="mobile" type="text" name="mobile" autocomplete="off"  value="" maxlength="16" tabindex="30" />
                            </div>                            
                            <div class="form-group">
                                    <label>الجنس</label>
                                    <select class="form-control" id="gender" name="gender" autocomplete="off"  value=""  maxlength="30" tabindex="2">
                                          <option value='0'></option>
                                          <option value='1'>ذكر</option>
                                          <option value='2'>أنثى</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                    <label>الاسم الأول</label>
                                    <input class="form-control" id="first_name" type="text" name="first_name" autocomplete="off"  value=""  maxlength="30" tabindex="10" />
                            </div>                            
                            <div class="form-group">
                                    <label>اسم العائلة</label> 
                                    <input class="form-control" id="last_name" type="text" name="last_name" autocomplete="off"  value=""  maxlength="30" tabindex="20" />
                            </div>                            
                            <div class="form-group">
                                    <label>كلمة المرور</label>
                                    <input class="form-control" id="pwd1" type="password" name="pwd1" autocomplete="off"  value="" maxlength="30" tabindex="40" />
                            </div>
                            <div class="form-group">
                                    <label>إعادة كلمة المرور</label>
                                    <input class="form-control" id="pwd2" type="password" name="pwd2" autocomplete="off"  value="" maxlength="30" tabindex="50" />
                            </div>
                            
                            <input type="hidden" name="next_step" value="1">
                            <h3><?=$register_conditions?></h3>
                            <input type="submit" name="registerGo" value="التسجيل" class="btnbtsp btn-primary" />
                                
                        </form>
                </div>
        </div>
</div>

<script type="text/javascript">
function checkRegisterForm() 
{
	if($("#gender").val() == 0 || $("#first_name").val() == "" || $("#last_name").val() == "" || $("#idn").val() == "" || $("#mobile").val() == "" || ($("#pwd").val() == "")) {
		alert("الرجاء إدخال بيانات التسجيل  كاملة، كل الحقول اجبارية");
		return false;
	}
        if($("#pwd1").val() != $("#pwd2").val()) {
		alert("لا يوجد تطابق بين كلمة المرور وإعادتها"+$("#pwd1").val()+" != "+$("#pwd2").val());
		return false;
	} else {
		return true;
	}
}
</script>
