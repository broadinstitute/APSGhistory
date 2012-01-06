<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_projectsinfo.php" ?>
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
$lsf_projects_edit = new clsf_projects_edit();
$Page =& $lsf_projects_edit;

// Page init processing
$lsf_projects_edit->Page_Init();

// Page main processing
$lsf_projects_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_projects_edit = new ew_Page("lsf_projects_edit");

// page properties
lsf_projects_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = lsf_projects_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
lsf_projects_edit.ValidateForm = function(fobj) {
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
lsf_projects_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_projects_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_projects_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Lsf Projects<br><br>
<a href="<?php echo $lsf_projects->getReturnUrl() ?>">Go Back</a></span></p>
<?php $lsf_projects_edit->ShowMessage() ?>
<form name="flsf_projectsedit" id="flsf_projectsedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return lsf_projects_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="lsf_projects">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lsf_projects->id->Visible) { // id ?>
	<tr<?php echo $lsf_projects->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $lsf_projects->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $lsf_projects->id->ViewAttributes() ?>><?php echo $lsf_projects->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($lsf_projects->id->CurrentValue) ?>">
</span><?php echo $lsf_projects->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_projects->name->Visible) { // name ?>
	<tr<?php echo $lsf_projects->name->RowAttributes ?>>
		<td class="ewTableHeader">Name<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $lsf_projects->name->CellAttributes() ?>><span id="el_name">
<input type="text" name="x_name" id="x_name" size="30" maxlength="200" value="<?php echo $lsf_projects->name->EditValue ?>"<?php echo $lsf_projects->name->EditAttributes() ?>>
</span><?php echo $lsf_projects->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lsf_projects->gid->Visible) { // gid ?>
	<tr<?php echo $lsf_projects->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $lsf_projects->gid->CellAttributes() ?>><span id="el_gid">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $lsf_projects->gid->EditValue ?>"<?php echo $lsf_projects->gid->EditAttributes() ?>>
</span><?php echo $lsf_projects->gid->CustomMsg ?></td>
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
$lsf_projects_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_projects_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'lsf_projects';

	// Page Object Name
	var $PageObjName = 'lsf_projects_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_projects;
		if ($lsf_projects->UseTokenInUrl) $PageUrl .= "t=" . $lsf_projects->TableVar . "&"; // add page token
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
		global $objForm, $lsf_projects;
		if ($lsf_projects->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_projects->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_projects->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_projects_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_projects"] = new clsf_projects();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_projects', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_projects;
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
		global $objForm, $gsFormError, $lsf_projects;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$lsf_projects->id->setQueryStringValue($_GET["id"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$lsf_projects->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$lsf_projects->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$lsf_projects->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($lsf_projects->id->CurrentValue == "")
			$this->Page_Terminate("lsf_projectslist.php"); // Invalid key, return to list
		switch ($lsf_projects->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("lsf_projectslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$lsf_projects->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $lsf_projects->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$lsf_projects->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $lsf_projects;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $lsf_projects;
		$lsf_projects->id->setFormValue($objForm->GetValue("x_id"));
		$lsf_projects->name->setFormValue($objForm->GetValue("x_name"));
		$lsf_projects->gid->setFormValue($objForm->GetValue("x_gid"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $lsf_projects;
		$this->LoadRow();
		$lsf_projects->id->CurrentValue = $lsf_projects->id->FormValue;
		$lsf_projects->name->CurrentValue = $lsf_projects->name->FormValue;
		$lsf_projects->gid->CurrentValue = $lsf_projects->gid->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_projects;
		$sFilter = $lsf_projects->KeyFilter();

		// Call Row Selecting event
		$lsf_projects->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_projects->CurrentFilter = $sFilter;
		$sSql = $lsf_projects->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_projects->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_projects;
		$lsf_projects->id->setDbValue($rs->fields('id'));
		$lsf_projects->name->setDbValue($rs->fields('name'));
		$lsf_projects->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_projects;

		// Call Row_Rendering event
		$lsf_projects->Row_Rendering();

		// Common render codes for all row types
		// id

		$lsf_projects->id->CellCssStyle = "";
		$lsf_projects->id->CellCssClass = "";

		// name
		$lsf_projects->name->CellCssStyle = "";
		$lsf_projects->name->CellCssClass = "";

		// gid
		$lsf_projects->gid->CellCssStyle = "";
		$lsf_projects->gid->CellCssClass = "";
		if ($lsf_projects->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$lsf_projects->id->ViewValue = $lsf_projects->id->CurrentValue;
			$lsf_projects->id->CssStyle = "";
			$lsf_projects->id->CssClass = "";
			$lsf_projects->id->ViewCustomAttributes = "";

			// name
			$lsf_projects->name->ViewValue = $lsf_projects->name->CurrentValue;
			$lsf_projects->name->CssStyle = "";
			$lsf_projects->name->CssClass = "";
			$lsf_projects->name->ViewCustomAttributes = "";

			// gid
			$lsf_projects->gid->ViewValue = $lsf_projects->gid->CurrentValue;
			$lsf_projects->gid->CssStyle = "";
			$lsf_projects->gid->CssClass = "";
			$lsf_projects->gid->ViewCustomAttributes = "";

			// id
			$lsf_projects->id->HrefValue = "";

			// name
			$lsf_projects->name->HrefValue = "";

			// gid
			$lsf_projects->gid->HrefValue = "";
		} elseif ($lsf_projects->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$lsf_projects->id->EditCustomAttributes = "";
			$lsf_projects->id->EditValue = $lsf_projects->id->CurrentValue;
			$lsf_projects->id->CssStyle = "";
			$lsf_projects->id->CssClass = "";
			$lsf_projects->id->ViewCustomAttributes = "";

			// name
			$lsf_projects->name->EditCustomAttributes = "";
			$lsf_projects->name->EditValue = ew_HtmlEncode($lsf_projects->name->CurrentValue);

			// gid
			$lsf_projects->gid->EditCustomAttributes = "";
			$lsf_projects->gid->EditValue = ew_HtmlEncode($lsf_projects->gid->CurrentValue);

			// Edit refer script
			// id

			$lsf_projects->id->HrefValue = "";

			// name
			$lsf_projects->name->HrefValue = "";

			// gid
			$lsf_projects->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_projects->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $lsf_projects;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($lsf_projects->name->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Name";
		}
		if (!ew_CheckInteger($lsf_projects->gid->FormValue)) {
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
		global $conn, $Security, $lsf_projects;
		$sFilter = $lsf_projects->KeyFilter();
		$lsf_projects->CurrentFilter = $sFilter;
		$sSql = $lsf_projects->SQL();
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

			$lsf_projects->name->SetDbValueDef($lsf_projects->name->CurrentValue, "");
			$rsnew['name'] =& $lsf_projects->name->DbValue;

			// Field gid
			$lsf_projects->gid->SetDbValueDef($lsf_projects->gid->CurrentValue, NULL);
			$rsnew['gid'] =& $lsf_projects->gid->DbValue;

			// Call Row Updating event
			$bUpdateRow = $lsf_projects->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($lsf_projects->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($lsf_projects->CancelMessage <> "") {
					$this->setMessage($lsf_projects->CancelMessage);
					$lsf_projects->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$lsf_projects->Row_Updated($rsold, $rsnew);
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
