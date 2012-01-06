<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'list/grid.tpl', 60, false),)), $this); ?>
<?php if ($this->_tpl_vars['Grid']->GetEnabledInlineEditing()): ?>
<script type="text/javascript">
    $(function()
    {
        $('#<?php echo $this->_tpl_vars['Grid']->GetName(); ?>
.grid').sm_inline_grid_edit(
        {
			cancelButtonHint: '<?php echo $this->_tpl_vars['Captions']->GetMessageString('Cancel'); ?>
',
			commitButtonHint: '<?php echo $this->_tpl_vars['Captions']->GetMessageString('Commit'); ?>
',
            requestAddress: '<?php echo $this->_tpl_vars['Grid']->GetInlineEditRequestsAddress(); ?>
',
            useBlockGUI: true,
			useImagesForActions: <?php if ($this->_tpl_vars['Grid']->GetUseImagesForActions()): ?>true<?php else: ?>false<?php endif; ?>,
            editingErrorMessageHeader: '<?php echo $this->_tpl_vars['Captions']->GetMessageString('ErrorsDuringUpdateProcess'); ?>
'
        });
    });
</script>
<?php endif; ?>

<?php if ($this->_tpl_vars['UseFilter']): ?>
<?php echo '<div class="grid grid_menu" style="width: auto; padding: 10px; margin-top: 10px;">'; ?><?php echo $this->_tpl_vars['SearchControl']; ?><?php echo '</div><br/>'; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['AllowDeleteSelected']): ?>
<form name="selectedRecords" method="POST" action="<?php echo $this->_tpl_vars['Grid']->GetDeleteSelectedLink(); ?>
">
    <input type="hidden" name="operation" value="delsel">
    <input type="hidden" name="recordCount" value="<?php echo $this->_tpl_vars['RecordCount']; ?>
">
<?php endif; ?>

<?php if ($this->_tpl_vars['Grid']->GetHighlightRowAtHover()): ?>
<script type="text/javascript"> 
    EnableHighlightRowAtHover('.grid');
</script>
<?php endif; ?>

<table
    id="<?php echo $this->_tpl_vars['Grid']->GetName(); ?>
"
    class="grid"
    <?php if (! $this->_tpl_vars['Grid']->UseAutoWidth()): ?>
        style="width: <?php echo $this->_tpl_vars['Grid']->GetWidth(); ?>
"
    <?php endif; ?>
    <?php if ($this->_tpl_vars['Grid']->GetUseFixedHeader()): ?>
        fixed-header="true" header-row-size="2"
    <?php endif; ?>
    <?php if ($this->_tpl_vars['ShowLineNumbers']): ?>
        pad-line-number-count="<?php echo $this->_tpl_vars['LineNumberPadCount']; ?>
"
        show-line-numbers="true" 
        start-number="<?php echo $this->_tpl_vars['StartLineNumbers']; ?>
"
    <?php endif; ?>
    >
