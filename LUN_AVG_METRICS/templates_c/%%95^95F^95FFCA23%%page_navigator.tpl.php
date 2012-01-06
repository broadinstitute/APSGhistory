<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', 'list/page_navigator.tpl', 9, false),array('function', 'n', 'list/page_navigator.tpl', 17, false),)), $this); ?>
<?php echo '<!-- <Pages> --><div class="page_navigator">'; ?><?php if ($this->_tpl_vars['PageNavigator']->GetPageCount() > 1): ?><?php echo '<span id="current_page_text">'; ?><?php $this->assign('current_page', $this->_tpl_vars['PageNavigator']->CurrentPageNumber()); ?><?php echo ''; ?><?php $this->assign('page_count', $this->_tpl_vars['PageNavigator']->GetPageCount()); ?><?php echo ''; ?><?php $this->assign('current_page_info_template', $this->_tpl_vars['Captions']->GetMessageString('PageNumbetOfCount')); ?><?php echo ''; ?><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['current_page_info_template']), $this);?><?php echo '</span><span dir="ltr">'; ?><?php $_from = $this->_tpl_vars['PageNavigatorPages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['PageNavigatorPage']):
?><?php echo ''; ?><?php if ($this->_tpl_vars['PageNavigatorPage']->IsCurrent()): ?><?php echo '<span id="current_page" title="'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetHint(); ?><?php echo '">'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageCaption(); ?><?php echo '</span>'; ?><?php else: ?><?php echo '<a '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'href="'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageLink(); ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'class="page_link" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'title="'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetHint(); ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php if ($this->_tpl_vars['PageNavigatorPage']->HasShortCut()): ?><?php echo 'pgui-shortcut="'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetShortCut(); ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageCaption(); ?><?php echo '</a>'; ?><?php endif; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '<span>'; ?><?php endif; ?><?php echo '</div>'; ?>


<script>
	$(function()
	{

        <?php echo '
        require(PhpGen.ModuleList([PhpGen.Module.UI.Dialog], true), function() {
        '; ?>


            $('#pgui-dialog-cusomize-page-nav-size_<?php echo $this->_tpl_vars['PageNavId']; ?>
').dialog(
            {
                autoOpen: false,
                resizable: false,
                modal: true,
                width : 400,
                buttons: {
                    OK: function() {
                        ApplyPageSize($('#pgui-dialog-cusomize-page-nav-size_<?php echo $this->_tpl_vars['PageNavId']; ?>
'));
                        $(this).dialog('close');
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                    }
                }
            });


            $('#pgui-customize-page-nav-size_<?php echo $this->_tpl_vars['PageNavId']; ?>
').click(
            function()
            {
                $('#pgui-dialog-cusomize-page-nav-size_<?php echo $this->_tpl_vars['PageNavId']; ?>
').dialog('open');
                return false;
            });

        <?php echo '
        });
        '; ?>

	});
</script>

<?php echo ''; ?><?php if (( $this->_tpl_vars['PageNavigator']->GetPageCount() > 1 ) | ( ( $this->_tpl_vars['PageNavigator']->GetPageCount() <= 1 ) & ( $this->_tpl_vars['PageNavId'] == 1 ) )): ?><?php echo ''; ?><?php if ($this->_tpl_vars['PageNavigator']->GetRowsPerPage() == 0): ?><?php echo ''; ?><?php $this->assign('rec_count_per_page', $this->_tpl_vars['PageNavigator']->GetRowCount()); ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php $this->assign('rec_count_per_page', $this->_tpl_vars['PageNavigator']->GetRowsPerPage()); ?><?php echo ''; ?><?php endif; ?><?php echo '<a href="#" id="pgui-customize-page-nav-size_'; ?><?php echo $this->_tpl_vars['PageNavId']; ?><?php echo '" class="pgui-customize-page-nav-size">'; ?><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('CustomizePageSize')), $this);?><?php echo '</a><div title="'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePageSizeTitle'); ?><?php echo '" style="display: none;" class="pgui-dialog-cusomize-page-nav-size" id="pgui-dialog-cusomize-page-nav-size_'; ?><?php echo $this->_tpl_vars['PageNavId']; ?><?php echo '">'; ?><?php $this->assign('row_count', $this->_tpl_vars['PageNavigator']->GetRowCount()); ?><?php echo '<p>'; ?><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('ChangePageSizeText')), $this);?><?php echo '</p><table cellspacing="0" cellpadding="0" class="pgui-select-page-size"><tr><th>'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('RecordsPerPage'); ?><?php echo '</th><th>'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('TotalPages'); ?><?php echo '</th></tr>'; ?><?php $_from = $this->_tpl_vars['PageNavigator']->GetRecordsPerPageValues(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?><?php echo '<tr><td><input type="radio" value="'; ?><?php echo $this->_tpl_vars['name']; ?><?php echo '" name="recperpage_'; ?><?php echo $this->_tpl_vars['PageNavId']; ?><?php echo '">'; ?><?php echo $this->_tpl_vars['value']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['PageNavigator']->GetPageCountForPageSize($this->_tpl_vars['name']); ?><?php echo '</td></tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '<tr><td><input type="radio" value="custom" name="recperpage_'; ?><?php echo $this->_tpl_vars['PageNavId']; ?><?php echo '" checked="checked">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('UseCustomPageSize'); ?><?php echo '<br><input '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'onkeyup="$(\'#custom_page_size_page_count_'; ?><?php echo $this->_tpl_vars['PageNavId']; ?><?php echo '\').html( GetPageCountForPageSize(this.value, '; ?><?php echo $this->_tpl_vars['PageNavigator']->GetRowCount(); ?><?php echo ') )" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'name="recperpage_custom" value="'; ?><?php echo $this->_tpl_vars['PageNavigator']->GetRowsPerPage(); ?><?php echo '" class="pgui-custom-page-size"></input></td><td><span id="custom_page_size_page_count_'; ?><?php echo $this->_tpl_vars['PageNavId']; ?><?php echo '">'; ?><?php echo $this->_tpl_vars['PageNavigator']->GetPageCount(); ?><?php echo '</span></td></tr></table></div>'; ?><?php endif; ?><?php echo ''; ?>