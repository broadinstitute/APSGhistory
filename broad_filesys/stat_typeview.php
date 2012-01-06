<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "stat_typeinfo.php" ?>
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
$stat_type_view = new cstat_type_view();
$Page =& $stat_type_view;

// Page init processing
$stat_type_view->Page_Init();

// Page main processing
$stat_type_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($stat_type->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var stat_type_view = new ew_Page("stat_type_view");

// page properties
stat_type_view.PageID = "view"; // page ID
var EW_PAGE_ID = stat_type_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
stat_type_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
stat_type_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
stat_type_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Stat Type
<br><br>
<?php if ($stat_type->Export == "") { ?>
<a href="stat_typelist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $stat_type->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $stat_type_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($stat_type->id->Visible) { // id ?>
	<tr<?php echo $stat_type->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $stat_type->id->CellAttributes() ?>>
<div<?php echo $stat_type->id->ViewAttributes() ?>><?php echo $stat_type->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($stat_type->name->Visible) { // name ?>
	<tr<?php echo $stat_type->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $stat_type->name->CellAttributes() ?>>
<div<?php echo $stat_type->name->ViewAttributes() ?>><?php echo $stat_type->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($stat_type->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$stat_type_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cstat_type_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'stat_type';

	// Page Object Name
	var $PageObjName = 'stat_type_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $stat_type;
		if ($stat_type->UseTokenInUrl) $PageUrl .= "t=" . $stat_type->TableVar . "&"; // add page token
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
		global $objForm, $stat_type;
		if ($stat_type->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($stat_type->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($stat_type->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cstat_type_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["stat_type"] = new cstat_type();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'stat_type', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $stat_type;
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
		global $stat_type;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$stat_type->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "stat_typelist.php"; // Return to list
			}

			// Get action
			$stat_type->CurrentAction = "I"; // Display form
			switch ($stat_type->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "stat_typelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "stat_typelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$stat_type->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $stat_type;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$stat_type->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$stat_type->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $stat_type->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$stat_type->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$stat_type->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$stat_type->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $stat_type;
		$sFilter = $stat_type->KeyFilter();

		// Call Row Selecting event
		$stat_type->Row_Selecting($sFilter);

		// Load sql based on filter
		$stat_type->CurrentFilter = $sFilter;
		$sSql = $stat_type->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$stat_type->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $stat_type;
		$stat_type->id->setDbValue($rs->fields('id'));
		$stat_type->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $stat_type;

		// Call Row_Rendering event
		$stat_type->Row_Rendering();

		// Common render codes for all row types
		// id

		$stat_type->id->CellCssStyle = "";
		$stat_type->id->CellCssClass = "";

		// name
		$stat_type->name->CellCssStyle = "";
		$stat_type->name->CellCssClass = "";
		if ($stat_type->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$stat_type->id->ViewValue = $stat_type->id->CurrentValue;
			$stat_type->id->CssStyle = "";
			$stat_type->id->CssClass = "";
			$stat_type->id->ViewCustomAttributes = "";

			// name
			$stat_type->name->ViewValue = $stat_type->name->CurrentValue;
			$stat_type->name->CssStyle = "";
			$stat_type->name->CssClass = "";
			$stat_type->name->ViewCustomAttributes = "";

			// id
			$stat_type->id->HrefValue = "";

			// name
			$stat_type->name->HrefValue = "";
		}

		// Call Row Rendered event
		$stat_type->Row_Rendered();
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
