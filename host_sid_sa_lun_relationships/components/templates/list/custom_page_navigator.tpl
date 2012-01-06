<!-- <Pages> -->
<div class="page_navigator">
    <span id="current_page_text">{$PageNavigator->GetCaption()}:</span>
{foreach item=PageNavigatorPage from=$PageNavigatorPages}
{if $PageNavigatorPage->IsCurrent()}
<span id="current_page">{$PageNavigatorPage->GetPageCaption()}</span>
{else}
<a href="{$PageNavigatorPage->GetPageLink()}" class="page_link">{$PageNavigatorPage->GetPageCaption()}</a>
{/if}
{/foreach}
</div>
