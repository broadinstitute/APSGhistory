<div align="center" style="width: auto">
    <table class="grid" style="width: 500px">
{section name=RowGrid loop=$ColumnCount}
        <tr class="{if $smarty.section.RowGrid.index is even}even{else}odd{/if}"{if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>
            <td class="odd" style="padding-left:20px;"><b>{$Columns[$smarty.section.RowGrid.index]->GetCaption()}</b></td>
            <td class="even" style="padding-left:10px;">
                {$Row[$smarty.section.RowGrid.index]}
            </td>
        </tr>
{/section}
    </table>
</div>
