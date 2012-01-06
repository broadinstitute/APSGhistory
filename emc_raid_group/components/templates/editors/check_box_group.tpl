{strip}
{if $RenderText}
{if !$CheckBoxGroup->GetReadOnly()}
<div
    {n}data-editor="true"
    {n}data-editor-class="CheckBoxGroup"
    {n}data-field-name="{$CheckBoxGroup->GetFieldName()}"
    {n}data-editable="true">
{foreach key=Value item=Name from=$CheckBoxGroup->GetValues()}
<label>
    <input
        {n}type="checkbox"
        {n}name="{$CheckBoxGroup->GetName()}[]"
        {n}value="{$Value}" {if $CheckBoxGroup->IsValueSelected($Value)}
        {n}checked="checked"{/if}
        {n}{$Validators.InputAttributes}/>{$Name}
</label><br/>
{/foreach}
</div>
{else}
{foreach key=Value item=Name from=$CheckBoxGroup->GetValues()}
{if $CheckBoxGroup->IsValueSelected($Value)}{$Name}&nbsp;&nbsp;{/if}
{/foreach}
{/if}
{/if}
{/strip}