<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "ge_usageinfo.php" ?>
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
$ge_usage_edit = new cge_usage_edit();
$Page =& $ge_usage_edit;

// Page init processing
$ge_usage_edit->Page_Init();

// Page main processing
$ge_usage_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var ge_usage_edit = new ew_Page("ge_usage_edit");

// page properties
ge_usage_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = ge_usage_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
ge_usage_edit.ValidateForm = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_pid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Pid");
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
ge_usage_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_usage_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_usage_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Ge Usage<br><br>
<a href="<?php echo $ge_usage->getReturnUrl() ?>">Go Back</a></span></p>
<?php $ge_usage_edit->ShowMessage() ?>
<form name="fge_usageedit" id="fge_usageedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ge_usage_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="ge_usage">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ge_usage->date->Visible) { // date ?>
	<tr<?php echo $ge_usage->date->RowAttributes ?>>
		<td class="ewTableHeader">Date<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $ge_usage->date->CellAttributes() ?>><span id="el_date">
<div<?php echo $ge_usage->date->ViewAttributes() ?>><?php echo $ge_usage->date->EditValue ?></div><input type="hidden" name="x_date" id="x_date" value="<?php echo ew_HtmlEncode($ge_usage->date->CurrentValue) ?>">
</span><?php echo $ge_usage->date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->uid->Visible) { // uid ?>
	<tr<?php echo $ge_usage->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $ge_usage->uid->CellAttributes() ?>><span id="el_uid">
<div<?php echo $ge_usage->uid->ViewAttributes() ?>><?php echo $ge_usage->uid->EditValue ?></div><input type="hidden" name="x_uid" id="x_uid" value="<?php echo ew_HtmlEncode($ge_usage->uid->CurrentValue) ?>">
</span><?php echo $ge_usage->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->qid->Visible) { // qid ?>
	<tr<?php echo $ge_usage->qid->RowAttributes ?>>
		<td class="ewTableHeader">Qid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $ge_usage->qid->CellAttributes() ?>><span id="el_qid">
<div<?php echo $ge_usage->qid->ViewAttributes() ?>><?php echo $ge_usage->qid->EditValue ?></div><input type="hidden" name="x_qid" id="x_qid" value="<?php echo ew_HtmlEncode($ge_usage->qid->CurrentValue) ?>">
</span><?php echo $ge_usage->qid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->pid->Visible) { // pid ?>
	<tr<?php echo $ge_usage->pid->RowAttributes ?>>
		<td class="ewTableHeader">Pid</td>
		<td<?php echo $ge_usage->pid->CellAttributes() ?>><span id="el_pid">
<input type="text" name="x_pid" id="x_pid" size="30" value="<?php echo $ge_usage->pid->EditValue ?>"<?php echo $ge_usage->pid->EditAttributes() ?>>
</span><?php echo $ge_usage->pid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->cpu->Visible) { // cpu ?>
	<tr<?php echo $ge_usage->cpu->RowAttributes ?>>
		<td class="ewTableHeader">Cpu</td>
		<td<?php echo $ge_usage->cpu->CellAttributes() ?>><span id="el_cpu">
<input type="text" name="x_cpu" id="x_cpu" size="30" value="<?php echo $ge_usage->cpu->EditValue ?>"<?php echo $ge_usage->cpu->EditAttributes() ?>>
</span><?php echo $ge_usage->cpu->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->job->Visible) { // job ?>
	<tr<?php echo $ge_usage->job->RowAttributes ?>>
		<td class="ewTableHeader">Job</td>
		<td<?php echo $ge_usage->job->CellAttributes() ?>><span id="el_job">
<input type="text" name="x_job" id="x_job" size="30" value="<?php echo $ge_usage->job->EditValue ?>"<?php echo $ge_usage->job->EditAttributes() ?>>
</span><?php echo $ge_usage->job->CustomMsg ?></td>
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
$ge_usage_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_usage_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'ge_usage';

	// Page Object Name
	var $PageObjName = 'ge_usage_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ge_usage;
		if ($ge_usage->UseTokenInUrl) $PageUrl .= "t=" . $ge_usage->TableVar . "&"; // add page token
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
		global $objForm, $ge_usage;
		if ($ge_usage->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($ge_usage->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ge_usage->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cge_usage_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_usage"] = new cge_usage();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ge_usage', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ge_usage;
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
		global $objForm, $gsFormError, $ge_usage;

		// Load key from QueryString
		if (@$_GET["date"] <> "")
			$ge_usage->date->setQueryStringValue($_GET["date"]);
		if (@$_GET["uid"] <> "")
			$ge_usage->uid->setQueryStringValue($_GET["uid"]);
		if (@$_GET["qid"] <> "")
			$ge_usage->qid->setQueryStringValue($_GET["qid"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$ge_usage->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$ge_usage->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$ge_usage->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($ge_usage->date->CurrentValue == "")
			$this->Page_Terminate("ge_usagelist.php"); // Invalid key, return to list
		if ($ge_usage->uid->CurrentValue == "")
			$this->Page_Terminate("ge_usagelist.php"); // Invalid key, return to list
		if ($ge_usage->qid->CurrentValue == "")
			$this->Page_Terminate("ge_usagelist.php"); // Invalid key, return to list
		switch ($ge_usage->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("ge_usagelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$ge_usage->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $ge_usage->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$ge_usage->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $ge_usage;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $ge_usage;
		$ge_usage->date->setFormValue($objForm->GetValue("x_date"));
		$ge_usage->uid->setFormValue($objForm->GetValue("x_uid"));
		$ge_usage->qid->setFormValue($objForm->GetValue("x_qid"));
		$ge_usage->pid->setFormValue($objForm->GetValue("x_pid"));
		$ge_usage->cpu->setFormValue($objForm->GetValue("x_cpu"));
		$ge_usage->job->setFormValue($objForm->GetValue("x_job"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $ge_usage;
		$this->LoadRow();
		$ge_usage->date->CurrentValue = $ge_usage->date->FormValue;
		$ge_usage->uid->CurrentValue = $ge_usage->uid->FormValue;
		$ge_usage->qid->CurrentValue = $ge_usage->qid->FormValue;
		$ge_usage->pid->CurrentValue = $ge_usage->pid->FormValue;
		$ge_usage->cpu->CurrentValue = $ge_usage->cpu->FormValue;
		$ge_usage->job->CurrentValue = $ge_usage->job->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ge_usage;
		$sFilter = $ge_usage->KeyFilter();

		// Call Row Selecting event
		$ge_usage->Row_Selecting($sFilter);

		// Load sql based on filter
		$ge_usage->CurrentFilter = $sFilter;
		$sSql = $ge_usage->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$ge_usage->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $ge_usage;
		$ge_usage->date->setDbValue($rs->fields('date'));
		$ge_usage->uid->setDbValue($rs->fields('uid'));
		$ge_usage->qid->setDbValue($rs->fields('qid'));
		$ge_usage->pid->setDbValue($rs->fields('pid'));
		$ge_usage->cpu->setDbValue($rs->fields('cpu'));
		$ge_usage->job->setDbValue($rs->fields('job'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $ge_usage;

		// Call Row_Rendering event
		$ge_usage->Row_Rendering();

		// Common render codes for all row types
		// date

		$ge_usage->date->CellCssStyle = "";
		$ge_usage->date->CellCssClass = "";

		// uid
		$ge_usage->uid->CellCssStyle = "";
		$ge_usage->uid->CellCssClass = "";

		// qid
		$ge_usage->qid->CellCssStyle = "";
		$ge_usage->qid->CellCssClass = "";

		// pid
		$ge_usage->pid->CellCssStyle = "";
		$ge_usage->pid->CellCssClass = "";

		// cpu
		$ge_usage->cpu->CellCssStyle = "";
		$ge_usage->cpu->CellCssClass = "";

		// job
		$ge_usage->job->CellCssStyle = "";
		$ge_usage->job->CellCssClass = "";
		if ($ge_usage->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$ge_usage->date->ViewValue = $ge_usage->date->CurrentValue;
			$ge_usage->date->CssStyle = "";
			$ge_usage->date->CssClass = "";
			$ge_usage->date->ViewCustomAttributes = "";

			// uid
			$ge_usage->uid->ViewValue = $ge_usage->uid->CurrentValue;
			$ge_usage->uid->CssStyle = "";
			$ge_usage->uid->CssClass = "";
			$ge_usage->uid->ViewCustomAttributes = "";

			// qid
			$ge_usage->qid->ViewValue = $ge_usage->qid->CurrentValue;
			$ge_usage->qid->CssStyle = "";
			$ge_usage->qid->CssClass = "";
			$ge_usage->qid->ViewCustomAttributes = "";

			// pid
			$ge_usage->pid->ViewValue = $ge_usage->pid->CurrentValue;
			$ge_usage->pid->CssStyle = "";
			$ge_usage->pid->CssClass = "";
			$ge_usage->pid->ViewCustomAttributes = "";

			// cpu
			$ge_usage->cpu->ViewValue = $ge_usage->cpu->CurrentValue;
			$ge_usage->cpu->CssStyle = "";
			$ge_usage->cpu->CssClass = "";
			$ge_usage->cpu->ViewCustomAttributes = "";

			// job
			$ge_usage->job->ViewValue = $ge_usage->job->CurrentValue;
			$ge_usage->job->CssStyle = "";
			$ge_usage->job->CssClass = "";
			$ge_usage->job->ViewCustomAttributes = "";

			// date
			$ge_usage->date->HrefValue = "";

			// uid
			$ge_usage->uid->HrefValue = "";

			// qid
			$ge_usage->qid->HrefValue = "";

			// pid
			$ge_usage->pid->HrefValue = "";

			// cpu
			$ge_usage->cpu->HrefValue = "";

			// job
			$ge_usage->job->HrefValue = "";
		} elseif ($ge_usage->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// date
			$ge_usage->date->EditCustomAttributes = "";
			$ge_usage->date->EditValue = $ge_usage->date->CurrentValue;
			$ge_usage->date->CssStyle = "";
			$ge_usage->date->CssClass = "";
			$ge_usage->date->ViewCustomAttributes = "";

			// uid
			$ge_usage->uid->EditCustomAttributes = "";
			$ge_usage->uid->EditValue = $ge_usage->uid->CurrentValue;
			$ge_usage->uid->CssStyle = "";
			$ge_usage->uid->CssClass = "";
			$ge_usage->uid->ViewCustomAttributes = "";

			// qid
			$ge_usage->qid->EditCustomAttributes = "";
			$ge_usage->qid->EditValue = $ge_usage->qid->CurrentValue;
			$ge_usage->qid->CssStyle = "";
			$ge_usage->qid->CssClass = "";
			$ge_usage->qid->ViewCustomAttributes = "";

			// pid
			$ge_usage->pid->EditCustomAttributes = "";
			$ge_usage->pid->EditValue = ew_HtmlEncode($ge_usage->pid->CurrentValue);

			// cpu
			$ge_usage->cpu->EditCustomAttributes = "";
			$ge_usage->cpu->EditValue = ew_HtmlEncode($ge_usage->cpu->CurrentValue);

			// job
			$ge_usage->job->EditCustomAttributes = "";
			$ge_usage->job->EditValue = ew_HtmlEncode($ge_usage->job->CurrentValue);

			// Edit refer script
			// date

			$ge_usage->date->HrefValue = "";

			// uid
			$ge_usage->uid->HrefValue = "";

			// qid
			$ge_usage->qid->HrefValue = "";

			// pid
			$ge_usage->pid->HrefValue = "";

			// cpu
			$ge_usage->cpu->HrefValue = "";

			// job
			$ge_usage->job->HrefValue = "";
		}

		// Call Row Rendered event
		$ge_usage->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $ge_usage;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($ge_usage->date->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Date";
		}
		if (!ew_CheckInteger($ge_usage->date->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Date";
		}
		if ($ge_usage->uid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Uid";
		}
		if (!ew_CheckInteger($ge_usage->uid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Uid";
		}
		if ($ge_usage->qid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Qid";
		}
		if (!ew_CheckInteger($ge_usage->qid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Qid";
		}
		if (!ew_CheckInteger($ge_usage->pid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Pid";
		}
		if (!ew_CheckNumber($ge_usage->cpu->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect floating point number - Cpu";
		}
		if (!ew_CheckNumber($ge_usage->job->FormValue)) {
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
		global $conn, $Security, $ge_usage;
		$sFilter = $ge_usage->KeyFilter();
		$ge_usage->CurrentFilter = $sFilter;
		$sSql = $ge_usage->SQL();
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
			// Field pid

			$ge_usage->pid->SetDbValueDef($ge_usage->pid->CurrentValue, NULL);
			$rsnew['pid'] =& $ge_usage->pid->DbValue;

			// Field cpu
			$ge_usage->cpu->SetDbValueDef($ge_usage->cpu->CurrentValue, NULL);
			$rsnew['cpu'] =& $ge_usage->cpu->DbValue;

			// Field job
			$ge_usage->job->SetDbValueDef($ge_usage->job->CurrentValue, NULL);
			$rsnew['job'] =& $ge_usage->job->DbValue;

			// Call Row Updating event
			$bUpdateRow = $ge_usage->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($ge_usage->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($ge_usage->CancelMessage <> "") {
					$this->setMessage($ge_usage->CancelMessage);
					$ge_usage->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$ge_usage->Row_Updated($rsold, $rsnew);
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
