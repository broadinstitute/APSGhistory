<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "stat_typeinfo.php" ?>
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
$stat_type_edit = new cstat_type_edit();
$Page =& $stat_type_edit;

// Page init processing
$stat_type_edit->Page_Init();

// Page main processing
$stat_type_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var stat_type_edit = new ew_Page("stat_type_edit");

// page properties
stat_type_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = stat_type_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
stat_type_edit.ValidateForm = function(fobj) {
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

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
stat_type_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
stat_type_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
stat_type_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Stat Type<br><br>
<a href="<?php echo $stat_type->getReturnUrl() ?>">Go Back</a></span></p>
<?php $stat_type_edit->ShowMessage() ?>
<form name="fstat_typeedit" id="fstat_typeedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return stat_type_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="stat_type">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($stat_type->id->Visible) { // id ?>
	<tr<?php echo $stat_type->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $stat_type->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $stat_type->id->ViewAttributes() ?>><?php echo $stat_type->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($stat_type->id->CurrentValue) ?>">
</span><?php echo $stat_type->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($stat_type->name->Visible) { // name ?>
	<tr<?php echo $stat_type->name->RowAttributes ?>>
		<td class="ewTableHeader">Name<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $stat_type->name->CellAttributes() ?>><span id="el_name">
<input type="text" name="x_name" id="x_name" size="30" maxlength="45" value="<?php echo $stat_type->name->EditValue ?>"<?php echo $stat_type->name->EditAttributes() ?>>
</span><?php echo $stat_type->name->CustomMsg ?></td>
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
$stat_type_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class cstat_type_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'stat_type';

	// Page Object Name
	var $PageObjName = 'stat_type_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $stat_type;
		if ($stat_type->UseTokenInUrl) $PageUrl .= "t=" . $stat_type->TableVar . "&"; // add page token
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
		global $objForm, $stat_type;
		if ($stat_type->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($stat_type->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($stat_type->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cstat_type_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["stat_type"] = new cstat_type();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'stat_type', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $stat_type;
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
		global $objForm, $gsFormError, $stat_type;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$stat_type->id->setQueryStringValue($_GET["id"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$stat_type->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$stat_type->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$stat_type->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($stat_type->id->CurrentValue == "")
			$this->Page_Terminate("stat_typelist.php"); // Invalid key, return to list
		switch ($stat_type->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("stat_typelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$stat_type->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $stat_type->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$stat_type->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $stat_type;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $stat_type;
		$stat_type->id->setFormValue($objForm->GetValue("x_id"));
		$stat_type->name->setFormValue($objForm->GetValue("x_name"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $stat_type;
		$this->LoadRow();
		$stat_type->id->CurrentValue = $stat_type->id->FormValue;
		$stat_type->name->CurrentValue = $stat_type->name->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $stat_type;
		$sFilter = $stat_type->KeyFilter();

		// Call Row Selecting event
		$stat_type->Row_Selecting($sFilter);

		// Load sql based on filter
		$stat_type->CurrentFilter = $sFilter;
		$sSql = $stat_type->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$stat_type->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $stat_type;
		$stat_type->id->setDbValue($rs->fields('id'));
		$stat_type->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $stat_type;

		// Call Row_Rendering event
		$stat_type->Row_Rendering();

		// Common render codes for all row types
		// id

		$stat_type->id->CellCssStyle = "";
		$stat_type->id->CellCssClass = "";

		// name
		$stat_type->name->CellCssStyle = "";
		$stat_type->name->CellCssClass = "";
		if ($stat_type->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$stat_type->id->ViewValue = $stat_type->id->CurrentValue;
			$stat_type->id->CssStyle = "";
			$stat_type->id->CssClass = "";
			$stat_type->id->ViewCustomAttributes = "";

			// name
			$stat_type->name->ViewValue = $stat_type->name->CurrentValue;
			$stat_type->name->CssStyle = "";
			$stat_type->name->CssClass = "";
			$stat_type->name->ViewCustomAttributes = "";

			// id
			$stat_type->id->HrefValue = "";

			// name
			$stat_type->name->HrefValue = "";
		} elseif ($stat_type->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$stat_type->id->EditCustomAttributes = "";
			$stat_type->id->EditValue = $stat_type->id->CurrentValue;
			$stat_type->id->CssStyle = "";
			$stat_type->id->CssClass = "";
			$stat_type->id->ViewCustomAttributes = "";

			// name
			$stat_type->name->EditCustomAttributes = "";
			$stat_type->name->EditValue = ew_HtmlEncode($stat_type->name->CurrentValue);

			// Edit refer script
			// id

			$stat_type->id->HrefValue = "";

			// name
			$stat_type->name->HrefValue = "";
		}

		// Call Row Rendered event
		$stat_type->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $stat_type;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($stat_type->name->FormValue == "") {
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
		global $conn, $Security, $stat_type;
		$sFilter = $stat_type->KeyFilter();
		$stat_type->CurrentFilter = $sFilter;
		$sSql = $stat_type->SQL();
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

			$stat_type->name->SetDbValueDef($stat_type->name->CurrentValue, "");
			$rsnew['name'] =& $stat_type->name->DbValue;

			// Call Row Updating event
			$bUpdateRow = $stat_type->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($stat_type->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($stat_type->CancelMessage <> "") {
					$this->setMessage($stat_type->CancelMessage);
					$stat_type->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$stat_type->Row_Updated($rsold, $rsnew);
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
