<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'n', 'advanced_search_control.tpl', 2, false),)), $this); ?>
<?php echo '<div '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'align="center" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'id="searchControl" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php if ($this->_tpl_vars['AdvancedSearchControl']->GetHidden()): ?><?php echo 'style="display: none; height: 0px;" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php endif; ?><?php echo '><form method="POST" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php if ($this->_tpl_vars['AdvancedSearchControl']->GetTarget() != ''): ?><?php echo 'action="'; ?><?php echo $this->_tpl_vars['AdvancedSearchControl']->GetTarget(); ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php endif; ?><?php echo 'id="AdvancedSearchForm" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'name="AdvancedSearchForm"  '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'style="padding: 0px; margin: 0px;"><input type="hidden" name="operation" value="asearch" ><input type="hidden" id="AdvancedSearch" name="AdvancedSearch" value="1"><input type="hidden" id="ResetFilter" name="ResetFilter" value="0"><table class="adv_filter">'; ?><?php if ($this->_tpl_vars['AdvancedSearchControl']->GetAllowOpenInNewWindow()): ?><?php echo '<tr class="adv_filter_top_panel adv_filter_type"><td colspan="5"><a href="'; ?><?php echo $this->_tpl_vars['AdvancedSearchControl']->GetOpenInNewWindowLink(); ?><?php echo '">Open in new page</a></td></tr>'; ?><?php endif; ?><?php echo '<tr class="adv_filter_title"><td colspan="5">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AdvancedSearch'); ?><?php echo '</td></tr><tr class="adv_filter_type"><td colspan="5">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('SearchFor'); ?><?php echo ':<input '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'type="radio" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'name="SearchType" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'value="and" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php if ($this->_tpl_vars['AdvancedSearchControl']->GetIsApplyAndOperator()): ?><?php echo 'checked '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AllConditions'); ?><?php echo '&nbsp;&nbsp;&nbsp;<input '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'type="radio" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'name="SearchType" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'value="pr" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php if (! $this->_tpl_vars['AdvancedSearchControl']->GetIsApplyAndOperator()): ?><?php echo 'checked '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AnyCondition'); ?><?php echo '</td></tr><tr class="adv_filter_head"><td class="adv_filter_field_head">&nbsp;</td><td class="adv_filter_not_head">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('Not'); ?><?php echo '</td><td colspan="3" class="adv_filter_editors_head">&nbsp;</td></tr>'; ?><?php $_from = $this->_tpl_vars['AdvancedSearchControl']->GetSearchColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ColumnsIterator'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ColumnsIterator']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Column']):
        $this->_foreach['ColumnsIterator']['iteration']++;
