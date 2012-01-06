<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html<?php if ($this->_tpl_vars['Page']->GetPageDirection() != null): ?> dir="<?php echo $this->_tpl_vars['Page']->GetPageDirection(); ?>
"<?php endif; ?>>
<head>
    <meta http-equiv="content-type" content="text/html<?php if ($this->_tpl_vars['Page']->GetContentEncoding() != null): ?>; charset=<?php echo $this->_tpl_vars['Page']->GetContentEncoding(); ?>
<?php endif; ?>" />
    <meta name="generator" content="Maestro PHP Generator" />
    <?php echo $this->_tpl_vars['HeadMetaTags']; ?>

    <title><?php echo $this->_tpl_vars['Page']->GetCaption(); ?>
</title>

    <link rel="stylesheet" type="text/css" href="phpgen.css" />
    <link rel="stylesheet" type="text/css" href="grid.css" />
    <link rel="stylesheet" type="text/css" href="components/css/common_style.css" />
	<link rel="stylesheet" type="text/css" href="libs/jquery/css/jquery-ui-1.8.10.custom.css" media="screen" />

    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="libs/timeentry/jquery.timeentry.ie.css" />
    <![endif]-->

    <script type="text/javascript" src="components/js/underscore.min.js"></script>
    <script type="text/javascript" src="components/js/pgui.main.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.js"></script>

    <script type="text/javascript"><?php echo '
    var require = {
        baseUrl: "components/js",
        deps: PhpGen.ModuleList([
            PhpGen.Module.MooTools,
            PhpGen.Module.UI.Dialog,

            "pgui.master_details",
            "pgui.vertical_grid",
            "pgui.modal_editing",
            PhpGen.Module.PG.DropDownButton,
            "pgui.forms",
            "pgui.validation",
            "pgui.utils",
            "pgui.effects",
            "pgui.unobtrusive",

            "phpgen"
    ], true)};

    '; ?>

    </script>

    <script type="text/javascript" src="components/js/require.js"></script>

        <?php echo $this->_tpl_vars['Page']->GetCustomPageHeader(); ?>


        <script type="text/javascript">
        try
        {
            <?php echo $this->_tpl_vars['Page']->GetCustomClientScript(); ?>

        }
        catch(error)
        {}
        
        $(function(){
            try
            {
                <?php echo $this->_tpl_vars['Page']->GetOnPageLoadedClientScript(); ?>

            }
            catch(error)
            {}
        }
        );

        <?php echo $this->_tpl_vars['Page']->GetValidationScripts(); ?>

    </script>
    </head>
<?php echo $this->_tpl_vars['ContentBlock']; ?>

<?php echo $this->_tpl_vars['DebugFooter']; ?>

</html>