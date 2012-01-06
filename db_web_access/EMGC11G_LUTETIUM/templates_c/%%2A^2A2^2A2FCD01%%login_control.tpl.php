<div align="center">
<form method="post" action="login.php">
<table class="adv_filter" width="300">
    <tr class="adv_filter_title">
        <td colspan="2"><?php echo $this->_tpl_vars['Captions']->GetMessageString('LoginTitle'); ?>
</td>
    </tr>
    <tr class="adv_filter_row">
        <td class="adv_filter_field_name_cell" width="30%" align="right"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Username'); ?>
:</td>
        <td class="adv_filter_editor1_cell"><input class="sm_text" type="text" name="username" id="username"<?php if ($this->_tpl_vars['LoginControl']->GetLastUserName() != ''): ?> value="<?php echo $this->_tpl_vars['LoginControl']->GetLastUserName(); ?>
"<?php endif; ?>></td>
                </tr>
    <tr class="adv_filter_row">
        <td class="adv_filter_field_name_cell" align="right"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Password'); ?>
:</td>
        <td class="adv_filter_editor1_cell"><input class="sm_text" type="password" name="password" id="password"></td>
                </tr>
    <tr class="adv_filter_row">
        <td colspan="2" class="adv_filter_editor1_cell" style="text-align: left;"><input type="checkbox" name="saveidentity" id="saveidentity" <?php if ($this->_tpl_vars['LoginControl']->GetLastSaveidentity()): ?> checked="checked"<?php endif; ?>><?php echo $this->_tpl_vars['Captions']->GetMessageString('RememberMe'); ?>
</td>
    </tr>
    <?php if ($this->_tpl_vars['LoginControl']->GetErrorMessage() != ''): ?>
    <?php echo '<tr class="adv_filter_row"><td colspan="2" class="adv_filter_editor1_cell" style="text-align: center; width: auto;"><div class="login_error_box"><font color="#550000">'; ?><?php echo $this->_tpl_vars['LoginControl']->GetErrorMessage(); ?><?php echo '</font></div></td></tr>'; ?>

    <?php endif; ?>
    <tr class="adv_filter_row">
        <td colspan="2" class="adv_filter_editor1_cell" style="width: auto;"><input class="sm_button" type="submit" value="<?php echo $this->_tpl_vars['Captions']->GetMessageString('Login'); ?>
"></td>
    </tr>                
    <?php if ($this->_tpl_vars['LoginControl']->CanLoginAsGuest()): ?>
    <?php echo '<tr class="adv_filter_row login_control_additional_links_row"><td colspan="2" class="adv_filter_editor1_cell" style="width: auto;"><a href="'; ?><?php echo $this->_tpl_vars['LoginControl']->GetLoginAsGuestLink(); ?><?php echo '">Login as guest</a></td></tr>'; ?>

    <?php endif; ?>
</table>
</form>
</div>