<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "CustomView1info.php" ?>
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
$CustomView1_view = new cCustomView1_view();
$Page =& $CustomView1_view;

// Page init processing
$CustomView1_view->Page_Init();

// Page main processing
$CustomView1_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($CustomView1->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var CustomView1_view = new ew_Page("CustomView1_view");

// page properties
CustomView1_view.PageID = "view"; // page ID
var EW_PAGE_ID = CustomView1_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
CustomView1_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
CustomView1_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
CustomView1_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View CUSTOM VIEW: Custom View 1
<br><br>
<?php if ($CustomView1->Export == "") { ?>
<a href="CustomView1list.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $CustomView1->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $CustomView1_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($CustomView1->id->Visible) { // id ?>
	<tr<?php echo $CustomView1->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $CustomView1->id->CellAttributes() ?>>
<div<?php echo $CustomView1->id->ViewAttributes() ?>><?php echo $CustomView1->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->mount->Visible) { // mount ?>
	<tr<?php echo $CustomView1->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount</td>
		<td<?php echo $CustomView1->mount->CellAttributes() ?>>
<div<?php echo $CustomView1->mount->ViewAttributes() ?>><?php echo $CustomView1->mount->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->path->Visible) { // path ?>
	<tr<?php echo $CustomView1->path->RowAttributes ?>>
		<td class="ewTableHeader">Path</td>
		<td<?php echo $CustomView1->path->CellAttributes() ?>>
<div<?php echo $CustomView1->path->ViewAttributes() ?>><?php echo $CustomView1->path->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->parent->Visible) { // parent ?>
	<tr<?php echo $CustomView1->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $CustomView1->parent->CellAttributes() ?>>
<div<?php echo $CustomView1->parent->ViewAttributes() ?>><?php echo $CustomView1->parent->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $CustomView1->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $CustomView1->deprecated->CellAttributes() ?>>
<div<?php echo $CustomView1->deprecated->ViewAttributes() ?>><?php echo $CustomView1->deprecated->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->gid->Visible) { // gid ?>
	<tr<?php echo $CustomView1->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $CustomView1->gid->CellAttributes() ?>>
<div<?php echo $CustomView1->gid->ViewAttributes() ?>><?php echo $CustomView1->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->snapshot->Visible) { // snapshot ?>
	<tr<?php echo $CustomView1->snapshot->RowAttributes ?>>
		<td class="ewTableHeader">Snapshot</td>
		<td<?php echo $CustomView1->snapshot->CellAttributes() ?>>
<div<?php echo $CustomView1->snapshot->ViewAttributes() ?>><?php echo $CustomView1->snapshot->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->tapebackup->Visible) { // tapebackup ?>
	<tr<?php echo $CustomView1->tapebackup->RowAttributes ?>>
		<td class="ewTableHeader">Tapebackup</td>
		<td<?php echo $CustomView1->tapebackup->CellAttributes() ?>>
<div<?php echo $CustomView1->tapebackup->ViewAttributes() ?>><?php echo $CustomView1->tapebackup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->diskbackup->Visible) { // diskbackup ?>
	<tr<?php echo $CustomView1->diskbackup->RowAttributes ?>>
		<td class="ewTableHeader">Diskbackup</td>
		<td<?php echo $CustomView1->diskbackup->CellAttributes() ?>>
<div<?php echo $CustomView1->diskbackup->ViewAttributes() ?>><?php echo $CustomView1->diskbackup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($CustomView1->name->Visible) { // name ?>
	<tr<?php echo $CustomView1->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $CustomView1->name->CellAttributes() ?>>
<div<?php echo $CustomView1->name->ViewAttributes() ?>><?php echo $CustomView1->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($CustomView1->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$CustomView1_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cCustomView1_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'CustomView1';

	// Page Object Name
	var $PageObjName = 'CustomView1_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $CustomView1;
		if ($CustomView1->UseTokenInUrl) $PageUrl .= "t=" . $CustomView1->TableVar . "&"; // add page token
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
		global $objForm, $CustomView1;
		if ($CustomView1->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($CustomView1->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($CustomView1->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cCustomView1_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["CustomView1"] = new cCustomView1();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'CustomView1', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $CustomView1;
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
		global $CustomView1;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$CustomView1->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "CustomView1list.php"; // Return to list
			}
			if (@$_GET["name"] <> "") {
				$CustomView1->name->setQueryStringValue($_GET["name"]);
			} else {
				$sReturnUrl = "CustomView1list.php"; // Return to list
			}

			// Get action
			$CustomView1->CurrentAction = "I"; // Display form
			switch ($CustomView1->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "CustomView1list.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "CustomView1list.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$CustomView1->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $CustomView1;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$CustomView1->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$CustomView1->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $CustomView1->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$CustomView1->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$CustomView1->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$CustomView1->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $CustomView1;
		$sFilter = $CustomView1->KeyFilter();

		// Call Row Selecting event
		$CustomView1->Row_Selecting($sFilter);

		// Load sql based on filter
		$CustomView1->CurrentFilter = $sFilter;
		$sSql = $CustomView1->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$CustomView1->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $CustomView1;
		$CustomView1->id->setDbValue($rs->fields('id'));
		$CustomView1->mount->setDbValue($rs->fields('mount'));
		$CustomView1->path->setDbValue($rs->fields('path'));
		$CustomView1->parent->setDbValue($rs->fields('parent'));
		$CustomView1->deprecated->setDbValue($rs->fields('deprecated'));
		$CustomView1->gid->setDbValue($rs->fields('gid'));
		$CustomView1->snapshot->setDbValue($rs->fields('snapshot'));
		$CustomView1->tapebackup->setDbValue($rs->fields('tapebackup'));
		$CustomView1->diskbackup->setDbValue($rs->fields('diskbackup'));
		$CustomView1->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $CustomView1;

		// Call Row_Rendering event
		$CustomView1->Row_Rendering();

		// Common render codes for all row types
		// id

		$CustomView1->id->CellCssStyle = "";
		$CustomView1->id->CellCssClass = "";

		// mount
		$CustomView1->mount->CellCssStyle = "";
		$CustomView1->mount->CellCssClass = "";

		// path
		$CustomView1->path->CellCssStyle = "";
		$CustomView1->path->CellCssClass = "";

		// parent
		$CustomView1->parent->CellCssStyle = "";
		$CustomView1->parent->CellCssClass = "";

		// deprecated
		$CustomView1->deprecated->CellCssStyle = "";
		$CustomView1->deprecated->CellCssClass = "";

		// gid
		$CustomView1->gid->CellCssStyle = "";
		$CustomView1->gid->CellCssClass = "";

		// snapshot
		$CustomView1->snapshot->CellCssStyle = "";
		$CustomView1->snapshot->CellCssClass = "";

		// tapebackup
		$CustomView1->tapebackup->CellCssStyle = "";
		$CustomView1->tapebackup->CellCssClass = "";

		// diskbackup
		$CustomView1->diskbackup->CellCssStyle = "";
		$CustomView1->diskbackup->CellCssClass = "";

		// name
		$CustomView1->name->CellCssStyle = "";
		$CustomView1->name->CellCssClass = "";
		if ($CustomView1->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$CustomView1->id->ViewValue = $CustomView1->id->CurrentValue;
			$CustomView1->id->CssStyle = "";
			$CustomView1->id->CssClass = "";
			$CustomView1->id->ViewCustomAttributes = "";

			// mount
			$CustomView1->mount->ViewValue = $CustomView1->mount->CurrentValue;
			$CustomView1->mount->CssStyle = "";
			$CustomView1->mount->CssClass = "";
			$CustomView1->mount->ViewCustomAttributes = "";

			// path
			$CustomView1->path->ViewValue = $CustomView1->path->CurrentValue;
			$CustomView1->path->CssStyle = "";
			$CustomView1->path->CssClass = "";
			$CustomView1->path->ViewCustomAttributes = "";

			// parent
			$CustomView1->parent->ViewValue = $CustomView1->parent->CurrentValue;
			$CustomView1->parent->CssStyle = "";
			$CustomView1->parent->CssClass = "";
			$CustomView1->parent->ViewCustomAttributes = "";

			// deprecated
			$CustomView1->deprecated->ViewValue = $CustomView1->deprecated->CurrentValue;
			$CustomView1->deprecated->CssStyle = "";
			$CustomView1->deprecated->CssClass = "";
			$CustomView1->deprecated->ViewCustomAttributes = "";

			// gid
			$CustomView1->gid->ViewValue = $CustomView1->gid->CurrentValue;
			$CustomView1->gid->CssStyle = "";
			$CustomView1->gid->CssClass = "";
			$CustomView1->gid->ViewCustomAttributes = "";

			// snapshot
			$CustomView1->snapshot->ViewValue = $CustomView1->snapshot->CurrentValue;
			$CustomView1->snapshot->CssStyle = "";
			$CustomView1->snapshot->CssClass = "";
			$CustomView1->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$CustomView1->tapebackup->ViewValue = $CustomView1->tapebackup->CurrentValue;
			$CustomView1->tapebackup->CssStyle = "";
			$CustomView1->tapebackup->CssClass = "";
			$CustomView1->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$CustomView1->diskbackup->ViewValue = $CustomView1->diskbackup->CurrentValue;
			$CustomView1->diskbackup->CssStyle = "";
			$CustomView1->diskbackup->CssClass = "";
			$CustomView1->diskbackup->ViewCustomAttributes = "";

			// name
			$CustomView1->name->ViewValue = $CustomView1->name->CurrentValue;
			$CustomView1->name->CssStyle = "";
			$CustomView1->name->CssClass = "";
			$CustomView1->name->ViewCustomAttributes = "";

			// id
			$CustomView1->id->HrefValue = "";

			// mount
			$CustomView1->mount->HrefValue = "";

			// path
			$CustomView1->path->HrefValue = "";

			// parent
			$CustomView1->parent->HrefValue = "";

			// deprecated
			$CustomView1->deprecated->HrefValue = "";

			// gid
			$CustomView1->gid->HrefValue = "";

			// snapshot
			$CustomView1->snapshot->HrefValue = "";

			// tapebackup
			$CustomView1->tapebackup->HrefValue = "";

			// diskbackup
			$CustomView1->diskbackup->HrefValue = "";

			// name
			$CustomView1->name->HrefValue = "";
		}

		// Call Row Rendered event
		$CustomView1->Row_Rendered();
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
