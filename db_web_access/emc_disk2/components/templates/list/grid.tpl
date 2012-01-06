{if $Grid->GetEnabledInlineEditing()}
<script type="text/javascript">
    {literal}
    require([PhpGen.Module.PG.InlineEdit], function() {
    {/literal}

        $(function()
        {ldelim}
            $('#{$Grid->GetName()}.grid').sm_inline_grid_edit(
            {ldelim}
                cancelButtonHint: '{$Captions->GetMessageString('Cancel')}',
                commitButtonHint: '{$Captions->GetMessageString('Commit')}',
                requestAddress: '{$Grid->GetInlineEditRequestsAddress()}',
                useBlockGUI: true,
                useImagesForActions: {if $Grid->GetUseImagesForActions()}true{else}false{/if},
                editingErrorMessageHeader: '{$Captions->GetMessageString('ErrorsDuringUpdateProcess')}'
            {rdelim});
        {rdelim});
    
    {literal}
    });
    {/literal}
</script>
{/if}

{if $UseFilter}
{strip}
    <div class="grid grid_menu" style="width: auto; padding: 10px; margin-top: 10px;">
        {$SearchControl}
    </div>
    <br/>
{/strip}
{/if}

{if $AllowDeleteSelected}
<form name="selectedRecords" method="POST" action="{$Grid->GetDeleteSelectedLink()}">
    <input type="hidden" name="operation" value="delsel">
    <input type="hidden" name="recordCount" value="{$RecordCount}">
{/if}

{if $Grid->GetHighlightRowAtHover()}
<script type="text/javascript">
    //TODO require
    {literal}
    require(["phpgen"], function()
    {
        EnableHighlightRowAtHover('.grid');
    });
    {/literal}
</script>
{/if}
{strip}
<table {n}
    id="{$Grid->GetName()}" {n}
    class="grid" {n}
    {if !$Grid->UseAutoWidth()}
    style="width: {$Grid->GetWidth()}" {n}
    {/if}
    {if $Grid->GetUseFixedHeader()}
    fixed-header="true" {n}
    header-row-size="2" {n}
    {/if}
    {if $ShowLineNumbers}
    pad-line-number-count="{$LineNumberPadCount}" {n}
    show-line-numbers="true" {n}
    start-number="{$StartLineNumbers}" {n}
    {/if}
    >
