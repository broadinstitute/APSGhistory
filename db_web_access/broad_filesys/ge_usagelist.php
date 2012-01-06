<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "ge_usageinfo.php" ?>
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
$ge_usage_list = new cge_usage_list();
$Page =& $ge_usage_list;

// Page init processing
$ge_usage_list->Page_Init();

// Page main processing
$ge_usage_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($ge_usage->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ge_usage_list = new ew_Page("ge_usage_list");

// page properties
ge_usage_list.PageID = "list"; // page ID
var EW_PAGE_ID = ge_usage_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ge_usage_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_usage_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_usage_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($ge_usage->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($ge_usage->Export == "" && $ge_usage->SelectLimit);
	if (!$bSelectLimit)
		$rs = $ge_usage_list->LoadRecordset();
	$ge_usage_list->lTotalRecs = ($bSelectLimit) ? $ge_usage->SelectRecordCount() : $rs->RecordCount();
	$ge_usage_list->lStartRec = 1;
	if ($ge_usage_list->lDisplayRecs <= 0) // Display all records
		$ge_usage_list->lDisplayRecs = $ge_usage_list->lTotalRecs;
	if (!($ge_usage->ExportAll && $ge_usage->Export <> ""))
		$ge_usage_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $ge_usage_list->LoadRecordset($ge_usage_list->lStartRec-1, $ge_usage_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Ge Usage
</span></p>
<?php $ge_usage_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fge_usagelist" id="fge_usagelist" class="ewForm" action="" method="post">
<?php if ($ge_usage_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$ge_usage_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$ge_usage_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$ge_usage_list->lOptionCnt++; // edit
}
if ($Security->IsLoggedIn()) {
	$ge_usage_list->lOptionCnt++; // copy
}
if ($Security->IsLoggedIn()) {
	$ge_usage_list->lOptionCnt++; // Delete
}
	$ge_usage_list->lOptionCnt += count($ge_usage_list->ListOptions->Items); // Custom list options
?>
<?php echo $ge_usage->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($ge_usage->date->Visible) { // date ?>
	<?php if ($ge_usage->SortUrl($ge_usage->date) == "") { ?>
		<td>Date</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_usage->SortUrl($ge_usage->date) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Date</td><td style="width: 10px;"><?php if ($ge_usage->date->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_usage->date->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_usage->uid->Visible) { // uid ?>
	<?php if ($ge_usage->SortUrl($ge_usage->uid) == "") { ?>
		<td>Uid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_usage->SortUrl($ge_usage->uid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Uid</td><td style="width: 10px;"><?php if ($ge_usage->uid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_usage->uid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_usage->qid->Visible) { // qid ?>
	<?php if ($ge_usage->SortUrl($ge_usage->qid) == "") { ?>
		<td>Qid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_usage->SortUrl($ge_usage->qid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Qid</td><td style="width: 10px;"><?php if ($ge_usage->qid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_usage->qid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_usage->pid->Visible) { // pid ?>
	<?php if ($ge_usage->SortUrl($ge_usage->pid) == "") { ?>
		<td>Pid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_usage->SortUrl($ge_usage->pid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Pid</td><td style="width: 10px;"><?php if ($ge_usage->pid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_usage->pid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_usage->cpu->Visible) { // cpu ?>
	<?php if ($ge_usage->SortUrl($ge_usage->cpu) == "") { ?>
		<td>Cpu</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_usage->SortUrl($ge_usage->cpu) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cpu</td><td style="width: 10px;"><?php if ($ge_usage->cpu->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_usage->cpu->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_usage->job->Visible) { // job ?>
	<?php if ($ge_usage->SortUrl($ge_usage->job) == "") { ?>
		<td>Job</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_usage->SortUrl($ge_usage->job) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Job</td><td style="width: 10px;"><?php if ($ge_usage->job->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_usage->job->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_usage->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($ge_usage_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($ge_usage->ExportAll && $ge_usage->Export <> "") {
	$ge_usage_list->lStopRec = $ge_usage_list->lTotalRecs;
} else {
	$ge_usage_list->lStopRec = $ge_usage_list->lStartRec + $ge_usage_list->lDisplayRecs - 1; // Set the last record to display
}
$ge_usage_list->lRecCount = $ge_usage_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$ge_usage->SelectLimit && $ge_usage_list->lStartRec > 1)
		$rs->Move($ge_usage_list->lStartRec - 1);
}
$ge_usage_list->lRowCnt = 0;
while (($ge_usage->CurrentAction == "gridadd" || !$rs->EOF) &&
	$ge_usage_list->lRecCount < $ge_usage_list->lStopRec) {
	$ge_usage_list->lRecCount++;
	if (intval($ge_usage_list->lRecCount) >= intval($ge_usage_list->lStartRec)) {
		$ge_usage_list->lRowCnt++;

	// Init row class and style
	$ge_usage->CssClass = "";
	$ge_usage->CssStyle = "";
	$ge_usage->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($ge_usage->CurrentAction == "gridadd") {
		$ge_usage_list->LoadDefaultValues(); // Load default values
	} else {
		$ge_usage_list->LoadRowValues($rs); // Load row values
	}
	$ge_usage->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$ge_usage_list->RenderRow();
?>
	<tr<?php echo $ge_usage->RowAttributes() ?>>
	<?php if ($ge_usage->date->Visible) { // date ?>
		<td<?php echo $ge_usage->date->CellAttributes() ?>>
<div<?php echo $ge_usage->date->ViewAttributes() ?>><?php echo $ge_usage->date->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($ge_usage->uid->Visible) { // uid ?>
		<td<?php echo $ge_usage->uid->CellAttributes() ?>>
<div<?php echo $ge_usage->uid->ViewAttributes() ?>><?php echo $ge_usage->uid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($ge_usage->qid->Visible) { // qid ?>
		<td<?php echo $ge_usage->qid->CellAttributes() ?>>
<div<?php echo $ge_usage->qid->ViewAttributes() ?>><?php echo $ge_usage->qid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($ge_usage->pid->Visible) { // pid ?>
		<td<?php echo $ge_usage->pid->CellAttributes() ?>>
<div<?php echo $ge_usage->pid->ViewAttributes() ?>><?php echo $ge_usage->pid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($ge_usage->cpu->Visible) { // cpu ?>
		<td<?php echo $ge_usage->cpu->CellAttributes() ?>>
<div<?php echo $ge_usage->cpu->ViewAttributes() ?>><?php echo $ge_usage->cpu->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($ge_usage->job->Visible) { // job ?>
		<td<?php echo $ge_usage->job->CellAttributes() ?>>
<div<?php echo $ge_usage->job->ViewAttributes() ?>><?php echo $ge_usage->job->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($ge_usage->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $ge_usage->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $ge_usage->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $ge_usage->CopyUrl() ?>">Copy</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $ge_usage->DeleteUrl() ?>">Delete</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($ge_usage_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($ge_usage->CurrentAction <> "gridadd")
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
<?php if ($ge_usage->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($ge_usage->CurrentAction <> "gridadd" && $ge_usage->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($ge_usage_list->Pager)) $ge_usage_list->Pager = new cPrevNextPager($ge_usage_list->lStartRec, $ge_usage_list->lDisplayRecs, $ge_usage_list->lTotalRecs) ?>
<?php if ($ge_usage_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($ge_usage_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $ge_usage_list->PageUrl() ?>start=<?php echo $ge_usage_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($ge_usage_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $ge_usage_list->PageUrl() ?>start=<?php echo $ge_usage_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ge_usage_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($ge_usage_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $ge_usage_list->PageUrl() ?>start=<?php echo $ge_usage_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($ge_usage_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $ge_usage_list->PageUrl() ?>start=<?php echo $ge_usage_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $ge_usage_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $ge_usage_list->Pager->FromIndex ?> to <?php echo $ge_usage_list->Pager->ToIndex ?> of <?php echo $ge_usage_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($ge_usage_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($ge_usage_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_usage->AddUrl() ?>">Add</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($ge_usage->Export == "" && $ge_usage->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(ge_usage_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($ge_usage->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$ge_usage_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_usage_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'ge_usage';

	// Page Object Name
	var $PageObjName = 'ge_usage_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ge_usage;
		if ($ge_usage->UseTokenInUrl) $PageUrl .= "t=" . $ge_usage->TableVar . "&"; // add page token
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
		global $objForm, $ge_usage;
		if ($ge_usage->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($ge_usage->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ge_usage->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cge_usage_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_usage"] = new cge_usage();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ge_usage', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ge_usage;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$ge_usage->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $ge_usage->Export; // Get export parameter, used in header
	$gsExportFile = $ge_usage->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $ge_usage;
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
		if ($ge_usage->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $ge_usage->getRecordsPerPage(); // Restore from Session
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
		$ge_usage->setSessionWhere($sFilter);
		$ge_usage->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $ge_usage;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$ge_usage->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$ge_usage->CurrentOrderType = @$_GET["ordertype"];
			$ge_usage->UpdateSort($ge_usage->date); // Field 
			$ge_usage->UpdateSort($ge_usage->uid); // Field 
			$ge_usage->UpdateSort($ge_usage->qid); // Field 
			$ge_usage->UpdateSort($ge_usage->pid); // Field 
			$ge_usage->UpdateSort($ge_usage->cpu); // Field 
			$ge_usage->UpdateSort($ge_usage->job); // Field 
			$ge_usage->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $ge_usage;
		$sOrderBy = $ge_usage->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($ge_usage->SqlOrderBy() <> "") {
				$sOrderBy = $ge_usage->SqlOrderBy();
				$ge_usage->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $ge_usage;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$ge_usage->setSessionOrderBy($sOrderBy);
				$ge_usage->date->setSort("");
				$ge_usage->uid->setSort("");
				$ge_usage->qid->setSort("");
				$ge_usage->pid->setSort("");
				$ge_usage->cpu->setSort("");
				$ge_usage->job->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$ge_usage->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $ge_usage;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$ge_usage->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$ge_usage->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $ge_usage->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$ge_usage->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$ge_usage->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$ge_usage->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $ge_usage;

		// Call Recordset Selecting event
		$ge_usage->Recordset_Selecting($ge_usage->CurrentFilter);

		// Load list page SQL
		$sSql = $ge_usage->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$ge_usage->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ge_usage;
		$sFilter = $ge_usage->KeyFilter();

		// Call Row Selecting event
		$ge_usage->Row_Selecting($sFilter);

		// Load sql based on filter
		$ge_usage->CurrentFilter = $sFilter;
		$sSql = $ge_usage->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$ge_usage->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $ge_usage;
		$ge_usage->date->setDbValue($rs->fields('date'));
		$ge_usage->uid->setDbValue($rs->fields('uid'));
		$ge_usage->qid->setDbValue($rs->fields('qid'));
		$ge_usage->pid->setDbValue($rs->fields('pid'));
		$ge_usage->cpu->setDbValue($rs->fields('cpu'));
		$ge_usage->job->setDbValue($rs->fields('job'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $ge_usage;

		// Call Row_Rendering event
		$ge_usage->Row_Rendering();

		// Common render codes for all row types
		// date

		$ge_usage->date->CellCssStyle = "";
		$ge_usage->date->CellCssClass = "";

		// uid
		$ge_usage->uid->CellCssStyle = "";
		$ge_usage->uid->CellCssClass = "";

		// qid
		$ge_usage->qid->CellCssStyle = "";
		$ge_usage->qid->CellCssClass = "";

		// pid
		$ge_usage->pid->CellCssStyle = "";
		$ge_usage->pid->CellCssClass = "";

		// cpu
		$ge_usage->cpu->CellCssStyle = "";
		$ge_usage->cpu->CellCssClass = "";

		// job
		$ge_usage->job->CellCssStyle = "";
		$ge_usage->job->CellCssClass = "";
		if ($ge_usage->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$ge_usage->date->ViewValue = $ge_usage->date->CurrentValue;
			$ge_usage->date->CssStyle = "";
			$ge_usage->date->CssClass = "";
			$ge_usage->date->ViewCustomAttributes = "";

			// uid
			$ge_usage->uid->ViewValue = $ge_usage->uid->CurrentValue;
			$ge_usage->uid->CssStyle = "";
			$ge_usage->uid->CssClass = "";
			$ge_usage->uid->ViewCustomAttributes = "";

			// qid
			$ge_usage->qid->ViewValue = $ge_usage->qid->CurrentValue;
			$ge_usage->qid->CssStyle = "";
			$ge_usage->qid->CssClass = "";
			$ge_usage->qid->ViewCustomAttributes = "";

			// pid
			$ge_usage->pid->ViewValue = $ge_usage->pid->CurrentValue;
			$ge_usage->pid->CssStyle = "";
			$ge_usage->pid->CssClass = "";
			$ge_usage->pid->ViewCustomAttributes = "";

			// cpu
			$ge_usage->cpu->ViewValue = $ge_usage->cpu->CurrentValue;
			$ge_usage->cpu->CssStyle = "";
			$ge_usage->cpu->CssClass = "";
			$ge_usage->cpu->ViewCustomAttributes = "";

			// job
			$ge_usage->job->ViewValue = $ge_usage->job->CurrentValue;
			$ge_usage->job->CssStyle = "";
			$ge_usage->job->CssClass = "";
			$ge_usage->job->ViewCustomAttributes = "";

			// date
			$ge_usage->date->HrefValue = "";

			// uid
			$ge_usage->uid->HrefValue = "";

			// qid
			$ge_usage->qid->HrefValue = "";

			// pid
			$ge_usage->pid->HrefValue = "";

			// cpu
			$ge_usage->cpu->HrefValue = "";

			// job
			$ge_usage->job->HrefValue = "";
		}

		// Call Row Rendered event
		$ge_usage->Row_Rendered();
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
