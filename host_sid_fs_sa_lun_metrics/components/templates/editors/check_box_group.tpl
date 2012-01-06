{if $RenderText}
{if !$CheckBoxGroup->GetReadOnly()}
{foreach key=Value item=Name from=$CheckBoxGroup->GetValues()}
<label><input type="checkbox" name="{$CheckBoxGroup->GetName()}[]" value="{$Value}" {if $CheckBoxGroup->IsValueSelected($Value)} checked="checked"{/if} {$Validators.InputAttributes}/>{$Name}<label><br/>
{/foreach}
{else}
{foreach key=Value item=Name from=$CheckBoxGroup->GetValues()}
{if $CheckBoxGroup->IsValueSelected($Value)}{$Name}&nbsp;&nbsp;{/if}
{/foreach}
{/if}
{/if}