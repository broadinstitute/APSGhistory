<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "ge_queuesinfo.php" ?>
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
$ge_queues_list = new cge_queues_list();
$Page =& $ge_queues_list;

// Page init processing
$ge_queues_list->Page_Init();

// Page main processing
$ge_queues_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($ge_queues->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ge_queues_list = new ew_Page("ge_queues_list");

// page properties
ge_queues_list.PageID = "list"; // page ID
var EW_PAGE_ID = ge_queues_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ge_queues_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_queues_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_queues_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($ge_queues->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($ge_queues->Export == "" && $ge_queues->SelectLimit);
	if (!$bSelectLimit)
		$rs = $ge_queues_list->LoadRecordset();
	$ge_queues_list->lTotalRecs = ($bSelectLimit) ? $ge_queues->SelectRecordCount() : $rs->RecordCount();
	$ge_queues_list->lStartRec = 1;
	if ($ge_queues_list->lDisplayRecs <= 0) // Display all records
		$ge_queues_list->lDisplayRecs = $ge_queues_list->lTotalRecs;
	if (!($ge_queues->ExportAll && $ge_queues->Export <> ""))
		$ge_queues_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $ge_queues_list->LoadRecordset($ge_queues_list->lStartRec-1, $ge_queues_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Ge Queues
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($ge_queues->Export == "" && $ge_queues->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(ge_queues_list);" style="text-decoration: none;"><img id="ge_queues_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="ge_queues_list_SearchPanel">
<form name="fge_queueslistsrch" id="fge_queueslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="ge_queues">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($ge_queues->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $ge_queues_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($ge_queues->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($ge_queues->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($ge_queues->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $ge_queues_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fge_queueslist" id="fge_queueslist" class="ewForm" action="" method="post">
<?php if ($ge_queues_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$ge_queues_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$ge_queues_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$ge_queues_list->lOptionCnt++; // edit
}
if ($Security->IsLoggedIn()) {
	$ge_queues_list->lOptionCnt++; // copy
}
if ($Security->IsLoggedIn()) {
	$ge_queues_list->lOptionCnt++; // Delete
}
	$ge_queues_list->lOptionCnt += count($ge_queues_list->ListOptions->Items); // Custom list options
?>
<?php echo $ge_queues->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($ge_queues->id->Visible) { // id ?>
	<?php if ($ge_queues->SortUrl($ge_queues->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_queues->SortUrl($ge_queues->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($ge_queues->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_queues->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_queues->name->Visible) { // name ?>
	<?php if ($ge_queues->SortUrl($ge_queues->name) == "") { ?>
		<td>Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_queues->SortUrl($ge_queues->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Name&nbsp;(*)</td><td style="width: 10px;"><?php if ($ge_queues->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_queues->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_queues->gid->Visible) { // gid ?>
	<?php if ($ge_queues->SortUrl($ge_queues->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ge_queues->SortUrl($ge_queues->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($ge_queues->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ge_queues->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($ge_queues->Export == "") { ?>
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
foreach ($ge_queues_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($ge_queues->ExportAll && $ge_queues->Export <> "") {
	$ge_queues_list->lStopRec = $ge_queues_list->lTotalRecs;
} else {
	$ge_queues_list->lStopRec = $ge_queues_list->lStartRec + $ge_queues_list->lDisplayRecs - 1; // Set the last record to display
}
$ge_queues_list->lRecCount = $ge_queues_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$ge_queues->SelectLimit && $ge_queues_list->lStartRec > 1)
		$rs->Move($ge_queues_list->lStartRec - 1);
}
$ge_queues_list->lRowCnt = 0;
while (($ge_queues->CurrentAction == "gridadd" || !$rs->EOF) &&
	$ge_queues_list->lRecCount < $ge_queues_list->lStopRec) {
	$ge_queues_list->lRecCount++;
	if (intval($ge_queues_list->lRecCount) >= intval($ge_queues_list->lStartRec)) {
		$ge_queues_list->lRowCnt++;

	// Init row class and style
	$ge_queues->CssClass = "";
	$ge_queues->CssStyle = "";
	$ge_queues->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($ge_queues->CurrentAction == "gridadd") {
		$ge_queues_list->LoadDefaultValues(); // Load default values
	} else {
		$ge_queues_list->LoadRowValues($rs); // Load row values
	}
	$ge_queues->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$ge_queues_list->RenderRow();
?>
	<tr<?php echo $ge_queues->RowAttributes() ?>>
	<?php if ($ge_queues->id->Visible) { // id ?>
		<td<?php echo $ge_queues->id->CellAttributes() ?>>
<div<?php echo $ge_queues->id->ViewAttributes() ?>><?php echo $ge_queues->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($ge_queues->name->Visible) { // name ?>
		<td<?php echo $ge_queues->name->CellAttributes() ?>>
<div<?php echo $ge_queues->name->ViewAttributes() ?>><?php echo $ge_queues->name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($ge_queues->gid->Visible) { // gid ?>
		<td<?php echo $ge_queues->gid->CellAttributes() ?>>
<div<?php echo $ge_queues->gid->ViewAttributes() ?>><?php echo $ge_queues->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($ge_queues->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $ge_queues->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $ge_queues->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $ge_queues->CopyUrl() ?>">Copy</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $ge_queues->DeleteUrl() ?>">Delete</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($ge_queues_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($ge_queues->CurrentAction <> "gridadd")
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
<?php if ($ge_queues->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($ge_queues->CurrentAction <> "gridadd" && $ge_queues->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($ge_queues_list->Pager)) $ge_queues_list->Pager = new cPrevNextPager($ge_queues_list->lStartRec, $ge_queues_list->lDisplayRecs, $ge_queues_list->lTotalRecs) ?>
<?php if ($ge_queues_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($ge_queues_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $ge_queues_list->PageUrl() ?>start=<?php echo $ge_queues_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($ge_queues_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $ge_queues_list->PageUrl() ?>start=<?php echo $ge_queues_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ge_queues_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($ge_queues_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $ge_queues_list->PageUrl() ?>start=<?php echo $ge_queues_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($ge_queues_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $ge_queues_list->PageUrl() ?>start=<?php echo $ge_queues_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $ge_queues_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $ge_queues_list->Pager->FromIndex ?> to <?php echo $ge_queues_list->Pager->ToIndex ?> of <?php echo $ge_queues_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($ge_queues_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($ge_queues_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ge_queues->AddUrl() ?>">Add</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($ge_queues->Export == "" && $ge_queues->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(ge_queues_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($ge_queues->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$ge_queues_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_queues_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'ge_queues';

	// Page Object Name
	var $PageObjName = 'ge_queues_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ge_queues;
		if ($ge_queues->UseTokenInUrl) $PageUrl .= "t=" . $ge_queues->TableVar . "&"; // add page token
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
		global $objForm, $ge_queues;
		if ($ge_queues->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($ge_queues->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ge_queues->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cge_queues_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_queues"] = new cge_queues();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ge_queues', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ge_queues;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$ge_queues->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $ge_queues->Export; // Get export parameter, used in header
	$gsExportFile = $ge_queues->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $ge_queues;
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

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($ge_queues->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $ge_queues->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		if ($sSrchAdvanced <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "($this->sSrchWhere) AND ($sSrchAdvanced)" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "($this->sSrchWhere) AND ($sSrchBasic)" : $sSrchBasic;

		// Call Recordset_Searching event
		$ge_queues->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$ge_queues->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$ge_queues->setStartRecordNumber($this->lStartRec);
		} else {
			$this->RestoreSearchParms();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$ge_queues->setSessionWhere($sFilter);
		$ge_queues->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $ge_queues;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $ge_queues->name->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $ge_queues;
		$sSearchStr = "";
		$sSearchKeyword = ew_StripSlashes(@$_GET[EW_TABLE_BASIC_SEARCH]);
		$sSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$ge_queues->setBasicSearchKeyword($sSearchKeyword);
			$ge_queues->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $ge_queues;
		$this->sSrchWhere = "";
		$ge_queues->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $ge_queues;
		$ge_queues->setBasicSearchKeyword("");
		$ge_queues->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $ge_queues;
		$this->sSrchWhere = $ge_queues->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $ge_queues;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$ge_queues->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$ge_queues->CurrentOrderType = @$_GET["ordertype"];
			$ge_queues->UpdateSort($ge_queues->id); // Field 
			$ge_queues->UpdateSort($ge_queues->name); // Field 
			$ge_queues->UpdateSort($ge_queues->gid); // Field 
			$ge_queues->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $ge_queues;
		$sOrderBy = $ge_queues->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($ge_queues->SqlOrderBy() <> "") {
				$sOrderBy = $ge_queues->SqlOrderBy();
				$ge_queues->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $ge_queues;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$ge_queues->setSessionOrderBy($sOrderBy);
				$ge_queues->id->setSort("");
				$ge_queues->name->setSort("");
				$ge_queues->gid->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$ge_queues->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $ge_queues;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$ge_queues->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$ge_queues->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $ge_queues->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$ge_queues->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$ge_queues->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$ge_queues->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $ge_queues;

		// Call Recordset Selecting event
		$ge_queues->Recordset_Selecting($ge_queues->CurrentFilter);

		// Load list page SQL
		$sSql = $ge_queues->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$ge_queues->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ge_queues;
		$sFilter = $ge_queues->KeyFilter();

		// Call Row Selecting event
		$ge_queues->Row_Selecting($sFilter);

		// Load sql based on filter
		$ge_queues->CurrentFilter = $sFilter;
		$sSql = $ge_queues->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$ge_queues->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $ge_queues;
		$ge_queues->id->setDbValue($rs->fields('id'));
		$ge_queues->name->setDbValue($rs->fields('name'));
		$ge_queues->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $ge_queues;

		// Call Row_Rendering event
		$ge_queues->Row_Rendering();

		// Common render codes for all row types
		// id

		$ge_queues->id->CellCssStyle = "";
		$ge_queues->id->CellCssClass = "";

		// name
		$ge_queues->name->CellCssStyle = "";
		$ge_queues->name->CellCssClass = "";

		// gid
		$ge_queues->gid->CellCssStyle = "";
		$ge_queues->gid->CellCssClass = "";
		if ($ge_queues->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$ge_queues->id->ViewValue = $ge_queues->id->CurrentValue;
			$ge_queues->id->CssStyle = "";
			$ge_queues->id->CssClass = "";
			$ge_queues->id->ViewCustomAttributes = "";

			// name
			$ge_queues->name->ViewValue = $ge_queues->name->CurrentValue;
			$ge_queues->name->CssStyle = "";
			$ge_queues->name->CssClass = "";
			$ge_queues->name->ViewCustomAttributes = "";

			// gid
			$ge_queues->gid->ViewValue = $ge_queues->gid->CurrentValue;
			$ge_queues->gid->CssStyle = "";
			$ge_queues->gid->CssClass = "";
			$ge_queues->gid->ViewCustomAttributes = "";

			// id
			$ge_queues->id->HrefValue = "";

			// name
			$ge_queues->name->HrefValue = "";

			// gid
			$ge_queues->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$ge_queues->Row_Rendered();
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
