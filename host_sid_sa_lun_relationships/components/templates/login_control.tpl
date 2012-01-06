<div align="center">
<form method="post" action="login.php">
<table class="adv_filter" width="300">
    <tr class="adv_filter_title">
        <td colspan="2">{$Captions->GetMessageString('LoginTitle')}</td>
    </tr>
    <tr class="adv_filter_row">
        <td class="adv_filter_field_name_cell" width="30%" align="right">{$Captions->GetMessageString('Username')}:</td>
        <td class="adv_filter_editor1_cell"><input class="sm_text" type="text" name="username" id="username"{if $LoginControl->GetLastUserName() != ''} value="{$LoginControl->GetLastUserName()}"{/if}></td>
                </tr>
    <tr class="adv_filter_row">
        <td class="adv_filter_field_name_cell" align="right">{$Captions->GetMessageString('Password')}:</td>
        <td class="adv_filter_editor1_cell"><input class="sm_text" type="password" name="password" id="password"></td>
                </tr>
    <tr class="adv_filter_row">
        <td colspan="2" class="adv_filter_editor1_cell" style="text-align: left;"><input type="checkbox" name="saveidentity" id="saveidentity" {if $LoginControl->GetLastSaveidentity()} checked="checked"{/if}>{$Captions->GetMessageString('RememberMe')}</td>
    </tr>
    {if $LoginControl->GetErrorMessage() != '' }
    {strip}
    <tr class="adv_filter_row">
        <td colspan="2" class="adv_filter_editor1_cell" style="text-align: center; width: auto;">
            <div class="login_error_box">
                <font color="#550000">{$LoginControl->GetErrorMessage()}</font>
            </div>
        </td>
    </tr>
    {/strip}
    {/if}
    <tr class="adv_filter_row">
        <td colspan="2" class="adv_filter_editor1_cell" style="width: auto;"><input class="sm_button" type="submit" value="{$Captions->GetMessageString('Login')}"></td>
    </tr>                
    {if $LoginControl->CanLoginAsGuest()}
    {strip}
    <tr class="adv_filter_row login_control_additional_links_row">
        <td colspan="2" class="adv_filter_editor1_cell" style="width: auto;">
        <a href="{$LoginControl->GetLoginAsGuestLink()}">Login as guest</a>
        </td>
    </tr>
    {/strip}
    {/if}
</table>
</form>
</div>