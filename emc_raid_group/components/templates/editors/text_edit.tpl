{strip}
{if not $TextEdit->GetReadOnly()}
    <input {n}
        data-editor="true" {n}
        data-editor-class="TextEdit" {n}
        data-field-name="{$TextEdit->GetFieldName()}" {n}
        data-editable="true" {n}
        {if $TextEdit->GetPasswordMode()}
            type="password" {n}
        {/if} 
        class="sm_text" {n}
        id="{$TextEdit->GetName()}" {n}
        name="{$TextEdit->GetName()}" {n}
        value="{$TextEdit->GetHTMLValue()}" {n}
        {if $TextEdit->GetSize() != null}
            size="{$TextEdit->GetSize()}" {n}
            style="width: auto;" {n}
        {/if}
        {if $TextEdit->GetMaxLength() != null}
            maxlength="{$TextEdit->GetMaxLength()}" {n}
        {/if}
        {$Validators.InputAttributes} {n}
    >
{else}
    {if !$TextEdit->GetPasswordMode()}
        <span {n}
            data-editor="true" {n}
            data-editor-class="TextEdit" {n}
            data-field-name="{$TextEdit->GetFieldName()}" {n}
            data-editable="false" {n}
            >{$TextEdit->GetValue()}</span>
    {else}
        <span {n}
            data-editor="true" {n}
            data-editor-class="TextEdit" {n}
            data-field-name="{$TextEdit->GetFieldName()}" {n}
            data-editable="false" {n}
            >*************</span>
    {/if}
{/if}
{/strip}