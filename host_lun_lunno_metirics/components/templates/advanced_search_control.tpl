<div align="center" 
    id="searchControl"
    {if $AdvancedSearchControl->GetHidden()} style="display: none; height: 0px;"{/if}>

    <form method="POST" 
        {if $AdvancedSearchControl->GetTarget() != ''}  action="{$AdvancedSearchControl->GetTarget()}"{/if} 
        id="AdvancedSearchForm" 
        name="AdvancedSearchForm" 
        style="padding: 0px; margin: 0px;">

        <input type="hidden" name="operation" value="asearch" >
        <input type="hidden" id="AdvancedSearch" name="AdvancedSearch" value="1">
        <input type="hidden" id="ResetFilter" name="ResetFilter" value="0">

        <table class="adv_filter">
        
            {if $AdvancedSearchControl->GetAllowOpenInNewWindow()}
            <tr class="adv_filter_top_panel adv_filter_type">
                <td colspan="5">
                    <a href="{$AdvancedSearchControl->GetOpenInNewWindowLink()}">Open in new page</a>
                </td>
            </tr>
            {/if}

        {strip}
        <tr class="adv_filter_title">
            <td colspan="5">
                {$Captions->GetMessageString('AdvancedSearch')}
            </td>
        </tr>
        {/strip}

        <tr class="adv_filter_type">
            <td colspan="5">
                {$Captions->GetMessageString('SearchFor')}:
                <input 
                    type="radio" 
                    name="SearchType" 
                    value="and"
                    {if $AdvancedSearchControl->GetIsApplyAndOperator()} checked{/if}>
                    {$Captions->GetMessageString('AllConditions')}
                &nbsp;&nbsp;&nbsp;
                <input 
                    type="radio" 
                    name="SearchType" 
                    value="pr"
                    {if not $AdvancedSearchControl->GetIsApplyAndOperator()} checked{/if}>{$Captions->GetMessageString('AnyCondition')}
            </td>
        </tr>

    <tr class="adv_filter_head">
        <td class="adv_filter_field_head">&nbsp;</td>
        <td class="adv_filter_not_head">{$Captions->GetMessageString('Not')}</td>
        <td colspan="3" class="adv_filter_editors_head">&nbsp;</td>
    </tr>
{foreach item=Column from=$AdvancedSearchControl->GetSearchColumns() name=ColumnsIterator}
    <tr class="adv_filter_row">
        <td class="adv_filter_field_name_cell">{$Column->GetCaption()}</td>
        <td class="adv_filter_not_cell">
            {smart_strip}
            <input 
                type="checkbox"
                name="{$Column->GetNotMarkInputName()}"
                value="{$FilterTypeIndex}"
                {if $Column->IsApplyNotOperator()} 
                checked="checked"
                {/if}>
            {/smart_strip}
        </td>
        <td class="adv_filter_operator_cell">
            <select 
                class="sm_comboBox adv_filter_type" 
                style="width: 120px;"
                id="{$Column->GetFiterTypeInputName()}"
                name="{$Column->GetFiterTypeInputName()}"
                onchange="if ($('#{$Column->GetFiterTypeInputName()}').val() == 'between') $('#{$Column->GetFieldName()}_second').show(); else $('#{$Column->GetFieldName()}_second').hide(); if ($('#{$Column->GetFiterTypeInputName()}').val() == 'IS NULL') $('{$Column->GetFieldName()}_value').hide(); else $('#{$Column->GetFieldName()}_value').show();">
{foreach key=FilterTypeName item=FilterTypeCaption from=$Column->GetAvailableFilterTypes()}
                {smart_strip}
                <option 
                    value="{$FilterTypeName}"
                    {if $Column->GetActiveFilterIndex() eq $FilterTypeName} 
                    selected
                    {/if}>
                    {$FilterTypeCaption}
                </option>
                {/smart_strip}
{/foreach}
            </select>
        </td>

        <td class="adv_filter_editor1_cell">
            {$Renderer->Render($Column->GetEditorControl())}
        </td>

        <td class="adv_filter_editor2_cell">
            <span id="{$Column->GetFieldName()}_second">
                {$Renderer->Render($Column->GetSecondEditorControl())}
            </span>
        </td>
    </tr>
{/foreach}
    <tr class="adv_filter_footer">
        <td colspan="5" style="padding: 5px;">
            <input 
                id="advsearch_submit" 
                class="sm_button" 
                type="submit" 
                value="{$Captions->GetMessageString('ApplyAdvancedFilter')}" />
            <input
                class="sm_button" 
                type="button" 
                value="{$Captions->GetMessageString('ResetAdvancedFilter')}" 
                onclick="javascript: document.forms.AdvancedSearchForm.ResetFilter.value = '1'; document.forms.AdvancedSearchForm.submit();"/>
        </td>
    </tr>
</table>

<script language="javascript">
{foreach item=Column from=$AdvancedSearchControl->GetSearchColumns() name=ColumnsIterator}
    if ($('#{$Column->GetFiterTypeInputName()}').val() == 'between')
        $('#{$Column->GetFieldName()}_second').show();
    else
        $('#{$Column->GetFieldName()}_second').hide();

    if ($('#{$Column->GetFiterTypeInputName()}').val() == 'IS NULL')
        $('#{$Column->GetFieldName()}_value').hide();
    else
        $('#{$Column->GetFieldName()}_value').show();

{/foreach}

{if $AdvancedSearchControl->IsActive()}
$(document).ready(function(){ldelim}
{foreach from=$AdvancedSearchControl->GetHighlightedFields() item=HighlightFieldName name=HighlightFields}
    HighlightTextInGrid('.grid', '{$HighlightFieldName}',
        '{$TextsForHighlight[$smarty.foreach.HighlightFields.index]}',
        '{$HighlightOptions[$smarty.foreach.HighlightFields.index]}');
{/foreach}
{rdelim});    
{/if}

$(function()
{ldelim}
	$('#advsearch_submit').click(function()
	{ldelim}
		var hasNotEmpty = false;
		$('table.adv_filter').find('td.adv_filter_editor1_cell').find('input,select').each(function()
		{ldelim}
			if ($(this).closest('tr.adv_filter_row').find('.adv_filter_operator_cell').find('select').val() == 'IS NULL')
				hasNotEmpty = true;	
			if ($(this).val() != '')
				hasNotEmpty = true;	
		{rdelim});
		if (!hasNotEmpty) 
			ShowOkDialog(
				'{$Captions->GetMessageString('EmptyFilter_MessageTitle')}', 
				'{$Captions->GetMessageString('EmptyFilter_Message')}');
		return hasNotEmpty;
	{rdelim});
{rdelim});

</script>
</form>
</div>