<thead>
    <?php if ($this->_tpl_vars['Grid']->GetShowAddButton() || $this->_tpl_vars['AllowDeleteSelected'] || $this->_tpl_vars['Grid']->GetShowUpdateLink()): ?>
    <tr>
        <?php echo '<th colspan="'; ?><?php echo $this->_tpl_vars['ColumnCount']; ?><?php echo '" class="grid_menu">'; ?><?php echo smarty_function_counter(array('start' => 0,'assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php if ($this->_tpl_vars['Grid']->GetShowInlineAddButton()): ?><?php echo ''; ?><?php if ($this->_tpl_vars['grid_menu_links'] > 0): ?><?php echo '|'; ?><?php endif; ?><?php echo '<a class="inline_add_button grid_menu_link" href="#">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecordInline'); ?><?php echo '</a>'; ?><?php echo smarty_function_counter(array('assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['Grid']->GetShowAddButton()): ?><?php echo ''; ?><?php if ($this->_tpl_vars['grid_menu_links'] > 0): ?><?php echo '|'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['Grid']->GetUseModalInserting()): ?><?php echo '<a class="grid_menu_link"dialog-title="'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?><?php echo '"content-link="'; ?><?php echo $this->_tpl_vars['Grid']->GetOpenInsertModalDialogLink(); ?><?php echo ' car.php?hname=car_inline_grid&mo=i"is-insert="true"modal-edit="true"insert-after="table#'; ?><?php echo $this->_tpl_vars['Grid']->GetName(); ?><?php echo ' .new-record-after-row"href="#">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?><?php echo '</a>'; ?><?php else: ?><?php echo '<a class="grid_menu_link" href="'; ?><?php echo $this->_tpl_vars['Grid']->GetAddRecordLink(); ?><?php echo '">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?><?php echo '</a>'; ?><?php endif; ?><?php echo ''; ?><?php echo smarty_function_counter(array('assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['AllowDeleteSelected']): ?><?php echo ''; ?><?php if ($this->_tpl_vars['grid_menu_links'] > 0): ?><?php echo '|'; ?><?php endif; ?><?php echo '<a class="grid_menu_link" href="" onclick="ShowYesNoDialog(\'Confirmation\', \'Delete records?\', function() '; ?>{<?php echo ' document.selectedRecords.submit(); '; ?>}<?php echo ', function () '; ?>{<?php echo ' '; ?>}<?php echo '); return false;">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('DeleteSelected'); ?><?php echo '</a>'; ?><?php echo smarty_function_counter(array('assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['Grid']->GetShowUpdateLink()): ?><?php echo ''; ?><?php if ($this->_tpl_vars['grid_menu_links'] > 0): ?><?php echo '|'; ?><?php endif; ?><?php echo '<a class="grid_menu_link" href="'; ?><?php echo $this->_tpl_vars['Grid']->GetUpdateLink(); ?><?php echo '">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('Refresh'); ?><?php echo '</a>'; ?><?php echo smarty_function_counter(array('assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php endif; ?><?php echo '</th>'; ?>

    </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['Grid']->GetErrorMessage() != ''): ?>
    <tr><th class="odd grid_error_row" colspan="<?php echo $this->_tpl_vars['ColumnCount']; ?>
" >
        <div class="grid_error_message">
        <strong><?php echo $this->_tpl_vars['Captions']->GetMessageString('ErrorsDuringDeleteProcess'); ?>
</strong><br><br>
        <?php echo $this->_tpl_vars['Grid']->GetErrorMessage(); ?>

        </div>
    </th></tr>
    <?php endif; ?>

    <!-- <Grid Head> -->
    <tr id="grid_header">
        <?php if ($this->_tpl_vars['ShowLineNumbers']): ?>
            <th class="odd pgui-line-number-header">#
            </th>
        <?php endif; ?>
        
        <?php if ($this->_tpl_vars['AllowDeleteSelected']): ?>
            <th class="odd row-selector">
                <input type="checkbox" name="rec<?php echo ($this->_foreach['RowsGrid']['iteration']-1); ?>
" onClick="var i; for(i = 0; i < <?php echo $this->_tpl_vars['RecordCount']; ?>
; i++) document.getElementById('rec' + i).checked = this.checked">
            </th>
        <?php endif; ?>
        <!-- <Grid Head Columns> -->
        <?php $_from = $this->_tpl_vars['Bands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['BandsHeader'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['BandsHeader']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Band']):
        $this->_foreach['BandsHeader']['iteration']++;
?>
        <?php if ($this->_tpl_vars['Band']->GetUseConsolidatedHeader()): ?>
            <?php if ($this->_tpl_vars['Band']->HasColumns()): ?>
                <th
                    id="<?php echo $this->_tpl_vars['Band']->GetName(); ?>
"
                    colspan="<?php echo $this->_tpl_vars['Band']->GetColumnCount(); ?>
" <?php if (! ($this->_foreach['BandsHeader']['iteration'] == $this->_foreach['BandsHeader']['total'])): ?>
                    style="<?php if ($this->_tpl_vars['Page']->GetPageDirection() == 'rtl'): ?>border-left<?php else: ?>border-right<?php endif; ?>: solid 2px #000000;"<?php endif; ?>
                    class="<?php if (!(1 & ($this->_foreach['BandsHeader']['iteration']-1))): ?>even<?php else: ?>odd<?php endif; ?>">
                    <?php echo $this->_tpl_vars['Band']->GetCaption(); ?>

                </th>
            <?php endif; ?>
        <?php else: ?>
            <?php $_from = $this->_tpl_vars['Band']->GetColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Header'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Header']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Column']):
        $this->_foreach['Header']['iteration']++;
?>
                <?php echo '<th class="'; ?><?php if (!(1 & ($this->_foreach['Header']['iteration']-1))): ?><?php echo 'even'; ?><?php else: ?><?php echo 'odd'; ?><?php endif; ?><?php echo '"'; ?><?php if ($this->_tpl_vars['HeadColumnsStyles'][($this->_foreach['BandsHeader']['iteration']-1)][($this->_foreach['Header']['iteration']-1)] != ''): ?><?php echo ' style="'; ?><?php echo $this->_tpl_vars['HeadColumnsStyles'][($this->_foreach['BandsHeader']['iteration']-1)][($this->_foreach['Header']['iteration']-1)]; ?><?php echo '"'; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['Renderer']->Render($this->_tpl_vars['Column']->GetHeaderControl()); ?><?php echo '</th>'; ?>

            <?php endforeach; endif; unset($_from); ?>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        <!-- </Grid Head Columns> -->
    </tr>
    <!-- </Grid Head> -->
</thead>
<tbody>
	<tr id="grid_empty" class="new-record-row" style="display: none;" data-new-row="false">
    <?php if ($this->_tpl_vars['ShowLineNumbers']): ?>
        <td class="odd pgui-line-number"></td>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['AllowDeleteSelected']): ?>
        <?php echo '<td class="odd" data-column-name="sm_multi_delete_column"></td>'; ?>

    <?php endif; ?>
        <?php $_from = $this->_tpl_vars['Bands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['BandsHeader'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['BandsHeader']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Band']):
        $this->_foreach['BandsHeader']['iteration']++;
?>
            <?php $_from = $this->_tpl_vars['Band']->GetColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['NewRowTemplate'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['NewRowTemplate']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Column']):
        $this->_foreach['NewRowTemplate']['iteration']++;
?>
                <?php echo '<td data-column-name="'; ?><?php echo $this->_tpl_vars['Column']->GetName(); ?><?php echo '" class="'; ?><?php if (!(1 & ($this->_foreach['NewRowTemplate']['iteration']-1))): ?><?php echo 'even'; ?><?php else: ?><?php echo 'odd'; ?><?php endif; ?><?php echo '"  '; ?><?php if (($this->_foreach['NewRowTemplate']['iteration'] == $this->_foreach['NewRowTemplate']['total']) & ! ($this->_foreach['BandsHeader']['iteration'] == $this->_foreach['BandsHeader']['total'])): ?><?php echo 'style="border-right: solid 2px #000000;"'; ?><?php endif; ?><?php echo '></td>'; ?>

            <?php endforeach; endif; unset($_from); ?>
        <?php endforeach; endif; unset($_from); ?>
	</tr>
    <tr data-new-row="false" class="new-record-after-row" style="display: none; border: none; height: 0px;">
        <td colspan="<?php echo $this->_tpl_vars['ColumnCount']; ?>
" style="border: none; padding: 0px; height: 0px;"></td>
    </tr>


<?php if (count ( $this->_tpl_vars['Rows'] ) > 0): ?>
    <?php $_from = $this->_tpl_vars['Rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['RowsGrid'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['RowsGrid']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Row']):
        $this->_foreach['RowsGrid']['iteration']++;
?>

        <tr class="<?php if (!(1 & ($this->_foreach['RowsGrid']['iteration']-1))): ?>even<?php else: ?>odd<?php endif; ?>"<?php if ($this->_tpl_vars['RowCssStyles'][($this->_foreach['RowsGrid']['iteration']-1)] != ''): ?> style="<?php echo $this->_tpl_vars['RowCssStyles'][($this->_foreach['RowsGrid']['iteration']-1)]; ?>
"<?php endif; ?>>

        <?php if ($this->_tpl_vars['ShowLineNumbers']): ?>
            <td class="odd pgui-line-number"></td>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['AllowDeleteSelected']): ?>
        <?php echo '<td class="odd" '; ?><?php if ($this->_tpl_vars['RowCssStyles'][($this->_foreach['RowsGrid']['iteration']-1)] != ''): ?><?php echo ' style="'; ?><?php echo $this->_tpl_vars['RowCssStyles'][($this->_foreach['RowsGrid']['iteration']-1)]; ?><?php echo '"'; ?><?php endif; ?><?php echo '><input type="checkbox" name="rec'; ?><?php echo ($this->_foreach['RowsGrid']['iteration']-1); ?><?php echo '" id="rec'; ?><?php echo ($this->_foreach['RowsGrid']['iteration']-1); ?><?php echo '" />'; ?><?php $_from = $this->_tpl_vars['RowPrimaryKeys'][($this->_foreach['RowsGrid']['iteration']-1)]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['CPkValues'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['CPkValues']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['PkValue']):
        $this->_foreach['CPkValues']['iteration']++;