?><?php echo '<tr class="adv_filter_row"><td class="adv_filter_field_name_cell">'; ?><?php echo $this->_tpl_vars['Column']->GetCaption(); ?><?php echo '</td><td class="adv_filter_not_cell"><input  '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'type="checkbox" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'name="'; ?><?php echo $this->_tpl_vars['Column']->GetNotMarkInputName(); ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'value="'; ?><?php echo $this->_tpl_vars['FilterTypeIndex']; ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php if ($this->_tpl_vars['Column']->IsApplyNotOperator()): ?><?php echo 'checked="checked" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php endif; ?><?php echo '></td><td class="adv_filter_operator_cell"><select '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'class="sm_comboBox adv_filter_type" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'style="width: 120px;" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'id="'; ?><?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'name="'; ?><?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'onchange="if ($(\'#'; ?><?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?><?php echo '\').val() == \'between\') $(\'#'; ?><?php echo $this->_tpl_vars['Column']->GetFieldName(); ?><?php echo '_second\').show(); else $(\'#'; ?><?php echo $this->_tpl_vars['Column']->GetFieldName(); ?><?php echo '_second\').hide(); if ($(\'#'; ?><?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?><?php echo '\').val() == \'IS NULL\') $(\''; ?><?php echo $this->_tpl_vars['Column']->GetFieldName(); ?><?php echo '_value\').hide(); else $(\'#'; ?><?php echo $this->_tpl_vars['Column']->GetFieldName(); ?><?php echo '_value\').show();">'; ?><?php $_from = $this->_tpl_vars['Column']->GetAvailableFilterTypes(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FilterTypeName'] => $this->_tpl_vars['FilterTypeCaption']):
?><?php echo '<option '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'value="'; ?><?php echo $this->_tpl_vars['FilterTypeName']; ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php if ($this->_tpl_vars['Column']->GetActiveFilterIndex() == $this->_tpl_vars['FilterTypeName']): ?><?php echo 'selected '; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['FilterTypeCaption']; ?><?php echo '</option>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</select></td><td class="adv_filter_editor1_cell">'; ?><?php echo $this->_tpl_vars['Renderer']->Render($this->_tpl_vars['Column']->GetEditorControl()); ?><?php echo '</td><td class="adv_filter_editor2_cell"><span id="'; ?><?php echo $this->_tpl_vars['Column']->GetFieldName(); ?><?php echo '_second">'; ?><?php echo $this->_tpl_vars['Renderer']->Render($this->_tpl_vars['Column']->GetSecondEditorControl()); ?><?php echo '</span></td></tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '<tr class="adv_filter_footer"><td colspan="5" style="padding: 5px;"><input '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'id="advsearch_submit" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'class="sm_button" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'type="submit" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'value="'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('ApplyAdvancedFilter'); ?><?php echo '" /><input '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'class="sm_button" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'type="button"  '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'value="'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('ResetAdvancedFilter'); ?><?php echo '" '; ?><?php echo smarty_function_n(array(), $this);?><?php echo 'onclick="javascript: document.forms.AdvancedSearchForm.ResetFilter.value = \'1\'; document.forms.AdvancedSearchForm.submit();"/></td></tr></table>'; ?>


<script language="javascript">

<?php $_from = $this->_tpl_vars['AdvancedSearchControl']->GetSearchColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ColumnsIterator'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ColumnsIterator']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Column']):
        $this->_foreach['ColumnsIterator']['iteration']++;
?>
    if ($('#<?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?>
').val() == 'between')
        $('#<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_second').show();
    else
        $('#<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_second').hide();

    if ($('#<?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?>
').val() == 'IS NULL')
        $('#<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_value').hide();
    else
        $('#<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_value').show();
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['AdvancedSearchControl']->IsActive()): ?>
$(document).ready(function(){

<?php echo '
require(PhpGen.ModuleList([PhpGen.Module.PG.TextHighlight]), function(textHighlight) {
'; ?>

    <?php $_from = $this->_tpl_vars['AdvancedSearchControl']->GetHighlightedFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['HighlightFields'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['HighlightFields']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['HighlightFieldName']):
        $this->_foreach['HighlightFields']['iteration']++;
?>
        textHighlight.HighlightTextInGrid('.grid', '<?php echo $this->_tpl_vars['HighlightFieldName']; ?>
',
            '<?php echo $this->_tpl_vars['TextsForHighlight'][($this->_foreach['HighlightFields']['iteration']-1)]; ?>
',
            '<?php echo $this->_tpl_vars['HighlightOptions'][($this->_foreach['HighlightFields']['iteration']-1)]; ?>
');
    <?php endforeach; endif; unset($_from); ?>
<?php echo '
});
'; ?>


});    
<?php endif; ?>

$(function()
{
	$('#advsearch_submit').click(function()
	{
		var hasNotEmpty = false;
		$('table.adv_filter').find('td.adv_filter_editor1_cell').find('input,select').each(function()
		{
			if ($(this).closest('tr.adv_filter_row').find('.adv_filter_operator_cell').find('select').val() == 'IS NULL')
				hasNotEmpty = true;	
			if ($(this).val() != '')
				hasNotEmpty = true;	
		});
		if (!hasNotEmpty) 
			ShowOkDialog(
				'<?php echo $this->_tpl_vars['Captions']->GetMessageString('EmptyFilter_MessageTitle'); ?>
', 
				'<?php echo $this->_tpl_vars['Captions']->GetMessageString('EmptyFilter_Message'); ?>
');
		return hasNotEmpty;
	});
});

</script>
</form>
</div>
