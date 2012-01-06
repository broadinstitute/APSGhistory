<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
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
$users_addopt = new cusers_addopt();
$Page =& $users_addopt;

// Page init
$users_addopt->Page_Init();

// Page main
$users_addopt->Page_Main();
?>
<script type="text/javascript">
<!--
var users_addopt = new ew_Page("users_addopt");

// page properties
users_addopt.PageID = "addopt"; // page ID
users_addopt.FormID = "fusersaddopt"; // form ID
var EW_PAGE_ID = users_addopt.PageID; // for backward compatibility

// extend page with ValidateForm function
users_addopt.ValidateForm = function(fobj) {
	return true; // ignore validation
}

//-->
</script>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$users_addopt->ShowMessage();
?>
<form name="fusersaddopt" id="fusersaddopt" action="usersaddopt.php" method="post" onsubmit="return users_addopt.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="users">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<table class="ewTableAddOpt">
	<tr>
		<td><?php echo $users->uid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td><span id="el_uid">
<input type="text" name="x_uid" id="x_uid" title="<?php echo $users->uid->FldTitle() ?>" size="30" value="<?php echo $users->uid->EditValue ?>"<?php echo $users->uid->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><?php echo $users->username->FldCaption() ?></td>
		<td><span id="el_username">
<input type="text" name="x_username" id="x_username" title="<?php echo $users->username->FldTitle() ?>" size="30" maxlength="16" value="<?php echo $users->username->EditValue ?>"<?php echo $users->username->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><?php echo $users->gecos->FldCaption() ?></td>
		<td><span id="el_gecos">
<input type="text" name="x_gecos" id="x_gecos" title="<?php echo $users->gecos->FldTitle() ?>" size="30" maxlength="80" value="<?php echo $users->gecos->EditValue ?>"<?php echo $users->gecos->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><?php echo $users->role->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td><span id="el_role">
<input type="text" name="x_role" id="x_role" title="<?php echo $users->role->FldTitle() ?>" size="30" value="<?php echo $users->role->EditValue ?>"<?php echo $users->role->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><?php echo $users->gid->FldCaption() ?></td>
		<td><span id="el_gid">
<input type="text" name="x_gid" id="x_gid" title="<?php echo $users->gid->FldTitle() ?>" size="30" value="<?php echo $users->gid->EditValue ?>"<?php echo $users->gid->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><?php echo $users->cobj->FldCaption() ?></td>
		<td><span id="el_cobj">
<input type="text" name="x_cobj" id="x_cobj" title="<?php echo $users->cobj->FldTitle() ?>" size="30" maxlength="200" value="<?php echo $users->cobj->EditValue ?>"<?php echo $users->cobj->EditAttributes() ?>>
</span></td>
	</tr>
</table>
<p>
</form>
<?php
$users_addopt->Page_Terminate();
?>
<?php

//
// Page class
//
class cusers_addopt {

