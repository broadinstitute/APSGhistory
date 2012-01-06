<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "grpinfo.php" ?>
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
$grp_edit = new cgrp_edit();
$Page =& $grp_edit;

// Page init
$grp_edit->Page_Init();

// Page main
$grp_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var grp_edit = new ew_Page("grp_edit");

// page properties
grp_edit.PageID = "edit"; // page ID
grp_edit.FormID = "fgrpedit"; // form ID
var EW_PAGE_ID = grp_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
grp_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_parent"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($grp->parent->FldErrMsg()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
grp_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
grp_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
grp_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $grp->TableCaption() ?><br><br>
<a href="<?php echo $grp->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$grp_edit->ShowMessage();
?>
<form name="fgrpedit" id="fgrpedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return grp_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="grp">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($grp->id->Visible) { // id ?>
	<tr<?php echo $grp->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $grp->id->FldCaption() ?></td>
		<td<?php echo $grp->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $grp->id->ViewAttributes() ?>><?php echo $grp->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($grp->id->CurrentValue) ?>">
</span><?php echo $grp->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($grp->name->Visible) { // name ?>
	<tr<?php echo $grp->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $grp->name->FldCaption() ?></td>
		<td<?php echo $grp->name->CellAttributes() ?>><span id="el_name">
<div<?php echo $grp->name->ViewAttributes() ?>><?php echo $grp->name->EditValue ?></div><input type="hidden" name="x_name" id="x_name" value="<?php echo ew_HtmlEncode($grp->name->CurrentValue) ?>">
</span><?php echo $grp->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($grp->parent->Visible) { // parent ?>
	<tr<?php echo $grp->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $grp->parent->FldCaption() ?></td>
		<td<?php echo $grp->parent->CellAttributes() ?>><span id="el_parent">
<input type="text" name="x_parent" id="x_parent" title="<?php echo $grp->parent->FldTitle() ?>" size="30" value="<?php echo $grp->parent->EditValue ?>"<?php echo $grp->parent->EditAttributes() ?>>
</span><?php echo $grp->parent->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$grp_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cgrp_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'grp';

	// Page object name
	var $PageObjName = 'grp_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $grp;
		if ($grp->UseTokenInUrl) $PageUrl .= "t=" . $grp->TableVar . "&"; // Add page token
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
		global $objForm, $grp;
		if ($grp->UseTokenInUrl) {
			if ($objForm)
				return ($grp->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($grp->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cgrp_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (grp)
		$GLOBALS["grp"] = new cgrp();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'grp', TRUE);

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
		global $grp;

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
		global $objForm, $Language, $gsFormError, $grp;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$grp->id->setQueryStringValue($_GET["id"]);
		if (@$_POST["a_edit"] <> "") {
			$grp->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$grp->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$grp->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$grp->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($grp->id->CurrentValue == "")
			$this->Page_Terminate("grplist.php"); // Invalid key, return to list
		switch ($grp->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("grplist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$grp->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $grp->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$grp->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$grp->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $grp;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $grp;
		$grp->id->setFormValue($objForm->GetValue("x_id"));
		$grp->name->setFormValue($objForm->GetValue("x_name"));
		$grp->parent->setFormValue($objForm->GetValue("x_parent"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $grp;
		$this->LoadRow();
		$grp->id->CurrentValue = $grp->id->FormValue;
		$grp->name->CurrentValue = $grp->name->FormValue;
		$grp->parent->CurrentValue = $grp->parent->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $grp;
		$sFilter = $grp->KeyFilter();

		// Call Row Selecting event
		$grp->Row_Selecting($sFilter);

		// Load SQL based on filter
		$grp->CurrentFilter = $sFilter;
		$sSql = $grp->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$grp->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $grp;
		$grp->id->setDbValue($rs->fields('id'));
		$grp->name->setDbValue($rs->fields('name'));
		$grp->parent->setDbValue($rs->fields('parent'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $grp;

		// Initialize URLs
		// Call Row_Rendering event

		$grp->Row_Rendering();

		// Common render codes for all row types
		// id

		$grp->id->CellCssStyle = ""; $grp->id->CellCssClass = "";
		$grp->id->CellAttrs = array(); $grp->id->ViewAttrs = array(); $grp->id->EditAttrs = array();

		// name
		$grp->name->CellCssStyle = ""; $grp->name->CellCssClass = "";
		$grp->name->CellAttrs = array(); $grp->name->ViewAttrs = array(); $grp->name->EditAttrs = array();

		// parent
		$grp->parent->CellCssStyle = ""; $grp->parent->CellCssClass = "";
		$grp->parent->CellAttrs = array(); $grp->parent->ViewAttrs = array(); $grp->parent->EditAttrs = array();
		if ($grp->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$grp->id->ViewValue = $grp->id->CurrentValue;
			$grp->id->CssStyle = "";
			$grp->id->CssClass = "";
			$grp->id->ViewCustomAttributes = "";

			// name
			$grp->name->ViewValue = $grp->name->CurrentValue;
			$grp->name->CssStyle = "";
			$grp->name->CssClass = "";
			$grp->name->ViewCustomAttributes = "";

			// parent
			$grp->parent->ViewValue = $grp->parent->CurrentValue;
			$grp->parent->CssStyle = "";
			$grp->parent->CssClass = "";
			$grp->parent->ViewCustomAttributes = "";

			// id
			$grp->id->HrefValue = "";
			$grp->id->TooltipValue = "";

			// name
			$grp->name->HrefValue = "";
			$grp->name->TooltipValue = "";

			// parent
			$grp->parent->HrefValue = "";
			$grp->parent->TooltipValue = "";
		} elseif ($grp->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$grp->id->EditCustomAttributes = "";
			$grp->id->EditValue = $grp->id->CurrentValue;
			$grp->id->CssStyle = "";
			$grp->id->CssClass = "";
			$grp->id->ViewCustomAttributes = "";

			// name
			$grp->name->EditCustomAttributes = "";
			$grp->name->EditValue = $grp->name->CurrentValue;
			$grp->name->CssStyle = "";
			$grp->name->CssClass = "";
			$grp->name->ViewCustomAttributes = "";

			// parent
			$grp->parent->EditCustomAttributes = "";
			$grp->parent->EditValue = ew_HtmlEncode($grp->parent->CurrentValue);

			// Edit refer script
			// id

			$grp->id->HrefValue = "";

			// name
			$grp->name->HrefValue = "";

			// parent
			$grp->parent->HrefValue = "";
		}

		// Call Row Rendered event
		if ($grp->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$grp->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $grp;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($grp->parent->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $grp->parent->FldErrMsg();
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
		global $conn, $Security, $Language, $grp;
		$sFilter = $grp->KeyFilter();
		$grp->CurrentFilter = $sFilter;
		$sSql = $grp->SQL();
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

			// parent
			$grp->parent->SetDbValueDef($rsnew, $grp->parent->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $grp->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($grp->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($grp->CancelMessage <> "") {
					$this->setMessage($grp->CancelMessage);
					$grp->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$grp->Row_Updated($rsold, $rsnew);
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
