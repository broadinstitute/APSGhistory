<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "ge_projectsinfo.php" ?>
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
$ge_projects_view = new cge_projects_view();
$Page =& $ge_projects_view;

// Page init processing
$ge_projects_view->Page_Init();

// Page main processing
$ge_projects_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($ge_projects->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ge_projects_view = new ew_Page("ge_projects_view");

// page properties
ge_projects_view.PageID = "view"; // page ID
var EW_PAGE_ID = ge_projects_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ge_projects_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_projects_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_projects_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Ge Projects
<br><br>
<?php if ($ge_projects->Export == "") { ?>
<a href="ge_projectslist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_projects->AddUrl() ?>">Add</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_projects->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_projects->CopyUrl() ?>">Copy</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_projects->DeleteUrl() ?>">Delete</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $ge_projects_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ge_projects->id->Visible) { // id ?>
	<tr<?php echo $ge_projects->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $ge_projects->id->CellAttributes() ?>>
<div<?php echo $ge_projects->id->ViewAttributes() ?>><?php echo $ge_projects->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_projects->name->Visible) { // name ?>
	<tr<?php echo $ge_projects->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $ge_projects->name->CellAttributes() ?>>
<div<?php echo $ge_projects->name->ViewAttributes() ?>><?php echo $ge_projects->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ge_projects->gid->Visible) { // gid ?>
	<tr<?php echo $ge_projects->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $ge_projects->gid->CellAttributes() ?>>
<div<?php echo $ge_projects->gid->ViewAttributes() ?>><?php echo $ge_projects->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($ge_projects->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$ge_projects_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_projects_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'ge_projects';

	// Page Object Name
	var $PageObjName = 'ge_projects_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ge_projects;
		if ($ge_projects->UseTokenInUrl) $PageUrl .= "t=" . $ge_projects->TableVar . "&"; // add page token
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
		global $objForm, $ge_projects;
		if ($ge_projects->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($ge_projects->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ge_projects->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cge_projects_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_projects"] = new cge_projects();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ge_projects', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ge_projects;
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
		global $ge_projects;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$ge_projects->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "ge_projectslist.php"; // Return to list
			}

			// Get action
			$ge_projects->CurrentAction = "I"; // Display form
			switch ($ge_projects->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "ge_projectslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ge_projectslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$ge_projects->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $ge_projects;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$ge_projects->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$ge_projects->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $ge_projects->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$ge_projects->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$ge_projects->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$ge_projects->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ge_projects;
		$sFilter = $ge_projects->KeyFilter();

		// Call Row Selecting event
		$ge_projects->Row_Selecting($sFilter);

		// Load sql based on filter
		$ge_projects->CurrentFilter = $sFilter;
		$sSql = $ge_projects->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$ge_projects->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $ge_projects;
		$ge_projects->id->setDbValue($rs->fields('id'));
		$ge_projects->name->setDbValue($rs->fields('name'));
		$ge_projects->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $ge_projects;

		// Call Row_Rendering event
		$ge_projects->Row_Rendering();

		// Common render codes for all row types
		// id

		$ge_projects->id->CellCssStyle = "";
		$ge_projects->id->CellCssClass = "";

		// name
		$ge_projects->name->CellCssStyle = "";
		$ge_projects->name->CellCssClass = "";

		// gid
		$ge_projects->gid->CellCssStyle = "";
		$ge_projects->gid->CellCssClass = "";
		if ($ge_projects->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$ge_projects->id->ViewValue = $ge_projects->id->CurrentValue;
			$ge_projects->id->CssStyle = "";
			$ge_projects->id->CssClass = "";
			$ge_projects->id->ViewCustomAttributes = "";

			// name
			$ge_projects->name->ViewValue = $ge_projects->name->CurrentValue;
			$ge_projects->name->CssStyle = "";
			$ge_projects->name->CssClass = "";
			$ge_projects->name->ViewCustomAttributes = "";

			// gid
			$ge_projects->gid->ViewValue = $ge_projects->gid->CurrentValue;
			$ge_projects->gid->CssStyle = "";
			$ge_projects->gid->CssClass = "";
			$ge_projects->gid->ViewCustomAttributes = "";

			// id
			$ge_projects->id->HrefValue = "";

			// name
			$ge_projects->name->HrefValue = "";

			// gid
			$ge_projects->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$ge_projects->Row_Rendered();
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
