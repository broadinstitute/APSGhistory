{if not $TextArea->GetReadOnly()}<textarea id="{$TextArea->GetName()}" name="{$TextArea->GetName()}" {if $TextArea->GetColumnCount() != null} cols="{$TextArea->GetColumnCount()}"{/if} {if $TextArea->GetRowCount() != null} rows="{$TextArea->GetRowCount()}"{/if} {$Validators.InputAttributes}>{$TextArea->GetValue()}</textarea>{else}
{$TextArea->GetValue()}
{/if}