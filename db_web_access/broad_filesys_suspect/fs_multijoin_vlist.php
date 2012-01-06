<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "fs_multijoin_vinfo.php" ?>
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
$fs_multijoin_v_list = new cfs_multijoin_v_list();
$Page =& $fs_multijoin_v_list;

// Page init processing
$fs_multijoin_v_list->Page_Init();

// Page main processing
$fs_multijoin_v_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($fs_multijoin_v->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var fs_multijoin_v_list = new ew_Page("fs_multijoin_v_list");

// page properties
fs_multijoin_v_list.PageID = "list"; // page ID
var EW_PAGE_ID = fs_multijoin_v_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
fs_multijoin_v_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
fs_multijoin_v_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fs_multijoin_v_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($fs_multijoin_v->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($fs_multijoin_v->Export == "" && $fs_multijoin_v->SelectLimit);
	if (!$bSelectLimit)
		$rs = $fs_multijoin_v_list->LoadRecordset();
	$fs_multijoin_v_list->lTotalRecs = ($bSelectLimit) ? $fs_multijoin_v->SelectRecordCount() : $rs->RecordCount();
	$fs_multijoin_v_list->lStartRec = 1;
	if ($fs_multijoin_v_list->lDisplayRecs <= 0) // Display all records
		$fs_multijoin_v_list->lDisplayRecs = $fs_multijoin_v_list->lTotalRecs;
	if (!($fs_multijoin_v->ExportAll && $fs_multijoin_v->Export <> ""))
		$fs_multijoin_v_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $fs_multijoin_v_list->LoadRecordset($fs_multijoin_v_list->lStartRec-1, $fs_multijoin_v_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">View: Fs Multijoin V
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($fs_multijoin_v->Export == "" && $fs_multijoin_v->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(fs_multijoin_v_list);" style="text-decoration: none;"><img id="fs_multijoin_v_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="fs_multijoin_v_list_SearchPanel">
<form name="ffs_multijoin_vlistsrch" id="ffs_multijoin_vlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="fs_multijoin_v">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($fs_multijoin_v->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($fs_multijoin_v->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($fs_multijoin_v->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($fs_multijoin_v->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $fs_multijoin_v_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="ffs_multijoin_vlist" id="ffs_multijoin_vlist" class="ewForm" action="" method="post">
<?php if ($fs_multijoin_v_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$fs_multijoin_v_list->lOptionCnt = 0;
	$fs_multijoin_v_list->lOptionCnt += count($fs_multijoin_v_list->ListOptions->Items); // Custom list options
?>
<?php echo $fs_multijoin_v->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($fs_multijoin_v->id->Visible) { // id ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($fs_multijoin_v->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->mount->Visible) { // mount ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->mount) == "") { ?>
		<td>Mount</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->mount) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Mount&nbsp;(*)</td><td style="width: 10px;"><?php if ($fs_multijoin_v->mount->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->mount->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->path->Visible) { // path ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->path) == "") { ?>
		<td>Path</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->path) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Path&nbsp;(*)</td><td style="width: 10px;"><?php if ($fs_multijoin_v->path->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->path->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->parent->Visible) { // parent ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->parent) == "") { ?>
		<td>Parent</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->parent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Parent</td><td style="width: 10px;"><?php if ($fs_multijoin_v->parent->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->parent->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->deprecated->Visible) { // deprecated ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->deprecated) == "") { ?>
		<td>Deprecated</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->deprecated) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Deprecated</td><td style="width: 10px;"><?php if ($fs_multijoin_v->deprecated->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->deprecated->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->name->Visible) { // name ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->name) == "") { ?>
		<td>Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Name&nbsp;(*)</td><td style="width: 10px;"><?php if ($fs_multijoin_v->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->snapshot->Visible) { // snapshot ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->snapshot) == "") { ?>
		<td>Snapshot</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->snapshot) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Snapshot</td><td style="width: 10px;"><?php if ($fs_multijoin_v->snapshot->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->snapshot->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->tapebackup->Visible) { // tapebackup ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->tapebackup) == "") { ?>
		<td>Tapebackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->tapebackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Tapebackup</td><td style="width: 10px;"><?php if ($fs_multijoin_v->tapebackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->tapebackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->diskbackup->Visible) { // diskbackup ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->diskbackup) == "") { ?>
		<td>Diskbackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->diskbackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Diskbackup</td><td style="width: 10px;"><?php if ($fs_multijoin_v->diskbackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->diskbackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->type->Visible) { // type ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->type) == "") { ?>
		<td>Type</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Type</td><td style="width: 10px;"><?php if ($fs_multijoin_v->type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->CONTACT->Visible) { // CONTACT ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->CONTACT) == "") { ?>
		<td>CONTACT</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->CONTACT) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>CONTACT&nbsp;(*)</td><td style="width: 10px;"><?php if ($fs_multijoin_v->CONTACT->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->CONTACT->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->CONTACT2->Visible) { // CONTACT2 ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->CONTACT2) == "") { ?>
		<td>CONTACT2</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->CONTACT2) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>CONTACT2&nbsp;(*)</td><td style="width: 10px;"><?php if ($fs_multijoin_v->CONTACT2->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->CONTACT2->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->RESCOMP->Visible) { // RESCOMP ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->RESCOMP) == "") { ?>
		<td>RESCOMP</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->RESCOMP) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>RESCOMP&nbsp;(*)</td><td style="width: 10px;"><?php if ($fs_multijoin_v->RESCOMP->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->RESCOMP->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->Export == "") { ?>
<?php

// Custom list options
foreach ($fs_multijoin_v_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($fs_multijoin_v->ExportAll && $fs_multijoin_v->Export <> "") {
	$fs_multijoin_v_list->lStopRec = $fs_multijoin_v_list->lTotalRecs;
} else {
	$fs_multijoin_v_list->lStopRec = $fs_multijoin_v_list->lStartRec + $fs_multijoin_v_list->lDisplayRecs - 1; // Set the last record to display
}
$fs_multijoin_v_list->lRecCount = $fs_multijoin_v_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$fs_multijoin_v->SelectLimit && $fs_multijoin_v_list->lStartRec > 1)
		$rs->Move($fs_multijoin_v_list->lStartRec - 1);
}
$fs_multijoin_v_list->lRowCnt = 0;
while (($fs_multijoin_v->CurrentAction == "gridadd" || !$rs->EOF) &&
	$fs_multijoin_v_list->lRecCount < $fs_multijoin_v_list->lStopRec) {
	$fs_multijoin_v_list->lRecCount++;
	if (intval($fs_multijoin_v_list->lRecCount) >= intval($fs_multijoin_v_list->lStartRec)) {
		$fs_multijoin_v_list->lRowCnt++;

	// Init row class and style
	$fs_multijoin_v->CssClass = "";
	$fs_multijoin_v->CssStyle = "";
	$fs_multijoin_v->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($fs_multijoin_v->CurrentAction == "gridadd") {
		$fs_multijoin_v_list->LoadDefaultValues(); // Load default values
	} else {
		$fs_multijoin_v_list->LoadRowValues($rs); // Load row values
	}
	$fs_multijoin_v->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$fs_multijoin_v_list->RenderRow();
?>
	<tr<?php echo $fs_multijoin_v->RowAttributes() ?>>
	<?php if ($fs_multijoin_v->id->Visible) { // id ?>
		<td<?php echo $fs_multijoin_v->id->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->id->ViewAttributes() ?>><?php echo $fs_multijoin_v->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->mount->Visible) { // mount ?>
		<td<?php echo $fs_multijoin_v->mount->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->mount->ViewAttributes() ?>><?php echo $fs_multijoin_v->mount->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->path->Visible) { // path ?>
		<td<?php echo $fs_multijoin_v->path->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->path->ViewAttributes() ?>><?php echo $fs_multijoin_v->path->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->parent->Visible) { // parent ?>
		<td<?php echo $fs_multijoin_v->parent->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->parent->ViewAttributes() ?>><?php echo $fs_multijoin_v->parent->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->deprecated->Visible) { // deprecated ?>
		<td<?php echo $fs_multijoin_v->deprecated->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->deprecated->ViewAttributes() ?>><?php echo $fs_multijoin_v->deprecated->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->name->Visible) { // name ?>
		<td<?php echo $fs_multijoin_v->name->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->name->ViewAttributes() ?>><?php echo $fs_multijoin_v->name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->snapshot->Visible) { // snapshot ?>
		<td<?php echo $fs_multijoin_v->snapshot->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->snapshot->ViewAttributes() ?>><?php echo $fs_multijoin_v->snapshot->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->tapebackup->Visible) { // tapebackup ?>
		<td<?php echo $fs_multijoin_v->tapebackup->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->tapebackup->ViewAttributes() ?>><?php echo $fs_multijoin_v->tapebackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->diskbackup->Visible) { // diskbackup ?>
		<td<?php echo $fs_multijoin_v->diskbackup->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->diskbackup->ViewAttributes() ?>><?php echo $fs_multijoin_v->diskbackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->type->Visible) { // type ?>
		<td<?php echo $fs_multijoin_v->type->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->type->ViewAttributes() ?>><?php echo $fs_multijoin_v->type->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->CONTACT->Visible) { // CONTACT ?>
		<td<?php echo $fs_multijoin_v->CONTACT->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->CONTACT->ViewAttributes() ?>><?php echo $fs_multijoin_v->CONTACT->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->CONTACT2->Visible) { // CONTACT2 ?>
		<td<?php echo $fs_multijoin_v->CONTACT2->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->CONTACT2->ViewAttributes() ?>><?php echo $fs_multijoin_v->CONTACT2->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fs_multijoin_v->RESCOMP->Visible) { // RESCOMP ?>
		<td<?php echo $fs_multijoin_v->RESCOMP->CellAttributes() ?>>
<div<?php echo $fs_multijoin_v->RESCOMP->ViewAttributes() ?>><?php echo $fs_multijoin_v->RESCOMP->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($fs_multijoin_v->Export == "") { ?>
<?php

// Custom list options
foreach ($fs_multijoin_v_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($fs_multijoin_v->CurrentAction <> "gridadd")
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
<?php if ($fs_multijoin_v->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($fs_multijoin_v->CurrentAction <> "gridadd" && $fs_multijoin_v->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($fs_multijoin_v_list->Pager)) $fs_multijoin_v_list->Pager = new cPrevNextPager($fs_multijoin_v_list->lStartRec, $fs_multijoin_v_list->lDisplayRecs, $fs_multijoin_v_list->lTotalRecs) ?>
<?php if ($fs_multijoin_v_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($fs_multijoin_v_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>start=<?php echo $fs_multijoin_v_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($fs_multijoin_v_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>start=<?php echo $fs_multijoin_v_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $fs_multijoin_v_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($fs_multijoin_v_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>start=<?php echo $fs_multijoin_v_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($fs_multijoin_v_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>start=<?php echo $fs_multijoin_v_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $fs_multijoin_v_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $fs_multijoin_v_list->Pager->FromIndex ?> to <?php echo $fs_multijoin_v_list->Pager->ToIndex ?> of <?php echo $fs_multijoin_v_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($fs_multijoin_v_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($fs_multijoin_v_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($fs_multijoin_v->Export == "" && $fs_multijoin_v->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(fs_multijoin_v_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($fs_multijoin_v->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$fs_multijoin_v_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cfs_multijoin_v_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'fs_multijoin_v';

	// Page Object Name
	var $PageObjName = 'fs_multijoin_v_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $fs_multijoin_v;
		if ($fs_multijoin_v->UseTokenInUrl) $PageUrl .= "t=" . $fs_multijoin_v->TableVar . "&"; // add page token
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
		global $objForm, $fs_multijoin_v;
		if ($fs_multijoin_v->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($fs_multijoin_v->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($fs_multijoin_v->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cfs_multijoin_v_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["fs_multijoin_v"] = new cfs_multijoin_v();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fs_multijoin_v', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $fs_multijoin_v;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$fs_multijoin_v->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $fs_multijoin_v->Export; // Get export parameter, used in header
	$gsExportFile = $fs_multijoin_v->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $fs_multijoin_v;
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
		if ($fs_multijoin_v->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $fs_multijoin_v->getRecordsPerPage(); // Restore from Session
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
		$fs_multijoin_v->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$fs_multijoin_v->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$fs_multijoin_v->setStartRecordNumber($this->lStartRec);
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
		$fs_multijoin_v->setSessionWhere($sFilter);
		$fs_multijoin_v->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $fs_multijoin_v;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $fs_multijoin_v->mount->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $fs_multijoin_v->path->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $fs_multijoin_v->name->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $fs_multijoin_v->CONTACT->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $fs_multijoin_v->CONTACT2->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $fs_multijoin_v->RESCOMP->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $fs_multijoin_v;
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
			$fs_multijoin_v->setBasicSearchKeyword($sSearchKeyword);
			$fs_multijoin_v->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $fs_multijoin_v;
		$this->sSrchWhere = "";
		$fs_multijoin_v->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $fs_multijoin_v;
		$fs_multijoin_v->setBasicSearchKeyword("");
		$fs_multijoin_v->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $fs_multijoin_v;
		$this->sSrchWhere = $fs_multijoin_v->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $fs_multijoin_v;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$fs_multijoin_v->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$fs_multijoin_v->CurrentOrderType = @$_GET["ordertype"];
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->id); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->mount); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->path); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->parent); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->deprecated); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->name); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->snapshot); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->tapebackup); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->diskbackup); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->type); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->CONTACT); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->CONTACT2); // Field 
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->RESCOMP); // Field 
			$fs_multijoin_v->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $fs_multijoin_v;
		$sOrderBy = $fs_multijoin_v->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($fs_multijoin_v->SqlOrderBy() <> "") {
				$sOrderBy = $fs_multijoin_v->SqlOrderBy();
				$fs_multijoin_v->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $fs_multijoin_v;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$fs_multijoin_v->setSessionOrderBy($sOrderBy);
				$fs_multijoin_v->id->setSort("");
				$fs_multijoin_v->mount->setSort("");
				$fs_multijoin_v->path->setSort("");
				$fs_multijoin_v->parent->setSort("");
				$fs_multijoin_v->deprecated->setSort("");
				$fs_multijoin_v->name->setSort("");
				$fs_multijoin_v->snapshot->setSort("");
				$fs_multijoin_v->tapebackup->setSort("");
				$fs_multijoin_v->diskbackup->setSort("");
				$fs_multijoin_v->type->setSort("");
				$fs_multijoin_v->CONTACT->setSort("");
				$fs_multijoin_v->CONTACT2->setSort("");
				$fs_multijoin_v->RESCOMP->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$fs_multijoin_v->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $fs_multijoin_v;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$fs_multijoin_v->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$fs_multijoin_v->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $fs_multijoin_v->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$fs_multijoin_v->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$fs_multijoin_v->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$fs_multijoin_v->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $fs_multijoin_v;

		// Call Recordset Selecting event
		$fs_multijoin_v->Recordset_Selecting($fs_multijoin_v->CurrentFilter);

		// Load list page SQL
		$sSql = $fs_multijoin_v->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$fs_multijoin_v->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $fs_multijoin_v;
		$sFilter = $fs_multijoin_v->KeyFilter();

		// Call Row Selecting event
		$fs_multijoin_v->Row_Selecting($sFilter);

		// Load sql based on filter
		$fs_multijoin_v->CurrentFilter = $sFilter;
		$sSql = $fs_multijoin_v->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$fs_multijoin_v->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $fs_multijoin_v;
		$fs_multijoin_v->id->setDbValue($rs->fields('id'));
		$fs_multijoin_v->mount->setDbValue($rs->fields('mount'));
		$fs_multijoin_v->path->setDbValue($rs->fields('path'));
		$fs_multijoin_v->parent->setDbValue($rs->fields('parent'));
		$fs_multijoin_v->deprecated->setDbValue($rs->fields('deprecated'));
		$fs_multijoin_v->name->setDbValue($rs->fields('name'));
		$fs_multijoin_v->snapshot->setDbValue($rs->fields('snapshot'));
		$fs_multijoin_v->tapebackup->setDbValue($rs->fields('tapebackup'));
		$fs_multijoin_v->diskbackup->setDbValue($rs->fields('diskbackup'));
		$fs_multijoin_v->type->setDbValue($rs->fields('type'));
		$fs_multijoin_v->CONTACT->setDbValue($rs->fields('CONTACT'));
		$fs_multijoin_v->CONTACT2->setDbValue($rs->fields('CONTACT2'));
		$fs_multijoin_v->RESCOMP->setDbValue($rs->fields('RESCOMP'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $fs_multijoin_v;

		// Call Row_Rendering event
		$fs_multijoin_v->Row_Rendering();

		// Common render codes for all row types
		// id

		$fs_multijoin_v->id->CellCssStyle = "";
		$fs_multijoin_v->id->CellCssClass = "";

		// mount
		$fs_multijoin_v->mount->CellCssStyle = "";
		$fs_multijoin_v->mount->CellCssClass = "";

		// path
		$fs_multijoin_v->path->CellCssStyle = "";
		$fs_multijoin_v->path->CellCssClass = "";

		// parent
		$fs_multijoin_v->parent->CellCssStyle = "";
		$fs_multijoin_v->parent->CellCssClass = "";

		// deprecated
		$fs_multijoin_v->deprecated->CellCssStyle = "";
		$fs_multijoin_v->deprecated->CellCssClass = "";

		// name
		$fs_multijoin_v->name->CellCssStyle = "";
		$fs_multijoin_v->name->CellCssClass = "";

		// snapshot
		$fs_multijoin_v->snapshot->CellCssStyle = "";
		$fs_multijoin_v->snapshot->CellCssClass = "";

		// tapebackup
		$fs_multijoin_v->tapebackup->CellCssStyle = "";
		$fs_multijoin_v->tapebackup->CellCssClass = "";

		// diskbackup
		$fs_multijoin_v->diskbackup->CellCssStyle = "";
		$fs_multijoin_v->diskbackup->CellCssClass = "";

		// type
		$fs_multijoin_v->type->CellCssStyle = "";
		$fs_multijoin_v->type->CellCssClass = "";

		// CONTACT
		$fs_multijoin_v->CONTACT->CellCssStyle = "";
		$fs_multijoin_v->CONTACT->CellCssClass = "";

		// CONTACT2
		$fs_multijoin_v->CONTACT2->CellCssStyle = "";
		$fs_multijoin_v->CONTACT2->CellCssClass = "";

		// RESCOMP
		$fs_multijoin_v->RESCOMP->CellCssStyle = "";
		$fs_multijoin_v->RESCOMP->CellCssClass = "";
		if ($fs_multijoin_v->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$fs_multijoin_v->id->ViewValue = $fs_multijoin_v->id->CurrentValue;
			$fs_multijoin_v->id->CssStyle = "";
			$fs_multijoin_v->id->CssClass = "";
			$fs_multijoin_v->id->ViewCustomAttributes = "";

			// mount
			$fs_multijoin_v->mount->ViewValue = $fs_multijoin_v->mount->CurrentValue;
			$fs_multijoin_v->mount->CssStyle = "";
			$fs_multijoin_v->mount->CssClass = "";
			$fs_multijoin_v->mount->ViewCustomAttributes = "";

			// path
			$fs_multijoin_v->path->ViewValue = $fs_multijoin_v->path->CurrentValue;
			$fs_multijoin_v->path->CssStyle = "";
			$fs_multijoin_v->path->CssClass = "";
			$fs_multijoin_v->path->ViewCustomAttributes = "";

			// parent
			$fs_multijoin_v->parent->ViewValue = $fs_multijoin_v->parent->CurrentValue;
			$fs_multijoin_v->parent->CssStyle = "";
			$fs_multijoin_v->parent->CssClass = "";
			$fs_multijoin_v->parent->ViewCustomAttributes = "";

			// deprecated
			$fs_multijoin_v->deprecated->ViewValue = $fs_multijoin_v->deprecated->CurrentValue;
			$fs_multijoin_v->deprecated->CssStyle = "";
			$fs_multijoin_v->deprecated->CssClass = "";
			$fs_multijoin_v->deprecated->ViewCustomAttributes = "";

			// name
			$fs_multijoin_v->name->ViewValue = $fs_multijoin_v->name->CurrentValue;
			$fs_multijoin_v->name->CssStyle = "";
			$fs_multijoin_v->name->CssClass = "";
			$fs_multijoin_v->name->ViewCustomAttributes = "";

			// snapshot
			$fs_multijoin_v->snapshot->ViewValue = $fs_multijoin_v->snapshot->CurrentValue;
			$fs_multijoin_v->snapshot->CssStyle = "";
			$fs_multijoin_v->snapshot->CssClass = "";
			$fs_multijoin_v->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$fs_multijoin_v->tapebackup->ViewValue = $fs_multijoin_v->tapebackup->CurrentValue;
			$fs_multijoin_v->tapebackup->CssStyle = "";
			$fs_multijoin_v->tapebackup->CssClass = "";
			$fs_multijoin_v->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$fs_multijoin_v->diskbackup->ViewValue = $fs_multijoin_v->diskbackup->CurrentValue;
			$fs_multijoin_v->diskbackup->CssStyle = "";
			$fs_multijoin_v->diskbackup->CssClass = "";
			$fs_multijoin_v->diskbackup->ViewCustomAttributes = "";

			// type
			$fs_multijoin_v->type->ViewValue = $fs_multijoin_v->type->CurrentValue;
			$fs_multijoin_v->type->CssStyle = "";
			$fs_multijoin_v->type->CssClass = "";
			$fs_multijoin_v->type->ViewCustomAttributes = "";

			// CONTACT
			$fs_multijoin_v->CONTACT->ViewValue = $fs_multijoin_v->CONTACT->CurrentValue;
			$fs_multijoin_v->CONTACT->CssStyle = "";
			$fs_multijoin_v->CONTACT->CssClass = "";
			$fs_multijoin_v->CONTACT->ViewCustomAttributes = "";

			// CONTACT2
			$fs_multijoin_v->CONTACT2->ViewValue = $fs_multijoin_v->CONTACT2->CurrentValue;
			$fs_multijoin_v->CONTACT2->CssStyle = "";
			$fs_multijoin_v->CONTACT2->CssClass = "";
			$fs_multijoin_v->CONTACT2->ViewCustomAttributes = "";

			// RESCOMP
			$fs_multijoin_v->RESCOMP->ViewValue = $fs_multijoin_v->RESCOMP->CurrentValue;
			$fs_multijoin_v->RESCOMP->CssStyle = "";
			$fs_multijoin_v->RESCOMP->CssClass = "";
			$fs_multijoin_v->RESCOMP->ViewCustomAttributes = "";

			// id
			$fs_multijoin_v->id->HrefValue = "";

			// mount
			$fs_multijoin_v->mount->HrefValue = "";

			// path
			$fs_multijoin_v->path->HrefValue = "";

			// parent
			$fs_multijoin_v->parent->HrefValue = "";

			// deprecated
			$fs_multijoin_v->deprecated->HrefValue = "";

			// name
			$fs_multijoin_v->name->HrefValue = "";

			// snapshot
			$fs_multijoin_v->snapshot->HrefValue = "";

			// tapebackup
			$fs_multijoin_v->tapebackup->HrefValue = "";

			// diskbackup
			$fs_multijoin_v->diskbackup->HrefValue = "";

			// type
			$fs_multijoin_v->type->HrefValue = "";

			// CONTACT
			$fs_multijoin_v->CONTACT->HrefValue = "";

			// CONTACT2
			$fs_multijoin_v->CONTACT2->HrefValue = "";

			// RESCOMP
			$fs_multijoin_v->RESCOMP->HrefValue = "";
		}

		// Call Row Rendered event
		$fs_multijoin_v->Row_Rendered();
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
