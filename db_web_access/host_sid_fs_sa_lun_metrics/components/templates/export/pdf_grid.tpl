<table border="1">
    <tr>
    {foreach item=Caption from=$HeaderCaptions}
        <td style="padding: 2px; font-weight: bold; background-color: #ddd;">{$Caption}</td>
    {/foreach}
    </tr>

    {foreach item=Row from=$Rows name=RowsGrid}
    <tr>
        {foreach item=RowColumn from=$Row}
            <td {if $RowColumn.Align != null} align="{$RowColumn.Align}"{/if} style="padding: 2px;">
                {$RowColumn.Value}
            </td>
        {/foreach}
    </tr>
    {/foreach}
</table>