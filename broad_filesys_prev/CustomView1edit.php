<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "CustomView1info.php" ?>
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
$CustomView1_edit = new cCustomView1_edit();
$Page =& $CustomView1_edit;

// Page init processing
$CustomView1_edit->Page_Init();

// Page main processing
$CustomView1_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var CustomView1_edit = new ew_Page("CustomView1_edit");

// page properties
CustomView1_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = CustomView1_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
CustomView1_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_mount"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Mount");
		elm = fobj.elements["x" + infix + "_path"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Path");
		elm = fobj.elements["x" + infix + "_parent"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Parent");
		elm = fobj.elements["x" + infix + "_deprecated"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Deprecated");
		elm = fobj.elements["x" + infix + "_gid"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Gid");
		elm = fobj.elements["x" + infix + "_snapshot"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Snapshot");
		elm = fobj.elements["x" + infix + "_tapebackup"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Tapebackup");
		elm = fobj.elements["x" + infix + "_diskbackup"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Incorrect integer - Diskbackup");
		elm = fobj.elements["x" + infix + "_name"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Please enter required field - Name");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
CustomView1_edit.Form_CustomValidate =
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
CustomView1_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
CustomView1_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Edit CUSTOM VIEW: Custom View 1<br><br>
<a href="<?php echo $CustomView1->getReturnUrl() ?>">Go Back</a></span></p>
<?php $CustomView1_edit->ShowMessage() ?>
<form name="fCustomView1edit" id="fCustomView1edit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return CustomView1_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="CustomView1">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($CustomView1->id->Visible) { // id ?>
	<tr<?php echo $CustomView1->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $CustomView1->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $CustomView1->id->ViewAttributes() ?>><?php echo $CustomView1->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($CustomView1->id->CurrentValue) ?>">
</span><?php echo $CustomView1->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->mount->Visible) { // mount ?>
	<tr<?php echo $CustomView1->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $CustomView1->mount->CellAttributes() ?>><span id="el_mount">
<input type="text" name="x_mount" id="x_mount" size="30" maxlength="100" value="<?php echo $CustomView1->mount->EditValue ?>"<?php echo $CustomView1->mount->EditAttributes() ?>>
</span><?php echo $CustomView1->mount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->path->Visible) { // path ?>
	<tr<?php echo $CustomView1->path->RowAttributes ?>>
		<td class="ewTableHeader">Path<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $CustomView1->path->CellAttributes() ?>><span id="el_path">
<input type="text" name="x_path" id="x_path" size="30" maxlength="100" value="<?php echo $CustomView1->path->EditValue ?>"<?php echo $CustomView1->path->EditAttributes() ?>>
</span><?php echo $CustomView1->path->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->parent->Visible) { // parent ?>
	<tr<?php echo $CustomView1->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $CustomView1->parent->CellAttributes() ?>><span id="el_parent">
<input type="text" name="x_parent" id="x_parent" size="30" value="<?php echo $CustomView1->parent->EditValue ?>"<?php echo $CustomView1->parent->EditAttributes() ?>>
</span><?php echo $CustomView1->parent->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $CustomView1->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $CustomView1->deprecated->CellAttributes() ?>><span id="el_deprecated">
<input type="text" name="x_deprecated" id="x_deprecated" size="30" value="<?php echo $CustomView1->deprecated->EditValue ?>"<?php echo $CustomView1->deprecated->EditAttributes() ?>>
</span><?php echo $CustomView1->deprecated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->gid->Visible) { // gid ?>
	<tr<?php echo $CustomView1->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $CustomView1->gid->CellAttributes() ?>><span id="el_gid">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $CustomView1->gid->EditValue ?>"<?php echo $CustomView1->gid->EditAttributes() ?>>
</span><?php echo $CustomView1->gid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->snapshot->Visible) { // snapshot ?>
	<tr<?php echo $CustomView1->snapshot->RowAttributes ?>>
		<td class="ewTableHeader">Snapshot</td>
		<td<?php echo $CustomView1->snapshot->CellAttributes() ?>><span id="el_snapshot">
<input type="text" name="x_snapshot" id="x_snapshot" size="30" value="<?php echo $CustomView1->snapshot->EditValue ?>"<?php echo $CustomView1->snapshot->EditAttributes() ?>>
</span><?php echo $CustomView1->snapshot->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->tapebackup->Visible) { // tapebackup ?>
	<tr<?php echo $CustomView1->tapebackup->RowAttributes ?>>
		<td class="ewTableHeader">Tapebackup</td>
		<td<?php echo $CustomView1->tapebackup->CellAttributes() ?>><span id="el_tapebackup">
<input type="text" name="x_tapebackup" id="x_tapebackup" size="30" value="<?php echo $CustomView1->tapebackup->EditValue ?>"<?php echo $CustomView1->tapebackup->EditAttributes() ?>>
</span><?php echo $CustomView1->tapebackup->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->diskbackup->Visible) { // diskbackup ?>
	<tr<?php echo $CustomView1->diskbackup->RowAttributes ?>>
		<td class="ewTableHeader">Diskbackup</td>
		<td<?php echo $CustomView1->diskbackup->CellAttributes() ?>><span id="el_diskbackup">
<input type="text" name="x_diskbackup" id="x_diskbackup" size="30" value="<?php echo $CustomView1->diskbackup->EditValue ?>"<?php echo $CustomView1->diskbackup->EditAttributes() ?>>
</span><?php echo $CustomView1->diskbackup->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->name->Visible) { // name ?>
	<tr<?php echo $CustomView1->name->RowAttributes ?>>
		<td class="ewTableHeader">Name<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $CustomView1->name->CellAttributes() ?>><span id="el_name">
<div<?php echo $CustomView1->name->ViewAttributes() ?>><?php echo $CustomView1->name->EditValue ?></div><input type="hidden" name="x_name" id="x_name" value="<?php echo ew_HtmlEncode($CustomView1->name->CurrentValue) ?>">
</span><?php echo $CustomView1->name->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="   Edit  ">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$CustomView1_edit->Page_Terminate();
?>
<?php

//
// Page Class
//
class cCustomView1_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'CustomView1';

	// Page Object Name
	var $PageObjName = 'CustomView1_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $CustomView1;
		if ($CustomView1->UseTokenInUrl) $PageUrl .= "t=" . $CustomView1->TableVar . "&"; // add page token
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
		global $objForm, $CustomView1;
		if ($CustomView1->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($CustomView1->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($CustomView1->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cCustomView1_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["CustomView1"] = new cCustomView1();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'CustomView1', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $CustomView1;
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
		global $objForm, $gsFormError, $CustomView1;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$CustomView1->id->setQueryStringValue($_GET["id"]);
		if (@$_GET["name"] <> "")
			$CustomView1->name->setQueryStringValue($_GET["name"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$CustomView1->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$CustomView1->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$CustomView1->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($CustomView1->id->CurrentValue == "")
			$this->Page_Terminate("CustomView1list.php"); // Invalid key, return to list
		if ($CustomView1->name->CurrentValue == "")
			$this->Page_Terminate("CustomView1list.php"); // Invalid key, return to list
		switch ($CustomView1->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No records found"); // No record found
					$this->Page_Terminate("CustomView1list.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$CustomView1->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Update succeeded"); // Update success
					$sReturnUrl = $CustomView1->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$CustomView1->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $CustomView1;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $CustomView1;
		$CustomView1->id->setFormValue($objForm->GetValue("x_id"));
		$CustomView1->mount->setFormValue($objForm->GetValue("x_mount"));
		$CustomView1->path->setFormValue($objForm->GetValue("x_path"));
		$CustomView1->parent->setFormValue($objForm->GetValue("x_parent"));
		$CustomView1->deprecated->setFormValue($objForm->GetValue("x_deprecated"));
		$CustomView1->gid->setFormValue($objForm->GetValue("x_gid"));
		$CustomView1->snapshot->setFormValue($objForm->GetValue("x_snapshot"));
		$CustomView1->tapebackup->setFormValue($objForm->GetValue("x_tapebackup"));
		$CustomView1->diskbackup->setFormValue($objForm->GetValue("x_diskbackup"));
		$CustomView1->name->setFormValue($objForm->GetValue("x_name"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $CustomView1;
		$this->LoadRow();
		$CustomView1->id->CurrentValue = $CustomView1->id->FormValue;
		$CustomView1->mount->CurrentValue = $CustomView1->mount->FormValue;
		$CustomView1->path->CurrentValue = $CustomView1->path->FormValue;
		$CustomView1->parent->CurrentValue = $CustomView1->parent->FormValue;
		$CustomView1->deprecated->CurrentValue = $CustomView1->deprecated->FormValue;
		$CustomView1->gid->CurrentValue = $CustomView1->gid->FormValue;
		$CustomView1->snapshot->CurrentValue = $CustomView1->snapshot->FormValue;
		$CustomView1->tapebackup->CurrentValue = $CustomView1->tapebackup->FormValue;
		$CustomView1->diskbackup->CurrentValue = $CustomView1->diskbackup->FormValue;
		$CustomView1->name->CurrentValue = $CustomView1->name->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $CustomView1;
		$sFilter = $CustomView1->KeyFilter();

		// Call Row Selecting event
		$CustomView1->Row_Selecting($sFilter);

		// Load sql based on filter
		$CustomView1->CurrentFilter = $sFilter;
		$sSql = $CustomView1->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$CustomView1->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $CustomView1;
		$CustomView1->id->setDbValue($rs->fields('id'));
		$CustomView1->mount->setDbValue($rs->fields('mount'));
		$CustomView1->path->setDbValue($rs->fields('path'));
		$CustomView1->parent->setDbValue($rs->fields('parent'));
		$CustomView1->deprecated->setDbValue($rs->fields('deprecated'));
		$CustomView1->gid->setDbValue($rs->fields('gid'));
		$CustomView1->snapshot->setDbValue($rs->fields('snapshot'));
		$CustomView1->tapebackup->setDbValue($rs->fields('tapebackup'));
		$CustomView1->diskbackup->setDbValue($rs->fields('diskbackup'));
		$CustomView1->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $CustomView1;

		// Call Row_Rendering event
		$CustomView1->Row_Rendering();

		// Common render codes for all row types
		// id

		$CustomView1->id->CellCssStyle = "";
		$CustomView1->id->CellCssClass = "";

		// mount
		$CustomView1->mount->CellCssStyle = "";
		$CustomView1->mount->CellCssClass = "";

		// path
		$CustomView1->path->CellCssStyle = "";
		$CustomView1->path->CellCssClass = "";

		// parent
		$CustomView1->parent->CellCssStyle = "";
		$CustomView1->parent->CellCssClass = "";

		// deprecated
		$CustomView1->deprecated->CellCssStyle = "";
		$CustomView1->deprecated->CellCssClass = "";

		// gid
		$CustomView1->gid->CellCssStyle = "";
		$CustomView1->gid->CellCssClass = "";

		// snapshot
		$CustomView1->snapshot->CellCssStyle = "";
		$CustomView1->snapshot->CellCssClass = "";

		// tapebackup
		$CustomView1->tapebackup->CellCssStyle = "";
		$CustomView1->tapebackup->CellCssClass = "";

		// diskbackup
		$CustomView1->diskbackup->CellCssStyle = "";
		$CustomView1->diskbackup->CellCssClass = "";

		// name
		$CustomView1->name->CellCssStyle = "";
		$CustomView1->name->CellCssClass = "";
		if ($CustomView1->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$CustomView1->id->ViewValue = $CustomView1->id->CurrentValue;
			$CustomView1->id->CssStyle = "";
			$CustomView1->id->CssClass = "";
			$CustomView1->id->ViewCustomAttributes = "";

			// mount
			$CustomView1->mount->ViewValue = $CustomView1->mount->CurrentValue;
			$CustomView1->mount->CssStyle = "";
			$CustomView1->mount->CssClass = "";
			$CustomView1->mount->ViewCustomAttributes = "";

			// path
			$CustomView1->path->ViewValue = $CustomView1->path->CurrentValue;
			$CustomView1->path->CssStyle = "";
			$CustomView1->path->CssClass = "";
			$CustomView1->path->ViewCustomAttributes = "";

			// parent
			$CustomView1->parent->ViewValue = $CustomView1->parent->CurrentValue;
			$CustomView1->parent->CssStyle = "";
			$CustomView1->parent->CssClass = "";
			$CustomView1->parent->ViewCustomAttributes = "";

			// deprecated
			$CustomView1->deprecated->ViewValue = $CustomView1->deprecated->CurrentValue;
			$CustomView1->deprecated->CssStyle = "";
			$CustomView1->deprecated->CssClass = "";
			$CustomView1->deprecated->ViewCustomAttributes = "";

			// gid
			$CustomView1->gid->ViewValue = $CustomView1->gid->CurrentValue;
			$CustomView1->gid->CssStyle = "";
			$CustomView1->gid->CssClass = "";
			$CustomView1->gid->ViewCustomAttributes = "";

			// snapshot
			$CustomView1->snapshot->ViewValue = $CustomView1->snapshot->CurrentValue;
			$CustomView1->snapshot->CssStyle = "";
			$CustomView1->snapshot->CssClass = "";
			$CustomView1->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$CustomView1->tapebackup->ViewValue = $CustomView1->tapebackup->CurrentValue;
			$CustomView1->tapebackup->CssStyle = "";
			$CustomView1->tapebackup->CssClass = "";
			$CustomView1->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$CustomView1->diskbackup->ViewValue = $CustomView1->diskbackup->CurrentValue;
			$CustomView1->diskbackup->CssStyle = "";
			$CustomView1->diskbackup->CssClass = "";
			$CustomView1->diskbackup->ViewCustomAttributes = "";

			// name
			$CustomView1->name->ViewValue = $CustomView1->name->CurrentValue;
			$CustomView1->name->CssStyle = "";
			$CustomView1->name->CssClass = "";
			$CustomView1->name->ViewCustomAttributes = "";

			// id
			$CustomView1->id->HrefValue = "";

			// mount
			$CustomView1->mount->HrefValue = "";

			// path
			$CustomView1->path->HrefValue = "";

			// parent
			$CustomView1->parent->HrefValue = "";

			// deprecated
			$CustomView1->deprecated->HrefValue = "";

			// gid
			$CustomView1->gid->HrefValue = "";

			// snapshot
			$CustomView1->snapshot->HrefValue = "";

			// tapebackup
			$CustomView1->tapebackup->HrefValue = "";

			// diskbackup
			$CustomView1->diskbackup->HrefValue = "";

			// name
			$CustomView1->name->HrefValue = "";
		} elseif ($CustomView1->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$CustomView1->id->EditCustomAttributes = "";
			$CustomView1->id->EditValue = $CustomView1->id->CurrentValue;
			$CustomView1->id->CssStyle = "";
			$CustomView1->id->CssClass = "";
			$CustomView1->id->ViewCustomAttributes = "";

			// mount
			$CustomView1->mount->EditCustomAttributes = "";
			$CustomView1->mount->EditValue = ew_HtmlEncode($CustomView1->mount->CurrentValue);

			// path
			$CustomView1->path->EditCustomAttributes = "";
			$CustomView1->path->EditValue = ew_HtmlEncode($CustomView1->path->CurrentValue);

			// parent
			$CustomView1->parent->EditCustomAttributes = "";
			$CustomView1->parent->EditValue = ew_HtmlEncode($CustomView1->parent->CurrentValue);

			// deprecated
			$CustomView1->deprecated->EditCustomAttributes = "";
			$CustomView1->deprecated->EditValue = ew_HtmlEncode($CustomView1->deprecated->CurrentValue);

			// gid
			$CustomView1->gid->EditCustomAttributes = "";
			$CustomView1->gid->EditValue = ew_HtmlEncode($CustomView1->gid->CurrentValue);

			// snapshot
			$CustomView1->snapshot->EditCustomAttributes = "";
			$CustomView1->snapshot->EditValue = ew_HtmlEncode($CustomView1->snapshot->CurrentValue);

			// tapebackup
			$CustomView1->tapebackup->EditCustomAttributes = "";
			$CustomView1->tapebackup->EditValue = ew_HtmlEncode($CustomView1->tapebackup->CurrentValue);

			// diskbackup
			$CustomView1->diskbackup->EditCustomAttributes = "";
			$CustomView1->diskbackup->EditValue = ew_HtmlEncode($CustomView1->diskbackup->CurrentValue);

			// name
			$CustomView1->name->EditCustomAttributes = "";
			$CustomView1->name->EditValue = $CustomView1->name->CurrentValue;
			$CustomView1->name->CssStyle = "";
			$CustomView1->name->CssClass = "";
			$CustomView1->name->ViewCustomAttributes = "";

			// Edit refer script
			// id

			$CustomView1->id->HrefValue = "";

			// mount
			$CustomView1->mount->HrefValue = "";

			// path
			$CustomView1->path->HrefValue = "";

			// parent
			$CustomView1->parent->HrefValue = "";

			// deprecated
			$CustomView1->deprecated->HrefValue = "";

			// gid
			$CustomView1->gid->HrefValue = "";

			// snapshot
			$CustomView1->snapshot->HrefValue = "";

			// tapebackup
			$CustomView1->tapebackup->HrefValue = "";

			// diskbackup
			$CustomView1->diskbackup->HrefValue = "";

			// name
			$CustomView1->name->HrefValue = "";
		}

		// Call Row Rendered event
		$CustomView1->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $CustomView1;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($CustomView1->mount->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Mount";
		}
		if ($CustomView1->path->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Path";
		}
		if (!ew_CheckInteger($CustomView1->parent->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Parent";
		}
		if (!ew_CheckInteger($CustomView1->deprecated->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Deprecated";
		}
		if (!ew_CheckInteger($CustomView1->gid->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Gid";
		}
		if (!ew_CheckInteger($CustomView1->snapshot->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Snapshot";
		}
		if (!ew_CheckInteger($CustomView1->tapebackup->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Tapebackup";
		}
		if (!ew_CheckInteger($CustomView1->diskbackup->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Incorrect integer - Diskbackup";
		}
		if ($CustomView1->name->FormValue == "") {
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
		global $conn, $Security, $CustomView1;
		$sFilter = $CustomView1->KeyFilter();
		$CustomView1->CurrentFilter = $sFilter;
		$sSql = $CustomView1->SQL();
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
			// Field mount

			$CustomView1->mount->SetDbValueDef($CustomView1->mount->CurrentValue, "");
			$rsnew['mount'] =& $CustomView1->mount->DbValue;

			// Field path
			$CustomView1->path->SetDbValueDef($CustomView1->path->CurrentValue, "");
			$rsnew['path'] =& $CustomView1->path->DbValue;

			// Field parent
			$CustomView1->parent->SetDbValueDef($CustomView1->parent->CurrentValue, NULL);
			$rsnew['parent'] =& $CustomView1->parent->DbValue;

			// Field deprecated
			$CustomView1->deprecated->SetDbValueDef($CustomView1->deprecated->CurrentValue, NULL);
			$rsnew['deprecated'] =& $CustomView1->deprecated->DbValue;

			// Field gid
			$CustomView1->gid->SetDbValueDef($CustomView1->gid->CurrentValue, NULL);
			$rsnew['gid'] =& $CustomView1->gid->DbValue;

			// Field snapshot
			$CustomView1->snapshot->SetDbValueDef($CustomView1->snapshot->CurrentValue, NULL);
			$rsnew['snapshot'] =& $CustomView1->snapshot->DbValue;

			// Field tapebackup
			$CustomView1->tapebackup->SetDbValueDef($CustomView1->tapebackup->CurrentValue, NULL);
			$rsnew['tapebackup'] =& $CustomView1->tapebackup->DbValue;

			// Field diskbackup
			$CustomView1->diskbackup->SetDbValueDef($CustomView1->diskbackup->CurrentValue, NULL);
			$rsnew['diskbackup'] =& $CustomView1->diskbackup->DbValue;

			// Field name
			// Call Row Updating event

			$bUpdateRow = $CustomView1->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($CustomView1->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($CustomView1->CancelMessage <> "") {
					$this->setMessage($CustomView1->CancelMessage);
					$CustomView1->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$CustomView1->Row_Updated($rsold, $rsnew);
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
