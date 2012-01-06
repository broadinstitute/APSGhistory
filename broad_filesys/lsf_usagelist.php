<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_usageinfo.php" ?>
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
$lsf_usage_list = new clsf_usage_list();
$Page =& $lsf_usage_list;

// Page init processing
$lsf_usage_list->Page_Init();

// Page main processing
$lsf_usage_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lsf_usage->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_usage_list = new ew_Page("lsf_usage_list");

// page properties
lsf_usage_list.PageID = "list"; // page ID
var EW_PAGE_ID = lsf_usage_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_usage_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_usage_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_usage_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($lsf_usage->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($lsf_usage->Export == "" && $lsf_usage->SelectLimit);
	if (!$bSelectLimit)
		$rs = $lsf_usage_list->LoadRecordset();
	$lsf_usage_list->lTotalRecs = ($bSelectLimit) ? $lsf_usage->SelectRecordCount() : $rs->RecordCount();
	$lsf_usage_list->lStartRec = 1;
	if ($lsf_usage_list->lDisplayRecs <= 0) // Display all records
		$lsf_usage_list->lDisplayRecs = $lsf_usage_list->lTotalRecs;
	if (!($lsf_usage->ExportAll && $lsf_usage->Export <> ""))
		$lsf_usage_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $lsf_usage_list->LoadRecordset($lsf_usage_list->lStartRec-1, $lsf_usage_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Lsf Usage
</span></p>
<?php $lsf_usage_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="flsf_usagelist" id="flsf_usagelist" class="ewForm" action="" method="post">
<?php if ($lsf_usage_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$lsf_usage_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$lsf_usage_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$lsf_usage_list->lOptionCnt++; // edit
}
	$lsf_usage_list->lOptionCnt += count($lsf_usage_list->ListOptions->Items); // Custom list options
?>
<?php echo $lsf_usage->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($lsf_usage->date->Visible) { // date ?>
	<?php if ($lsf_usage->SortUrl($lsf_usage->date) == "") { ?>
		<td>Date</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_usage->SortUrl($lsf_usage->date) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Date</td><td style="width: 10px;"><?php if ($lsf_usage->date->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_usage->date->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_usage->uid->Visible) { // uid ?>
	<?php if ($lsf_usage->SortUrl($lsf_usage->uid) == "") { ?>
		<td>Uid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_usage->SortUrl($lsf_usage->uid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Uid</td><td style="width: 10px;"><?php if ($lsf_usage->uid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_usage->uid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_usage->qid->Visible) { // qid ?>
	<?php if ($lsf_usage->SortUrl($lsf_usage->qid) == "") { ?>
		<td>Qid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_usage->SortUrl($lsf_usage->qid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Qid</td><td style="width: 10px;"><?php if ($lsf_usage->qid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_usage->qid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_usage->cpu->Visible) { // cpu ?>
	<?php if ($lsf_usage->SortUrl($lsf_usage->cpu) == "") { ?>
		<td>Cpu</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_usage->SortUrl($lsf_usage->cpu) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cpu</td><td style="width: 10px;"><?php if ($lsf_usage->cpu->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_usage->cpu->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_usage->job->Visible) { // job ?>
	<?php if ($lsf_usage->SortUrl($lsf_usage->job) == "") { ?>
		<td>Job</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_usage->SortUrl($lsf_usage->job) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Job</td><td style="width: 10px;"><?php if ($lsf_usage->job->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_usage->job->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_usage->pid->Visible) { // pid ?>
	<?php if ($lsf_usage->SortUrl($lsf_usage->pid) == "") { ?>
		<td>Pid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_usage->SortUrl($lsf_usage->pid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Pid</td><td style="width: 10px;"><?php if ($lsf_usage->pid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_usage->pid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_usage->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($lsf_usage_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($lsf_usage->ExportAll && $lsf_usage->Export <> "") {
	$lsf_usage_list->lStopRec = $lsf_usage_list->lTotalRecs;
} else {
	$lsf_usage_list->lStopRec = $lsf_usage_list->lStartRec + $lsf_usage_list->lDisplayRecs - 1; // Set the last record to display
}
$lsf_usage_list->lRecCount = $lsf_usage_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$lsf_usage->SelectLimit && $lsf_usage_list->lStartRec > 1)
		$rs->Move($lsf_usage_list->lStartRec - 1);
}
$lsf_usage_list->lRowCnt = 0;
while (($lsf_usage->CurrentAction == "gridadd" || !$rs->EOF) &&
	$lsf_usage_list->lRecCount < $lsf_usage_list->lStopRec) {
	$lsf_usage_list->lRecCount++;
	if (intval($lsf_usage_list->lRecCount) >= intval($lsf_usage_list->lStartRec)) {
		$lsf_usage_list->lRowCnt++;

	// Init row class and style
	$lsf_usage->CssClass = "";
	$lsf_usage->CssStyle = "";
	$lsf_usage->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($lsf_usage->CurrentAction == "gridadd") {
		$lsf_usage_list->LoadDefaultValues(); // Load default values
	} else {
		$lsf_usage_list->LoadRowValues($rs); // Load row values
	}
	$lsf_usage->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$lsf_usage_list->RenderRow();
?>
	<tr<?php echo $lsf_usage->RowAttributes() ?>>
	<?php if ($lsf_usage->date->Visible) { // date ?>
		<td<?php echo $lsf_usage->date->CellAttributes() ?>>
<div<?php echo $lsf_usage->date->ViewAttributes() ?>><?php echo $lsf_usage->date->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_usage->uid->Visible) { // uid ?>
		<td<?php echo $lsf_usage->uid->CellAttributes() ?>>
<div<?php echo $lsf_usage->uid->ViewAttributes() ?>><?php echo $lsf_usage->uid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_usage->qid->Visible) { // qid ?>
		<td<?php echo $lsf_usage->qid->CellAttributes() ?>>
<div<?php echo $lsf_usage->qid->ViewAttributes() ?>><?php echo $lsf_usage->qid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_usage->cpu->Visible) { // cpu ?>
		<td<?php echo $lsf_usage->cpu->CellAttributes() ?>>
<div<?php echo $lsf_usage->cpu->ViewAttributes() ?>><?php echo $lsf_usage->cpu->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_usage->job->Visible) { // job ?>
		<td<?php echo $lsf_usage->job->CellAttributes() ?>>
<div<?php echo $lsf_usage->job->ViewAttributes() ?>><?php echo $lsf_usage->job->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_usage->pid->Visible) { // pid ?>
		<td<?php echo $lsf_usage->pid->CellAttributes() ?>>
<div<?php echo $lsf_usage->pid->ViewAttributes() ?>><?php echo $lsf_usage->pid->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($lsf_usage->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $lsf_usage->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $lsf_usage->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($lsf_usage_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($lsf_usage->CurrentAction <> "gridadd")
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
<?php if ($lsf_usage->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($lsf_usage->CurrentAction <> "gridadd" && $lsf_usage->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($lsf_usage_list->Pager)) $lsf_usage_list->Pager = new cPrevNextPager($lsf_usage_list->lStartRec, $lsf_usage_list->lDisplayRecs, $lsf_usage_list->lTotalRecs) ?>
<?php if ($lsf_usage_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($lsf_usage_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_usage_list->PageUrl() ?>start=<?php echo $lsf_usage_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($lsf_usage_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_usage_list->PageUrl() ?>start=<?php echo $lsf_usage_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $lsf_usage_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($lsf_usage_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_usage_list->PageUrl() ?>start=<?php echo $lsf_usage_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($lsf_usage_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_usage_list->PageUrl() ?>start=<?php echo $lsf_usage_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $lsf_usage_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $lsf_usage_list->Pager->FromIndex ?> to <?php echo $lsf_usage_list->Pager->ToIndex ?> of <?php echo $lsf_usage_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($lsf_usage_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($lsf_usage_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($lsf_usage->Export == "" && $lsf_usage->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(lsf_usage_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($lsf_usage->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lsf_usage_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_usage_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'lsf_usage';

	// Page Object Name
	var $PageObjName = 'lsf_usage_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_usage;
		if ($lsf_usage->UseTokenInUrl) $PageUrl .= "t=" . $lsf_usage->TableVar . "&"; // add page token
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
		global $objForm, $lsf_usage;
		if ($lsf_usage->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_usage->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_usage->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_usage_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_usage"] = new clsf_usage();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_usage', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_usage;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$lsf_usage->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $lsf_usage->Export; // Get export parameter, used in header
	$gsExportFile = $lsf_usage->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $lsf_usage;
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
		if ($lsf_usage->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $lsf_usage->getRecordsPerPage(); // Restore from Session
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
		$lsf_usage->setSessionWhere($sFilter);
		$lsf_usage->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $lsf_usage;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$lsf_usage->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$lsf_usage->CurrentOrderType = @$_GET["ordertype"];
			$lsf_usage->UpdateSort($lsf_usage->date); // Field 
			$lsf_usage->UpdateSort($lsf_usage->uid); // Field 
			$lsf_usage->UpdateSort($lsf_usage->qid); // Field 
			$lsf_usage->UpdateSort($lsf_usage->cpu); // Field 
			$lsf_usage->UpdateSort($lsf_usage->job); // Field 
			$lsf_usage->UpdateSort($lsf_usage->pid); // Field 
			$lsf_usage->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $lsf_usage;
		$sOrderBy = $lsf_usage->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($lsf_usage->SqlOrderBy() <> "") {
				$sOrderBy = $lsf_usage->SqlOrderBy();
				$lsf_usage->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $lsf_usage;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$lsf_usage->setSessionOrderBy($sOrderBy);
				$lsf_usage->date->setSort("");
				$lsf_usage->uid->setSort("");
				$lsf_usage->qid->setSort("");
				$lsf_usage->cpu->setSort("");
				$lsf_usage->job->setSort("");
				$lsf_usage->pid->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$lsf_usage->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $lsf_usage;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lsf_usage->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lsf_usage->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lsf_usage->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lsf_usage->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lsf_usage->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lsf_usage->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $lsf_usage;

		// Call Recordset Selecting event
		$lsf_usage->Recordset_Selecting($lsf_usage->CurrentFilter);

		// Load list page SQL
		$sSql = $lsf_usage->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$lsf_usage->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_usage;
		$sFilter = $lsf_usage->KeyFilter();

		// Call Row Selecting event
		$lsf_usage->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_usage->CurrentFilter = $sFilter;
		$sSql = $lsf_usage->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_usage->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_usage;
		$lsf_usage->date->setDbValue($rs->fields('date'));
		$lsf_usage->uid->setDbValue($rs->fields('uid'));
		$lsf_usage->qid->setDbValue($rs->fields('qid'));
		$lsf_usage->cpu->setDbValue($rs->fields('cpu'));
		$lsf_usage->job->setDbValue($rs->fields('job'));
		$lsf_usage->pid->setDbValue($rs->fields('pid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_usage;

		// Call Row_Rendering event
		$lsf_usage->Row_Rendering();

		// Common render codes for all row types
		// date

		$lsf_usage->date->CellCssStyle = "";
		$lsf_usage->date->CellCssClass = "";

		// uid
		$lsf_usage->uid->CellCssStyle = "";
		$lsf_usage->uid->CellCssClass = "";

		// qid
		$lsf_usage->qid->CellCssStyle = "";
		$lsf_usage->qid->CellCssClass = "";

		// cpu
		$lsf_usage->cpu->CellCssStyle = "";
		$lsf_usage->cpu->CellCssClass = "";

		// job
		$lsf_usage->job->CellCssStyle = "";
		$lsf_usage->job->CellCssClass = "";

		// pid
		$lsf_usage->pid->CellCssStyle = "";
		$lsf_usage->pid->CellCssClass = "";
		if ($lsf_usage->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$lsf_usage->date->ViewValue = $lsf_usage->date->CurrentValue;
			$lsf_usage->date->CssStyle = "";
			$lsf_usage->date->CssClass = "";
			$lsf_usage->date->ViewCustomAttributes = "";

			// uid
			$lsf_usage->uid->ViewValue = $lsf_usage->uid->CurrentValue;
			$lsf_usage->uid->CssStyle = "";
			$lsf_usage->uid->CssClass = "";
			$lsf_usage->uid->ViewCustomAttributes = "";

			// qid
			$lsf_usage->qid->ViewValue = $lsf_usage->qid->CurrentValue;
			$lsf_usage->qid->CssStyle = "";
			$lsf_usage->qid->CssClass = "";
			$lsf_usage->qid->ViewCustomAttributes = "";

			// cpu
			$lsf_usage->cpu->ViewValue = $lsf_usage->cpu->CurrentValue;
			$lsf_usage->cpu->CssStyle = "";
			$lsf_usage->cpu->CssClass = "";
			$lsf_usage->cpu->ViewCustomAttributes = "";

			// job
			$lsf_usage->job->ViewValue = $lsf_usage->job->CurrentValue;
			$lsf_usage->job->CssStyle = "";
			$lsf_usage->job->CssClass = "";
			$lsf_usage->job->ViewCustomAttributes = "";

			// pid
			$lsf_usage->pid->ViewValue = $lsf_usage->pid->CurrentValue;
			$lsf_usage->pid->CssStyle = "";
			$lsf_usage->pid->CssClass = "";
			$lsf_usage->pid->ViewCustomAttributes = "";

			// date
			$lsf_usage->date->HrefValue = "";

			// uid
			$lsf_usage->uid->HrefValue = "";

			// qid
			$lsf_usage->qid->HrefValue = "";

			// cpu
			$lsf_usage->cpu->HrefValue = "";

			// job
			$lsf_usage->job->HrefValue = "";

			// pid
			$lsf_usage->pid->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_usage->Row_Rendered();
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
