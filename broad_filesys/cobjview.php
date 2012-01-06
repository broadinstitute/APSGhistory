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
$cobj_view = new ccobj_view();
$Page =& $cobj_view;

// Page init processing
$cobj_view->Page_Init();

// Page main processing
$cobj_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cobj->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cobj_view = new ew_Page("cobj_view");

// page properties
cobj_view.PageID = "view"; // page ID
var EW_PAGE_ID = cobj_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cobj_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cobj_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cobj_view.ValidateRequired = false; // no JavaScript validation
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
<?php } ?>
<p><span class="phpmaker">View TABLE: Cobj
<br><br>
<?php if ($cobj->Export == "") { ?>
<a href="cobjlist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $cobj->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $cobj_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cobj->cid->Visible) { // cid ?>
	<tr<?php echo $cobj->cid->RowAttributes ?>>
		<td class="ewTableHeader">Cid</td>
		<td<?php echo $cobj->cid->CellAttributes() ?>>
<div<?php echo $cobj->cid->ViewAttributes() ?>><?php echo $cobj->cid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cobj->class->Visible) { // class ?>
	<tr<?php echo $cobj->class->RowAttributes ?>>
		<td class="ewTableHeader">Class</td>
		<td<?php echo $cobj->class->CellAttributes() ?>>
<div<?php echo $cobj->class->ViewAttributes() ?>><?php echo $cobj->class->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cobj->name->Visible) { // name ?>
	<tr<?php echo $cobj->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $cobj->name->CellAttributes() ?>>
<div<?php echo $cobj->name->ViewAttributes() ?>><?php echo $cobj->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($cobj->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$cobj_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class ccobj_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'cobj';

	// Page Object Name
	var $PageObjName = 'cobj_view';

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
	function ccobj_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["cobj"] = new ccobj();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
	var $lDisplayRecs; // Number of display records
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs;
	var $lRecRange;
	var $lRecCnt;

	//
	// Page main processing
	//
	function Page_Main() {
		global $cobj;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["cid"] <> "") {
				$cobj->cid->setQueryStringValue($_GET["cid"]);
			} else {
				$sReturnUrl = "cobjlist.php"; // Return to list
			}

			// Get action
			$cobj->CurrentAction = "I"; // Display form
			switch ($cobj->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "cobjlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "cobjlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$cobj->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $cobj;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$cobj->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$cobj->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $cobj->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$cobj->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$cobj->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$cobj->setStartRecordNumber($this->lStartRec);
		}
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
		}

		// Call Row Rendered event
		$cobj->Row_Rendered();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}
}
?>
