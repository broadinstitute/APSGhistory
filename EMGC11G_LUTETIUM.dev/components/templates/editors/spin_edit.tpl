{if !$SpinEdit->GetReadOnly()}
<input
    spinedit="true"
    id="{$SpinEdit->GetName()}"
    name="{$SpinEdit->GetName()}"
    value="{$SpinEdit->GetValue()}"
    {$Validators.InputAttributes}
>
{else}
{$SpinEdit->GetValue()}
{/if}