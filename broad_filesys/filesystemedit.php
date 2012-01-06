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
$filesystem_edit = new cfilesystem_edit();
$Page =& $filesystem_edit;

// Page init
$filesystem_edit->Page_Init();

// Page main
$filesystem_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var filesystem_edit = new ew_Page("filesystem_edit");

// page properties
filesystem_edit.PageID = "edit"; // page ID
filesystem_edit.FormID = "ffilesystemedit"; // form ID
var EW_PAGE_ID = filesystem_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
filesystem_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
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
	}
	return true;
}

// extend page with Form_CustomValidate function
filesystem_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
filesystem_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
filesystem_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $filesystem->TableCaption() ?><br><br>
<a href="<?php echo $filesystem->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$filesystem_edit->ShowMessage();
?>
<form name="ffilesystemedit" id="ffilesystemedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return filesystem_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="filesystem">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($filesystem->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($filesystem->id->Visible) { // id ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->id->FldCaption() ?></td>
		<td<?php echo $filesystem->id->CellAttributes() ?>><span id="el_id">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($filesystem->id->CurrentValue) ?>">
<?php } else { ?>
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->ViewValue ?></div>
<input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($filesystem->id->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->mount->Visible) { // mount ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->mount->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $filesystem->mount->CellAttributes() ?>><span id="el_mount">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<input type="text" name="x_mount" id="x_mount" title="<?php echo $filesystem->mount->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $filesystem->mount->EditValue ?>"<?php echo $filesystem->mount->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $filesystem->mount->ViewAttributes() ?>><?php echo $filesystem->mount->ViewValue ?></div>
<input type="hidden" name="x_mount" id="x_mount" value="<?php echo ew_HtmlEncode($filesystem->mount->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->mount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->path->Visible) { // path ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->path->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $filesystem->path->CellAttributes() ?>><span id="el_path">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<input type="text" name="x_path" id="x_path" title="<?php echo $filesystem->path->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $filesystem->path->EditValue ?>"<?php echo $filesystem->path->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $filesystem->path->ViewAttributes() ?>><?php echo $filesystem->path->ViewValue ?></div>
<input type="hidden" name="x_path" id="x_path" value="<?php echo ew_HtmlEncode($filesystem->path->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->path->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->parent->Visible) { // parent ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->parent->FldCaption() ?></td>
		<td<?php echo $filesystem->parent->CellAttributes() ?>><span id="el_parent">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<input type="text" name="x_parent" id="x_parent" title="<?php echo $filesystem->parent->FldTitle() ?>" size="30" value="<?php echo $filesystem->parent->EditValue ?>"<?php echo $filesystem->parent->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $filesystem->parent->ViewAttributes() ?>><?php echo $filesystem->parent->ViewValue ?></div>
<input type="hidden" name="x_parent" id="x_parent" value="<?php echo ew_HtmlEncode($filesystem->parent->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->parent->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->deprecated->FldCaption() ?></td>
		<td<?php echo $filesystem->deprecated->CellAttributes() ?>><span id="el_deprecated">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<input type="text" name="x_deprecated" id="x_deprecated" title="<?php echo $filesystem->deprecated->FldTitle() ?>" size="30" value="<?php echo $filesystem->deprecated->EditValue ?>"<?php echo $filesystem->deprecated->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $filesystem->deprecated->ViewAttributes() ?>><?php echo $filesystem->deprecated->ViewValue ?></div>
<input type="hidden" name="x_deprecated" id="x_deprecated" value="<?php echo ew_HtmlEncode($filesystem->deprecated->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->deprecated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->gid->Visible) { // gid ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->gid->FldCaption() ?></td>
		<td<?php echo $filesystem->gid->CellAttributes() ?>><span id="el_gid">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<?php if ($filesystem->gid->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ViewValue ?></div>
<input type="hidden" id="x_gid" name="x_gid" value="<?php echo ew_HtmlEncode($filesystem->gid->CurrentValue) ?>">
<?php } else { ?>
<select id="x_gid" name="x_gid" title="<?php echo $filesystem->gid->FldTitle() ?>"<?php echo $filesystem->gid->EditAttributes() ?>>
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
?>
</select>
<?php } ?>
<?php } else { ?>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ViewValue ?></div>
<input type="hidden" name="x_gid" id="x_gid" value="<?php echo ew_HtmlEncode($filesystem->gid->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->gid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->snapshot->FldCaption() ?></td>
		<td<?php echo $filesystem->snapshot->CellAttributes() ?>><span id="el_snapshot">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<input type="text" name="x_snapshot" id="x_snapshot" title="<?php echo $filesystem->snapshot->FldTitle() ?>" size="30" value="<?php echo $filesystem->snapshot->EditValue ?>"<?php echo $filesystem->snapshot->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $filesystem->snapshot->ViewAttributes() ?>><?php echo $filesystem->snapshot->ViewValue ?></div>
<input type="hidden" name="x_snapshot" id="x_snapshot" value="<?php echo ew_HtmlEncode($filesystem->snapshot->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->snapshot->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->tapebackup->FldCaption() ?></td>
		<td<?php echo $filesystem->tapebackup->CellAttributes() ?>><span id="el_tapebackup">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<input type="text" name="x_tapebackup" id="x_tapebackup" title="<?php echo $filesystem->tapebackup->FldTitle() ?>" size="30" value="<?php echo $filesystem->tapebackup->EditValue ?>"<?php echo $filesystem->tapebackup->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $filesystem->tapebackup->ViewAttributes() ?>><?php echo $filesystem->tapebackup->ViewValue ?></div>
<input type="hidden" name="x_tapebackup" id="x_tapebackup" value="<?php echo ew_HtmlEncode($filesystem->tapebackup->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->tapebackup->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->diskbackup->FldCaption() ?></td>
		<td<?php echo $filesystem->diskbackup->CellAttributes() ?>><span id="el_diskbackup">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<input type="text" name="x_diskbackup" id="x_diskbackup" title="<?php echo $filesystem->diskbackup->FldTitle() ?>" size="30" value="<?php echo $filesystem->diskbackup->EditValue ?>"<?php echo $filesystem->diskbackup->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $filesystem->diskbackup->ViewAttributes() ?>><?php echo $filesystem->diskbackup->ViewValue ?></div>
<input type="hidden" name="x_diskbackup" id="x_diskbackup" value="<?php echo ew_HtmlEncode($filesystem->diskbackup->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->diskbackup->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->type->Visible) { // type ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->type->FldCaption() ?></td>
		<td<?php echo $filesystem->type->CellAttributes() ?>><span id="el_type">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<?php if ($filesystem->type->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ViewValue ?></div>
<input type="hidden" id="x_type" name="x_type" value="<?php echo ew_HtmlEncode($filesystem->type->CurrentValue) ?>">
<?php } else { ?>
<select id="x_type" name="x_type" title="<?php echo $filesystem->type->FldTitle() ?>"<?php echo $filesystem->type->EditAttributes() ?>>
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
?>
</select>
<?php } ?>
<?php } else { ?>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ViewValue ?></div>
<input type="hidden" name="x_type" id="x_type" value="<?php echo ew_HtmlEncode($filesystem->type->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->contact->Visible) { // contact ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->contact->FldCaption() ?></td>
		<td<?php echo $filesystem->contact->CellAttributes() ?>><span id="el_contact">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<?php if ($filesystem->contact->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ViewValue ?></div>
<input type="hidden" id="x_contact" name="x_contact" value="<?php echo ew_HtmlEncode($filesystem->contact->CurrentValue) ?>">
<?php } else { ?>
<div id="as_x_contact" style="z-index: 8890">
	<input type="text" name="sv_x_contact" id="sv_x_contact" value="<?php echo $filesystem->contact->EditValue ?>" title="<?php echo $filesystem->contact->FldTitle() ?>" size="30"<?php echo $filesystem->contact->EditAttributes() ?>>&nbsp;<span id="em_x_contact" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x_contact"></div>
</div>
<input type="hidden" name="x_contact" id="x_contact" value="<?php echo $filesystem->contact->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_contact" id="s_x_contact" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x_contact = new ew_AutoSuggest("sv_x_contact", "sc_x_contact", "s_x_contact", "em_x_contact", "x_contact", "", false);
oas_x_contact.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x_contact.ac.typeAhead = false;

//-->
</script>
&nbsp;<a name="aol_x_contact" id="aol_x_contact" href="javascript:void(0);" onclick="ew_AddOptDialogShow({pg:filesystem_edit,lnk:'aol_x_contact',el:'x_contact',hdr:this.innerHTML, url:'usersaddopt.php',lf:'x_uid',df:'x_uid',df2:'x_gecos',pf:'',ff:''});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $filesystem->contact->FldCaption() ?></a>
<?php } ?>
<?php } else { ?>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ViewValue ?></div>
<input type="hidden" name="x_contact" id="x_contact" value="<?php echo ew_HtmlEncode($filesystem->contact->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->contact->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->contact2->Visible) { // contact2 ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->contact2->FldCaption() ?></td>
		<td<?php echo $filesystem->contact2->CellAttributes() ?>><span id="el_contact2">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<div id="as_x_contact2" style="z-index: 8880">
	<input type="text" name="sv_x_contact2" id="sv_x_contact2" value="<?php echo $filesystem->contact2->EditValue ?>" title="<?php echo $filesystem->contact2->FldTitle() ?>" size="30"<?php echo $filesystem->contact2->EditAttributes() ?>>&nbsp;<span id="em_x_contact2" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x_contact2"></div>
</div>
<input type="hidden" name="x_contact2" id="x_contact2" value="<?php echo $filesystem->contact2->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_contact2" id="s_x_contact2" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x_contact2 = new ew_AutoSuggest("sv_x_contact2", "sc_x_contact2", "s_x_contact2", "em_x_contact2", "x_contact2", "", false);
oas_x_contact2.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x_contact2.ac.typeAhead = false;

//-->
</script>
&nbsp;<a name="aol_x_contact2" id="aol_x_contact2" href="javascript:void(0);" onclick="ew_AddOptDialogShow({pg:filesystem_edit,lnk:'aol_x_contact2',el:'x_contact2',hdr:this.innerHTML, url:'usersaddopt.php',lf:'x_uid',df:'x_uid',df2:'x_gecos',pf:'',ff:''});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $filesystem->contact2->FldCaption() ?></a>
<?php } else { ?>
<div<?php echo $filesystem->contact2->ViewAttributes() ?>><?php echo $filesystem->contact2->ViewValue ?></div>
<input type="hidden" name="x_contact2" id="x_contact2" value="<?php echo ew_HtmlEncode($filesystem->contact2->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->contact2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->rescomp->FldCaption() ?></td>
		<td<?php echo $filesystem->rescomp->CellAttributes() ?>><span id="el_rescomp">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<div id="as_x_rescomp" style="z-index: 8870">
	<input type="text" name="sv_x_rescomp" id="sv_x_rescomp" value="<?php echo $filesystem->rescomp->EditValue ?>" title="<?php echo $filesystem->rescomp->FldTitle() ?>" size="30"<?php echo $filesystem->rescomp->EditAttributes() ?>>&nbsp;<span id="em_x_rescomp" class="ewMessage" style="display: none"><?php echo $Language->Phrase("UnmatchedValue") ?></span>
	<div id="sc_x_rescomp"></div>
</div>
<input type="hidden" name="x_rescomp" id="x_rescomp" value="<?php echo $filesystem->rescomp->CurrentValue ?>">
<?php
$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
$sWhereWrk = "`uid` = {query_value}";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `uid` Asc";
	$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_rescomp" id="s_x_rescomp" value="<?php echo $sSqlWrk ?>">
<script type="text/javascript">
<!--
var oas_x_rescomp = new ew_AutoSuggest("sv_x_rescomp", "sc_x_rescomp", "s_x_rescomp", "em_x_rescomp", "x_rescomp", "", false);
oas_x_rescomp.formatResult = function(ar) {	
	var df1 = ar[0];
	var df2 = ar[1];
	if (df2 != "")
		df1 += EW_FIELD_SEP + df2;
	return df1;
};
oas_x_rescomp.ac.typeAhead = false;

//-->
</script>
&nbsp;<a name="aol_x_rescomp" id="aol_x_rescomp" href="javascript:void(0);" onclick="ew_AddOptDialogShow({pg:filesystem_edit,lnk:'aol_x_rescomp',el:'x_rescomp',hdr:this.innerHTML, url:'usersaddopt.php',lf:'x_uid',df:'x_uid',df2:'x_gecos',pf:'',ff:''});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $filesystem->rescomp->FldCaption() ?></a>
<?php } else { ?>
<div<?php echo $filesystem->rescomp->ViewAttributes() ?>><?php echo $filesystem->rescomp->ViewValue ?></div>
<input type="hidden" name="x_rescomp" id="x_rescomp" value="<?php echo ew_HtmlEncode($filesystem->rescomp->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->rescomp->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->maxdepth->Visible) { // maxdepth ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->maxdepth->FldCaption() ?></td>
		<td<?php echo $filesystem->maxdepth->CellAttributes() ?>><span id="el_maxdepth">
<?php if ($filesystem->CurrentAction <> "F") { ?>
<input type="text" name="x_maxdepth" id="x_maxdepth" title="<?php echo $filesystem->maxdepth->FldTitle() ?>" size="30" value="<?php echo $filesystem->maxdepth->EditValue ?>"<?php echo $filesystem->maxdepth->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $filesystem->maxdepth->ViewAttributes() ?>><?php echo $filesystem->maxdepth->ViewValue ?></div>
<input type="hidden" name="x_maxdepth" id="x_maxdepth" value="<?php echo ew_HtmlEncode($filesystem->maxdepth->FormValue) ?>">
<?php } ?>
</span><?php echo $filesystem->maxdepth->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($filesystem->CurrentAction <> "F") { // Confirm page ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>" onclick="this.form.a_edit.value='F';">
<?php } else { ?>
<input type="submit" name="btnCancel" id="btnCancel" value="<?php echo ew_BtnCaption($Language->Phrase("CancelBtn")) ?>" onclick="this.form.a_edit.value='X';">
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("ConfirmBtn")) ?>">
<?php } ?>
</form>
<?php if ($filesystem->CurrentAction <> "F") { ?>
<?php } ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$filesystem_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cfilesystem_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'filesystem';

	// Page object name
	var $PageObjName = 'filesystem_edit';

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
	function cfilesystem_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (filesystem)
		$GLOBALS["filesystem"] = new cfilesystem();

		// Table object (grp)
		$GLOBALS['grp'] = new cgrp();

		// Table object (server_type)
		$GLOBALS['server_type'] = new cserver_type();

		// Table object (users)
		$GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'filesystem', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();
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
	var $sDbMasterFilter;
	var $sDbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $filesystem;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$filesystem->id->setQueryStringValue($_GET["id"]);

		// Set up master detail parameters
		$this->SetUpMasterDetail();
		if (@$_POST["a_edit"] <> "") {
			$filesystem->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$filesystem->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$filesystem->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$filesystem->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($filesystem->id->CurrentValue == "")
			$this->Page_Terminate("filesystemlist.php"); // Invalid key, return to list
		switch ($filesystem->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("filesystemlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$filesystem->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $filesystem->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$filesystem->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		if ($filesystem->CurrentAction == "F") { // Confirm page
			$filesystem->RowType = EW_ROWTYPE_VIEW; // Render as View
		} else {
			$filesystem->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		}
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $filesystem;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $filesystem;
		$filesystem->id->setFormValue($objForm->GetValue("x_id"));
		$filesystem->mount->setFormValue($objForm->GetValue("x_mount"));
		$filesystem->path->setFormValue($objForm->GetValue("x_path"));
		$filesystem->parent->setFormValue($objForm->GetValue("x_parent"));
		$filesystem->deprecated->setFormValue($objForm->GetValue("x_deprecated"));
		$filesystem->gid->setFormValue($objForm->GetValue("x_gid"));
		$filesystem->snapshot->setFormValue($objForm->GetValue("x_snapshot"));
		$filesystem->tapebackup->setFormValue($objForm->GetValue("x_tapebackup"));
		$filesystem->diskbackup->setFormValue($objForm->GetValue("x_diskbackup"));
		$filesystem->type->setFormValue($objForm->GetValue("x_type"));
		$filesystem->contact->setFormValue($objForm->GetValue("x_contact"));
		$filesystem->contact2->setFormValue($objForm->GetValue("x_contact2"));
		$filesystem->rescomp->setFormValue($objForm->GetValue("x_rescomp"));
		$filesystem->maxdepth->setFormValue($objForm->GetValue("x_maxdepth"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $filesystem;
		$this->LoadRow();
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
}
?>
