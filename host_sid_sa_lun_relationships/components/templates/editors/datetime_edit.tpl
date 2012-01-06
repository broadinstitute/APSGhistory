{if !$DateTimeEdit->GetReadOnly()}
{if $RenderText}
<span>
    <input class="pgui-date-time-edit" type="text" name="{$DateTimeEdit->GetName()}" id="{$DateTimeEdit->GetName()}" value="{$DateTimeEdit->GetValue()}" {$Validators.InputAttributes}>
    <div title="Show date time picker" href="#" class="pgui-date-time-edit-picker" id="{$DateTimeEdit->GetName()}_trigger"></div>
</span>
{/if}
{if $RenderScripts}
{if $RenderText}
<script type="text/javascript">
{/if}
    Calendar.setup({ldelim}
        inputField     :    "{$DateTimeEdit->GetName()}",
        dateFormat     :    "{$DateTimeEdit->GetFormat()}",
        showTime       :    {if $DateTimeEdit->GetShowsTime()}true{else}false{/if},
        trigger        :    "{$DateTimeEdit->GetName()}_trigger",
        minuteStep     :    1,
        onSelect       :    function() {ldelim} this.hide() {rdelim},
        fdow           :    {$DateTimeEdit->GetFirstDayOfWeek()}
    {rdelim});
{if $RenderText}
</script>
{/if}
{/if}
{else}
{if $RenderText}
{$DateTimeEdit->GetValue()}
{/if}
{/if}