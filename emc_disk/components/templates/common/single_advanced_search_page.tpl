{capture assign="ContentBlock"}
<body onload="HideSearchControl();">

{if not $Page->GetVisualEffectsEnabled()}
<!-- Turn on visual effects -->
<script type="text/javascript">
    jQuery.fx.off = true;
</script>
{/if}

{include file='common/site_header.tpl'}

<table>
    {if $Page->GetShowUserAuthBar() or 
        $Page->GetShowPageList() or
        $Page->GetPrinterFriendlyAvailable() or
        $Page->GetPrinterFriendlyAvailable() or
        $Page->GetExportToExcelAvailable() or
        $Page->GetExportToWordAvailable() or
        $Page->GetExportToXmlAvailable() or
        $Page->GetExportToCsvAvailable() or
        $Page->GetExportToPdfAvailable()}
    <tr>
        <td colspan="2" class="top_panel">
        <a class="hide_right_panel" href="#" onclick="ToogleSideBar(); return false;">
            {$Captions->GetMessageString('ShowHideNavbar')}
        </a>
        </td>
    </tr>
    {/if}

    <tr>    
        <td valign="top">
        {if $Page->GetShowUserAuthBar() or 
            $Page->GetShowPageList()}

            <div id="right_side_bar">
            {if $Page->GetShowUserAuthBar()}
                <div class="auth_bar">
                {if $Page->IsCurrentUserLoggedIn()}
                    <span id="loggen_in_as_text">{$Captions->GetMessageString('LoggedInAs')}</span>:<br>
                    <span id="user_name">{$Page->GetCurrentUserName()}</span><br>
                    <a href="login.php?operation=logout">{$Captions->GetMessageString('Logout')}</a>
                {else}
                    <span id="loggen_in_as_text">{$Captions->GetMessageString('YouAreNotLoggedIn')}</span><br>
                    <a href="login.php">{$Captions->GetMessageString('Login')}</a>
                {/if}
            {/if}
            </div>

            {if $Page->GetShowPageList()}
                <div id="pages_section" class="page_list">
                    <img src="images/home.gif" /><span id="current_page_text">{$Captions->GetMessageString('CurrentPage')}::</span><br/><span id="current_page" style="white-space: normal; padding-left: 20px">{$Page->GetShortCaption()}</span>
                    {$PageList}
                </div>
            {/if}

        </div>
        <script type="text/javascript">
            ApplySideBarPosition();
        </script>
        {/if}
        </td>

        <td valign="top">
            <div style="margin-bottom: 10px;">
                <h2 class="page_header" style="margin: 0px;">{$Page->GetCaption()}</h2>
            </div>

            {if $Page->GetAdvancedSearchAvailable()}{$AdvancedSearch}{/if}

            {$ContentBlock}

        </td>
    </tr>
</table>

{$Page->GetFooter()}

</body>
{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}