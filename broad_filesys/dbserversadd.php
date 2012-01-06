<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "dbserversinfo.php" ?>
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
$dbservers_add = new cdbservers_add();
$Page =& $dbservers_add;

// Page init processing
$dbservers_add->Page_Init();

// Page main processing
$dbservers_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var dbservers_add = new ew_Page("dbservers_add");

// page properties
dbservers_add.PageID = "add"; // page ID
var EW_PAGE_ID = dbservers_add.PageID; // for backward compatibility

// extend page with ValidateForm function
dbservers_add.ValidateForm = function(fobj) {
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
dbservers_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
dbservers_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
dbservers_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Add to TABLE: Dbservers<br><br>
<a href="<?php echo $dbservers->getReturnUrl() ?>">Go Back</a></span></p>
<?php $dbservers_add->ShowMessage() ?>
<form name="fdbserversadd" id="fdbserversadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return dbservers_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="dbservers">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($dbservers->name->Visible) { // name ?>
	<tr<?php echo $dbservers->name->RowAttributes ?>>
		<td class="ewTableHeader">Name<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $dbservers->name->CellAttributes() ?>><span id="el_name">
<input type="text" name="x_name" id="x_name" size="30" maxlength="45" value="<?php echo $dbservers->name->EditValue ?>"<?php echo $dbservers->name->EditAttributes() ?>>
</span><?php echo $dbservers->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($dbservers->gid->Visible) { // gid ?>
	<tr<?php echo $dbservers->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $dbservers->gid->CellAttributes() ?>><span id="el_gid">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $dbservers->gid->EditValue ?>"<?php echo $dbservers->gid->EditAttributes() ?>>
</span><?php echo $dbservers->gid->CustomMsg ?></td>
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
$dbservers_add->Page_Terminate();
?>
<?php

//
// Page Class
//
class cdbservers_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'dbservers';

	// Page Object Name
	var $PageObjName = 'dbservers_add';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $dbservers;
		if ($dbservers->UseTokenInUrl) $PageUrl .= "t=" . $dbservers->TableVar . "&"; // add page token
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
		global $objForm, $dbservers;
		if ($dbservers->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($dbservers->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($dbservers->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdbservers_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["dbservers"] = new cdbservers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dbservers', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $dbservers;
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
		global $objForm, $gsFormError, $dbservers;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["id"] != "") {
		  $dbservers->id->setQueryStringValue($_GET["id"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $dbservers->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$dbservers->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $dbservers->CurrentAction = "C"; // Copy Record
		  } else {
		    $dbservers->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($dbservers->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No records found"); // No record found
		      $this->Page_Terminate("dbserverslist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$dbservers->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Add succeeded"); // Set up success message
					$sReturnUrl = $dbservers->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$dbservers->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $dbservers;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $dbservers;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $dbservers;
		$dbservers->name->setFormValue($objForm->GetValue("x_name"));
		$dbservers->gid->setFormValue($objForm->GetValue("x_gid"));
		$dbservers->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $dbservers;
		$dbservers->id->CurrentValue = $dbservers->id->FormValue;
		$dbservers->name->CurrentValue = $dbservers->name->FormValue;
		$dbservers->gid->CurrentValue = $dbservers->gid->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $dbservers;
		$sFilter = $dbservers->KeyFilter();

		// Call Row Selecting event
		$dbservers->Row_Selecting($sFilter);

		// Load sql based on filter
		$dbservers->CurrentFilter = $sFilter;
		$sSql = $dbservers->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$dbservers->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $dbservers;
		$dbservers->id->setDbValue($rs->fields('id'));
		$dbservers->name->setDbValue($rs->fields('name'));
		$dbservers->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $dbservers;

		// Call Row_Rendering event
		$dbservers->Row_Rendering();

		// Common render codes for all row types
		// name

		$dbservers->name->CellCssStyle = "";
		$dbservers->name->CellCssClass = "";

		// gid
		$dbservers->gid->CellCssStyle = "";
		$dbservers->gid->CellCssClass = "";
		if ($dbservers->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$dbservers->id->ViewValue = $dbservers->id->CurrentValue;
			$dbservers->id->CssStyle = "";
			$dbservers->id->CssClass = "";
			$dbservers->id->ViewCustomAttributes = "";

			// name
			$dbservers->name->ViewValue = $dbservers->name->CurrentValue;
			$dbservers->name->CssStyle = "";
			$dbservers->name->CssClass = "";
			$dbservers->name->ViewCustomAttributes = "";

			// gid
			$dbservers->gid->ViewValue = $dbservers->gid->CurrentValue;
			$dbservers->gid->CssStyle = "";
			$dbservers->gid->CssClass = "";
			$dbservers->gid->ViewCustomAttributes = "";

			// name
			$dbservers->name->HrefValue = "";

			// gid
			$dbservers->gid->HrefValue = "";
		} elseif ($dbservers->RowType == EW_ROWTYPE_ADD) { // Add row

			// name
			$dbservers->name->EditCustomAttributes = "";
			$dbservers->name->EditValue = ew_HtmlEncode($dbservers->name->CurrentValue);

			// gid
			$dbservers->gid->EditCustomAttributes = "";
			$dbservers->gid->EditValue = ew_HtmlEncode($dbservers->gid->CurrentValue);
		}

		// Call Row Rendered event
		$dbservers->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $dbservers;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($dbservers->name->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Please enter required field - Name";
		}
		if (!ew_CheckInteger($dbservers->gid->FormValue)) {
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
		global $conn, $Security, $dbservers;
		$rsnew = array();

		// Field name
		$dbservers->name->SetDbValueDef($dbservers->name->CurrentValue, "");
		$rsnew['name'] =& $dbservers->name->DbValue;

		// Field gid
		$dbservers->gid->SetDbValueDef($dbservers->gid->CurrentValue, NULL);
		$rsnew['gid'] =& $dbservers->gid->DbValue;

		// Call Row Inserting event
		$bInsertRow = $dbservers->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($dbservers->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($dbservers->CancelMessage <> "") {
				$this->setMessage($dbservers->CancelMessage);
				$dbservers->CancelMessage = "";
			} else {
				$this->setMessage("Insert cancelled");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$dbservers->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] =& $dbservers->id->DbValue;

			// Call Row Inserted event
			$dbservers->Row_Inserted($rsnew);
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
