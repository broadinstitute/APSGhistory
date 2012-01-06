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
$dbservers_view = new cdbservers_view();
$Page =& $dbservers_view;

// Page init processing
$dbservers_view->Page_Init();

// Page main processing
$dbservers_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($dbservers->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var dbservers_view = new ew_Page("dbservers_view");

// page properties
dbservers_view.PageID = "view"; // page ID
var EW_PAGE_ID = dbservers_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
dbservers_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
dbservers_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
dbservers_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Dbservers
<br><br>
<?php if ($dbservers->Export == "") { ?>
<a href="dbserverslist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbservers->AddUrl() ?>">Add</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbservers->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbservers->CopyUrl() ?>">Copy</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbservers->DeleteUrl() ?>">Delete</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $dbservers_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($dbservers->id->Visible) { // id ?>
	<tr<?php echo $dbservers->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $dbservers->id->CellAttributes() ?>>
<div<?php echo $dbservers->id->ViewAttributes() ?>><?php echo $dbservers->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($dbservers->name->Visible) { // name ?>
	<tr<?php echo $dbservers->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $dbservers->name->CellAttributes() ?>>
<div<?php echo $dbservers->name->ViewAttributes() ?>><?php echo $dbservers->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($dbservers->gid->Visible) { // gid ?>
	<tr<?php echo $dbservers->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $dbservers->gid->CellAttributes() ?>>
<div<?php echo $dbservers->gid->ViewAttributes() ?>><?php echo $dbservers->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($dbservers->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$dbservers_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cdbservers_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'dbservers';

	// Page Object Name
	var $PageObjName = 'dbservers_view';

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
	function cdbservers_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["dbservers"] = new cdbservers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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
		global $dbservers;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$dbservers->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "dbserverslist.php"; // Return to list
			}

			// Get action
			$dbservers->CurrentAction = "I"; // Display form
			switch ($dbservers->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "dbserverslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "dbserverslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$dbservers->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $dbservers;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$dbservers->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$dbservers->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $dbservers->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$dbservers->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$dbservers->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$dbservers->setStartRecordNumber($this->lStartRec);
		}
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
		// id

		$dbservers->id->CellCssStyle = "";
		$dbservers->id->CellCssClass = "";

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

			// id
			$dbservers->id->HrefValue = "";

			// name
			$dbservers->name->HrefValue = "";

			// gid
			$dbservers->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$dbservers->Row_Rendered();
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
