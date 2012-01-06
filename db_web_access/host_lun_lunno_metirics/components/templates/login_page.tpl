{capture assign="ContentBlock"}
<body>
{include file='common/site_header.tpl'}
<br>
    {$Renderer->Render($LoginControl)}
</body>
{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}