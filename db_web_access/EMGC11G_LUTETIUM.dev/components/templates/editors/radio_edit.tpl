{if !$RadioEdit->GetReadOnly()}
{foreach key=Value item=Name from=$RadioEdit->GetValues()}
<label><input id="{$RadioEdit->GetName()}" name="{$RadioEdit->GetName()}" value="{$Value}"{if $RadioEdit->GetSelectedValue() eq $Value} checked="checked"{/if} type="radio" {$Validators.InputAttributes}>{$Name}</label>
{/foreach}
{else}
{foreach key=Value item=Name from=$RadioEdit->GetValues()}
{if $RadioEdit->GetSelectedValue() eq $Value}{$Name}{/if}
{/foreach}
{/if}

