{capture assign="ContentBlock"}
<body style="{styleoption name='margin' value=$Page->Margin}{styleoption name='padding' value=$Page->Padding}">
{include file='common/site_header.tpl'}
<br/>
{$Grid}
</body>
{/capture}

{capture assign="DebugFooter"}{$Variables}{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}

