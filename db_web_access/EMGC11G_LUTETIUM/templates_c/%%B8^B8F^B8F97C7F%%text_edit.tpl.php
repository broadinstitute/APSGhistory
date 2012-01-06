<?php if (! $this->_tpl_vars['TextEdit']->GetReadOnly()): ?>
    <input
        <?php if ($this->_tpl_vars['TextEdit']->GetPasswordMode()): ?>
            type="password"
        <?php endif; ?> 
        class="sm_text"
        id="<?php echo $this->_tpl_vars['TextEdit']->GetName(); ?>
"
        name="<?php echo $this->_tpl_vars['TextEdit']->GetName(); ?>
"
        value="<?php echo $this->_tpl_vars['TextEdit']->GetHTMLValue(); ?>
"
        <?php if ($this->_tpl_vars['TextEdit']->GetSize() != null): ?>
            size="<?php echo $this->_tpl_vars['TextEdit']->GetSize(); ?>
"
            style="width: auto;"
        <?php endif; ?>
        <?php if ($this->_tpl_vars['TextEdit']->GetMaxLength() != null): ?>
            maxlength="<?php echo $this->_tpl_vars['TextEdit']->GetMaxLength(); ?>
"
        <?php endif; ?>
        <?php echo $this->_tpl_vars['Validators']['InputAttributes']; ?>

    >
<?php else: ?>
    <?php if (! $this->_tpl_vars['TextEdit']->GetPasswordMode()): ?>
        <?php echo $this->_tpl_vars['TextEdit']->GetValue(); ?>

    <?php else: ?>
        *************
    <?php endif; ?>
<?php endif; ?>