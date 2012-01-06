<!-- -->
<form method="GET" name="SearchForm" style="padding: 0px; margin: 0px; vertical-align: middle;">
<?php $_from = $this->_tpl_vars['SearchControl']->GetHiddenValues(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Name'] => $this->_tpl_vars['Value']):
?>
    <input type="hidden" name="<?php echo $this->_tpl_vars['Name']; ?>
" value="<?php echo $this->_tpl_vars['Value']; ?>
" />
<?php endforeach; endif; unset($_from); ?>
    <input type="hidden" name="operation" value="ssearch" />
    <input type="hidden" name="ResetFilter" value="0" />
    <b><?php echo $this->_tpl_vars['Captions']->GetMessageString('SearchFor'); ?>
: </b> &nbsp;&nbsp;&nbsp
    <select class="sfilter_comboBox" name="SearchField" id="SearchField">
<?php $_from = $this->_tpl_vars['SearchControl']->GetFieldsToFilter(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FieldName'] => $this->_tpl_vars['FieldCaption']):
?>
        <option value="<?php echo $this->_tpl_vars['FieldName']; ?>
"<?php if ($this->_tpl_vars['SearchControl']->GetActiveFieldName() == $this->_tpl_vars['FieldName']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['FieldCaption']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
    </select>
&nbsp;
    <select class="sfilter_comboBox" name="FilterType" id="FilterType">
<?php $_from = $this->_tpl_vars['SearchControl']->GetFilterTypes(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FilterTypeIndex'] => $this->_tpl_vars['FilterTypeName']):
?>
        <option value="<?php echo $this->_tpl_vars['FilterTypeIndex']; ?>
"<?php if ($this->_tpl_vars['SearchControl']->GetActiveFilterTypeName() == $this->_tpl_vars['FilterTypeIndex']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['FilterTypeName']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input class="sfilter_text" type="text" size="20" name="FilterText" id="FilterText" value="<?php echo $this->_tpl_vars['SearchControl']->GetActiveFilterText(); ?>
">
    &nbsp;
    <input type="submit" class="sm_button" value="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ApplySimpleFilter'); ?>
">
    &nbsp;
    <input type="button" class="sm_button" value="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ResetSimpleFilter'); ?>
" onclick="javascript: document.forms.SearchForm.ResetFilter.value = '1'; document.forms.SearchForm.submit();">
</form>

<script>
    <?php if ($this->_tpl_vars['SearchControl']->UseTextHighlight() != ''): ?>
    $(document).ready(function(){
    <?php $_from = $this->_tpl_vars['SearchControl']->GetHighlightedFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HighlightFieldName']):
?>
        HighlightTextInGrid('.grid', '<?php echo $this->_tpl_vars['HighlightFieldName']; ?>
', '<?php echo $this->_tpl_vars['SearchControl']->GetTextForHighlight(); ?>
', '<?php echo $this->_tpl_vars['SearchControl']->GetHighlightOption(); ?>
');
    <?php endforeach; endif; unset($_from); ?>
    });
    <?php endif; ?>
</script>