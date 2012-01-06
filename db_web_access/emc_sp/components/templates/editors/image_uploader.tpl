{if !$Uploader->GetReadOnly()}
{if $RenderText}
{if $Uploader->GetShowImage() and !$HideImage}
<img src="{$Uploader->GetLink()}"><br/>
{/if}
<input checked="checked" type="radio" value="Keep" name="{$Uploader->GetName()}_action">{$Captions->GetMessageString('KeepImage')}
<input type="radio" value="Remove" name="{$Uploader->GetName()}_action">{$Captions->GetMessageString('RemoveImage')}
<input type="radio" value="Replace" name="{$Uploader->GetName()}_action">{$Captions->GetMessageString('ReplaceImage')}<br>
<input type="file" name="{$Uploader->GetName()}_filename"
    onchange="if (this.form.{$Uploader->GetName()}_action[2]) this.form.{$Uploader->GetName()}_action[2].checked=true;">
{/if}
{else}
{if $RenderText}
{if $Uploader->GetShowImage() and !$HideImage}
<img src="{$Uploader->GetLink()}"><br/>
{else}
<a class="image" target="_blank" title="download" href="{$Uploader->GetLink()}">Download file</a>
{/if}
{/if}
{/if}