{strip}
{if count($Rows) > 0}
    {foreach item=Row from=$Rows name=RowsGrid}
        <tr class="{if $smarty.foreach.RowsGrid.index is even}even{else}odd{/if}"{if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>

        {if $ShowLineNumbers}
            <td class="odd pgui-line-number"></td>
        {/if}
        {if $AllowDeleteSelected}
        {strip}
        <td class="odd" {if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>
            <input type="checkbox" name="rec{$smarty.foreach.RowsGrid.index}" id="rec{$smarty.foreach.RowsGrid.index}" />
            {foreach item=PkValue from=$RowPrimaryKeys[$smarty.foreach.RowsGrid.index] name=CPkValues}
                <input type="hidden" name="rec{$smarty.foreach.RowsGrid.index}_pk{$smarty.foreach.CPkValues.index}" value="{$PkValue}" />
            {/foreach}
        </td>
        {/strip}
        {/if}

        {foreach item=RowColumn from=$Row name=RowColumns}
        {strip}
            <td data-column-name="{$ColumnsNames[$smarty.foreach.RowColumns.index]}" char="{$RowColumnsChars[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index]}" class="{if $smarty.foreach.RowColumns.index is even}even{else}odd{/if}" {if $RowColumnsCssStyles[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index] != ''}style="{$RowColumnsCssStyles[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index]}"{/if}>
                {$RowColumn}
            </td>
        {/strip}
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
{/if}
{/strip}