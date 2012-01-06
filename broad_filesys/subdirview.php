<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "subdirinfo.php" ?>
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
$subdir_view = new csubdir_view();
$Page =& $subdir_view;

// Page init processing
$subdir_view->Page_Init();

// Page main processing
$subdir_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($subdir->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var subdir_view = new ew_Page("subdir_view");

// page properties
subdir_view.PageID = "view"; // page ID
var EW_PAGE_ID = subdir_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
subdir_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
subdir_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
subdir_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Subdir
<br><br>
<?php if ($subdir->Export == "") { ?>
<a href="subdirlist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $subdir->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $subdir_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($subdir->fsid->Visible) { // fsid ?>
	<tr<?php echo $subdir->fsid->RowAttributes ?>>
		<td class="ewTableHeader">Fsid</td>
		<td<?php echo $subdir->fsid->CellAttributes() ?>>
<div<?php echo $subdir->fsid->ViewAttributes() ?>><?php echo $subdir->fsid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($subdir->dirid->Visible) { // dirid ?>
	<tr<?php echo $subdir->dirid->RowAttributes ?>>
		<td class="ewTableHeader">Dirid</td>
		<td<?php echo $subdir->dirid->CellAttributes() ?>>
<div<?php echo $subdir->dirid->ViewAttributes() ?>><?php echo $subdir->dirid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($subdir->parent->Visible) { // parent ?>
	<tr<?php echo $subdir->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $subdir->parent->CellAttributes() ?>>
<div<?php echo $subdir->parent->ViewAttributes() ?>><?php echo $subdir->parent->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($subdir->name->Visible) { // name ?>
	<tr<?php echo $subdir->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $subdir->name->CellAttributes() ?>>
<div<?php echo $subdir->name->ViewAttributes() ?>><?php echo $subdir->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($subdir->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $subdir->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $subdir->deprecated->CellAttributes() ?>>
<div<?php echo $subdir->deprecated->ViewAttributes() ?>><?php echo $subdir->deprecated->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($subdir->level->Visible) { // level ?>
	<tr<?php echo $subdir->level->RowAttributes ?>>
		<td class="ewTableHeader">Level</td>
		<td<?php echo $subdir->level->CellAttributes() ?>>
<div<?php echo $subdir->level->ViewAttributes() ?>><?php echo $subdir->level->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($subdir->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$subdir_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class csubdir_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'subdir';

	// Page Object Name
	var $PageObjName = 'subdir_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $subdir;
		if ($subdir->UseTokenInUrl) $PageUrl .= "t=" . $subdir->TableVar . "&"; // add page token
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
		global $objForm, $subdir;
		if ($subdir->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($subdir->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($subdir->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function csubdir_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["subdir"] = new csubdir();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'subdir', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $subdir;
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
		global $subdir;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["fsid"] <> "") {
				$subdir->fsid->setQueryStringValue($_GET["fsid"]);
			} else {
				$sReturnUrl = "subdirlist.php"; // Return to list
			}
			if (@$_GET["dirid"] <> "") {
				$subdir->dirid->setQueryStringValue($_GET["dirid"]);
			} else {
				$sReturnUrl = "subdirlist.php"; // Return to list
			}

			// Get action
			$subdir->CurrentAction = "I"; // Display form
			switch ($subdir->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "subdirlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "subdirlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$subdir->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $subdir;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$subdir->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$subdir->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $subdir->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$subdir->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$subdir->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$subdir->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $subdir;
		$sFilter = $subdir->KeyFilter();

		// Call Row Selecting event
		$subdir->Row_Selecting($sFilter);

		// Load sql based on filter
		$subdir->CurrentFilter = $sFilter;
		$sSql = $subdir->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$subdir->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $subdir;
		$subdir->fsid->setDbValue($rs->fields('fsid'));
		$subdir->dirid->setDbValue($rs->fields('dirid'));
		$subdir->parent->setDbValue($rs->fields('parent'));
		$subdir->name->setDbValue($rs->fields('name'));
		$subdir->deprecated->setDbValue($rs->fields('deprecated'));
		$subdir->level->setDbValue($rs->fields('level'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $subdir;

		// Call Row_Rendering event
		$subdir->Row_Rendering();

		// Common render codes for all row types
		// fsid

		$subdir->fsid->CellCssStyle = "";
		$subdir->fsid->CellCssClass = "";

		// dirid
		$subdir->dirid->CellCssStyle = "";
		$subdir->dirid->CellCssClass = "";

		// parent
		$subdir->parent->CellCssStyle = "";
		$subdir->parent->CellCssClass = "";

		// name
		$subdir->name->CellCssStyle = "";
		$subdir->name->CellCssClass = "";

		// deprecated
		$subdir->deprecated->CellCssStyle = "";
		$subdir->deprecated->CellCssClass = "";

		// level
		$subdir->level->CellCssStyle = "";
		$subdir->level->CellCssClass = "";
		if ($subdir->RowType == EW_ROWTYPE_VIEW) { // View row

			// fsid
			$subdir->fsid->ViewValue = $subdir->fsid->CurrentValue;
			$subdir->fsid->CssStyle = "";
			$subdir->fsid->CssClass = "";
			$subdir->fsid->ViewCustomAttributes = "";

			// dirid
			$subdir->dirid->ViewValue = $subdir->dirid->CurrentValue;
			$subdir->dirid->CssStyle = "";
			$subdir->dirid->CssClass = "";
			$subdir->dirid->ViewCustomAttributes = "";

			// parent
			$subdir->parent->ViewValue = $subdir->parent->CurrentValue;
			$subdir->parent->CssStyle = "";
			$subdir->parent->CssClass = "";
			$subdir->parent->ViewCustomAttributes = "";

			// name
			$subdir->name->ViewValue = $subdir->name->CurrentValue;
			$subdir->name->CssStyle = "";
			$subdir->name->CssClass = "";
			$subdir->name->ViewCustomAttributes = "";

			// deprecated
			$subdir->deprecated->ViewValue = $subdir->deprecated->CurrentValue;
			$subdir->deprecated->CssStyle = "";
			$subdir->deprecated->CssClass = "";
			$subdir->deprecated->ViewCustomAttributes = "";

			// level
			$subdir->level->ViewValue = $subdir->level->CurrentValue;
			$subdir->level->CssStyle = "";
			$subdir->level->CssClass = "";
			$subdir->level->ViewCustomAttributes = "";

			// fsid
			$subdir->fsid->HrefValue = "";

			// dirid
			$subdir->dirid->HrefValue = "";

			// parent
			$subdir->parent->HrefValue = "";

			// name
			$subdir->name->HrefValue = "";

			// deprecated
			$subdir->deprecated->HrefValue = "";

			// level
			$subdir->level->HrefValue = "";
		}

		// Call Row Rendered event
		$subdir->Row_Rendered();
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
