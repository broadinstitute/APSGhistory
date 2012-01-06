{capture assign="ContentBlock"}
<body style="{styleoption name='margin' value=$Page->Margin}{styleoption name='padding' value=$Page->Padding}">
<div style="height: auto; padding: 5px;" id="detailContent_{$DetailPage->DetailRowNumber}">
<div style="padding: 5px">
<div style="padding: 5px; border: 1px solid;">
<div class="detail_preview_head" style="width: 100%; text-align: left;" dir="ltr">
{$Captions->GetMessageString('DetailPreview')}: <span class="detail_page_caption" title="{$DetailPage->GetCaption()}">{$DetailPage->GetShortCaption()}</span>
{if $DetailPage->GetRecordLimit() < $DetailPage->GetFullRecordCount()}
<div style="margin: 0px; font-size: 8pt;">
{assign var="first_record_count" value=$DetailPage->GetRecordLimit()}
{assign var="total_record_count" value=$DetailPage->GetFullRecordCount()}
{assign var="shown_first_m_of_n_records" value=$Captions->GetMessageString('ShownFirstMofNRecords')}
{eval var=$shown_first_m_of_n_records}
{assign var="full_view_link" value=$DetailPage->GetFullViewLink()}
({eval var=$Captions->GetMessageString('FullView')})</div>
{/if}
</div>
{$PageNavigator}
{$Grid}
</div>
</div>
</div>
<script language="javascript">
<!--
    var elem = document.getElementById('detailContent_{$DetailPage->DetailRowNumber}');
    if (elem && elem.innerHTML)
    {ldelim}
        window.parent.LoadDetail('{$DetailPage->DetailRowNumber}', elem);
        location.replace('about:blank');
    {rdelim}
// -->
</script>
</body>
{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}