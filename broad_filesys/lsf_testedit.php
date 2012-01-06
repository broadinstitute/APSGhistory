<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_testinfo.php" ?>
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
$lsf_test_edit = new clsf_test_edit();
$Page =& $lsf_test_edit;

// Page init processing
$lsf_test_edit->Page_Init();

// Page main processing
$lsf_test_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_test_edit = new ew_Page("lsf_test_edit");

// page properties
lsf_test_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = lsf_test_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
lsf_test_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_date"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Date");
		elm = fobj.elements["x" + infix + "_date"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Date");
		elm = fobj.elements["x" + infix + "_uid"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Uid");
		elm = fobj.elements["x" + infix + "_uid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Uid");
		elm = fobj.elements["x" + infix + "_qid"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Qid");
		elm = fobj.elements["x" + infix + "_qid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Qid");
		elm = fobj.elements["x" + infix + "_cpu"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "Incorrect floating point number - Cpu");
		elm = fobj.elements["x" + infix + "_job"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "Incorrect floating point number - Job");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
lsf_test_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_test_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_test_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Lsf Test<br><br>
<a href="<?php echo $lsf_test->getReturnUrl() ?>">Go Back</a></span></p>
<?php $lsf_test_edit->ShowMessage() ?>
<form name="flsf_testedit" id="flsf_testedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return lsf_test_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="lsf_test">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lsf_test->date->Visible) { // date ?>
	<tr<?php echo $lsf_test->date->RowAttributes ?>>
		<td class="ewTableHeader">Date<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $lsf_test->date->CellAttributes() ?>><span id="el_date">
<div<?php echo $lsf_test->date->ViewAttributes() ?>><?php echo $lsf_test->date->EditValue ?></div><input type="hidden" name="x_date" id="x_date" value="<?php echo ew_HtmlEncode($lsf_test->date->CurrentValue) ?>">
</span><?php echo $lsf_test->date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_test->uid->Visible) { // uid ?>
	<tr<?php echo $lsf_test->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $lsf_test->uid->CellAttributes() ?>><span id="el_uid">
<div<?php echo $lsf_test->uid->ViewAttributes() ?>><?php echo $lsf_test->uid->EditValue ?></div><input type="hidden" name="x_uid" id="x_uid" value="<?php echo ew_HtmlEncode($lsf_test->uid->CurrentValue) ?>">
</span><?php echo $lsf_test->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_test->qid->Visible) { // qid ?>
	<tr<?php echo $lsf_test->qid->RowAttributes ?>>
		<td class="ewTableHeader">Qid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $lsf_test->qid->CellAttributes() ?>><span id="el_qid">
<div<?php echo $lsf_test->qid->ViewAttributes() ?>><?php echo $lsf_test->qid->EditValue ?></div><input type="hidden" name="x_qid" id="x_qid" value="<?php echo ew_HtmlEncode($lsf_test->qid->CurrentValue) ?>">
</span><?php echo $lsf_test->qid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_test->cpu->Visible) { // cpu ?>
	<tr<?php echo $lsf_test->cpu->RowAttributes ?>>
		<td class="ewTableHeader">Cpu</td>
		<td<?php echo $lsf_test->cpu->CellAttributes() ?>><span id="el_cpu">
<input type="text" name="x_cpu" id="x_cpu" size="30" value="<?php echo $lsf_test->cpu->EditValue ?>"<?php echo $lsf_test->cpu->EditAttributes() ?>>
</span><?php echo $lsf_test->cpu->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_test->job->Visible) { // job ?>
	<tr<?php echo $lsf_test->job->RowAttributes ?>>
		<td class="ewTableHeader">Job</td>
		<td<?php echo $lsf_test->job->CellAttributes() ?>><span id="el_job">
<input type="text" name="x_job" id="x_job" size="30" value="<?php echo $lsf_test->job->EditValue ?>"<?php echo $lsf_test->job->EditAttributes() ?>>
</span><?php echo $lsf_test->job->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="   Edit   ">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$lsf_test_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_test_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'lsf_test';

	// Page Object Name
	var $PageObjName = 'lsf_test_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_test;
		if ($lsf_test->UseTokenInUrl) $PageUrl .= "t=" . $lsf_test->TableVar . "&"; // add page token
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
		global $objForm, $lsf_test;
		if ($lsf_test->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_test->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_test->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_test_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_test"] = new clsf_test();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_test', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_test;
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
		global $objForm, $gsFormError, $lsf_test;

		// Load key from QueryString
		if (@$_GET["date"] <> "")
			$lsf_test->date->setQueryStringValue($_GET["date"]);
		if (@$_GET["uid"] <> "")
			$lsf_test->uid->setQueryStringValue($_GET["uid"]);
		if (@$_GET["qid"] <> "")
			$lsf_test->qid->setQueryStringValue($_GET["qid"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$lsf_test->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$lsf_test->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$lsf_test->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($lsf_test->date->CurrentValue == "")
			$this->Page_Terminate("lsf_testlist.php"); // Invalid key, return to list
		if ($lsf_test->uid->CurrentValue == "")
			$this->Page_Terminate("lsf_testlist.php"); // Invalid key, return to list
		if ($lsf_test->qid->CurrentValue == "")
			$this->Page_Terminate("lsf_testlist.php"); // Invalid key, return to list
		switch ($lsf_test->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("lsf_testlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$lsf_test->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $lsf_test->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$lsf_test->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $lsf_test;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $lsf_test;
		$lsf_test->date->setFormValue($objForm->GetValue("x_date"));
		$lsf_test->uid->setFormValue($objForm->GetValue("x_uid"));
		$lsf_test->qid->setFormValue($objForm->GetValue("x_qid"));
		$lsf_test->cpu->setFormValue($objForm->GetValue("x_cpu"));
		$lsf_test->job->setFormValue($objForm->GetValue("x_job"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $lsf_test;
		$this->LoadRow();
		$lsf_test->date->CurrentValue = $lsf_test->date->FormValue;
		$lsf_test->uid->CurrentValue = $lsf_test->uid->FormValue;
		$lsf_test->qid->CurrentValue = $lsf_test->qid->FormValue;
		$lsf_test->cpu->CurrentValue = $lsf_test->cpu->FormValue;
		$lsf_test->job->CurrentValue = $lsf_test->job->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_test;
		$sFilter = $lsf_test->KeyFilter();

		// Call Row Selecting event
		$lsf_test->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_test->CurrentFilter = $sFilter;
		$sSql = $lsf_test->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_test->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_test;
		$lsf_test->date->setDbValue($rs->fields('date'));
		$lsf_test->uid->setDbValue($rs->fields('uid'));
		$lsf_test->qid->setDbValue($rs->fields('qid'));
		$lsf_test->cpu->setDbValue($rs->fields('cpu'));
		$lsf_test->job->setDbValue($rs->fields('job'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_test;

		// Call Row_Rendering event
		$lsf_test->Row_Rendering();

		// Common render codes for all row types
		// date

		$lsf_test->date->CellCssStyle = "";
		$lsf_test->date->CellCssClass = "";

		// uid
		$lsf_test->uid->CellCssStyle = "";
		$lsf_test->uid->CellCssClass = "";

		// qid
		$lsf_test->qid->CellCssStyle = "";
		$lsf_test->qid->CellCssClass = "";

		// cpu
		$lsf_test->cpu->CellCssStyle = "";
		$lsf_test->cpu->CellCssClass = "";

		// job
		$lsf_test->job->CellCssStyle = "";
		$lsf_test->job->CellCssClass = "";
		if ($lsf_test->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$lsf_test->date->ViewValue = $lsf_test->date->CurrentValue;
			$lsf_test->date->CssStyle = "";
			$lsf_test->date->CssClass = "";
			$lsf_test->date->ViewCustomAttributes = "";

			// uid
			$lsf_test->uid->ViewValue = $lsf_test->uid->CurrentValue;
			$lsf_test->uid->CssStyle = "";
			$lsf_test->uid->CssClass = "";
			$lsf_test->uid->ViewCustomAttributes = "";

			// qid
			$lsf_test->qid->ViewValue = $lsf_test->qid->CurrentValue;
			$lsf_test->qid->CssStyle = "";
			$lsf_test->qid->CssClass = "";
			$lsf_test->qid->ViewCustomAttributes = "";

			// cpu
			$lsf_test->cpu->ViewValue = $lsf_test->cpu->CurrentValue;
			$lsf_test->cpu->CssStyle = "";
			$lsf_test->cpu->CssClass = "";
			$lsf_test->cpu->ViewCustomAttributes = "";

			// job
			$lsf_test->job->ViewValue = $lsf_test->job->CurrentValue;
			$lsf_test->job->CssStyle = "";
			$lsf_test->job->CssClass = "";
			$lsf_test->job->ViewCustomAttributes = "";

			// date
			$lsf_test->date->HrefValue = "";

			// uid
			$lsf_test->uid->HrefValue = "";

			// qid
			$lsf_test->qid->HrefValue = "";

			// cpu
			$lsf_test->cpu->HrefValue = "";

			// job
			$lsf_test->job->HrefValue = "";
		} elseif ($lsf_test->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// date
			$lsf_test->date->EditCustomAttributes = "";
			$lsf_test->date->EditValue = $lsf_test->date->CurrentValue;
			$lsf_test->date->CssStyle = "";
			$lsf_test->date->CssClass = "";
			$lsf_test->date->ViewCustomAttributes = "";

			// uid
			$lsf_test->uid->EditCustomAttributes = "";
			$lsf_test->uid->EditValue = $lsf_test->uid->CurrentValue;
			$lsf_test->uid->CssStyle = "";
			$lsf_test->uid->CssClass = "";
			$lsf_test->uid->ViewCustomAttributes = "";

			// qid
			$lsf_test->qid->EditCustomAttributes = "";
			$lsf_test->qid->EditValue = $lsf_test->qid->CurrentValue;
			$lsf_test->qid->CssStyle = "";
			$lsf_test->qid->CssClass = "";
			$lsf_test->qid->ViewCustomAttributes = "";

			// cpu
			$lsf_test->cpu->EditCustomAttributes = "";
			$lsf_test->cpu->EditValue = ew_HtmlEncode($lsf_test->cpu->CurrentValue);

			// job
			$lsf_test->job->EditCustomAttributes = "";
			$lsf_test->job->EditValue = ew_HtmlEncode($lsf_test->job->CurrentValue);

			// Edit refer script
			// date

			$lsf_test->date->HrefValue = "";

			// uid
			$lsf_test->uid->HrefValue = "";

			// qid
			$lsf_test->qid->HrefValue = "";

			// cpu
			$lsf_test->cpu->HrefValue = "";

			// job
			$lsf_test->job->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_test->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $lsf_test;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($lsf_test->date->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Date";
		}
		if (!ew_CheckInteger($lsf_test->date->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Date";
		}
		if ($lsf_test->uid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Uid";
		}
		if (!ew_CheckInteger($lsf_test->uid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Uid";
		}
		if ($lsf_test->qid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Qid";
		}
		if (!ew_CheckInteger($lsf_test->qid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Qid";
		}
		if (!ew_CheckNumber($lsf_test->cpu->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect floating point number - Cpu";
		}
		if (!ew_CheckNumber($lsf_test->job->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect floating point number - Job";
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
		global $conn, $Security, $lsf_test;
		$sFilter = $lsf_test->KeyFilter();
		$lsf_test->CurrentFilter = $sFilter;
		$sSql = $lsf_test->SQL();
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

			// Field date
			// Field uid
			// Field qid
			// Field cpu

			$lsf_test->cpu->SetDbValueDef($lsf_test->cpu->CurrentValue, NULL);
			$rsnew['cpu'] =& $lsf_test->cpu->DbValue;

			// Field job
			$lsf_test->job->SetDbValueDef($lsf_test->job->CurrentValue, NULL);
			$rsnew['job'] =& $lsf_test->job->DbValue;

			// Call Row Updating event
			$bUpdateRow = $lsf_test->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($lsf_test->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($lsf_test->CancelMessage <> "") {
					$this->setMessage($lsf_test->CancelMessage);
					$lsf_test->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$lsf_test->Row_Updated($rsold, $rsnew);
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
