<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "bjobsinfo.php" ?>
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
$bjobs_edit = new cbjobs_edit();
$Page =& $bjobs_edit;

// Page init processing
$bjobs_edit->Page_Init();

// Page main processing
$bjobs_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var bjobs_edit = new ew_Page("bjobs_edit");

// page properties
bjobs_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = bjobs_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
bjobs_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_checked"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Checked");
		elm = fobj.elements["x" + infix + "_checked"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Checked");
		elm = fobj.elements["x" + infix + "_jobslots"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Jobslots");
		elm = fobj.elements["x" + infix + "_bjobs"];
		aelm = fobj.elements["a" + infix + "_bjobs"];
		var chk_bjobs = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_bjobs && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Bjobs");
		elm = fobj.elements["x" + infix + "_bjobs"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, "File type is not allowed.");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
bjobs_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
bjobs_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
bjobs_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Bjobs<br><br>
<a href="<?php echo $bjobs->getReturnUrl() ?>">Go Back</a></span></p>
<?php $bjobs_edit->ShowMessage() ?>
<form name="fbjobsedit" id="fbjobsedit" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return bjobs_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="bjobs">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($bjobs->checked->Visible) { // checked ?>
	<tr<?php echo $bjobs->checked->RowAttributes ?>>
		<td class="ewTableHeader">Checked<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $bjobs->checked->CellAttributes() ?>><span id="el_checked">
<div<?php echo $bjobs->checked->ViewAttributes() ?>><?php echo $bjobs->checked->EditValue ?></div><input type="hidden" name="x_checked" id="x_checked" value="<?php echo ew_HtmlEncode($bjobs->checked->CurrentValue) ?>">
</span><?php echo $bjobs->checked->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($bjobs->jobslots->Visible) { // jobslots ?>
	<tr<?php echo $bjobs->jobslots->RowAttributes ?>>
		<td class="ewTableHeader">Jobslots</td>
		<td<?php echo $bjobs->jobslots->CellAttributes() ?>><span id="el_jobslots">
<input type="text" name="x_jobslots" id="x_jobslots" size="30" value="<?php echo $bjobs->jobslots->EditValue ?>"<?php echo $bjobs->jobslots->EditAttributes() ?>>
</span><?php echo $bjobs->jobslots->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($bjobs->bjobs->Visible) { // bjobs ?>
	<tr<?php echo $bjobs->bjobs->RowAttributes ?>>
		<td class="ewTableHeader">Bjobs<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $bjobs->bjobs->CellAttributes() ?>><span id="el_bjobs">
<div id="old_x_bjobs">
<?php if ($bjobs->bjobs->HrefValue <> "") { ?>
<?php if (!is_null($bjobs->bjobs->Upload->DbValue)) { ?>
<a href="<?php echo $bjobs->bjobs->HrefValue ?>" target="_blank"><?php echo $bjobs->bjobs->EditValue ?></a>
<?php } elseif (!in_array($bjobs->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!is_null($bjobs->bjobs->Upload->DbValue)) { ?>
<?php echo $bjobs->bjobs->EditValue ?>
<?php } elseif (!in_array($bjobs->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_bjobs">
<?php if (!is_null($bjobs->bjobs->Upload->DbValue)) { ?>
<input type="radio" name="a_bjobs" id="a_bjobs" value="1" checked="checked">Keep&nbsp;
<input type="radio" name="a_bjobs" id="a_bjobs" value="2" disabled="disabled">Remove&nbsp;
<input type="radio" name="a_bjobs" id="a_bjobs" value="3">Replace<br>
<?php } else { ?>
<input type="hidden" name="a_bjobs" id="a_bjobs" value="3">
<?php } ?>
<input type="file" name="x_bjobs" id="x_bjobs" size="30" onchange="if (this.form.a_bjobs[2]) this.form.a_bjobs[2].checked=true;"<?php echo $bjobs->bjobs->EditAttributes() ?>>
</div>
</span><?php echo $bjobs->bjobs->CustomMsg ?></td>
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
$bjobs_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class cbjobs_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'bjobs';

	// Page Object Name
	var $PageObjName = 'bjobs_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $bjobs;
		if ($bjobs->UseTokenInUrl) $PageUrl .= "t=" . $bjobs->TableVar . "&"; // add page token
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
		global $objForm, $bjobs;
		if ($bjobs->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($bjobs->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($bjobs->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cbjobs_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["bjobs"] = new cbjobs();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'bjobs', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $bjobs;
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
		global $objForm, $gsFormError, $bjobs;

		// Load key from QueryString
		if (@$_GET["checked"] <> "")
			$bjobs->checked->setQueryStringValue($_GET["checked"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$bjobs->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->GetUploadFiles(); // Get upload files
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$bjobs->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$bjobs->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($bjobs->checked->CurrentValue == "")
			$this->Page_Terminate("bjobslist.php"); // Invalid key, return to list
		switch ($bjobs->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("bjobslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$bjobs->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $bjobs->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$bjobs->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $bjobs;

		// Get upload data
			if ($bjobs->bjobs->Upload->UploadFile()) {

				// No action required
			} else {
				echo $bjobs->bjobs->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $bjobs;
		$bjobs->checked->setFormValue($objForm->GetValue("x_checked"));
		$bjobs->jobslots->setFormValue($objForm->GetValue("x_jobslots"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $bjobs;
		$this->LoadRow();
		$bjobs->checked->CurrentValue = $bjobs->checked->FormValue;
		$bjobs->jobslots->CurrentValue = $bjobs->jobslots->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $bjobs;
		$sFilter = $bjobs->KeyFilter();

		// Call Row Selecting event
		$bjobs->Row_Selecting($sFilter);

		// Load sql based on filter
		$bjobs->CurrentFilter = $sFilter;
		$sSql = $bjobs->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$bjobs->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $bjobs;
		$bjobs->checked->setDbValue($rs->fields('checked'));
		$bjobs->jobslots->setDbValue($rs->fields('jobslots'));
		$bjobs->bjobs->Upload->DbValue = $rs->fields('bjobs');
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $bjobs;

		// Call Row_Rendering event
		$bjobs->Row_Rendering();

		// Common render codes for all row types
		// checked

		$bjobs->checked->CellCssStyle = "";
		$bjobs->checked->CellCssClass = "";

		// jobslots
		$bjobs->jobslots->CellCssStyle = "";
		$bjobs->jobslots->CellCssClass = "";

		// bjobs
		$bjobs->bjobs->CellCssStyle = "";
		$bjobs->bjobs->CellCssClass = "";
		if ($bjobs->RowType == EW_ROWTYPE_VIEW) { // View row

			// checked
			$bjobs->checked->ViewValue = $bjobs->checked->CurrentValue;
			$bjobs->checked->CssStyle = "";
			$bjobs->checked->CssClass = "";
			$bjobs->checked->ViewCustomAttributes = "";

			// jobslots
			$bjobs->jobslots->ViewValue = $bjobs->jobslots->CurrentValue;
			$bjobs->jobslots->CssStyle = "";
			$bjobs->jobslots->CssClass = "";
			$bjobs->jobslots->ViewCustomAttributes = "";

			// bjobs
			if (!is_null($bjobs->bjobs->Upload->DbValue)) {
				$bjobs->bjobs->ViewValue = "Bjobs";
			} else {
				$bjobs->bjobs->ViewValue = "";
			}
			$bjobs->bjobs->CssStyle = "";
			$bjobs->bjobs->CssClass = "";
			$bjobs->bjobs->ViewCustomAttributes = "";

			// checked
			$bjobs->checked->HrefValue = "";

			// jobslots
			$bjobs->jobslots->HrefValue = "";

			// bjobs
			if (!is_null($bjobs->bjobs->Upload->DbValue)) {
				$bjobs->bjobs->HrefValue = "bjobs_bjobs_bv.php?checked=" . $bjobs->checked->CurrentValue;
				if ($bjobs->Export <> "") $bjobs->bjobs->HrefValue = ew_ConvertFullUrl($bjobs->bjobs->HrefValue);
			} else {
				$bjobs->bjobs->HrefValue = "";
			}
		} elseif ($bjobs->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// checked
			$bjobs->checked->EditCustomAttributes = "";
			$bjobs->checked->EditValue = $bjobs->checked->CurrentValue;
			$bjobs->checked->CssStyle = "";
			$bjobs->checked->CssClass = "";
			$bjobs->checked->ViewCustomAttributes = "";

			// jobslots
			$bjobs->jobslots->EditCustomAttributes = "";
			$bjobs->jobslots->EditValue = ew_HtmlEncode($bjobs->jobslots->CurrentValue);

			// bjobs
			$bjobs->bjobs->EditCustomAttributes = "";
			if (!is_null($bjobs->bjobs->Upload->DbValue)) {
				$bjobs->bjobs->EditValue = "Bjobs";
			} else {
				$bjobs->bjobs->EditValue = "";
			}

			// Edit refer script
			// checked

			$bjobs->checked->HrefValue = "";

			// jobslots
			$bjobs->jobslots->HrefValue = "";

			// bjobs
			if (!is_null($bjobs->bjobs->Upload->DbValue)) {
				$bjobs->bjobs->HrefValue = "bjobs_bjobs_bv.php?checked=" . $bjobs->checked->CurrentValue;
				if ($bjobs->Export <> "") $bjobs->bjobs->HrefValue = ew_ConvertFullUrl($bjobs->bjobs->HrefValue);
			} else {
				$bjobs->bjobs->HrefValue = "";
			}
		}

		// Call Row Rendered event
		$bjobs->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $bjobs;

		// Initialize
		$gsFormError = "";
		if (!ew_CheckFileType($bjobs->bjobs->Upload->FileName)) {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "File type is not allowed.";
		}
		if ($bjobs->bjobs->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0) {
			if ($bjobs->bjobs->Upload->FileSize > EW_MAX_FILE_SIZE)
				$gsFormError .= str_replace("%s", EW_MAX_FILE_SIZE, "Max. file size (%s bytes) exceeded.");
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($bjobs->checked->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Checked";
		}
		if (!ew_CheckInteger($bjobs->checked->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Checked";
		}
		if (!ew_CheckInteger($bjobs->jobslots->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Jobslots";
		}
		if ($bjobs->bjobs->Upload->Action == "3" && is_null($bjobs->bjobs->Upload->Value)) {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Bjobs";
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
		global $conn, $Security, $bjobs;
		$sFilter = $bjobs->KeyFilter();
		$bjobs->CurrentFilter = $sFilter;
		$sSql = $bjobs->SQL();
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

			// Field checked
			// Field jobslots

			$bjobs->jobslots->SetDbValueDef($bjobs->jobslots->CurrentValue, NULL);
			$rsnew['jobslots'] =& $bjobs->jobslots->DbValue;

			// Field bjobs
			$bjobs->bjobs->Upload->SaveToSession(); // Save file value to Session
						if ($bjobs->bjobs->Upload->Action == "2" || $bjobs->bjobs->Upload->Action == "3") { // Update/Remove
			if (is_null($bjobs->bjobs->Upload->Value)) {
				$rsnew['bjobs'] = NULL;	
			} else {
				$rsnew['bjobs'] = $bjobs->bjobs->Upload->Value;
			}
			}

			// Call Row Updating event
			$bUpdateRow = $bjobs->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {

			// Field bjobs
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($bjobs->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($bjobs->CancelMessage <> "") {
					$this->setMessage($bjobs->CancelMessage);
					$bjobs->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$bjobs->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// Field bjobs
		$bjobs->bjobs->Upload->RemoveFromSession(); // Remove file value from Session
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
