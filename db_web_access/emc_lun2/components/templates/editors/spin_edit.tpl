{if !$SpinEdit->GetReadOnly()}
<input
    data-editor="true"
    data-editor-class="SpinEdit"
    data-field-name="{$SpinEdit->GetFieldName()}"
    data-editable="true"

    spinedit="true"
    id="{$SpinEdit->GetName()}"
    name="{$SpinEdit->GetName()}"
    value="{$SpinEdit->GetValue()}"
    {$Validators.InputAttributes}
>
{else}
<span
    data-editor="true"
    data-editor-class="SpinEdit"
    data-field-name="{$SpinEdit->GetFieldName()}"
    data-editable="false"
    >
{$SpinEdit->GetValue()}
</span>

{/if}