<!-- <Pages> -->
<div class="page_navigator">
    <span id="current_page_text">{$PageNavigator->GetCaption()}:</span>
    <select id="{$PageNavigator->GetName()}" class="sm_comboBox">
{foreach item=PageNavigatorPage from=$PageNavigatorPages}
{if $PageNavigatorPage->IsCurrent()}
    <option value="" selected="selected">{$PageNavigatorPage->GetPageCaption()}</option>
{else}
    <option value="{$PageNavigatorPage->GetPageLink()}">{$PageNavigatorPage->GetPageCaption()}</option>
{/if}
{/foreach}
    </select>
    <input type="button" class="sm_button" style="width: 40px;" onclick="if ($(this).closest('div.page_navigator').children('#{$PageNavigator->GetName()}').val() != '') navigate_to($(this).closest('div.page_navigator').children('#{$PageNavigator->GetName()}').val());" value="GO">
</div>
