{if not $Editor->GetReadOnly()}
{if $RenderText}
<textarea
    data-editor="true"
    data-editor-class="HtmlEditor"
    data-field-name="{$Editor->GetFieldName()}"
    data-editable="true"

    class="html_wysiwyg"
    id="{$Editor->GetName()}"
    name="{$Editor->GetName()}"
    {$Validators.InputAttributes}>
{$Editor->GetValue()}
</textarea>
{/if}
{if $RenderScripts}
{if $RenderText}
<script type="text/javascript">
{literal}

$(function(){
    window.setTimeout(function()
    {

{/literal}
{/if}

{literal}
require(PhpGen.ModuleList([PhpGen.Module.TinyMCE, PhpGen.Module.PG.Editors]), function() {
{/literal}

    $('#{$Editor->GetName()}').tinymce({ldelim}
        script_url : 'libs/jquery/tiny_mce/tiny_mce.js',
        theme : "advanced",

        theme_advanced_buttons1 :
            "bold,italic,underline,strikethrough" + ",|," +
            "justifyleft,justifycenter,justifyright,justifyfull" + ",|," +
            "styleselect,formatselect,fontselect,fontsizeselect",

        theme_advanced_buttons2 :
            "bullist,numlist" + ",|," +
            "outdent,indent,blockquote" + ",|," +
            "undo,redo" + ",|," +
            "link,unlink,anchor,image,cleanup,help,code",

        theme_advanced_buttons3 :
            {if $Editor->GetAllowColorControls()}
            "forecolor,backcolor" + ",|," +
            {/if}
            "hr,removeformat,visualaid" +  ",|," +
            "sub,sup" + ",|," +
            "charmap",

        onchange_callback: function() {ldelim} PhpGen.htmlEditorGlobalNotifier.valueChanged("{$Editor->GetFieldName()}"); {rdelim},
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
       {rdelim});

{literal}
});
{/literal}

{if $RenderText}
{literal}
    }, 10);
});
{/literal}
</script>
{/if}
{/if}
{else}
{if $RenderText}
<span
    data-editor="true"
    data-editor-class="HtmlEditor"
    data-field-name="{$Editor->GetFieldName()}"
    data-editable="false">
{$Editor->GetValue()}
</span>
{/if}
{/if}