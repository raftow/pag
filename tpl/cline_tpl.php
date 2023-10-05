<div class="fleft home_banner home_banner4" dir="ltr">
        <div class="fleft command_line_container" height-flag="true" style="height: 200px;">
                <form method="post" action="tamakan_command_line.php">
                <div class="fleft row command_line col-xs-12">
                           <div class="form-group form-cline" dir="ltr">
                                <label>Tamakan framework comand line &nbsp;<img src="../lib/images/help.png" data-toggle="tooltip" data-placement="top" title="type help [keyword1] [keyword2] ... to see help on tamakan framework comand line" width="20" heigth="20">
                                </label>
                                <!--  -->
                                <table style='width:100%'>
                                        <tr>
                                                  <td class='cline_td'> <span class='cline-en cline-message cline-normal'> tmkn > </span> 
                                                  </td>
                                                  <td>
                                                        <input dir="ltr" type="text" class="inputText form-control command_line_input" name="command_line" size="32" maxlength="1000" value="[newsug_command_line]"  autocomplete="off" required>
                                                        <span class="floating-label">Type your command or type help</span>
                                                  </td>
                                        </tr>
                                </table>    
                                <input type="hidden" name="currmod" id="currmod" value="[currmod]">
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

