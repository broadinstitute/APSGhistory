<input type="text" name="{$Column->GetFieldName()}" id="{$Column->GetFieldName()}" value="{$Value}">
<button type="reset" id="{$Column->GetFieldName()}_trigger">...</button>

<script type="text/javascript">
    Calendar.setup({ldelim}
        inputField     :    "{$Column->GetFieldName()}",
        ifFormat       :    "%Y-%m-%d{if $Column->GetShowsTime()} %I:%M:%S{/if}",
        showsTime      :    {if $Column->GetShowsTime()}true{else}false{/if},
        button         :    "{$Column->GetFieldName()}_trigger",
        singleClick    :    true,
        step           :    1
    {rdelim});
</script>
