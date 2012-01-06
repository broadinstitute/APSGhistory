{strip}
    <h3><span>{$Captions->GetMessageString('PageList')}</span></h3>
    <ul>
{foreach item=PageLink from=$PageList->GetPages()}        
{if $PageLink->GetShowAsText()}
        <li><b><span title="{$PageLink->GetHint()}">{$PageLink->GetCaption()}</span></b></li>
{else}
    {if $PageLink->GetBeginNewGroup()}
        </ul>
        <div style="margin: 10px 0;" class="navbar_section_break"></div>
        <ul>
    {/if}

        <li><a href="{$PageLink->GetLink()}" title="{$PageLink->GetHint()}"><span title="{$PageLink->GetHint()}">{$PageLink->GetCaption()}</span></a></li>
{/if}
{/foreach}
    </ul>
{/strip}