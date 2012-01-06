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
    <?php echo '
    <!--[if lte IE 6]>
    <style>
        th { behavior: url(\'iepngfix.htc\'); }
        div.site_header_pad
        {
            margin: 0px;
            display: none;
        }
    </style>
    <![endif]-->
    '; ?>


        <script type="text/javascript" src="libs/calendar/js/jscal2.js"></script>
    <script type="text/javascript" src="libs/calendar/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="libs/calendar/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="libs/calendar/css/border-radius.css" />
    
        <link rel="stylesheet" type="text/css" href="phpgen.css" />
    <link rel="stylesheet" type="text/css" href="grid.css" />
    <link rel="stylesheet" type="text/css" href="common_style.css" />
    
    <link rel="stylesheet" type="text/css" href="libs/jquery/css/lightbox.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="libs/jquery/css/jquery-ui-1.8.10.custom.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="libs/spinbox/jquery.spinbox.css" media="screen" />

    <script type="text/javascript" src="libs/jquery/jquery.js"></script>

        <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.button.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.mouse.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.draggable.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.position.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.autocomplete.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.resizable.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.dialog.js"></script>
    
        <script type="text/javascript" src="libs/jquery/jquery.highlight-3.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.hotkeys-0.7.9.min.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.qtips.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.lightbox.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.color.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.colors.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.clearfield.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.fixedtableheader-1-0-2.min.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.maskedinput-1.2.2.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="libs/jquery/tiny_mce/jquery.tinymce.js"></script>
    <script type="text/javascript" src="libs/timeentry/jquery.timeentry.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.form.js	"></script>
	<script type="text/javascript" src="libs/jquery/jquery.query.js	"></script>
    <script type="text/javascript" src="libs/jquery/jquery.blockui.js"></script>
    <script type="text/javascript" src="libs/spinbox/jquery.spinbox.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.validate.js"></script>
    
    <link rel="stylesheet" type="text/css" href="libs/timeentry/jquery.timeentry.css" />
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="libs/timeentry/jquery.timeentry.ie.css" />
    <![endif]-->

        <script type="text/javascript" src="components/js/master_details.js"></script>
    <script type="text/javascript" src="components/js/jquery.pgui_validation.js"></script>
    <script type="text/javascript" src="components/js/vertical_grid.js"></script>
    <script type="text/javascript" src="components/js/jquery.pgui_inline_grid_edit.js"></script>
    <script type="text/javascript" src="components/js/modal_editing.js"></script>
    <script type="text/javascript" src="components/js/utils.js"></script>
    <script type="text/javascript" src="components/js/jquery.pgui_navbar_section.js"></script>
    <script type="text/javascript" src="components/js/jquery.pgui_effects.js"></script>
    <script type="text/javascript" src="components/js/jquery.pgui_unobtrusive.js"></script>
    <script type="text/javascript" src="components/js/pgui_autocomplete.js"></script>
    <script type="text/javascript" src="phpgen.js"></script>

    
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