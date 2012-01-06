<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "fs_multijoin_vinfo.php" ?>
<?php include "userfn7.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$fs_multijoin_v_list = new cfs_multijoin_v_list();
$Page =& $fs_multijoin_v_list;

// Page init
$fs_multijoin_v_list->Page_Init();

// Page main
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
fs_multijoin_v_list.FormID = "ffs_multijoin_vlist"; // form ID
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
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$fs_multijoin_v_list->lTotalRecs = $fs_multijoin_v->SelectRecordCount();
	} else {
		if ($rs = $fs_multijoin_v_list->LoadRecordset())
			$fs_multijoin_v_list->lTotalRecs = $rs->RecordCount();
	}
	$fs_multijoin_v_list->lStartRec = 1;
	if ($fs_multijoin_v_list->lDisplayRecs <= 0 || ($fs_multijoin_v->Export <> "" && $fs_multijoin_v->ExportAll)) // Display all records
		$fs_multijoin_v_list->lDisplayRecs = $fs_multijoin_v_list->lTotalRecs;
	if (!($fs_multijoin_v->Export <> "" && $fs_multijoin_v->ExportAll))
		$fs_multijoin_v_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $fs_multijoin_v_list->LoadRecordset($fs_multijoin_v_list->lStartRec-1, $fs_multijoin_v_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $fs_multijoin_v->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($fs_multijoin_v->Export == "" && $fs_multijoin_v->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(fs_multijoin_v_list);" style="text-decoration: none;"><img id="fs_multijoin_v_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fs_multijoin_v_list_SearchPanel">
<form name="ffs_multijoin_vlistsrch" id="ffs_multijoin_vlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="fs_multijoin_v">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($fs_multijoin_v->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($fs_multijoin_v->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($fs_multijoin_v->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($fs_multijoin_v->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$fs_multijoin_v_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="ffs_multijoin_vlist" id="ffs_multijoin_vlist" class="ewForm" action="" method="post">
<div id="gmp_fs_multijoin_v" class="ewGridMiddlePanel">
<?php if ($fs_multijoin_v_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $fs_multijoin_v->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$fs_multijoin_v_list->RenderListOptions();

// Render list options (header, left)
$fs_multijoin_v_list->ListOptions->Render("header", "left");
?>
<?php if ($fs_multijoin_v->id->Visible) { // id ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->id) == "") { ?>
		<td><?php echo $fs_multijoin_v->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->mount->Visible) { // mount ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->mount) == "") { ?>
		<td><?php echo $fs_multijoin_v->mount->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->mount) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->mount->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->mount->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->mount->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->path->Visible) { // path ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->path) == "") { ?>
		<td><?php echo $fs_multijoin_v->path->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->path) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->path->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->path->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->path->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->parent->Visible) { // parent ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->parent) == "") { ?>
		<td><?php echo $fs_multijoin_v->parent->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->parent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->parent->FldCaption() ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->parent->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->parent->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->deprecated->Visible) { // deprecated ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->deprecated) == "") { ?>
		<td><?php echo $fs_multijoin_v->deprecated->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->deprecated) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->deprecated->FldCaption() ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->deprecated->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->deprecated->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->name->Visible) { // name ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->name) == "") { ?>
		<td><?php echo $fs_multijoin_v->name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->snapshot->Visible) { // snapshot ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->snapshot) == "") { ?>
		<td><?php echo $fs_multijoin_v->snapshot->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->snapshot) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->snapshot->FldCaption() ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->snapshot->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->snapshot->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->tapebackup->Visible) { // tapebackup ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->tapebackup) == "") { ?>
		<td><?php echo $fs_multijoin_v->tapebackup->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->tapebackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->tapebackup->FldCaption() ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->tapebackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->tapebackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->diskbackup->Visible) { // diskbackup ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->diskbackup) == "") { ?>
		<td><?php echo $fs_multijoin_v->diskbackup->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->diskbackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->diskbackup->FldCaption() ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->diskbackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->diskbackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->type->Visible) { // type ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->type) == "") { ?>
		<td><?php echo $fs_multijoin_v->type->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->type->FldCaption() ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->CONTACT->Visible) { // CONTACT ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->CONTACT) == "") { ?>
		<td><?php echo $fs_multijoin_v->CONTACT->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->CONTACT) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->CONTACT->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->CONTACT->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->CONTACT->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->CONTACT2->Visible) { // CONTACT2 ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->CONTACT2) == "") { ?>
		<td><?php echo $fs_multijoin_v->CONTACT2->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->CONTACT2) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->CONTACT2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->CONTACT2->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->CONTACT2->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($fs_multijoin_v->RESCOMP->Visible) { // RESCOMP ?>
	<?php if ($fs_multijoin_v->SortUrl($fs_multijoin_v->RESCOMP) == "") { ?>
		<td><?php echo $fs_multijoin_v->RESCOMP->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fs_multijoin_v->SortUrl($fs_multijoin_v->RESCOMP) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $fs_multijoin_v->RESCOMP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($fs_multijoin_v->RESCOMP->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fs_multijoin_v->RESCOMP->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$fs_multijoin_v_list->ListOptions->Render("header", "right");
?>
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
	if (!$bSelectLimit && $fs_multijoin_v_list->lStartRec > 1)
		$rs->Move($fs_multijoin_v_list->lStartRec - 1);
}

// Initialize aggregate
$fs_multijoin_v->RowType = EW_ROWTYPE_AGGREGATEINIT;
$fs_multijoin_v_list->RenderRow();
$fs_multijoin_v_list->lRowCnt = 0;
while (($fs_multijoin_v->CurrentAction == "gridadd" || !$rs->EOF) &&
	$fs_multijoin_v_list->lRecCount < $fs_multijoin_v_list->lStopRec) {
	$fs_multijoin_v_list->lRecCount++;
	if (intval($fs_multijoin_v_list->lRecCount) >= intval($fs_multijoin_v_list->lStartRec)) {
		$fs_multijoin_v_list->lRowCnt++;

	// Init row class and style
	$fs_multijoin_v->CssClass = "";
	$fs_multijoin_v->CssStyle = "";
	$fs_multijoin_v->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($fs_multijoin_v->CurrentAction == "gridadd") {
		$fs_multijoin_v_list->LoadDefaultValues(); // Load default values
	} else {
		$fs_multijoin_v_list->LoadRowValues($rs); // Load row values
	}
	$fs_multijoin_v->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$fs_multijoin_v_list->RenderRow();

	// Render list options
	$fs_multijoin_v_list->RenderListOptions();
?>
	<tr<?php echo $fs_multijoin_v->RowAttributes() ?>>
<?php

// Render list options (body, left)
$fs_multijoin_v_list->ListOptions->Render("body", "left");
?>
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
<?php

// Render list options (body, right)
$fs_multijoin_v_list->ListOptions->Render("body", "right");
?>
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
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($fs_multijoin_v->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($fs_multijoin_v->CurrentAction <> "gridadd" && $fs_multijoin_v->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($fs_multijoin_v_list->Pager)) $fs_multijoin_v_list->Pager = new cPrevNextPager($fs_multijoin_v_list->lStartRec, $fs_multijoin_v_list->lDisplayRecs, $fs_multijoin_v_list->lTotalRecs) ?>
<?php if ($fs_multijoin_v_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($fs_multijoin_v_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>start=<?php echo $fs_multijoin_v_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($fs_multijoin_v_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>start=<?php echo $fs_multijoin_v_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $fs_multijoin_v_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($fs_multijoin_v_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>start=<?php echo $fs_multijoin_v_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($fs_multijoin_v_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $fs_multijoin_v_list->PageUrl() ?>start=<?php echo $fs_multijoin_v_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $fs_multijoin_v_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $fs_multijoin_v_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $fs_multijoin_v_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $fs_multijoin_v_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($fs_multijoin_v_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
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
// Page class
//
class cfs_multijoin_v_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'fs_multijoin_v';

	// Page object name
	var $PageObjName = 'fs_multijoin_v_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $fs_multijoin_v;
		if ($fs_multijoin_v->UseTokenInUrl) $PageUrl .= "t=" . $fs_multijoin_v->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $fs_multijoin_v;
		if ($fs_multijoin_v->UseTokenInUrl) {
			if ($objForm)
				return ($fs_multijoin_v->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($fs_multijoin_v->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cfs_multijoin_v_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (fs_multijoin_v)
		$GLOBALS["fs_multijoin_v"] = new cfs_multijoin_v();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["fs_multijoin_v"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "fs_multijoin_vdelete.php";
		$this->MultiUpdateUrl = "fs_multijoin_vupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fs_multijoin_v', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $fs_multijoin_v;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$fs_multijoin_v->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$fs_multijoin_v->Export = $_POST["exporttype"];
		} else {
			$fs_multijoin_v->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $fs_multijoin_v->Export; // Get export parameter, used in header
		$gsExportFile = $fs_multijoin_v->TableVar; // Get export file, used in header

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $lDisplayRecs = 20;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $sSrchWhere = ""; // Search WHERE clause
	var $lRecCnt = 0; // Record count
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex; // Row index
	var $lRecPerRow = 0;
	var $lColCnt = 0;
	var $sDbMasterFilter = ""; // Master filter
	var $sDbDetailFilter = ""; // Detail filter
	var $bMasterRecordExists;	
	var $sMultiSelectKey;
	var $RestoreSearch;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError, $Security, $fs_multijoin_v;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$fs_multijoin_v->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

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
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchAdvanced . ")" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchBasic. ")" : $sSrchBasic;

		// Call Recordset_Searching event
		$fs_multijoin_v->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$fs_multijoin_v->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$fs_multijoin_v->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $fs_multijoin_v->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$fs_multijoin_v->setSessionWhere($sFilter);
		$fs_multijoin_v->CurrentFilter = "";
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $fs_multijoin_v;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $fs_multijoin_v->mount, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $fs_multijoin_v->path, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $fs_multijoin_v->name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $fs_multijoin_v->CONTACT, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $fs_multijoin_v->CONTACT2, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $fs_multijoin_v->RESCOMP, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . " LIKE " . ew_QuotedValue("%" . $Keyword . "%", $lFldDataType);
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $fs_multijoin_v;
		$sSearchStr = "";
		$sSearchKeyword = $fs_multijoin_v->BasicSearchKeyword;
		$sSearchType = $fs_multijoin_v->BasicSearchType;
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
			$fs_multijoin_v->setSessionBasicSearchKeyword($sSearchKeyword);
			$fs_multijoin_v->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $fs_multijoin_v;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$fs_multijoin_v->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $fs_multijoin_v;
		$fs_multijoin_v->setSessionBasicSearchKeyword("");
		$fs_multijoin_v->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $fs_multijoin_v;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$fs_multijoin_v->BasicSearchKeyword = $fs_multijoin_v->getSessionBasicSearchKeyword();
			$fs_multijoin_v->BasicSearchType = $fs_multijoin_v->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $fs_multijoin_v;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$fs_multijoin_v->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$fs_multijoin_v->CurrentOrderType = @$_GET["ordertype"];
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->id); // id
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->mount); // mount
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->path); // path
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->parent); // parent
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->deprecated); // deprecated
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->name); // name
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->snapshot); // snapshot
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->tapebackup); // tapebackup
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->diskbackup); // diskbackup
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->type); // type
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->CONTACT); // CONTACT
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->CONTACT2); // CONTACT2
			$fs_multijoin_v->UpdateSort($fs_multijoin_v->RESCOMP); // RESCOMP
			$fs_multijoin_v->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $fs_multijoin_v;
		$sOrderBy = $fs_multijoin_v->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($fs_multijoin_v->SqlOrderBy() <> "") {
				$sOrderBy = $fs_multijoin_v->SqlOrderBy();
				$fs_multijoin_v->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $fs_multijoin_v;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
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

	// Set up list options
	function SetupListOptions() {
		global $Security, $fs_multijoin_v;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($fs_multijoin_v->Export <> "" ||
			$fs_multijoin_v->CurrentAction == "gridadd" ||
			$fs_multijoin_v->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $fs_multijoin_v;
		$this->ListOptions->LoadDefault();
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $fs_multijoin_v;
	}

	// Set up starting record parameters
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

	// Load basic search values
	function LoadBasicSearchValues() {
		global $fs_multijoin_v;
		$fs_multijoin_v->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$fs_multijoin_v->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $fs_multijoin_v;

		// Call Recordset Selecting event
		$fs_multijoin_v->Recordset_Selecting($fs_multijoin_v->CurrentFilter);

		// Load List page SQL
		$sSql = $fs_multijoin_v->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

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

		// Load SQL based on filter
		$fs_multijoin_v->CurrentFilter = $sFilter;
		$sSql = $fs_multijoin_v->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$fs_multijoin_v->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $fs_multijoin_v;
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
		global $conn, $Security, $Language, $fs_multijoin_v;

		// Initialize URLs
		$this->ViewUrl = $fs_multijoin_v->ViewUrl();
		$this->EditUrl = $fs_multijoin_v->EditUrl();
		$this->InlineEditUrl = $fs_multijoin_v->InlineEditUrl();
		$this->CopyUrl = $fs_multijoin_v->CopyUrl();
		$this->InlineCopyUrl = $fs_multijoin_v->InlineCopyUrl();
		$this->DeleteUrl = $fs_multijoin_v->DeleteUrl();

		// Call Row_Rendering event
		$fs_multijoin_v->Row_Rendering();

		// Common render codes for all row types
		// id

		$fs_multijoin_v->id->CellCssStyle = ""; $fs_multijoin_v->id->CellCssClass = "";
		$fs_multijoin_v->id->CellAttrs = array(); $fs_multijoin_v->id->ViewAttrs = array(); $fs_multijoin_v->id->EditAttrs = array();

		// mount
		$fs_multijoin_v->mount->CellCssStyle = ""; $fs_multijoin_v->mount->CellCssClass = "";
		$fs_multijoin_v->mount->CellAttrs = array(); $fs_multijoin_v->mount->ViewAttrs = array(); $fs_multijoin_v->mount->EditAttrs = array();

		// path
		$fs_multijoin_v->path->CellCssStyle = ""; $fs_multijoin_v->path->CellCssClass = "";
		$fs_multijoin_v->path->CellAttrs = array(); $fs_multijoin_v->path->ViewAttrs = array(); $fs_multijoin_v->path->EditAttrs = array();

		// parent
		$fs_multijoin_v->parent->CellCssStyle = ""; $fs_multijoin_v->parent->CellCssClass = "";
		$fs_multijoin_v->parent->CellAttrs = array(); $fs_multijoin_v->parent->ViewAttrs = array(); $fs_multijoin_v->parent->EditAttrs = array();

		// deprecated
		$fs_multijoin_v->deprecated->CellCssStyle = ""; $fs_multijoin_v->deprecated->CellCssClass = "";
		$fs_multijoin_v->deprecated->CellAttrs = array(); $fs_multijoin_v->deprecated->ViewAttrs = array(); $fs_multijoin_v->deprecated->EditAttrs = array();

		// name
		$fs_multijoin_v->name->CellCssStyle = ""; $fs_multijoin_v->name->CellCssClass = "";
		$fs_multijoin_v->name->CellAttrs = array(); $fs_multijoin_v->name->ViewAttrs = array(); $fs_multijoin_v->name->EditAttrs = array();

		// snapshot
		$fs_multijoin_v->snapshot->CellCssStyle = ""; $fs_multijoin_v->snapshot->CellCssClass = "";
		$fs_multijoin_v->snapshot->CellAttrs = array(); $fs_multijoin_v->snapshot->ViewAttrs = array(); $fs_multijoin_v->snapshot->EditAttrs = array();

		// tapebackup
		$fs_multijoin_v->tapebackup->CellCssStyle = ""; $fs_multijoin_v->tapebackup->CellCssClass = "";
		$fs_multijoin_v->tapebackup->CellAttrs = array(); $fs_multijoin_v->tapebackup->ViewAttrs = array(); $fs_multijoin_v->tapebackup->EditAttrs = array();

		// diskbackup
		$fs_multijoin_v->diskbackup->CellCssStyle = ""; $fs_multijoin_v->diskbackup->CellCssClass = "";
		$fs_multijoin_v->diskbackup->CellAttrs = array(); $fs_multijoin_v->diskbackup->ViewAttrs = array(); $fs_multijoin_v->diskbackup->EditAttrs = array();

		// type
		$fs_multijoin_v->type->CellCssStyle = ""; $fs_multijoin_v->type->CellCssClass = "";
		$fs_multijoin_v->type->CellAttrs = array(); $fs_multijoin_v->type->ViewAttrs = array(); $fs_multijoin_v->type->EditAttrs = array();

		// CONTACT
		$fs_multijoin_v->CONTACT->CellCssStyle = ""; $fs_multijoin_v->CONTACT->CellCssClass = "";
		$fs_multijoin_v->CONTACT->CellAttrs = array(); $fs_multijoin_v->CONTACT->ViewAttrs = array(); $fs_multijoin_v->CONTACT->EditAttrs = array();

		// CONTACT2
		$fs_multijoin_v->CONTACT2->CellCssStyle = ""; $fs_multijoin_v->CONTACT2->CellCssClass = "";
		$fs_multijoin_v->CONTACT2->CellAttrs = array(); $fs_multijoin_v->CONTACT2->ViewAttrs = array(); $fs_multijoin_v->CONTACT2->EditAttrs = array();

		// RESCOMP
		$fs_multijoin_v->RESCOMP->CellCssStyle = ""; $fs_multijoin_v->RESCOMP->CellCssClass = "";
		$fs_multijoin_v->RESCOMP->CellAttrs = array(); $fs_multijoin_v->RESCOMP->ViewAttrs = array(); $fs_multijoin_v->RESCOMP->EditAttrs = array();
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
			$fs_multijoin_v->id->TooltipValue = "";

			// mount
			$fs_multijoin_v->mount->HrefValue = "";
			$fs_multijoin_v->mount->TooltipValue = "";

			// path
			$fs_multijoin_v->path->HrefValue = "";
			$fs_multijoin_v->path->TooltipValue = "";

			// parent
			$fs_multijoin_v->parent->HrefValue = "";
			$fs_multijoin_v->parent->TooltipValue = "";

			// deprecated
			$fs_multijoin_v->deprecated->HrefValue = "";
			$fs_multijoin_v->deprecated->TooltipValue = "";

			// name
			$fs_multijoin_v->name->HrefValue = "";
			$fs_multijoin_v->name->TooltipValue = "";

			// snapshot
			$fs_multijoin_v->snapshot->HrefValue = "";
			$fs_multijoin_v->snapshot->TooltipValue = "";

			// tapebackup
			$fs_multijoin_v->tapebackup->HrefValue = "";
			$fs_multijoin_v->tapebackup->TooltipValue = "";

			// diskbackup
			$fs_multijoin_v->diskbackup->HrefValue = "";
			$fs_multijoin_v->diskbackup->TooltipValue = "";

			// type
			$fs_multijoin_v->type->HrefValue = "";
			$fs_multijoin_v->type->TooltipValue = "";

			// CONTACT
			$fs_multijoin_v->CONTACT->HrefValue = "";
			$fs_multijoin_v->CONTACT->TooltipValue = "";

			// CONTACT2
			$fs_multijoin_v->CONTACT2->HrefValue = "";
			$fs_multijoin_v->CONTACT2->TooltipValue = "";

			// RESCOMP
			$fs_multijoin_v->RESCOMP->HrefValue = "";
			$fs_multijoin_v->RESCOMP->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($fs_multijoin_v->RowType <> EW_ROWTYPE_AGGREGATEINIT)
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

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example: 
		//$this->ListOptions->Add("new");
		//$this->ListOptions->Items["new"]->OnLeft = TRUE; // Link on left
		//$this->ListOptions->MoveItem("new", 0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
