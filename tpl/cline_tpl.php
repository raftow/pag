<div class="fleft home_banner home_banner4" dir="ltr">
        <div class="fleft command_line_container" height-flag="true" style="height: 200px;">
                <form method="post" action="cline_go.php">
                <div class="fleft row command_line col-xs-12">
                           <div class="form-group form-cline" dir="ltr">
                                <label>Momken framework comand line &nbsp;
                                       <img src="../lib/images/help.png" data-toggle="tooltip" data-placement="top" title="type help [keyword1] [keyword2] ... to see help on Momken framework comand line" width="20" heigth="20">
                                       <span class='cline field'>[currfld]</span>
                                       <span class='cline table'>[currtbl_code]</span>
                                       <span class='cline module'>[currmod]</span>
                                       <span class='cline title'>current work objects</span>
                                </label>
                                <!--  -->
                                <table style='width:100%'>
                                        <tr>
                                                  <td class='cline_td'> <span class='cline-en cline-message cline-normal'> [context] > </span> 
                                                  </td>
                                                  <td>
                                                        <input dir="ltr" type="text" class="inputText form-control command_line_input" name="command_line" size="32" maxlength="1000" value="[newsug_command_line]"  autocomplete="off" required>
                                                        <span class="floating-label">Type your command or type help</span>
                                                  </td>
                                        </tr>
                                </table>    
                                <input type="hidden" name="currmod" id="currmod" value="[currmod]">
                                <input type="hidden" name="currtbl" id="currtbl" value="[currtbl]">
                                <input type="hidden" name="currtbl_code" id="currtbl_code" value="[currtbl_code]">
                                <input type="hidden" name="currobj" id="currobj" value="[currobj]">
                                <input type="hidden" name="currfld" id="currfld" value="[currfld]">
                                <input type="hidden" name="recid" id="currid" value="[recid]">
                                <input type="hidden" name="hist" id="hist" value="[hist]">
                                <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;" tabindex="-1" />
        		   </div>				
                </div>
                </form>
                <div class="fleft row command_line_result col-xs-12">
                [command_line_result]				
                </div>
        </div>
</div>

