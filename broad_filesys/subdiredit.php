<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "subdirinfo.php" ?>
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
$subdir_edit = new csubdir_edit();
$Page =& $subdir_edit;

// Page init processing
$subdir_edit->Page_Init();

// Page main processing
$subdir_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var subdir_edit = new ew_Page("subdir_edit");

// page properties
subdir_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = subdir_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
subdir_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_fsid"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Fsid");
		elm = fobj.elements["x" + infix + "_fsid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Fsid");
		elm = fobj.elements["x" + infix + "_dirid"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Dirid");
		elm = fobj.elements["x" + infix + "_dirid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Dirid");
		elm = fobj.elements["x" + infix + "_parent"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Parent");
		elm = fobj.elements["x" + infix + "_name"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Name");
		elm = fobj.elements["x" + infix + "_deprecated"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Deprecated");
		elm = fobj.elements["x" + infix + "_level"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Level");
		elm = fobj.elements["x" + infix + "_level"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Level");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
subdir_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
subdir_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
subdir_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Subdir<br><br>
<a href="<?php echo $subdir->getReturnUrl() ?>">Go Back</a></span></p>
<?php $subdir_edit->ShowMessage() ?>
<form name="fsubdiredit" id="fsubdiredit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return subdir_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="subdir">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($subdir->fsid->Visible) { // fsid ?>
	<tr<?php echo $subdir->fsid->RowAttributes ?>>
		<td class="ewTableHeader">Fsid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $subdir->fsid->CellAttributes() ?>><span id="el_fsid">
<div<?php echo $subdir->fsid->ViewAttributes() ?>><?php echo $subdir->fsid->EditValue ?></div><input type="hidden" name="x_fsid" id="x_fsid" value="<?php echo ew_HtmlEncode($subdir->fsid->CurrentValue) ?>">
</span><?php echo $subdir->fsid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($subdir->dirid->Visible) { // dirid ?>
	<tr<?php echo $subdir->dirid->RowAttributes ?>>
		<td class="ewTableHeader">Dirid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $subdir->dirid->CellAttributes() ?>><span id="el_dirid">
<div<?php echo $subdir->dirid->ViewAttributes() ?>><?php echo $subdir->dirid->EditValue ?></div><input type="hidden" name="x_dirid" id="x_dirid" value="<?php echo ew_HtmlEncode($subdir->dirid->CurrentValue) ?>">
</span><?php echo $subdir->dirid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($subdir->parent->Visible) { // parent ?>
	<tr<?php echo $subdir->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $subdir->parent->CellAttributes() ?>><span id="el_parent">
<input type="text" name="x_parent" id="x_parent" size="30" value="<?php echo $subdir->parent->EditValue ?>"<?php echo $subdir->parent->EditAttributes() ?>>
</span><?php echo $subdir->parent->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($subdir->name->Visible) { // name ?>
	<tr<?php echo $subdir->name->RowAttributes ?>>
		<td class="ewTableHeader">Name<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $subdir->name->CellAttributes() ?>><span id="el_name">
<input type="text" name="x_name" id="x_name" size="30" maxlength="100" value="<?php echo $subdir->name->EditValue ?>"<?php echo $subdir->name->EditAttributes() ?>>
</span><?php echo $subdir->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($subdir->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $subdir->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $subdir->deprecated->CellAttributes() ?>><span id="el_deprecated">
<input type="text" name="x_deprecated" id="x_deprecated" size="30" value="<?php echo $subdir->deprecated->EditValue ?>"<?php echo $subdir->deprecated->EditAttributes() ?>>
</span><?php echo $subdir->deprecated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($subdir->level->Visible) { // level ?>
	<tr<?php echo $subdir->level->RowAttributes ?>>
		<td class="ewTableHeader">Level<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $subdir->level->CellAttributes() ?>><span id="el_level">
<input type="text" name="x_level" id="x_level" size="30" value="<?php echo $subdir->level->EditValue ?>"<?php echo $subdir->level->EditAttributes() ?>>
</span><?php echo $subdir->level->CustomMsg ?></td>
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
$subdir_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class csubdir_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'subdir';

	// Page Object Name
	var $PageObjName = 'subdir_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $subdir;
		if ($subdir->UseTokenInUrl) $PageUrl .= "t=" . $subdir->TableVar . "&"; // add page token
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
		global $objForm, $subdir;
		if ($subdir->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($subdir->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($subdir->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function csubdir_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["subdir"] = new csubdir();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'subdir', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $subdir;
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
		global $objForm, $gsFormError, $subdir;

		// Load key from QueryString
		if (@$_GET["fsid"] <> "")
			$subdir->fsid->setQueryStringValue($_GET["fsid"]);
		if (@$_GET["dirid"] <> "")
			$subdir->dirid->setQueryStringValue($_GET["dirid"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$subdir->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$subdir->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$subdir->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($subdir->fsid->CurrentValue == "")
			$this->Page_Terminate("subdirlist.php"); // Invalid key, return to list
		if ($subdir->dirid->CurrentValue == "")
			$this->Page_Terminate("subdirlist.php"); // Invalid key, return to list
		switch ($subdir->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("subdirlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$subdir->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $subdir->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$subdir->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $subdir;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $subdir;
		$subdir->fsid->setFormValue($objForm->GetValue("x_fsid"));
		$subdir->dirid->setFormValue($objForm->GetValue("x_dirid"));
		$subdir->parent->setFormValue($objForm->GetValue("x_parent"));
		$subdir->name->setFormValue($objForm->GetValue("x_name"));
		$subdir->deprecated->setFormValue($objForm->GetValue("x_deprecated"));
		$subdir->level->setFormValue($objForm->GetValue("x_level"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $subdir;
		$this->LoadRow();
		$subdir->fsid->CurrentValue = $subdir->fsid->FormValue;
		$subdir->dirid->CurrentValue = $subdir->dirid->FormValue;
		$subdir->parent->CurrentValue = $subdir->parent->FormValue;
		$subdir->name->CurrentValue = $subdir->name->FormValue;
		$subdir->deprecated->CurrentValue = $subdir->deprecated->FormValue;
		$subdir->level->CurrentValue = $subdir->level->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $subdir;
		$sFilter = $subdir->KeyFilter();

		// Call Row Selecting event
		$subdir->Row_Selecting($sFilter);

		// Load sql based on filter
		$subdir->CurrentFilter = $sFilter;
		$sSql = $subdir->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$subdir->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $subdir;
		$subdir->fsid->setDbValue($rs->fields('fsid'));
		$subdir->dirid->setDbValue($rs->fields('dirid'));
		$subdir->parent->setDbValue($rs->fields('parent'));
		$subdir->name->setDbValue($rs->fields('name'));
		$subdir->deprecated->setDbValue($rs->fields('deprecated'));
		$subdir->level->setDbValue($rs->fields('level'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $subdir;

		// Call Row_Rendering event
		$subdir->Row_Rendering();

		// Common render codes for all row types
		// fsid

		$subdir->fsid->CellCssStyle = "";
		$subdir->fsid->CellCssClass = "";

		// dirid
		$subdir->dirid->CellCssStyle = "";
		$subdir->dirid->CellCssClass = "";

		// parent
		$subdir->parent->CellCssStyle = "";
		$subdir->parent->CellCssClass = "";

		// name
		$subdir->name->CellCssStyle = "";
		$subdir->name->CellCssClass = "";

		// deprecated
		$subdir->deprecated->CellCssStyle = "";
		$subdir->deprecated->CellCssClass = "";

		// level
		$subdir->level->CellCssStyle = "";
		$subdir->level->CellCssClass = "";
		if ($subdir->RowType == EW_ROWTYPE_VIEW) { // View row

			// fsid
			$subdir->fsid->ViewValue = $subdir->fsid->CurrentValue;
			$subdir->fsid->CssStyle = "";
			$subdir->fsid->CssClass = "";
			$subdir->fsid->ViewCustomAttributes = "";

			// dirid
			$subdir->dirid->ViewValue = $subdir->dirid->CurrentValue;
			$subdir->dirid->CssStyle = "";
			$subdir->dirid->CssClass = "";
			$subdir->dirid->ViewCustomAttributes = "";

			// parent
			$subdir->parent->ViewValue = $subdir->parent->CurrentValue;
			$subdir->parent->CssStyle = "";
			$subdir->parent->CssClass = "";
			$subdir->parent->ViewCustomAttributes = "";

			// name
			$subdir->name->ViewValue = $subdir->name->CurrentValue;
			$subdir->name->CssStyle = "";
			$subdir->name->CssClass = "";
			$subdir->name->ViewCustomAttributes = "";

			// deprecated
			$subdir->deprecated->ViewValue = $subdir->deprecated->CurrentValue;
			$subdir->deprecated->CssStyle = "";
			$subdir->deprecated->CssClass = "";
			$subdir->deprecated->ViewCustomAttributes = "";

			// level
			$subdir->level->ViewValue = $subdir->level->CurrentValue;
			$subdir->level->CssStyle = "";
			$subdir->level->CssClass = "";
			$subdir->level->ViewCustomAttributes = "";

			// fsid
			$subdir->fsid->HrefValue = "";

			// dirid
			$subdir->dirid->HrefValue = "";

			// parent
			$subdir->parent->HrefValue = "";

			// name
			$subdir->name->HrefValue = "";

			// deprecated
			$subdir->deprecated->HrefValue = "";

			// level
			$subdir->level->HrefValue = "";
		} elseif ($subdir->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// fsid
			$subdir->fsid->EditCustomAttributes = "";
			$subdir->fsid->EditValue = $subdir->fsid->CurrentValue;
			$subdir->fsid->CssStyle = "";
			$subdir->fsid->CssClass = "";
			$subdir->fsid->ViewCustomAttributes = "";

			// dirid
			$subdir->dirid->EditCustomAttributes = "";
			$subdir->dirid->EditValue = $subdir->dirid->CurrentValue;
			$subdir->dirid->CssStyle = "";
			$subdir->dirid->CssClass = "";
			$subdir->dirid->ViewCustomAttributes = "";

			// parent
			$subdir->parent->EditCustomAttributes = "";
			$subdir->parent->EditValue = ew_HtmlEncode($subdir->parent->CurrentValue);

			// name
			$subdir->name->EditCustomAttributes = "";
			$subdir->name->EditValue = ew_HtmlEncode($subdir->name->CurrentValue);

			// deprecated
			$subdir->deprecated->EditCustomAttributes = "";
			$subdir->deprecated->EditValue = ew_HtmlEncode($subdir->deprecated->CurrentValue);

			// level
			$subdir->level->EditCustomAttributes = "";
			$subdir->level->EditValue = ew_HtmlEncode($subdir->level->CurrentValue);

			// Edit refer script
			// fsid

			$subdir->fsid->HrefValue = "";

			// dirid
			$subdir->dirid->HrefValue = "";

			// parent
			$subdir->parent->HrefValue = "";

			// name
			$subdir->name->HrefValue = "";

			// deprecated
			$subdir->deprecated->HrefValue = "";

			// level
			$subdir->level->HrefValue = "";
		}

		// Call Row Rendered event
		$subdir->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $subdir;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($subdir->fsid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Fsid";
		}
		if (!ew_CheckInteger($subdir->fsid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Fsid";
		}
		if ($subdir->dirid->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Dirid";
		}
		if (!ew_CheckInteger($subdir->dirid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Dirid";
		}
		if (!ew_CheckInteger($subdir->parent->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Parent";
		}
		if ($subdir->name->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Name";
		}
		if (!ew_CheckInteger($subdir->deprecated->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Deprecated";
		}
		if ($subdir->level->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Level";
		}
		if (!ew_CheckInteger($subdir->level->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Level";
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
		global $conn, $Security, $subdir;
		$sFilter = $subdir->KeyFilter();
		$subdir->CurrentFilter = $sFilter;
		$sSql = $subdir->SQL();
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

			// Field fsid
			// Field dirid
			// Field parent

			$subdir->parent->SetDbValueDef($subdir->parent->CurrentValue, NULL);
			$rsnew['parent'] =& $subdir->parent->DbValue;

			// Field name
			$subdir->name->SetDbValueDef($subdir->name->CurrentValue, "");
			$rsnew['name'] =& $subdir->name->DbValue;

			// Field deprecated
			$subdir->deprecated->SetDbValueDef($subdir->deprecated->CurrentValue, NULL);
			$rsnew['deprecated'] =& $subdir->deprecated->DbValue;

			// Field level
			$subdir->level->SetDbValueDef($subdir->level->CurrentValue, 0);
			$rsnew['level'] =& $subdir->level->DbValue;

			// Call Row Updating event
			$bUpdateRow = $subdir->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($subdir->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($subdir->CancelMessage <> "") {
					$this->setMessage($subdir->CancelMessage);
					$subdir->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$subdir->Row_Updated($rsold, $rsnew);
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
