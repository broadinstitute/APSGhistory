<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "grpinfo.php" ?>
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
$grp_edit = new cgrp_edit();
$Page =& $grp_edit;

// Page init processing
$grp_edit->Page_Init();

// Page main processing
$grp_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var grp_edit = new ew_Page("grp_edit");

// page properties
grp_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = grp_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
grp_edit.ValidateForm = function(fobj) {
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
<p><span class="phpmaker">Edit TABLE: Grp<br><br>
<a href="<?php echo $grp->getReturnUrl() ?>">Go Back</a></span></p>
<?php $grp_edit->ShowMessage() ?>
<form name="fgrpedit" id="fgrpedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return grp_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="grp">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($grp->id->Visible) { // id ?>
	<tr<?php echo $grp->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $grp->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $grp->id->ViewAttributes() ?>><?php echo $grp->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($grp->id->CurrentValue) ?>">
</span><?php echo $grp->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($grp->name->Visible) { // name ?>
	<tr<?php echo $grp->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $grp->name->CellAttributes() ?>><span id="el_name">
<div<?php echo $grp->name->ViewAttributes() ?>><?php echo $grp->name->EditValue ?></div><input type="hidden" name="x_name" id="x_name" value="<?php echo ew_HtmlEncode($grp->name->CurrentValue) ?>">
</span><?php echo $grp->name->CustomMsg ?></td>
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
$grp_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class cgrp_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'grp';

	// Page Object Name
	var $PageObjName = 'grp_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $grp;
		if ($grp->UseTokenInUrl) $PageUrl .= "t=" . $grp->TableVar . "&"; // add page token
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
		global $objForm, $grp;
		if ($grp->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($grp->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($grp->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cgrp_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["grp"] = new cgrp();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'grp', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $grp;
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
		global $objForm, $gsFormError, $grp;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$grp->id->setQueryStringValue($_GET["id"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$grp->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$grp->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
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
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("grplist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$grp->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $grp->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$grp->RowType = EW_ROWTYPE_EDIT; // Render as edit
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $grp;
		$this->LoadRow();
		$grp->id->CurrentValue = $grp->id->FormValue;
		$grp->name->CurrentValue = $grp->name->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $grp;
		$sFilter = $grp->KeyFilter();

		// Call Row Selecting event
		$grp->Row_Selecting($sFilter);

		// Load sql based on filter
		$grp->CurrentFilter = $sFilter;
		$sSql = $grp->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$grp->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $grp;
		$grp->id->setDbValue($rs->fields('id'));
		$grp->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $grp;

		// Call Row_Rendering event
		$grp->Row_Rendering();

		// Common render codes for all row types
		// id

		$grp->id->CellCssStyle = "";
		$grp->id->CellCssClass = "";

		// name
		$grp->name->CellCssStyle = "";
		$grp->name->CellCssClass = "";
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

			// id
			$grp->id->HrefValue = "";

			// name
			$grp->name->HrefValue = "";
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

			// Edit refer script
			// id

			$grp->id->HrefValue = "";

			// name
			$grp->name->HrefValue = "";
		}

		// Call Row Rendered event
		$grp->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $grp;

		// Initialize
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
		global $conn, $Security, $grp;
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
					$this->setMessage("Update cancelled");
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
