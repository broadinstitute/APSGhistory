<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "filesysteminfo.php" ?>
<?php include "grpinfo.php" ?>
<?php include "server_typeinfo.php" ?>
<?php include "usersinfo.php" ?>
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
$filesystem_list = new cfilesystem_list();
$Page =& $filesystem_list;

// Page init
$filesystem_list->Page_Init();

// Page main
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
filesystem_list.FormID = "ffilesystemlist"; // form ID
var EW_PAGE_ID = filesystem_list.PageID; // for backward compatibility

// extend page with ValidateForm function
filesystem_list.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	var addcnt = 0;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		var chkthisrow = true;
		if (fobj.a_list && fobj.a_list.value == "gridinsert")
			chkthisrow = !(this.EmptyRow(fobj, infix));
		else
			chkthisrow = true;
		if (chkthisrow) {
			addcnt += 1;
		elm = fobj.elements["x" + infix + "_mount"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($filesystem->mount->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_path"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($filesystem->path->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_parent"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($filesystem->parent->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_deprecated"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($filesystem->deprecated->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_snapshot"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($filesystem->snapshot->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_tapebackup"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($filesystem->tapebackup->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_diskbackup"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($filesystem->diskbackup->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_maxdepth"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($filesystem->maxdepth->FldErrMsg()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
		} // End Grid Add checking
	}
	if (fobj.a_list && fobj.a_list.value == "gridinsert" && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Extend page with empty row check
filesystem_list.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "mount", false)) return false;
	if (ew_ValueChanged(fobj, infix, "path", false)) return false;
	if (ew_ValueChanged(fobj, infix, "parent", false)) return false;
	if (ew_ValueChanged(fobj, infix, "deprecated", false)) return false;
	if (ew_ValueChanged(fobj, infix, "gid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "snapshot", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tapebackup", false)) return false;
	if (ew_ValueChanged(fobj, infix, "diskbackup", false)) return false;
	if (ew_ValueChanged(fobj, infix, "type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "contact", false)) return false;
	if (ew_ValueChanged(fobj, infix, "contact2", false)) return false;
	if (ew_ValueChanged(fobj, infix, "rescomp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "maxdepth", false)) return false;
	return true;
}

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
if ($filesystem->CurrentAction == "gridadd") {
	$filesystem->CurrentFilter = "0=1";
	$filesystem_list->lStartRec = 1;
	if ($filesystem_list->lDisplayRecs <= 0)
		$filesystem_list->lDisplayRecs = 20;
	$filesystem_list->lTotalRecs = $filesystem_list->lDisplayRecs;
	$filesystem_list->lStopRec = $filesystem_list->lDisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$filesystem_list->lTotalRecs = $filesystem->SelectRecordCount();
	} else {
		if ($rs = $filesystem_list->LoadRecordset())
			$filesystem_list->lTotalRecs = $rs->RecordCount();
	}
	$filesystem_list->lStartRec = 1;
	if ($filesystem_list->lDisplayRecs <= 0 || ($filesystem->Export <> "" && $filesystem->ExportAll)) // Display all records
		$filesystem_list->lDisplayRecs = $filesystem_list->lTotalRecs;
	if (!($filesystem->Export <> "" && $filesystem->ExportAll))
		$filesystem_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $filesystem_list->LoadRecordset($filesystem_list->lStartRec-1, $filesystem_list->lDisplayRecs);
}
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $filesystem->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($filesystem->Export == "" && $filesystem->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(filesystem_list);" style="text-decoration: none;"><img id="filesystem_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="filesystem_list_SearchPanel">
<form name="ffilesystemlistsrch" id="ffilesystemlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="filesystem">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($filesystem->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $filesystem_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($filesystem->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($filesystem->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($filesystem->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$filesystem_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="ffilesystemlist" id="ffilesystemlist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" id="t" value="filesystem">
<div id="gmp_filesystem" class="ewGridMiddlePanel">
<?php if ($filesystem_list->lTotalRecs > 0 || $filesystem->CurrentAction == "add" || $filesystem->CurrentAction == "copy") { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $filesystem->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$filesystem_list->RenderListOptions();

// Render list options (header, left)
$filesystem_list->ListOptions->Render("header", "left");
?>
<?php if ($filesystem->id->Visible) { // id ?>
	<?php if ($filesystem->SortUrl($filesystem->id) == "") { ?>
		<td><?php echo $filesystem->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->mount->Visible) { // mount ?>
	<?php if ($filesystem->SortUrl($filesystem->mount) == "") { ?>
		<td><?php echo $filesystem->mount->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->mount) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->mount->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($filesystem->mount->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->mount->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->path->Visible) { // path ?>
	<?php if ($filesystem->SortUrl($filesystem->path) == "") { ?>
		<td><?php echo $filesystem->path->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->path) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->path->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($filesystem->path->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->path->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->parent->Visible) { // parent ?>
	<?php if ($filesystem->SortUrl($filesystem->parent) == "") { ?>
		<td><?php echo $filesystem->parent->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->parent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->parent->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->parent->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->parent->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
	<?php if ($filesystem->SortUrl($filesystem->deprecated) == "") { ?>
		<td><?php echo $filesystem->deprecated->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->deprecated) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->deprecated->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->deprecated->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->deprecated->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->gid->Visible) { // gid ?>
	<?php if ($filesystem->SortUrl($filesystem->gid) == "") { ?>
		<td><?php echo $filesystem->gid->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->gid->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
	<?php if ($filesystem->SortUrl($filesystem->snapshot) == "") { ?>
		<td><?php echo $filesystem->snapshot->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->snapshot) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->snapshot->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->snapshot->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->snapshot->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
	<?php if ($filesystem->SortUrl($filesystem->tapebackup) == "") { ?>
		<td><?php echo $filesystem->tapebackup->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->tapebackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->tapebackup->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->tapebackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->tapebackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
	<?php if ($filesystem->SortUrl($filesystem->diskbackup) == "") { ?>
		<td><?php echo $filesystem->diskbackup->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->diskbackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->diskbackup->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->diskbackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->diskbackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->type->Visible) { // type ?>
	<?php if ($filesystem->SortUrl($filesystem->type) == "") { ?>
		<td><?php echo $filesystem->type->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->type->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->contact->Visible) { // contact ?>
	<?php if ($filesystem->SortUrl($filesystem->contact) == "") { ?>
		<td><?php echo $filesystem->contact->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->contact) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->contact->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->contact->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->contact->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->contact2->Visible) { // contact2 ?>
	<?php if ($filesystem->SortUrl($filesystem->contact2) == "") { ?>
		<td><?php echo $filesystem->contact2->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->contact2) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->contact2->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->contact2->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->contact2->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
	<?php if ($filesystem->SortUrl($filesystem->rescomp) == "") { ?>
		<td><?php echo $filesystem->rescomp->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->rescomp) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->rescomp->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->rescomp->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->rescomp->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($filesystem->maxdepth->Visible) { // maxdepth ?>
	<?php if ($filesystem->SortUrl($filesystem->maxdepth) == "") { ?>
		<td><?php echo $filesystem->maxdepth->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $filesystem->SortUrl($filesystem->maxdepth) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $filesystem->maxdepth->FldCaption() ?></td><td style="width: 10px;"><?php if ($filesystem->maxdepth->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($filesystem->maxdepth->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$filesystem_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
	if ($filesystem->CurrentAction == "add" || $filesystem->CurrentAction == "copy") {
		$filesystem_list->lRowIndex = 1;
		if ($filesystem->CurrentAction == "copy" && !$filesystem_list->LoadRow())
				$filesystem->CurrentAction = "add";
		if ($filesystem->CurrentAction == "add")
			$filesystem_list->LoadDefaultValues();
		if ($filesystem->EventCancelled) // Insert failed
			$filesystem_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$filesystem->CssClass = "ewTableEditRow";
		$filesystem->CssStyle = "";
		$filesystem->RowAttrs = array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
		$filesystem->RowType = EW_ROWTYPE_ADD;

		// Render row
		$filesystem_list->RenderRow();

		// Render list options
		$filesystem_list->RenderListOptions();
?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
<?php

// Render list options (body, left)
$filesystem_list->ListOptions->Render("body", "left");
?>
	<?php if ($filesystem->id->Visible) { // id ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($filesystem->mount->Visible) { // mount ?>
		<td>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_mount" id="x<?php echo $filesystem_list->lRowIndex ?>_mount" title="<?php echo $filesystem->mount->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $filesystem->mount->EditValue ?>"<?php echo $filesystem->mount->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($filesystem->path->Visible) { // path ?>
		<td>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_path" id="x<?php echo $filesystem_list->lRowIndex ?>_path" title="<?php echo $filesystem->path->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $filesystem->path->EditValue ?>"<?php echo $filesystem->path->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($filesystem->parent->Visible) { // parent ?>
		<td>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_parent" id="x<?php echo $filesystem_list->lRowIndex ?>_parent" title="<?php echo $filesystem->parent->FldTitle() ?>" size="30" value="<?php echo $filesystem->parent->EditValue ?>"<?php echo $filesystem->parent->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
		<td>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_deprecated" id="x<?php echo $filesystem_list->lRowIndex ?>_deprecated" title="<?php echo $filesystem->deprecated->FldTitle() ?>" size="30" value="<?php echo $filesystem->deprecated->EditValue ?>"<?php echo $filesystem->deprecated->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($filesystem->gid->Visible) { // gid ?>
		<td>
<?php if ($filesystem->gid->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_gid" name="x<?php echo $filesystem_list->lRowIndex ?>_gid" value="<?php echo ew_HtmlEncode($filesystem->gid->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $filesystem_list->lRowIndex ?>_gid" name="x<?php echo $filesystem_list->lRowIndex ?>_gid" title="<?php echo $filesystem->gid->FldTitle() ?>"<?php echo $filesystem->gid->EditAttributes() ?>>
<?php
if (is_array($filesystem->gid->EditValue)) {
	$arwrk = $filesystem->gid->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($filesystem->gid->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $filesystem->gid->OldValue = "";
?>
</select>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
		<td>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_snapshot" id="x<?php echo $filesystem_list->lRowIndex ?>_snapshot" title="<?php echo $filesystem->snapshot->FldTitle() ?>" size="30" value="<?php echo $filesystem->snapshot->EditValue ?>"<?php echo $filesystem->snapshot->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
		<td>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_tapebackup" id="x<?php echo $filesystem_list->lRowIndex ?>_tapebackup" title="<?php echo $filesystem->tapebackup->FldTitle() ?>" size="30" value="<?php echo $filesystem->tapebackup->EditValue ?>"<?php echo $filesystem->tapebackup->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
		<td>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_diskbackup" id="x<?php echo $filesystem_list->lRowIndex ?>_diskbackup" title="<?php echo $filesystem->diskbackup->FldTitle() ?>" size="30" value="<?php echo $filesystem->diskbackup->EditValue ?>"<?php echo $filesystem->diskbackup->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($filesystem->type->Visible) { // type ?>
		<td>
<?php if ($filesystem->type->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_type" name="x<?php echo $filesystem_list->lRowIndex ?>_type" value="<?php echo ew_HtmlEncode($filesystem->type->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $filesystem_list->lRowIndex ?>_type" name="x<?php echo $filesystem_list->lRowIndex ?>_type" title="<?php echo $filesystem->type->FldTitle() ?>"<?php echo $filesystem->type->EditAttributes() ?>>
<?php
if (is_array($filesystem->type->EditValue)) {
	$arwrk = $filesystem->type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($filesystem->type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $filesystem->type->OldValue = "";
?>
</select>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->contact->Visible) { // contact ?>
		<td>
<?php if ($filesystem->contact->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_contact" name="x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo ew_HtmlEncode($filesystem->contact->CurrentValue) ?>">
<?php } else { ?>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_contact" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $filesystem->contact->EditValue ?>" title="<?php echo $filesystem->contact->FldTitle() ?>" size="30"<?php echo $filesystem->contact->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_contact" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_contact"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_contact" id="x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $filesystem->contact->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_contact" id="s_x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_contact = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_contact", "sc_x<?php echo $filesystem_list->lRowIndex ?>_contact", "s_x<?php echo $filesystem_list->lRowIndex ?>_contact", "em_x<?php echo $filesystem_list->lRowIndex ?>_contact", "x<?php echo $filesystem_list->lRowIndex ?>_contact", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact.ac.typeAhead = false;

//-->
</script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->contact2->Visible) { // contact2 ?>
		<td>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_contact2" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $filesystem->contact2->EditValue ?>" title="<?php echo $filesystem->contact2->FldTitle() ?>" size="30"<?php echo $filesystem->contact2->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_contact2" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_contact2"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $filesystem->contact2->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="s_x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2 = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "sc_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "s_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "em_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "x<?php echo $filesystem_list->lRowIndex ?>_contact2", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2.ac.typeAhead = false;

//-->
</script>
</td>
	<?php } ?>
	<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
		<td>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $filesystem->rescomp->EditValue ?>" title="<?php echo $filesystem->rescomp->FldTitle() ?>" size="30"<?php echo $filesystem->rescomp->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_rescomp"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $filesystem->rescomp->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "sc_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "em_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp.ac.typeAhead = false;

//-->
</script>
</td>
	<?php } ?>
	<?php if ($filesystem->maxdepth->Visible) { // maxdepth ?>
		<td>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_maxdepth" id="x<?php echo $filesystem_list->lRowIndex ?>_maxdepth" title="<?php echo $filesystem->maxdepth->FldTitle() ?>" size="30" value="<?php echo $filesystem->maxdepth->EditValue ?>"<?php echo $filesystem->maxdepth->EditAttributes() ?>>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$filesystem_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
<?php
if ($filesystem->ExportAll && $filesystem->Export <> "") {
	$filesystem_list->lStopRec = $filesystem_list->lTotalRecs;
} else {
	$filesystem_list->lStopRec = $filesystem_list->lStartRec + $filesystem_list->lDisplayRecs - 1; // Set the last record to display
}
$filesystem_list->lRecCount = $filesystem_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $filesystem_list->lStartRec > 1)
		$rs->Move($filesystem_list->lStartRec - 1);
}

// Initialize aggregate
$filesystem->RowType = EW_ROWTYPE_AGGREGATEINIT;
$filesystem_list->RenderRow();
$filesystem_list->lRowCnt = 0;
$filesystem_list->lEditRowCnt = 0;
if ($filesystem->CurrentAction == "edit")
	$filesystem_list->lRowIndex = 1;
if ($filesystem->CurrentAction == "gridadd")
	$filesystem_list->lRowIndex = 0;
if ($filesystem->CurrentAction == "gridedit")
	$filesystem_list->lRowIndex = 0;
while (($filesystem->CurrentAction == "gridadd" || !$rs->EOF) &&
	$filesystem_list->lRecCount < $filesystem_list->lStopRec) {
	$filesystem_list->lRecCount++;
	if (intval($filesystem_list->lRecCount) >= intval($filesystem_list->lStartRec)) {
		$filesystem_list->lRowCnt++;
		if ($filesystem->CurrentAction == "gridadd" || $filesystem->CurrentAction == "gridedit")
			$filesystem_list->lRowIndex++;

	// Init row class and style
	$filesystem->CssClass = "";
	$filesystem->CssStyle = "";
	$filesystem->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($filesystem->CurrentAction == "gridadd") {
		$filesystem_list->LoadDefaultValues(); // Load default values
	} else {
		$filesystem_list->LoadRowValues($rs); // Load row values
	}
	$filesystem->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($filesystem->CurrentAction == "gridadd") // Grid add
		$filesystem->RowType = EW_ROWTYPE_ADD; // Render add
	if ($filesystem->CurrentAction == "gridadd" && $filesystem->EventCancelled) // Insert failed
		$filesystem_list->RestoreCurrentRowFormValues($filesystem_list->lRowIndex); // Restore form values
	if ($filesystem->CurrentAction == "edit") {
		if ($filesystem_list->CheckInlineEditKey() && $filesystem_list->lEditRowCnt == 0) { // Inline edit
			$filesystem->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
	}
	if ($filesystem->CurrentAction == "gridedit") { // Grid edit
		$filesystem->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
	if ($filesystem->RowType == EW_ROWTYPE_EDIT && $filesystem->EventCancelled) { // Update failed
		if ($filesystem->CurrentAction == "edit")
			$filesystem_list->RestoreFormValues(); // Restore form values
		if ($filesystem->CurrentAction == "gridedit")
			$filesystem_list->RestoreCurrentRowFormValues($filesystem_list->lRowIndex); // Restore form values
	}
	if ($filesystem->RowType == EW_ROWTYPE_EDIT) // Edit row
		$filesystem_list->lEditRowCnt++;
	if ($filesystem->RowType == EW_ROWTYPE_ADD || $filesystem->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
		$filesystem->RowAttrs = array_merge($filesystem->RowAttrs, array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);'));
		$filesystem->CssClass = "ewTableEditRow";
	}

	// Render row
	$filesystem_list->RenderRow();

	// Render list options
	$filesystem_list->RenderListOptions();
?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
<?php

// Render list options (body, left)
$filesystem_list->ListOptions->Render("body", "left");
?>
	<?php if ($filesystem->id->Visible) { // id ?>
		<td<?php echo $filesystem->id->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_id" id="o<?php echo $filesystem_list->lRowIndex ?>_id" value="<?php echo ew_HtmlEncode($filesystem->id->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->EditValue ?></div><input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_id" id="x<?php echo $filesystem_list->lRowIndex ?>_id" value="<?php echo ew_HtmlEncode($filesystem->id->CurrentValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->mount->Visible) { // mount ?>
		<td<?php echo $filesystem->mount->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_mount" id="x<?php echo $filesystem_list->lRowIndex ?>_mount" title="<?php echo $filesystem->mount->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $filesystem->mount->EditValue ?>"<?php echo $filesystem->mount->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_mount" id="o<?php echo $filesystem_list->lRowIndex ?>_mount" value="<?php echo ew_HtmlEncode($filesystem->mount->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_mount" id="x<?php echo $filesystem_list->lRowIndex ?>_mount" title="<?php echo $filesystem->mount->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $filesystem->mount->EditValue ?>"<?php echo $filesystem->mount->EditAttributes() ?>>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->mount->ViewAttributes() ?>><?php echo $filesystem->mount->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->path->Visible) { // path ?>
		<td<?php echo $filesystem->path->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_path" id="x<?php echo $filesystem_list->lRowIndex ?>_path" title="<?php echo $filesystem->path->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $filesystem->path->EditValue ?>"<?php echo $filesystem->path->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_path" id="o<?php echo $filesystem_list->lRowIndex ?>_path" value="<?php echo ew_HtmlEncode($filesystem->path->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_path" id="x<?php echo $filesystem_list->lRowIndex ?>_path" title="<?php echo $filesystem->path->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $filesystem->path->EditValue ?>"<?php echo $filesystem->path->EditAttributes() ?>>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->path->ViewAttributes() ?>><?php echo $filesystem->path->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->parent->Visible) { // parent ?>
		<td<?php echo $filesystem->parent->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_parent" id="x<?php echo $filesystem_list->lRowIndex ?>_parent" title="<?php echo $filesystem->parent->FldTitle() ?>" size="30" value="<?php echo $filesystem->parent->EditValue ?>"<?php echo $filesystem->parent->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_parent" id="o<?php echo $filesystem_list->lRowIndex ?>_parent" value="<?php echo ew_HtmlEncode($filesystem->parent->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_parent" id="x<?php echo $filesystem_list->lRowIndex ?>_parent" title="<?php echo $filesystem->parent->FldTitle() ?>" size="30" value="<?php echo $filesystem->parent->EditValue ?>"<?php echo $filesystem->parent->EditAttributes() ?>>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->parent->ViewAttributes() ?>><?php echo $filesystem->parent->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
		<td<?php echo $filesystem->deprecated->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_deprecated" id="x<?php echo $filesystem_list->lRowIndex ?>_deprecated" title="<?php echo $filesystem->deprecated->FldTitle() ?>" size="30" value="<?php echo $filesystem->deprecated->EditValue ?>"<?php echo $filesystem->deprecated->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_deprecated" id="o<?php echo $filesystem_list->lRowIndex ?>_deprecated" value="<?php echo ew_HtmlEncode($filesystem->deprecated->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_deprecated" id="x<?php echo $filesystem_list->lRowIndex ?>_deprecated" title="<?php echo $filesystem->deprecated->FldTitle() ?>" size="30" value="<?php echo $filesystem->deprecated->EditValue ?>"<?php echo $filesystem->deprecated->EditAttributes() ?>>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->deprecated->ViewAttributes() ?>><?php echo $filesystem->deprecated->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->gid->Visible) { // gid ?>
		<td<?php echo $filesystem->gid->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($filesystem->gid->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_gid" name="x<?php echo $filesystem_list->lRowIndex ?>_gid" value="<?php echo ew_HtmlEncode($filesystem->gid->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $filesystem_list->lRowIndex ?>_gid" name="x<?php echo $filesystem_list->lRowIndex ?>_gid" title="<?php echo $filesystem->gid->FldTitle() ?>"<?php echo $filesystem->gid->EditAttributes() ?>>
<?php
if (is_array($filesystem->gid->EditValue)) {
	$arwrk = $filesystem->gid->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($filesystem->gid->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $filesystem->gid->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_gid" id="o<?php echo $filesystem_list->lRowIndex ?>_gid" value="<?php echo ew_HtmlEncode($filesystem->gid->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($filesystem->gid->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_gid" name="x<?php echo $filesystem_list->lRowIndex ?>_gid" value="<?php echo ew_HtmlEncode($filesystem->gid->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $filesystem_list->lRowIndex ?>_gid" name="x<?php echo $filesystem_list->lRowIndex ?>_gid" title="<?php echo $filesystem->gid->FldTitle() ?>"<?php echo $filesystem->gid->EditAttributes() ?>>
<?php
if (is_array($filesystem->gid->EditValue)) {
	$arwrk = $filesystem->gid->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($filesystem->gid->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $filesystem->gid->OldValue = "";
?>
</select>
<?php } ?>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
		<td<?php echo $filesystem->snapshot->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_snapshot" id="x<?php echo $filesystem_list->lRowIndex ?>_snapshot" title="<?php echo $filesystem->snapshot->FldTitle() ?>" size="30" value="<?php echo $filesystem->snapshot->EditValue ?>"<?php echo $filesystem->snapshot->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_snapshot" id="o<?php echo $filesystem_list->lRowIndex ?>_snapshot" value="<?php echo ew_HtmlEncode($filesystem->snapshot->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_snapshot" id="x<?php echo $filesystem_list->lRowIndex ?>_snapshot" title="<?php echo $filesystem->snapshot->FldTitle() ?>" size="30" value="<?php echo $filesystem->snapshot->EditValue ?>"<?php echo $filesystem->snapshot->EditAttributes() ?>>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->snapshot->ViewAttributes() ?>><?php echo $filesystem->snapshot->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
		<td<?php echo $filesystem->tapebackup->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_tapebackup" id="x<?php echo $filesystem_list->lRowIndex ?>_tapebackup" title="<?php echo $filesystem->tapebackup->FldTitle() ?>" size="30" value="<?php echo $filesystem->tapebackup->EditValue ?>"<?php echo $filesystem->tapebackup->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_tapebackup" id="o<?php echo $filesystem_list->lRowIndex ?>_tapebackup" value="<?php echo ew_HtmlEncode($filesystem->tapebackup->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_tapebackup" id="x<?php echo $filesystem_list->lRowIndex ?>_tapebackup" title="<?php echo $filesystem->tapebackup->FldTitle() ?>" size="30" value="<?php echo $filesystem->tapebackup->EditValue ?>"<?php echo $filesystem->tapebackup->EditAttributes() ?>>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->tapebackup->ViewAttributes() ?>><?php echo $filesystem->tapebackup->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
		<td<?php echo $filesystem->diskbackup->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_diskbackup" id="x<?php echo $filesystem_list->lRowIndex ?>_diskbackup" title="<?php echo $filesystem->diskbackup->FldTitle() ?>" size="30" value="<?php echo $filesystem->diskbackup->EditValue ?>"<?php echo $filesystem->diskbackup->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_diskbackup" id="o<?php echo $filesystem_list->lRowIndex ?>_diskbackup" value="<?php echo ew_HtmlEncode($filesystem->diskbackup->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_diskbackup" id="x<?php echo $filesystem_list->lRowIndex ?>_diskbackup" title="<?php echo $filesystem->diskbackup->FldTitle() ?>" size="30" value="<?php echo $filesystem->diskbackup->EditValue ?>"<?php echo $filesystem->diskbackup->EditAttributes() ?>>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->diskbackup->ViewAttributes() ?>><?php echo $filesystem->diskbackup->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->type->Visible) { // type ?>
		<td<?php echo $filesystem->type->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($filesystem->type->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_type" name="x<?php echo $filesystem_list->lRowIndex ?>_type" value="<?php echo ew_HtmlEncode($filesystem->type->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $filesystem_list->lRowIndex ?>_type" name="x<?php echo $filesystem_list->lRowIndex ?>_type" title="<?php echo $filesystem->type->FldTitle() ?>"<?php echo $filesystem->type->EditAttributes() ?>>
<?php
if (is_array($filesystem->type->EditValue)) {
	$arwrk = $filesystem->type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($filesystem->type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $filesystem->type->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_type" id="o<?php echo $filesystem_list->lRowIndex ?>_type" value="<?php echo ew_HtmlEncode($filesystem->type->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($filesystem->type->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_type" name="x<?php echo $filesystem_list->lRowIndex ?>_type" value="<?php echo ew_HtmlEncode($filesystem->type->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $filesystem_list->lRowIndex ?>_type" name="x<?php echo $filesystem_list->lRowIndex ?>_type" title="<?php echo $filesystem->type->FldTitle() ?>"<?php echo $filesystem->type->EditAttributes() ?>>
<?php
if (is_array($filesystem->type->EditValue)) {
	$arwrk = $filesystem->type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($filesystem->type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $filesystem->type->OldValue = "";
?>
</select>
<?php } ?>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->contact->Visible) { // contact ?>
		<td<?php echo $filesystem->contact->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($filesystem->contact->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_contact" name="x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo ew_HtmlEncode($filesystem->contact->CurrentValue) ?>">
<?php } else { ?>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_contact" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $filesystem->contact->EditValue ?>" title="<?php echo $filesystem->contact->FldTitle() ?>" size="30"<?php echo $filesystem->contact->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_contact" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_contact"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_contact" id="x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $filesystem->contact->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_contact" id="s_x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_contact = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_contact", "sc_x<?php echo $filesystem_list->lRowIndex ?>_contact", "s_x<?php echo $filesystem_list->lRowIndex ?>_contact", "em_x<?php echo $filesystem_list->lRowIndex ?>_contact", "x<?php echo $filesystem_list->lRowIndex ?>_contact", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact.ac.typeAhead = false;

//-->
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_contact" id="o<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo ew_HtmlEncode($filesystem->contact->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($filesystem->contact->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ListViewValue() ?></div>
<input type="hidden" id="x<?php echo $filesystem_list->lRowIndex ?>_contact" name="x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo ew_HtmlEncode($filesystem->contact->CurrentValue) ?>">
<?php } else { ?>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_contact" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $filesystem->contact->EditValue ?>" title="<?php echo $filesystem->contact->FldTitle() ?>" size="30"<?php echo $filesystem->contact->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_contact" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_contact"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_contact" id="x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $filesystem->contact->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_contact" id="s_x<?php echo $filesystem_list->lRowIndex ?>_contact" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_contact = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_contact", "sc_x<?php echo $filesystem_list->lRowIndex ?>_contact", "s_x<?php echo $filesystem_list->lRowIndex ?>_contact", "em_x<?php echo $filesystem_list->lRowIndex ?>_contact", "x<?php echo $filesystem_list->lRowIndex ?>_contact", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact.ac.typeAhead = false;

//-->
</script>
<?php } ?>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->contact2->Visible) { // contact2 ?>
		<td<?php echo $filesystem->contact2->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_contact2" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $filesystem->contact2->EditValue ?>" title="<?php echo $filesystem->contact2->FldTitle() ?>" size="30"<?php echo $filesystem->contact2->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_contact2" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_contact2"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $filesystem->contact2->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="s_x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2 = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "sc_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "s_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "em_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "x<?php echo $filesystem_list->lRowIndex ?>_contact2", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2.ac.typeAhead = false;

//-->
</script>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_contact2" id="o<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo ew_HtmlEncode($filesystem->contact2->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_contact2" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $filesystem->contact2->EditValue ?>" title="<?php echo $filesystem->contact2->FldTitle() ?>" size="30"<?php echo $filesystem->contact2->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_contact2" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_contact2"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $filesystem->contact2->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_contact2" id="s_x<?php echo $filesystem_list->lRowIndex ?>_contact2" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2 = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "sc_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "s_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "em_x<?php echo $filesystem_list->lRowIndex ?>_contact2", "x<?php echo $filesystem_list->lRowIndex ?>_contact2", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_contact2.ac.typeAhead = false;

//-->
</script>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->contact2->ViewAttributes() ?>><?php echo $filesystem->contact2->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
		<td<?php echo $filesystem->rescomp->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $filesystem->rescomp->EditValue ?>" title="<?php echo $filesystem->rescomp->FldTitle() ?>" size="30"<?php echo $filesystem->rescomp->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_rescomp"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $filesystem->rescomp->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "sc_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "em_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp.ac.typeAhead = false;

//-->
</script>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="o<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo ew_HtmlEncode($filesystem->rescomp->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="as_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" style="z-index: <?php echo (9000 - $filesystem_list->lRowIndex * 10) ?>">
	<input type="text" name="sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $filesystem->rescomp->EditValue ?>" title="<?php echo $filesystem->rescomp->FldTitle() ?>" size="30"<?php echo $filesystem->rescomp->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x<?php echo $filesystem_list->lRowIndex ?>_rescomp"></div>
</div>
<input type="hidden" name="x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $filesystem->rescomp->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" id="s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp = new ew_AutoSuggest("sv_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "sc_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "s_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "em_x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "x<?php echo $filesystem_list->lRowIndex ?>_rescomp", "", false);
oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x<?php echo $filesystem_list->lRowIndex ?>_rescomp.ac.typeAhead = false;

//-->
</script>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->rescomp->ViewAttributes() ?>><?php echo $filesystem->rescomp->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($filesystem->maxdepth->Visible) { // maxdepth ?>
		<td<?php echo $filesystem->maxdepth->CellAttributes() ?>>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_maxdepth" id="x<?php echo $filesystem_list->lRowIndex ?>_maxdepth" title="<?php echo $filesystem->maxdepth->FldTitle() ?>" size="30" value="<?php echo $filesystem->maxdepth->EditValue ?>"<?php echo $filesystem->maxdepth->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $filesystem_list->lRowIndex ?>_maxdepth" id="o<?php echo $filesystem_list->lRowIndex ?>_maxdepth" value="<?php echo ew_HtmlEncode($filesystem->maxdepth->OldValue) ?>">
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $filesystem_list->lRowIndex ?>_maxdepth" id="x<?php echo $filesystem_list->lRowIndex ?>_maxdepth" title="<?php echo $filesystem->maxdepth->FldTitle() ?>" size="30" value="<?php echo $filesystem->maxdepth->EditValue ?>"<?php echo $filesystem->maxdepth->EditAttributes() ?>>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $filesystem->maxdepth->ViewAttributes() ?>><?php echo $filesystem->maxdepth->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$filesystem_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($filesystem->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($filesystem->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	if ($filesystem->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($filesystem->CurrentAction == "add" || $filesystem->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $filesystem_list->lRowIndex ?>">
<?php } ?>
<?php if ($filesystem->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $filesystem_list->lRowIndex ?>">
<?php } ?>
<?php if ($filesystem->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $filesystem_list->lRowIndex ?>">
<?php } ?>
<?php if ($filesystem->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $filesystem_list->lRowIndex ?>">
<?php echo $filesystem_list->sMultiSelectKey ?>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($filesystem->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($filesystem->CurrentAction <> "gridadd" && $filesystem->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($filesystem_list->Pager)) $filesystem_list->Pager = new cPrevNextPager($filesystem_list->lStartRec, $filesystem_list->lDisplayRecs, $filesystem_list->lTotalRecs) ?>
<?php if ($filesystem_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($filesystem_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $filesystem_list->PageUrl() ?>start=<?php echo $filesystem_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($filesystem_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $filesystem_list->PageUrl() ?>start=<?php echo $filesystem_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $filesystem_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($filesystem_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $filesystem_list->PageUrl() ?>start=<?php echo $filesystem_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($filesystem_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $filesystem_list->PageUrl() ?>start=<?php echo $filesystem_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $filesystem_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $filesystem_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $filesystem_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $filesystem_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($filesystem_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($filesystem_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($filesystem->CurrentAction <> "gridadd" && $filesystem->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $filesystem_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $filesystem_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $filesystem_list->GridAddUrl ?>"><?php echo $Language->Phrase("GridAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($filesystem_list->lTotalRecs > 0) { ?>
<a href="<?php echo $filesystem_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($filesystem->CurrentAction == "gridadd") { ?>
<a href="" onclick="f=document.ffilesystemlist;if(filesystem_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridInsertLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $filesystem_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($filesystem->CurrentAction == "gridedit") { ?>
<a href="" onclick="f=document.ffilesystemlist;if(filesystem_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridSaveLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $filesystem_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($filesystem->Export == "" && $filesystem->CurrentAction == "") { ?>
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
// Page class
//
class cfilesystem_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'filesystem';

	// Page object name
	var $PageObjName = 'filesystem_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $filesystem;
		if ($filesystem->UseTokenInUrl) $PageUrl .= "t=" . $filesystem->TableVar . "&"; // Add page token
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
		global $objForm, $filesystem;
		if ($filesystem->UseTokenInUrl) {
			if ($objForm)
				return ($filesystem->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($filesystem->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cfilesystem_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (filesystem)
		$GLOBALS["filesystem"] = new cfilesystem();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["filesystem"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "filesystemdelete.php";
		$this->MultiUpdateUrl = "filesystemupdate.php";

		// Table object (grp)
		$GLOBALS['grp'] = new cgrp();

		// Table object (server_type)
		$GLOBALS['server_type'] = new cserver_type();

		// Table object (users)
		$GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'filesystem', TRUE);

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
		global $filesystem;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Create form object
		$objForm = new cFormObj();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$filesystem->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$filesystem->Export = $_POST["exporttype"];
		} else {
			$filesystem->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $filesystem->Export; // Get export parameter, used in header
		$gsExportFile = $filesystem->TableVar; // Get export file, used in header

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
		global $objForm, $Language, $gsSearchError, $Security, $filesystem;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterDetail();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$filesystem->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($filesystem->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($filesystem->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($filesystem->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($filesystem->CurrentAction == "add" || $filesystem->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($filesystem->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$filesystem->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($filesystem->CurrentAction == "gridupdate" || $filesystem->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit")
						$this->GridUpdate();

					// Inline Update
					if (($filesystem->CurrentAction == "update" || $filesystem->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($filesystem->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($filesystem->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd")
						$this->GridInsert();
				}
			}

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$filesystem->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

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
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchAdvanced . ")" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchBasic. ")" : $sSrchBasic;

		// Call Recordset_Searching event
		$filesystem->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$filesystem->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$filesystem->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $filesystem->getSearchWhere();
		}

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->sDbMasterFilter = $filesystem->getMasterFilter(); // Restore master filter
		$this->sDbDetailFilter = $filesystem->getDetailFilter(); // Restore detail filter
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Load master record
		if ($filesystem->getMasterFilter() <> "" && $filesystem->getCurrentMasterTable() == "grp") {
			global $grp;
			$rsmaster = $grp->LoadRs($this->sDbMasterFilter);
			$this->bMasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->bMasterRecordExists) {
				$filesystem->setMasterFilter(""); // Clear master filter
				$filesystem->setDetailFilter(""); // Clear detail filter
				$this->setMessage($Language->Phrase("NoRecord")); // Set no record found
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
				$this->setMessage($Language->Phrase("NoRecord")); // Set no record found
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
				$this->setMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate($filesystem->getReturnUrl()); // Return to caller
			} else {
				$server_type->LoadListRowValues($rsmaster);
				$server_type->RowType = EW_ROWTYPE_MASTER; // Master row
				$server_type->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$filesystem->setSessionWhere($sFilter);
		$filesystem->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $filesystem;
		$filesystem->setKey("id", ""); // Clear inline edit key
		$filesystem->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $filesystem;
		$bInlineEdit = TRUE;
		if (@$_GET["id"] <> "") {
			$filesystem->id->setQueryStringValue($_GET["id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$filesystem->setKey("id", $filesystem->id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError, $filesystem;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;	
			if ($this->CheckInlineEditKey()) { // Check key
				$filesystem->SendEmail = TRUE; // Send email on update success
				$bInlineUpdate = $this->EditRow(); // Update record
			} else {
				$bInlineUpdate = FALSE;
			}
		}
		if ($bInlineUpdate) { // Update success
			$this->setMessage($Language->Phrase("UpdateSuccess")); // Set success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getMessage() == "")
				$this->setMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$filesystem->EventCancelled = TRUE; // Cancel event
			$filesystem->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {
		global $filesystem;

		//CheckInlineEditKey = True
		if (strval($filesystem->getKey("id")) <> strval($filesystem->id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $filesystem;
		if ($filesystem->CurrentAction == "copy") {
			if (@$_GET["id"] <> "") {
				$filesystem->id->setQueryStringValue($_GET["id"]);
			} else {
				$filesystem->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError, $filesystem;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setMessage($gsFormError); // Set validation error message
			$filesystem->EventCancelled = TRUE; // Set event cancelled
			$filesystem->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$filesystem->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow()) { // Add record
			$this->setMessage($Language->Phrase("AddSuccess")); // Set add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$filesystem->EventCancelled = TRUE; // Set event cancelled
			$filesystem->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError, $filesystem;
		$rowindex = 1;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$filesystem->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $filesystem->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));

		// Update all rows based on key
		while ($sThisKey <> "") {

			// Load all values and keys
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$bGridUpdate = FALSE; // Form error, reset action
				$this->setMessage($gsFormError);
			} else {
				if ($this->SetupKeyValues($sThisKey)) { // Set up key values
					$filesystem->SendEmail = FALSE; // Do not send email on update success
					$bGridUpdate = $this->EditRow(); // Update this row
				} else {
					$bGridUpdate = FALSE; // update failed
				}
			}
			if ($bGridUpdate) {
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			} else {
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->setMessage($Language->Phrase("UpdateSuccess")); // Set update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getMessage() == "")
				$this->setMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$filesystem->EventCancelled = TRUE; // Set event cancelled
			$filesystem->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $filesystem;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $filesystem->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		global $filesystem;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$filesystem->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($filesystem->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $filesystem;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = 0;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$filesystem->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow(); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $filesystem->id->CurrentValue;

					// Add filter for this record
					$sFilter = $filesystem->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$filesystem->CurrentFilter = $sWrkFilter;
			$sSql = $filesystem->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->setMessage($Language->Phrase("InsertSuccess")); // Set insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($addcnt == 0) { // No record inserted
				$this->setMessage($Language->Phrase("NoAddRecord"));
			} elseif ($this->getMessage() == "") {
				$this->setMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$filesystem->EventCancelled = TRUE; // Set event cancelled
			$filesystem->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
	}

	// Check if empty row
	function EmptyRow() {
		global $filesystem;
		if ($filesystem->mount->CurrentValue <> $filesystem->mount->OldValue)
			return FALSE;
		if ($filesystem->path->CurrentValue <> $filesystem->path->OldValue)
			return FALSE;
		if ($filesystem->parent->CurrentValue <> $filesystem->parent->OldValue)
			return FALSE;
		if ($filesystem->deprecated->CurrentValue <> $filesystem->deprecated->OldValue)
			return FALSE;
		if ($filesystem->gid->CurrentValue <> $filesystem->gid->OldValue)
			return FALSE;
		if ($filesystem->snapshot->CurrentValue <> $filesystem->snapshot->OldValue)
			return FALSE;
		if ($filesystem->tapebackup->CurrentValue <> $filesystem->tapebackup->OldValue)
			return FALSE;
		if ($filesystem->diskbackup->CurrentValue <> $filesystem->diskbackup->OldValue)
			return FALSE;
		if ($filesystem->type->CurrentValue <> $filesystem->type->OldValue)
			return FALSE;
		if ($filesystem->contact->CurrentValue <> $filesystem->contact->OldValue)
			return FALSE;
		if ($filesystem->contact2->CurrentValue <> $filesystem->contact2->OldValue)
			return FALSE;
		if ($filesystem->rescomp->CurrentValue <> $filesystem->rescomp->OldValue)
			return FALSE;
		if ($filesystem->maxdepth->CurrentValue <> $filesystem->maxdepth->OldValue)
			return FALSE;
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm, $filesystem;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($filesystem->CurrentAction == "gridadd")
			$this->LoadFormValues(); // Load form values
		if ($filesystem->CurrentAction == "gridedit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if (count($arrKeyFlds) >= 1) {
				if (strval($arrKeyFlds[0]) == strval($filesystem->id->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $filesystem;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $filesystem->mount, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $filesystem->path, $Keyword);
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
		global $Security, $filesystem;
		$sSearchStr = "";
		$sSearchKeyword = $filesystem->BasicSearchKeyword;
		$sSearchType = $filesystem->BasicSearchType;
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
			$filesystem->setSessionBasicSearchKeyword($sSearchKeyword);
			$filesystem->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $filesystem;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$filesystem->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $filesystem;
		$filesystem->setSessionBasicSearchKeyword("");
		$filesystem->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $filesystem;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$filesystem->BasicSearchKeyword = $filesystem->getSessionBasicSearchKeyword();
			$filesystem->BasicSearchType = $filesystem->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $filesystem;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$filesystem->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$filesystem->CurrentOrderType = @$_GET["ordertype"];
			$filesystem->UpdateSort($filesystem->id); // id
			$filesystem->UpdateSort($filesystem->mount); // mount
			$filesystem->UpdateSort($filesystem->path); // path
			$filesystem->UpdateSort($filesystem->parent); // parent
			$filesystem->UpdateSort($filesystem->deprecated); // deprecated
			$filesystem->UpdateSort($filesystem->gid); // gid
			$filesystem->UpdateSort($filesystem->snapshot); // snapshot
			$filesystem->UpdateSort($filesystem->tapebackup); // tapebackup
			$filesystem->UpdateSort($filesystem->diskbackup); // diskbackup
			$filesystem->UpdateSort($filesystem->type); // type
			$filesystem->UpdateSort($filesystem->contact); // contact
			$filesystem->UpdateSort($filesystem->contact2); // contact2
			$filesystem->UpdateSort($filesystem->rescomp); // rescomp
			$filesystem->UpdateSort($filesystem->maxdepth); // maxdepth
			$filesystem->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $filesystem;
		$sOrderBy = $filesystem->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($filesystem->SqlOrderBy() <> "") {
				$sOrderBy = $filesystem->SqlOrderBy();
				$filesystem->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $filesystem;

		// Get reset command
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

			// Reset sorting order
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
				$filesystem->maxdepth->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$filesystem->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $filesystem;

		// "view"
		$this->ListOptions->Add("view");
		$item =& $this->ListOptions->Items["view"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "edit"
		$this->ListOptions->Add("edit");
		$item =& $this->ListOptions->Items["edit"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "copy"
		$this->ListOptions->Add("copy");
		$item =& $this->ListOptions->Items["copy"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($filesystem->Export <> "" ||
			$filesystem->CurrentAction == "gridadd" ||
			$filesystem->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $filesystem;
		$this->ListOptions->LoadDefault();

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if (($filesystem->CurrentAction == "add" || $filesystem->CurrentAction == "copy") &&
			$filesystem->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a href=\"\" onclick=\"f=document.ffilesystemlist;if(filesystem_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($filesystem->CurrentAction == "edit" && $filesystem->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a href=\"\" onclick=\"f=document.ffilesystemlist;if(filesystem_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			return;
		}

		// "view"
		$oListOpt =& $this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible)
			$oListOpt->Body = "<a href=\"" . $this->ViewUrl . "\">" . $Language->Phrase("ViewLink") . "</a>";

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewInlineLink\" href=\"" . $this->InlineEditUrl . "#" . $this->PageObjName . "_row_" . $this->lRowCnt . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a href=\"" . $this->InlineCopyUrl . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
		}
		if ($filesystem->CurrentAction == "gridedit")
			$this->sMultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->lRowIndex . "_key\" id=\"k" . $this->lRowIndex . "_key\" value=\"" . $filesystem->id->CurrentValue . "\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $filesystem;
	}

	// Set up starting record parameters
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

	// Load default values
	function LoadDefaultValues() {
		global $filesystem;
		$filesystem->deprecated->CurrentValue = 0;
		$filesystem->deprecated->OldValue = $filesystem->deprecated->CurrentValue;
		$filesystem->snapshot->CurrentValue = 0;
		$filesystem->snapshot->OldValue = $filesystem->snapshot->CurrentValue;
		$filesystem->tapebackup->CurrentValue = 0;
		$filesystem->tapebackup->OldValue = $filesystem->tapebackup->CurrentValue;
		$filesystem->diskbackup->CurrentValue = 0;
		$filesystem->diskbackup->OldValue = $filesystem->diskbackup->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $filesystem;
		$filesystem->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$filesystem->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $filesystem;
		$filesystem->id->setFormValue($objForm->GetValue("x_id"));
		$filesystem->id->setOldValue($objForm->GetValue("o_id"));
		$filesystem->mount->setFormValue($objForm->GetValue("x_mount"));
		$filesystem->mount->setOldValue($objForm->GetValue("o_mount"));
		$filesystem->path->setFormValue($objForm->GetValue("x_path"));
		$filesystem->path->setOldValue($objForm->GetValue("o_path"));
		$filesystem->parent->setFormValue($objForm->GetValue("x_parent"));
		$filesystem->parent->setOldValue($objForm->GetValue("o_parent"));
		$filesystem->deprecated->setFormValue($objForm->GetValue("x_deprecated"));
		$filesystem->deprecated->setOldValue($objForm->GetValue("o_deprecated"));
		$filesystem->gid->setFormValue($objForm->GetValue("x_gid"));
		$filesystem->gid->setOldValue($objForm->GetValue("o_gid"));
		$filesystem->snapshot->setFormValue($objForm->GetValue("x_snapshot"));
		$filesystem->snapshot->setOldValue($objForm->GetValue("o_snapshot"));
		$filesystem->tapebackup->setFormValue($objForm->GetValue("x_tapebackup"));
		$filesystem->tapebackup->setOldValue($objForm->GetValue("o_tapebackup"));
		$filesystem->diskbackup->setFormValue($objForm->GetValue("x_diskbackup"));
		$filesystem->diskbackup->setOldValue($objForm->GetValue("o_diskbackup"));
		$filesystem->type->setFormValue($objForm->GetValue("x_type"));
		$filesystem->type->setOldValue($objForm->GetValue("o_type"));
		$filesystem->contact->setFormValue($objForm->GetValue("x_contact"));
		$filesystem->contact->setOldValue($objForm->GetValue("o_contact"));
		$filesystem->contact2->setFormValue($objForm->GetValue("x_contact2"));
		$filesystem->contact2->setOldValue($objForm->GetValue("o_contact2"));
		$filesystem->rescomp->setFormValue($objForm->GetValue("x_rescomp"));
		$filesystem->rescomp->setOldValue($objForm->GetValue("o_rescomp"));
		$filesystem->maxdepth->setFormValue($objForm->GetValue("x_maxdepth"));
		$filesystem->maxdepth->setOldValue($objForm->GetValue("o_maxdepth"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $filesystem;
		$filesystem->id->CurrentValue = $filesystem->id->FormValue;
		$filesystem->mount->CurrentValue = $filesystem->mount->FormValue;
		$filesystem->path->CurrentValue = $filesystem->path->FormValue;
		$filesystem->parent->CurrentValue = $filesystem->parent->FormValue;
		$filesystem->deprecated->CurrentValue = $filesystem->deprecated->FormValue;
		$filesystem->gid->CurrentValue = $filesystem->gid->FormValue;
		$filesystem->snapshot->CurrentValue = $filesystem->snapshot->FormValue;
		$filesystem->tapebackup->CurrentValue = $filesystem->tapebackup->FormValue;
		$filesystem->diskbackup->CurrentValue = $filesystem->diskbackup->FormValue;
		$filesystem->type->CurrentValue = $filesystem->type->FormValue;
		$filesystem->contact->CurrentValue = $filesystem->contact->FormValue;
		$filesystem->contact2->CurrentValue = $filesystem->contact2->FormValue;
		$filesystem->rescomp->CurrentValue = $filesystem->rescomp->FormValue;
		$filesystem->maxdepth->CurrentValue = $filesystem->maxdepth->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $filesystem;

		// Call Recordset Selecting event
		$filesystem->Recordset_Selecting($filesystem->CurrentFilter);

		// Load List page SQL
		$sSql = $filesystem->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

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

		// Load SQL based on filter
		$filesystem->CurrentFilter = $sFilter;
		$sSql = $filesystem->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$filesystem->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $filesystem;
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
		$filesystem->maxdepth->setDbValue($rs->fields('maxdepth'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $filesystem;

		// Initialize URLs
		$this->ViewUrl = $filesystem->ViewUrl();
		$this->EditUrl = $filesystem->EditUrl();
		$this->InlineEditUrl = $filesystem->InlineEditUrl();
		$this->CopyUrl = $filesystem->CopyUrl();
		$this->InlineCopyUrl = $filesystem->InlineCopyUrl();
		$this->DeleteUrl = $filesystem->DeleteUrl();

		// Call Row_Rendering event
		$filesystem->Row_Rendering();

		// Common render codes for all row types
		// id

		$filesystem->id->CellCssStyle = ""; $filesystem->id->CellCssClass = "";
		$filesystem->id->CellAttrs = array(); $filesystem->id->ViewAttrs = array(); $filesystem->id->EditAttrs = array();

		// mount
		$filesystem->mount->CellCssStyle = ""; $filesystem->mount->CellCssClass = "";
		$filesystem->mount->CellAttrs = array(); $filesystem->mount->ViewAttrs = array(); $filesystem->mount->EditAttrs = array();

		// path
		$filesystem->path->CellCssStyle = ""; $filesystem->path->CellCssClass = "";
		$filesystem->path->CellAttrs = array(); $filesystem->path->ViewAttrs = array(); $filesystem->path->EditAttrs = array();

		// parent
		$filesystem->parent->CellCssStyle = ""; $filesystem->parent->CellCssClass = "";
		$filesystem->parent->CellAttrs = array(); $filesystem->parent->ViewAttrs = array(); $filesystem->parent->EditAttrs = array();

		// deprecated
		$filesystem->deprecated->CellCssStyle = ""; $filesystem->deprecated->CellCssClass = "";
		$filesystem->deprecated->CellAttrs = array(); $filesystem->deprecated->ViewAttrs = array(); $filesystem->deprecated->EditAttrs = array();

		// gid
		$filesystem->gid->CellCssStyle = ""; $filesystem->gid->CellCssClass = "";
		$filesystem->gid->CellAttrs = array(); $filesystem->gid->ViewAttrs = array(); $filesystem->gid->EditAttrs = array();

		// snapshot
		$filesystem->snapshot->CellCssStyle = ""; $filesystem->snapshot->CellCssClass = "";
		$filesystem->snapshot->CellAttrs = array(); $filesystem->snapshot->ViewAttrs = array(); $filesystem->snapshot->EditAttrs = array();

		// tapebackup
		$filesystem->tapebackup->CellCssStyle = ""; $filesystem->tapebackup->CellCssClass = "";
		$filesystem->tapebackup->CellAttrs = array(); $filesystem->tapebackup->ViewAttrs = array(); $filesystem->tapebackup->EditAttrs = array();

		// diskbackup
		$filesystem->diskbackup->CellCssStyle = ""; $filesystem->diskbackup->CellCssClass = "";
		$filesystem->diskbackup->CellAttrs = array(); $filesystem->diskbackup->ViewAttrs = array(); $filesystem->diskbackup->EditAttrs = array();

		// type
		$filesystem->type->CellCssStyle = ""; $filesystem->type->CellCssClass = "";
		$filesystem->type->CellAttrs = array(); $filesystem->type->ViewAttrs = array(); $filesystem->type->EditAttrs = array();

		// contact
		$filesystem->contact->CellCssStyle = ""; $filesystem->contact->CellCssClass = "";
		$filesystem->contact->CellAttrs = array(); $filesystem->contact->ViewAttrs = array(); $filesystem->contact->EditAttrs = array();

		// contact2
		$filesystem->contact2->CellCssStyle = ""; $filesystem->contact2->CellCssClass = "";
		$filesystem->contact2->CellAttrs = array(); $filesystem->contact2->ViewAttrs = array(); $filesystem->contact2->EditAttrs = array();

		// rescomp
		$filesystem->rescomp->CellCssStyle = ""; $filesystem->rescomp->CellCssClass = "";
		$filesystem->rescomp->CellAttrs = array(); $filesystem->rescomp->ViewAttrs = array(); $filesystem->rescomp->EditAttrs = array();

		// maxdepth
		$filesystem->maxdepth->CellCssStyle = ""; $filesystem->maxdepth->CellCssClass = "";
		$filesystem->maxdepth->CellAttrs = array(); $filesystem->maxdepth->ViewAttrs = array(); $filesystem->maxdepth->EditAttrs = array();
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
				$sFilterWrk = "`id` = " . ew_AdjustSql($filesystem->gid->CurrentValue) . "";
			$sSqlWrk = "SELECT `id`, `name` FROM `grp`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
				$sFilterWrk = "`id` = " . ew_AdjustSql($filesystem->type->CurrentValue) . "";
			$sSqlWrk = "SELECT `id`, `name` FROM `server_type`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			if (strval($filesystem->contact2->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact2->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->contact2->ViewValue = $rswrk->fields('uid');
					$filesystem->contact2->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->contact2->ViewValue = $filesystem->contact2->CurrentValue;
				}
			} else {
				$filesystem->contact2->ViewValue = NULL;
			}
			$filesystem->contact2->CssStyle = "";
			$filesystem->contact2->CssClass = "";
			$filesystem->contact2->ViewCustomAttributes = "";

			// rescomp
			$filesystem->rescomp->ViewValue = $filesystem->rescomp->CurrentValue;
			if (strval($filesystem->rescomp->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->rescomp->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->rescomp->ViewValue = $rswrk->fields('uid');
					$filesystem->rescomp->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->rescomp->ViewValue = $filesystem->rescomp->CurrentValue;
				}
			} else {
				$filesystem->rescomp->ViewValue = NULL;
			}
			$filesystem->rescomp->CssStyle = "";
			$filesystem->rescomp->CssClass = "";
			$filesystem->rescomp->ViewCustomAttributes = "";

			// maxdepth
			$filesystem->maxdepth->ViewValue = $filesystem->maxdepth->CurrentValue;
			$filesystem->maxdepth->CssStyle = "";
			$filesystem->maxdepth->CssClass = "";
			$filesystem->maxdepth->ViewCustomAttributes = "";

			// id
			$filesystem->id->HrefValue = "";
			$filesystem->id->TooltipValue = "";

			// mount
			$filesystem->mount->HrefValue = "";
			$filesystem->mount->TooltipValue = "";

			// path
			$filesystem->path->HrefValue = "";
			$filesystem->path->TooltipValue = "";

			// parent
			$filesystem->parent->HrefValue = "";
			$filesystem->parent->TooltipValue = "";

			// deprecated
			$filesystem->deprecated->HrefValue = "";
			$filesystem->deprecated->TooltipValue = "";

			// gid
			$filesystem->gid->HrefValue = "";
			$filesystem->gid->TooltipValue = "";

			// snapshot
			$filesystem->snapshot->HrefValue = "";
			$filesystem->snapshot->TooltipValue = "";

			// tapebackup
			$filesystem->tapebackup->HrefValue = "";
			$filesystem->tapebackup->TooltipValue = "";

			// diskbackup
			$filesystem->diskbackup->HrefValue = "";
			$filesystem->diskbackup->TooltipValue = "";

			// type
			$filesystem->type->HrefValue = "";
			$filesystem->type->TooltipValue = "";

			// contact
			$filesystem->contact->HrefValue = "";
			$filesystem->contact->TooltipValue = "";

			// contact2
			$filesystem->contact2->HrefValue = "";
			$filesystem->contact2->TooltipValue = "";

			// rescomp
			$filesystem->rescomp->HrefValue = "";
			$filesystem->rescomp->TooltipValue = "";

			// maxdepth
			$filesystem->maxdepth->HrefValue = "";
			$filesystem->maxdepth->TooltipValue = "";
		} elseif ($filesystem->RowType == EW_ROWTYPE_ADD) { // Add row

			// id
			// mount

			$filesystem->mount->EditCustomAttributes = "";
			$filesystem->mount->EditValue = ew_HtmlEncode($filesystem->mount->CurrentValue);

			// path
			$filesystem->path->EditCustomAttributes = "";
			$filesystem->path->EditValue = ew_HtmlEncode($filesystem->path->CurrentValue);

			// parent
			$filesystem->parent->EditCustomAttributes = "";
			$filesystem->parent->EditValue = ew_HtmlEncode($filesystem->parent->CurrentValue);

			// deprecated
			$filesystem->deprecated->EditCustomAttributes = "";
			$filesystem->deprecated->EditValue = ew_HtmlEncode($filesystem->deprecated->CurrentValue);

			// gid
			$filesystem->gid->EditCustomAttributes = "";
			if ($filesystem->gid->getSessionValue() <> "") {
				$filesystem->gid->CurrentValue = $filesystem->gid->getSessionValue();
				$filesystem->gid->OldValue = $filesystem->gid->CurrentValue;
			if (strval($filesystem->gid->CurrentValue) <> "") {
				$sFilterWrk = "`id` = " . ew_AdjustSql($filesystem->gid->CurrentValue) . "";
			$sSqlWrk = "SELECT `id`, `name` FROM `grp`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			} else {
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `id`, `id`, `name`, '' AS SelectFilterFld FROM `grp`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$filesystem->gid->EditValue = $arwrk;
			}

			// snapshot
			$filesystem->snapshot->EditCustomAttributes = "";
			$filesystem->snapshot->EditValue = ew_HtmlEncode($filesystem->snapshot->CurrentValue);

			// tapebackup
			$filesystem->tapebackup->EditCustomAttributes = "";
			$filesystem->tapebackup->EditValue = ew_HtmlEncode($filesystem->tapebackup->CurrentValue);

			// diskbackup
			$filesystem->diskbackup->EditCustomAttributes = "";
			$filesystem->diskbackup->EditValue = ew_HtmlEncode($filesystem->diskbackup->CurrentValue);

			// type
			$filesystem->type->EditCustomAttributes = "";
			if ($filesystem->type->getSessionValue() <> "") {
				$filesystem->type->CurrentValue = $filesystem->type->getSessionValue();
				$filesystem->type->OldValue = $filesystem->type->CurrentValue;
			if (strval($filesystem->type->CurrentValue) <> "") {
				$sFilterWrk = "`id` = " . ew_AdjustSql($filesystem->type->CurrentValue) . "";
			$sSqlWrk = "SELECT `id`, `name` FROM `server_type`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			} else {
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `id`, `id`, `name`, '' AS SelectFilterFld FROM `server_type`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$filesystem->type->EditValue = $arwrk;
			}

			// contact
			$filesystem->contact->EditCustomAttributes = "";
			if ($filesystem->contact->getSessionValue() <> "") {
				$filesystem->contact->CurrentValue = $filesystem->contact->getSessionValue();
				$filesystem->contact->OldValue = $filesystem->contact->CurrentValue;
			$filesystem->contact->ViewValue = $filesystem->contact->CurrentValue;
			if (strval($filesystem->contact->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			} else {
			$filesystem->contact->EditValue = ew_HtmlEncode($filesystem->contact->CurrentValue);
			if (strval($filesystem->contact->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->contact->EditValue = $rswrk->fields('uid');
					$filesystem->contact->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->contact->EditValue = $filesystem->contact->CurrentValue;
				}
			} else {
				$filesystem->contact->EditValue = NULL;
			}
			}

			// contact2
			$filesystem->contact2->EditCustomAttributes = "";
			$filesystem->contact2->EditValue = ew_HtmlEncode($filesystem->contact2->CurrentValue);
			if (strval($filesystem->contact2->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact2->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->contact2->EditValue = $rswrk->fields('uid');
					$filesystem->contact2->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->contact2->EditValue = $filesystem->contact2->CurrentValue;
				}
			} else {
				$filesystem->contact2->EditValue = NULL;
			}

			// rescomp
			$filesystem->rescomp->EditCustomAttributes = "";
			$filesystem->rescomp->EditValue = ew_HtmlEncode($filesystem->rescomp->CurrentValue);
			if (strval($filesystem->rescomp->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->rescomp->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->rescomp->EditValue = $rswrk->fields('uid');
					$filesystem->rescomp->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->rescomp->EditValue = $filesystem->rescomp->CurrentValue;
				}
			} else {
				$filesystem->rescomp->EditValue = NULL;
			}

			// maxdepth
			$filesystem->maxdepth->EditCustomAttributes = "";
			$filesystem->maxdepth->EditValue = ew_HtmlEncode($filesystem->maxdepth->CurrentValue);
		} elseif ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$filesystem->id->EditCustomAttributes = "";
			$filesystem->id->EditValue = $filesystem->id->CurrentValue;
			$filesystem->id->CssStyle = "";
			$filesystem->id->CssClass = "";
			$filesystem->id->ViewCustomAttributes = "";

			// mount
			$filesystem->mount->EditCustomAttributes = "";
			$filesystem->mount->EditValue = ew_HtmlEncode($filesystem->mount->CurrentValue);

			// path
			$filesystem->path->EditCustomAttributes = "";
			$filesystem->path->EditValue = ew_HtmlEncode($filesystem->path->CurrentValue);

			// parent
			$filesystem->parent->EditCustomAttributes = "";
			$filesystem->parent->EditValue = ew_HtmlEncode($filesystem->parent->CurrentValue);

			// deprecated
			$filesystem->deprecated->EditCustomAttributes = "";
			$filesystem->deprecated->EditValue = ew_HtmlEncode($filesystem->deprecated->CurrentValue);

			// gid
			$filesystem->gid->EditCustomAttributes = "";
			if ($filesystem->gid->getSessionValue() <> "") {
				$filesystem->gid->CurrentValue = $filesystem->gid->getSessionValue();
				$filesystem->gid->OldValue = $filesystem->gid->CurrentValue;
			if (strval($filesystem->gid->CurrentValue) <> "") {
				$sFilterWrk = "`id` = " . ew_AdjustSql($filesystem->gid->CurrentValue) . "";
			$sSqlWrk = "SELECT `id`, `name` FROM `grp`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			} else {
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `id`, `id`, `name`, '' AS SelectFilterFld FROM `grp`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$filesystem->gid->EditValue = $arwrk;
			}

			// snapshot
			$filesystem->snapshot->EditCustomAttributes = "";
			$filesystem->snapshot->EditValue = ew_HtmlEncode($filesystem->snapshot->CurrentValue);

			// tapebackup
			$filesystem->tapebackup->EditCustomAttributes = "";
			$filesystem->tapebackup->EditValue = ew_HtmlEncode($filesystem->tapebackup->CurrentValue);

			// diskbackup
			$filesystem->diskbackup->EditCustomAttributes = "";
			$filesystem->diskbackup->EditValue = ew_HtmlEncode($filesystem->diskbackup->CurrentValue);

			// type
			$filesystem->type->EditCustomAttributes = "";
			if ($filesystem->type->getSessionValue() <> "") {
				$filesystem->type->CurrentValue = $filesystem->type->getSessionValue();
				$filesystem->type->OldValue = $filesystem->type->CurrentValue;
			if (strval($filesystem->type->CurrentValue) <> "") {
				$sFilterWrk = "`id` = " . ew_AdjustSql($filesystem->type->CurrentValue) . "";
			$sSqlWrk = "SELECT `id`, `name` FROM `server_type`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			} else {
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `id`, `id`, `name`, '' AS SelectFilterFld FROM `server_type`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$filesystem->type->EditValue = $arwrk;
			}

			// contact
			$filesystem->contact->EditCustomAttributes = "";
			if ($filesystem->contact->getSessionValue() <> "") {
				$filesystem->contact->CurrentValue = $filesystem->contact->getSessionValue();
				$filesystem->contact->OldValue = $filesystem->contact->CurrentValue;
			$filesystem->contact->ViewValue = $filesystem->contact->CurrentValue;
			if (strval($filesystem->contact->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			} else {
			$filesystem->contact->EditValue = ew_HtmlEncode($filesystem->contact->CurrentValue);
			if (strval($filesystem->contact->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->contact->EditValue = $rswrk->fields('uid');
					$filesystem->contact->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->contact->EditValue = $filesystem->contact->CurrentValue;
				}
			} else {
				$filesystem->contact->EditValue = NULL;
			}
			}

			// contact2
			$filesystem->contact2->EditCustomAttributes = "";
			$filesystem->contact2->EditValue = ew_HtmlEncode($filesystem->contact2->CurrentValue);
			if (strval($filesystem->contact2->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact2->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->contact2->EditValue = $rswrk->fields('uid');
					$filesystem->contact2->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->contact2->EditValue = $filesystem->contact2->CurrentValue;
				}
			} else {
				$filesystem->contact2->EditValue = NULL;
			}

			// rescomp
			$filesystem->rescomp->EditCustomAttributes = "";
			$filesystem->rescomp->EditValue = ew_HtmlEncode($filesystem->rescomp->CurrentValue);
			if (strval($filesystem->rescomp->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->rescomp->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->rescomp->EditValue = $rswrk->fields('uid');
					$filesystem->rescomp->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->rescomp->EditValue = $filesystem->rescomp->CurrentValue;
				}
			} else {
				$filesystem->rescomp->EditValue = NULL;
			}

			// maxdepth
			$filesystem->maxdepth->EditCustomAttributes = "";
			$filesystem->maxdepth->EditValue = ew_HtmlEncode($filesystem->maxdepth->CurrentValue);

			// Edit refer script
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

			// maxdepth
			$filesystem->maxdepth->HrefValue = "";
		}

		// Call Row Rendered event
		if ($filesystem->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$filesystem->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $filesystem;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($filesystem->mount->FormValue) && $filesystem->mount->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $filesystem->mount->FldCaption();
		}
		if (!is_null($filesystem->path->FormValue) && $filesystem->path->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $filesystem->path->FldCaption();
		}
		if (!ew_CheckInteger($filesystem->parent->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $filesystem->parent->FldErrMsg();
		}
		if (!ew_CheckInteger($filesystem->deprecated->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $filesystem->deprecated->FldErrMsg();
		}
		if (!ew_CheckInteger($filesystem->snapshot->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $filesystem->snapshot->FldErrMsg();
		}
		if (!ew_CheckInteger($filesystem->tapebackup->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $filesystem->tapebackup->FldErrMsg();
		}
		if (!ew_CheckInteger($filesystem->diskbackup->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $filesystem->diskbackup->FldErrMsg();
		}
		if (!ew_CheckInteger($filesystem->maxdepth->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $filesystem->maxdepth->FldErrMsg();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $filesystem;
		$sFilter = $filesystem->KeyFilter();
		$filesystem->CurrentFilter = $sFilter;
		$sSql = $filesystem->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// mount
			$filesystem->mount->SetDbValueDef($rsnew, $filesystem->mount->CurrentValue, "", FALSE);

			// path
			$filesystem->path->SetDbValueDef($rsnew, $filesystem->path->CurrentValue, "", FALSE);

			// parent
			$filesystem->parent->SetDbValueDef($rsnew, $filesystem->parent->CurrentValue, NULL, FALSE);

			// deprecated
			$filesystem->deprecated->SetDbValueDef($rsnew, $filesystem->deprecated->CurrentValue, NULL, FALSE);

			// gid
			$filesystem->gid->SetDbValueDef($rsnew, $filesystem->gid->CurrentValue, NULL, FALSE);

			// snapshot
			$filesystem->snapshot->SetDbValueDef($rsnew, $filesystem->snapshot->CurrentValue, NULL, FALSE);

			// tapebackup
			$filesystem->tapebackup->SetDbValueDef($rsnew, $filesystem->tapebackup->CurrentValue, NULL, FALSE);

			// diskbackup
			$filesystem->diskbackup->SetDbValueDef($rsnew, $filesystem->diskbackup->CurrentValue, NULL, FALSE);

			// type
			$filesystem->type->SetDbValueDef($rsnew, $filesystem->type->CurrentValue, NULL, FALSE);

			// contact
			$filesystem->contact->SetDbValueDef($rsnew, $filesystem->contact->CurrentValue, NULL, FALSE);

			// contact2
			$filesystem->contact2->SetDbValueDef($rsnew, $filesystem->contact2->CurrentValue, NULL, FALSE);

			// rescomp
			$filesystem->rescomp->SetDbValueDef($rsnew, $filesystem->rescomp->CurrentValue, NULL, FALSE);

			// maxdepth
			$filesystem->maxdepth->SetDbValueDef($rsnew, $filesystem->maxdepth->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $filesystem->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($filesystem->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($filesystem->CancelMessage <> "") {
					$this->setMessage($filesystem->CancelMessage);
					$filesystem->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$filesystem->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow() {
		global $conn, $Language, $Security, $filesystem;
		$rsnew = array();

		// mount
		$filesystem->mount->SetDbValueDef($rsnew, $filesystem->mount->CurrentValue, "", FALSE);

		// path
		$filesystem->path->SetDbValueDef($rsnew, $filesystem->path->CurrentValue, "", FALSE);

		// parent
		$filesystem->parent->SetDbValueDef($rsnew, $filesystem->parent->CurrentValue, NULL, FALSE);

		// deprecated
		$filesystem->deprecated->SetDbValueDef($rsnew, $filesystem->deprecated->CurrentValue, NULL, TRUE);

		// gid
		$filesystem->gid->SetDbValueDef($rsnew, $filesystem->gid->CurrentValue, NULL, FALSE);

		// snapshot
		$filesystem->snapshot->SetDbValueDef($rsnew, $filesystem->snapshot->CurrentValue, NULL, TRUE);

		// tapebackup
		$filesystem->tapebackup->SetDbValueDef($rsnew, $filesystem->tapebackup->CurrentValue, NULL, TRUE);

		// diskbackup
		$filesystem->diskbackup->SetDbValueDef($rsnew, $filesystem->diskbackup->CurrentValue, NULL, TRUE);

		// type
		$filesystem->type->SetDbValueDef($rsnew, $filesystem->type->CurrentValue, NULL, FALSE);

		// contact
		$filesystem->contact->SetDbValueDef($rsnew, $filesystem->contact->CurrentValue, NULL, FALSE);

		// contact2
		$filesystem->contact2->SetDbValueDef($rsnew, $filesystem->contact2->CurrentValue, NULL, FALSE);

		// rescomp
		$filesystem->rescomp->SetDbValueDef($rsnew, $filesystem->rescomp->CurrentValue, NULL, FALSE);

		// maxdepth
		$filesystem->maxdepth->SetDbValueDef($rsnew, $filesystem->maxdepth->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$bInsertRow = $filesystem->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($filesystem->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($filesystem->CancelMessage <> "") {
				$this->setMessage($filesystem->CancelMessage);
				$filesystem->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$filesystem->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $filesystem->id->DbValue;

			// Call Row Inserted event
			$filesystem->Row_Inserted($rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
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

			// Clear previous master key from Session
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
