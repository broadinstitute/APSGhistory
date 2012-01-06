<?php if (! $this->_tpl_vars['DateTimeEdit']->GetReadOnly()): ?>
<?php if ($this->_tpl_vars['RenderText']): ?>
<span>
    <input class="pgui-date-time-edit" type="text" name="<?php echo $this->_tpl_vars['DateTimeEdit']->GetName(); ?>
" id="<?php echo $this->_tpl_vars['DateTimeEdit']->GetName(); ?>
" value="<?php echo $this->_tpl_vars['DateTimeEdit']->GetValue(); ?>
" <?php echo $this->_tpl_vars['Validators']['InputAttributes']; ?>
>
    <div title="Show date time picker" href="#" class="pgui-date-time-edit-picker" id="<?php echo $this->_tpl_vars['DateTimeEdit']->GetName(); ?>
_trigger"></div>
</span>
<?php endif; ?>
<?php if ($this->_tpl_vars['RenderScripts']): ?>
<?php if ($this->_tpl_vars['RenderText']): ?>
<script type="text/javascript">
<?php endif; ?>
    Calendar.setup({
        inputField     :    "<?php echo $this->_tpl_vars['DateTimeEdit']->GetName(); ?>
",
        dateFormat     :    "<?php echo $this->_tpl_vars['DateTimeEdit']->GetFormat(); ?>
",
        showTime       :    <?php if ($this->_tpl_vars['DateTimeEdit']->GetShowsTime()): ?>true<?php else: ?>false<?php endif; ?>,
        trigger        :    "<?php echo $this->_tpl_vars['DateTimeEdit']->GetName(); ?>
_trigger",
        minuteStep     :    1,
        onSelect       :    function() { this.hide() },
        fdow           :    <?php echo $this->_tpl_vars['DateTimeEdit']->GetFirstDayOfWeek(); ?>

    });
<?php if ($this->_tpl_vars['RenderText']): ?>
</script>
<?php endif; ?>
<?php endif; ?>
<?php else: ?>
<?php if ($this->_tpl_vars['RenderText']): ?>
<?php echo $this->_tpl_vars['DateTimeEdit']->GetValue(); ?>

<?php endif; ?>
<?php endif; ?>