<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cobjinfo.php" ?>
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
$cobj_edit = new ccobj_edit();
$Page =& $cobj_edit;

// Page init processing
$cobj_edit->Page_Init();

// Page main processing
$cobj_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cobj_edit = new ew_Page("cobj_edit");

// page properties
cobj_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = cobj_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
cobj_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_cid"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Cid");
		elm = fobj.elements["x" + infix + "_cid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Cid");
		elm = fobj.elements["x" + infix + "_class"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Class");
		elm = fobj.elements["x" + infix + "_name"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Name");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
cobj_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cobj_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cobj_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Cobj<br><br>
<a href="<?php echo $cobj->getReturnUrl() ?>">Go Back</a></span></p>
<?php $cobj_edit->ShowMessage() ?>
<form name="fcobjedit" id="fcobjedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return cobj_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="cobj">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cobj->cid->Visible) { // cid ?>
	<tr<?php echo $cobj->cid->RowAttributes ?>>
		<td class="ewTableHeader">Cid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $cobj->cid->CellAttributes() ?>><span id="el_cid">
<div<?php echo $cobj->cid->ViewAttributes() ?>><?php echo $cobj->cid->EditValue ?></div><input type="hidden" name="x_cid" id="x_cid" value="<?php echo ew_HtmlEncode($cobj->cid->CurrentValue) ?>">
</span><?php echo $cobj->cid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cobj->class->Visible) { // class ?>
	<tr<?php echo $cobj->class->RowAttributes ?>>
		<td class="ewTableHeader">Class<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $cobj->class->CellAttributes() ?>><span id="el_class">
<input type="text" name="x_class" id="x_class" size="30" maxlength="40" value="<?php echo $cobj->class->EditValue ?>"<?php echo $cobj->class->EditAttributes() ?>>
</span><?php echo $cobj->class->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cobj->name->Visible) { // name ?>
	<tr<?php echo $cobj->name->RowAttributes ?>>
		<td class="ewTableHeader">Name<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $cobj->name->CellAttributes() ?>><span id="el_name">
<input type="text" name="x_name" id="x_name" size="30" maxlength="60" value="<?php echo $cobj->name->EditValue ?>"<?php echo $cobj->name->EditAttributes() ?>>
</span><?php echo $cobj->name->CustomMsg ?></td>
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
$cobj_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class ccobj_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'cobj';

	// Page Object Name
	var $PageObjName = 'cobj_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cobj;
		if ($cobj->UseTokenInUrl) $PageUrl .= "t=" . $cobj->TableVar . "&"; // add page token
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
		global $objForm, $cobj;
		if ($cobj->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cobj->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cobj->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccobj_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["cobj"] = new ccobj();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cobj', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cobj;
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
		global $objForm, $gsFormError, $cobj;

		// Load key from QueryString
		if (@$_GET["cid"] <> "")
			$cobj->cid->setQueryStringValue($_GET["cid"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$cobj->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$cobj->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$cobj->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($cobj->cid->CurrentValue == "")
			$this->Page_Terminate("cobjlist.php"); // Invalid key, return to list
		switch ($cobj->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("cobjlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$cobj->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $cobj->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$cobj->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cobj;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cobj;
		$cobj->cid->setFormValue($objForm->GetValue("x_cid"));
		$cobj->class->setFormValue($objForm->GetValue("x_class"));
		$cobj->name->setFormValue($objForm->GetValue("x_name"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $cobj;
		$this->LoadRow();
		$cobj->cid->CurrentValue = $cobj->cid->FormValue;
		$cobj->class->CurrentValue = $cobj->class->FormValue;
		$cobj->name->CurrentValue = $cobj->name->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cobj;
		$sFilter = $cobj->KeyFilter();

		// Call Row Selecting event
		$cobj->Row_Selecting($sFilter);

		// Load sql based on filter
		$cobj->CurrentFilter = $sFilter;
		$sSql = $cobj->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cobj->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cobj;
		$cobj->cid->setDbValue($rs->fields('cid'));
		$cobj->class->setDbValue($rs->fields('class'));
		$cobj->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cobj;

		// Call Row_Rendering event
		$cobj->Row_Rendering();

		// Common render codes for all row types
		// cid

		$cobj->cid->CellCssStyle = "";
		$cobj->cid->CellCssClass = "";

		// class
		$cobj->class->CellCssStyle = "";
		$cobj->class->CellCssClass = "";

		// name
		$cobj->name->CellCssStyle = "";
		$cobj->name->CellCssClass = "";
		if ($cobj->RowType == EW_ROWTYPE_VIEW) { // View row

			// cid
			$cobj->cid->ViewValue = $cobj->cid->CurrentValue;
			$cobj->cid->CssStyle = "";
			$cobj->cid->CssClass = "";
			$cobj->cid->ViewCustomAttributes = "";

			// class
			$cobj->class->ViewValue = $cobj->class->CurrentValue;
			$cobj->class->CssStyle = "";
			$cobj->class->CssClass = "";
			$cobj->class->ViewCustomAttributes = "";

			// name
			$cobj->name->ViewValue = $cobj->name->CurrentValue;
			$cobj->name->CssStyle = "";
			$cobj->name->CssClass = "";
			$cobj->name->ViewCustomAttributes = "";

			// cid
			$cobj->cid->HrefValue = "";

			// class
			$cobj->class->HrefValue = "";

			// name
			$cobj->name->HrefValue = "";
		} elseif ($cobj->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// cid
			$cobj->cid->EditCustomAttributes = "";
			$cobj->cid->EditValue = $cobj->cid->CurrentValue;
			$cobj->cid->CssStyle = "";
			$cobj->cid->CssClass = "";
			$cobj->cid->ViewCustomAttributes = "";

			// class
			$cobj->class->EditCustomAttributes = "";
			$cobj->class->EditValue = ew_HtmlEncode($cobj->class->CurrentValue);

			// name
			$cobj->name->EditCustomAttributes = "";
			$cobj->name->EditValue = ew_HtmlEncode($cobj->name->CurrentValue);

			// Edit refer script
			// cid

			$cobj->cid->HrefValue = "";

			// class
			$cobj->class->HrefValue = "";

			// name
			$cobj->name->HrefValue = "";
		}

		// Call Row Rendered event
		$cobj->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $cobj;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($cobj->cid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Cid";
		}
		if (!ew_CheckInteger($cobj->cid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Cid";
		}
		if ($cobj->class->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Class";
		}
		if ($cobj->name->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Name";
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
		global $conn, $Security, $cobj;
		$sFilter = $cobj->KeyFilter();
		$cobj->CurrentFilter = $sFilter;
		$sSql = $cobj->SQL();
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

			// Field cid
			// Field class

			$cobj->class->SetDbValueDef($cobj->class->CurrentValue, "");
			$rsnew['class'] =& $cobj->class->DbValue;

			// Field name
			$cobj->name->SetDbValueDef($cobj->name->CurrentValue, "");
			$rsnew['name'] =& $cobj->name->DbValue;

			// Call Row Updating event
			$bUpdateRow = $cobj->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($cobj->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($cobj->CancelMessage <> "") {
					$this->setMessage($cobj->CancelMessage);
					$cobj->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$cobj->Row_Updated($rsold, $rsnew);
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
