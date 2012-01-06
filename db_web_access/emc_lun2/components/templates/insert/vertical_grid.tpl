<div vertical-grid="true" align="center" style="width: 100%">
    <form
        validate="true"
        name="insertform"
        id="insertform"
        enctype="multipart/form-data"
        method="POST"
        action="{$Grid->GetModalInsertPageAction()}"
    >
        <input type="hidden" name="edit_operation" value="commit_insert" />
        {foreach key=HiddenValueName item=HiddenValue from=$HiddenValues}
        <input type="hidden" name="{$HiddenValueName}" value="{$HiddenValue}" />
        {/foreach}

        <div class="error-message-container"></div>

        <table class="grid edit-grid" style="width: auto">
{foreach item=column from=$Grid->GetInsertColumns() name=Columns}

            <tr class="{if $smarty.foreach.Columns.index is even}even{else}odd{/if}">

                {* <Column label> *}
                <td class="even labels-column">
                        {$column->GetCaption()}
                        {if not $column->GetAllowSetToNull()}
                            <span class="required-mark">*</span>
                        {/if}
                </td>
                {* </Column label> *}

                {* <Column editor> *}
                <td class="odd editors-column">{$Renderer->Render($column)}</td>
                {* </Column editor> *}

                <td class="odd set-null-column">
                {if $column->GetShowSetToNullCheckBox()}
                    <input
                        type="checkbox"
                        value="1"
                        id="{$column->GetFieldName()}_null"
                        name="{$column->GetFieldName()}_null"{if $column->IsValueNull()}
                        checked="checked"{/if}/>
                        {$Captions->GetMessageString('SetNull')}
                {/if}
                </td>
                
                <td class="odd set-default-column">
                {if $column->GetAllowSetToDefault()}
                    <input
                        type="checkbox"
                        value="1"
                        name="{$column->GetFieldName()}_def"
                        id="{$column->GetFieldName()}_def"/>
                        {$Captions->GetMessageString('SetDefault')}
                {/if}
                </td>
            </tr>
{/foreach}

            <tr class="editor_buttons">
                <td colspan="4" style="text-align: left" valign="middle">
                    <span class="required-mark">*</span> - {$Captions->GetMessageString('RequiredField')}
                </td>
            </tr>
            
        </table>
    </form>
</div>