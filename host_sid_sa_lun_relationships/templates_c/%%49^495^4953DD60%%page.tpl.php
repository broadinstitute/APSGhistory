<html<?php if ($this->_tpl_vars['Page']->GetPageDirection() != null): ?> dir="<?php echo $this->_tpl_vars['Page']->GetPageDirection(); ?>
"<?php endif; ?>>
    <head>
        <title><?php echo $this->_tpl_vars['Page']->GetCaption(); ?>
</title>
        <meta http-equiv="content-type" content="text/html<?php if ($this->_tpl_vars['Page']->GetContentEncoding() != null): ?>; charset=<?php echo $this->_tpl_vars['Page']->GetContentEncoding(); ?>
<?php endif; ?>">
    </head>
<style>
img
{
    border-width: 0px;
}
body
{
    font-family: Verdana;
}
table
{
    border-collapse: collapse;
}
td
{
    font-size: 11;
    padding: 5px;
    margin: 0px;
    border-width: 1px;
    border-style: solid;
    border-color: #000000;
}
@media print
{
    a.pdf
    {
        display:none
    }
}

</style>
<body style="background-color:white">
    <h1><?php echo $this->_tpl_vars['Page']->GetCaption(); ?>
</h1>
<?php echo $this->_tpl_vars['Grid']; ?>

</body>
</html>