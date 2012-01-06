<input style="text" class="inputText" name="{$Column->GetFieldName()}" value="{$Value}" />{if $Column->GetAllowNull()}
<input type="checkBox" name="{$Column->GetFieldName()}_SetNull">Set to null
{/if}
{if $Column->GetAllowDefault()}
<input class="inputText" type="checkBox" name="{$Column->GetFieldName()}_SetDefault">Set to default
{/if}