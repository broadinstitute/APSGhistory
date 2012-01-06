{capture assign="HeadMetaTags"}
    {if $Page->HasRss()}
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{$Page->GetRssLink()}" />
    {/if}
    {$HeadMetaTags}
{/capture}

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
            $Page->GetShowPageList() or
            $Page->GetPrinterFriendlyAvailable() or
            $Page->GetPrinterFriendlyAvailable() or
            $Page->GetExportToExcelAvailable() or
            $Page->GetExportToWordAvailable() or
            $Page->GetExportToXmlAvailable() or
            $Page->GetExportToCsvAvailable() or
            $Page->GetExportToPdfAvailable()}

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
                </div>
            {/if}

            {if $Page->GetShowPageList()}
                <div id="pages_section" class="page_list">
                    <img src="images/home.gif" />
                    <span id="current_page_text">{$Captions->GetMessageString('CurrentPage')}::</span>
                    <br/>
{if $Page->HasRss()}
<span id="current_page" style="white-space: normal; padding-left: 0px">
<a title="RSS" href="{$Page->GetRssLink()}"><img alt="RSS" src="images/rss_small.png" style="position: relative; top: 3px;"/></a>
{$Page->GetShortCaption()}
</span>
{else}
<span id="current_page" style="white-space: normal; padding-left: 20px">{$Page->GetShortCaption()}</span>
{/if}
                    {$PageList}
                </div>
            {/if}

            {if $Page->GetPrinterFriendlyAvailable()}
                <div id="print_section" class="page_list">
                    <div class="navbar_section_break" style="margin-top: 10px;"></div>
                        <h3 id="print_section_header"><span>{$Captions->GetMessageString('Print')}</span></h3>
                        <ul>
                            <li><a href="{$Page->GetPrintCurrentPageLink()}"><span>{$Captions->GetMessageString('PrintCurrentPage')}</span></a></li>
                            <li><a href="{$Page->GetPrintAllLink()}"><span>{$Captions->GetMessageString('PrintAllPages')}</span></a></li>
                        </ul>
                </div>
            {/if}

            {if $Page->GetExportToExcelAvailable() or $Page->GetExportToWordAvailable() or $Page->GetExportToXmlAvailable() or $Page->GetExportToCsvAvailable() or $Page->GetExportToPdfAvailable()}
                <div id="export_section" class="page_list">
                    <div class="navbar_section_break"></div>
                    <h3><span>{$Captions->GetMessageString('Export')}</span></h3>
                    <ul>
                        {if $Page->GetExportToExcelAvailable()}
                        <li><a href="{$Page->GetExportToExcelLink()}"><span>{$Captions->GetMessageString('ExportToExcel')}</span></a></li>
                        {/if}
                        {if $Page->GetExportToWordAvailable()}
                        <li><a href="{$Page->GetExportToWordLink()}"><span>{$Captions->GetMessageString('ExportToWord')}</span></a></li>
                        {/if}
                        {if $Page->GetExportToXmlAvailable()}
                        <li><a href="{$Page->GetExportToXmlLink()}"><span>{$Captions->GetMessageString('ExportToXml')}</span></a></li>
                        {/if}
                        {if $Page->GetExportToCsvAvailable()}
                        <li><a href="{$Page->GetExportToCsvLink()}"><span>{$Captions->GetMessageString('ExportToCsv')}</span></a></li>
                        {/if}
                        {if $Page->GetExportToPdfAvailable()}
                        <li><a href="{$Page->GetExportToPdfLink()}"><span>{$Captions->GetMessageString('ExportToPdf')}</span></a></li>
                        {/if}
                    </ul>
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
            {if $Page->GetMessage() != null && $Page->GetMessage() != ''}
                <span style="color: #FF0000">{$Page->GetMessage()}</span>
            {/if}
                <table height="0">
                    <tr>
                        <td style="padding: 0px;"><h2 class="page_header" style="margin: 0px;">{$Page->GetCaption()}</h2></td>
                        <td valign="top" style="padding: 0px; padding-top: 5px;"><a title="{$Captions->GetMessageString('PrinterFriendly')}" href="{$Page->GetPrintCurrentPageLink()}">{if $Page->GetPrinterFriendlyAvailable()}<img style="border: none;" alt="{$Captions->GetMessageString('PrinterFriendly')}" src="images/print.png"></a>{/if}</td>
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

            {$ContentBlock}

            {if $Page->GetShowBottomPageNavigator()}
            {$PageNavigator2}
            {/if}
        </td>
    </tr>
</table>

{$Page->GetFooter()}

</body>
{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}