<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "filesysteminfo.php" ?>
<?php include "grpinfo.php" ?>
<?php include "server_typeinfo.php" ?>
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
$filesystem_update = new cfilesystem_update();
$Page =& $filesystem_update;

// Page init processing
$filesystem_update->Page_Init();

// Page main processing
$filesystem_update->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var filesystem_update = new ew_Page("filesystem_update");

// page properties
filesystem_update.PageID = "update"; // page ID
var EW_PAGE_ID = filesystem_update.PageID; // for backward compatibility

// extend page with ValidateForm function
filesystem_update.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		alert('No field selected for update');
		return false;
	}
	var uelm;
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
filesystem_update.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
filesystem_update.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
filesystem_update.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
filesystem_update.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Update TABLE: Filesystem<br><br>
<a href="<?php echo $filesystem->getReturnUrl() ?>">Back to List</a></span></p>
<?php $filesystem_update->ShowMessage() ?>
<form name="ffilesystemupdate" id="ffilesystemupdate" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return filesystem_update.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="filesystem">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php for ($i = 0; $i < $filesystem_update->nKeySelected; $i++) { ?>
<input type="hidden" name="k<?php echo $i+1 ?>_key" id="key<?php echo $i+1 ?>" value="<?php echo ew_HtmlEncode($filesystem_update->arRecKeys[$i]) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr class="ewTableHeader">
		<td>Update<input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"></td>
		<td>Field Name</td>
		<td>New Value</td>
	</tr>
<?php if ($filesystem->gid->Visible) { // gid ?>
	<tr<?php echo $filesystem->gid->RowAttributes ?>>
		<td<?php echo $filesystem->gid->CellAttributes() ?>>
<input type="checkbox" name="u_gid" id="u_gid" value="1"<?php echo ($filesystem->gid->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
</td>
		<td<?php echo $filesystem->gid->CellAttributes() ?>>Gid</td>
		<td<?php echo $filesystem->gid->CellAttributes() ?>><span id="el_gid">
<?php if ($filesystem->gid->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ViewValue ?></div>
<input type="hidden" id="x_gid" name="x_gid" value="<?php echo ew_HtmlEncode($filesystem->gid->CurrentValue) ?>">
<?php } else { ?>
<select id="x_gid" name="x_gid"<?php echo $filesystem->gid->EditAttributes() ?>>
<?php
if (is_array($filesystem->gid->EditValue)) {
	$arwrk = $filesystem->gid->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($filesystem->gid->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php } ?>
</span><?php echo $filesystem->gid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($filesystem->type->Visible) { // type ?>
	<tr<?php echo $filesystem->type->RowAttributes ?>>
		<td<?php echo $filesystem->type->CellAttributes() ?>>
<input type="checkbox" name="u_type" id="u_type" value="1"<?php echo ($filesystem->type->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
</td>
		<td<?php echo $filesystem->type->CellAttributes() ?>>Type</td>
		<td<?php echo $filesystem->type->CellAttributes() ?>><span id="el_type">
<?php if ($filesystem->type->getSessionValue() <> "") { ?>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ViewValue ?></div>
<input type="hidden" id="x_type" name="x_type" value="<?php echo ew_HtmlEncode($filesystem->type->CurrentValue) ?>">
<?php } else { ?>
<select id="x_type" name="x_type"<?php echo $filesystem->type->EditAttributes() ?>>
<?php
if (is_array($filesystem->type->EditValue)) {
	$arwrk = $filesystem->type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($filesystem->type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php } ?>
</span><?php echo $filesystem->type->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  Update  ">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$filesystem_update->Page_Terminate();
?>
<?php

//
// Page Class
//
class cfilesystem_update {

	// Page ID
	var $PageID = 'update';

	// Table Name
	var $TableName = 'filesystem';

	// Page Object Name
	var $PageObjName = 'filesystem_update';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $filesystem;
		if ($filesystem->UseTokenInUrl) $PageUrl .= "t=" . $filesystem->TableVar . "&"; // add page token
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
		global $objForm, $filesystem;
		if ($filesystem->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($filesystem->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($filesystem->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cfilesystem_update() {
		global $conn;

		// Initialize table object
		$GLOBALS["filesystem"] = new cfilesystem();

		// Initialize other table object
		$GLOBALS['grp'] = new cgrp();

		// Initialize other table object
		$GLOBALS['server_type'] = new cserver_type();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'filesystem', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $filesystem;
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
	var $nKeySelected;
	var $arRecKeys;
	var $sDisabled;

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $filesystem;

		// Try to load keys from list form
		$this->nKeySelected = 0;
		if (ew_IsHttpPost()) {
			if (isset($_POST["key_m"])) { // Key count > 0
				$this->nKeySelected = count($_POST["key_m"]); // Get number of keys
				$this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
				$this->LoadMultiUpdateValues(); // Load initial values to form
			}
		}

		// Try to load key from update form
		if ($this->nKeySelected == 0) {
			$this->arRecKeys = array();

			// Create form object
			$objForm = new cFormObj();
			if (@$_POST["a_update"] <> "") {

				// Get action
				$filesystem->CurrentAction = $_POST["a_update"];

				// Get record keys
				$sKey = @$_POST["k" . strval($this->nKeySelected+1) . "_key"];
				while ($sKey <> "") {
					$this->arRecKeys[$this->nKeySelected] = ew_StripSlashes($sKey);
					$this->nKeySelected++;
					$sKey = @$_POST["k" . strval($this->nKeySelected+1) . "_key"];
				}
				$this->LoadFormValues(); // Get form values

				// Validate Form
				if (!$this->ValidateForm()) {
					$filesystem->CurrentAction = "I"; // Form error, reset action
					$this->setMessage($gsFormError);
				}
			}
		}
		if ($this->nKeySelected <= 0)
			$this->Page_Terminate("filesystemlist.php"); // No records selected, return to list
		switch ($filesystem->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					$this->setMessage("Update succeeded"); // Set update success message
					$this->Page_Terminate($filesystem->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$filesystem->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		global $filesystem;
		$filesystem->CurrentFilter = $this->BuildKeyFilter();

		// Load recordset
		$rs = $this->LoadRecordset();
		$i = 1;
		while (!$rs->EOF) {
			if ($i == 1) {
				$filesystem->gid->setDbValue($rs->fields('gid'));
				$filesystem->type->setDbValue($rs->fields('type'));
			} else {
				if (!ew_CompareValue($filesystem->gid->DbValue, $rs->fields('gid')))
					$filesystem->gid->CurrentValue = NULL;
				if (!ew_CompareValue($filesystem->type->DbValue, $rs->fields('type')))
					$filesystem->type->CurrentValue = NULL;
			}
			$i++;
			$rs->MoveNext();
		}
		$rs->Close();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $filesystem;
		$sWrkFilter = "";
		foreach ($this->arRecKeys as $sKey) {
			$sKey = trim($sKey);
			if ($this->SetupKeyValues($sKey)) {
				$sFilter = $filesystem->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}
		}
		return $sWrkFilter;
	}

	// Set up key value
	function SetupKeyValues($key) {
		global $filesystem;
		$sKeyFld = $key;
		if (!is_numeric($sKeyFld))
			return FALSE;
		$filesystem->id->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $conn, $filesystem;
		$conn->BeginTrans();

		// Get old recordset
		$filesystem->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $filesystem->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->arRecKeys as $sThisKey) {
			$sThisKey = trim($sThisKey);
			if ($this->SetupKeyValues($sThisKey)) {
				$filesystem->SendEmail = FALSE; // Do not send email on update success
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				return; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
		} else {
			$conn->RollbackTrans(); // Rollback transaction
		}
		return $UpdateRows;
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $filesystem;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $filesystem;
		$filesystem->gid->setFormValue($objForm->GetValue("x_gid"));
		$filesystem->gid->MultiUpdate = $objForm->GetValue("u_gid");
		$filesystem->type->setFormValue($objForm->GetValue("x_type"));
		$filesystem->type->MultiUpdate = $objForm->GetValue("u_type");
		$filesystem->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $filesystem;
		$filesystem->id->CurrentValue = $filesystem->id->FormValue;
		$filesystem->gid->CurrentValue = $filesystem->gid->FormValue;
		$filesystem->type->CurrentValue = $filesystem->type->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $filesystem;

		// Call Recordset Selecting event
		$filesystem->Recordset_Selecting($filesystem->CurrentFilter);

		// Load list page SQL
		$sSql = $filesystem->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$filesystem->Recordset_Selected($rs);
		return $rs;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $filesystem;

		// Call Row_Rendering event
		$filesystem->Row_Rendering();

		// Common render codes for all row types
		// gid

		$filesystem->gid->CellCssStyle = "";
		$filesystem->gid->CellCssClass = "";

		// type
		$filesystem->type->CellCssStyle = "";
		$filesystem->type->CellCssClass = "";
		if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$filesystem->id->ViewValue = $filesystem->id->CurrentValue;
			$filesystem->id->CssStyle = "";
			$filesystem->id->CssClass = "";
			$filesystem->id->ViewCustomAttributes = "";

			// mount
			$filesystem->mount->ViewValue = $filesystem->mount->CurrentValue;
			$filesystem->mount->CssStyle = "";
			$filesystem->mount->CssClass = "";
			$filesystem->mount->ViewCustomAttributes = "";

			// path
			$filesystem->path->ViewValue = $filesystem->path->CurrentValue;
			$filesystem->path->CssStyle = "";
			$filesystem->path->CssClass = "";
			$filesystem->path->ViewCustomAttributes = "";

			// parent
			$filesystem->parent->ViewValue = $filesystem->parent->CurrentValue;
			$filesystem->parent->CssStyle = "";
			$filesystem->parent->CssClass = "";
			$filesystem->parent->ViewCustomAttributes = "";

			// deprecated
			$filesystem->deprecated->ViewValue = $filesystem->deprecated->CurrentValue;
			$filesystem->deprecated->CssStyle = "";
			$filesystem->deprecated->CssClass = "";
			$filesystem->deprecated->ViewCustomAttributes = "";

			// gid
			if (strval($filesystem->gid->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `id`, `name` FROM `grp` WHERE `id` = " . ew_AdjustSql($filesystem->gid->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->gid->ViewValue = $rswrk->fields('id');
					$filesystem->gid->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
					$rswrk->Close();
				} else {
					$filesystem->gid->ViewValue = $filesystem->gid->CurrentValue;
				}
			} else {
				$filesystem->gid->ViewValue = NULL;
			}
			$filesystem->gid->CssStyle = "";
			$filesystem->gid->CssClass = "";
			$filesystem->gid->ViewCustomAttributes = "";

			// snapshot
			$filesystem->snapshot->ViewValue = $filesystem->snapshot->CurrentValue;
			$filesystem->snapshot->CssStyle = "";
			$filesystem->snapshot->CssClass = "";
			$filesystem->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$filesystem->tapebackup->ViewValue = $filesystem->tapebackup->CurrentValue;
			$filesystem->tapebackup->CssStyle = "";
			$filesystem->tapebackup->CssClass = "";
			$filesystem->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$filesystem->diskbackup->ViewValue = $filesystem->diskbackup->CurrentValue;
			$filesystem->diskbackup->CssStyle = "";
			$filesystem->diskbackup->CssClass = "";
			$filesystem->diskbackup->ViewCustomAttributes = "";

			// type
			if (strval($filesystem->type->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `id`, `name` FROM `server_type` WHERE `id` = " . ew_AdjustSql($filesystem->type->CurrentValue) . "";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->type->ViewValue = $rswrk->fields('id');
					$filesystem->type->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
					$rswrk->Close();
				} else {
					$filesystem->type->ViewValue = $filesystem->type->CurrentValue;
				}
			} else {
				$filesystem->type->ViewValue = NULL;
			}
			$filesystem->type->CssStyle = "";
			$filesystem->type->CssClass = "";
			$filesystem->type->ViewCustomAttributes = "";

			// gid
			$filesystem->gid->HrefValue = "";

			// type
			$filesystem->type->HrefValue = "";
		} elseif ($filesystem->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// gid
			$filesystem->gid->EditCustomAttributes = "";
			if ($filesystem->gid->getSessionValue() <> "") {
				$filesystem->gid->CurrentValue = $filesystem->gid->getSessionValue();
			if (strval($filesystem->gid->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `id`, `name` FROM `grp` WHERE `id` = " . ew_AdjustSql($filesystem->gid->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->gid->ViewValue = $rswrk->fields('id');
					$filesystem->gid->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
					$rswrk->Close();
				} else {
					$filesystem->gid->ViewValue = $filesystem->gid->CurrentValue;
				}
			} else {
				$filesystem->gid->ViewValue = NULL;
			}
			$filesystem->gid->CssStyle = "";
			$filesystem->gid->CssClass = "";
			$filesystem->gid->ViewCustomAttributes = "";
			} else {
			$sSqlWrk = "SELECT `id`, `id`, `name`, '' AS SelectFilterFld FROM `grp`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Please Select", ""));
			$filesystem->gid->EditValue = $arwrk;
			}

			// type
			$filesystem->type->EditCustomAttributes = "";
			if ($filesystem->type->getSessionValue() <> "") {
				$filesystem->type->CurrentValue = $filesystem->type->getSessionValue();
			if (strval($filesystem->type->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `id`, `name` FROM `server_type` WHERE `id` = " . ew_AdjustSql($filesystem->type->CurrentValue) . "";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->type->ViewValue = $rswrk->fields('id');
					$filesystem->type->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
					$rswrk->Close();
				} else {
					$filesystem->type->ViewValue = $filesystem->type->CurrentValue;
				}
			} else {
				$filesystem->type->ViewValue = NULL;
			}
			$filesystem->type->CssStyle = "";
			$filesystem->type->CssClass = "";
			$filesystem->type->ViewCustomAttributes = "";
			} else {
			$sSqlWrk = "SELECT `id`, `id`, `name`, '' AS SelectFilterFld FROM `server_type`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Please Select", ""));
			$filesystem->type->EditValue = $arwrk;
			}

			// Edit refer script
			// gid

			$filesystem->gid->HrefValue = "";

			// type
			$filesystem->type->HrefValue = "";
		}

		// Call Row Rendered event
		$filesystem->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $filesystem;

		// Initialize
		$gsFormError = "";
		$lUpdateCnt = 0;
		if ($filesystem->gid->MultiUpdate == "1") $lUpdateCnt++;
		if ($filesystem->type->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = "No field selected for update";
			return FALSE;
		}

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
		global $conn, $Security, $filesystem;
		$sFilter = $filesystem->KeyFilter();
		$filesystem->CurrentFilter = $sFilter;
		$sSql = $filesystem->SQL();
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

			// Field gid
						if ($filesystem->gid->MultiUpdate == "1") {
			$filesystem->gid->SetDbValueDef($filesystem->gid->CurrentValue, NULL);
			$rsnew['gid'] =& $filesystem->gid->DbValue;
			}

			// Field type
						if ($filesystem->type->MultiUpdate == "1") {
			$filesystem->type->SetDbValueDef($filesystem->type->CurrentValue, NULL);
			$rsnew['type'] =& $filesystem->type->DbValue;
			}

			// Call Row Updating event
			$bUpdateRow = $filesystem->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($filesystem->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($filesystem->CancelMessage <> "") {
					$this->setMessage($filesystem->CancelMessage);
					$filesystem->CancelMessage = "";
				} else {
					$this->setMessage("Update cancelled");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$filesystem->Row_Updated($rsold, $rsnew);
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
