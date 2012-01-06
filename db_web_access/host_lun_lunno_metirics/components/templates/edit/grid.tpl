<div align="center" style="width: 100%">
    <form
        validate="true"
        name="editform"
        id="editform"
        enctype="multipart/form-data"
        method="POST"
        action="{$Grid->GetEditPageAction()}"
    >

        {foreach key=HiddenValueName item=HiddenValue from=$HiddenValues}
        <input type="hidden" name="{$HiddenValueName}" value="{$HiddenValue}" />
        {/foreach}

        <table class="grid" style="width: auto">
            <tr>
                <th class="even" colspan="4">{$Title}</th>
            </tr>

            {if $Grid->GetErrorMessage() != ''}
            <tr>
                <td class="odd grid_error_row" colspan="4">
                    <div class="grid_error_message">
                        <strong>{$Captions->GetMessageString('ErrorsDuringUpdateProcess')}</strong>
                        <br><br>
                        {$Grid->GetErrorMessage()}
                    </div>
                </td>
            </tr>
            {/if}
            
{foreach item=column from=$Grid->GetEditColumns() name=Columns}
            <tr class="{if $smarty.foreach.Columns.index is even}even{else}odd{/if}">
                <td
                    class="even"
                    style="padding-left:20px; font-weight: bold;">
                        {$column->GetCaption()}
                        {if not $column->GetAllowSetToNull()}<font color="#FF0000">*</font>{/if}
                </td>

                <td class="odd" style="border-right-width: 0px; text-align: left; padding-left: 15px;">
{$Renderer->Render($column)}
                </td>
                
                <td class="odd" style="border-right-width: 0px; white-space: nowrap; padding-right: 5px;">
                {if $column->GetShowSetToNullCheckBox()}
                    <input
                        type="checkbox"
                        value="1"
                        id="{$column->GetFieldName()}_null"
                        name="{$column->GetFieldName()}_null"{if $column->IsValueNull()}
                        checked="checked"{/if}/>{$Captions->GetMessageString('SetNull')}
                {/if}
                
                </td>
                
                <td class="odd" style="border-right-width: 0px; white-space: nowrap; padding-right: 5px;">
                {if $column->GetAllowSetToDefault()}
                    <input type="checkbox" value="1" name="{$column->GetFieldName()}_def" id="{$column->GetFieldName()}_def"/>{$Captions->GetMessageString('SetDefault')}
                {/if}
                </td>
            </tr>
{/foreach}
            <tr class="editor_buttons" >
                <td colspan="4" style="text-align: left" valign="middle">
                    <font color="#FF0000">*</font> - {$Captions->GetMessageString('RequiredField')}
                </td>
            </tr>
            
            <tr id="errorMessagesRow" style="display: none;">
                <td class="odd grid_error_row" colspan="4">
                    <ul class="editing-error-box">
                    </ul>
                </td>
            </tr>
            
            <tr height="40" class="editor_buttons">
                <td colspan="4" align="center" valign="top" >
                    <input
                        class="sm_button"
                        type="button"
                        value="{$Captions->GetMessageString('Save')}"
                        name="submit1"
                        onclick="{literal}WriteWYSIWYGValuesToTheirTextAreas(); if (ValidateSimpleForm($('#editform'), $('ul.editing-error-box'), false)) { document.editform.submit(); } {/literal}"
                    />

                    <input
                        class="sm_button"
                        type="reset"
                        value="{$Captions->GetMessageString('BackToList')}"
                        onclick="window.location.href='{$Grid->GetReturnUrl()}'"
                    />
                </td>
            </tr>
            
        </table>
    </form>
</div>