?><?php echo '<input type="hidden" name="rec'; ?><?php echo ($this->_foreach['RowsGrid']['iteration']-1); ?><?php echo '_pk'; ?><?php echo ($this->_foreach['CPkValues']['iteration']-1); ?><?php echo '" value="'; ?><?php echo $this->_tpl_vars['PkValue']; ?><?php echo '" />'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</td>'; ?>

        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['Row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['RowColumns'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['RowColumns']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['RowColumn']):
        $this->_foreach['RowColumns']['iteration']++;
?>
        <?php echo '<td data-column-name="'; ?><?php echo $this->_tpl_vars['ColumnsNames'][($this->_foreach['RowColumns']['iteration']-1)]; ?><?php echo '" char="'; ?><?php echo $this->_tpl_vars['RowColumnsChars'][($this->_foreach['RowsGrid']['iteration']-1)][($this->_foreach['RowColumns']['iteration']-1)]; ?><?php echo '" class="'; ?><?php if (!(1 & ($this->_foreach['RowColumns']['iteration']-1))): ?><?php echo 'even'; ?><?php else: ?><?php echo 'odd'; ?><?php endif; ?><?php echo '" '; ?><?php if ($this->_tpl_vars['RowColumnsCssStyles'][($this->_foreach['RowsGrid']['iteration']-1)][($this->_foreach['RowColumns']['iteration']-1)] != ''): ?><?php echo 'style="'; ?><?php echo $this->_tpl_vars['RowColumnsCssStyles'][($this->_foreach['RowsGrid']['iteration']-1)][($this->_foreach['RowColumns']['iteration']-1)]; ?><?php echo '"'; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['RowColumn']; ?><?php echo '</td>'; ?>

        <?php endforeach; endif; unset($_from); ?>
    </tr>
    
        <?php echo '<tr pgui-details="true" style="border: none; height: 0px;"><td colspan="'; ?><?php echo $this->_tpl_vars['ColumnCount']; ?><?php echo '" style="border: none; padding: 0px; height: 0px;">'; ?><?php $_from = $this->_tpl_vars['AfterRows'][($this->_foreach['RowsGrid']['iteration']-1)]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['AfterRow']):
