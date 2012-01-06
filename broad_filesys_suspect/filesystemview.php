<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "filesysteminfo.php" ?>
<?php include "grpinfo.php" ?>
<?php include "server_typeinfo.php" ?>
<?php include "usersinfo.php" ?>
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
$filesystem_view = new cfilesystem_view();
$Page =& $filesystem_view;

// Page init processing
$filesystem_view->Page_Init();

// Page main processing
$filesystem_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($filesystem->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var filesystem_view = new ew_Page("filesystem_view");

// page properties
filesystem_view.PageID = "view"; // page ID
var EW_PAGE_ID = filesystem_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
filesystem_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
filesystem_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
filesystem_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">View TABLE: Filesystem
<br><br>
<?php if ($filesystem->Export == "") { ?>
<a href="filesystemlist.php">Back to List</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $filesystem->EditUrl() ?>">Edit</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $filesystem_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($filesystem->id->Visible) { // id ?>
	<tr<?php echo $filesystem->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $filesystem->id->CellAttributes() ?>>
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->mount->Visible) { // mount ?>
	<tr<?php echo $filesystem->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount</td>
		<td<?php echo $filesystem->mount->CellAttributes() ?>>
<div<?php echo $filesystem->mount->ViewAttributes() ?>><?php echo $filesystem->mount->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->path->Visible) { // path ?>
	<tr<?php echo $filesystem->path->RowAttributes ?>>
		<td class="ewTableHeader">Path</td>
		<td<?php echo $filesystem->path->CellAttributes() ?>>
<div<?php echo $filesystem->path->ViewAttributes() ?>><?php echo $filesystem->path->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->parent->Visible) { // parent ?>
	<tr<?php echo $filesystem->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $filesystem->parent->CellAttributes() ?>>
<div<?php echo $filesystem->parent->ViewAttributes() ?>><?php echo $filesystem->parent->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $filesystem->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $filesystem->deprecated->CellAttributes() ?>>
<div<?php echo $filesystem->deprecated->ViewAttributes() ?>><?php echo $filesystem->deprecated->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->gid->Visible) { // gid ?>
	<tr<?php echo $filesystem->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $filesystem->gid->CellAttributes() ?>>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
	<tr<?php echo $filesystem->snapshot->RowAttributes ?>>
		<td class="ewTableHeader">Snapshot</td>
		<td<?php echo $filesystem->snapshot->CellAttributes() ?>>
<div<?php echo $filesystem->snapshot->ViewAttributes() ?>><?php echo $filesystem->snapshot->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
	<tr<?php echo $filesystem->tapebackup->RowAttributes ?>>
		<td class="ewTableHeader">Tapebackup</td>
		<td<?php echo $filesystem->tapebackup->CellAttributes() ?>>
<div<?php echo $filesystem->tapebackup->ViewAttributes() ?>><?php echo $filesystem->tapebackup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
	<tr<?php echo $filesystem->diskbackup->RowAttributes ?>>
		<td class="ewTableHeader">Diskbackup</td>
		<td<?php echo $filesystem->diskbackup->CellAttributes() ?>>
<div<?php echo $filesystem->diskbackup->ViewAttributes() ?>><?php echo $filesystem->diskbackup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->type->Visible) { // type ?>
	<tr<?php echo $filesystem->type->RowAttributes ?>>
		<td class="ewTableHeader">Type</td>
		<td<?php echo $filesystem->type->CellAttributes() ?>>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->contact->Visible) { // contact ?>
	<tr<?php echo $filesystem->contact->RowAttributes ?>>
		<td class="ewTableHeader">Contact</td>
		<td<?php echo $filesystem->contact->CellAttributes() ?>>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->contact2->Visible) { // contact2 ?>
	<tr<?php echo $filesystem->contact2->RowAttributes ?>>
		<td class="ewTableHeader">Contact 2</td>
		<td<?php echo $filesystem->contact2->CellAttributes() ?>>
<div<?php echo $filesystem->contact2->ViewAttributes() ?>><?php echo $filesystem->contact2->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
	<tr<?php echo $filesystem->rescomp->RowAttributes ?>>
		<td class="ewTableHeader">Rescomp</td>
		<td<?php echo $filesystem->rescomp->CellAttributes() ?>>
<div<?php echo $filesystem->rescomp->ViewAttributes() ?>><?php echo $filesystem->rescomp->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($filesystem->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$filesystem_view->Page_Terminate();
?>
<?php

//
// Page Class
//
class cfilesystem_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'filesystem';

	// Page Object Name
	var $PageObjName = 'filesystem_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $filesystem;
		if ($filesystem->UseTokenInUrl) $PageUrl .= "t=" . $filesystem->TableVar . "&"; // add page token
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
		global $objForm, $filesystem;
		if ($filesystem->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($filesystem->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($filesystem->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cfilesystem_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["filesystem"] = new cfilesystem();

		// Initialize other table object
		$GLOBALS['grp'] = new cgrp();

		// Initialize other table object
		$GLOBALS['server_type'] = new cserver_type();

		// Initialize other table object
		$GLOBALS['users'] = new cusers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'filesystem', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $filesystem;
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
		global $filesystem;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$filesystem->id->setQueryStringValue($_GET["id"]);
			} else {
				$sReturnUrl = "filesystemlist.php"; // Return to list
			}

			// Get action
			$filesystem->CurrentAction = "I"; // Display form
			switch ($filesystem->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No records found"); // Set no record message
						$sReturnUrl = "filesystemlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "filesystemlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$filesystem->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $filesystem;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$filesystem->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$filesystem->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $filesystem->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$filesystem->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$filesystem->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$filesystem->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $filesystem;
		$sFilter = $filesystem->KeyFilter();

		// Call Row Selecting event
		$filesystem->Row_Selecting($sFilter);

		// Load sql based on filter
		$filesystem->CurrentFilter = $sFilter;
		$sSql = $filesystem->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$filesystem->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $filesystem;
		$filesystem->id->setDbValue($rs->fields('id'));
		$filesystem->mount->setDbValue($rs->fields('mount'));
		$filesystem->path->setDbValue($rs->fields('path'));
		$filesystem->parent->setDbValue($rs->fields('parent'));
		$filesystem->deprecated->setDbValue($rs->fields('deprecated'));
		$filesystem->gid->setDbValue($rs->fields('gid'));
		$filesystem->snapshot->setDbValue($rs->fields('snapshot'));
		$filesystem->tapebackup->setDbValue($rs->fields('tapebackup'));
		$filesystem->diskbackup->setDbValue($rs->fields('diskbackup'));
		$filesystem->type->setDbValue($rs->fields('type'));
		$filesystem->contact->setDbValue($rs->fields('contact'));
		$filesystem->contact2->setDbValue($rs->fields('contact2'));
		$filesystem->rescomp->setDbValue($rs->fields('rescomp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $filesystem;

		// Call Row_Rendering event
		$filesystem->Row_Rendering();

		// Common render codes for all row types
		// id

		$filesystem->id->CellCssStyle = "";
		$filesystem->id->CellCssClass = "";

		// mount
		$filesystem->mount->CellCssStyle = "";
		$filesystem->mount->CellCssClass = "";

		// path
		$filesystem->path->CellCssStyle = "";
		$filesystem->path->CellCssClass = "";

		// parent
		$filesystem->parent->CellCssStyle = "";
		$filesystem->parent->CellCssClass = "";

		// deprecated
		$filesystem->deprecated->CellCssStyle = "";
		$filesystem->deprecated->CellCssClass = "";

		// gid
		$filesystem->gid->CellCssStyle = "";
		$filesystem->gid->CellCssClass = "";

		// snapshot
		$filesystem->snapshot->CellCssStyle = "";
		$filesystem->snapshot->CellCssClass = "";

		// tapebackup
		$filesystem->tapebackup->CellCssStyle = "";
		$filesystem->tapebackup->CellCssClass = "";

		// diskbackup
		$filesystem->diskbackup->CellCssStyle = "";
		$filesystem->diskbackup->CellCssClass = "";

		// type
		$filesystem->type->CellCssStyle = "";
		$filesystem->type->CellCssClass = "";

		// contact
		$filesystem->contact->CellCssStyle = "";
		$filesystem->contact->CellCssClass = "";

		// contact2
		$filesystem->contact2->CellCssStyle = "";
		$filesystem->contact2->CellCssClass = "";

		// rescomp
		$filesystem->rescomp->CellCssStyle = "";
		$filesystem->rescomp->CellCssClass = "";
		if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$filesystem->id->ViewValue = $filesystem->id->CurrentValue;
			$filesystem->id->CssStyle = "";
			$filesystem->id->CssClass = "";
			$filesystem->id->ViewCustomAttributes = "";

			// mount
			$filesystem->mount->ViewValue = $filesystem->mount->CurrentValue;
			$filesystem->mount->CssStyle = "";
			$filesystem->mount->CssClass = "";
			$filesystem->mount->ViewCustomAttributes = "";

			// path
			$filesystem->path->ViewValue = $filesystem->path->CurrentValue;
			$filesystem->path->CssStyle = "";
			$filesystem->path->CssClass = "";
			$filesystem->path->ViewCustomAttributes = "";

			// parent
			$filesystem->parent->ViewValue = $filesystem->parent->CurrentValue;
			$filesystem->parent->CssStyle = "";
			$filesystem->parent->CssClass = "";
			$filesystem->parent->ViewCustomAttributes = "";

			// deprecated
			$filesystem->deprecated->ViewValue = $filesystem->deprecated->CurrentValue;
			$filesystem->deprecated->CssStyle = "";
			$filesystem->deprecated->CssClass = "";
			$filesystem->deprecated->ViewCustomAttributes = "";

			// gid
			if (strval($filesystem->gid->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `id`, `name` FROM `grp` WHERE `id` = " . ew_AdjustSql($filesystem->gid->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->gid->ViewValue = $rswrk->fields('id');
					$filesystem->gid->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
					$rswrk->Close();
				} else {
					$filesystem->gid->ViewValue = $filesystem->gid->CurrentValue;
				}
			} else {
				$filesystem->gid->ViewValue = NULL;
			}
			$filesystem->gid->CssStyle = "";
			$filesystem->gid->CssClass = "";
			$filesystem->gid->ViewCustomAttributes = "";

			// snapshot
			$filesystem->snapshot->ViewValue = $filesystem->snapshot->CurrentValue;
			$filesystem->snapshot->CssStyle = "";
			$filesystem->snapshot->CssClass = "";
			$filesystem->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$filesystem->tapebackup->ViewValue = $filesystem->tapebackup->CurrentValue;
			$filesystem->tapebackup->CssStyle = "";
			$filesystem->tapebackup->CssClass = "";
			$filesystem->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$filesystem->diskbackup->ViewValue = $filesystem->diskbackup->CurrentValue;
			$filesystem->diskbackup->CssStyle = "";
			$filesystem->diskbackup->CssClass = "";
			$filesystem->diskbackup->ViewCustomAttributes = "";

			// type
			if (strval($filesystem->type->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `id`, `name` FROM `server_type` WHERE `id` = " . ew_AdjustSql($filesystem->type->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$filesystem->type->ViewValue = $rswrk->fields('id');
					$filesystem->type->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
					$rswrk->Close();
				} else {
					$filesystem->type->ViewValue = $filesystem->type->CurrentValue;
				}
			} else {
				$filesystem->type->ViewValue = NULL;
			}
			$filesystem->type->CssStyle = "";
			$filesystem->type->CssClass = "";
			$filesystem->type->ViewCustomAttributes = "";

			// contact
			$filesystem->contact->ViewValue = $filesystem->contact->CurrentValue;
			$filesystem->contact->CssStyle = "";
			$filesystem->contact->CssClass = "";
			$filesystem->contact->ViewCustomAttributes = "";

			// contact2
			$filesystem->contact2->ViewValue = $filesystem->contact2->CurrentValue;
			$filesystem->contact2->CssStyle = "";
			$filesystem->contact2->CssClass = "";
			$filesystem->contact2->ViewCustomAttributes = "";

			// rescomp
			$filesystem->rescomp->ViewValue = $filesystem->rescomp->CurrentValue;
			$filesystem->rescomp->CssStyle = "";
			$filesystem->rescomp->CssClass = "";
			$filesystem->rescomp->ViewCustomAttributes = "";

			// id
			$filesystem->id->HrefValue = "";

			// mount
			$filesystem->mount->HrefValue = "";

			// path
			$filesystem->path->HrefValue = "";

			// parent
			$filesystem->parent->HrefValue = "";

			// deprecated
			$filesystem->deprecated->HrefValue = "";

			// gid
			$filesystem->gid->HrefValue = "";

			// snapshot
			$filesystem->snapshot->HrefValue = "";

			// tapebackup
			$filesystem->tapebackup->HrefValue = "";

			// diskbackup
			$filesystem->diskbackup->HrefValue = "";

			// type
			$filesystem->type->HrefValue = "";

			// contact
			$filesystem->contact->HrefValue = "";

			// contact2
			$filesystem->contact2->HrefValue = "";

			// rescomp
			$filesystem->rescomp->HrefValue = "";
		}

		// Call Row Rendered event
		$filesystem->Row_Rendered();
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
