<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "complete_fs_viewinfo.php" ?>
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
$complete_fs_view_view = new ccomplete_fs_view_view();
$Page =& $complete_fs_view_view;

// Page init processing
$complete_fs_view_view->Page_Init();

// Page main processing
$complete_fs_view_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($complete_fs_view->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var complete_fs_view_view = new ew_Page("complete_fs_view_view");

// page properties
complete_fs_view_view.PageID = "view"; // page ID
var EW_PAGE_ID = complete_fs_view_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
complete_fs_view_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
complete_fs_view_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
complete_fs_view_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View View: Complete Fs View
<br><br>
<?php if ($complete_fs_view->Export == "") { ?>
<a href="complete_fs_viewlist.php">Back to List</a>&nbsp;
<?php } ?>
</span></p>
<?php $complete_fs_view_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($complete_fs_view->id->Visible) { // id ?>
	<tr<?php echo $complete_fs_view->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $complete_fs_view->id->CellAttributes() ?>>
<div<?php echo $complete_fs_view->id->ViewAttributes() ?>><?php echo $complete_fs_view->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->mount->Visible) { // mount ?>
	<tr<?php echo $complete_fs_view->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount</td>
		<td<?php echo $complete_fs_view->mount->CellAttributes() ?>>
<div<?php echo $complete_fs_view->mount->ViewAttributes() ?>><?php echo $complete_fs_view->mount->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->path->Visible) { // path ?>
	<tr<?php echo $complete_fs_view->path->RowAttributes ?>>
		<td class="ewTableHeader">Path</td>
		<td<?php echo $complete_fs_view->path->CellAttributes() ?>>
<div<?php echo $complete_fs_view->path->ViewAttributes() ?>><?php echo $complete_fs_view->path->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->parent->Visible) { // parent ?>
	<tr<?php echo $complete_fs_view->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $complete_fs_view->parent->CellAttributes() ?>>
<div<?php echo $complete_fs_view->parent->ViewAttributes() ?>><?php echo $complete_fs_view->parent->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $complete_fs_view->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $complete_fs_view->deprecated->CellAttributes() ?>>
<div<?php echo $complete_fs_view->deprecated->ViewAttributes() ?>><?php echo $complete_fs_view->deprecated->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->gid->Visible) { // gid ?>
	<tr<?php echo $complete_fs_view->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $complete_fs_view->gid->CellAttributes() ?>>
<div<?php echo $complete_fs_view->gid->ViewAttributes() ?>><?php echo $complete_fs_view->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->group_name->Visible) { // group_name ?>
	<tr<?php echo $complete_fs_view->group_name->RowAttributes ?>>
		<td class="ewTableHeader">Group Name</td>
		<td<?php echo $complete_fs_view->group_name->CellAttributes() ?>>
<div<?php echo $complete_fs_view->group_name->ViewAttributes() ?>><?php echo $complete_fs_view->group_name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->snapshot->Visible) { // snapshot ?>
	<tr<?php echo $complete_fs_view->snapshot->RowAttributes ?>>
		<td class="ewTableHeader">Snapshot</td>
		<td<?php echo $complete_fs_view->snapshot->CellAttributes() ?>>
<div<?php echo $complete_fs_view->snapshot->ViewAttributes() ?>><?php echo $complete_fs_view->snapshot->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->tapebackup->Visible) { // tapebackup ?>
	<tr<?php echo $complete_fs_view->tapebackup->RowAttributes ?>>
		<td class="ewTableHeader">Tapebackup</td>
		<td<?php echo $complete_fs_view->tapebackup->CellAttributes() ?>>
<div<?php echo $complete_fs_view->tapebackup->ViewAttributes() ?>><?php echo $complete_fs_view->tapebackup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->diskbackup->Visible) { // diskbackup ?>
	<tr<?php echo $complete_fs_view->diskbackup->RowAttributes ?>>
		<td class="ewTableHeader">Diskbackup</td>
		<td<?php echo $complete_fs_view->diskbackup->CellAttributes() ?>>
<div<?php echo $complete_fs_view->diskbackup->ViewAttributes() ?>><?php echo $complete_fs_view->diskbackup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->type->Visible) { // type ?>
	<tr<?php echo $complete_fs_view->type->RowAttributes ?>>
		<td class="ewTableHeader">Type</td>
		<td<?php echo $complete_fs_view->type->CellAttributes() ?>>
<div<?php echo $complete_fs_view->type->ViewAttributes() ?>><?php echo $complete_fs_view->type->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($complete_fs_view->server_type->Visible) { // server_type ?>
	<tr<?php echo $complete_fs_view->server_type->RowAttributes ?>>
		<td class="ewTableHeader">Server Type</td>
		<td<?php echo $complete_fs_view->server_type->CellAttributes() ?>>
<div<?php echo $complete_fs_view->server_type->ViewAttributes() ?>><?php echo $complete_fs_view->server_type->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($complete_fs_view->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$complete_fs_view_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class ccomplete_fs_view_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'complete_fs_view';

	// Page Object Name
	var $PageObjName = 'complete_fs_view_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $complete_fs_view;
		if ($complete_fs_view->UseTokenInUrl) $PageUrl .= "t=" . $complete_fs_view->TableVar . "&"; // add page token
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
		global $objForm, $complete_fs_view;
		if ($complete_fs_view->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($complete_fs_view->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($complete_fs_view->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccomplete_fs_view_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["complete_fs_view"] = new ccomplete_fs_view();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'complete_fs_view', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $complete_fs_view;
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
		global $complete_fs_view;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$complete_fs_view->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "complete_fs_viewlist.php"; // Return to list
			}

			// Get action
			$complete_fs_view->CurrentAction = "I"; // Display form
			switch ($complete_fs_view->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "complete_fs_viewlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "complete_fs_viewlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$complete_fs_view->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $complete_fs_view;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$complete_fs_view->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$complete_fs_view->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $complete_fs_view->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$complete_fs_view->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$complete_fs_view->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$complete_fs_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $complete_fs_view;
		$sFilter = $complete_fs_view->KeyFilter();

		// Call Row Selecting event
		$complete_fs_view->Row_Selecting($sFilter);

		// Load sql based on filter
		$complete_fs_view->CurrentFilter = $sFilter;
		$sSql = $complete_fs_view->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$complete_fs_view->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $complete_fs_view;
		$complete_fs_view->id->setDbValue($rs->fields('id'));
		$complete_fs_view->mount->setDbValue($rs->fields('mount'));
		$complete_fs_view->path->setDbValue($rs->fields('path'));
		$complete_fs_view->parent->setDbValue($rs->fields('parent'));
		$complete_fs_view->deprecated->setDbValue($rs->fields('deprecated'));
		$complete_fs_view->gid->setDbValue($rs->fields('gid'));
		$complete_fs_view->group_name->setDbValue($rs->fields('group_name'));
		$complete_fs_view->snapshot->setDbValue($rs->fields('snapshot'));
		$complete_fs_view->tapebackup->setDbValue($rs->fields('tapebackup'));
		$complete_fs_view->diskbackup->setDbValue($rs->fields('diskbackup'));
		$complete_fs_view->type->setDbValue($rs->fields('type'));
		$complete_fs_view->server_type->setDbValue($rs->fields('server_type'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $complete_fs_view;

		// Call Row_Rendering event
		$complete_fs_view->Row_Rendering();

		// Common render codes for all row types
		// id

		$complete_fs_view->id->CellCssStyle = "";
		$complete_fs_view->id->CellCssClass = "";

		// mount
		$complete_fs_view->mount->CellCssStyle = "";
		$complete_fs_view->mount->CellCssClass = "";

		// path
		$complete_fs_view->path->CellCssStyle = "";
		$complete_fs_view->path->CellCssClass = "";

		// parent
		$complete_fs_view->parent->CellCssStyle = "";
		$complete_fs_view->parent->CellCssClass = "";

		// deprecated
		$complete_fs_view->deprecated->CellCssStyle = "";
		$complete_fs_view->deprecated->CellCssClass = "";

		// gid
		$complete_fs_view->gid->CellCssStyle = "";
		$complete_fs_view->gid->CellCssClass = "";

		// group_name
		$complete_fs_view->group_name->CellCssStyle = "";
		$complete_fs_view->group_name->CellCssClass = "";

		// snapshot
		$complete_fs_view->snapshot->CellCssStyle = "";
		$complete_fs_view->snapshot->CellCssClass = "";

		// tapebackup
		$complete_fs_view->tapebackup->CellCssStyle = "";
		$complete_fs_view->tapebackup->CellCssClass = "";

		// diskbackup
		$complete_fs_view->diskbackup->CellCssStyle = "";
		$complete_fs_view->diskbackup->CellCssClass = "";

		// type
		$complete_fs_view->type->CellCssStyle = "";
		$complete_fs_view->type->CellCssClass = "";

		// server_type
		$complete_fs_view->server_type->CellCssStyle = "";
		$complete_fs_view->server_type->CellCssClass = "";
		if ($complete_fs_view->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$complete_fs_view->id->ViewValue = $complete_fs_view->id->CurrentValue;
			$complete_fs_view->id->CssStyle = "";
			$complete_fs_view->id->CssClass = "";
			$complete_fs_view->id->ViewCustomAttributes = "";

			// mount
			$complete_fs_view->mount->ViewValue = $complete_fs_view->mount->CurrentValue;
			$complete_fs_view->mount->CssStyle = "";
			$complete_fs_view->mount->CssClass = "";
			$complete_fs_view->mount->ViewCustomAttributes = "";

			// path
			$complete_fs_view->path->ViewValue = $complete_fs_view->path->CurrentValue;
			$complete_fs_view->path->CssStyle = "";
			$complete_fs_view->path->CssClass = "";
			$complete_fs_view->path->ViewCustomAttributes = "";

			// parent
			$complete_fs_view->parent->ViewValue = $complete_fs_view->parent->CurrentValue;
			$complete_fs_view->parent->CssStyle = "";
			$complete_fs_view->parent->CssClass = "";
			$complete_fs_view->parent->ViewCustomAttributes = "";

			// deprecated
			$complete_fs_view->deprecated->ViewValue = $complete_fs_view->deprecated->CurrentValue;
			$complete_fs_view->deprecated->CssStyle = "";
			$complete_fs_view->deprecated->CssClass = "";
			$complete_fs_view->deprecated->ViewCustomAttributes = "";

			// gid
			$complete_fs_view->gid->ViewValue = $complete_fs_view->gid->CurrentValue;
			$complete_fs_view->gid->CssStyle = "";
			$complete_fs_view->gid->CssClass = "";
			$complete_fs_view->gid->ViewCustomAttributes = "";

			// group_name
			$complete_fs_view->group_name->ViewValue = $complete_fs_view->group_name->CurrentValue;
			$complete_fs_view->group_name->CssStyle = "";
			$complete_fs_view->group_name->CssClass = "";
			$complete_fs_view->group_name->ViewCustomAttributes = "";

			// snapshot
			$complete_fs_view->snapshot->ViewValue = $complete_fs_view->snapshot->CurrentValue;
			$complete_fs_view->snapshot->CssStyle = "";
			$complete_fs_view->snapshot->CssClass = "";
			$complete_fs_view->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$complete_fs_view->tapebackup->ViewValue = $complete_fs_view->tapebackup->CurrentValue;
			$complete_fs_view->tapebackup->CssStyle = "";
			$complete_fs_view->tapebackup->CssClass = "";
			$complete_fs_view->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$complete_fs_view->diskbackup->ViewValue = $complete_fs_view->diskbackup->CurrentValue;
			$complete_fs_view->diskbackup->CssStyle = "";
			$complete_fs_view->diskbackup->CssClass = "";
			$complete_fs_view->diskbackup->ViewCustomAttributes = "";

			// type
			$complete_fs_view->type->ViewValue = $complete_fs_view->type->CurrentValue;
			$complete_fs_view->type->CssStyle = "";
			$complete_fs_view->type->CssClass = "";
			$complete_fs_view->type->ViewCustomAttributes = "";

			// server_type
			$complete_fs_view->server_type->ViewValue = $complete_fs_view->server_type->CurrentValue;
			$complete_fs_view->server_type->CssStyle = "";
			$complete_fs_view->server_type->CssClass = "";
			$complete_fs_view->server_type->ViewCustomAttributes = "";

			// id
			$complete_fs_view->id->HrefValue = "";

			// mount
			$complete_fs_view->mount->HrefValue = "";

			// path
			$complete_fs_view->path->HrefValue = "";

			// parent
			$complete_fs_view->parent->HrefValue = "";

			// deprecated
			$complete_fs_view->deprecated->HrefValue = "";

			// gid
			$complete_fs_view->gid->HrefValue = "";

			// group_name
			$complete_fs_view->group_name->HrefValue = "";

			// snapshot
			$complete_fs_view->snapshot->HrefValue = "";

			// tapebackup
			$complete_fs_view->tapebackup->HrefValue = "";

			// diskbackup
			$complete_fs_view->diskbackup->HrefValue = "";

			// type
			$complete_fs_view->type->HrefValue = "";

			// server_type
			$complete_fs_view->server_type->HrefValue = "";
		}

		// Call Row Rendered event
		$complete_fs_view->Row_Rendered();
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