?><?php echo ''; ?><?php echo $this->_tpl_vars['AfterRow']; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '</td></tr>'; ?>

    <?php endforeach; endif; unset($_from); ?>

    <!-- <Totals> -->
    <?php if ($this->_tpl_vars['Grid']->HasTotals()): ?>
        <tr class="grid-totals">
        <?php if ($this->_tpl_vars['ShowLineNumbers']): ?>
            <td></td>
        <?php endif; ?>


        <?php if ($this->_tpl_vars['AllowDeleteSelected']): ?>
            <td></td>
        <?php endif; ?>
        <?php $_from = $this->_tpl_vars['Totals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Total']):
?>
        <?php echo '<td '; ?><?php if ($this->_tpl_vars['Total']['Style'] != ''): ?><?php echo 'style="'; ?><?php echo $this->_tpl_vars['Total']['Style']; ?><?php echo '"'; ?><?php endif; ?><?php echo '>'; ?><?php if (! $this->_tpl_vars['Total']['IsEmpty']): ?><?php echo ''; ?><?php if ($this->_tpl_vars['Total']['CustomValue']): ?><?php echo ''; ?><?php echo $this->_tpl_vars['Total']['UserHTML']; ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php echo $this->_tpl_vars['Total']['Aggregate']; ?><?php echo ' = '; ?><?php echo $this->_tpl_vars['Total']['Value']; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php endif; ?><?php echo '</td>'; ?>

        <?php endforeach; endif; unset($_from); ?>
        </tr>
    <?php endif; ?>
    <!-- </Totals> -->
