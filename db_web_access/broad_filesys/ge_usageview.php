<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "ge_usageinfo.php" ?>
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
$ge_usage_view = new cge_usage_view();
$Page =& $ge_usage_view;

// Page init processing
$ge_usage_view->Page_Init();

// Page main processing
$ge_usage_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($ge_usage->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ge_usage_view = new ew_Page("ge_usage_view");

// page properties
ge_usage_view.PageID = "view"; // page ID
var EW_PAGE_ID = ge_usage_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ge_usage_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_usage_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_usage_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Ge Usage
<br><br>
<?php if ($ge_usage->Export == "") { ?>
<a href="ge_usagelist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_usage->AddUrl() ?>">Add</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_usage->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_usage->CopyUrl() ?>">Copy</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_usage->DeleteUrl() ?>">Delete</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $ge_usage_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ge_usage->date->Visible) { // date ?>
	<tr<?php echo $ge_usage->date->RowAttributes ?>>
		<td class="ewTableHeader">Date</td>
		<td<?php echo $ge_usage->date->CellAttributes() ?>>
<div<?php echo $ge_usage->date->ViewAttributes() ?>><?php echo $ge_usage->date->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->uid->Visible) { // uid ?>
	<tr<?php echo $ge_usage->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid</td>
		<td<?php echo $ge_usage->uid->CellAttributes() ?>>
<div<?php echo $ge_usage->uid->ViewAttributes() ?>><?php echo $ge_usage->uid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->qid->Visible) { // qid ?>
	<tr<?php echo $ge_usage->qid->RowAttributes ?>>
		<td class="ewTableHeader">Qid</td>
		<td<?php echo $ge_usage->qid->CellAttributes() ?>>
<div<?php echo $ge_usage->qid->ViewAttributes() ?>><?php echo $ge_usage->qid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->pid->Visible) { // pid ?>
	<tr<?php echo $ge_usage->pid->RowAttributes ?>>
		<td class="ewTableHeader">Pid</td>
		<td<?php echo $ge_usage->pid->CellAttributes() ?>>
<div<?php echo $ge_usage->pid->ViewAttributes() ?>><?php echo $ge_usage->pid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->cpu->Visible) { // cpu ?>
	<tr<?php echo $ge_usage->cpu->RowAttributes ?>>
		<td class="ewTableHeader">Cpu</td>
		<td<?php echo $ge_usage->cpu->CellAttributes() ?>>
<div<?php echo $ge_usage->cpu->ViewAttributes() ?>><?php echo $ge_usage->cpu->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_usage->job->Visible) { // job ?>
	<tr<?php echo $ge_usage->job->RowAttributes ?>>
		<td class="ewTableHeader">Job</td>
		<td<?php echo $ge_usage->job->CellAttributes() ?>>
<div<?php echo $ge_usage->job->ViewAttributes() ?>><?php echo $ge_usage->job->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($ge_usage->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$ge_usage_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_usage_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'ge_usage';

	// Page Object Name
	var $PageObjName = 'ge_usage_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ge_usage;
		if ($ge_usage->UseTokenInUrl) $PageUrl .= "t=" . $ge_usage->TableVar . "&"; // add page token
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
		global $objForm, $ge_usage;
		if ($ge_usage->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($ge_usage->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ge_usage->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cge_usage_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_usage"] = new cge_usage();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ge_usage', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ge_usage;
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
		global $ge_usage;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["date"] <> "") {
				$ge_usage->date->setQueryStringValue($_GET["date"]);
			} else {
				$sReturnUrl = "ge_usagelist.php"; // Return to list
			}
			if (@$_GET["uid"] <> "") {
				$ge_usage->uid->setQueryStringValue($_GET["uid"]);
			} else {
				$sReturnUrl = "ge_usagelist.php"; // Return to list
			}
			if (@$_GET["qid"] <> "") {
				$ge_usage->qid->setQueryStringValue($_GET["qid"]);
			} else {
				$sReturnUrl = "ge_usagelist.php"; // Return to list
			}

			// Get action
			$ge_usage->CurrentAction = "I"; // Display form
			switch ($ge_usage->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "ge_usagelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ge_usagelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$ge_usage->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $ge_usage;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$ge_usage->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$ge_usage->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $ge_usage->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$ge_usage->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$ge_usage->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$ge_usage->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ge_usage;
		$sFilter = $ge_usage->KeyFilter();

		// Call Row Selecting event
		$ge_usage->Row_Selecting($sFilter);

		// Load sql based on filter
		$ge_usage->CurrentFilter = $sFilter;
		$sSql = $ge_usage->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$ge_usage->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $ge_usage;
		$ge_usage->date->setDbValue($rs->fields('date'));
		$ge_usage->uid->setDbValue($rs->fields('uid'));
		$ge_usage->qid->setDbValue($rs->fields('qid'));
		$ge_usage->pid->setDbValue($rs->fields('pid'));
		$ge_usage->cpu->setDbValue($rs->fields('cpu'));
		$ge_usage->job->setDbValue($rs->fields('job'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $ge_usage;

		// Call Row_Rendering event
		$ge_usage->Row_Rendering();

		// Common render codes for all row types
		// date

		$ge_usage->date->CellCssStyle = "";
		$ge_usage->date->CellCssClass = "";

		// uid
		$ge_usage->uid->CellCssStyle = "";
		$ge_usage->uid->CellCssClass = "";

		// qid
		$ge_usage->qid->CellCssStyle = "";
		$ge_usage->qid->CellCssClass = "";

		// pid
		$ge_usage->pid->CellCssStyle = "";
		$ge_usage->pid->CellCssClass = "";

		// cpu
		$ge_usage->cpu->CellCssStyle = "";
		$ge_usage->cpu->CellCssClass = "";

		// job
		$ge_usage->job->CellCssStyle = "";
		$ge_usage->job->CellCssClass = "";
		if ($ge_usage->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$ge_usage->date->ViewValue = $ge_usage->date->CurrentValue;
			$ge_usage->date->CssStyle = "";
			$ge_usage->date->CssClass = "";
			$ge_usage->date->ViewCustomAttributes = "";

			// uid
			$ge_usage->uid->ViewValue = $ge_usage->uid->CurrentValue;
			$ge_usage->uid->CssStyle = "";
			$ge_usage->uid->CssClass = "";
			$ge_usage->uid->ViewCustomAttributes = "";

			// qid
			$ge_usage->qid->ViewValue = $ge_usage->qid->CurrentValue;
			$ge_usage->qid->CssStyle = "";
			$ge_usage->qid->CssClass = "";
			$ge_usage->qid->ViewCustomAttributes = "";

			// pid
			$ge_usage->pid->ViewValue = $ge_usage->pid->CurrentValue;
			$ge_usage->pid->CssStyle = "";
			$ge_usage->pid->CssClass = "";
			$ge_usage->pid->ViewCustomAttributes = "";

			// cpu
			$ge_usage->cpu->ViewValue = $ge_usage->cpu->CurrentValue;
			$ge_usage->cpu->CssStyle = "";
			$ge_usage->cpu->CssClass = "";
			$ge_usage->cpu->ViewCustomAttributes = "";

			// job
			$ge_usage->job->ViewValue = $ge_usage->job->CurrentValue;
			$ge_usage->job->CssStyle = "";
			$ge_usage->job->CssClass = "";
			$ge_usage->job->ViewCustomAttributes = "";

			// date
			$ge_usage->date->HrefValue = "";

			// uid
			$ge_usage->uid->HrefValue = "";

			// qid
			$ge_usage->qid->HrefValue = "";

			// pid
			$ge_usage->pid->HrefValue = "";

			// cpu
			$ge_usage->cpu->HrefValue = "";

			// job
			$ge_usage->job->HrefValue = "";
		}

		// Call Row Rendered event
		$ge_usage->Row_Rendered();
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
