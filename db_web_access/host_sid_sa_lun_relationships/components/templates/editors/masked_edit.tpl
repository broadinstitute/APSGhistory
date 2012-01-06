    <input
        masked="true"
        mask="{$Editor->GetMask()}"
        class="sm_text"
        id="{$Editor->GetName()}"
        name="{$Editor->GetName()}"
        value="{$Editor->GetValue()}"
        {$Validators.InputAttributes}
    >
    <div class="masked-edit-hint">{$Editor->GetHint()}</div>