<?php else: ?> <?php echo '<tr><td colspan="'; ?><?php echo $this->_tpl_vars['ColumnCount']; ?><?php echo '" class="emplygrid">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('NoDataToDisplay'); ?><?php echo '</td></tr>'; ?>

<?php endif; ?> 
<!-- <Bottom menu> -->
<?php if ($this->_tpl_vars['Grid']->GetShowAddButton() || $this->_tpl_vars['AllowDeleteSelected'] || $this->_tpl_vars['Grid']->GetShowUpdateLink()): ?>
    <tr>
        <?php echo '<th colspan="'; ?><?php echo $this->_tpl_vars['ColumnCount']; ?><?php echo '" class="grid_menu">'; ?><?php echo smarty_function_counter(array('start' => 0,'assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php if ($this->_tpl_vars['Grid']->GetShowInlineAddButton()): ?><?php echo ''; ?><?php if ($this->_tpl_vars['grid_menu_links'] > 0): ?><?php echo '|'; ?><?php endif; ?><?php echo '<a class="inline_add_button grid_menu_link" href="#">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecordInline'); ?><?php echo '</a>'; ?><?php echo smarty_function_counter(array('assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['Grid']->GetShowAddButton()): ?><?php echo ''; ?><?php if ($this->_tpl_vars['grid_menu_links'] > 0): ?><?php echo '|'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['Grid']->GetUseModalInserting()): ?><?php echo '<a class="grid_menu_link"dialog-title="'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?><?php echo '"content-link="'; ?><?php echo $this->_tpl_vars['Grid']->GetOpenInsertModalDialogLink(); ?><?php echo ' car.php?hname=car_inline_grid&mo=i"is-insert="true"modal-edit="true"insert-after="table#'; ?><?php echo $this->_tpl_vars['Grid']->GetName(); ?><?php echo ' .new-record-after-row"href="#">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?><?php echo '</a>'; ?><?php else: ?><?php echo '<a class="grid_menu_link" href="'; ?><?php echo $this->_tpl_vars['Grid']->GetAddRecordLink(); ?><?php echo '">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?><?php echo '</a>'; ?><?php endif; ?><?php echo ''; ?><?php echo smarty_function_counter(array('assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['AllowDeleteSelected']): ?><?php echo ''; ?><?php if ($this->_tpl_vars['grid_menu_links'] > 0): ?><?php echo '|'; ?><?php endif; ?><?php echo '<a class="grid_menu_link" href="" onclick="ShowYesNoDialog(\'Confirmation\', \'Delete records?\', function() '; ?>{<?php echo ' document.selectedRecords.submit(); '; ?>}<?php echo ', function () '; ?>{<?php echo ' '; ?>}<?php echo '); return false;">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('DeleteSelected'); ?><?php echo '</a>'; ?><?php echo smarty_function_counter(array('assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['Grid']->GetShowUpdateLink()): ?><?php echo ''; ?><?php if ($this->_tpl_vars['grid_menu_links'] > 0): ?><?php echo '|'; ?><?php endif; ?><?php echo '<a class="grid_menu_link" href="'; ?><?php echo $this->_tpl_vars['Grid']->GetUpdateLink(); ?><?php echo '">'; ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('Refresh'); ?><?php echo '</a>'; ?><?php echo smarty_function_counter(array('assign' => 'grid_menu_links'), $this);?><?php echo ''; ?><?php endif; ?><?php echo '</th>'; ?>

    </tr>
<?php endif; ?>
<!-- </Bottom menu> -->
</tbody>
</table>

<?php if ($this->_tpl_vars['AllowDeleteSelected']): ?></form><?php endif; ?>