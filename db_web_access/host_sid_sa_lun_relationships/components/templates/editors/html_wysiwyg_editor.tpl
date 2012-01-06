{if not $Editor->GetReadOnly()}
{if $RenderText}
<textarea class="html_wysiwyg"
  id="{$Editor->GetName()}"
  name="{$Editor->GetName()}"
  {$Validators.InputAttributes}>
{$Editor->GetValue()}
</textarea>
{/if}
{if $RenderScripts}
{if $RenderText}
<script type="text/javascript">
{/if}
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

    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true
   {rdelim});
{if $RenderText}
</script>
{/if}
{/if}
{else}
{if $RenderText}
{$Editor->GetValue()}
{/if}
{/if}