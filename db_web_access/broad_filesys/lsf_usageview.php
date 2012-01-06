<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_usageinfo.php" ?>
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
$lsf_usage_view = new clsf_usage_view();
$Page =& $lsf_usage_view;

// Page init processing
$lsf_usage_view->Page_Init();

// Page main processing
$lsf_usage_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lsf_usage->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_usage_view = new ew_Page("lsf_usage_view");

// page properties
lsf_usage_view.PageID = "view"; // page ID
var EW_PAGE_ID = lsf_usage_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_usage_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_usage_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_usage_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Lsf Usage
<br><br>
<?php if ($lsf_usage->Export == "") { ?>
<a href="lsf_usagelist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lsf_usage->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $lsf_usage_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lsf_usage->date->Visible) { // date ?>
	<tr<?php echo $lsf_usage->date->RowAttributes ?>>
		<td class="ewTableHeader">Date</td>
		<td<?php echo $lsf_usage->date->CellAttributes() ?>>
<div<?php echo $lsf_usage->date->ViewAttributes() ?>><?php echo $lsf_usage->date->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->uid->Visible) { // uid ?>
	<tr<?php echo $lsf_usage->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid</td>
		<td<?php echo $lsf_usage->uid->CellAttributes() ?>>
<div<?php echo $lsf_usage->uid->ViewAttributes() ?>><?php echo $lsf_usage->uid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->qid->Visible) { // qid ?>
	<tr<?php echo $lsf_usage->qid->RowAttributes ?>>
		<td class="ewTableHeader">Qid</td>
		<td<?php echo $lsf_usage->qid->CellAttributes() ?>>
<div<?php echo $lsf_usage->qid->ViewAttributes() ?>><?php echo $lsf_usage->qid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->cpu->Visible) { // cpu ?>
	<tr<?php echo $lsf_usage->cpu->RowAttributes ?>>
		<td class="ewTableHeader">Cpu</td>
		<td<?php echo $lsf_usage->cpu->CellAttributes() ?>>
<div<?php echo $lsf_usage->cpu->ViewAttributes() ?>><?php echo $lsf_usage->cpu->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->job->Visible) { // job ?>
	<tr<?php echo $lsf_usage->job->RowAttributes ?>>
		<td class="ewTableHeader">Job</td>
		<td<?php echo $lsf_usage->job->CellAttributes() ?>>
<div<?php echo $lsf_usage->job->ViewAttributes() ?>><?php echo $lsf_usage->job->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_usage->pid->Visible) { // pid ?>
	<tr<?php echo $lsf_usage->pid->RowAttributes ?>>
		<td class="ewTableHeader">Pid</td>
		<td<?php echo $lsf_usage->pid->CellAttributes() ?>>
<div<?php echo $lsf_usage->pid->ViewAttributes() ?>><?php echo $lsf_usage->pid->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($lsf_usage->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lsf_usage_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_usage_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'lsf_usage';

	// Page Object Name
	var $PageObjName = 'lsf_usage_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_usage;
		if ($lsf_usage->UseTokenInUrl) $PageUrl .= "t=" . $lsf_usage->TableVar . "&"; // add page token
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
		global $objForm, $lsf_usage;
		if ($lsf_usage->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_usage->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_usage->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_usage_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_usage"] = new clsf_usage();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_usage', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_usage;
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
		global $lsf_usage;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["date"] <> "") {
				$lsf_usage->date->setQueryStringValue($_GET["date"]);
			} else {
				$sReturnUrl = "lsf_usagelist.php"; // Return to list
			}
			if (@$_GET["uid"] <> "") {
				$lsf_usage->uid->setQueryStringValue($_GET["uid"]);
			} else {
				$sReturnUrl = "lsf_usagelist.php"; // Return to list
			}
			if (@$_GET["qid"] <> "") {
				$lsf_usage->qid->setQueryStringValue($_GET["qid"]);
			} else {
				$sReturnUrl = "lsf_usagelist.php"; // Return to list
			}

			// Get action
			$lsf_usage->CurrentAction = "I"; // Display form
			switch ($lsf_usage->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "lsf_usagelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "lsf_usagelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$lsf_usage->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $lsf_usage;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lsf_usage->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lsf_usage->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lsf_usage->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lsf_usage->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lsf_usage->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lsf_usage->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_usage;
		$sFilter = $lsf_usage->KeyFilter();

		// Call Row Selecting event
		$lsf_usage->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_usage->CurrentFilter = $sFilter;
		$sSql = $lsf_usage->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_usage->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_usage;
		$lsf_usage->date->setDbValue($rs->fields('date'));
		$lsf_usage->uid->setDbValue($rs->fields('uid'));
		$lsf_usage->qid->setDbValue($rs->fields('qid'));
		$lsf_usage->cpu->setDbValue($rs->fields('cpu'));
		$lsf_usage->job->setDbValue($rs->fields('job'));
		$lsf_usage->pid->setDbValue($rs->fields('pid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_usage;

		// Call Row_Rendering event
		$lsf_usage->Row_Rendering();

		// Common render codes for all row types
		// date

		$lsf_usage->date->CellCssStyle = "";
		$lsf_usage->date->CellCssClass = "";

		// uid
		$lsf_usage->uid->CellCssStyle = "";
		$lsf_usage->uid->CellCssClass = "";

		// qid
		$lsf_usage->qid->CellCssStyle = "";
		$lsf_usage->qid->CellCssClass = "";

		// cpu
		$lsf_usage->cpu->CellCssStyle = "";
		$lsf_usage->cpu->CellCssClass = "";

		// job
		$lsf_usage->job->CellCssStyle = "";
		$lsf_usage->job->CellCssClass = "";

		// pid
		$lsf_usage->pid->CellCssStyle = "";
		$lsf_usage->pid->CellCssClass = "";
		if ($lsf_usage->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$lsf_usage->date->ViewValue = $lsf_usage->date->CurrentValue;
			$lsf_usage->date->CssStyle = "";
			$lsf_usage->date->CssClass = "";
			$lsf_usage->date->ViewCustomAttributes = "";

			// uid
			$lsf_usage->uid->ViewValue = $lsf_usage->uid->CurrentValue;
			$lsf_usage->uid->CssStyle = "";
			$lsf_usage->uid->CssClass = "";
			$lsf_usage->uid->ViewCustomAttributes = "";

			// qid
			$lsf_usage->qid->ViewValue = $lsf_usage->qid->CurrentValue;
			$lsf_usage->qid->CssStyle = "";
			$lsf_usage->qid->CssClass = "";
			$lsf_usage->qid->ViewCustomAttributes = "";

			// cpu
			$lsf_usage->cpu->ViewValue = $lsf_usage->cpu->CurrentValue;
			$lsf_usage->cpu->CssStyle = "";
			$lsf_usage->cpu->CssClass = "";
			$lsf_usage->cpu->ViewCustomAttributes = "";

			// job
			$lsf_usage->job->ViewValue = $lsf_usage->job->CurrentValue;
			$lsf_usage->job->CssStyle = "";
			$lsf_usage->job->CssClass = "";
			$lsf_usage->job->ViewCustomAttributes = "";

			// pid
			$lsf_usage->pid->ViewValue = $lsf_usage->pid->CurrentValue;
			$lsf_usage->pid->CssStyle = "";
			$lsf_usage->pid->CssClass = "";
			$lsf_usage->pid->ViewCustomAttributes = "";

			// date
			$lsf_usage->date->HrefValue = "";

			// uid
			$lsf_usage->uid->HrefValue = "";

			// qid
			$lsf_usage->qid->HrefValue = "";

			// cpu
			$lsf_usage->cpu->HrefValue = "";

			// job
			$lsf_usage->job->HrefValue = "";

			// pid
			$lsf_usage->pid->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_usage->Row_Rendered();
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
