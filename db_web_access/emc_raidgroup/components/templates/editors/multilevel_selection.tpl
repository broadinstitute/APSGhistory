{if $RenderText}
{if !$MultilevelEditor->GetReadOnly()}
{foreach from=$Editors item=Editor name=Editors}
    <div class="pgui-autocomplete-container-container">
        <div class="pgui-caption">{$Editor.Caption}:</div>

        <table class="pgui-autocomplete-container">
            <tbody>
                <tr>
                    <td>
                        <input
                            type="text"
                            id="{$Editor.Name}_selector"
                            value="{$Editor.DisplayValue}"
                            class="pgui-autocomplete"

                            {if $Editor.ParentEditor != null}
                            parent-autocomplete="#{$Editor.ParentEditor}_selector"
                            {/if}

                            autocomplete="true"
                            data-url="{$Editor.DataURL}"
                            copy-id-to="#{$Editor.Name}"
                                />
                        <input type="hidden" id="{$Editor.Name}" name="{$Editor.Name}" value="{$Editor.Value}"
                            {if $smarty.foreach.Editors.last}
                                {$Validators.InputAttributes}
                            {/if}/>
                    </td>
                    <td class="button">
                        <div class="pgui-ml-autocomplete-button"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
{/foreach}
{else}

<div class="pgui-autocomplete-readonly">
{foreach from=$Editors item=Editor}
    <div class="pgui-autocomplete-level">
        <span class="caption">{$Editor.Caption}:</span>
        <span class="value">{$Editor.DisplayValue}</span>
    </div>
{/foreach}
</div>

{/if}
{/if}