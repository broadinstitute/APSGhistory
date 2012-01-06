<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_testinfo.php" ?>
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
$lsf_test_view = new clsf_test_view();
$Page =& $lsf_test_view;

// Page init processing
$lsf_test_view->Page_Init();

// Page main processing
$lsf_test_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lsf_test->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_test_view = new ew_Page("lsf_test_view");

// page properties
lsf_test_view.PageID = "view"; // page ID
var EW_PAGE_ID = lsf_test_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_test_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_test_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_test_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Lsf Test
<br><br>
<?php if ($lsf_test->Export == "") { ?>
<a href="lsf_testlist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lsf_test->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $lsf_test_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lsf_test->date->Visible) { // date ?>
	<tr<?php echo $lsf_test->date->RowAttributes ?>>
		<td class="ewTableHeader">Date</td>
		<td<?php echo $lsf_test->date->CellAttributes() ?>>
<div<?php echo $lsf_test->date->ViewAttributes() ?>><?php echo $lsf_test->date->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_test->uid->Visible) { // uid ?>
	<tr<?php echo $lsf_test->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid</td>
		<td<?php echo $lsf_test->uid->CellAttributes() ?>>
<div<?php echo $lsf_test->uid->ViewAttributes() ?>><?php echo $lsf_test->uid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_test->qid->Visible) { // qid ?>
	<tr<?php echo $lsf_test->qid->RowAttributes ?>>
		<td class="ewTableHeader">Qid</td>
		<td<?php echo $lsf_test->qid->CellAttributes() ?>>
<div<?php echo $lsf_test->qid->ViewAttributes() ?>><?php echo $lsf_test->qid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_test->cpu->Visible) { // cpu ?>
	<tr<?php echo $lsf_test->cpu->RowAttributes ?>>
		<td class="ewTableHeader">Cpu</td>
		<td<?php echo $lsf_test->cpu->CellAttributes() ?>>
<div<?php echo $lsf_test->cpu->ViewAttributes() ?>><?php echo $lsf_test->cpu->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_test->job->Visible) { // job ?>
	<tr<?php echo $lsf_test->job->RowAttributes ?>>
		<td class="ewTableHeader">Job</td>
		<td<?php echo $lsf_test->job->CellAttributes() ?>>
<div<?php echo $lsf_test->job->ViewAttributes() ?>><?php echo $lsf_test->job->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($lsf_test->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lsf_test_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_test_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'lsf_test';

	// Page Object Name
	var $PageObjName = 'lsf_test_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_test;
		if ($lsf_test->UseTokenInUrl) $PageUrl .= "t=" . $lsf_test->TableVar . "&"; // add page token
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
		global $objForm, $lsf_test;
		if ($lsf_test->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_test->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_test->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_test_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_test"] = new clsf_test();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_test', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_test;
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
		global $lsf_test;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["date"] <> "") {
				$lsf_test->date->setQueryStringValue($_GET["date"]);
			} else {
				$sReturnUrl = "lsf_testlist.php"; // Return to list
			}
			if (@$_GET["uid"] <> "") {
				$lsf_test->uid->setQueryStringValue($_GET["uid"]);
			} else {
				$sReturnUrl = "lsf_testlist.php"; // Return to list
			}
			if (@$_GET["qid"] <> "") {
				$lsf_test->qid->setQueryStringValue($_GET["qid"]);
			} else {
				$sReturnUrl = "lsf_testlist.php"; // Return to list
			}

			// Get action
			$lsf_test->CurrentAction = "I"; // Display form
			switch ($lsf_test->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "lsf_testlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "lsf_testlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$lsf_test->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $lsf_test;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lsf_test->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lsf_test->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lsf_test->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lsf_test->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lsf_test->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lsf_test->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_test;
		$sFilter = $lsf_test->KeyFilter();

		// Call Row Selecting event
		$lsf_test->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_test->CurrentFilter = $sFilter;
		$sSql = $lsf_test->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_test->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_test;
		$lsf_test->date->setDbValue($rs->fields('date'));
		$lsf_test->uid->setDbValue($rs->fields('uid'));
		$lsf_test->qid->setDbValue($rs->fields('qid'));
		$lsf_test->cpu->setDbValue($rs->fields('cpu'));
		$lsf_test->job->setDbValue($rs->fields('job'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_test;

		// Call Row_Rendering event
		$lsf_test->Row_Rendering();

		// Common render codes for all row types
		// date

		$lsf_test->date->CellCssStyle = "";
		$lsf_test->date->CellCssClass = "";

		// uid
		$lsf_test->uid->CellCssStyle = "";
		$lsf_test->uid->CellCssClass = "";

		// qid
		$lsf_test->qid->CellCssStyle = "";
		$lsf_test->qid->CellCssClass = "";

		// cpu
		$lsf_test->cpu->CellCssStyle = "";
		$lsf_test->cpu->CellCssClass = "";

		// job
		$lsf_test->job->CellCssStyle = "";
		$lsf_test->job->CellCssClass = "";
		if ($lsf_test->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$lsf_test->date->ViewValue = $lsf_test->date->CurrentValue;
			$lsf_test->date->CssStyle = "";
			$lsf_test->date->CssClass = "";
			$lsf_test->date->ViewCustomAttributes = "";

			// uid
			$lsf_test->uid->ViewValue = $lsf_test->uid->CurrentValue;
			$lsf_test->uid->CssStyle = "";
			$lsf_test->uid->CssClass = "";
			$lsf_test->uid->ViewCustomAttributes = "";

			// qid
			$lsf_test->qid->ViewValue = $lsf_test->qid->CurrentValue;
			$lsf_test->qid->CssStyle = "";
			$lsf_test->qid->CssClass = "";
			$lsf_test->qid->ViewCustomAttributes = "";

			// cpu
			$lsf_test->cpu->ViewValue = $lsf_test->cpu->CurrentValue;
			$lsf_test->cpu->CssStyle = "";
			$lsf_test->cpu->CssClass = "";
			$lsf_test->cpu->ViewCustomAttributes = "";

			// job
			$lsf_test->job->ViewValue = $lsf_test->job->CurrentValue;
			$lsf_test->job->CssStyle = "";
			$lsf_test->job->CssClass = "";
			$lsf_test->job->ViewCustomAttributes = "";

			// date
			$lsf_test->date->HrefValue = "";

			// uid
			$lsf_test->uid->HrefValue = "";

			// qid
			$lsf_test->qid->HrefValue = "";

			// cpu
			$lsf_test->cpu->HrefValue = "";

			// job
			$lsf_test->job->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_test->Row_Rendered();
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
