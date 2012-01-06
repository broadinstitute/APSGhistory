{if $RenderText}
{if !$CheckBox->GetReadOnly()}
<input type="checkbox" name="{$CheckBox->GetName()}" id="{$CheckBox->GetName()}" value="on" {if $CheckBox->Checked()} checked="checked"{/if} {$Validators.InputAttributes}>
{else}
{if $CheckBox->Checked()}
<img src="images/checked.png" />
{/if}
{/if}
{/if}