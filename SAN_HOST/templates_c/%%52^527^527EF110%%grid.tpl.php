<div align="center" style="width: auto">
    <?php if ($this->_tpl_vars['PrintOneRecord']): ?>
    <div align="right" style="width: 500px; padding-bottom: 3px;" class="auxiliary_header_text">
        <a href="<?php echo $this->_tpl_vars['PrintRecordLink']; ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('PrintOneRecord'); ?>
</a>
    </div>
    <?php endif; ?>
    <table class="grid" style="width: 500px">
        <tr><th dir="ltr" class="even" colspan=2>
            <?php echo $this->_tpl_vars['Title']; ?>
        </th></tr>
<?php unset($this->_sections['RowGrid']);
$this->_sections['RowGrid']['name'] = 'RowGrid';
$this->_sections['RowGrid']['loop'] = is_array($_loop=$this->_tpl_vars['ColumnCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['RowGrid']['show'] = true;
$this->_sections['RowGrid']['max'] = $this->_sections['RowGrid']['loop'];
$this->_sections['RowGrid']['step'] = 1;
$this->_sections['RowGrid']['start'] = $this->_sections['RowGrid']['step'] > 0 ? 0 : $this->_sections['RowGrid']['loop']-1;
if ($this->_sections['RowGrid']['show']) {
    $this->_sections['RowGrid']['total'] = $this->_sections['RowGrid']['loop'];
    if ($this->_sections['RowGrid']['total'] == 0)
        $this->_sections['RowGrid']['show'] = false;
} else
    $this->_sections['RowGrid']['total'] = 0;
if ($this->_sections['RowGrid']['show']):

            for ($this->_sections['RowGrid']['index'] = $this->_sections['RowGrid']['start'], $this->_sections['RowGrid']['iteration'] = 1;
                 $this->_sections['RowGrid']['iteration'] <= $this->_sections['RowGrid']['total'];
                 $this->_sections['RowGrid']['index'] += $this->_sections['RowGrid']['step'], $this->_sections['RowGrid']['iteration']++):
$this->_sections['RowGrid']['rownum'] = $this->_sections['RowGrid']['iteration'];
$this->_sections['RowGrid']['index_prev'] = $this->_sections['RowGrid']['index'] - $this->_sections['RowGrid']['step'];
$this->_sections['RowGrid']['index_next'] = $this->_sections['RowGrid']['index'] + $this->_sections['RowGrid']['step'];
$this->_sections['RowGrid']['first']      = ($this->_sections['RowGrid']['iteration'] == 1);
$this->_sections['RowGrid']['last']       = ($this->_sections['RowGrid']['iteration'] == $this->_sections['RowGrid']['total']);
?>
        <tr class="<?php if (!(1 & $this->_sections['RowGrid']['index'])): ?>even<?php else: ?>odd<?php endif; ?>"<?php if ($this->_tpl_vars['RowCssStyles'][($this->_foreach['RowsGrid']['iteration']-1)] != ''): ?> style="<?php echo $this->_tpl_vars['RowCssStyles'][($this->_foreach['RowsGrid']['iteration']-1)]; ?>
"<?php endif; ?>>
            <td class="odd" style="padding-left:20px;"><b><?php echo $this->_tpl_vars['Columns'][$this->_sections['RowGrid']['index']]->GetCaption(); ?>
</b></td>
            <td class="even" style="padding-left:10px;">
                <?php echo $this->_tpl_vars['Row'][$this->_sections['RowGrid']['index']]; ?>

            </td>
        </tr>
<?php endfor; endif; ?>
        <tr height="40" class="editor_buttons"><td colspan="2" align="center" valign="middle">
            <input class="sm_button" type="button" value="<?php echo $this->_tpl_vars['Captions']->GetMessageString('BackToList'); ?>
" onclick="window.location.href='<?php echo $this->_tpl_vars['Grid']->GetReturnUrl(); ?>
'"/>
        </td></tr>
    </table>
</div>