<thead>
    {if $Grid->GetShowAddButton() or $AllowDeleteSelected or $Grid->GetShowUpdateLink()}
    <tr>
        <th colspan="{$ColumnCount}" class="grid_menu">

            {counter start=0 assign="grid_menu_links"}

            {if $Grid->GetShowInlineAddButton()}
                {if $grid_menu_links > 0}|{/if}
                <a class="inline_add_button grid_menu_link" href="#">{$Captions->GetMessageString('AddNewRecordInline')}</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $Grid->GetShowAddButton()}
                {if $grid_menu_links > 0}|{/if}

                {if $Grid->GetUseModalInserting()}
                <a class="grid_menu_link" {n}
                    dialog-title="{$Captions->GetMessageString('AddNewRecord')}" {n}
                    content-link="{$Grid->GetOpenInsertModalDialogLink()} car.php?hname=car_inline_grid&mo=i" {n}
                    is-insert="true" {n}
                    modal-edit="true" {n}
                    insert-after="table#{$Grid->GetName()} .new-record-after-row" {n}
                    href="#">{$Captions->GetMessageString('AddNewRecord')}</a>
                {else}
                    <a class="grid_menu_link" href="{$Grid->GetAddRecordLink()}">{$Captions->GetMessageString('AddNewRecord')}</a>
                {/if}
                {counter assign="grid_menu_links"}
            {/if}
            {if $AllowDeleteSelected}
                {if $grid_menu_links > 0}|{/if}
                <a class="grid_menu_link" href="" onclick="ShowYesNoDialog('Confirmation', 'Delete records?', function() {ldelim} document.selectedRecords.submit(); {rdelim}, function () {ldelim} {rdelim}); return false;">
					{$Captions->GetMessageString('DeleteSelected')}
				</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $Grid->GetShowUpdateLink()}
                {if $grid_menu_links > 0}|{/if}
                <a class="grid_menu_link" href="{$Grid->GetUpdateLink()}">{$Captions->GetMessageString('Refresh')}</a>
                {counter assign="grid_menu_links"}
            {/if}
        </th>
    </tr>
    {/if}
    {if $Grid->GetErrorMessage() != ''}
    <tr><th class="odd grid_error_row" colspan="{$ColumnCount}" >
        <div class="grid_message grid_error_message">
        <strong>{$Captions->GetMessageString('ErrorsDuringDeleteProcess')}</strong><br><br>
        {$Grid->GetErrorMessage()}
        </div>
    </th></tr>
    {else}
    {if $Grid->GetGridMessage() != ''}
    <tr><th class="odd grid_error_row" colspan="{$ColumnCount}" >
        <div class="grid_message grid_success_message">
        {$Grid->GetGridMessage()}
        </div>
    </th></tr>
    {/if}
    {/if}

    <!-- <Grid Head> -->
    <tr id="grid_header">
        {if $ShowLineNumbers}
            <th class="odd pgui-line-number-header">#
            </th>
        {/if}
        
        {if $AllowDeleteSelected}
            <th class="odd row-selector">
                <input type="checkbox" name="rec{$smarty.foreach.RowsGrid.index}" onClick="var i; for(i = 0; i < {$RecordCount}; i++) document.getElementById('rec' + i).checked = this.checked">
            </th>
        {/if}
        <!-- <Grid Head Columns> -->
        {foreach item=Band from=$Bands name=BandsHeader}
        {if $Band->GetUseConsolidatedHeader()}
            {if $Band->HasColumns()}
                <th {n}
                    id="{$Band->GetName()}" {n}
                    colspan="{$Band->GetColumnCount()}" {n}
                    {if not $smarty.foreach.BandsHeader.last}
                        style="{if $Page->GetPageDirection() eq 'rtl'}border-left{else}border-right{/if}: solid 2px #000000;" {n}
                    {/if}
                    class="{if $smarty.foreach.BandsHeader.index is even}even{else}odd{/if}">
                    {$Band->GetCaption()}
                </th>
            {/if}
        {else}
            {foreach item=Column from=$Band->GetColumns() name=Header}
                <th class="{if $smarty.foreach.Header.index is even}even{else}odd{/if}"{if $HeadColumnsStyles[$smarty.foreach.BandsHeader.index][$smarty.foreach.Header.index] != ''} style="{$HeadColumnsStyles[$smarty.foreach.BandsHeader.index][$smarty.foreach.Header.index]}"{/if}>
                    {$Renderer->Render($Column->GetHeaderControl())}
                </th>
            {/foreach}
        {/if}
        {/foreach}
        <!-- </Grid Head Columns> -->
    </tr>
    <!-- </Grid Head> -->
</thead>
<tbody>
	<tr id="grid_empty" class="new-record-row" style="display: none;" data-new-row="false">
    {if $ShowLineNumbers}
        <td class="odd pgui-line-number"></td>
    {/if}
    {if $AllowDeleteSelected}
		<td class="odd" data-column-name="sm_multi_delete_column"></td>
    {/if}
        {foreach item=Band from=$Bands name=BandsHeader}
            {foreach item=Column from=$Band->GetColumns() name=NewRowTemplate}
                <td data-column-name="{$Column->GetName()}" class="{if $smarty.foreach.NewRowTemplate.index is even}even{else}odd{/if}"  {if $smarty.foreach.NewRowTemplate.last & !$smarty.foreach.BandsHeader.last}style="border-right: solid 2px #000000;"{/if}>
                </td>
            {/foreach}
        {/foreach}
	</tr>
    <tr data-new-row="false" class="new-record-after-row" style="display: none; border: none; height: 0px;">
        <td colspan="{$ColumnCount}" style="border: none; padding: 0px; height: 0px;"></td>
    </tr>


