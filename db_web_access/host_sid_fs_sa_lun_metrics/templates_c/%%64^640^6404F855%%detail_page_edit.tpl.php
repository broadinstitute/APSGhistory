<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_indent', 'list/detail_page_edit.tpl', 19, false),)), $this); ?>
<?php ob_start(); ?><div align="center" style="padding-bottom: 5px;">
    <table border=0 cellpadding=0 cellspacing=0 class=main_table_border2 width=100%><tr><td>
        <table class="main_table_border" cellspacing="0" cellpadding="0" width=100% border=0>
            <tr><td height="20" valign=middle align=center style="padding-top:0px;">
                <table class="data" border="0" cellspacing="0" cellpadding="3" width="100%">
                    <tr class="blackshade" valign="top">
                        <td class="headerlist">
                            <span dir="ltr">
                            <?php echo $this->_tpl_vars['Captions']->GetMessageString('MasterRecord'); ?>

                            (<a href="<?php echo $this->_tpl_vars['Page']->GetParentPageLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ReturnFromDetailToMaster'); ?>
</a>)
                            </span>
                        </td>
                    </tr>
                </table>
            </td></tr>
         </table>
     </td></tr></table>
</div>
<?php echo smarty_function_html_indent(array('value' => 1,'text' => $this->_tpl_vars['MasterGrid']), $this);?>
<br />
<?php echo smarty_function_html_indent(array('value' => 1,'text' => $this->_tpl_vars['Grid']), $this);?>

<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php ob_start(); ?><?php echo $this->_tpl_vars['Variables']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('DebugFooter', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/list_page_template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>