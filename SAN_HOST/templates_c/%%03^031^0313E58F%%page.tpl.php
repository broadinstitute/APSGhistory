<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'styleoption', 'edit/page.tpl', 2, false),)), $this); ?>
<?php ob_start(); ?>
<body style="<?php echo smarty_function_styleoption(array('name' => 'margin','value' => $this->_tpl_vars['Page']->Margin), $this);?>
<?php echo smarty_function_styleoption(array('name' => 'padding','value' => $this->_tpl_vars['Page']->Padding), $this);?>
">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/site_header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<br/>
<?php echo $this->_tpl_vars['Grid']; ?>

</body>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php ob_start(); ?><?php echo $this->_tpl_vars['Variables']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('DebugFooter', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/base_page_template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
