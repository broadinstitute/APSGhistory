<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "ge_queuesinfo.php" ?>
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
$ge_queues_add = new cge_queues_add();
$Page =& $ge_queues_add;

// Page init processing
$ge_queues_add->Page_Init();

// Page main processing
$ge_queues_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var ge_queues_add = new ew_Page("ge_queues_add");

// page properties
ge_queues_add.PageID = "add"; // page ID
var EW_PAGE_ID = ge_queues_add.PageID; // for backward compatibility

// extend page with ValidateForm function
ge_queues_add.ValidateForm = function(fobj) {
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
ge_queues_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_queues_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_queues_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Add to TABLE: Ge Queues<br><br>
<a href="<?php echo $ge_queues->getReturnUrl() ?>">Go Back</a></span></p>
<?php $ge_queues_add->ShowMessage() ?>
<form name="fge_queuesadd" id="fge_queuesadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ge_queues_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="ge_queues">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ge_queues->name->Visible) { // name ?>
	<tr<?php echo $ge_queues->name->RowAttributes ?>>
		<td class="ewTableHeader">Name<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $ge_queues->name->CellAttributes() ?>><span id="el_name">
<input type="text" name="x_name" id="x_name" size="30" maxlength="45" value="<?php echo $ge_queues->name->EditValue ?>"<?php echo $ge_queues->name->EditAttributes() ?>>
</span><?php echo $ge_queues->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ge_queues->gid->Visible) { // gid ?>
	<tr<?php echo $ge_queues->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $ge_queues->gid->CellAttributes() ?>><span id="el_gid">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $ge_queues->gid->EditValue ?>"<?php echo $ge_queues->gid->EditAttributes() ?>>
</span><?php echo $ge_queues->gid->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="    Add    ">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$ge_queues_add->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_queues_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'ge_queues';

	// Page Object Name
	var $PageObjName = 'ge_queues_add';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ge_queues;
		if ($ge_queues->UseTokenInUrl) $PageUrl .= "t=" . $ge_queues->TableVar . "&"; // add page token
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
		global $objForm, $ge_queues;
		if ($ge_queues->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($ge_queues->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ge_queues->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cge_queues_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_queues"] = new cge_queues();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ge_queues', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ge_queues;
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
	var $x_ewPriv = 0;

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $ge_queues;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["id"] != "") {
		  $ge_queues->id->setQueryStringValue($_GET["id"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $ge_queues->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$ge_queues->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $ge_queues->CurrentAction = "C"; // Copy Record
		  } else {
		    $ge_queues->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($ge_queues->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No records found"); // No record found
		      $this->Page_Terminate("ge_queueslist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$ge_queues->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Add succeeded"); // Set up success message
					$sReturnUrl = $ge_queues->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$ge_queues->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $ge_queues;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $ge_queues;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $ge_queues;
		$ge_queues->name->setFormValue($objForm->GetValue("x_name"));
		$ge_queues->gid->setFormValue($objForm->GetValue("x_gid"));
		$ge_queues->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $ge_queues;
		$ge_queues->id->CurrentValue = $ge_queues->id->FormValue;
		$ge_queues->name->CurrentValue = $ge_queues->name->FormValue;
		$ge_queues->gid->CurrentValue = $ge_queues->gid->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ge_queues;
		$sFilter = $ge_queues->KeyFilter();

		// Call Row Selecting event
		$ge_queues->Row_Selecting($sFilter);

		// Load sql based on filter
		$ge_queues->CurrentFilter = $sFilter;
		$sSql = $ge_queues->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$ge_queues->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $ge_queues;
		$ge_queues->id->setDbValue($rs->fields('id'));
		$ge_queues->name->setDbValue($rs->fields('name'));
		$ge_queues->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $ge_queues;

		// Call Row_Rendering event
		$ge_queues->Row_Rendering();

		// Common render codes for all row types
		// name

		$ge_queues->name->CellCssStyle = "";
		$ge_queues->name->CellCssClass = "";

		// gid
		$ge_queues->gid->CellCssStyle = "";
		$ge_queues->gid->CellCssClass = "";
		if ($ge_queues->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$ge_queues->id->ViewValue = $ge_queues->id->CurrentValue;
			$ge_queues->id->CssStyle = "";
			$ge_queues->id->CssClass = "";
			$ge_queues->id->ViewCustomAttributes = "";

			// name
			$ge_queues->name->ViewValue = $ge_queues->name->CurrentValue;
			$ge_queues->name->CssStyle = "";
			$ge_queues->name->CssClass = "";
			$ge_queues->name->ViewCustomAttributes = "";

			// gid
			$ge_queues->gid->ViewValue = $ge_queues->gid->CurrentValue;
			$ge_queues->gid->CssStyle = "";
			$ge_queues->gid->CssClass = "";
			$ge_queues->gid->ViewCustomAttributes = "";

			// name
			$ge_queues->name->HrefValue = "";

			// gid
			$ge_queues->gid->HrefValue = "";
		} elseif ($ge_queues->RowType == EW_ROWTYPE_ADD) { // Add row

			// name
			$ge_queues->name->EditCustomAttributes = "";
			$ge_queues->name->EditValue = ew_HtmlEncode($ge_queues->name->CurrentValue);

			// gid
			$ge_queues->gid->EditCustomAttributes = "";
			$ge_queues->gid->EditValue = ew_HtmlEncode($ge_queues->gid->CurrentValue);
		}

		// Call Row Rendered event
		$ge_queues->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $ge_queues;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($ge_queues->name->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Name";
		}
		if (!ew_CheckInteger($ge_queues->gid->FormValue)) {
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

	// Add record
	function AddRow() {
		global $conn, $Security, $ge_queues;
		$rsnew = array();

		// Field name
		$ge_queues->name->SetDbValueDef($ge_queues->name->CurrentValue, "");
		$rsnew['name'] =& $ge_queues->name->DbValue;

		// Field gid
		$ge_queues->gid->SetDbValueDef($ge_queues->gid->CurrentValue, NULL);
		$rsnew['gid'] =& $ge_queues->gid->DbValue;

		// Call Row Inserting event
		$bInsertRow = $ge_queues->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($ge_queues->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($ge_queues->CancelMessage <> "") {
				$this->setMessage($ge_queues->CancelMessage);
				$ge_queues->CancelMessage = "";
			} else {
				$this->setMessage("Insert cancelled");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$ge_queues->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] =& $ge_queues->id->DbValue;

			// Call Row Inserted event
			$ge_queues->Row_Inserted($rsnew);
		}
		return $AddRow;
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
