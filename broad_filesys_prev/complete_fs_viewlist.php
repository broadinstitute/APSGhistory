<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "complete_fs_viewinfo.php" ?>
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
$complete_fs_view_list = new ccomplete_fs_view_list();
$Page =& $complete_fs_view_list;

// Page init processing
$complete_fs_view_list->Page_Init();

// Page main processing
$complete_fs_view_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($complete_fs_view->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var complete_fs_view_list = new ew_Page("complete_fs_view_list");

// page properties
complete_fs_view_list.PageID = "list"; // page ID
var EW_PAGE_ID = complete_fs_view_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
complete_fs_view_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
complete_fs_view_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
complete_fs_view_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($complete_fs_view->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($complete_fs_view->Export == "" && $complete_fs_view->SelectLimit);
	if (!$bSelectLimit)
		$rs = $complete_fs_view_list->LoadRecordset();
	$complete_fs_view_list->lTotalRecs = ($bSelectLimit) ? $complete_fs_view->SelectRecordCount() : $rs->RecordCount();
	$complete_fs_view_list->lStartRec = 1;
	if ($complete_fs_view_list->lDisplayRecs <= 0) // Display all records
		$complete_fs_view_list->lDisplayRecs = $complete_fs_view_list->lTotalRecs;
	if (!($complete_fs_view->ExportAll && $complete_fs_view->Export <> ""))
		$complete_fs_view_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $complete_fs_view_list->LoadRecordset($complete_fs_view_list->lStartRec-1, $complete_fs_view_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">View: Complete Fs View
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($complete_fs_view->Export == "" && $complete_fs_view->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(complete_fs_view_list);" style="text-decoration: none;"><img id="complete_fs_view_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="complete_fs_view_list_SearchPanel">
<form name="fcomplete_fs_viewlistsrch" id="fcomplete_fs_viewlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="complete_fs_view">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($complete_fs_view->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $complete_fs_view_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($complete_fs_view->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($complete_fs_view->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($complete_fs_view->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $complete_fs_view_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fcomplete_fs_viewlist" id="fcomplete_fs_viewlist" class="ewForm" action="" method="post">
<?php if ($complete_fs_view_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$complete_fs_view_list->lOptionCnt = 0;
	$complete_fs_view_list->lOptionCnt += count($complete_fs_view_list->ListOptions->Items); // Custom list options
?>
<?php echo $complete_fs_view->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($complete_fs_view->id->Visible) { // id ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($complete_fs_view->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->mount->Visible) { // mount ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->mount) == "") { ?>
		<td>Mount</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->mount) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Mount&nbsp;(*)</td><td style="width: 10px;"><?php if ($complete_fs_view->mount->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->mount->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->path->Visible) { // path ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->path) == "") { ?>
		<td>Path</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->path) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Path&nbsp;(*)</td><td style="width: 10px;"><?php if ($complete_fs_view->path->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->path->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->parent->Visible) { // parent ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->parent) == "") { ?>
		<td>Parent</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->parent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Parent</td><td style="width: 10px;"><?php if ($complete_fs_view->parent->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->parent->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->deprecated->Visible) { // deprecated ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->deprecated) == "") { ?>
		<td>Deprecated</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->deprecated) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Deprecated</td><td style="width: 10px;"><?php if ($complete_fs_view->deprecated->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->deprecated->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->gid->Visible) { // gid ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($complete_fs_view->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->group_name->Visible) { // group_name ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->group_name) == "") { ?>
		<td>Group Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->group_name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Group Name&nbsp;(*)</td><td style="width: 10px;"><?php if ($complete_fs_view->group_name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->group_name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->snapshot->Visible) { // snapshot ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->snapshot) == "") { ?>
		<td>Snapshot</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->snapshot) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Snapshot</td><td style="width: 10px;"><?php if ($complete_fs_view->snapshot->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->snapshot->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->tapebackup->Visible) { // tapebackup ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->tapebackup) == "") { ?>
		<td>Tapebackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->tapebackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Tapebackup</td><td style="width: 10px;"><?php if ($complete_fs_view->tapebackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->tapebackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->diskbackup->Visible) { // diskbackup ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->diskbackup) == "") { ?>
		<td>Diskbackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->diskbackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Diskbackup</td><td style="width: 10px;"><?php if ($complete_fs_view->diskbackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->diskbackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->type->Visible) { // type ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->type) == "") { ?>
		<td>Type</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Type</td><td style="width: 10px;"><?php if ($complete_fs_view->type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->server_type->Visible) { // server_type ?>
	<?php if ($complete_fs_view->SortUrl($complete_fs_view->server_type) == "") { ?>
		<td>Server Type</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $complete_fs_view->SortUrl($complete_fs_view->server_type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Server Type&nbsp;(*)</td><td style="width: 10px;"><?php if ($complete_fs_view->server_type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($complete_fs_view->server_type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($complete_fs_view->Export == "") { ?>
<?php

// Custom list options
foreach ($complete_fs_view_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($complete_fs_view->ExportAll && $complete_fs_view->Export <> "") {
	$complete_fs_view_list->lStopRec = $complete_fs_view_list->lTotalRecs;
} else {
	$complete_fs_view_list->lStopRec = $complete_fs_view_list->lStartRec + $complete_fs_view_list->lDisplayRecs - 1; // Set the last record to display
}
$complete_fs_view_list->lRecCount = $complete_fs_view_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$complete_fs_view->SelectLimit && $complete_fs_view_list->lStartRec > 1)
		$rs->Move($complete_fs_view_list->lStartRec - 1);
}
$complete_fs_view_list->lRowCnt = 0;
while (($complete_fs_view->CurrentAction == "gridadd" || !$rs->EOF) &&
	$complete_fs_view_list->lRecCount < $complete_fs_view_list->lStopRec) {
	$complete_fs_view_list->lRecCount++;
	if (intval($complete_fs_view_list->lRecCount) >= intval($complete_fs_view_list->lStartRec)) {
		$complete_fs_view_list->lRowCnt++;

	// Init row class and style
	$complete_fs_view->CssClass = "";
	$complete_fs_view->CssStyle = "";
	$complete_fs_view->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($complete_fs_view->CurrentAction == "gridadd") {
		$complete_fs_view_list->LoadDefaultValues(); // Load default values
	} else {
		$complete_fs_view_list->LoadRowValues($rs); // Load row values
	}
	$complete_fs_view->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$complete_fs_view_list->RenderRow();
?>
	<tr<?php echo $complete_fs_view->RowAttributes() ?>>
	<?php if ($complete_fs_view->id->Visible) { // id ?>
		<td<?php echo $complete_fs_view->id->CellAttributes() ?>>
<div<?php echo $complete_fs_view->id->ViewAttributes() ?>><?php echo $complete_fs_view->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->mount->Visible) { // mount ?>
		<td<?php echo $complete_fs_view->mount->CellAttributes() ?>>
<div<?php echo $complete_fs_view->mount->ViewAttributes() ?>><?php echo $complete_fs_view->mount->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->path->Visible) { // path ?>
		<td<?php echo $complete_fs_view->path->CellAttributes() ?>>
<div<?php echo $complete_fs_view->path->ViewAttributes() ?>><?php echo $complete_fs_view->path->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->parent->Visible) { // parent ?>
		<td<?php echo $complete_fs_view->parent->CellAttributes() ?>>
<div<?php echo $complete_fs_view->parent->ViewAttributes() ?>><?php echo $complete_fs_view->parent->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->deprecated->Visible) { // deprecated ?>
		<td<?php echo $complete_fs_view->deprecated->CellAttributes() ?>>
<div<?php echo $complete_fs_view->deprecated->ViewAttributes() ?>><?php echo $complete_fs_view->deprecated->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->gid->Visible) { // gid ?>
		<td<?php echo $complete_fs_view->gid->CellAttributes() ?>>
<div<?php echo $complete_fs_view->gid->ViewAttributes() ?>><?php echo $complete_fs_view->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->group_name->Visible) { // group_name ?>
		<td<?php echo $complete_fs_view->group_name->CellAttributes() ?>>
<div<?php echo $complete_fs_view->group_name->ViewAttributes() ?>><?php echo $complete_fs_view->group_name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->snapshot->Visible) { // snapshot ?>
		<td<?php echo $complete_fs_view->snapshot->CellAttributes() ?>>
<div<?php echo $complete_fs_view->snapshot->ViewAttributes() ?>><?php echo $complete_fs_view->snapshot->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->tapebackup->Visible) { // tapebackup ?>
		<td<?php echo $complete_fs_view->tapebackup->CellAttributes() ?>>
<div<?php echo $complete_fs_view->tapebackup->ViewAttributes() ?>><?php echo $complete_fs_view->tapebackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->diskbackup->Visible) { // diskbackup ?>
		<td<?php echo $complete_fs_view->diskbackup->CellAttributes() ?>>
<div<?php echo $complete_fs_view->diskbackup->ViewAttributes() ?>><?php echo $complete_fs_view->diskbackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->type->Visible) { // type ?>
		<td<?php echo $complete_fs_view->type->CellAttributes() ?>>
<div<?php echo $complete_fs_view->type->ViewAttributes() ?>><?php echo $complete_fs_view->type->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($complete_fs_view->server_type->Visible) { // server_type ?>
		<td<?php echo $complete_fs_view->server_type->CellAttributes() ?>>
<div<?php echo $complete_fs_view->server_type->ViewAttributes() ?>><?php echo $complete_fs_view->server_type->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($complete_fs_view->Export == "") { ?>
<?php

// Custom list options
foreach ($complete_fs_view_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($complete_fs_view->CurrentAction <> "gridadd")
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
<?php if ($complete_fs_view->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($complete_fs_view->CurrentAction <> "gridadd" && $complete_fs_view->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($complete_fs_view_list->Pager)) $complete_fs_view_list->Pager = new cPrevNextPager($complete_fs_view_list->lStartRec, $complete_fs_view_list->lDisplayRecs, $complete_fs_view_list->lTotalRecs) ?>
<?php if ($complete_fs_view_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($complete_fs_view_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $complete_fs_view_list->PageUrl() ?>start=<?php echo $complete_fs_view_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($complete_fs_view_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $complete_fs_view_list->PageUrl() ?>start=<?php echo $complete_fs_view_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $complete_fs_view_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($complete_fs_view_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $complete_fs_view_list->PageUrl() ?>start=<?php echo $complete_fs_view_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($complete_fs_view_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $complete_fs_view_list->PageUrl() ?>start=<?php echo $complete_fs_view_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $complete_fs_view_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $complete_fs_view_list->Pager->FromIndex ?> to <?php echo $complete_fs_view_list->Pager->ToIndex ?> of <?php echo $complete_fs_view_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($complete_fs_view_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($complete_fs_view_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($complete_fs_view->Export == "" && $complete_fs_view->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(complete_fs_view_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($complete_fs_view->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$complete_fs_view_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class ccomplete_fs_view_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'complete_fs_view';

	// Page Object Name
	var $PageObjName = 'complete_fs_view_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $complete_fs_view;
		if ($complete_fs_view->UseTokenInUrl) $PageUrl .= "t=" . $complete_fs_view->TableVar . "&"; // add page token
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
		global $objForm, $complete_fs_view;
		if ($complete_fs_view->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($complete_fs_view->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($complete_fs_view->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccomplete_fs_view_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["complete_fs_view"] = new ccomplete_fs_view();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'complete_fs_view', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $complete_fs_view;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$complete_fs_view->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $complete_fs_view->Export; // Get export parameter, used in header
	$gsExportFile = $complete_fs_view->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $complete_fs_view;
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

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($complete_fs_view->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $complete_fs_view->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		if ($sSrchAdvanced <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "($this->sSrchWhere) AND ($sSrchAdvanced)" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "($this->sSrchWhere) AND ($sSrchBasic)" : $sSrchBasic;

		// Call Recordset_Searching event
		$complete_fs_view->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$complete_fs_view->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$complete_fs_view->setStartRecordNumber($this->lStartRec);
		} else {
			$this->RestoreSearchParms();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$complete_fs_view->setSessionWhere($sFilter);
		$complete_fs_view->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $complete_fs_view;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $complete_fs_view->mount->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $complete_fs_view->path->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $complete_fs_view->group_name->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $complete_fs_view->server_type->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $complete_fs_view;
		$sSearchStr = "";
		$sSearchKeyword = ew_StripSlashes(@$_GET[EW_TABLE_BASIC_SEARCH]);
		$sSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$complete_fs_view->setBasicSearchKeyword($sSearchKeyword);
			$complete_fs_view->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $complete_fs_view;
		$this->sSrchWhere = "";
		$complete_fs_view->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $complete_fs_view;
		$complete_fs_view->setBasicSearchKeyword("");
		$complete_fs_view->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $complete_fs_view;
		$this->sSrchWhere = $complete_fs_view->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $complete_fs_view;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$complete_fs_view->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$complete_fs_view->CurrentOrderType = @$_GET["ordertype"];
			$complete_fs_view->UpdateSort($complete_fs_view->id); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->mount); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->path); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->parent); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->deprecated); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->gid); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->group_name); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->snapshot); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->tapebackup); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->diskbackup); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->type); // Field 
			$complete_fs_view->UpdateSort($complete_fs_view->server_type); // Field 
			$complete_fs_view->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $complete_fs_view;
		$sOrderBy = $complete_fs_view->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($complete_fs_view->SqlOrderBy() <> "") {
				$sOrderBy = $complete_fs_view->SqlOrderBy();
				$complete_fs_view->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $complete_fs_view;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$complete_fs_view->setSessionOrderBy($sOrderBy);
				$complete_fs_view->id->setSort("");
				$complete_fs_view->mount->setSort("");
				$complete_fs_view->path->setSort("");
				$complete_fs_view->parent->setSort("");
				$complete_fs_view->deprecated->setSort("");
				$complete_fs_view->gid->setSort("");
				$complete_fs_view->group_name->setSort("");
				$complete_fs_view->snapshot->setSort("");
				$complete_fs_view->tapebackup->setSort("");
				$complete_fs_view->diskbackup->setSort("");
				$complete_fs_view->type->setSort("");
				$complete_fs_view->server_type->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$complete_fs_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $complete_fs_view;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$complete_fs_view->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$complete_fs_view->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $complete_fs_view->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$complete_fs_view->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$complete_fs_view->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$complete_fs_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $complete_fs_view;

		// Call Recordset Selecting event
		$complete_fs_view->Recordset_Selecting($complete_fs_view->CurrentFilter);

		// Load list page SQL
		$sSql = $complete_fs_view->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$complete_fs_view->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $complete_fs_view;
		$sFilter = $complete_fs_view->KeyFilter();

		// Call Row Selecting event
		$complete_fs_view->Row_Selecting($sFilter);

		// Load sql based on filter
		$complete_fs_view->CurrentFilter = $sFilter;
		$sSql = $complete_fs_view->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$complete_fs_view->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $complete_fs_view;
		$complete_fs_view->id->setDbValue($rs->fields('id'));
		$complete_fs_view->mount->setDbValue($rs->fields('mount'));
		$complete_fs_view->path->setDbValue($rs->fields('path'));
		$complete_fs_view->parent->setDbValue($rs->fields('parent'));
		$complete_fs_view->deprecated->setDbValue($rs->fields('deprecated'));
		$complete_fs_view->gid->setDbValue($rs->fields('gid'));
		$complete_fs_view->group_name->setDbValue($rs->fields('group_name'));
		$complete_fs_view->snapshot->setDbValue($rs->fields('snapshot'));
		$complete_fs_view->tapebackup->setDbValue($rs->fields('tapebackup'));
		$complete_fs_view->diskbackup->setDbValue($rs->fields('diskbackup'));
		$complete_fs_view->type->setDbValue($rs->fields('type'));
		$complete_fs_view->server_type->setDbValue($rs->fields('server_type'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $complete_fs_view;

		// Call Row_Rendering event
		$complete_fs_view->Row_Rendering();

		// Common render codes for all row types
		// id

		$complete_fs_view->id->CellCssStyle = "";
		$complete_fs_view->id->CellCssClass = "";

		// mount
		$complete_fs_view->mount->CellCssStyle = "";
		$complete_fs_view->mount->CellCssClass = "";

		// path
		$complete_fs_view->path->CellCssStyle = "";
		$complete_fs_view->path->CellCssClass = "";

		// parent
		$complete_fs_view->parent->CellCssStyle = "";
		$complete_fs_view->parent->CellCssClass = "";

		// deprecated
		$complete_fs_view->deprecated->CellCssStyle = "";
		$complete_fs_view->deprecated->CellCssClass = "";

		// gid
		$complete_fs_view->gid->CellCssStyle = "";
		$complete_fs_view->gid->CellCssClass = "";

		// group_name
		$complete_fs_view->group_name->CellCssStyle = "";
		$complete_fs_view->group_name->CellCssClass = "";

		// snapshot
		$complete_fs_view->snapshot->CellCssStyle = "";
		$complete_fs_view->snapshot->CellCssClass = "";

		// tapebackup
		$complete_fs_view->tapebackup->CellCssStyle = "";
		$complete_fs_view->tapebackup->CellCssClass = "";

		// diskbackup
		$complete_fs_view->diskbackup->CellCssStyle = "";
		$complete_fs_view->diskbackup->CellCssClass = "";

		// type
		$complete_fs_view->type->CellCssStyle = "";
		$complete_fs_view->type->CellCssClass = "";

		// server_type
		$complete_fs_view->server_type->CellCssStyle = "";
		$complete_fs_view->server_type->CellCssClass = "";
		if ($complete_fs_view->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$complete_fs_view->id->ViewValue = $complete_fs_view->id->CurrentValue;
			$complete_fs_view->id->CssStyle = "";
			$complete_fs_view->id->CssClass = "";
			$complete_fs_view->id->ViewCustomAttributes = "";

			// mount
			$complete_fs_view->mount->ViewValue = $complete_fs_view->mount->CurrentValue;
			$complete_fs_view->mount->CssStyle = "";
			$complete_fs_view->mount->CssClass = "";
			$complete_fs_view->mount->ViewCustomAttributes = "";

			// path
			$complete_fs_view->path->ViewValue = $complete_fs_view->path->CurrentValue;
			$complete_fs_view->path->CssStyle = "";
			$complete_fs_view->path->CssClass = "";
			$complete_fs_view->path->ViewCustomAttributes = "";

			// parent
			$complete_fs_view->parent->ViewValue = $complete_fs_view->parent->CurrentValue;
			$complete_fs_view->parent->CssStyle = "";
			$complete_fs_view->parent->CssClass = "";
			$complete_fs_view->parent->ViewCustomAttributes = "";

			// deprecated
			$complete_fs_view->deprecated->ViewValue = $complete_fs_view->deprecated->CurrentValue;
			$complete_fs_view->deprecated->CssStyle = "";
			$complete_fs_view->deprecated->CssClass = "";
			$complete_fs_view->deprecated->ViewCustomAttributes = "";

			// gid
			$complete_fs_view->gid->ViewValue = $complete_fs_view->gid->CurrentValue;
			$complete_fs_view->gid->CssStyle = "";
			$complete_fs_view->gid->CssClass = "";
			$complete_fs_view->gid->ViewCustomAttributes = "";

			// group_name
			$complete_fs_view->group_name->ViewValue = $complete_fs_view->group_name->CurrentValue;
			$complete_fs_view->group_name->CssStyle = "";
			$complete_fs_view->group_name->CssClass = "";
			$complete_fs_view->group_name->ViewCustomAttributes = "";

			// snapshot
			$complete_fs_view->snapshot->ViewValue = $complete_fs_view->snapshot->CurrentValue;
			$complete_fs_view->snapshot->CssStyle = "";
			$complete_fs_view->snapshot->CssClass = "";
			$complete_fs_view->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$complete_fs_view->tapebackup->ViewValue = $complete_fs_view->tapebackup->CurrentValue;
			$complete_fs_view->tapebackup->CssStyle = "";
			$complete_fs_view->tapebackup->CssClass = "";
			$complete_fs_view->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$complete_fs_view->diskbackup->ViewValue = $complete_fs_view->diskbackup->CurrentValue;
			$complete_fs_view->diskbackup->CssStyle = "";
			$complete_fs_view->diskbackup->CssClass = "";
			$complete_fs_view->diskbackup->ViewCustomAttributes = "";

			// type
			$complete_fs_view->type->ViewValue = $complete_fs_view->type->CurrentValue;
			$complete_fs_view->type->CssStyle = "";
			$complete_fs_view->type->CssClass = "";
			$complete_fs_view->type->ViewCustomAttributes = "";

			// server_type
			$complete_fs_view->server_type->ViewValue = $complete_fs_view->server_type->CurrentValue;
			$complete_fs_view->server_type->CssStyle = "";
			$complete_fs_view->server_type->CssClass = "";
			$complete_fs_view->server_type->ViewCustomAttributes = "";

			// id
			$complete_fs_view->id->HrefValue = "";

			// mount
			$complete_fs_view->mount->HrefValue = "";

			// path
			$complete_fs_view->path->HrefValue = "";

			// parent
			$complete_fs_view->parent->HrefValue = "";

			// deprecated
			$complete_fs_view->deprecated->HrefValue = "";

			// gid
			$complete_fs_view->gid->HrefValue = "";

			// group_name
			$complete_fs_view->group_name->HrefValue = "";

			// snapshot
			$complete_fs_view->snapshot->HrefValue = "";

			// tapebackup
			$complete_fs_view->tapebackup->HrefValue = "";

			// diskbackup
			$complete_fs_view->diskbackup->HrefValue = "";

			// type
			$complete_fs_view->type->HrefValue = "";

			// server_type
			$complete_fs_view->server_type->HrefValue = "";
		}

		// Call Row Rendered event
		$complete_fs_view->Row_Rendered();
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
