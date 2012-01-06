{capture assign="ContentBlock"}
<body onload="HideSearchControl();">
{if not $Page->GetVisualEffectsEnabled()}<script>jQuery.fx.off = true;</script>{/if}
{include file='common/site_header.tpl'}
<table>
{if $Page->GetShowUserAuthBar() or $Page->GetShowPageList()}
<tr><td colspan="2" class="top_panel"><a
    class="hide_right_panel" href="#"
    onclick="ToogleSideBar(); return false;">{$Captions->GetMessageString('ShowHideNavbar')}</a></tr>
<tr>
{/if}
    <td valign="top">
{if $Page->GetShowUserAuthBar() or $Page->GetShowPageList() or $Page->GetPrinterFriendlyAvailable() or   $Page->GetPrinterFriendlyAvailable() or $Page->GetExportToExcelAvailable() or $Page->GetExportToWordAvailable() or $Page->GetExportToXmlAvailable() or $Page->GetExportToCsvAvailable() or $Page->GetExportToPdfAvailable()}
        <div id="right_side_bar">
{if $Page->GetShowUserAuthBar()}
    <div class="auth_bar">
        {if $Page->IsCurrentUserLoggedIn()}
            <span id="loggen_in_as_text">{$Captions->GetMessageString('LoggedInAs')}</span>:<br>
            <span id="user_name">{$Page->GetCurrentUserName()}</span><br>
            <a href="login.php?operation=logout">{$Captions->GetMessageString('Logout')}</a>
        {else}
            <span id="loggen_in_as_text">{$Captions->GetMessageString('YouAreNotLoggedIn')}</span>
            <br><a href="login.php">{$Captions->GetMessageString('Login')}</a>
        {/if}
    </div>
{/if}

{if $Page->GetShowPageList()}
    <div class="page_list">
        <img src="images/home.gif" /><span id="current_page_text">{$Captions->GetMessageString('CurrentPage')}::</span><br/><span id="current_page" style="white-space: normal; padding-left: 20px">{$Page->GetShortCaption()}</span>
        {$PageList}
    </div>
{/if}

    </div>
    <script>
        ApplySideBarPosition();
    </script>
{/if}
</td>
<td valign="top">
    <div style="margin-bottom: 10px;">
        {if $Page->GetMessage() != null && $Page->GetMessage() != ''}
            <span style="color: #FF0000">{$Page->GetMessage()}</span>
        {/if}
        <table height="0">
            <tr>
                <td style="padding: 0px;"><h2 class="page_header" style="margin: 0px;">{$Page->GetCaption()}</h2></td>
                <td valign="top" style="padding: 0px; padding-top: 5px;"></td>
                {if $Page->GetAdvancedSearchAvailable()}
                {if isset($AdvancedSearch) and !empty($AdvancedSearch)}
                {strip}
                    <td valign="top" style="padding: 0px; padding-top: 7px">
                        <a id="advanced_search_link" href="javascript:;" onclick="javascript: $('#searchControl').slideToggle('slow');" class="adv_filter_link{if $IsAdvancedSearchActive} active{/if}">
                            {$Captions->GetMessageString('AdvancedSearch')}
                            {if $IsAdvancedSearchActive} *{/if}
                        </a>
                        {if $IsAdvancedSearchActive}
                            <div style="display: none;" id="advanced_search_condition">
                                {$Captions->GetMessageString('SearchCondtitions')}:
                                <table class="advanced_search_hint">
                                {foreach from=$FriendlyAdvancedSearchCondition item=FieldCondition}
                                    <tr>
                                        <td>{$FieldCondition.Caption}</td>
                                        <td>{$FieldCondition.Condition}</td>
                                    </tr>
                                {/foreach}
                                </table>
                            </div>
                        {/if}
                    </td>
                {/strip}
                {/if}
                {/if}
            </tr>
        </table>
    </div>
{if $Page->GetAdvancedSearchAvailable()}{$AdvancedSearch}{/if}
<script>
    function HideSearchControl()
    {ldelim}
        $('#searchControl').css('display', '');
        $('#searchControl').hide();
        $('#searchControl').css('height', 'auto');
    {rdelim}
</script>
{if $Page->GetGridHeader() != ''}
<div style="margin-top: 5px; margin-bottom: 5px;">
{$Page->GetGridHeader()}
</div>
{/if}
{if $Page->GetShowTopPageNavigator()}
    {$PageNavigator}
{/if}

{if $IsAdvancedSearchActive}
<script>
    $('#advanced_search_link').qtip(
        {ldelim}
            container: 'advanced_search_link_cont',
            content:($('#advanced_search_condition').html()),
            position:'center',
            tip_class: 'qtip-wrapper-asearch'
        {rdelim});
</script>
{/if}

<div class="grid_error_message">
<strong>{$Captions->GetMessageString('ErrorsDuringDataRetrieving')}</strong><br><br>
{$ErrorMessage}
</div>
            </td>
        </tr>
    </table>
    {$Page->GetFooter()}
</body>
{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}