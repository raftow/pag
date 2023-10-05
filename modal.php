<?
  ob_start();
?>



<div class="modal-dialog modal-lg" id="user-popup-window">
        <div class="modal-content">
                <div class="modal-header">
                        <div class="row">
                                <div class="col-xs-6">
                                        <a href="http://livehelperchat.com" target="_blank" title="Live Helper Chat">
                                                <img class="img-responsive" src="/lhc_web/design/defaulttheme/images/general/logo_user.png" alt="Live Helper Chat" title="Live Helper Chat"></a>
                                </div>
                                <div class="col-xs-6">
                                        <div class="btn-group pull-right" role="group" aria-label="...">
                                                <a class="btnbtsp btn-default btn-xs closebutton" onclick="lhinst.userclosedchatandbrowser();" href="#" title="Close">
                                                        <i title="close" class="material-icons mr-0">close</i></a>
                                        </div>
                                </div>
                        </div>
                </div>
                <div class="modal-body"><h4>Fill out this form to start a chat</h4>
                        <form id="form-start-chat" method="post" action="/lhc_web/index.php/chat/startchat" onsubmit="return lhinst.addCaptcha('1498944736',$(this))">
                                <div class="form-group">
                                        <label class="control-label">Name*
                                        </label>
                                        <input autofocus="autofocus" aria-required="true" required="" aria-label="Enter your name" placeholder="Enter your name" class="form-control" type="text" name="Username" value="">
                                </div>
                                <div class="form-group">
                                        <label class="control-label">Your question*
                                        </label>
<textarea autofocus="autofocus" aria-required="true" required="" aria-label="Enter your message" class="form-control" placeholder="Enter your message" name="Question"></textarea>
                                </div>
                                <input type="hidden" name="user_timezone" value="4">
<script>$(document).ready(function() {Date.prototype.stdTimezoneOffset = function() {var jan = new Date(this.getFullYear(), 0, 1);var jul = new Date(this.getFullYear(), 6, 1);return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());};Date.prototype.dst = function() {return this.getTimezoneOffset() < this.stdTimezoneOffset();};var today = new Date();var timeZoneOffset = 0;if (today.dst()) {timeZoneOffset = today.getTimezoneOffset();} else {timeZoneOffset = today.getTimezoneOffset()-60;};$('input[name=user_timezone]').val(((timeZoneOffset)/60) * -1);});</script>
                                <div class="btn-group" role="group" aria-label="...">
                                        <input type="submit" class="btnbtsp btn-primary btn-sm startchat" value="Start chat" name="StartChatAction">
                                </div>
                                <input type="hidden" value="" name="URLRefer">
                                <input type="hidden" value="" name="r">
                                <input type="hidden" value="0" name="operator">
                                <input type="hidden" value="1" name="StartChat">
                        </form>
                </div>
        </div>
</div>
<?
  $out_scr = ob_get_clean();
?>
