<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "fsstatinfo.php" ?>
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
$fsstat_list = new cfsstat_list();
$Page =& $fsstat_list;

// Page init processing
$fsstat_list->Page_Init();

// Page main processing
$fsstat_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($fsstat->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var fsstat_list = new ew_Page("fsstat_list");

// page properties
fsstat_list.PageID = "list"; // page ID
var EW_PAGE_ID = fsstat_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
fsstat_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
fsstat_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fsstat_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($fsstat->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($fsstat->Export == "" && $fsstat->SelectLimit);
	if (!$bSelectLimit)
		$rs = $fsstat_list->LoadRecordset();
	$fsstat_list->lTotalRecs = ($bSelectLimit) ? $fsstat->SelectRecordCount() : $rs->RecordCount();
	$fsstat_list->lStartRec = 1;
	if ($fsstat_list->lDisplayRecs <= 0) // Display all records
		$fsstat_list->lDisplayRecs = $fsstat_list->lTotalRecs;
	if (!($fsstat->ExportAll && $fsstat->Export <> ""))
		$fsstat_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $fsstat_list->LoadRecordset($fsstat_list->lStartRec-1, $fsstat_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Fsstat
</span></p>
<?php $fsstat_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="ffsstatlist" id="ffsstatlist" class="ewForm" action="" method="post">
<?php if ($fsstat_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$fsstat_list->lOptionCnt = 0;
	$fsstat_list->lOptionCnt += count($fsstat_list->ListOptions->Items); // Custom list options
?>
<?php echo $fsstat->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($fsstat->fsid->Visible) { // fsid ?>
	<?php if ($fsstat->SortUrl($fsstat->fsid) == "") { ?>
		<td>Fsid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->fsid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fsid</td><td style="width: 10px;"><?php if ($fsstat->fsid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->fsid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->dirid->Visible) { // dirid ?>
	<?php if ($fsstat->SortUrl($fsstat->dirid) == "") { ?>
		<td>Dirid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->dirid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Dirid</td><td style="width: 10px;"><?php if ($fsstat->dirid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->dirid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->checked->Visible) { // checked ?>
	<?php if ($fsstat->SortUrl($fsstat->checked) == "") { ?>
		<td>Checked</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->checked) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Checked</td><td style="width: 10px;"><?php if ($fsstat->checked->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->checked->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->latest->Visible) { // latest ?>
	<?php if ($fsstat->SortUrl($fsstat->latest) == "") { ?>
		<td>Latest</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->latest) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Latest</td><td style="width: 10px;"><?php if ($fsstat->latest->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->latest->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->uid->Visible) { // uid ?>
	<?php if ($fsstat->SortUrl($fsstat->uid) == "") { ?>
		<td>Uid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->uid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Uid</td><td style="width: 10px;"><?php if ($fsstat->uid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->uid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->type->Visible) { // type ?>
	<?php if ($fsstat->SortUrl($fsstat->type) == "") { ?>
		<td>Type</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Type</td><td style="width: 10px;"><?php if ($fsstat->type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->sumcnt->Visible) { // sumcnt ?>
	<?php if ($fsstat->SortUrl($fsstat->sumcnt) == "") { ?>
		<td>Sumcnt</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->sumcnt) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Sumcnt</td><td style="width: 10px;"><?php if ($fsstat->sumcnt->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->sumcnt->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->sumval->Visible) { // sumval ?>
	<?php if ($fsstat->SortUrl($fsstat->sumval) == "") { ?>
		<td>Sumval</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->sumval) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Sumval</td><td style="width: 10px;"><?php if ($fsstat->sumval->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->sumval->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->maxcnt->Visible) { // maxcnt ?>
	<?php if ($fsstat->SortUrl($fsstat->maxcnt) == "") { ?>
		<td>Maxcnt</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->maxcnt) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Maxcnt</td><td style="width: 10px;"><?php if ($fsstat->maxcnt->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->maxcnt->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->maxval->Visible) { // maxval ?>
	<?php if ($fsstat->SortUrl($fsstat->maxval) == "") { ?>
		<td>Maxval</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat->SortUrl($fsstat->maxval) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Maxval</td><td style="width: 10px;"><?php if ($fsstat->maxval->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat->maxval->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat->Export == "") { ?>
<?php

// Custom list options
foreach ($fsstat_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($fsstat->ExportAll && $fsstat->Export <> "") {
	$fsstat_list->lStopRec = $fsstat_list->lTotalRecs;
} else {
	$fsstat_list->lStopRec = $fsstat_list->lStartRec + $fsstat_list->lDisplayRecs - 1; // Set the last record to display
}
$fsstat_list->lRecCount = $fsstat_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$fsstat->SelectLimit && $fsstat_list->lStartRec > 1)
		$rs->Move($fsstat_list->lStartRec - 1);
}
$fsstat_list->lRowCnt = 0;
while (($fsstat->CurrentAction == "gridadd" || !$rs->EOF) &&
	$fsstat_list->lRecCount < $fsstat_list->lStopRec) {
	$fsstat_list->lRecCount++;
	if (intval($fsstat_list->lRecCount) >= intval($fsstat_list->lStartRec)) {
		$fsstat_list->lRowCnt++;

	// Init row class and style
	$fsstat->CssClass = "";
	$fsstat->CssStyle = "";
	$fsstat->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($fsstat->CurrentAction == "gridadd") {
		$fsstat_list->LoadDefaultValues(); // Load default values
	} else {
		$fsstat_list->LoadRowValues($rs); // Load row values
	}
	$fsstat->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$fsstat_list->RenderRow();
?>
	<tr<?php echo $fsstat->RowAttributes() ?>>
	<?php if ($fsstat->fsid->Visible) { // fsid ?>
		<td<?php echo $fsstat->fsid->CellAttributes() ?>>
<div<?php echo $fsstat->fsid->ViewAttributes() ?>><?php echo $fsstat->fsid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->dirid->Visible) { // dirid ?>
		<td<?php echo $fsstat->dirid->CellAttributes() ?>>
<div<?php echo $fsstat->dirid->ViewAttributes() ?>><?php echo $fsstat->dirid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->checked->Visible) { // checked ?>
		<td<?php echo $fsstat->checked->CellAttributes() ?>>
<div<?php echo $fsstat->checked->ViewAttributes() ?>><?php echo $fsstat->checked->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->latest->Visible) { // latest ?>
		<td<?php echo $fsstat->latest->CellAttributes() ?>>
<div<?php echo $fsstat->latest->ViewAttributes() ?>><?php echo $fsstat->latest->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->uid->Visible) { // uid ?>
		<td<?php echo $fsstat->uid->CellAttributes() ?>>
<div<?php echo $fsstat->uid->ViewAttributes() ?>><?php echo $fsstat->uid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->type->Visible) { // type ?>
		<td<?php echo $fsstat->type->CellAttributes() ?>>
<div<?php echo $fsstat->type->ViewAttributes() ?>><?php echo $fsstat->type->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->sumcnt->Visible) { // sumcnt ?>
		<td<?php echo $fsstat->sumcnt->CellAttributes() ?>>
<div<?php echo $fsstat->sumcnt->ViewAttributes() ?>><?php echo $fsstat->sumcnt->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->sumval->Visible) { // sumval ?>
		<td<?php echo $fsstat->sumval->CellAttributes() ?>>
<div<?php echo $fsstat->sumval->ViewAttributes() ?>><?php echo $fsstat->sumval->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->maxcnt->Visible) { // maxcnt ?>
		<td<?php echo $fsstat->maxcnt->CellAttributes() ?>>
<div<?php echo $fsstat->maxcnt->ViewAttributes() ?>><?php echo $fsstat->maxcnt->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat->maxval->Visible) { // maxval ?>
		<td<?php echo $fsstat->maxval->CellAttributes() ?>>
<div<?php echo $fsstat->maxval->ViewAttributes() ?>><?php echo $fsstat->maxval->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($fsstat->Export == "") { ?>
<?php

// Custom list options
foreach ($fsstat_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($fsstat->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
</div>
<?php if ($fsstat->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($fsstat->CurrentAction <> "gridadd" && $fsstat->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($fsstat_list->Pager)) $fsstat_list->Pager = new cPrevNextPager($fsstat_list->lStartRec, $fsstat_list->lDisplayRecs, $fsstat_list->lTotalRecs) ?>
<?php if ($fsstat_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($fsstat_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $fsstat_list->PageUrl() ?>start=<?php echo $fsstat_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($fsstat_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $fsstat_list->PageUrl() ?>start=<?php echo $fsstat_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $fsstat_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($fsstat_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $fsstat_list->PageUrl() ?>start=<?php echo $fsstat_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($fsstat_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $fsstat_list->PageUrl() ?>start=<?php echo $fsstat_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $fsstat_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $fsstat_list->Pager->FromIndex ?> to <?php echo $fsstat_list->Pager->ToIndex ?> of <?php echo $fsstat_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($fsstat_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($fsstat_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($fsstat->Export == "" && $fsstat->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(fsstat_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($fsstat->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$fsstat_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cfsstat_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'fsstat';

	// Page Object Name
	var $PageObjName = 'fsstat_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $fsstat;
		if ($fsstat->UseTokenInUrl) $PageUrl .= "t=" . $fsstat->TableVar . "&"; // add page token
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
		global $objForm, $fsstat;
		if ($fsstat->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($fsstat->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($fsstat->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cfsstat_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["fsstat"] = new cfsstat();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fsstat', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $fsstat;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$fsstat->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $fsstat->Export; // Get export parameter, used in header
	$gsExportFile = $fsstat->TableVar; // Get export file, used in header

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
	var $sSrchWhere;
	var $lRecCnt;
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex;
	var $lOptionCnt;
	var $lRecPerRow;
	var $lColCnt;
	var $sDeleteConfirmMsg; // Delete confirm message
	var $sDbMasterFilter;
	var $sDbDetailFilter;
	var $bMasterRecordExists;	
	var $ListOptions;
	var $sMultiSelectKey;

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $Security, $fsstat;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause

		// Master/Detail
		$this->sDbMasterFilter = ""; // Master filter
		$this->sDbDetailFilter = ""; // Detail filter
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($fsstat->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $fsstat->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$fsstat->setSessionWhere($sFilter);
		$fsstat->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $fsstat;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$fsstat->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$fsstat->CurrentOrderType = @$_GET["ordertype"];
			$fsstat->UpdateSort($fsstat->fsid); // Field 
			$fsstat->UpdateSort($fsstat->dirid); // Field 
			$fsstat->UpdateSort($fsstat->checked); // Field 
			$fsstat->UpdateSort($fsstat->latest); // Field 
			$fsstat->UpdateSort($fsstat->uid); // Field 
			$fsstat->UpdateSort($fsstat->type); // Field 
			$fsstat->UpdateSort($fsstat->sumcnt); // Field 
			$fsstat->UpdateSort($fsstat->sumval); // Field 
			$fsstat->UpdateSort($fsstat->maxcnt); // Field 
			$fsstat->UpdateSort($fsstat->maxval); // Field 
			$fsstat->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $fsstat;
		$sOrderBy = $fsstat->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($fsstat->SqlOrderBy() <> "") {
				$sOrderBy = $fsstat->SqlOrderBy();
				$fsstat->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $fsstat;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$fsstat->setSessionOrderBy($sOrderBy);
				$fsstat->fsid->setSort("");
				$fsstat->dirid->setSort("");
				$fsstat->checked->setSort("");
				$fsstat->latest->setSort("");
				$fsstat->uid->setSort("");
				$fsstat->type->setSort("");
				$fsstat->sumcnt->setSort("");
				$fsstat->sumval->setSort("");
				$fsstat->maxcnt->setSort("");
				$fsstat->maxval->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$fsstat->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $fsstat;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$fsstat->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$fsstat->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $fsstat->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$fsstat->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$fsstat->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$fsstat->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $fsstat;

		// Call Recordset Selecting event
		$fsstat->Recordset_Selecting($fsstat->CurrentFilter);

		// Load list page SQL
		$sSql = $fsstat->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$fsstat->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $fsstat;
		$sFilter = $fsstat->KeyFilter();

		// Call Row Selecting event
		$fsstat->Row_Selecting($sFilter);

		// Load sql based on filter
		$fsstat->CurrentFilter = $sFilter;
		$sSql = $fsstat->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$fsstat->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $fsstat;
		$fsstat->fsid->setDbValue($rs->fields('fsid'));
		$fsstat->dirid->setDbValue($rs->fields('dirid'));
		$fsstat->checked->setDbValue($rs->fields('checked'));
		$fsstat->latest->setDbValue($rs->fields('latest'));
		$fsstat->uid->setDbValue($rs->fields('uid'));
		$fsstat->type->setDbValue($rs->fields('type'));
		$fsstat->sumcnt->setDbValue($rs->fields('sumcnt'));
		$fsstat->sumval->setDbValue($rs->fields('sumval'));
		$fsstat->maxcnt->setDbValue($rs->fields('maxcnt'));
		$fsstat->maxval->setDbValue($rs->fields('maxval'));
		$fsstat->histogram->Upload->DbValue = $rs->fields('histogram');
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $fsstat;

		// Call Row_Rendering event
		$fsstat->Row_Rendering();

		// Common render codes for all row types
		// fsid

		$fsstat->fsid->CellCssStyle = "";
		$fsstat->fsid->CellCssClass = "";

		// dirid
		$fsstat->dirid->CellCssStyle = "";
		$fsstat->dirid->CellCssClass = "";

		// checked
		$fsstat->checked->CellCssStyle = "";
		$fsstat->checked->CellCssClass = "";

		// latest
		$fsstat->latest->CellCssStyle = "";
		$fsstat->latest->CellCssClass = "";

		// uid
		$fsstat->uid->CellCssStyle = "";
		$fsstat->uid->CellCssClass = "";

		// type
		$fsstat->type->CellCssStyle = "";
		$fsstat->type->CellCssClass = "";

		// sumcnt
		$fsstat->sumcnt->CellCssStyle = "";
		$fsstat->sumcnt->CellCssClass = "";

		// sumval
		$fsstat->sumval->CellCssStyle = "";
		$fsstat->sumval->CellCssClass = "";

		// maxcnt
		$fsstat->maxcnt->CellCssStyle = "";
		$fsstat->maxcnt->CellCssClass = "";

		// maxval
		$fsstat->maxval->CellCssStyle = "";
		$fsstat->maxval->CellCssClass = "";
		if ($fsstat->RowType == EW_ROWTYPE_VIEW) { // View row

			// fsid
			$fsstat->fsid->ViewValue = $fsstat->fsid->CurrentValue;
			$fsstat->fsid->CssStyle = "";
			$fsstat->fsid->CssClass = "";
			$fsstat->fsid->ViewCustomAttributes = "";

			// dirid
			$fsstat->dirid->ViewValue = $fsstat->dirid->CurrentValue;
			$fsstat->dirid->CssStyle = "";
			$fsstat->dirid->CssClass = "";
			$fsstat->dirid->ViewCustomAttributes = "";

			// checked
			$fsstat->checked->ViewValue = $fsstat->checked->CurrentValue;
			$fsstat->checked->CssStyle = "";
			$fsstat->checked->CssClass = "";
			$fsstat->checked->ViewCustomAttributes = "";

			// latest
			$fsstat->latest->ViewValue = $fsstat->latest->CurrentValue;
			$fsstat->latest->CssStyle = "";
			$fsstat->latest->CssClass = "";
			$fsstat->latest->ViewCustomAttributes = "";

			// uid
			$fsstat->uid->ViewValue = $fsstat->uid->CurrentValue;
			$fsstat->uid->CssStyle = "";
			$fsstat->uid->CssClass = "";
			$fsstat->uid->ViewCustomAttributes = "";

			// type
			$fsstat->type->ViewValue = $fsstat->type->CurrentValue;
			$fsstat->type->CssStyle = "";
			$fsstat->type->CssClass = "";
			$fsstat->type->ViewCustomAttributes = "";

			// sumcnt
			$fsstat->sumcnt->ViewValue = $fsstat->sumcnt->CurrentValue;
			$fsstat->sumcnt->CssStyle = "";
			$fsstat->sumcnt->CssClass = "";
			$fsstat->sumcnt->ViewCustomAttributes = "";

			// sumval
			$fsstat->sumval->ViewValue = $fsstat->sumval->CurrentValue;
			$fsstat->sumval->CssStyle = "";
			$fsstat->sumval->CssClass = "";
			$fsstat->sumval->ViewCustomAttributes = "";

			// maxcnt
			$fsstat->maxcnt->ViewValue = $fsstat->maxcnt->CurrentValue;
			$fsstat->maxcnt->CssStyle = "";
			$fsstat->maxcnt->CssClass = "";
			$fsstat->maxcnt->ViewCustomAttributes = "";

			// maxval
			$fsstat->maxval->ViewValue = $fsstat->maxval->CurrentValue;
			$fsstat->maxval->CssStyle = "";
			$fsstat->maxval->CssClass = "";
			$fsstat->maxval->ViewCustomAttributes = "";

			// fsid
			$fsstat->fsid->HrefValue = "";

			// dirid
			$fsstat->dirid->HrefValue = "";

			// checked
			$fsstat->checked->HrefValue = "";

			// latest
			$fsstat->latest->HrefValue = "";

			// uid
			$fsstat->uid->HrefValue = "";

			// type
			$fsstat->type->HrefValue = "";

			// sumcnt
			$fsstat->sumcnt->HrefValue = "";

			// sumval
			$fsstat->sumval->HrefValue = "";

			// maxcnt
			$fsstat->maxcnt->HrefValue = "";

			// maxval
			$fsstat->maxval->HrefValue = "";
		}

		// Call Row Rendered event
		$fsstat->Row_Rendered();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
