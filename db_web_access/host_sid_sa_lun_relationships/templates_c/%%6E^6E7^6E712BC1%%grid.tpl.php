<table align="center" width="95%" border="0" cellpadding="3" cellspacing="2">
    <tr valign="top">
<?php $_from = $this->_tpl_vars['Columns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Column']):
?>
        <td><b><?php echo $this->_tpl_vars['Column']->GetCaption(); ?>
</b></td>
<?php endforeach; endif; unset($_from); ?>
    </tr>
<?php $_from = $this->_tpl_vars['Rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['RowsGrid'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['RowsGrid']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Row']):
        $this->_foreach['RowsGrid']['iteration']++;
?>
    <tr valign="top">
    <!---->
<?php $_from = $this->_tpl_vars['Row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['RowColumn']):
?>
        <td>
            <?php echo $this->_tpl_vars['RowColumn']; ?>

        </td>
<?php endforeach; endif; unset($_from); ?>
    <!---->
    </tr>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['Grid']->HasTotals()): ?>
    <tr>
    <?php $_from = $this->_tpl_vars['Totals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Total']):
?>
    <?php echo '<td>'; ?><?php if (! $this->_tpl_vars['Total']['IsEmpty']): ?><?php echo ''; ?><?php if ($this->_tpl_vars['Total']['CustomValue']): ?><?php echo ''; ?><?php echo $this->_tpl_vars['Total']['UserHTML']; ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php echo $this->_tpl_vars['Total']['Aggregate']; ?><?php echo ' = '; ?><?php echo $this->_tpl_vars['Total']['Value']; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php endif; ?><?php echo '</td>'; ?>

    <?php endforeach; endif; unset($_from); ?>
    </tr>
<?php endif; ?>

</table>