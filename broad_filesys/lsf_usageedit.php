<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_usageinfo.php" ?>
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
$lsf_usage_edit = new clsf_usage_edit();
$Page =& $lsf_usage_edit;

// Page init processing
$lsf_usage_edit->Page_Init();

// Page main processing
$lsf_usage_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_usage_edit = new ew_Page("lsf_usage_edit");

// page properties
lsf_usage_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = lsf_usage_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
lsf_usage_edit.ValidateForm = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_pid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Pid");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
lsf_usage_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_usage_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_usage_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Lsf Usage<br><br>
<a href="<?php echo $lsf_usage->getReturnUrl() ?>">Go Back</a></span></p>
<?php $lsf_usage_edit->ShowMessage() ?>
<form name="flsf_usageedit" id="flsf_usageedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return lsf_usage_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="lsf_usage">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lsf_usage->date->Visible) { // date ?>
	<tr<?php echo $lsf_usage->date->RowAttributes ?>>
		<td class="ewTableHeader">Date<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $lsf_usage->date->CellAttributes() ?>><span id="el_date">
<div<?php echo $lsf_usage->date->ViewAttributes() ?>><?php echo $lsf_usage->date->EditValue ?></div><input type="hidden" name="x_date" id="x_date" value="<?php echo ew_HtmlEncode($lsf_usage->date->CurrentValue) ?>">
</span><?php echo $lsf_usage->date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->uid->Visible) { // uid ?>
	<tr<?php echo $lsf_usage->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $lsf_usage->uid->CellAttributes() ?>><span id="el_uid">
<div<?php echo $lsf_usage->uid->ViewAttributes() ?>><?php echo $lsf_usage->uid->EditValue ?></div><input type="hidden" name="x_uid" id="x_uid" value="<?php echo ew_HtmlEncode($lsf_usage->uid->CurrentValue) ?>">
</span><?php echo $lsf_usage->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->qid->Visible) { // qid ?>
	<tr<?php echo $lsf_usage->qid->RowAttributes ?>>
		<td class="ewTableHeader">Qid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $lsf_usage->qid->CellAttributes() ?>><span id="el_qid">
<div<?php echo $lsf_usage->qid->ViewAttributes() ?>><?php echo $lsf_usage->qid->EditValue ?></div><input type="hidden" name="x_qid" id="x_qid" value="<?php echo ew_HtmlEncode($lsf_usage->qid->CurrentValue) ?>">
</span><?php echo $lsf_usage->qid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->cpu->Visible) { // cpu ?>
	<tr<?php echo $lsf_usage->cpu->RowAttributes ?>>
		<td class="ewTableHeader">Cpu</td>
		<td<?php echo $lsf_usage->cpu->CellAttributes() ?>><span id="el_cpu">
<input type="text" name="x_cpu" id="x_cpu" size="30" value="<?php echo $lsf_usage->cpu->EditValue ?>"<?php echo $lsf_usage->cpu->EditAttributes() ?>>
</span><?php echo $lsf_usage->cpu->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->job->Visible) { // job ?>
	<tr<?php echo $lsf_usage->job->RowAttributes ?>>
		<td class="ewTableHeader">Job</td>
		<td<?php echo $lsf_usage->job->CellAttributes() ?>><span id="el_job">
<input type="text" name="x_job" id="x_job" size="30" value="<?php echo $lsf_usage->job->EditValue ?>"<?php echo $lsf_usage->job->EditAttributes() ?>>
</span><?php echo $lsf_usage->job->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->pid->Visible) { // pid ?>
	<tr<?php echo $lsf_usage->pid->RowAttributes ?>>
		<td class="ewTableHeader">Pid</td>
		<td<?php echo $lsf_usage->pid->CellAttributes() ?>><span id="el_pid">
<input type="text" name="x_pid" id="x_pid" size="30" value="<?php echo $lsf_usage->pid->EditValue ?>"<?php echo $lsf_usage->pid->EditAttributes() ?>>
</span><?php echo $lsf_usage->pid->CustomMsg ?></td>
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
$lsf_usage_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_usage_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'lsf_usage';

	// Page Object Name
	var $PageObjName = 'lsf_usage_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_usage;
		if ($lsf_usage->UseTokenInUrl) $PageUrl .= "t=" . $lsf_usage->TableVar . "&"; // add page token
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
		global $objForm, $lsf_usage;
		if ($lsf_usage->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_usage->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_usage->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_usage_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_usage"] = new clsf_usage();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_usage', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_usage;
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
		global $objForm, $gsFormError, $lsf_usage;

		// Load key from QueryString
		if (@$_GET["date"] <> "")
			$lsf_usage->date->setQueryStringValue($_GET["date"]);
		if (@$_GET["uid"] <> "")
			$lsf_usage->uid->setQueryStringValue($_GET["uid"]);
		if (@$_GET["qid"] <> "")
			$lsf_usage->qid->setQueryStringValue($_GET["qid"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$lsf_usage->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$lsf_usage->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$lsf_usage->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($lsf_usage->date->CurrentValue == "")
			$this->Page_Terminate("lsf_usagelist.php"); // Invalid key, return to list
		if ($lsf_usage->uid->CurrentValue == "")
			$this->Page_Terminate("lsf_usagelist.php"); // Invalid key, return to list
		if ($lsf_usage->qid->CurrentValue == "")
			$this->Page_Terminate("lsf_usagelist.php"); // Invalid key, return to list
		switch ($lsf_usage->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("lsf_usagelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$lsf_usage->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $lsf_usage->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$lsf_usage->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $lsf_usage;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $lsf_usage;
		$lsf_usage->date->setFormValue($objForm->GetValue("x_date"));
		$lsf_usage->uid->setFormValue($objForm->GetValue("x_uid"));
		$lsf_usage->qid->setFormValue($objForm->GetValue("x_qid"));
		$lsf_usage->cpu->setFormValue($objForm->GetValue("x_cpu"));
		$lsf_usage->job->setFormValue($objForm->GetValue("x_job"));
		$lsf_usage->pid->setFormValue($objForm->GetValue("x_pid"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $lsf_usage;
		$this->LoadRow();
		$lsf_usage->date->CurrentValue = $lsf_usage->date->FormValue;
		$lsf_usage->uid->CurrentValue = $lsf_usage->uid->FormValue;
		$lsf_usage->qid->CurrentValue = $lsf_usage->qid->FormValue;
		$lsf_usage->cpu->CurrentValue = $lsf_usage->cpu->FormValue;
		$lsf_usage->job->CurrentValue = $lsf_usage->job->FormValue;
		$lsf_usage->pid->CurrentValue = $lsf_usage->pid->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_usage;
		$sFilter = $lsf_usage->KeyFilter();

		// Call Row Selecting event
		$lsf_usage->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_usage->CurrentFilter = $sFilter;
		$sSql = $lsf_usage->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_usage->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_usage;
		$lsf_usage->date->setDbValue($rs->fields('date'));
		$lsf_usage->uid->setDbValue($rs->fields('uid'));
		$lsf_usage->qid->setDbValue($rs->fields('qid'));
		$lsf_usage->cpu->setDbValue($rs->fields('cpu'));
		$lsf_usage->job->setDbValue($rs->fields('job'));
		$lsf_usage->pid->setDbValue($rs->fields('pid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_usage;

		// Call Row_Rendering event
		$lsf_usage->Row_Rendering();

		// Common render codes for all row types
		// date

		$lsf_usage->date->CellCssStyle = "";
		$lsf_usage->date->CellCssClass = "";

		// uid
		$lsf_usage->uid->CellCssStyle = "";
		$lsf_usage->uid->CellCssClass = "";

		// qid
		$lsf_usage->qid->CellCssStyle = "";
		$lsf_usage->qid->CellCssClass = "";

		// cpu
		$lsf_usage->cpu->CellCssStyle = "";
		$lsf_usage->cpu->CellCssClass = "";

		// job
		$lsf_usage->job->CellCssStyle = "";
		$lsf_usage->job->CellCssClass = "";

		// pid
		$lsf_usage->pid->CellCssStyle = "";
		$lsf_usage->pid->CellCssClass = "";
		if ($lsf_usage->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$lsf_usage->date->ViewValue = $lsf_usage->date->CurrentValue;
			$lsf_usage->date->CssStyle = "";
			$lsf_usage->date->CssClass = "";
			$lsf_usage->date->ViewCustomAttributes = "";

			// uid
			$lsf_usage->uid->ViewValue = $lsf_usage->uid->CurrentValue;
			$lsf_usage->uid->CssStyle = "";
			$lsf_usage->uid->CssClass = "";
			$lsf_usage->uid->ViewCustomAttributes = "";

			// qid
			$lsf_usage->qid->ViewValue = $lsf_usage->qid->CurrentValue;
			$lsf_usage->qid->CssStyle = "";
			$lsf_usage->qid->CssClass = "";
			$lsf_usage->qid->ViewCustomAttributes = "";

			// cpu
			$lsf_usage->cpu->ViewValue = $lsf_usage->cpu->CurrentValue;
			$lsf_usage->cpu->CssStyle = "";
			$lsf_usage->cpu->CssClass = "";
			$lsf_usage->cpu->ViewCustomAttributes = "";

			// job
			$lsf_usage->job->ViewValue = $lsf_usage->job->CurrentValue;
			$lsf_usage->job->CssStyle = "";
			$lsf_usage->job->CssClass = "";
			$lsf_usage->job->ViewCustomAttributes = "";

			// pid
			$lsf_usage->pid->ViewValue = $lsf_usage->pid->CurrentValue;
			$lsf_usage->pid->CssStyle = "";
			$lsf_usage->pid->CssClass = "";
			$lsf_usage->pid->ViewCustomAttributes = "";

			// date
			$lsf_usage->date->HrefValue = "";

			// uid
			$lsf_usage->uid->HrefValue = "";

			// qid
			$lsf_usage->qid->HrefValue = "";

			// cpu
			$lsf_usage->cpu->HrefValue = "";

			// job
			$lsf_usage->job->HrefValue = "";

			// pid
			$lsf_usage->pid->HrefValue = "";
		} elseif ($lsf_usage->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// date
			$lsf_usage->date->EditCustomAttributes = "";
			$lsf_usage->date->EditValue = $lsf_usage->date->CurrentValue;
			$lsf_usage->date->CssStyle = "";
			$lsf_usage->date->CssClass = "";
			$lsf_usage->date->ViewCustomAttributes = "";

			// uid
			$lsf_usage->uid->EditCustomAttributes = "";
			$lsf_usage->uid->EditValue = $lsf_usage->uid->CurrentValue;
			$lsf_usage->uid->CssStyle = "";
			$lsf_usage->uid->CssClass = "";
			$lsf_usage->uid->ViewCustomAttributes = "";

			// qid
			$lsf_usage->qid->EditCustomAttributes = "";
			$lsf_usage->qid->EditValue = $lsf_usage->qid->CurrentValue;
			$lsf_usage->qid->CssStyle = "";
			$lsf_usage->qid->CssClass = "";
			$lsf_usage->qid->ViewCustomAttributes = "";

			// cpu
			$lsf_usage->cpu->EditCustomAttributes = "";
			$lsf_usage->cpu->EditValue = ew_HtmlEncode($lsf_usage->cpu->CurrentValue);

			// job
			$lsf_usage->job->EditCustomAttributes = "";
			$lsf_usage->job->EditValue = ew_HtmlEncode($lsf_usage->job->CurrentValue);

			// pid
			$lsf_usage->pid->EditCustomAttributes = "";
			$lsf_usage->pid->EditValue = ew_HtmlEncode($lsf_usage->pid->CurrentValue);

			// Edit refer script
			// date

			$lsf_usage->date->HrefValue = "";

			// uid
			$lsf_usage->uid->HrefValue = "";

			// qid
			$lsf_usage->qid->HrefValue = "";

			// cpu
			$lsf_usage->cpu->HrefValue = "";

			// job
			$lsf_usage->job->HrefValue = "";

			// pid
			$lsf_usage->pid->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_usage->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $lsf_usage;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($lsf_usage->date->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Date";
		}
		if (!ew_CheckInteger($lsf_usage->date->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Date";
		}
		if ($lsf_usage->uid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Uid";
		}
		if (!ew_CheckInteger($lsf_usage->uid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Uid";
		}
		if ($lsf_usage->qid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Qid";
		}
		if (!ew_CheckInteger($lsf_usage->qid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Qid";
		}
		if (!ew_CheckNumber($lsf_usage->cpu->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect floating point number - Cpu";
		}
		if (!ew_CheckNumber($lsf_usage->job->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect floating point number - Job";
		}
		if (!ew_CheckInteger($lsf_usage->pid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Pid";
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
		global $conn, $Security, $lsf_usage;
		$sFilter = $lsf_usage->KeyFilter();
		$lsf_usage->CurrentFilter = $sFilter;
		$sSql = $lsf_usage->SQL();
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

			$lsf_usage->cpu->SetDbValueDef($lsf_usage->cpu->CurrentValue, NULL);
			$rsnew['cpu'] =& $lsf_usage->cpu->DbValue;

			// Field job
			$lsf_usage->job->SetDbValueDef($lsf_usage->job->CurrentValue, NULL);
			$rsnew['job'] =& $lsf_usage->job->DbValue;

			// Field pid
			$lsf_usage->pid->SetDbValueDef($lsf_usage->pid->CurrentValue, NULL);
			$rsnew['pid'] =& $lsf_usage->pid->DbValue;

			// Call Row Updating event
			$bUpdateRow = $lsf_usage->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($lsf_usage->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($lsf_usage->CancelMessage <> "") {
					$this->setMessage($lsf_usage->CancelMessage);
					$lsf_usage->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$lsf_usage->Row_Updated($rsold, $rsnew);
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
