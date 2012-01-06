<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'styleoption', 'list/detail_page.tpl', 2, false),array('function', 'eval', 'list/detail_page.tpl', 13, false),)), $this); ?>
<?php ob_start(); ?>
<body style="<?php echo smarty_function_styleoption(array('name' => 'margin','value' => $this->_tpl_vars['Page']->Margin), $this);?>
<?php echo smarty_function_styleoption(array('name' => 'padding','value' => $this->_tpl_vars['Page']->Padding), $this);?>
">
<div style="height: auto; padding: 5px;" id="detailContent_<?php echo $this->_tpl_vars['DetailPage']->DetailRowNumber; ?>
">
<div style="padding: 5px">
<div style="padding: 5px; border: 1px solid;">
<div class="detail_preview_head" style="width: 100%; text-align: left;" dir="ltr">
<?php echo $this->_tpl_vars['Captions']->GetMessageString('DetailPreview'); ?>
: <span class="detail_page_caption" title="<?php echo $this->_tpl_vars['DetailPage']->GetCaption(); ?>
"><?php echo $this->_tpl_vars['DetailPage']->GetShortCaption(); ?>
</span>
<?php if ($this->_tpl_vars['DetailPage']->GetRecordLimit() < $this->_tpl_vars['DetailPage']->GetFullRecordCount()): ?>
<div style="margin: 0px; font-size: 8pt;">
<?php $this->assign('first_record_count', $this->_tpl_vars['DetailPage']->GetRecordLimit()); ?>
<?php $this->assign('total_record_count', $this->_tpl_vars['DetailPage']->GetFullRecordCount()); ?>
<?php $this->assign('shown_first_m_of_n_records', $this->_tpl_vars['Captions']->GetMessageString('ShownFirstMofNRecords')); ?>
<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['shown_first_m_of_n_records']), $this);?>

<?php $this->assign('full_view_link', $this->_tpl_vars['DetailPage']->GetFullViewLink()); ?>
(<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('FullView')), $this);?>
)</div>
<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['PageNavigator']; ?>

<?php echo $this->_tpl_vars['Grid']; ?>

</div>
</div>
</div>
<script language="javascript">
<!--
    var elem = document.getElementById('detailContent_<?php echo $this->_tpl_vars['DetailPage']->DetailRowNumber; ?>
');
    if (elem && elem.innerHTML)
    {
        window.parent.LoadDetail('<?php echo $this->_tpl_vars['DetailPage']->DetailRowNumber; ?>
', elem);
        location.replace('about:blank');
    }
// -->
</script>
</body>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/base_page_template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>