<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "grp_inc_viewinfo.php" ?>
<?php include "userfn6.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$grp_inc_view_list = new cgrp_inc_view_list();
$Page =& $grp_inc_view_list;

// Page init processing
$grp_inc_view_list->Page_Init();

// Page main processing
$grp_inc_view_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($grp_inc_view->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var grp_inc_view_list = new ew_Page("grp_inc_view_list");

// page properties
grp_inc_view_list.PageID = "list"; // page ID
var EW_PAGE_ID = grp_inc_view_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
grp_inc_view_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
grp_inc_view_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
grp_inc_view_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($grp_inc_view->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($grp_inc_view->Export == "" && $grp_inc_view->SelectLimit);
	if (!$bSelectLimit)
		$rs = $grp_inc_view_list->LoadRecordset();
	$grp_inc_view_list->lTotalRecs = ($bSelectLimit) ? $grp_inc_view->SelectRecordCount() : $rs->RecordCount();
	$grp_inc_view_list->lStartRec = 1;
	if ($grp_inc_view_list->lDisplayRecs <= 0) // Display all records
		$grp_inc_view_list->lDisplayRecs = $grp_inc_view_list->lTotalRecs;
	if (!($grp_inc_view->ExportAll && $grp_inc_view->Export <> ""))
		$grp_inc_view_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $grp_inc_view_list->LoadRecordset($grp_inc_view_list->lStartRec-1, $grp_inc_view_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">View: Grp Inc View
</span></p>
<?php $grp_inc_view_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fgrp_inc_viewlist" id="fgrp_inc_viewlist" class="ewForm" action="" method="post">
<?php if ($grp_inc_view_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$grp_inc_view_list->lOptionCnt = 0;
	$grp_inc_view_list->lOptionCnt += count($grp_inc_view_list->ListOptions->Items); // Custom list options
?>
<?php echo $grp_inc_view->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($grp_inc_view->id->Visible) { // id ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($grp_inc_view->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->mount->Visible) { // mount ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->mount) == "") { ?>
		<td>Mount</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->mount) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Mount</td><td style="width: 10px;"><?php if ($grp_inc_view->mount->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->mount->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->path->Visible) { // path ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->path) == "") { ?>
		<td>Path</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->path) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Path</td><td style="width: 10px;"><?php if ($grp_inc_view->path->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->path->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->parent->Visible) { // parent ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->parent) == "") { ?>
		<td>Parent</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->parent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Parent</td><td style="width: 10px;"><?php if ($grp_inc_view->parent->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->parent->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->deprecated->Visible) { // deprecated ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->deprecated) == "") { ?>
		<td>Deprecated</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->deprecated) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Deprecated</td><td style="width: 10px;"><?php if ($grp_inc_view->deprecated->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->deprecated->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->gid->Visible) { // gid ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($grp_inc_view->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->group_name->Visible) { // group_name ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->group_name) == "") { ?>
		<td>Group Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->group_name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Group Name</td><td style="width: 10px;"><?php if ($grp_inc_view->group_name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->group_name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->snapshot->Visible) { // snapshot ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->snapshot) == "") { ?>
		<td>Snapshot</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->snapshot) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Snapshot</td><td style="width: 10px;"><?php if ($grp_inc_view->snapshot->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->snapshot->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->tapebackup->Visible) { // tapebackup ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->tapebackup) == "") { ?>
		<td>Tapebackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->tapebackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Tapebackup</td><td style="width: 10px;"><?php if ($grp_inc_view->tapebackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->tapebackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->diskbackup->Visible) { // diskbackup ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->diskbackup) == "") { ?>
		<td>Diskbackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->diskbackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Diskbackup</td><td style="width: 10px;"><?php if ($grp_inc_view->diskbackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->diskbackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->type->Visible) { // type ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->type) == "") { ?>
		<td>Type</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Type</td><td style="width: 10px;"><?php if ($grp_inc_view->type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->server_type->Visible) { // server_type ?>
	<?php if ($grp_inc_view->SortUrl($grp_inc_view->server_type) == "") { ?>
		<td>Server Type</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $grp_inc_view->SortUrl($grp_inc_view->server_type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Server Type</td><td style="width: 10px;"><?php if ($grp_inc_view->server_type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($grp_inc_view->server_type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($grp_inc_view->Export == "") { ?>
<?php

// Custom list options
foreach ($grp_inc_view_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($grp_inc_view->ExportAll && $grp_inc_view->Export <> "") {
	$grp_inc_view_list->lStopRec = $grp_inc_view_list->lTotalRecs;
} else {
	$grp_inc_view_list->lStopRec = $grp_inc_view_list->lStartRec + $grp_inc_view_list->lDisplayRecs - 1; // Set the last record to display
}
$grp_inc_view_list->lRecCount = $grp_inc_view_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$grp_inc_view->SelectLimit && $grp_inc_view_list->lStartRec > 1)
		$rs->Move($grp_inc_view_list->lStartRec - 1);
}
$grp_inc_view_list->lRowCnt = 0;
while (($grp_inc_view->CurrentAction == "gridadd" || !$rs->EOF) &&
	$grp_inc_view_list->lRecCount < $grp_inc_view_list->lStopRec) {
	$grp_inc_view_list->lRecCount++;
	if (intval($grp_inc_view_list->lRecCount) >= intval($grp_inc_view_list->lStartRec)) {
		$grp_inc_view_list->lRowCnt++;

	// Init row class and style
	$grp_inc_view->CssClass = "";
	$grp_inc_view->CssStyle = "";
	$grp_inc_view->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($grp_inc_view->CurrentAction == "gridadd") {
		$grp_inc_view_list->LoadDefaultValues(); // Load default values
	} else {
		$grp_inc_view_list->LoadRowValues($rs); // Load row values
	}
	$grp_inc_view->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$grp_inc_view_list->RenderRow();
?>
	<tr<?php echo $grp_inc_view->RowAttributes() ?>>
	<?php if ($grp_inc_view->id->Visible) { // id ?>
		<td<?php echo $grp_inc_view->id->CellAttributes() ?>>
<div<?php echo $grp_inc_view->id->ViewAttributes() ?>><?php echo $grp_inc_view->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->mount->Visible) { // mount ?>
		<td<?php echo $grp_inc_view->mount->CellAttributes() ?>>
<div<?php echo $grp_inc_view->mount->ViewAttributes() ?>><?php echo $grp_inc_view->mount->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->path->Visible) { // path ?>
		<td<?php echo $grp_inc_view->path->CellAttributes() ?>>
<div<?php echo $grp_inc_view->path->ViewAttributes() ?>><?php echo $grp_inc_view->path->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->parent->Visible) { // parent ?>
		<td<?php echo $grp_inc_view->parent->CellAttributes() ?>>
<div<?php echo $grp_inc_view->parent->ViewAttributes() ?>><?php echo $grp_inc_view->parent->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->deprecated->Visible) { // deprecated ?>
		<td<?php echo $grp_inc_view->deprecated->CellAttributes() ?>>
<div<?php echo $grp_inc_view->deprecated->ViewAttributes() ?>><?php echo $grp_inc_view->deprecated->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->gid->Visible) { // gid ?>
		<td<?php echo $grp_inc_view->gid->CellAttributes() ?>>
<div<?php echo $grp_inc_view->gid->ViewAttributes() ?>><?php echo $grp_inc_view->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->group_name->Visible) { // group_name ?>
		<td<?php echo $grp_inc_view->group_name->CellAttributes() ?>>
<div<?php echo $grp_inc_view->group_name->ViewAttributes() ?>><?php echo $grp_inc_view->group_name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->snapshot->Visible) { // snapshot ?>
		<td<?php echo $grp_inc_view->snapshot->CellAttributes() ?>>
<div<?php echo $grp_inc_view->snapshot->ViewAttributes() ?>><?php echo $grp_inc_view->snapshot->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->tapebackup->Visible) { // tapebackup ?>
		<td<?php echo $grp_inc_view->tapebackup->CellAttributes() ?>>
<div<?php echo $grp_inc_view->tapebackup->ViewAttributes() ?>><?php echo $grp_inc_view->tapebackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->diskbackup->Visible) { // diskbackup ?>
		<td<?php echo $grp_inc_view->diskbackup->CellAttributes() ?>>
<div<?php echo $grp_inc_view->diskbackup->ViewAttributes() ?>><?php echo $grp_inc_view->diskbackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->type->Visible) { // type ?>
		<td<?php echo $grp_inc_view->type->CellAttributes() ?>>
<div<?php echo $grp_inc_view->type->ViewAttributes() ?>><?php echo $grp_inc_view->type->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($grp_inc_view->server_type->Visible) { // server_type ?>
		<td<?php echo $grp_inc_view->server_type->CellAttributes() ?>>
<div<?php echo $grp_inc_view->server_type->ViewAttributes() ?>><?php echo $grp_inc_view->server_type->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($grp_inc_view->Export == "") { ?>
<?php

// Custom list options
foreach ($grp_inc_view_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($grp_inc_view->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
</div>
<?php if ($grp_inc_view->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($grp_inc_view->CurrentAction <> "gridadd" && $grp_inc_view->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($grp_inc_view_list->Pager)) $grp_inc_view_list->Pager = new cPrevNextPager($grp_inc_view_list->lStartRec, $grp_inc_view_list->lDisplayRecs, $grp_inc_view_list->lTotalRecs) ?>
<?php if ($grp_inc_view_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($grp_inc_view_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $grp_inc_view_list->PageUrl() ?>start=<?php echo $grp_inc_view_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($grp_inc_view_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $grp_inc_view_list->PageUrl() ?>start=<?php echo $grp_inc_view_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $grp_inc_view_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($grp_inc_view_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $grp_inc_view_list->PageUrl() ?>start=<?php echo $grp_inc_view_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($grp_inc_view_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $grp_inc_view_list->PageUrl() ?>start=<?php echo $grp_inc_view_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $grp_inc_view_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $grp_inc_view_list->Pager->FromIndex ?> to <?php echo $grp_inc_view_list->Pager->ToIndex ?> of <?php echo $grp_inc_view_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($grp_inc_view_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($grp_inc_view_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($grp_inc_view->Export == "" && $grp_inc_view->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(grp_inc_view_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($grp_inc_view->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$grp_inc_view_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cgrp_inc_view_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'grp_inc_view';

	// Page Object Name
	var $PageObjName = 'grp_inc_view_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $grp_inc_view;
		if ($grp_inc_view->UseTokenInUrl) $PageUrl .= "t=" . $grp_inc_view->TableVar . "&"; // add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show Message
	function ShowMessage() {
		if ($this->getMessage() <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $this->getMessage() . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate Page request
	function IsPageRequest() {
		global $objForm, $grp_inc_view;
		if ($grp_inc_view->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($grp_inc_view->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($grp_inc_view->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cgrp_inc_view_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["grp_inc_view"] = new cgrp_inc_view();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'grp_inc_view', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $grp_inc_view;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$grp_inc_view->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $grp_inc_view->Export; // Get export parameter, used in header
	$gsExportFile = $grp_inc_view->TableVar; // Get export file, used in header

		// Global page loading event (in userfn6.php)
		Page_Loading();

		// Page load event, used in current page
		$this->Page_Load();
	}

	//
	//  Page_Terminate
	//  - called when exit page
	//  - if URL specified, redirect to the URL
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page unload event, used in current page
		$this->Page_Unload();

		// Global page unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close Connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			ob_end_clean();
			header("Location: $url");
		}
		exit();
	}
	var $lDisplayRecs; // Number of display records
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs;
	var $lRecRange;
	var $sSrchWhere;
	var $lRecCnt;
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex;
	var $lOptionCnt;
	var $lRecPerRow;
	var $lColCnt;
	var $sDeleteConfirmMsg; // Delete confirm message
	var $sDbMasterFilter;
	var $sDbDetailFilter;
	var $bMasterRecordExists;	
	var $ListOptions;
	var $sMultiSelectKey;

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $Security, $grp_inc_view;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause

		// Master/Detail
		$this->sDbMasterFilter = ""; // Master filter
		$this->sDbDetailFilter = ""; // Detail filter
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($grp_inc_view->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $grp_inc_view->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$grp_inc_view->setSessionWhere($sFilter);
		$grp_inc_view->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $grp_inc_view;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$grp_inc_view->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$grp_inc_view->CurrentOrderType = @$_GET["ordertype"];
			$grp_inc_view->UpdateSort($grp_inc_view->id); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->mount); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->path); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->parent); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->deprecated); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->gid); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->group_name); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->snapshot); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->tapebackup); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->diskbackup); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->type); // Field 
			$grp_inc_view->UpdateSort($grp_inc_view->server_type); // Field 
			$grp_inc_view->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $grp_inc_view;
		$sOrderBy = $grp_inc_view->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($grp_inc_view->SqlOrderBy() <> "") {
				$sOrderBy = $grp_inc_view->SqlOrderBy();
				$grp_inc_view->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $grp_inc_view;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$grp_inc_view->setSessionOrderBy($sOrderBy);
				$grp_inc_view->id->setSort("");
				$grp_inc_view->mount->setSort("");
				$grp_inc_view->path->setSort("");
				$grp_inc_view->parent->setSort("");
				$grp_inc_view->deprecated->setSort("");
				$grp_inc_view->gid->setSort("");
				$grp_inc_view->group_name->setSort("");
				$grp_inc_view->snapshot->setSort("");
				$grp_inc_view->tapebackup->setSort("");
				$grp_inc_view->diskbackup->setSort("");
				$grp_inc_view->type->setSort("");
				$grp_inc_view->server_type->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$grp_inc_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $grp_inc_view;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$grp_inc_view->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$grp_inc_view->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $grp_inc_view->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$grp_inc_view->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$grp_inc_view->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$grp_inc_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $grp_inc_view;

		// Call Recordset Selecting event
		$grp_inc_view->Recordset_Selecting($grp_inc_view->CurrentFilter);

		// Load list page SQL
		$sSql = $grp_inc_view->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$grp_inc_view->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $grp_inc_view;
		$sFilter = $grp_inc_view->KeyFilter();

		// Call Row Selecting event
		$grp_inc_view->Row_Selecting($sFilter);

		// Load sql based on filter
		$grp_inc_view->CurrentFilter = $sFilter;
		$sSql = $grp_inc_view->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$grp_inc_view->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $grp_inc_view;
		$grp_inc_view->id->setDbValue($rs->fields('id'));
		$grp_inc_view->mount->setDbValue($rs->fields('mount'));
		$grp_inc_view->path->setDbValue($rs->fields('path'));
		$grp_inc_view->parent->setDbValue($rs->fields('parent'));
		$grp_inc_view->deprecated->setDbValue($rs->fields('deprecated'));
		$grp_inc_view->gid->setDbValue($rs->fields('gid'));
		$grp_inc_view->group_name->setDbValue($rs->fields('group_name'));
		$grp_inc_view->snapshot->setDbValue($rs->fields('snapshot'));
		$grp_inc_view->tapebackup->setDbValue($rs->fields('tapebackup'));
		$grp_inc_view->diskbackup->setDbValue($rs->fields('diskbackup'));
		$grp_inc_view->type->setDbValue($rs->fields('type'));
		$grp_inc_view->server_type->setDbValue($rs->fields('server_type'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $grp_inc_view;

		// Call Row_Rendering event
		$grp_inc_view->Row_Rendering();

		// Common render codes for all row types
		// id

		$grp_inc_view->id->CellCssStyle = "";
		$grp_inc_view->id->CellCssClass = "";

		// mount
		$grp_inc_view->mount->CellCssStyle = "";
		$grp_inc_view->mount->CellCssClass = "";

		// path
		$grp_inc_view->path->CellCssStyle = "";
		$grp_inc_view->path->CellCssClass = "";

		// parent
		$grp_inc_view->parent->CellCssStyle = "";
		$grp_inc_view->parent->CellCssClass = "";

		// deprecated
		$grp_inc_view->deprecated->CellCssStyle = "";
		$grp_inc_view->deprecated->CellCssClass = "";

		// gid
		$grp_inc_view->gid->CellCssStyle = "";
		$grp_inc_view->gid->CellCssClass = "";

		// group_name
		$grp_inc_view->group_name->CellCssStyle = "";
		$grp_inc_view->group_name->CellCssClass = "";

		// snapshot
		$grp_inc_view->snapshot->CellCssStyle = "";
		$grp_inc_view->snapshot->CellCssClass = "";

		// tapebackup
		$grp_inc_view->tapebackup->CellCssStyle = "";
		$grp_inc_view->tapebackup->CellCssClass = "";

		// diskbackup
		$grp_inc_view->diskbackup->CellCssStyle = "";
		$grp_inc_view->diskbackup->CellCssClass = "";

		// type
		$grp_inc_view->type->CellCssStyle = "";
		$grp_inc_view->type->CellCssClass = "";

		// server_type
		$grp_inc_view->server_type->CellCssStyle = "";
		$grp_inc_view->server_type->CellCssClass = "";
		if ($grp_inc_view->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$grp_inc_view->id->ViewValue = $grp_inc_view->id->CurrentValue;
			$grp_inc_view->id->CssStyle = "";
			$grp_inc_view->id->CssClass = "";
			$grp_inc_view->id->ViewCustomAttributes = "";

			// mount
			$grp_inc_view->mount->ViewValue = $grp_inc_view->mount->CurrentValue;
			$grp_inc_view->mount->CssStyle = "";
			$grp_inc_view->mount->CssClass = "";
			$grp_inc_view->mount->ViewCustomAttributes = "";

			// path
			$grp_inc_view->path->ViewValue = $grp_inc_view->path->CurrentValue;
			$grp_inc_view->path->CssStyle = "";
			$grp_inc_view->path->CssClass = "";
			$grp_inc_view->path->ViewCustomAttributes = "";

			// parent
			$grp_inc_view->parent->ViewValue = $grp_inc_view->parent->CurrentValue;
			$grp_inc_view->parent->CssStyle = "";
			$grp_inc_view->parent->CssClass = "";
			$grp_inc_view->parent->ViewCustomAttributes = "";

			// deprecated
			$grp_inc_view->deprecated->ViewValue = $grp_inc_view->deprecated->CurrentValue;
			$grp_inc_view->deprecated->CssStyle = "";
			$grp_inc_view->deprecated->CssClass = "";
			$grp_inc_view->deprecated->ViewCustomAttributes = "";

			// gid
			$grp_inc_view->gid->ViewValue = $grp_inc_view->gid->CurrentValue;
			$grp_inc_view->gid->CssStyle = "";
			$grp_inc_view->gid->CssClass = "";
			$grp_inc_view->gid->ViewCustomAttributes = "";

			// group_name
			$grp_inc_view->group_name->ViewValue = $grp_inc_view->group_name->CurrentValue;
			$grp_inc_view->group_name->CssStyle = "";
			$grp_inc_view->group_name->CssClass = "";
			$grp_inc_view->group_name->ViewCustomAttributes = "";

			// snapshot
			$grp_inc_view->snapshot->ViewValue = $grp_inc_view->snapshot->CurrentValue;
			$grp_inc_view->snapshot->CssStyle = "";
			$grp_inc_view->snapshot->CssClass = "";
			$grp_inc_view->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$grp_inc_view->tapebackup->ViewValue = $grp_inc_view->tapebackup->CurrentValue;
			$grp_inc_view->tapebackup->CssStyle = "";
			$grp_inc_view->tapebackup->CssClass = "";
			$grp_inc_view->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$grp_inc_view->diskbackup->ViewValue = $grp_inc_view->diskbackup->CurrentValue;
			$grp_inc_view->diskbackup->CssStyle = "";
			$grp_inc_view->diskbackup->CssClass = "";
			$grp_inc_view->diskbackup->ViewCustomAttributes = "";

			// type
			$grp_inc_view->type->ViewValue = $grp_inc_view->type->CurrentValue;
			$grp_inc_view->type->CssStyle = "";
			$grp_inc_view->type->CssClass = "";
			$grp_inc_view->type->ViewCustomAttributes = "";

			// server_type
			$grp_inc_view->server_type->ViewValue = $grp_inc_view->server_type->CurrentValue;
			$grp_inc_view->server_type->CssStyle = "";
			$grp_inc_view->server_type->CssClass = "";
			$grp_inc_view->server_type->ViewCustomAttributes = "";

			// id
			$grp_inc_view->id->HrefValue = "";

			// mount
			$grp_inc_view->mount->HrefValue = "";

			// path
			$grp_inc_view->path->HrefValue = "";

			// parent
			$grp_inc_view->parent->HrefValue = "";

			// deprecated
			$grp_inc_view->deprecated->HrefValue = "";

			// gid
			$grp_inc_view->gid->HrefValue = "";

			// group_name
			$grp_inc_view->group_name->HrefValue = "";

			// snapshot
			$grp_inc_view->snapshot->HrefValue = "";

			// tapebackup
			$grp_inc_view->tapebackup->HrefValue = "";

			// diskbackup
			$grp_inc_view->diskbackup->HrefValue = "";

			// type
			$grp_inc_view->type->HrefValue = "";

			// server_type
			$grp_inc_view->server_type->HrefValue = "";
		}

		// Call Row Rendered event
		$grp_inc_view->Row_Rendered();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
