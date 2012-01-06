{capture assign="ContentBlock"}
<body>
    <table class="grid" style="width: auto">
        <tr><th class="even" >{$Viewer->GetCaption()}</th></tr>
        <tr class="even"><td class="even" style="padding: 10px; text-align: left"><p align="justify">{$Viewer->GetValue($Renderer)}</p></td></tr>
        <tr class="even"><td class="even"><a href="#" onClick="window.close(); return false;">{$Captions->GetMessageString('CloseWindow')}</a></td></tr>
    </table>
</body>
{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}