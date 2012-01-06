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
$ge_queues_view = new cge_queues_view();
$Page =& $ge_queues_view;

// Page init processing
$ge_queues_view->Page_Init();

// Page main processing
$ge_queues_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($ge_queues->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ge_queues_view = new ew_Page("ge_queues_view");

// page properties
ge_queues_view.PageID = "view"; // page ID
var EW_PAGE_ID = ge_queues_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ge_queues_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_queues_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_queues_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Ge Queues
<br><br>
<?php if ($ge_queues->Export == "") { ?>
<a href="ge_queueslist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_queues->AddUrl() ?>">Add</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_queues->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_queues->CopyUrl() ?>">Copy</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_queues->DeleteUrl() ?>">Delete</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $ge_queues_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ge_queues->id->Visible) { // id ?>
	<tr<?php echo $ge_queues->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $ge_queues->id->CellAttributes() ?>>
<div<?php echo $ge_queues->id->ViewAttributes() ?>><?php echo $ge_queues->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_queues->name->Visible) { // name ?>
	<tr<?php echo $ge_queues->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $ge_queues->name->CellAttributes() ?>>
<div<?php echo $ge_queues->name->ViewAttributes() ?>><?php echo $ge_queues->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_queues->gid->Visible) { // gid ?>
	<tr<?php echo $ge_queues->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $ge_queues->gid->CellAttributes() ?>>
<div<?php echo $ge_queues->gid->ViewAttributes() ?>><?php echo $ge_queues->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($ge_queues->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$ge_queues_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_queues_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'ge_queues';

	// Page Object Name
	var $PageObjName = 'ge_queues_view';

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
	function cge_queues_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_queues"] = new cge_queues();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
		global $ge_queues;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$ge_queues->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "ge_queueslist.php"; // Return to list
			}

			// Get action
			$ge_queues->CurrentAction = "I"; // Display form
			switch ($ge_queues->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "ge_queueslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ge_queueslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$ge_queues->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $ge_queues;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$ge_queues->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$ge_queues->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $ge_queues->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$ge_queues->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$ge_queues->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$ge_queues->setStartRecordNumber($this->lStartRec);
		}
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
		// id

		$ge_queues->id->CellCssStyle = "";
		$ge_queues->id->CellCssClass = "";

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

			// id
			$ge_queues->id->HrefValue = "";

			// name
			$ge_queues->name->HrefValue = "";

			// gid
			$ge_queues->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$ge_queues->Row_Rendered();
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
