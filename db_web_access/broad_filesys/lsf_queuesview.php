<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_queuesinfo.php" ?>
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
$lsf_queues_view = new clsf_queues_view();
$Page =& $lsf_queues_view;

// Page init processing
$lsf_queues_view->Page_Init();

// Page main processing
$lsf_queues_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lsf_queues->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_queues_view = new ew_Page("lsf_queues_view");

// page properties
lsf_queues_view.PageID = "view"; // page ID
var EW_PAGE_ID = lsf_queues_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_queues_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_queues_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_queues_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Lsf Queues
<br><br>
<?php if ($lsf_queues->Export == "") { ?>
<a href="lsf_queueslist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lsf_queues->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $lsf_queues_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lsf_queues->id->Visible) { // id ?>
	<tr<?php echo $lsf_queues->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $lsf_queues->id->CellAttributes() ?>>
<div<?php echo $lsf_queues->id->ViewAttributes() ?>><?php echo $lsf_queues->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_queues->name->Visible) { // name ?>
	<tr<?php echo $lsf_queues->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $lsf_queues->name->CellAttributes() ?>>
<div<?php echo $lsf_queues->name->ViewAttributes() ?>><?php echo $lsf_queues->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_queues->gid->Visible) { // gid ?>
	<tr<?php echo $lsf_queues->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $lsf_queues->gid->CellAttributes() ?>>
<div<?php echo $lsf_queues->gid->ViewAttributes() ?>><?php echo $lsf_queues->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($lsf_queues->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lsf_queues_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_queues_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'lsf_queues';

	// Page Object Name
	var $PageObjName = 'lsf_queues_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_queues;
		if ($lsf_queues->UseTokenInUrl) $PageUrl .= "t=" . $lsf_queues->TableVar . "&"; // add page token
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
		global $objForm, $lsf_queues;
		if ($lsf_queues->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_queues->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_queues->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_queues_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_queues"] = new clsf_queues();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_queues', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_queues;
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
		global $lsf_queues;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$lsf_queues->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "lsf_queueslist.php"; // Return to list
			}

			// Get action
			$lsf_queues->CurrentAction = "I"; // Display form
			switch ($lsf_queues->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "lsf_queueslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "lsf_queueslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$lsf_queues->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $lsf_queues;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lsf_queues->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lsf_queues->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lsf_queues->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lsf_queues->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lsf_queues->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lsf_queues->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_queues;
		$sFilter = $lsf_queues->KeyFilter();

		// Call Row Selecting event
		$lsf_queues->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_queues->CurrentFilter = $sFilter;
		$sSql = $lsf_queues->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_queues->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_queues;
		$lsf_queues->id->setDbValue($rs->fields('id'));
		$lsf_queues->name->setDbValue($rs->fields('name'));
		$lsf_queues->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_queues;

		// Call Row_Rendering event
		$lsf_queues->Row_Rendering();

		// Common render codes for all row types
		// id

		$lsf_queues->id->CellCssStyle = "";
		$lsf_queues->id->CellCssClass = "";

		// name
		$lsf_queues->name->CellCssStyle = "";
		$lsf_queues->name->CellCssClass = "";

		// gid
		$lsf_queues->gid->CellCssStyle = "";
		$lsf_queues->gid->CellCssClass = "";
		if ($lsf_queues->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$lsf_queues->id->ViewValue = $lsf_queues->id->CurrentValue;
			$lsf_queues->id->CssStyle = "";
			$lsf_queues->id->CssClass = "";
			$lsf_queues->id->ViewCustomAttributes = "";

			// name
			$lsf_queues->name->ViewValue = $lsf_queues->name->CurrentValue;
			$lsf_queues->name->CssStyle = "";
			$lsf_queues->name->CssClass = "";
			$lsf_queues->name->ViewCustomAttributes = "";

			// gid
			$lsf_queues->gid->ViewValue = $lsf_queues->gid->CurrentValue;
			$lsf_queues->gid->CssStyle = "";
			$lsf_queues->gid->CssClass = "";
			$lsf_queues->gid->ViewCustomAttributes = "";

			// id
			$lsf_queues->id->HrefValue = "";

			// name
			$lsf_queues->name->HrefValue = "";

			// gid
			$lsf_queues->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_queues->Row_Rendered();
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