{if count($Rows) > 0}
{strip}
    {foreach item=Row from=$Rows name=RowsGrid}

    <tr class="{if $smarty.foreach.RowsGrid.index is even}even{else}odd{/if}"{if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>

        {if $ShowLineNumbers}
            <td class="odd pgui-line-number" {if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}></td>
        {/if}

        {if $AllowDeleteSelected}
        <td class="odd" {if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>
            <input type="checkbox" name="rec{$smarty.foreach.RowsGrid.index}" id="rec{$smarty.foreach.RowsGrid.index}" />
            {foreach item=PkValue from=$RowPrimaryKeys[$smarty.foreach.RowsGrid.index] name=CPkValues}
                <input type="hidden" name="rec{$smarty.foreach.RowsGrid.index}_pk{$smarty.foreach.CPkValues.index}" value="{$PkValue}" />
            {/foreach}
        </td>
        {/if}

        {foreach item=RowColumn from=$Row name=RowColumns}
            <td {n}
                data-column-name="{$ColumnsNames[$smarty.foreach.RowColumns.index]}" {n}
                char="{$RowColumnsChars[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index]}" {n}
                class="{if $smarty.foreach.RowColumns.index is even}even{else}odd{/if}" {n}
                {if $RowColumnsCssStyles[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index] != ''} {n}
                    style="{$RowColumnsCssStyles[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index]}" {n}
                {/if}>
                {$RowColumn}
            </td>
        {/foreach}
    </tr>
    
    <tr pgui-details="true" style="border: none; height: 0px;">
        <td colspan="{$ColumnCount}" style="border: none; padding: 0px; height: 0px;">
            {foreach item=AfterRow from=$AfterRows[$smarty.foreach.RowsGrid.index]}
                {$AfterRow}
            {/foreach}
        </td>
    </tr>

    {/foreach}
{/strip}
    <!-- <Totals> -->
    {if $Grid->HasTotals()}
        <tr class="grid-totals">
        {if $ShowLineNumbers}
            <td></td>
        {/if}


        {if $AllowDeleteSelected}
            <td></td>
        {/if}
        {foreach item=Total from=$Totals}
        {strip}
            <td {if $Total.Style != ''}style="{$Total.Style}"{/if}>
            {if not $Total.IsEmpty}
                {if $Total.CustomValue}
                    {$Total.UserHTML}
                {else}
                    {$Total.Aggregate} = {$Total.Value}
                {/if}
            {/if}
            </td>
        {/strip}
        {/foreach}
        </tr>
    {/if}
    <!-- </Totals> -->
{else} {* count($Rows) > 0 *}
    <tr>
        <td colspan="{$ColumnCount}" class="emplygrid">
            {$Captions->GetMessageString('NoDataToDisplay')}
        </td>
    </tr>
{/if} {* count($Rows) > 0 *}

<!-- <Bottom menu> -->
{if $Grid->GetShowAddButton() or $AllowDeleteSelected or $Grid->GetShowUpdateLink()}
    <tr>
        {strip}
        <th colspan="{$ColumnCount}" class="grid_menu">

            {counter start=0 assign="grid_menu_links"}

            {if $Grid->GetShowInlineAddButton()}
                {if $grid_menu_links > 0}|{/if}
                <a class="inline_add_button grid_menu_link" href="#">{$Captions->GetMessageString('AddNewRecordInline')}</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $Grid->GetShowAddButton()}
                {if $grid_menu_links > 0}|{/if}

                {if $Grid->GetUseModalInserting()}
                <a class="grid_menu_link" {n}
                    dialog-title="{$Captions->GetMessageString('AddNewRecord')}" {n}
                    content-link="{$Grid->GetOpenInsertModalDialogLink()} car.php?hname=car_inline_grid&mo=i" {n}
                    is-insert="true" {n}
                    modal-edit="true" {n}
                    insert-after="table#{$Grid->GetName()} .new-record-after-row" {n}
                    href="#">{$Captions->GetMessageString('AddNewRecord')}</a>
                {else}
                    <a class="grid_menu_link" href="{$Grid->GetAddRecordLink()}">{$Captions->GetMessageString('AddNewRecord')}</a>
                {/if}
                {counter assign="grid_menu_links"}
            {/if}
            {if $AllowDeleteSelected}
                {if $grid_menu_links > 0}|{/if}
                <a class="grid_menu_link" href="" onclick="ShowYesNoDialog('Confirmation', 'Delete records?', function() {ldelim} document.selectedRecords.submit(); {rdelim}, function () {ldelim} {rdelim}); return false;">
					{$Captions->GetMessageString('DeleteSelected')}
				</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $Grid->GetShowUpdateLink()}
                {if $grid_menu_links > 0}|{/if}
                <a class="grid_menu_link" href="{$Grid->GetUpdateLink()}">{$Captions->GetMessageString('Refresh')}</a>
                {counter assign="grid_menu_links"}
            {/if}
        </th>
        {/strip}
    </tr>
{/if}
<!-- </Bottom menu> -->
</tbody>
</table>
{/strip}
{if $AllowDeleteSelected}</form>{/if}