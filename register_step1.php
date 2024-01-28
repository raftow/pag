<div class="modal-dialog">
        <div class="modal-content">
                        <?
                         // @todo should be dynamic 
                          //
                         $register_title = AfwLanguageHelper::tarjemMessage("REGISTER_ACCOUNT_ACTIVATION",$uri_module); 
                         $activate_sentence = AfwLanguageHelper::tarjemMessage("ACTIVATE_SENTENCE",$uri_module);
                         $register_data_type = AfwLanguageHelper::tarjemMessage("REGISTER_DATA_TYPE",$uri_module);
                         // $register_conditions = AfwLanguageHelper::tarjemMessage("REGISTER_CONDITIONS",$uri_module);        
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
                        <h3><?=$activate_sentence?></h3>                        
                        <form id="formRegister" name="formRegister" method="post" action="register.php"  onSubmit="return checkRegisterForm();" dir="rtl" enctype="multipart/form-data">
                            <input type="hidden" name="auser_id" value="<?=$auser->getId()?>">
                            <input type="hidden" name="next_step" value="2">
                            <div class="form-group">
                                    <label>رمز التفعيل</label> 
                                    <input class="form-control" id="mobile_activation_id" type="text" name="mobile_activation_id" autocomplete="off"  value="" maxlength="16" tabindex="35" />
                            </div>

                            <input type="submit" name="registerGo" value="التالي" class="btnbtsp btn-primary" />
                                
                        </form>
                </div>
        </div>
</div>                
                
<script type="text/javascript">
function checkRegisterForm() 
{
	if($("#mobile_activation_id").val() == "") {
		alert("الرجاء إدخال رمز التفعيل");
		return false;
	}
        else {
		return true;
	}
}
</script>