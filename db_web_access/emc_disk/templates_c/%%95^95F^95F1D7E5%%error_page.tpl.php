<?php ob_start(); ?>
<body onload="HideSearchControl();">
<?php if (! $this->_tpl_vars['Page']->GetVisualEffectsEnabled()): ?><script>jQuery.fx.off = true;</script><?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/site_header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table>
<?php if ($this->_tpl_vars['Page']->GetShowUserAuthBar() || $this->_tpl_vars['Page']->GetShowPageList()): ?>
<tr><td colspan="2" class="top_panel"><a
    class="hide_right_panel" href="#"
    onclick="ToogleSideBar(); return false;"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ShowHideNavbar'); ?>
</a></tr>
<tr>
<?php endif; ?>
    <td valign="top">
<?php if ($this->_tpl_vars['Page']->GetShowUserAuthBar() || $this->_tpl_vars['Page']->GetShowPageList() || $this->_tpl_vars['Page']->GetPrinterFriendlyAvailable() || $this->_tpl_vars['Page']->GetPrinterFriendlyAvailable() || $this->_tpl_vars['Page']->GetExportToExcelAvailable() || $this->_tpl_vars['Page']->GetExportToWordAvailable() || $this->_tpl_vars['Page']->GetExportToXmlAvailable() || $this->_tpl_vars['Page']->GetExportToCsvAvailable() || $this->_tpl_vars['Page']->GetExportToPdfAvailable()): ?>
        <div id="right_side_bar">
<?php if ($this->_tpl_vars['Page']->GetShowUserAuthBar()): ?>
    <div class="auth_bar">
        <?php if ($this->_tpl_vars['Page']->IsCurrentUserLoggedIn()): ?>
            <span id="loggen_in_as_text"><?php echo $this->_tpl_vars['Captions']->GetMessageString('LoggedInAs'); ?>
</span>:<br>
            <span id="user_name"><?php echo $this->_tpl_vars['Page']->GetCurrentUserName(); ?>
</span><br>
            <a href="login.php?operation=logout"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Logout'); ?>
</a>
        <?php else: ?>
            <span id="loggen_in_as_text"><?php echo $this->_tpl_vars['Captions']->GetMessageString('YouAreNotLoggedIn'); ?>
</span>
            <br><a href="login.php"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Login'); ?>
</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['Page']->GetShowPageList()): ?>
    <div class="page_list">
        <img src="images/home.gif" /><span id="current_page_text"><?php echo $this->_tpl_vars['Captions']->GetMessageString('CurrentPage'); ?>
::</span><br/><span id="current_page" style="white-space: normal; padding-left: 20px"><?php echo $this->_tpl_vars['Page']->GetShortCaption(); ?>
</span>
        <?php echo $this->_tpl_vars['PageList']; ?>

    </div>
<?php endif; ?>

    </div>
    <script>
        ApplySideBarPosition();
    </script>
<?php endif; ?>
</td>
<td valign="top">
    <div style="margin-bottom: 10px;">
        <?php if ($this->_tpl_vars['Page']->GetMessage() != null && $this->_tpl_vars['Page']->GetMessage() != ''): ?>
            <span style="color: #FF0000"><?php echo $this->_tpl_vars['Page']->GetMessage(); ?>
</span>
        <?php endif; ?>
        <table height="0">
            <tr>
                <td style="padding: 0px;"><h2 class="page_header" style="margin: 0px;"><?php echo $this->_tpl_vars['Page']->GetCaption(); ?>
</h2></td>
                <td valign="top" style="padding: 0px; padding-top: 5px;"></td>
                <?php if ($this->_tpl_vars['Page']->GetAdvancedSearchAvailable()): ?>
                <?php if (isset ( $this->_tpl_vars['AdvancedSearch'] ) && ! empty ( $this->_tpl_vars['AdvancedSearch'] )): ?>
                <?php echo '<td valign="top" style="padding: 0px; padding-top: 7px"><a id="advanced_search_link" href="javascript:;" onclick="javascript: $(\'#searchControl\').slideToggle(\'slow\');" class="adv_filter_link'; ?><?php if ($this->_tpl_vars['IsAdvancedSearchActive']): ?><?php echo ' active'; ?><?php endif; ?><?php echo '">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AdvancedSearch'); ?><?php echo ''; ?><?php if ($this->_tpl_vars['IsAdvancedSearchActive']): ?><?php echo ' *'; ?><?php endif; ?><?php echo '</a>'; ?><?php if ($this->_tpl_vars['IsAdvancedSearchActive']): ?><?php echo '<div style="display: none;" id="advanced_search_condition">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('SearchCondtitions'); ?><?php echo ':<table class="advanced_search_hint">'; ?><?php $_from = $this->_tpl_vars['FriendlyAdvancedSearchCondition']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FieldCondition']):
?><?php echo '<tr><td>'; ?><?php echo $this->_tpl_vars['FieldCondition']['Caption']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['FieldCondition']['Condition']; ?><?php echo '</td></tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</table></div>'; ?><?php endif; ?><?php echo '</td>'; ?>

                <?php endif; ?>
                <?php endif; ?>
            </tr>
        </table>
    </div>
<?php if ($this->_tpl_vars['Page']->GetAdvancedSearchAvailable()): ?><?php echo $this->_tpl_vars['AdvancedSearch']; ?>
<?php endif; ?>
<script>
    function HideSearchControl()
    {
        $('#searchControl').css('display', '');
        $('#searchControl').hide();
        $('#searchControl').css('height', 'auto');
    }
</script>
<?php if ($this->_tpl_vars['Page']->GetGridHeader() != ''): ?>
<div style="margin-top: 5px; margin-bottom: 5px;">
<?php echo $this->_tpl_vars['Page']->GetGridHeader(); ?>

</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['Page']->GetShowTopPageNavigator()): ?>
    <?php echo $this->_tpl_vars['PageNavigator']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['IsAdvancedSearchActive']): ?>
<script>
    $('#advanced_search_link').qtip(
        {
            container: 'advanced_search_link_cont',
            content:($('#advanced_search_condition').html()),
            position:'center',
            tip_class: 'qtip-wrapper-asearch'
        });
</script>
<?php endif; ?>

<div class="grid_error_message">
<strong><?php echo $this->_tpl_vars['Captions']->GetMessageString('ErrorsDuringDataRetrieving'); ?>
</strong><br><br>
<?php echo $this->_tpl_vars['ErrorMessage']; ?>

</div>
            </td>
        </tr>
    </table>
    <?php echo $this->_tpl_vars['Page']->GetFooter(); ?>

</body>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/base_page_template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>