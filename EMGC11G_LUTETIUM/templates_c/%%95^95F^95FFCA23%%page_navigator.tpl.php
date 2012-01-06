<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', 'list/page_navigator.tpl', 8, false),)), $this); ?>
<!-- <Pages> -->
<div class="page_navigator">
<?php if ($this->_tpl_vars['PageNavigator']->GetPageCount() > 1): ?>
    <span id="current_page_text">
    <?php $this->assign('current_page', $this->_tpl_vars['PageNavigator']->CurrentPageNumber()); ?>
    <?php $this->assign('page_count', $this->_tpl_vars['PageNavigator']->GetPageCount()); ?>
    <?php $this->assign('current_page_info_template', $this->_tpl_vars['Captions']->GetMessageString('PageNumbetOfCount')); ?>
    <?php echo smarty_function_eval(array('var' => $this->_tpl_vars['current_page_info_template']), $this);?>

    </span>
<span dir="ltr">
<?php $_from = $this->_tpl_vars['PageNavigatorPages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['PageNavigatorPage']):
?>
<?php if ($this->_tpl_vars['PageNavigatorPage']->IsCurrent()): ?>
                        <span id="current_page" title="<?php echo $this->_tpl_vars['PageNavigatorPage']->GetHint(); ?>
"><?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageCaption(); ?>
</span>
<?php else: ?>
                        <a href="<?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageLink(); ?>
" class="page_link" title="<?php echo $this->_tpl_vars['PageNavigatorPage']->GetHint(); ?>
"><?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageCaption(); ?>
</a>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<span>
<?php endif; ?>
</div>


<script>
    <?php if ($this->_tpl_vars['PageNavigator']->HasPreviosPage()): ?>
    BindPageDecrementShortCut('<?php echo $this->_tpl_vars['PageNavigator']->PreviosPageLink(); ?>
');
    <?php endif; ?>
    <?php if ($this->_tpl_vars['PageNavigator']->HasNextPage()): ?>
    BindPageIncrementShortCut('<?php echo $this->_tpl_vars['PageNavigator']->NextPageLink(); ?>
');
    <?php endif; ?>
		
	$(function()
	{

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
			
	});
	

</script>

<?php if (( $this->_tpl_vars['PageNavigator']->GetPageCount() > 1 ) | ( ( $this->_tpl_vars['PageNavigator']->GetPageCount() <= 1 ) & ( $this->_tpl_vars['PageNavId'] == 1 ) )): ?>
<?php if ($this->_tpl_vars['PageNavigator']->GetRowsPerPage() == 0): ?>
	<?php $this->assign('rec_count_per_page', $this->_tpl_vars['PageNavigator']->GetRowCount()); ?>
<?php else: ?>
	<?php $this->assign('rec_count_per_page', $this->_tpl_vars['PageNavigator']->GetRowsPerPage()); ?>
<?php endif; ?>
<a href="#" id="pgui-customize-page-nav-size_<?php echo $this->_tpl_vars['PageNavId']; ?>
" class="pgui-customize-page-nav-size"><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('CustomizePageSize')), $this);?>
</a>

<div title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePageSizeTitle'); ?>
" style="display: none;" class="pgui-dialog-cusomize-page-nav-size" id="pgui-dialog-cusomize-page-nav-size_<?php echo $this->_tpl_vars['PageNavId']; ?>
">

	<?php $this->assign('row_count', $this->_tpl_vars['PageNavigator']->GetRowCount()); ?>
	<p><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('ChangePageSizeText')), $this);?>
</p>

	<table cellspacing="0" cellpadding="0" class="pgui-select-page-size">
		<tr>
			<th><?php echo $this->_tpl_vars['Captions']->GetMessageString('RecordsPerPage'); ?>
</th>
			<th><?php echo $this->_tpl_vars['Captions']->GetMessageString('TotalPages'); ?>
</th>
		</tr>
		<?php $_from = $this->_tpl_vars['PageNavigator']->GetRecordsPerPageValues(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
		<tr>
			<td><input type="radio" value="<?php echo $this->_tpl_vars['name']; ?>
" name="recperpage_<?php echo $this->_tpl_vars['PageNavId']; ?>
"><?php echo $this->_tpl_vars['value']; ?>
</td>
			<td><?php echo $this->_tpl_vars['PageNavigator']->GetPageCountForPageSize($this->_tpl_vars['name']); ?>
</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
		<tr>
			<td>
				<input type="radio" value="custom" name="recperpage_<?php echo $this->_tpl_vars['PageNavId']; ?>
" checked="checked">
				<?php echo $this->_tpl_vars['Captions']->GetMessageString('UseCustomPageSize'); ?>
<br>
				<input 
					onkeyup="$('#custom_page_size_page_count_<?php echo $this->_tpl_vars['PageNavId']; ?>
').html( GetPageCountForPageSize(this.value, <?php echo $this->_tpl_vars['PageNavigator']->GetRowCount(); ?>
) )" 
					name="recperpage_custom" value="<?php echo $this->_tpl_vars['PageNavigator']->GetRowsPerPage(); ?>
" class="pgui-custom-page-size"></input>
			</td>
			<td><span id="custom_page_size_page_count_<?php echo $this->_tpl_vars['PageNavId']; ?>
"><?php echo $this->_tpl_vars['PageNavigator']->GetPageCount(); ?>
</span></td>
		</tr>
	</table>
</div>
<?php endif; ?>
