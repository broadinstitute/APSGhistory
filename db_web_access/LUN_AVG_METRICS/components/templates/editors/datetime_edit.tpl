{if !$DateTimeEdit->GetReadOnly()}
{if $RenderText}
<span>
    <input
        data-editor="true"
        data-editor-class="DateTimeEdit"
        data-field-name="{$DateTimeEdit->GetFieldName()}"
        data-editable="true"
        class="pgui-date-time-edit" type="text" name="{$DateTimeEdit->GetName()}" id="{$DateTimeEdit->GetName()}" value="{$DateTimeEdit->GetValue()}" {$Validators.InputAttributes}>
    <div title="Show date time picker" href="#" class="pgui-date-time-edit-picker" id="{$DateTimeEdit->GetName()}_trigger"></div>
</span>
{/if}
{if $RenderScripts}
{if $RenderText}
<script type="text/javascript">
{/if}
    {literal}
    require(PhpGen.ModuleList(PhpGen.Module.Calendar), function(){
        Calendar.setup({
            {/literal}
            inputField     :    "{$DateTimeEdit->GetName()}",
            dateFormat     :    "{$DateTimeEdit->GetFormat()}",
            showTime       :    {if $DateTimeEdit->GetShowsTime()}true{else}false{/if},
            trigger        :    "{$DateTimeEdit->GetName()}_trigger",
            minuteStep     :    1,
            onSelect       :    function() {ldelim} this.hide(); PhpGen.dateTimeGlobalNotifier.valueChanged("{$DateTimeEdit->GetFieldName()}"); {rdelim},
            fdow           :    {$DateTimeEdit->GetFirstDayOfWeek()}
            {literal}
        });
    });
    {/literal}
{if $RenderText}
</script>
{/if}
{/if}
{else}
{if $RenderText}
<span
    data-editor="true"
    data-editor-class="DateTimeEdit"
    data-field-name="{$DateTimeEdit->GetFieldName()}"
    data-editable="false"
    >{$DateTimeEdit->GetValue()}</span>
{/if}
{/if}