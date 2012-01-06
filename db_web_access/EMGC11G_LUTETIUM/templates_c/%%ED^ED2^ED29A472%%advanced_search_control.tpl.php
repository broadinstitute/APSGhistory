<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'smart_strip', 'advanced_search_control.tpl', 60, false),)), $this); ?>
<div align="center" 
    id="searchControl"
    <?php if ($this->_tpl_vars['AdvancedSearchControl']->GetHidden()): ?> style="display: none; height: 0px;"<?php endif; ?>>

    <form method="POST" 
        <?php if ($this->_tpl_vars['AdvancedSearchControl']->GetTarget() != ''): ?>  action="<?php echo $this->_tpl_vars['AdvancedSearchControl']->GetTarget(); ?>
"<?php endif; ?> 
        id="AdvancedSearchForm" 
        name="AdvancedSearchForm" 
        style="padding: 0px; margin: 0px;">

        <input type="hidden" name="operation" value="asearch" >
        <input type="hidden" id="AdvancedSearch" name="AdvancedSearch" value="1">
        <input type="hidden" id="ResetFilter" name="ResetFilter" value="0">

        <table class="adv_filter">
        
            <?php if ($this->_tpl_vars['AdvancedSearchControl']->GetAllowOpenInNewWindow()): ?>
            <tr class="adv_filter_top_panel adv_filter_type">
                <td colspan="5">
                    <a href="<?php echo $this->_tpl_vars['AdvancedSearchControl']->GetOpenInNewWindowLink(); ?>
">Open in new page</a>
                </td>
            </tr>
            <?php endif; ?>

        <?php echo '<tr class="adv_filter_title"><td colspan="5">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AdvancedSearch'); ?><?php echo '</td></tr>'; ?>


        <tr class="adv_filter_type">
            <td colspan="5">
                <?php echo $this->_tpl_vars['Captions']->GetMessageString('SearchFor'); ?>
:
                <input 
                    type="radio" 
                    name="SearchType" 
                    value="and"
                    <?php if ($this->_tpl_vars['AdvancedSearchControl']->GetIsApplyAndOperator()): ?> checked<?php endif; ?>>
                    <?php echo $this->_tpl_vars['Captions']->GetMessageString('AllConditions'); ?>

                &nbsp;&nbsp;&nbsp;
                <input 
                    type="radio" 
                    name="SearchType" 
                    value="pr"
                    <?php if (! $this->_tpl_vars['AdvancedSearchControl']->GetIsApplyAndOperator()): ?> checked<?php endif; ?>><?php echo $this->_tpl_vars['Captions']->GetMessageString('AnyCondition'); ?>

            </td>
        </tr>

    <tr class="adv_filter_head">
        <td class="adv_filter_field_head">&nbsp;</td>
        <td class="adv_filter_not_head"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Not'); ?>
</td>
        <td colspan="3" class="adv_filter_editors_head">&nbsp;</td>
    </tr>
<?php $_from = $this->_tpl_vars['AdvancedSearchControl']->GetSearchColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ColumnsIterator'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ColumnsIterator']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Column']):
        $this->_foreach['ColumnsIterator']['iteration']++;
?>
    <tr class="adv_filter_row">
        <td class="adv_filter_field_name_cell"><?php echo $this->_tpl_vars['Column']->GetCaption(); ?>
</td>
        <td class="adv_filter_not_cell">
            <?php $this->_tag_stack[] = array('smart_strip', array()); $_block_repeat=true;smarty_block_smart_strip($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <input 
                type="checkbox"
                name="<?php echo $this->_tpl_vars['Column']->GetNotMarkInputName(); ?>
"
                value="<?php echo $this->_tpl_vars['FilterTypeIndex']; ?>
"
                <?php if ($this->_tpl_vars['Column']->IsApplyNotOperator()): ?> 
                checked="checked"
                <?php endif; ?>>
            <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_smart_strip($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
        </td>
        <td class="adv_filter_operator_cell">
            <select 
                class="sm_comboBox adv_filter_type" 
                style="width: 120px;"
                id="<?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?>
"
                name="<?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?>
"
                onchange="if ($('#<?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?>
').val() == 'between') $('#<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_second').show(); else $('#<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_second').hide(); if ($('#<?php echo $this->_tpl_vars['Column']->GetFiterTypeInputName(); ?>
').val() == 'IS NULL') $('<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_value').hide(); else $('#<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_value').show();">
<?php $_from = $this->_tpl_vars['Column']->GetAvailableFilterTypes(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FilterTypeName'] => $this->_tpl_vars['FilterTypeCaption']):
?>
                <?php $this->_tag_stack[] = array('smart_strip', array()); $_block_repeat=true;smarty_block_smart_strip($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                <option 
                    value="<?php echo $this->_tpl_vars['FilterTypeName']; ?>
"
                    <?php if ($this->_tpl_vars['Column']->GetActiveFilterIndex() == $this->_tpl_vars['FilterTypeName']): ?> 
                    selected
                    <?php endif; ?>>
                    <?php echo $this->_tpl_vars['FilterTypeCaption']; ?>

                </option>
                <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_smart_strip($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php endforeach; endif; unset($_from); ?>
            </select>
        </td>

        <td class="adv_filter_editor1_cell">
            <?php echo $this->_tpl_vars['Renderer']->Render($this->_tpl_vars['Column']->GetEditorControl()); ?>

        </td>

        <td class="adv_filter_editor2_cell">
            <span id="<?php echo $this->_tpl_vars['Column']->GetFieldName(); ?>
_second">
                <?php echo $this->_tpl_vars['Renderer']->Render($this->_tpl_vars['Column']->GetSecondEditorControl()); ?>

            </span>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
    <tr class="adv_filter_footer">
        <td colspan="5" style="padding: 5px;">
            <input 
                id="advsearch_submit" 
                class="sm_button" 
                type="submit" 
                value="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ApplyAdvancedFilter'); ?>
" />
            <input
                class="sm_button" 
                type="button" 
                value="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ResetAdvancedFilter'); ?>
" 
                onclick="javascript: document.forms.AdvancedSearchForm.ResetFilter.value = '1'; document.forms.AdvancedSearchForm.submit();"/>
        </td>
    </tr>
</table>

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
<?php $_from = $this->_tpl_vars['AdvancedSearchControl']->GetHighlightedFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['HighlightFields'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['HighlightFields']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['HighlightFieldName']):
        $this->_foreach['HighlightFields']['iteration']++;
?>
    HighlightTextInGrid('.grid', '<?php echo $this->_tpl_vars['HighlightFieldName']; ?>
',
        '<?php echo $this->_tpl_vars['TextsForHighlight'][($this->_foreach['HighlightFields']['iteration']-1)]; ?>
',
        '<?php echo $this->_tpl_vars['HighlightOptions'][($this->_foreach['HighlightFields']['iteration']-1)]; ?>
');
<?php endforeach; endif; unset($_from); ?>
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
