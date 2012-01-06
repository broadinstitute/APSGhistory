{if $RenderText}
{if !$ComboBox->GetReadOnly()}<select id="{$ComboBox->GetName()}" name="{$ComboBox->GetName()}" {$Validators.InputAttributes}>
{if $ComboBox->ShowEmptyValue()}
    <option value="">{$ComboBox->GetEmptyValue()}</option>
{/if}
{if $ComboBox->HasMFUValues()}
{foreach key=Value item=Name from=$ComboBox->GetMFUValues()}
<option value="{$Value}">{$Name}</option>
{/foreach}
<option value="----------" disabled="disabled">----------</option>
{/if}
{foreach key=Value item=Name from=$ComboBox->GetDisplayValues()}
    <option value="{$Value}"{if $ComboBox->GetSelectedValue() eq $Value} selected{/if}>{$Name}</option>
{/foreach}
</select>{else}
{foreach key=Value item=Name from=$ComboBox->GetValues()}
{if $ComboBox->GetSelectedValue() eq $Value}{$Name}{/if}
{/foreach}
{/if}
{/if}