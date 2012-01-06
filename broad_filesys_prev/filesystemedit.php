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
$filesystem_edit = new cfilesystem_edit();
$Page =& $filesystem_edit;

// Page init processing
$filesystem_edit->Page_Init();

// Page main processing
$filesystem_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var filesystem_edit = new ew_Page("filesystem_edit");

// page properties
filesystem_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = filesystem_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
filesystem_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_snapshot"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Snapshot");
		elm = fobj.elements["x" + infix + "_tapebackup"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Tapebackup");
		elm = fobj.elements["x" + infix + "_diskbackup"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Diskbackup");
		elm = fobj.elements["x" + infix + "_contact"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Contact");
		elm = fobj.elements["x" + infix + "_contact2"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Contact 2");
		elm = fobj.elements["x" + infix + "_rescomp"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Rescomp");

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
<p><span class="phpmaker">Edit TABLE: Filesystem<br><br>
<a href="<?php echo $filesystem->getReturnUrl() ?>">Go Back</a></span></p>
<?php $filesystem_edit->ShowMessage() ?>
<form name="ffilesystemedit" id="ffilesystemedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return filesystem_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="filesystem">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($filesystem->id->Visible) { // id ?>
	<tr<?php echo $filesystem->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $filesystem->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($filesystem->id->CurrentValue) ?>">
</span><?php echo $filesystem->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->mount->Visible) { // mount ?>
	<tr<?php echo $filesystem->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $filesystem->mount->CellAttributes() ?>><span id="el_mount">
<div<?php echo $filesystem->mount->ViewAttributes() ?>><?php echo $filesystem->mount->EditValue ?></div><input type="hidden" name="x_mount" id="x_mount" value="<?php echo ew_HtmlEncode($filesystem->mount->CurrentValue) ?>">
</span><?php echo $filesystem->mount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->path->Visible) { // path ?>
	<tr<?php echo $filesystem->path->RowAttributes ?>>
		<td class="ewTableHeader">Path<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $filesystem->path->CellAttributes() ?>><span id="el_path">
<div<?php echo $filesystem->path->ViewAttributes() ?>><?php echo $filesystem->path->EditValue ?></div><input type="hidden" name="x_path" id="x_path" value="<?php echo ew_HtmlEncode($filesystem->path->CurrentValue) ?>">
</span><?php echo $filesystem->path->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->parent->Visible) { // parent ?>
	<tr<?php echo $filesystem->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $filesystem->parent->CellAttributes() ?>><span id="el_parent">
<div<?php echo $filesystem->parent->ViewAttributes() ?>><?php echo $filesystem->parent->EditValue ?></div><input type="hidden" name="x_parent" id="x_parent" value="<?php echo ew_HtmlEncode($filesystem->parent->CurrentValue) ?>">
</span><?php echo $filesystem->parent->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $filesystem->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $filesystem->deprecated->CellAttributes() ?>><span id="el_deprecated">
<div<?php echo $filesystem->deprecated->ViewAttributes() ?>><?php echo $filesystem->deprecated->EditValue ?></div><input type="hidden" name="x_deprecated" id="x_deprecated" value="<?php echo ew_HtmlEncode($filesystem->deprecated->CurrentValue) ?>">
</span><?php echo $filesystem->deprecated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->gid->Visible) { // gid ?>
	<tr<?php echo $filesystem->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $filesystem->gid->CellAttributes() ?>><span id="el_gid">
<?php if ($filesystem->gid->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ViewValue ?></div>
<input type="hidden" id="x_gid" name="x_gid" value="<?php echo ew_HtmlEncode($filesystem->gid->CurrentValue) ?>">
<?php } else { ?>
<select id="x_gid" name="x_gid"<?php echo $filesystem->gid->EditAttributes() ?>>
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
</span><?php echo $filesystem->gid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
	<tr<?php echo $filesystem->snapshot->RowAttributes ?>>
		<td class="ewTableHeader">Snapshot</td>
		<td<?php echo $filesystem->snapshot->CellAttributes() ?>><span id="el_snapshot">
<input type="text" name="x_snapshot" id="x_snapshot" size="30" value="<?php echo $filesystem->snapshot->EditValue ?>"<?php echo $filesystem->snapshot->EditAttributes() ?>>
</span><?php echo $filesystem->snapshot->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
	<tr<?php echo $filesystem->tapebackup->RowAttributes ?>>
		<td class="ewTableHeader">Tapebackup</td>
		<td<?php echo $filesystem->tapebackup->CellAttributes() ?>><span id="el_tapebackup">
<input type="text" name="x_tapebackup" id="x_tapebackup" size="30" value="<?php echo $filesystem->tapebackup->EditValue ?>"<?php echo $filesystem->tapebackup->EditAttributes() ?>>
</span><?php echo $filesystem->tapebackup->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
	<tr<?php echo $filesystem->diskbackup->RowAttributes ?>>
		<td class="ewTableHeader">Diskbackup</td>
		<td<?php echo $filesystem->diskbackup->CellAttributes() ?>><span id="el_diskbackup">
<input type="text" name="x_diskbackup" id="x_diskbackup" size="30" value="<?php echo $filesystem->diskbackup->EditValue ?>"<?php echo $filesystem->diskbackup->EditAttributes() ?>>
</span><?php echo $filesystem->diskbackup->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->type->Visible) { // type ?>
	<tr<?php echo $filesystem->type->RowAttributes ?>>
		<td class="ewTableHeader">Type</td>
		<td<?php echo $filesystem->type->CellAttributes() ?>><span id="el_type">
<?php if ($filesystem->type->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ViewValue ?></div>
<input type="hidden" id="x_type" name="x_type" value="<?php echo ew_HtmlEncode($filesystem->type->CurrentValue) ?>">
<?php } else { ?>
<select id="x_type" name="x_type"<?php echo $filesystem->type->EditAttributes() ?>>
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
</span><?php echo $filesystem->type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->contact->Visible) { // contact ?>
	<tr<?php echo $filesystem->contact->RowAttributes ?>>
		<td class="ewTableHeader">Contact</td>
		<td<?php echo $filesystem->contact->CellAttributes() ?>><span id="el_contact">
<?php if ($filesystem->contact->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ViewValue ?></div>
<input type="hidden" id="x_contact" name="x_contact" value="<?php echo ew_HtmlEncode($filesystem->contact->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x_contact" id="x_contact" size="30" value="<?php echo $filesystem->contact->EditValue ?>"<?php echo $filesystem->contact->EditAttributes() ?>>
<?php } ?>
</span><?php echo $filesystem->contact->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->contact2->Visible) { // contact2 ?>
	<tr<?php echo $filesystem->contact2->RowAttributes ?>>
		<td class="ewTableHeader">Contact 2</td>
		<td<?php echo $filesystem->contact2->CellAttributes() ?>><span id="el_contact2">
<input type="text" name="x_contact2" id="x_contact2" size="30" value="<?php echo $filesystem->contact2->EditValue ?>"<?php echo $filesystem->contact2->EditAttributes() ?>>
</span><?php echo $filesystem->contact2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
	<tr<?php echo $filesystem->rescomp->RowAttributes ?>>
		<td class="ewTableHeader">Rescomp</td>
		<td<?php echo $filesystem->rescomp->CellAttributes() ?>><span id="el_rescomp">
<input type="text" name="x_rescomp" id="x_rescomp" size="30" value="<?php echo $filesystem->rescomp->EditValue ?>"<?php echo $filesystem->rescomp->EditAttributes() ?>>
</span><?php echo $filesystem->rescomp->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p> Press COMIT to confirm changes else click on Go Back </p>
<p>
<input type="submit" name="btnAction" id="btnAction" value="   COMMIT   ">
</form>
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
// Page Class
//
class cfilesystem_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'filesystem';

	// Page Object Name
	var $PageObjName = 'filesystem_edit';

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
	function cfilesystem_edit() {
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
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'filesystem', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
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

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $filesystem;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$filesystem->id->setQueryStringValue($_GET["id"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$filesystem->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$filesystem->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
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
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("filesystemlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$filesystem->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $filesystem->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$filesystem->RowType = EW_ROWTYPE_EDIT; // Render as edit
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $filesystem;
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
		} elseif ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$filesystem->id->EditCustomAttributes = "";
			$filesystem->id->EditValue = $filesystem->id->CurrentValue;
			$filesystem->id->CssStyle = "";
			$filesystem->id->CssClass = "";
			$filesystem->id->ViewCustomAttributes = "";

			// mount
			$filesystem->mount->EditCustomAttributes = "";
			$filesystem->mount->EditValue = $filesystem->mount->CurrentValue;
			$filesystem->mount->CssStyle = "";
			$filesystem->mount->CssClass = "";
			$filesystem->mount->ViewCustomAttributes = "";

			// path
			$filesystem->path->EditCustomAttributes = "";
			$filesystem->path->EditValue = $filesystem->path->CurrentValue;
			$filesystem->path->CssStyle = "";
			$filesystem->path->CssClass = "";
			$filesystem->path->ViewCustomAttributes = "";

			// parent
			$filesystem->parent->EditCustomAttributes = "";
			$filesystem->parent->EditValue = $filesystem->parent->CurrentValue;
			$filesystem->parent->CssStyle = "";
			$filesystem->parent->CssClass = "";
			$filesystem->parent->ViewCustomAttributes = "";

			// deprecated
			$filesystem->deprecated->EditCustomAttributes = "";
			$filesystem->deprecated->EditValue = $filesystem->deprecated->CurrentValue;
			$filesystem->deprecated->CssStyle = "";
			$filesystem->deprecated->CssClass = "";
			$filesystem->deprecated->ViewCustomAttributes = "";

			// gid
			$filesystem->gid->EditCustomAttributes = "";
			if ($filesystem->gid->getSessionValue() <> "") {
				$filesystem->gid->CurrentValue = $filesystem->gid->getSessionValue();
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
			} else {
			$sSqlWrk = "SELECT `id`, `id`, `name`, '' AS SelectFilterFld FROM `grp`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Please Select", ""));
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
			} else {
			$sSqlWrk = "SELECT `id`, `id`, `name`, '' AS SelectFilterFld FROM `server_type`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Please Select", ""));
			$filesystem->type->EditValue = $arwrk;
			}

			// contact
			$filesystem->contact->EditCustomAttributes = "";
			if ($filesystem->contact->getSessionValue() <> "") {
				$filesystem->contact->CurrentValue = $filesystem->contact->getSessionValue();
			$filesystem->contact->ViewValue = $filesystem->contact->CurrentValue;
			$filesystem->contact->CssStyle = "";
			$filesystem->contact->CssClass = "";
			$filesystem->contact->ViewCustomAttributes = "";
			} else {
			$filesystem->contact->EditValue = ew_HtmlEncode($filesystem->contact->CurrentValue);
			}

			// contact2
			$filesystem->contact2->EditCustomAttributes = "";
			$filesystem->contact2->EditValue = ew_HtmlEncode($filesystem->contact2->CurrentValue);

			// rescomp
			$filesystem->rescomp->EditCustomAttributes = "";
			$filesystem->rescomp->EditValue = ew_HtmlEncode($filesystem->rescomp->CurrentValue);

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
		}

		// Call Row Rendered event
		$filesystem->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $filesystem;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($filesystem->snapshot->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Snapshot";
		}
		if (!ew_CheckInteger($filesystem->tapebackup->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Tapebackup";
		}
		if (!ew_CheckInteger($filesystem->diskbackup->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Diskbackup";
		}
		if (!ew_CheckInteger($filesystem->contact->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Contact";
		}
		if (!ew_CheckInteger($filesystem->contact2->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Contact 2";
		}
		if (!ew_CheckInteger($filesystem->rescomp->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Rescomp";
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
		global $conn, $Security, $filesystem;
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

			// Field gid
			$filesystem->gid->SetDbValueDef($filesystem->gid->CurrentValue, NULL);
			$rsnew['gid'] =& $filesystem->gid->DbValue;

			// Field snapshot
			$filesystem->snapshot->SetDbValueDef($filesystem->snapshot->CurrentValue, NULL);
			$rsnew['snapshot'] =& $filesystem->snapshot->DbValue;

			// Field tapebackup
			$filesystem->tapebackup->SetDbValueDef($filesystem->tapebackup->CurrentValue, NULL);
			$rsnew['tapebackup'] =& $filesystem->tapebackup->DbValue;

			// Field diskbackup
			$filesystem->diskbackup->SetDbValueDef($filesystem->diskbackup->CurrentValue, NULL);
			$rsnew['diskbackup'] =& $filesystem->diskbackup->DbValue;

			// Field type
			$filesystem->type->SetDbValueDef($filesystem->type->CurrentValue, NULL);
			$rsnew['type'] =& $filesystem->type->DbValue;

			// Field contact
			$filesystem->contact->SetDbValueDef($filesystem->contact->CurrentValue, NULL);
			$rsnew['contact'] =& $filesystem->contact->DbValue;

			// Field contact2
			$filesystem->contact2->SetDbValueDef($filesystem->contact2->CurrentValue, NULL);
			$rsnew['contact2'] =& $filesystem->contact2->DbValue;

			// Field rescomp
			$filesystem->rescomp->SetDbValueDef($filesystem->rescomp->CurrentValue, NULL);
			$rsnew['rescomp'] =& $filesystem->rescomp->DbValue;

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
					$this->setMessage("Update cancelled");
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
