<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_projectsinfo.php" ?>
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
$lsf_projects_view = new clsf_projects_view();
$Page =& $lsf_projects_view;

// Page init processing
$lsf_projects_view->Page_Init();

// Page main processing
$lsf_projects_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lsf_projects->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_projects_view = new ew_Page("lsf_projects_view");

// page properties
lsf_projects_view.PageID = "view"; // page ID
var EW_PAGE_ID = lsf_projects_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_projects_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_projects_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_projects_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Lsf Projects
<br><br>
<?php if ($lsf_projects->Export == "") { ?>
<a href="lsf_projectslist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lsf_projects->AddUrl() ?>">Add</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lsf_projects->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lsf_projects->CopyUrl() ?>">Copy</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lsf_projects->DeleteUrl() ?>">Delete</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $lsf_projects_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lsf_projects->id->Visible) { // id ?>
	<tr<?php echo $lsf_projects->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $lsf_projects->id->CellAttributes() ?>>
<div<?php echo $lsf_projects->id->ViewAttributes() ?>><?php echo $lsf_projects->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_projects->name->Visible) { // name ?>
	<tr<?php echo $lsf_projects->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $lsf_projects->name->CellAttributes() ?>>
<div<?php echo $lsf_projects->name->ViewAttributes() ?>><?php echo $lsf_projects->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lsf_projects->gid->Visible) { // gid ?>
	<tr<?php echo $lsf_projects->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $lsf_projects->gid->CellAttributes() ?>>
<div<?php echo $lsf_projects->gid->ViewAttributes() ?>><?php echo $lsf_projects->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($lsf_projects->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lsf_projects_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_projects_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'lsf_projects';

	// Page Object Name
	var $PageObjName = 'lsf_projects_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_projects;
		if ($lsf_projects->UseTokenInUrl) $PageUrl .= "t=" . $lsf_projects->TableVar . "&"; // add page token
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
		global $objForm, $lsf_projects;
		if ($lsf_projects->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_projects->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_projects->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_projects_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_projects"] = new clsf_projects();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_projects', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_projects;
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
		global $lsf_projects;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$lsf_projects->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "lsf_projectslist.php"; // Return to list
			}

			// Get action
			$lsf_projects->CurrentAction = "I"; // Display form
			switch ($lsf_projects->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "lsf_projectslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "lsf_projectslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$lsf_projects->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $lsf_projects;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lsf_projects->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lsf_projects->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lsf_projects->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lsf_projects->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lsf_projects->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lsf_projects->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_projects;
		$sFilter = $lsf_projects->KeyFilter();

		// Call Row Selecting event
		$lsf_projects->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_projects->CurrentFilter = $sFilter;
		$sSql = $lsf_projects->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_projects->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_projects;
		$lsf_projects->id->setDbValue($rs->fields('id'));
		$lsf_projects->name->setDbValue($rs->fields('name'));
		$lsf_projects->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_projects;

		// Call Row_Rendering event
		$lsf_projects->Row_Rendering();

		// Common render codes for all row types
		// id

		$lsf_projects->id->CellCssStyle = "";
		$lsf_projects->id->CellCssClass = "";

		// name
		$lsf_projects->name->CellCssStyle = "";
		$lsf_projects->name->CellCssClass = "";

		// gid
		$lsf_projects->gid->CellCssStyle = "";
		$lsf_projects->gid->CellCssClass = "";
		if ($lsf_projects->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$lsf_projects->id->ViewValue = $lsf_projects->id->CurrentValue;
			$lsf_projects->id->CssStyle = "";
			$lsf_projects->id->CssClass = "";
			$lsf_projects->id->ViewCustomAttributes = "";

			// name
			$lsf_projects->name->ViewValue = $lsf_projects->name->CurrentValue;
			$lsf_projects->name->CssStyle = "";
			$lsf_projects->name->CssClass = "";
			$lsf_projects->name->ViewCustomAttributes = "";

			// gid
			$lsf_projects->gid->ViewValue = $lsf_projects->gid->CurrentValue;
			$lsf_projects->gid->CssStyle = "";
			$lsf_projects->gid->CssClass = "";
			$lsf_projects->gid->ViewCustomAttributes = "";

			// id
			$lsf_projects->id->HrefValue = "";

			// name
			$lsf_projects->name->HrefValue = "";

			// gid
			$lsf_projects->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_projects->Row_Rendered();
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
