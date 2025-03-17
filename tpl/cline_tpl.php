<html>
<head>        
        <title>CLINE</title>
        <link href='favicon.ico' rel='shortcut icon'>
        <script src='../lib/js/jquery-1.12.0.min.js'></script>
        <script src='./js/cline.js'></script>
</head>        
<body>
<?php
  $tkn=md5("tkf".date("His"));
  echo "<link href=\"../pag/css/cline.css?crsf=$tkn\" rel=\"stylesheet\" type=\"text/css\">";
?>
<div class="fleft home_banner home_banner4" dir="ltr">
        <div class="fleft command_line_container" height-flag="true" style="height: 200px;">
                <form id="cline_form" method="post" class="form_lourde" action="cline_go.php">
                <div class="fleft row command_line col-xs-12">
                           <div class="form-group form-cline top" dir="ltr">
                                <div class='div-cline title-cline'>
                                       <span class='cline prompt'>[Momken framework comand line] &nbsp;</span>
                                       <img src="../lib/images/help.png" data-toggle="tooltip" data-placement="top" title="type help [keyword1] [keyword2] ... to see help on Momken framework comand line" width="20" heigth="20">
                                       <span class='cline field'>[currfld]</span>
                                       <span class='cline table'>[currtbl_code]</span>
                                       <span class='cline module'>[currmod]</span>
                                       <span class='cline title'>[db_prefix] work objects</span>
                                </div>
                                <!--  -->
                                <div class='div-cline cmd-cline'>
                                                  <!-- [context] > --> 
                                                        <input dir="ltr" type="text" class="inputText form-control command_line_input" name="command_line" size="32" maxlength="1000" value="[newsug_command_line]" id="command_line" autofocus required>
                                                        <span class="floating-label">Type your command or type help</span>
                                </div>    
                                <input type="hidden" name="currmod" id="currmod" value="[currmod]">
                                <input type="hidden" name="currtbl" id="currtbl" value="[currtbl]">
                                <input type="hidden" name="currtbl_code" id="currtbl_code" value="[currtbl_code]">
                                <input type="hidden" name="currobj" id="currobj" value="[currobj]">
                                <input type="hidden" name="currfld" id="currfld" value="[currfld]">
                                <input type="hidden" name="currfld_id" id="currfld_id" value="[currfld_id]">
                                <input type="hidden" name="recid" id="currid" value="[recid]">
                                <input type="hidden" name="hist" id="hist" value="[hist]">
                                <input type="hidden" name="clinego" id="hist" value="1">
                                <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;" tabindex="-1" />
        		   </div>				
                </div>
                <div class="footer-s hzm-loader-div hide" id="myloader">
                        <div class="hzm-loading-div" id="myloading">
                        working on it ...
                        </div>
                </div>
                </form>
                <div class="fleft row command_line_result col-xs-12">
                        <nav>
                                [command_line_history]				
                        </nav>
                [command_line_result]				
                </div>
        </div>
</div>



<script type="text/javascript">
$(document).ready(function() {
        $(".bcounter").click(function()
                { 
                        console.log('id='+$(this).attr("id"));
                        // alert("rafik 02");
                        arr_data = $(this).attr("id").split("-");
                        clicked_id = 'cline-hist-'+arr_data[1];
                        console.log('clicked_id='+clicked_id);
                        clicked_id_val = $("#"+clicked_id).text();
                        console.log('clicked_id_val='+clicked_id_val);
                        $("#command_line").val(clicked_id_val);
                }
        );
        $("#command_line").focus();

        $("#cline_form" ).on('submit', function( event ) {
                
                $(".hzm-loader-div").removeClass("hide"); 
                // alert('here event on submit');
                return true;
        });
	//document.getElementById("command_line").focus();
});
</script>
</body>
</html>
