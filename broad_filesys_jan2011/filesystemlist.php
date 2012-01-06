<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "filesysteminfo.php" ?>
<?php include "grpinfo.php" ?>
<?php include "server_typeinfo.php" ?>
<?php include "usersinfo.php" ?>
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
$filesystem_list = new cfilesystem_list();
$Page =& $filesystem_list;

// Page init processing
$filesystem_list->Page_Init();

// Page main processing
$filesystem_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($filesystem->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var filesystem_list = new ew_Page("filesystem_list");

// page properties
filesystem_list.PageID = "list"; // page ID
var EW_PAGE_ID = filesystem_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
filesystem_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
filesystem_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
filesystem_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($filesystem->Export == "") { ?>
<?php
$gsMasterReturnUrl = "grplist.php";
if ($filesystem_list->sDbMasterFilter <> "" && $filesystem->getCurrentMasterTable() == "grp") {
	if ($filesystem_list->bMasterRecordExists) {
		if ($filesystem->getCurrentMasterTable() == $filesystem->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include "grpmaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "userslist.php";
if ($filesystem_list->sDbMasterFilter <> "" && $filesystem->getCurrentMasterTable() == "users") {
	if ($filesystem_list->bMasterRecordExists) {
		if ($filesystem->getCurrentMasterTable() == $filesystem->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include "usersmaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "server_typelist.php";
if ($filesystem_list->sDbMasterFilter <> "" && $filesystem->getCurrentMasterTable() == "server_type") {
	if ($filesystem_list->bMasterRecordExists) {
		if ($filesystem->getCurrentMasterTable() == $filesystem->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include "server_typemaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = ($filesystem->Export == "" && $filesystem->SelectLimit);
	if (!$bSelectLimit)
		$rs = $filesystem_list->LoadRecordset();
	$filesystem_list->lTotalRecs = ($bSelectLimit) ? $filesystem->SelectRecordCount() : $rs->RecordCount();
	$filesystem_list->lStartRec = 1;
	if ($filesystem_list->lDisplayRecs <= 0) // Display all records
		$filesystem_list->lDisplayRecs = $filesystem_list->lTotalRecs;
	if (!($filesystem->ExportAll && $filesystem->Export <> ""))
		$filesystem_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $filesystem_list->LoadRecordset($filesystem_list->lStartRec-1, $filesystem_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Filesystem
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($filesystem->Export == "" && $filesystem->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(filesystem_list);" style="text-decoration: none;"><img id="filesystem_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="filesystem_list_SearchPanel">
<form name="ffilesystemlistsrch" id="ffilesystemlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="filesystem">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($filesystem->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $filesystem_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($filesystem->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($filesystem->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($filesystem->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $filesystem_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="ffilesystemlist" id="ffilesystemlist" class="ewForm" action="" method="post">
<?php if ($filesystem_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$filesystem_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$filesystem_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$filesystem_list->lOptionCnt++; // edit
}
	$filesystem_list->lOptionCnt += count($filesystem_list->ListOptions->Items); // Custom list options
?>
<?php echo $filesystem->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($filesystem->id->Visible) { // id ?>
	<?php if ($filesystem->SortUrl($filesystem->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($filesystem->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->mount->Visible) { // mount ?>
	<?php if ($filesystem->SortUrl($filesystem->mount) == "") { ?>
		<td>Mount</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->mount) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Mount&nbsp;(*)</td><td style="width: 10px;"><?php if ($filesystem->mount->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->mount->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->path->Visible) { // path ?>
	<?php if ($filesystem->SortUrl($filesystem->path) == "") { ?>
		<td>Path</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->path) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Path&nbsp;(*)</td><td style="width: 10px;"><?php if ($filesystem->path->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->path->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->parent->Visible) { // parent ?>
	<?php if ($filesystem->SortUrl($filesystem->parent) == "") { ?>
		<td>Parent</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->parent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Parent</td><td style="width: 10px;"><?php if ($filesystem->parent->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->parent->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
	<?php if ($filesystem->SortUrl($filesystem->deprecated) == "") { ?>
		<td>Deprecated</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->deprecated) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Deprecated</td><td style="width: 10px;"><?php if ($filesystem->deprecated->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->deprecated->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->gid->Visible) { // gid ?>
	<?php if ($filesystem->SortUrl($filesystem->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($filesystem->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
	<?php if ($filesystem->SortUrl($filesystem->snapshot) == "") { ?>
		<td>Snapshot</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->snapshot) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Snapshot</td><td style="width: 10px;"><?php if ($filesystem->snapshot->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->snapshot->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
	<?php if ($filesystem->SortUrl($filesystem->tapebackup) == "") { ?>
		<td>Tapebackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->tapebackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Tapebackup</td><td style="width: 10px;"><?php if ($filesystem->tapebackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->tapebackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
	<?php if ($filesystem->SortUrl($filesystem->diskbackup) == "") { ?>
		<td>Diskbackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->diskbackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Diskbackup</td><td style="width: 10px;"><?php if ($filesystem->diskbackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->diskbackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->type->Visible) { // type ?>
	<?php if ($filesystem->SortUrl($filesystem->type) == "") { ?>
		<td>Type</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Type</td><td style="width: 10px;"><?php if ($filesystem->type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->contact->Visible) { // contact ?>
	<?php if ($filesystem->SortUrl($filesystem->contact) == "") { ?>
		<td>Contact</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->contact) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Contact</td><td style="width: 10px;"><?php if ($filesystem->contact->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->contact->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->contact2->Visible) { // contact2 ?>
	<?php if ($filesystem->SortUrl($filesystem->contact2) == "") { ?>
		<td>Contact 2</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->contact2) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Contact 2</td><td style="width: 10px;"><?php if ($filesystem->contact2->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->contact2->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
	<?php if ($filesystem->SortUrl($filesystem->rescomp) == "") { ?>
		<td>Rescomp</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->rescomp) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Rescomp</td><td style="width: 10px;"><?php if ($filesystem->rescomp->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->rescomp->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($filesystem_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($filesystem->ExportAll && $filesystem->Export <> "") {
	$filesystem_list->lStopRec = $filesystem_list->lTotalRecs;
} else {
	$filesystem_list->lStopRec = $filesystem_list->lStartRec + $filesystem_list->lDisplayRecs - 1; // Set the last record to display
}
$filesystem_list->lRecCount = $filesystem_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$filesystem->SelectLimit && $filesystem_list->lStartRec > 1)
		$rs->Move($filesystem_list->lStartRec - 1);
}
$filesystem_list->lRowCnt = 0;
while (($filesystem->CurrentAction == "gridadd" || !$rs->EOF) &&
	$filesystem_list->lRecCount < $filesystem_list->lStopRec) {
	$filesystem_list->lRecCount++;
	if (intval($filesystem_list->lRecCount) >= intval($filesystem_list->lStartRec)) {
		$filesystem_list->lRowCnt++;

	// Init row class and style
	$filesystem->CssClass = "";
	$filesystem->CssStyle = "";
	$filesystem->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($filesystem->CurrentAction == "gridadd") {
		$filesystem_list->LoadDefaultValues(); // Load default values
	} else {
		$filesystem_list->LoadRowValues($rs); // Load row values
	}
	$filesystem->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$filesystem_list->RenderRow();
?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
	<?php if ($filesystem->id->Visible) { // id ?>
		<td<?php echo $filesystem->id->CellAttributes() ?>>
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->mount->Visible) { // mount ?>
		<td<?php echo $filesystem->mount->CellAttributes() ?>>
<div<?php echo $filesystem->mount->ViewAttributes() ?>><?php echo $filesystem->mount->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->path->Visible) { // path ?>
		<td<?php echo $filesystem->path->CellAttributes() ?>>
<div<?php echo $filesystem->path->ViewAttributes() ?>><?php echo $filesystem->path->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->parent->Visible) { // parent ?>
		<td<?php echo $filesystem->parent->CellAttributes() ?>>
<div<?php echo $filesystem->parent->ViewAttributes() ?>><?php echo $filesystem->parent->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
		<td<?php echo $filesystem->deprecated->CellAttributes() ?>>
<div<?php echo $filesystem->deprecated->ViewAttributes() ?>><?php echo $filesystem->deprecated->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->gid->Visible) { // gid ?>
		<td<?php echo $filesystem->gid->CellAttributes() ?>>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
		<td<?php echo $filesystem->snapshot->CellAttributes() ?>>
<div<?php echo $filesystem->snapshot->ViewAttributes() ?>><?php echo $filesystem->snapshot->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
		<td<?php echo $filesystem->tapebackup->CellAttributes() ?>>
<div<?php echo $filesystem->tapebackup->ViewAttributes() ?>><?php echo $filesystem->tapebackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
		<td<?php echo $filesystem->diskbackup->CellAttributes() ?>>
<div<?php echo $filesystem->diskbackup->ViewAttributes() ?>><?php echo $filesystem->diskbackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->type->Visible) { // type ?>
		<td<?php echo $filesystem->type->CellAttributes() ?>>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->contact->Visible) { // contact ?>
		<td<?php echo $filesystem->contact->CellAttributes() ?>>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->contact2->Visible) { // contact2 ?>
		<td<?php echo $filesystem->contact2->CellAttributes() ?>>
<div<?php echo $filesystem->contact2->ViewAttributes() ?>><?php echo $filesystem->contact2->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
		<td<?php echo $filesystem->rescomp->CellAttributes() ?>>
<div<?php echo $filesystem->rescomp->ViewAttributes() ?>><?php echo $filesystem->rescomp->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($filesystem->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $filesystem->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $filesystem->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($filesystem_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($filesystem->CurrentAction <> "gridadd")
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
<?php if ($filesystem->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($filesystem->CurrentAction <> "gridadd" && $filesystem->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($filesystem_list->Pager)) $filesystem_list->Pager = new cPrevNextPager($filesystem_list->lStartRec, $filesystem_list->lDisplayRecs, $filesystem_list->lTotalRecs) ?>
<?php if ($filesystem_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($filesystem_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $filesystem_list->PageUrl() ?>start=<?php echo $filesystem_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($filesystem_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $filesystem_list->PageUrl() ?>start=<?php echo $filesystem_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $filesystem_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($filesystem_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $filesystem_list->PageUrl() ?>start=<?php echo $filesystem_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($filesystem_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $filesystem_list->PageUrl() ?>start=<?php echo $filesystem_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $filesystem_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $filesystem_list->Pager->FromIndex ?> to <?php echo $filesystem_list->Pager->ToIndex ?> of <?php echo $filesystem_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($filesystem_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($filesystem_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($filesystem->Export == "" && $filesystem->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(filesystem_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($filesystem->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$filesystem_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cfilesystem_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'filesystem';

	// Page Object Name
	var $PageObjName = 'filesystem_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $filesystem;
		if ($filesystem->UseTokenInUrl) $PageUrl .= "t=" . $filesystem->TableVar . "&"; // add page token
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
		global $objForm, $filesystem;
		if ($filesystem->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($filesystem->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($filesystem->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cfilesystem_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["filesystem"] = new cfilesystem();

		// Initialize other table object
		$GLOBALS['grp'] = new cgrp();

		// Initialize other table object
		$GLOBALS['server_type'] = new cserver_type();

		// Initialize other table object
		$GLOBALS['users'] = new cusers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'filesystem', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $filesystem;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$filesystem->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $filesystem->Export; // Get export parameter, used in header
	$gsExportFile = $filesystem->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $filesystem;
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

			// Set up master detail parameters
			$this->SetUpMasterDetail();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($filesystem->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $filesystem->getRecordsPerPage(); // Restore from Session
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
		$filesystem->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$filesystem->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$filesystem->setStartRecordNumber($this->lStartRec);
		} else {
			$this->RestoreSearchParms();
		}

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->sDbMasterFilter = $filesystem->getMasterFilter(); // Restore master filter
		$this->sDbDetailFilter = $filesystem->getDetailFilter(); // Restore detail filter
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Load master record
		if ($filesystem->getMasterFilter() <> "" && $filesystem->getCurrentMasterTable() == "grp") {
			global $grp;
			$rsmaster = $grp->LoadRs($this->sDbMasterFilter);
			$this->bMasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->bMasterRecordExists) {
				$filesystem->setMasterFilter(""); // Clear master filter
				$filesystem->setDetailFilter(""); // Clear detail filter
				$this->setMessage("No records found"); // Set no record found
				$this->Page_Terminate($filesystem->getReturnUrl()); // Return to caller
			} else {
				$grp->LoadListRowValues($rsmaster);
				$grp->RowType = EW_ROWTYPE_MASTER; // Master row
				$grp->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($filesystem->getMasterFilter() <> "" && $filesystem->getCurrentMasterTable() == "users") {
			global $users;
			$rsmaster = $users->LoadRs($this->sDbMasterFilter);
			$this->bMasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->bMasterRecordExists) {
				$filesystem->setMasterFilter(""); // Clear master filter
				$filesystem->setDetailFilter(""); // Clear detail filter
				$this->setMessage("No records found"); // Set no record found
				$this->Page_Terminate($filesystem->getReturnUrl()); // Return to caller
			} else {
				$users->LoadListRowValues($rsmaster);
				$users->RowType = EW_ROWTYPE_MASTER; // Master row
				$users->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($filesystem->getMasterFilter() <> "" && $filesystem->getCurrentMasterTable() == "server_type") {
			global $server_type;
			$rsmaster = $server_type->LoadRs($this->sDbMasterFilter);
			$this->bMasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->bMasterRecordExists) {
				$filesystem->setMasterFilter(""); // Clear master filter
				$filesystem->setDetailFilter(""); // Clear detail filter
				$this->setMessage("No records found"); // Set no record found
				$this->Page_Terminate($filesystem->getReturnUrl()); // Return to caller
			} else {
				$server_type->LoadListRowValues($rsmaster);
				$server_type->RowType = EW_ROWTYPE_MASTER; // Master row
				$server_type->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in Session
		$filesystem->setSessionWhere($sFilter);
		$filesystem->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $filesystem;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $filesystem->mount->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $filesystem->path->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $filesystem;
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
			$filesystem->setBasicSearchKeyword($sSearchKeyword);
			$filesystem->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $filesystem;
		$this->sSrchWhere = "";
		$filesystem->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $filesystem;
		$filesystem->setBasicSearchKeyword("");
		$filesystem->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $filesystem;
		$this->sSrchWhere = $filesystem->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $filesystem;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$filesystem->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$filesystem->CurrentOrderType = @$_GET["ordertype"];
			$filesystem->UpdateSort($filesystem->id); // Field 
			$filesystem->UpdateSort($filesystem->mount); // Field 
			$filesystem->UpdateSort($filesystem->path); // Field 
			$filesystem->UpdateSort($filesystem->parent); // Field 
			$filesystem->UpdateSort($filesystem->deprecated); // Field 
			$filesystem->UpdateSort($filesystem->gid); // Field 
			$filesystem->UpdateSort($filesystem->snapshot); // Field 
			$filesystem->UpdateSort($filesystem->tapebackup); // Field 
			$filesystem->UpdateSort($filesystem->diskbackup); // Field 
			$filesystem->UpdateSort($filesystem->type); // Field 
			$filesystem->UpdateSort($filesystem->contact); // Field 
			$filesystem->UpdateSort($filesystem->contact2); // Field 
			$filesystem->UpdateSort($filesystem->rescomp); // Field 
			$filesystem->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $filesystem;
		$sOrderBy = $filesystem->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($filesystem->SqlOrderBy() <> "") {
				$sOrderBy = $filesystem->SqlOrderBy();
				$filesystem->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $filesystem;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$filesystem->getCurrentMasterTable = ""; // Clear master table
				$filesystem->setMasterFilter(""); // Clear master filter
				$this->sDbMasterFilter = "";
				$filesystem->setDetailFilter(""); // Clear detail filter
				$this->sDbDetailFilter = "";
				$filesystem->gid->setSessionValue("");
				$filesystem->contact->setSessionValue("");
				$filesystem->type->setSessionValue("");
			}

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$filesystem->setSessionOrderBy($sOrderBy);
				$filesystem->id->setSort("");
				$filesystem->mount->setSort("");
				$filesystem->path->setSort("");
				$filesystem->parent->setSort("");
				$filesystem->deprecated->setSort("");
				$filesystem->gid->setSort("");
				$filesystem->snapshot->setSort("");
				$filesystem->tapebackup->setSort("");
				$filesystem->diskbackup->setSort("");
				$filesystem->type->setSort("");
				$filesystem->contact->setSort("");
				$filesystem->contact2->setSort("");
				$filesystem->rescomp->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$filesystem->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $filesystem;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$filesystem->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$filesystem->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $filesystem->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$filesystem->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$filesystem->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$filesystem->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $filesystem;

		// Call Recordset Selecting event
		$filesystem->Recordset_Selecting($filesystem->CurrentFilter);

		// Load list page SQL
		$sSql = $filesystem->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$filesystem->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $filesystem;
		$sFilter = $filesystem->KeyFilter();

		// Call Row Selecting event
		$filesystem->Row_Selecting($sFilter);

		// Load sql based on filter
		$filesystem->CurrentFilter = $sFilter;
		$sSql = $filesystem->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$filesystem->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $filesystem;
		$filesystem->id->setDbValue($rs->fields('id'));
		$filesystem->mount->setDbValue($rs->fields('mount'));
		$filesystem->path->setDbValue($rs->fields('path'));
		$filesystem->parent->setDbValue($rs->fields('parent'));
		$filesystem->deprecated->setDbValue($rs->fields('deprecated'));
		$filesystem->gid->setDbValue($rs->fields('gid'));
		$filesystem->snapshot->setDbValue($rs->fields('snapshot'));
		$filesystem->tapebackup->setDbValue($rs->fields('tapebackup'));
		$filesystem->diskbackup->setDbValue($rs->fields('diskbackup'));
		$filesystem->type->setDbValue($rs->fields('type'));
		$filesystem->contact->setDbValue($rs->fields('contact'));
		$filesystem->contact2->setDbValue($rs->fields('contact2'));
		$filesystem->rescomp->setDbValue($rs->fields('rescomp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $filesystem;

		// Call Row_Rendering event
		$filesystem->Row_Rendering();

		// Common render codes for all row types
		// id

		$filesystem->id->CellCssStyle = "";
		$filesystem->id->CellCssClass = "";

		// mount
		$filesystem->mount->CellCssStyle = "";
		$filesystem->mount->CellCssClass = "";

		// path
		$filesystem->path->CellCssStyle = "";
		$filesystem->path->CellCssClass = "";

		// parent
		$filesystem->parent->CellCssStyle = "";
		$filesystem->parent->CellCssClass = "";

		// deprecated
		$filesystem->deprecated->CellCssStyle = "";
		$filesystem->deprecated->CellCssClass = "";

		// gid
		$filesystem->gid->CellCssStyle = "";
		$filesystem->gid->CellCssClass = "";

		// snapshot
		$filesystem->snapshot->CellCssStyle = "";
		$filesystem->snapshot->CellCssClass = "";

		// tapebackup
		$filesystem->tapebackup->CellCssStyle = "";
		$filesystem->tapebackup->CellCssClass = "";

		// diskbackup
		$filesystem->diskbackup->CellCssStyle = "";
		$filesystem->diskbackup->CellCssClass = "";

		// type
		$filesystem->type->CellCssStyle = "";
		$filesystem->type->CellCssClass = "";

		// contact
		$filesystem->contact->CellCssStyle = "";
		$filesystem->contact->CellCssClass = "";

		// contact2
		$filesystem->contact2->CellCssStyle = "";
		$filesystem->contact2->CellCssClass = "";

		// rescomp
		$filesystem->rescomp->CellCssStyle = "";
		$filesystem->rescomp->CellCssClass = "";
		if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$filesystem->id->ViewValue = $filesystem->id->CurrentValue;
			$filesystem->id->CssStyle = "";
			$filesystem->id->CssClass = "";
			$filesystem->id->ViewCustomAttributes = "";

			// mount
			$filesystem->mount->ViewValue = $filesystem->mount->CurrentValue;
			$filesystem->mount->CssStyle = "";
			$filesystem->mount->CssClass = "";
			$filesystem->mount->ViewCustomAttributes = "";

			// path
			$filesystem->path->ViewValue = $filesystem->path->CurrentValue;
			$filesystem->path->CssStyle = "";
			$filesystem->path->CssClass = "";
			$filesystem->path->ViewCustomAttributes = "";

			// parent
			$filesystem->parent->ViewValue = $filesystem->parent->CurrentValue;
			$filesystem->parent->CssStyle = "";
			$filesystem->parent->CssClass = "";
			$filesystem->parent->ViewCustomAttributes = "";

			// deprecated
			$filesystem->deprecated->ViewValue = $filesystem->deprecated->CurrentValue;
			$filesystem->deprecated->CssStyle = "";
			$filesystem->deprecated->CssClass = "";
			$filesystem->deprecated->ViewCustomAttributes = "";

			// gid
			if (strval($filesystem->gid->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `id`, `name` FROM `grp` WHERE `id` = " . ew_AdjustSql($filesystem->gid->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->gid->ViewValue = $rswrk->fields('id');
					$filesystem->gid->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
					$rswrk->Close();
				} else {
					$filesystem->gid->ViewValue = $filesystem->gid->CurrentValue;
				}
			} else {
				$filesystem->gid->ViewValue = NULL;
			}
			$filesystem->gid->CssStyle = "";
			$filesystem->gid->CssClass = "";
			$filesystem->gid->ViewCustomAttributes = "";

			// snapshot
			$filesystem->snapshot->ViewValue = $filesystem->snapshot->CurrentValue;
			$filesystem->snapshot->CssStyle = "";
			$filesystem->snapshot->CssClass = "";
			$filesystem->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$filesystem->tapebackup->ViewValue = $filesystem->tapebackup->CurrentValue;
			$filesystem->tapebackup->CssStyle = "";
			$filesystem->tapebackup->CssClass = "";
			$filesystem->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$filesystem->diskbackup->ViewValue = $filesystem->diskbackup->CurrentValue;
			$filesystem->diskbackup->CssStyle = "";
			$filesystem->diskbackup->CssClass = "";
			$filesystem->diskbackup->ViewCustomAttributes = "";

			// type
			if (strval($filesystem->type->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `id`, `name` FROM `server_type` WHERE `id` = " . ew_AdjustSql($filesystem->type->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->type->ViewValue = $rswrk->fields('id');
					$filesystem->type->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
					$rswrk->Close();
				} else {
					$filesystem->type->ViewValue = $filesystem->type->CurrentValue;
				}
			} else {
				$filesystem->type->ViewValue = NULL;
			}
			$filesystem->type->CssStyle = "";
			$filesystem->type->CssClass = "";
			$filesystem->type->ViewCustomAttributes = "";

			// contact
			$filesystem->contact->ViewValue = $filesystem->contact->CurrentValue;
			if (strval($filesystem->contact->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `uid`, `gecos` FROM `users` WHERE `uid` = " . ew_AdjustSql($filesystem->contact->CurrentValue) . "";
				$sSqlWrk .= " AND (" . "filesystem.gid = users.uid" . ")";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->contact->ViewValue = $rswrk->fields('uid');
					$filesystem->contact->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->contact->ViewValue = $filesystem->contact->CurrentValue;
				}
			} else {
				$filesystem->contact->ViewValue = NULL;
			}
			$filesystem->contact->CssStyle = "";
			$filesystem->contact->CssClass = "";
			$filesystem->contact->ViewCustomAttributes = "";

			// contact2
			$filesystem->contact2->ViewValue = $filesystem->contact2->CurrentValue;
			$filesystem->contact2->CssStyle = "";
			$filesystem->contact2->CssClass = "";
			$filesystem->contact2->ViewCustomAttributes = "";

			// rescomp
			$filesystem->rescomp->ViewValue = $filesystem->rescomp->CurrentValue;
			$filesystem->rescomp->CssStyle = "";
			$filesystem->rescomp->CssClass = "";
			$filesystem->rescomp->ViewCustomAttributes = "";

			// id
			$filesystem->id->HrefValue = "";

			// mount
			$filesystem->mount->HrefValue = "";

			// path
			$filesystem->path->HrefValue = "";

			// parent
			$filesystem->parent->HrefValue = "";

			// deprecated
			$filesystem->deprecated->HrefValue = "";

			// gid
			$filesystem->gid->HrefValue = "";

			// snapshot
			$filesystem->snapshot->HrefValue = "";

			// tapebackup
			$filesystem->tapebackup->HrefValue = "";

			// diskbackup
			$filesystem->diskbackup->HrefValue = "";

			// type
			$filesystem->type->HrefValue = "";

			// contact
			$filesystem->contact->HrefValue = "";

			// contact2
			$filesystem->contact2->HrefValue = "";

			// rescomp
			$filesystem->rescomp->HrefValue = "";
		}

		// Call Row Rendered event
		$filesystem->Row_Rendered();
	}

	// Set up Master Detail based on querystring parameter
	function SetUpMasterDetail() {
		global $filesystem;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = "";
				$this->sDbDetailFilter = "";
			}
			if ($sMasterTblVar == "grp") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = $filesystem->SqlMasterFilter_grp();
				$this->sDbDetailFilter = $filesystem->SqlDetailFilter_grp();
				if (@$_GET["id"] <> "") {
					$GLOBALS["grp"]->id->setQueryStringValue($_GET["id"]);
					$filesystem->gid->setQueryStringValue($GLOBALS["grp"]->id->QueryStringValue);
					$filesystem->gid->setSessionValue($filesystem->gid->QueryStringValue);
					if (!is_numeric($GLOBALS["grp"]->id->QueryStringValue)) $bValidMaster = FALSE;
					$this->sDbMasterFilter = str_replace("@id@", ew_AdjustSql($GLOBALS["grp"]->id->QueryStringValue), $this->sDbMasterFilter);
					$this->sDbDetailFilter = str_replace("@gid@", ew_AdjustSql($GLOBALS["grp"]->id->QueryStringValue), $this->sDbDetailFilter);
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "users") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = $filesystem->SqlMasterFilter_users();
				$this->sDbDetailFilter = $filesystem->SqlDetailFilter_users();
				if (@$_GET["uid"] <> "") {
					$GLOBALS["users"]->uid->setQueryStringValue($_GET["uid"]);
					$filesystem->contact->setQueryStringValue($GLOBALS["users"]->uid->QueryStringValue);
					$filesystem->contact->setSessionValue($filesystem->contact->QueryStringValue);
					if (!is_numeric($GLOBALS["users"]->uid->QueryStringValue)) $bValidMaster = FALSE;
					$this->sDbMasterFilter = str_replace("@uid@", ew_AdjustSql($GLOBALS["users"]->uid->QueryStringValue), $this->sDbMasterFilter);
					$this->sDbDetailFilter = str_replace("@contact@", ew_AdjustSql($GLOBALS["users"]->uid->QueryStringValue), $this->sDbDetailFilter);
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "server_type") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = $filesystem->SqlMasterFilter_server_type();
				$this->sDbDetailFilter = $filesystem->SqlDetailFilter_server_type();
				if (@$_GET["id"] <> "") {
					$GLOBALS["server_type"]->id->setQueryStringValue($_GET["id"]);
					$filesystem->type->setQueryStringValue($GLOBALS["server_type"]->id->QueryStringValue);
					$filesystem->type->setSessionValue($filesystem->type->QueryStringValue);
					if (!is_numeric($GLOBALS["server_type"]->id->QueryStringValue)) $bValidMaster = FALSE;
					$this->sDbMasterFilter = str_replace("@id@", ew_AdjustSql($GLOBALS["server_type"]->id->QueryStringValue), $this->sDbMasterFilter);
					$this->sDbDetailFilter = str_replace("@type@", ew_AdjustSql($GLOBALS["server_type"]->id->QueryStringValue), $this->sDbDetailFilter);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$filesystem->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->lStartRec = 1;
			$filesystem->setStartRecordNumber($this->lStartRec);
			$filesystem->setMasterFilter($this->sDbMasterFilter); // Set up master filter
			$filesystem->setDetailFilter($this->sDbDetailFilter); // Set up detail filter

			// Clear previous master session values
			if ($sMasterTblVar <> "grp") {
				if ($filesystem->gid->QueryStringValue == "") $filesystem->gid->setSessionValue("");
			}
			if ($sMasterTblVar <> "users") {
				if ($filesystem->contact->QueryStringValue == "") $filesystem->contact->setSessionValue("");
			}
			if ($sMasterTblVar <> "server_type") {
				if ($filesystem->type->QueryStringValue == "") $filesystem->type->setSessionValue("");
			}
		} else {
			$this->sDbMasterFilter = $filesystem->getMasterFilter(); //  Restore master filter
			$this->sDbDetailFilter = $filesystem->getDetailFilter(); // Restore detail filter
		}
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
