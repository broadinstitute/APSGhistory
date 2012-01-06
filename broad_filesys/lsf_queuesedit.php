<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_queuesinfo.php" ?>
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
$lsf_queues_edit = new clsf_queues_edit();
$Page =& $lsf_queues_edit;

// Page init processing
$lsf_queues_edit->Page_Init();

// Page main processing
$lsf_queues_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_queues_edit = new ew_Page("lsf_queues_edit");

// page properties
lsf_queues_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = lsf_queues_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
lsf_queues_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_name"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Name");
		elm = fobj.elements["x" + infix + "_gid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Gid");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
lsf_queues_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_queues_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_queues_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Lsf Queues<br><br>
<a href="<?php echo $lsf_queues->getReturnUrl() ?>">Go Back</a></span></p>
<?php $lsf_queues_edit->ShowMessage() ?>
<form name="flsf_queuesedit" id="flsf_queuesedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return lsf_queues_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="lsf_queues">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lsf_queues->id->Visible) { // id ?>
	<tr<?php echo $lsf_queues->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $lsf_queues->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $lsf_queues->id->ViewAttributes() ?>><?php echo $lsf_queues->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($lsf_queues->id->CurrentValue) ?>">
</span><?php echo $lsf_queues->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_queues->name->Visible) { // name ?>
	<tr<?php echo $lsf_queues->name->RowAttributes ?>>
		<td class="ewTableHeader">Name<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $lsf_queues->name->CellAttributes() ?>><span id="el_name">
<input type="text" name="x_name" id="x_name" size="30" maxlength="45" value="<?php echo $lsf_queues->name->EditValue ?>"<?php echo $lsf_queues->name->EditAttributes() ?>>
</span><?php echo $lsf_queues->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_queues->gid->Visible) { // gid ?>
	<tr<?php echo $lsf_queues->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $lsf_queues->gid->CellAttributes() ?>><span id="el_gid">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $lsf_queues->gid->EditValue ?>"<?php echo $lsf_queues->gid->EditAttributes() ?>>
</span><?php echo $lsf_queues->gid->CustomMsg ?></td>
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
$lsf_queues_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_queues_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'lsf_queues';

	// Page Object Name
	var $PageObjName = 'lsf_queues_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_queues;
		if ($lsf_queues->UseTokenInUrl) $PageUrl .= "t=" . $lsf_queues->TableVar . "&"; // add page token
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
		global $objForm, $lsf_queues;
		if ($lsf_queues->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_queues->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_queues->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_queues_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_queues"] = new clsf_queues();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_queues', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_queues;
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
		global $objForm, $gsFormError, $lsf_queues;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$lsf_queues->id->setQueryStringValue($_GET["id"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$lsf_queues->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$lsf_queues->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$lsf_queues->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($lsf_queues->id->CurrentValue == "")
			$this->Page_Terminate("lsf_queueslist.php"); // Invalid key, return to list
		switch ($lsf_queues->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("lsf_queueslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$lsf_queues->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $lsf_queues->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$lsf_queues->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $lsf_queues;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $lsf_queues;
		$lsf_queues->id->setFormValue($objForm->GetValue("x_id"));
		$lsf_queues->name->setFormValue($objForm->GetValue("x_name"));
		$lsf_queues->gid->setFormValue($objForm->GetValue("x_gid"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $lsf_queues;
		$this->LoadRow();
		$lsf_queues->id->CurrentValue = $lsf_queues->id->FormValue;
		$lsf_queues->name->CurrentValue = $lsf_queues->name->FormValue;
		$lsf_queues->gid->CurrentValue = $lsf_queues->gid->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_queues;
		$sFilter = $lsf_queues->KeyFilter();

		// Call Row Selecting event
		$lsf_queues->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_queues->CurrentFilter = $sFilter;
		$sSql = $lsf_queues->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_queues->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_queues;
		$lsf_queues->id->setDbValue($rs->fields('id'));
		$lsf_queues->name->setDbValue($rs->fields('name'));
		$lsf_queues->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_queues;

		// Call Row_Rendering event
		$lsf_queues->Row_Rendering();

		// Common render codes for all row types
		// id

		$lsf_queues->id->CellCssStyle = "";
		$lsf_queues->id->CellCssClass = "";

		// name
		$lsf_queues->name->CellCssStyle = "";
		$lsf_queues->name->CellCssClass = "";

		// gid
		$lsf_queues->gid->CellCssStyle = "";
		$lsf_queues->gid->CellCssClass = "";
		if ($lsf_queues->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$lsf_queues->id->ViewValue = $lsf_queues->id->CurrentValue;
			$lsf_queues->id->CssStyle = "";
			$lsf_queues->id->CssClass = "";
			$lsf_queues->id->ViewCustomAttributes = "";

			// name
			$lsf_queues->name->ViewValue = $lsf_queues->name->CurrentValue;
			$lsf_queues->name->CssStyle = "";
			$lsf_queues->name->CssClass = "";
			$lsf_queues->name->ViewCustomAttributes = "";

			// gid
			$lsf_queues->gid->ViewValue = $lsf_queues->gid->CurrentValue;
			$lsf_queues->gid->CssStyle = "";
			$lsf_queues->gid->CssClass = "";
			$lsf_queues->gid->ViewCustomAttributes = "";

			// id
			$lsf_queues->id->HrefValue = "";

			// name
			$lsf_queues->name->HrefValue = "";

			// gid
			$lsf_queues->gid->HrefValue = "";
		} elseif ($lsf_queues->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$lsf_queues->id->EditCustomAttributes = "";
			$lsf_queues->id->EditValue = $lsf_queues->id->CurrentValue;
			$lsf_queues->id->CssStyle = "";
			$lsf_queues->id->CssClass = "";
			$lsf_queues->id->ViewCustomAttributes = "";

			// name
			$lsf_queues->name->EditCustomAttributes = "";
			$lsf_queues->name->EditValue = ew_HtmlEncode($lsf_queues->name->CurrentValue);

			// gid
			$lsf_queues->gid->EditCustomAttributes = "";
			$lsf_queues->gid->EditValue = ew_HtmlEncode($lsf_queues->gid->CurrentValue);

			// Edit refer script
			// id

			$lsf_queues->id->HrefValue = "";

			// name
			$lsf_queues->name->HrefValue = "";

			// gid
			$lsf_queues->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_queues->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $lsf_queues;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($lsf_queues->name->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Name";
		}
		if (!ew_CheckInteger($lsf_queues->gid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Gid";
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
		global $conn, $Security, $lsf_queues;
		$sFilter = $lsf_queues->KeyFilter();
		$lsf_queues->CurrentFilter = $sFilter;
		$sSql = $lsf_queues->SQL();
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

			// Field id
			// Field name

			$lsf_queues->name->SetDbValueDef($lsf_queues->name->CurrentValue, "");
			$rsnew['name'] =& $lsf_queues->name->DbValue;

			// Field gid
			$lsf_queues->gid->SetDbValueDef($lsf_queues->gid->CurrentValue, NULL);
			$rsnew['gid'] =& $lsf_queues->gid->DbValue;

			// Call Row Updating event
			$bUpdateRow = $lsf_queues->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($lsf_queues->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($lsf_queues->CancelMessage <> "") {
					$this->setMessage($lsf_queues->CancelMessage);
					$lsf_queues->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$lsf_queues->Row_Updated($rsold, $rsnew);
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
