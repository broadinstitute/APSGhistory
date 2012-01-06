<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "bjobsinfo.php" ?>
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
$bjobs_view = new cbjobs_view();
$Page =& $bjobs_view;

// Page init processing
$bjobs_view->Page_Init();

// Page main processing
$bjobs_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($bjobs->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var bjobs_view = new ew_Page("bjobs_view");

// page properties
bjobs_view.PageID = "view"; // page ID
var EW_PAGE_ID = bjobs_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
bjobs_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
bjobs_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
bjobs_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Bjobs
<br><br>
<?php if ($bjobs->Export == "") { ?>
<a href="bjobslist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $bjobs->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $bjobs_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($bjobs->checked->Visible) { // checked ?>
	<tr<?php echo $bjobs->checked->RowAttributes ?>>
		<td class="ewTableHeader">Checked</td>
		<td<?php echo $bjobs->checked->CellAttributes() ?>>
<div<?php echo $bjobs->checked->ViewAttributes() ?>><?php echo $bjobs->checked->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($bjobs->jobslots->Visible) { // jobslots ?>
	<tr<?php echo $bjobs->jobslots->RowAttributes ?>>
		<td class="ewTableHeader">Jobslots</td>
		<td<?php echo $bjobs->jobslots->CellAttributes() ?>>
<div<?php echo $bjobs->jobslots->ViewAttributes() ?>><?php echo $bjobs->jobslots->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($bjobs->bjobs->Visible) { // bjobs ?>
	<tr<?php echo $bjobs->bjobs->RowAttributes ?>>
		<td class="ewTableHeader">Bjobs</td>
		<td<?php echo $bjobs->bjobs->CellAttributes() ?>>
<?php if ($bjobs->bjobs->HrefValue <> "") { ?>
<?php if (!is_null($bjobs->bjobs->Upload->DbValue)) { ?>
<a href="<?php echo $bjobs->bjobs->HrefValue ?>" target="_blank"><?php echo $bjobs->bjobs->ViewValue ?></a>
<?php } elseif (!in_array($bjobs->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!is_null($bjobs->bjobs->Upload->DbValue)) { ?>
<?php echo $bjobs->bjobs->ViewValue ?>
<?php } elseif (!in_array($bjobs->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($bjobs->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$bjobs_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cbjobs_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'bjobs';

	// Page Object Name
	var $PageObjName = 'bjobs_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $bjobs;
		if ($bjobs->UseTokenInUrl) $PageUrl .= "t=" . $bjobs->TableVar . "&"; // add page token
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
		global $objForm, $bjobs;
		if ($bjobs->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($bjobs->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($bjobs->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cbjobs_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["bjobs"] = new cbjobs();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'bjobs', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $bjobs;
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
		global $bjobs;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["checked"] <> "") {
				$bjobs->checked->setQueryStringValue($_GET["checked"]);
			} else {
				$sReturnUrl = "bjobslist.php"; // Return to list
			}

			// Get action
			$bjobs->CurrentAction = "I"; // Display form
			switch ($bjobs->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "bjobslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "bjobslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$bjobs->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $bjobs;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$bjobs->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$bjobs->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $bjobs->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$bjobs->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$bjobs->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$bjobs->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $bjobs;
		$sFilter = $bjobs->KeyFilter();

		// Call Row Selecting event
		$bjobs->Row_Selecting($sFilter);

		// Load sql based on filter
		$bjobs->CurrentFilter = $sFilter;
		$sSql = $bjobs->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$bjobs->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $bjobs;
		$bjobs->checked->setDbValue($rs->fields('checked'));
		$bjobs->jobslots->setDbValue($rs->fields('jobslots'));
		$bjobs->bjobs->Upload->DbValue = $rs->fields('bjobs');
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $bjobs;

		// Call Row_Rendering event
		$bjobs->Row_Rendering();

		// Common render codes for all row types
		// checked

		$bjobs->checked->CellCssStyle = "";
		$bjobs->checked->CellCssClass = "";

		// jobslots
		$bjobs->jobslots->CellCssStyle = "";
		$bjobs->jobslots->CellCssClass = "";

		// bjobs
		$bjobs->bjobs->CellCssStyle = "";
		$bjobs->bjobs->CellCssClass = "";
		if ($bjobs->RowType == EW_ROWTYPE_VIEW) { // View row

			// checked
			$bjobs->checked->ViewValue = $bjobs->checked->CurrentValue;
			$bjobs->checked->CssStyle = "";
			$bjobs->checked->CssClass = "";
			$bjobs->checked->ViewCustomAttributes = "";

			// jobslots
			$bjobs->jobslots->ViewValue = $bjobs->jobslots->CurrentValue;
			$bjobs->jobslots->CssStyle = "";
			$bjobs->jobslots->CssClass = "";
			$bjobs->jobslots->ViewCustomAttributes = "";

			// bjobs
			if (!is_null($bjobs->bjobs->Upload->DbValue)) {
				$bjobs->bjobs->ViewValue = "Bjobs";
			} else {
				$bjobs->bjobs->ViewValue = "";
			}
			$bjobs->bjobs->CssStyle = "";
			$bjobs->bjobs->CssClass = "";
			$bjobs->bjobs->ViewCustomAttributes = "";

			// checked
			$bjobs->checked->HrefValue = "";

			// jobslots
			$bjobs->jobslots->HrefValue = "";

			// bjobs
			if (!is_null($bjobs->bjobs->Upload->DbValue)) {
				$bjobs->bjobs->HrefValue = "bjobs_bjobs_bv.php?checked=" . $bjobs->checked->CurrentValue;
				if ($bjobs->Export <> "") $bjobs->bjobs->HrefValue = ew_ConvertFullUrl($bjobs->bjobs->HrefValue);
			} else {
				$bjobs->bjobs->HrefValue = "";
			}
		}

		// Call Row Rendered event
		$bjobs->Row_Rendered();
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
