{if !$ComboBox->GetReadOnly()}
{if $RenderText}
{strip}
<div
    {n}data-editor="true"
    {n}data-editor-class="Autocomplete"
    {n}data-editable="true"
    {n}data-field-name="{$ComboBox->GetFieldName()}"
    {n}id="{$ComboBox->GetName()}_container" class="dropdown_container" style="width: {$ComboBox->GetSize()};">
    <table class="dropdown_button_container" cellpadding="0" cellspacing="0">
        <tr>
            <td class="dropdown_input_container" style="background-color: #fff;">
                <input {n}
                    type="text" {n}
                    id="{$ComboBox->GetName()}_selector" {n}
                    class="dropdown_input" {n}
                    value="{$ComboBox->GetDisplayValue()}" {n}
                    data-url="{$ComboBox->GetDataUrl()}" {n}
                    pgui-autocomplete="true" {n}
                    copy-id-to="#{$ComboBox->GetName()}" {n}
                    data-field-name="{$ComboBox->GetFieldName()}"{n}
                    />
                <input {n}
                    class="autocomplete-hidden"
                    type="hidden" {n}
                    id="{$ComboBox->GetName()}" {n}
                    name="{$ComboBox->GetName()}" {n}
                    value="{$ComboBox->GetValue()}" {n}
                    {$Validators.InputAttributes} {n}
                    />
            </td>
            <td class="dropdown_button_column" style="width:15px;">  </td>
        </tr>
    </table>
</div>
{/strip}
{/if}
{else}
{$ComboBox->GetDisplayValue()}
{/if}