	// Page ID
	var $PageID = 'addopt';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_addopt';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $users;
		if ($users->UseTokenInUrl) $PageUrl .= "t=" . $users->TableVar . "&"; // Add page token
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
		global $objForm, $users;
		if ($users->UseTokenInUrl) {
			if ($objForm)
				return ($users->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($users->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cusers_addopt() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (users)
		$GLOBALS["users"] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'addopt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

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
		global $users;

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

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $users;

		// Process form if post back
		if ($objForm->GetValue("a_addopt") <> "") {
			$users->CurrentAction = $objForm->GetValue("a_addopt"); // Get form action
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$users->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
			$users->CurrentAction = "I"; // Display blank record
			$this->LoadDefaultValues(); // Load default values
		}

		// Perform action based on action code
		switch ($users->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add new record
				$users->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow()) { // Add successful
					$XMLDoc = new cXMLDocument("utf-8");
					$XMLDoc->AddRoot("root");
					$XMLDoc->AddRow("result");
					$XMLDoc->AddField("x_uid", strval($users->uid->FormValue));
					$XMLDoc->AddField("x_username", strval($users->username->FormValue));
					$XMLDoc->AddField("x_gecos", strval($users->gecos->FormValue));
					$XMLDoc->AddField("x_role", strval($users->role->FormValue));
					$XMLDoc->AddField("x_gid", strval($users->gid->FormValue));
					$XMLDoc->AddField("x_cobj", strval($users->cobj->FormValue));
					header("Content-Type: text/xml");
					echo $XMLDoc->XML();
					$this->Page_Terminate();
					exit();
				} else {
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row
		$users->RowType = EW_ROWTYPE_ADD; // Render add type
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $users;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $users;
		$users->role->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $users;
		$users->uid->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_uid")));
		$users->username->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_username")));
		$users->gecos->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_gecos")));
		$users->role->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_role")));
		$users->gid->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_gid")));
		$users->cobj->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_cobj")));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $users;
		$users->uid->CurrentValue = ew_ConvertToUtf8($users->uid->FormValue);
		$users->username->CurrentValue = ew_ConvertToUtf8($users->username->FormValue);
		$users->gecos->CurrentValue = ew_ConvertToUtf8($users->gecos->FormValue);
		$users->role->CurrentValue = ew_ConvertToUtf8($users->role->FormValue);
		$users->gid->CurrentValue = ew_ConvertToUtf8($users->gid->FormValue);
		$users->cobj->CurrentValue = ew_ConvertToUtf8($users->cobj->FormValue);
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $users;
		$sFilter = $users->KeyFilter();

		// Call Row Selecting event
		$users->Row_Selecting($sFilter);

		// Load SQL based on filter
		$users->CurrentFilter = $sFilter;
		$sSql = $users->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$users->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $users;
		$users->uid->setDbValue($rs->fields('uid'));
		$users->username->setDbValue($rs->fields('username'));
		$users->gecos->setDbValue($rs->fields('gecos'));
		$users->role->setDbValue($rs->fields('role'));
		$users->gid->setDbValue($rs->fields('gid'));
		$users->cobj->setDbValue($rs->fields('cobj'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $users;

		// Initialize URLs
		// Call Row_Rendering event

		$users->Row_Rendering();

		// Common render codes for all row types
		// uid

		$users->uid->CellCssStyle = ""; $users->uid->CellCssClass = "";
		$users->uid->CellAttrs = array(); $users->uid->ViewAttrs = array(); $users->uid->EditAttrs = array();

		// username
		$users->username->CellCssStyle = ""; $users->username->CellCssClass = "";
		$users->username->CellAttrs = array(); $users->username->ViewAttrs = array(); $users->username->EditAttrs = array();

		// gecos
		$users->gecos->CellCssStyle = ""; $users->gecos->CellCssClass = "";
		$users->gecos->CellAttrs = array(); $users->gecos->ViewAttrs = array(); $users->gecos->EditAttrs = array();

		// role
		$users->role->CellCssStyle = ""; $users->role->CellCssClass = "";
		$users->role->CellAttrs = array(); $users->role->ViewAttrs = array(); $users->role->EditAttrs = array();

		// gid
		$users->gid->CellCssStyle = ""; $users->gid->CellCssClass = "";
		$users->gid->CellAttrs = array(); $users->gid->ViewAttrs = array(); $users->gid->EditAttrs = array();

		// cobj
		$users->cobj->CellCssStyle = ""; $users->cobj->CellCssClass = "";
		$users->cobj->CellAttrs = array(); $users->cobj->ViewAttrs = array(); $users->cobj->EditAttrs = array();
		if ($users->RowType == EW_ROWTYPE_VIEW) { // View row

			// uid
			$users->uid->ViewValue = $users->uid->CurrentValue;
			$users->uid->CssStyle = "";
			$users->uid->CssClass = "";
			$users->uid->ViewCustomAttributes = "";

			// username
			$users->username->ViewValue = $users->username->CurrentValue;
			$users->username->CssStyle = "";
			$users->username->CssClass = "";
			$users->username->ViewCustomAttributes = "";

			// gecos
			$users->gecos->ViewValue = $users->gecos->CurrentValue;
			$users->gecos->CssStyle = "";
			$users->gecos->CssClass = "";
			$users->gecos->ViewCustomAttributes = "";

			// role
			$users->role->ViewValue = $users->role->CurrentValue;
			$users->role->CssStyle = "";
			$users->role->CssClass = "";
			$users->role->ViewCustomAttributes = "";

			// gid
			$users->gid->ViewValue = $users->gid->CurrentValue;
			$users->gid->CssStyle = "";
			$users->gid->CssClass = "";
			$users->gid->ViewCustomAttributes = "";

			// cobj
			$users->cobj->ViewValue = $users->cobj->CurrentValue;
			$users->cobj->CssStyle = "";
			$users->cobj->CssClass = "";
			$users->cobj->ViewCustomAttributes = "";

			// uid
			$users->uid->HrefValue = "";
			$users->uid->TooltipValue = "";

			// username
			$users->username->HrefValue = "";
			$users->username->TooltipValue = "";

			// gecos
			$users->gecos->HrefValue = "";
			$users->gecos->TooltipValue = "";

			// role
			$users->role->HrefValue = "";
			$users->role->TooltipValue = "";

			// gid
			$users->gid->HrefValue = "";
			$users->gid->TooltipValue = "";

			// cobj
			$users->cobj->HrefValue = "";
			$users->cobj->TooltipValue = "";
		} elseif ($users->RowType == EW_ROWTYPE_ADD) { // Add row

			// uid
			$users->uid->EditCustomAttributes = "";
			$users->uid->EditValue = ew_HtmlEncode($users->uid->CurrentValue);

			// username
			$users->username->EditCustomAttributes = "";
			$users->username->EditValue = ew_HtmlEncode($users->username->CurrentValue);

			// gecos
			$users->gecos->EditCustomAttributes = "";
			$users->gecos->EditValue = ew_HtmlEncode($users->gecos->CurrentValue);

			// role
			$users->role->EditCustomAttributes = "";
			$users->role->EditValue = ew_HtmlEncode($users->role->CurrentValue);

			// gid
			$users->gid->EditCustomAttributes = "";
			$users->gid->EditValue = ew_HtmlEncode($users->gid->CurrentValue);

			// cobj
			$users->cobj->EditCustomAttributes = "";
			$users->cobj->EditValue = ew_HtmlEncode($users->cobj->CurrentValue);
		}

		// Call Row Rendered event
		if ($users->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$users->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $users;

		// Initialize form error message
		$gsFormError = "";
		if (!is_null($users->uid->FormValue) && $users->uid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $users->uid->FldCaption();
		}
		if (!ew_CheckInteger($users->uid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $users->uid->FldErrMsg();
		}
		if (!ew_CheckInteger($users->role->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $users->role->FldErrMsg();
		}
		if (!ew_CheckInteger($users->gid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $users->gid->FldErrMsg();
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

	// Add record
	function AddRow() {
		global $conn, $Language, $Security, $users;

		// Check if key value entered
		if ($users->uid->CurrentValue == "" && $users->uid->getSessionValue() == "") {
			$this->setMessage($Language->Phrase("InvalidKeyValue"));
			return FALSE;
		}

		// Check for duplicate key
		$bCheckKey = TRUE;
		$sFilter = $users->KeyFilter();
		if ($bCheckKey) {
			$rsChk = $users->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setMessage($sKeyErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// uid
		$users->uid->SetDbValueDef($rsnew, $users->uid->CurrentValue, 0, FALSE);

		// username
		$users->username->SetDbValueDef($rsnew, $users->username->CurrentValue, NULL, FALSE);

		// gecos
		$users->gecos->SetDbValueDef($rsnew, $users->gecos->CurrentValue, NULL, FALSE);

		// role
		$users->role->SetDbValueDef($rsnew, $users->role->CurrentValue, 0, TRUE);

		// gid
		$users->gid->SetDbValueDef($rsnew, $users->gid->CurrentValue, NULL, FALSE);

		// cobj
		$users->cobj->SetDbValueDef($rsnew, $users->cobj->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$bInsertRow = $users->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($users->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($users->CancelMessage <> "") {
				$this->setMessage($users->CancelMessage);
				$users->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$users->Row_Inserted($rsnew);
		}
		return $AddRow;
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

	// Custom validate event
	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
