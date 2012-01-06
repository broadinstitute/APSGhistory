<!-- <Pages> -->
<div class="page_navigator">
{if $PageNavigator->GetPageCount() > 1}
    <span id="current_page_text">
    {assign var="current_page" value=$PageNavigator->CurrentPageNumber()}
    {assign var="page_count" value=$PageNavigator->GetPageCount()}
    {assign var="current_page_info_template" value=$Captions->GetMessageString('PageNumbetOfCount')}
    {eval var=$current_page_info_template}
    </span>
<span dir="ltr">
{foreach item=PageNavigatorPage from=$PageNavigatorPages}
{if $PageNavigatorPage->IsCurrent()}
                        <span id="current_page" title="{$PageNavigatorPage->GetHint()}">{$PageNavigatorPage->GetPageCaption()}</span>
{else}
                        <a href="{$PageNavigatorPage->GetPageLink()}" class="page_link" title="{$PageNavigatorPage->GetHint()}">{$PageNavigatorPage->GetPageCaption()}</a>
{/if}
{/foreach}
<span>
{/if}
</div>


<script>
    {if $PageNavigator->HasPreviosPage()}
    BindPageDecrementShortCut('{$PageNavigator->PreviosPageLink()}');
    {/if}
    {if $PageNavigator->HasNextPage()}
    BindPageIncrementShortCut('{$PageNavigator->NextPageLink()}');
    {/if}
		
	$(function()
	{ldelim}

		$('#pgui-dialog-cusomize-page-nav-size_{$PageNavId}').dialog(
		{ldelim}
			autoOpen: false,
			resizable: false,
			modal: true,
			width : 400,
			buttons: {ldelim}
				OK: function() {ldelim}
					ApplyPageSize($('#pgui-dialog-cusomize-page-nav-size_{$PageNavId}'));
					$(this).dialog('close');
				{rdelim},
				Cancel: function() {ldelim}
					$(this).dialog('close');
				{rdelim}
			{rdelim}
		{rdelim});

	
		$('#pgui-customize-page-nav-size_{$PageNavId}').click(
		function()
		{ldelim}
			$('#pgui-dialog-cusomize-page-nav-size_{$PageNavId}').dialog('open');
			return false;
		{rdelim});
			
	{rdelim});
	

</script>

{if ($PageNavigator->GetPageCount() > 1) | ( ($PageNavigator->GetPageCount() <= 1) & ($PageNavId == 1) )}
{if $PageNavigator->GetRowsPerPage() == 0}
	{assign var="rec_count_per_page" value=$PageNavigator->GetRowCount()}
{else}
	{assign var="rec_count_per_page" value=$PageNavigator->GetRowsPerPage()}
{/if}
<a href="#" id="pgui-customize-page-nav-size_{$PageNavId}" class="pgui-customize-page-nav-size">{eval var=$Captions->GetMessageString('CustomizePageSize')}</a>

<div title="{$Captions->GetMessageString('ChangePageSizeTitle')}" style="display: none;" class="pgui-dialog-cusomize-page-nav-size" id="pgui-dialog-cusomize-page-nav-size_{$PageNavId}">

	{assign var="row_count" value=$PageNavigator->GetRowCount()}
	<p>{eval var=$Captions->GetMessageString('ChangePageSizeText')}</p>

	<table cellspacing="0" cellpadding="0" class="pgui-select-page-size">
		<tr>
			<th>{$Captions->GetMessageString('RecordsPerPage')}</th>
			<th>{$Captions->GetMessageString('TotalPages')}</th>
		</tr>
		{foreach from=$PageNavigator->GetRecordsPerPageValues() key=name item=value}
		<tr>
			<td><input type="radio" value="{$name}" name="recperpage_{$PageNavId}">{$value}</td>
			<td>{$PageNavigator->GetPageCountForPageSize($name)}</td>
		</tr>
		{/foreach}
		<tr>
			<td>
				<input type="radio" value="custom" name="recperpage_{$PageNavId}" checked="checked">
				{$Captions->GetMessageString('UseCustomPageSize')}<br>
				<input 
					onkeyup="$('#custom_page_size_page_count_{$PageNavId}').html( GetPageCountForPageSize(this.value, {$PageNavigator->GetRowCount()}) )" 
					name="recperpage_custom" value="{$PageNavigator->GetRowsPerPage()}" class="pgui-custom-page-size"></input>
			</td>
			<td><span id="custom_page_size_page_count_{$PageNavId}">{$PageNavigator->GetPageCount()}</span></td>
		</tr>
	</table>
</div>
{/if}

