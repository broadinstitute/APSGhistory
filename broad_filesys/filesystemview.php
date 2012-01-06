<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "filesysteminfo.php" ?>
<?php include "grpinfo.php" ?>
<?php include "server_typeinfo.php" ?>
<?php include "usersinfo.php" ?>
<?php include "userfn7.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$filesystem_view = new cfilesystem_view();
$Page =& $filesystem_view;

// Page init
$filesystem_view->Page_Init();

// Page main
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
filesystem_view.FormID = "ffilesystemview"; // form ID
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $filesystem->TableCaption() ?>
<br><br>
<?php if ($filesystem->Export == "") { ?>
<a href="<?php echo $filesystem_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $filesystem_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $filesystem_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $filesystem_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$filesystem_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($filesystem->id->Visible) { // id ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->id->FldCaption() ?></td>
		<td<?php echo $filesystem->id->CellAttributes() ?>>
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->mount->Visible) { // mount ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->mount->FldCaption() ?></td>
		<td<?php echo $filesystem->mount->CellAttributes() ?>>
<div<?php echo $filesystem->mount->ViewAttributes() ?>><?php echo $filesystem->mount->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->path->Visible) { // path ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->path->FldCaption() ?></td>
		<td<?php echo $filesystem->path->CellAttributes() ?>>
<div<?php echo $filesystem->path->ViewAttributes() ?>><?php echo $filesystem->path->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->parent->Visible) { // parent ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->parent->FldCaption() ?></td>
		<td<?php echo $filesystem->parent->CellAttributes() ?>>
<div<?php echo $filesystem->parent->ViewAttributes() ?>><?php echo $filesystem->parent->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->deprecated->Visible) { // deprecated ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->deprecated->FldCaption() ?></td>
		<td<?php echo $filesystem->deprecated->CellAttributes() ?>>
<div<?php echo $filesystem->deprecated->ViewAttributes() ?>><?php echo $filesystem->deprecated->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->gid->Visible) { // gid ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->gid->FldCaption() ?></td>
		<td<?php echo $filesystem->gid->CellAttributes() ?>>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->snapshot->Visible) { // snapshot ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->snapshot->FldCaption() ?></td>
		<td<?php echo $filesystem->snapshot->CellAttributes() ?>>
<div<?php echo $filesystem->snapshot->ViewAttributes() ?>><?php echo $filesystem->snapshot->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->tapebackup->Visible) { // tapebackup ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->tapebackup->FldCaption() ?></td>
		<td<?php echo $filesystem->tapebackup->CellAttributes() ?>>
<div<?php echo $filesystem->tapebackup->ViewAttributes() ?>><?php echo $filesystem->tapebackup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->diskbackup->Visible) { // diskbackup ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->diskbackup->FldCaption() ?></td>
		<td<?php echo $filesystem->diskbackup->CellAttributes() ?>>
<div<?php echo $filesystem->diskbackup->ViewAttributes() ?>><?php echo $filesystem->diskbackup->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->type->Visible) { // type ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->type->FldCaption() ?></td>
		<td<?php echo $filesystem->type->CellAttributes() ?>>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->contact->Visible) { // contact ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->contact->FldCaption() ?></td>
		<td<?php echo $filesystem->contact->CellAttributes() ?>>
<div<?php echo $filesystem->contact->ViewAttributes() ?>><?php echo $filesystem->contact->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->contact2->Visible) { // contact2 ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->contact2->FldCaption() ?></td>
		<td<?php echo $filesystem->contact2->CellAttributes() ?>>
<div<?php echo $filesystem->contact2->ViewAttributes() ?>><?php echo $filesystem->contact2->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->rescomp->Visible) { // rescomp ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->rescomp->FldCaption() ?></td>
		<td<?php echo $filesystem->rescomp->CellAttributes() ?>>
<div<?php echo $filesystem->rescomp->ViewAttributes() ?>><?php echo $filesystem->rescomp->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($filesystem->maxdepth->Visible) { // maxdepth ?>
	<tr<?php echo $filesystem->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $filesystem->maxdepth->FldCaption() ?></td>
		<td<?php echo $filesystem->maxdepth->CellAttributes() ?>>
<div<?php echo $filesystem->maxdepth->ViewAttributes() ?>><?php echo $filesystem->maxdepth->ViewValue ?></div></td>
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
// Page class
//
class cfilesystem_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'filesystem';

	// Page object name
	var $PageObjName = 'filesystem_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $filesystem;
		if ($filesystem->UseTokenInUrl) $PageUrl .= "t=" . $filesystem->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $filesystem;
		if ($filesystem->UseTokenInUrl) {
			if ($objForm)
				return ($filesystem->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($filesystem->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cfilesystem_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (filesystem)
		$GLOBALS["filesystem"] = new cfilesystem();

		// Table object (grp)
		$GLOBALS['grp'] = new cgrp();

		// Table object (server_type)
		$GLOBALS['server_type'] = new cserver_type();

		// Table object (users)
		$GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'filesystem', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $filesystem;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $lDisplayRecs = 1;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $lRecCnt;
	var $arRecKey = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $filesystem;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$filesystem->id->setQueryStringValue($_GET["id"]);
				$this->arRecKey["id"] = $filesystem->id->QueryStringValue;
			} else {
				$sReturnUrl = "filesystemlist.php"; // Return to list
			}

			// Get action
			$filesystem->CurrentAction = "I"; // Display form
			switch ($filesystem->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
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

	// Set up starting record parameters
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

		// Load SQL based on filter
		$filesystem->CurrentFilter = $sFilter;
		$sSql = $filesystem->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$filesystem->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $filesystem;
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
		$filesystem->maxdepth->setDbValue($rs->fields('maxdepth'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $filesystem;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id=" . urlencode($filesystem->id->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id=" . urlencode($filesystem->id->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id=" . urlencode($filesystem->id->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id=" . urlencode($filesystem->id->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id=" . urlencode($filesystem->id->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id=" . urlencode($filesystem->id->CurrentValue);
		$this->AddUrl = $filesystem->AddUrl();
		$this->EditUrl = $filesystem->EditUrl();
		$this->CopyUrl = $filesystem->CopyUrl();
		$this->DeleteUrl = $filesystem->DeleteUrl();
		$this->ListUrl = $filesystem->ListUrl();

		// Call Row_Rendering event
		$filesystem->Row_Rendering();

		// Common render codes for all row types
		// id

		$filesystem->id->CellCssStyle = ""; $filesystem->id->CellCssClass = "";
		$filesystem->id->CellAttrs = array(); $filesystem->id->ViewAttrs = array(); $filesystem->id->EditAttrs = array();

		// mount
		$filesystem->mount->CellCssStyle = ""; $filesystem->mount->CellCssClass = "";
		$filesystem->mount->CellAttrs = array(); $filesystem->mount->ViewAttrs = array(); $filesystem->mount->EditAttrs = array();

		// path
		$filesystem->path->CellCssStyle = ""; $filesystem->path->CellCssClass = "";
		$filesystem->path->CellAttrs = array(); $filesystem->path->ViewAttrs = array(); $filesystem->path->EditAttrs = array();

		// parent
		$filesystem->parent->CellCssStyle = ""; $filesystem->parent->CellCssClass = "";
		$filesystem->parent->CellAttrs = array(); $filesystem->parent->ViewAttrs = array(); $filesystem->parent->EditAttrs = array();

		// deprecated
		$filesystem->deprecated->CellCssStyle = ""; $filesystem->deprecated->CellCssClass = "";
		$filesystem->deprecated->CellAttrs = array(); $filesystem->deprecated->ViewAttrs = array(); $filesystem->deprecated->EditAttrs = array();

		// gid
		$filesystem->gid->CellCssStyle = ""; $filesystem->gid->CellCssClass = "";
		$filesystem->gid->CellAttrs = array(); $filesystem->gid->ViewAttrs = array(); $filesystem->gid->EditAttrs = array();

		// snapshot
		$filesystem->snapshot->CellCssStyle = ""; $filesystem->snapshot->CellCssClass = "";
		$filesystem->snapshot->CellAttrs = array(); $filesystem->snapshot->ViewAttrs = array(); $filesystem->snapshot->EditAttrs = array();

		// tapebackup
		$filesystem->tapebackup->CellCssStyle = ""; $filesystem->tapebackup->CellCssClass = "";
		$filesystem->tapebackup->CellAttrs = array(); $filesystem->tapebackup->ViewAttrs = array(); $filesystem->tapebackup->EditAttrs = array();

		// diskbackup
		$filesystem->diskbackup->CellCssStyle = ""; $filesystem->diskbackup->CellCssClass = "";
		$filesystem->diskbackup->CellAttrs = array(); $filesystem->diskbackup->ViewAttrs = array(); $filesystem->diskbackup->EditAttrs = array();

		// type
		$filesystem->type->CellCssStyle = ""; $filesystem->type->CellCssClass = "";
		$filesystem->type->CellAttrs = array(); $filesystem->type->ViewAttrs = array(); $filesystem->type->EditAttrs = array();

		// contact
		$filesystem->contact->CellCssStyle = ""; $filesystem->contact->CellCssClass = "";
		$filesystem->contact->CellAttrs = array(); $filesystem->contact->ViewAttrs = array(); $filesystem->contact->EditAttrs = array();

		// contact2
		$filesystem->contact2->CellCssStyle = ""; $filesystem->contact2->CellCssClass = "";
		$filesystem->contact2->CellAttrs = array(); $filesystem->contact2->ViewAttrs = array(); $filesystem->contact2->EditAttrs = array();

		// rescomp
		$filesystem->rescomp->CellCssStyle = ""; $filesystem->rescomp->CellCssClass = "";
		$filesystem->rescomp->CellAttrs = array(); $filesystem->rescomp->ViewAttrs = array(); $filesystem->rescomp->EditAttrs = array();

		// maxdepth
		$filesystem->maxdepth->CellCssStyle = ""; $filesystem->maxdepth->CellCssClass = "";
		$filesystem->maxdepth->CellAttrs = array(); $filesystem->maxdepth->ViewAttrs = array(); $filesystem->maxdepth->EditAttrs = array();
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
				$sFilterWrk = "`id` = " . ew_AdjustSql($filesystem->gid->CurrentValue) . "";
			$sSqlWrk = "SELECT `id`, `name` FROM `grp`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
				$sFilterWrk = "`id` = " . ew_AdjustSql($filesystem->type->CurrentValue) . "";
			$sSqlWrk = "SELECT `id`, `name` FROM `server_type`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			if (strval($filesystem->contact->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->contact->ViewValue = $rswrk->fields('uid');
					$filesystem->contact->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->contact->ViewValue = $filesystem->contact->CurrentValue;
				}
			} else {
				$filesystem->contact->ViewValue = NULL;
			}
			$filesystem->contact->CssStyle = "";
			$filesystem->contact->CssClass = "";
			$filesystem->contact->ViewCustomAttributes = "";

			// contact2
			$filesystem->contact2->ViewValue = $filesystem->contact2->CurrentValue;
			if (strval($filesystem->contact2->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->contact2->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->contact2->ViewValue = $rswrk->fields('uid');
					$filesystem->contact2->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->contact2->ViewValue = $filesystem->contact2->CurrentValue;
				}
			} else {
				$filesystem->contact2->ViewValue = NULL;
			}
			$filesystem->contact2->CssStyle = "";
			$filesystem->contact2->CssClass = "";
			$filesystem->contact2->ViewCustomAttributes = "";

			// rescomp
			$filesystem->rescomp->ViewValue = $filesystem->rescomp->CurrentValue;
			if (strval($filesystem->rescomp->CurrentValue) <> "") {
				$sFilterWrk = "`uid` = " . ew_AdjustSql($filesystem->rescomp->CurrentValue) . "";
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `uid` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$filesystem->rescomp->ViewValue = $rswrk->fields('uid');
					$filesystem->rescomp->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
					$rswrk->Close();
				} else {
					$filesystem->rescomp->ViewValue = $filesystem->rescomp->CurrentValue;
				}
			} else {
				$filesystem->rescomp->ViewValue = NULL;
			}
			$filesystem->rescomp->CssStyle = "";
			$filesystem->rescomp->CssClass = "";
			$filesystem->rescomp->ViewCustomAttributes = "";

			// maxdepth
			$filesystem->maxdepth->ViewValue = $filesystem->maxdepth->CurrentValue;
			$filesystem->maxdepth->CssStyle = "";
			$filesystem->maxdepth->CssClass = "";
			$filesystem->maxdepth->ViewCustomAttributes = "";

			// id
			$filesystem->id->HrefValue = "";
			$filesystem->id->TooltipValue = "";

			// mount
			$filesystem->mount->HrefValue = "";
			$filesystem->mount->TooltipValue = "";

			// path
			$filesystem->path->HrefValue = "";
			$filesystem->path->TooltipValue = "";

			// parent
			$filesystem->parent->HrefValue = "";
			$filesystem->parent->TooltipValue = "";

			// deprecated
			$filesystem->deprecated->HrefValue = "";
			$filesystem->deprecated->TooltipValue = "";

			// gid
			$filesystem->gid->HrefValue = "";
			$filesystem->gid->TooltipValue = "";

			// snapshot
			$filesystem->snapshot->HrefValue = "";
			$filesystem->snapshot->TooltipValue = "";

			// tapebackup
			$filesystem->tapebackup->HrefValue = "";
			$filesystem->tapebackup->TooltipValue = "";

			// diskbackup
			$filesystem->diskbackup->HrefValue = "";
			$filesystem->diskbackup->TooltipValue = "";

			// type
			$filesystem->type->HrefValue = "";
			$filesystem->type->TooltipValue = "";

			// contact
			$filesystem->contact->HrefValue = "";
			$filesystem->contact->TooltipValue = "";

			// contact2
			$filesystem->contact2->HrefValue = "";
			$filesystem->contact2->TooltipValue = "";

			// rescomp
			$filesystem->rescomp->HrefValue = "";
			$filesystem->rescomp->TooltipValue = "";

			// maxdepth
			$filesystem->maxdepth->HrefValue = "";
			$filesystem->maxdepth->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($filesystem->RowType <> EW_ROWTYPE_AGGREGATEINIT)
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

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}
}
?>
