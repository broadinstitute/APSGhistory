<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "usersinfo.php" ?>
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
$users_edit = new cusers_edit();
$Page =& $users_edit;

// Page init processing
$users_edit->Page_Init();

// Page main processing
$users_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var users_edit = new ew_Page("users_edit");

// page properties
users_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = users_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
users_edit.ValidateForm = function(fobj) {
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
users_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
users_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
users_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit TABLE: Users<br><br>
<a href="<?php echo $users->getReturnUrl() ?>">Go Back</a></span></p>
<?php $users_edit->ShowMessage() ?>
<form name="fusersedit" id="fusersedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return users_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="users">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($users->uid->Visible) { // uid ?>
	<tr<?php echo $users->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $users->uid->CellAttributes() ?>><span id="el_uid">
<div<?php echo $users->uid->ViewAttributes() ?>><?php echo $users->uid->EditValue ?></div><input type="hidden" name="x_uid" id="x_uid" value="<?php echo ew_HtmlEncode($users->uid->CurrentValue) ?>">
</span><?php echo $users->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->username->Visible) { // username ?>
	<tr<?php echo $users->username->RowAttributes ?>>
		<td class="ewTableHeader">Username</td>
		<td<?php echo $users->username->CellAttributes() ?>><span id="el_username">
<div<?php echo $users->username->ViewAttributes() ?>><?php echo $users->username->EditValue ?></div><input type="hidden" name="x_username" id="x_username" value="<?php echo ew_HtmlEncode($users->username->CurrentValue) ?>">
</span><?php echo $users->username->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->gecos->Visible) { // gecos ?>
	<tr<?php echo $users->gecos->RowAttributes ?>>
		<td class="ewTableHeader">Gecos</td>
		<td<?php echo $users->gecos->CellAttributes() ?>><span id="el_gecos">
<div<?php echo $users->gecos->ViewAttributes() ?>><?php echo $users->gecos->EditValue ?></div><input type="hidden" name="x_gecos" id="x_gecos" value="<?php echo ew_HtmlEncode($users->gecos->CurrentValue) ?>">
</span><?php echo $users->gecos->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->role->Visible) { // role ?>
	<tr<?php echo $users->role->RowAttributes ?>>
		<td class="ewTableHeader">Role<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $users->role->CellAttributes() ?>><span id="el_role">
<div<?php echo $users->role->ViewAttributes() ?>><?php echo $users->role->EditValue ?></div><input type="hidden" name="x_role" id="x_role" value="<?php echo ew_HtmlEncode($users->role->CurrentValue) ?>">
</span><?php echo $users->role->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->gid->Visible) { // gid ?>
	<tr<?php echo $users->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $users->gid->CellAttributes() ?>><span id="el_gid">
<div<?php echo $users->gid->ViewAttributes() ?>><?php echo $users->gid->EditValue ?></div><input type="hidden" name="x_gid" id="x_gid" value="<?php echo ew_HtmlEncode($users->gid->CurrentValue) ?>">
</span><?php echo $users->gid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($users->cobj->Visible) { // cobj ?>
	<tr<?php echo $users->cobj->RowAttributes ?>>
		<td class="ewTableHeader">Cobj</td>
		<td<?php echo $users->cobj->CellAttributes() ?>><span id="el_cobj">
<div<?php echo $users->cobj->ViewAttributes() ?>><?php echo $users->cobj->EditValue ?></div><input type="hidden" name="x_cobj" id="x_cobj" value="<?php echo ew_HtmlEncode($users->cobj->CurrentValue) ?>">
</span><?php echo $users->cobj->CustomMsg ?></td>
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
$users_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class cusers_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'users';

	// Page Object Name
	var $PageObjName = 'users_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $users;
		if ($users->UseTokenInUrl) $PageUrl .= "t=" . $users->TableVar . "&"; // add page token
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
		global $objForm, $users;
		if ($users->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($users->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($users->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cusers_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["users"] = new cusers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $users;
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
		global $objForm, $gsFormError, $users;

		// Load key from QueryString
		if (@$_GET["uid"] <> "")
			$users->uid->setQueryStringValue($_GET["uid"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$users->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$users->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$users->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($users->uid->CurrentValue == "")
			$this->Page_Terminate("userslist.php"); // Invalid key, return to list
		switch ($users->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("userslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$users->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $users->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$users->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $users;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $users;
		$users->uid->setFormValue($objForm->GetValue("x_uid"));
		$users->username->setFormValue($objForm->GetValue("x_username"));
		$users->gecos->setFormValue($objForm->GetValue("x_gecos"));
		$users->role->setFormValue($objForm->GetValue("x_role"));
		$users->gid->setFormValue($objForm->GetValue("x_gid"));
		$users->cobj->setFormValue($objForm->GetValue("x_cobj"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $users;
		$this->LoadRow();
		$users->uid->CurrentValue = $users->uid->FormValue;
		$users->username->CurrentValue = $users->username->FormValue;
		$users->gecos->CurrentValue = $users->gecos->FormValue;
		$users->role->CurrentValue = $users->role->FormValue;
		$users->gid->CurrentValue = $users->gid->FormValue;
		$users->cobj->CurrentValue = $users->cobj->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $users;
		$sFilter = $users->KeyFilter();

		// Call Row Selecting event
		$users->Row_Selecting($sFilter);

		// Load sql based on filter
		$users->CurrentFilter = $sFilter;
		$sSql = $users->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$users->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $users;
		$users->uid->setDbValue($rs->fields('uid'));
		$users->username->setDbValue($rs->fields('username'));
		$users->gecos->setDbValue($rs->fields('gecos'));
		$users->role->setDbValue($rs->fields('role'));
		$users->gid->setDbValue($rs->fields('gid'));
		$users->cobj->setDbValue($rs->fields('cobj'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $users;

		// Call Row_Rendering event
		$users->Row_Rendering();

		// Common render codes for all row types
		// uid

		$users->uid->CellCssStyle = "";
		$users->uid->CellCssClass = "";

		// username
		$users->username->CellCssStyle = "";
		$users->username->CellCssClass = "";

		// gecos
		$users->gecos->CellCssStyle = "";
		$users->gecos->CellCssClass = "";

		// role
		$users->role->CellCssStyle = "";
		$users->role->CellCssClass = "";

		// gid
		$users->gid->CellCssStyle = "";
		$users->gid->CellCssClass = "";

		// cobj
		$users->cobj->CellCssStyle = "";
		$users->cobj->CellCssClass = "";
		if ($users->RowType == EW_ROWTYPE_VIEW) { // View row

			// uid
			$users->uid->ViewValue = $users->uid->CurrentValue;
			$users->uid->CssStyle = "";
			$users->uid->CssClass = "";
			$users->uid->ViewCustomAttributes = "";

			// username
			$users->username->ViewValue = $users->username->CurrentValue;
			$users->username->CssStyle = "";
			$users->username->CssClass = "";
			$users->username->ViewCustomAttributes = "";

			// gecos
			$users->gecos->ViewValue = $users->gecos->CurrentValue;
			$users->gecos->CssStyle = "";
			$users->gecos->CssClass = "";
			$users->gecos->ViewCustomAttributes = "";

			// role
			$users->role->ViewValue = $users->role->CurrentValue;
			$users->role->CssStyle = "";
			$users->role->CssClass = "";
			$users->role->ViewCustomAttributes = "";

			// gid
			$users->gid->ViewValue = $users->gid->CurrentValue;
			$users->gid->CssStyle = "";
			$users->gid->CssClass = "";
			$users->gid->ViewCustomAttributes = "";

			// cobj
			$users->cobj->ViewValue = $users->cobj->CurrentValue;
			$users->cobj->CssStyle = "";
			$users->cobj->CssClass = "";
			$users->cobj->ViewCustomAttributes = "";

			// uid
			$users->uid->HrefValue = "";

			// username
			$users->username->HrefValue = "";

			// gecos
			$users->gecos->HrefValue = "";

			// role
			$users->role->HrefValue = "";

			// gid
			$users->gid->HrefValue = "";

			// cobj
			$users->cobj->HrefValue = "";
		} elseif ($users->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// uid
			$users->uid->EditCustomAttributes = "";
			$users->uid->EditValue = $users->uid->CurrentValue;
			$users->uid->CssStyle = "";
			$users->uid->CssClass = "";
			$users->uid->ViewCustomAttributes = "";

			// username
			$users->username->EditCustomAttributes = "";
			$users->username->EditValue = $users->username->CurrentValue;
			$users->username->CssStyle = "";
			$users->username->CssClass = "";
			$users->username->ViewCustomAttributes = "";

			// gecos
			$users->gecos->EditCustomAttributes = "";
			$users->gecos->EditValue = $users->gecos->CurrentValue;
			$users->gecos->CssStyle = "";
			$users->gecos->CssClass = "";
			$users->gecos->ViewCustomAttributes = "";

			// role
			$users->role->EditCustomAttributes = "";
			$users->role->EditValue = $users->role->CurrentValue;
			$users->role->CssStyle = "";
			$users->role->CssClass = "";
			$users->role->ViewCustomAttributes = "";

			// gid
			$users->gid->EditCustomAttributes = "";
			$users->gid->EditValue = $users->gid->CurrentValue;
			$users->gid->CssStyle = "";
			$users->gid->CssClass = "";
			$users->gid->ViewCustomAttributes = "";

			// cobj
			$users->cobj->EditCustomAttributes = "";
			$users->cobj->EditValue = $users->cobj->CurrentValue;
			$users->cobj->CssStyle = "";
			$users->cobj->CssClass = "";
			$users->cobj->ViewCustomAttributes = "";

			// Edit refer script
			// uid

			$users->uid->HrefValue = "";

			// username
			$users->username->HrefValue = "";

			// gecos
			$users->gecos->HrefValue = "";

			// role
			$users->role->HrefValue = "";

			// gid
			$users->gid->HrefValue = "";

			// cobj
			$users->cobj->HrefValue = "";
		}

		// Call Row Rendered event
		$users->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $users;

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
		global $conn, $Security, $users;
		$sFilter = $users->KeyFilter();
		$users->CurrentFilter = $sFilter;
		$sSql = $users->SQL();
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
			$bUpdateRow = $users->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($users->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($users->CancelMessage <> "") {
					$this->setMessage($users->CancelMessage);
					$users->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$users->Row_Updated($rsold, $rsnew);
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
