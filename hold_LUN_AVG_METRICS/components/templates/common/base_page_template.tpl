<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html{if $Page->GetPageDirection() != null} dir="{$Page->GetPageDirection()}"{/if}>
<head>
    <meta http-equiv="content-type" content="text/html{if $Page->GetContentEncoding() != null}; charset={$Page->GetContentEncoding()}{/if}" />
    <meta name="generator" content="Maestro PHP Generator" />
    {$HeadMetaTags}
    <title>{$Page->GetCaption()}</title>

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

    <script type="text/javascript">{literal}
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

    {/literal}
    </script>

    <script type="text/javascript" src="components/js/require.js"></script>

    {* Header defined in user event *}
    {$Page->GetCustomPageHeader()}

    {* <User javascript events> *}
    <script type="text/javascript">
        try
        {ldelim}
            {$Page->GetCustomClientScript()}
        {rdelim}
        catch(error)
        {ldelim}{rdelim}
        
        $(function(){ldelim}
            try
            {ldelim}
                {$Page->GetOnPageLoadedClientScript()}
            {rdelim}
            catch(error)
            {ldelim}{rdelim}
        {rdelim}
        );

        {$Page->GetValidationScripts()}
    </script>
    {* </User javascript events> *}
</head>
{$ContentBlock}
{$DebugFooter}
</html>