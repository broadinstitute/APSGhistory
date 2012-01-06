<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "grpinfo.php" ?>
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
$grp_view = new cgrp_view();
$Page =& $grp_view;

// Page init processing
$grp_view->Page_Init();

// Page main processing
$grp_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($grp->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var grp_view = new ew_Page("grp_view");

// page properties
grp_view.PageID = "view"; // page ID
var EW_PAGE_ID = grp_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
grp_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
grp_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
grp_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Grp
<br><br>
<?php if ($grp->Export == "") { ?>
<a href="grplist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $grp->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="filesystemlist.php?<?php echo EW_TABLE_SHOW_MASTER ?>=grp&id=<?php echo urlencode(strval($grp->id->CurrentValue)) ?>">Filesystem...</a>
&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $grp_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($grp->id->Visible) { // id ?>
	<tr<?php echo $grp->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $grp->id->CellAttributes() ?>>
<div<?php echo $grp->id->ViewAttributes() ?>><?php echo $grp->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($grp->name->Visible) { // name ?>
	<tr<?php echo $grp->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $grp->name->CellAttributes() ?>>
<div<?php echo $grp->name->ViewAttributes() ?>><?php echo $grp->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($grp->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$grp_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cgrp_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'grp';

	// Page Object Name
	var $PageObjName = 'grp_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $grp;
		if ($grp->UseTokenInUrl) $PageUrl .= "t=" . $grp->TableVar . "&"; // add page token
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
		global $objForm, $grp;
		if ($grp->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($grp->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($grp->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cgrp_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["grp"] = new cgrp();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'grp', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $grp;
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
		global $grp;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$grp->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "grplist.php"; // Return to list
			}

			// Get action
			$grp->CurrentAction = "I"; // Display form
			switch ($grp->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "grplist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "grplist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$grp->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $grp;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$grp->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$grp->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $grp->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$grp->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$grp->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$grp->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $grp;
		$sFilter = $grp->KeyFilter();

		// Call Row Selecting event
		$grp->Row_Selecting($sFilter);

		// Load sql based on filter
		$grp->CurrentFilter = $sFilter;
		$sSql = $grp->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$grp->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $grp;
		$grp->id->setDbValue($rs->fields('id'));
		$grp->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $grp;

		// Call Row_Rendering event
		$grp->Row_Rendering();

		// Common render codes for all row types
		// id

		$grp->id->CellCssStyle = "";
		$grp->id->CellCssClass = "";

		// name
		$grp->name->CellCssStyle = "";
		$grp->name->CellCssClass = "";
		if ($grp->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$grp->id->ViewValue = $grp->id->CurrentValue;
			$grp->id->CssStyle = "";
			$grp->id->CssClass = "";
			$grp->id->ViewCustomAttributes = "";

			// name
			$grp->name->ViewValue = $grp->name->CurrentValue;
			$grp->name->CssStyle = "";
			$grp->name->CssClass = "";
			$grp->name->ViewCustomAttributes = "";

			// id
			$grp->id->HrefValue = "";

			// name
			$grp->name->HrefValue = "";
		}

		// Call Row Rendered event
		$grp->Row_Rendered();
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
