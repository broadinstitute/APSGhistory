<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "server_typeinfo.php" ?>
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
$server_type_edit = new cserver_type_edit();
$Page =& $server_type_edit;

// Page init
$server_type_edit->Page_Init();

// Page main
$server_type_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var server_type_edit = new ew_Page("server_type_edit");

// page properties
server_type_edit.PageID = "edit"; // page ID
server_type_edit.FormID = "fserver_typeedit"; // form ID
var EW_PAGE_ID = server_type_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
server_type_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
server_type_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
server_type_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
server_type_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $server_type->TableCaption() ?><br><br>
<a href="<?php echo $server_type->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$server_type_edit->ShowMessage();
?>
<form name="fserver_typeedit" id="fserver_typeedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return server_type_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="server_type">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($server_type->id->Visible) { // id ?>
	<tr<?php echo $server_type->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $server_type->id->FldCaption() ?></td>
		<td<?php echo $server_type->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $server_type->id->ViewAttributes() ?>><?php echo $server_type->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($server_type->id->CurrentValue) ?>">
</span><?php echo $server_type->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($server_type->name->Visible) { // name ?>
	<tr<?php echo $server_type->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $server_type->name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $server_type->name->CellAttributes() ?>><span id="el_name">
<div<?php echo $server_type->name->ViewAttributes() ?>><?php echo $server_type->name->EditValue ?></div><input type="hidden" name="x_name" id="x_name" value="<?php echo ew_HtmlEncode($server_type->name->CurrentValue) ?>">
</span><?php echo $server_type->name->CustomMsg ?></td>
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
$server_type_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cserver_type_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'server_type';

	// Page object name
	var $PageObjName = 'server_type_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $server_type;
		if ($server_type->UseTokenInUrl) $PageUrl .= "t=" . $server_type->TableVar . "&"; // Add page token
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
		global $objForm, $server_type;
		if ($server_type->UseTokenInUrl) {
			if ($objForm)
				return ($server_type->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($server_type->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cserver_type_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (server_type)
		$GLOBALS["server_type"] = new cserver_type();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'server_type', TRUE);

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
		global $server_type;

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
		global $objForm, $Language, $gsFormError, $server_type;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$server_type->id->setQueryStringValue($_GET["id"]);
		if (@$_POST["a_edit"] <> "") {
			$server_type->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$server_type->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$server_type->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$server_type->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($server_type->id->CurrentValue == "")
			$this->Page_Terminate("server_typelist.php"); // Invalid key, return to list
		switch ($server_type->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("server_typelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$server_type->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $server_type->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$server_type->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$server_type->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $server_type;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $server_type;
		$server_type->id->setFormValue($objForm->GetValue("x_id"));
		$server_type->name->setFormValue($objForm->GetValue("x_name"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $server_type;
		$this->LoadRow();
		$server_type->id->CurrentValue = $server_type->id->FormValue;
		$server_type->name->CurrentValue = $server_type->name->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $server_type;
		$sFilter = $server_type->KeyFilter();

		// Call Row Selecting event
		$server_type->Row_Selecting($sFilter);

		// Load SQL based on filter
		$server_type->CurrentFilter = $sFilter;
		$sSql = $server_type->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$server_type->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $server_type;
		$server_type->id->setDbValue($rs->fields('id'));
		$server_type->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $server_type;

		// Initialize URLs
		// Call Row_Rendering event

		$server_type->Row_Rendering();

		// Common render codes for all row types
		// id

		$server_type->id->CellCssStyle = ""; $server_type->id->CellCssClass = "";
		$server_type->id->CellAttrs = array(); $server_type->id->ViewAttrs = array(); $server_type->id->EditAttrs = array();

		// name
		$server_type->name->CellCssStyle = ""; $server_type->name->CellCssClass = "";
		$server_type->name->CellAttrs = array(); $server_type->name->ViewAttrs = array(); $server_type->name->EditAttrs = array();
		if ($server_type->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$server_type->id->ViewValue = $server_type->id->CurrentValue;
			$server_type->id->CssStyle = "";
			$server_type->id->CssClass = "";
			$server_type->id->ViewCustomAttributes = "";

			// name
			$server_type->name->ViewValue = $server_type->name->CurrentValue;
			$server_type->name->CssStyle = "";
			$server_type->name->CssClass = "";
			$server_type->name->ViewCustomAttributes = "";

			// id
			$server_type->id->HrefValue = "";
			$server_type->id->TooltipValue = "";

			// name
			$server_type->name->HrefValue = "";
			$server_type->name->TooltipValue = "";
		} elseif ($server_type->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$server_type->id->EditCustomAttributes = "";
			$server_type->id->EditValue = $server_type->id->CurrentValue;
			$server_type->id->CssStyle = "";
			$server_type->id->CssClass = "";
			$server_type->id->ViewCustomAttributes = "";

			// name
			$server_type->name->EditCustomAttributes = "";
			$server_type->name->EditValue = $server_type->name->CurrentValue;
			$server_type->name->CssStyle = "";
			$server_type->name->CssClass = "";
			$server_type->name->ViewCustomAttributes = "";

			// Edit refer script
			// id

			$server_type->id->HrefValue = "";

			// name
			$server_type->name->HrefValue = "";
		}

		// Call Row Rendered event
		if ($server_type->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$server_type->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $server_type;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

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
		global $conn, $Security, $Language, $server_type;
		$sFilter = $server_type->KeyFilter();
		$server_type->CurrentFilter = $sFilter;
		$sSql = $server_type->SQL();
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

			// Call Row Updating event
			$bUpdateRow = $server_type->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($server_type->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($server_type->CancelMessage <> "") {
					$this->setMessage($server_type->CancelMessage);
					$server_type->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$server_type->Row_Updated($rsold, $rsnew);
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
