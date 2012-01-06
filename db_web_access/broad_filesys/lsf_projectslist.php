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
$lsf_projects_list = new clsf_projects_list();
$Page =& $lsf_projects_list;

// Page init processing
$lsf_projects_list->Page_Init();

// Page main processing
$lsf_projects_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lsf_projects->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_projects_list = new ew_Page("lsf_projects_list");

// page properties
lsf_projects_list.PageID = "list"; // page ID
var EW_PAGE_ID = lsf_projects_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_projects_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_projects_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_projects_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($lsf_projects->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($lsf_projects->Export == "" && $lsf_projects->SelectLimit);
	if (!$bSelectLimit)
		$rs = $lsf_projects_list->LoadRecordset();
	$lsf_projects_list->lTotalRecs = ($bSelectLimit) ? $lsf_projects->SelectRecordCount() : $rs->RecordCount();
	$lsf_projects_list->lStartRec = 1;
	if ($lsf_projects_list->lDisplayRecs <= 0) // Display all records
		$lsf_projects_list->lDisplayRecs = $lsf_projects_list->lTotalRecs;
	if (!($lsf_projects->ExportAll && $lsf_projects->Export <> ""))
		$lsf_projects_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $lsf_projects_list->LoadRecordset($lsf_projects_list->lStartRec-1, $lsf_projects_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Lsf Projects
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($lsf_projects->Export == "" && $lsf_projects->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(lsf_projects_list);" style="text-decoration: none;"><img id="lsf_projects_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="lsf_projects_list_SearchPanel">
<form name="flsf_projectslistsrch" id="flsf_projectslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="lsf_projects">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($lsf_projects->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $lsf_projects_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($lsf_projects->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($lsf_projects->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($lsf_projects->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $lsf_projects_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="flsf_projectslist" id="flsf_projectslist" class="ewForm" action="" method="post">
<?php if ($lsf_projects_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$lsf_projects_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$lsf_projects_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$lsf_projects_list->lOptionCnt++; // edit
}
if ($Security->IsLoggedIn()) {
	$lsf_projects_list->lOptionCnt++; // copy
}
if ($Security->IsLoggedIn()) {
	$lsf_projects_list->lOptionCnt++; // Delete
}
	$lsf_projects_list->lOptionCnt += count($lsf_projects_list->ListOptions->Items); // Custom list options
?>
<?php echo $lsf_projects->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($lsf_projects->id->Visible) { // id ?>
	<?php if ($lsf_projects->SortUrl($lsf_projects->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_projects->SortUrl($lsf_projects->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($lsf_projects->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_projects->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_projects->name->Visible) { // name ?>
	<?php if ($lsf_projects->SortUrl($lsf_projects->name) == "") { ?>
		<td>Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_projects->SortUrl($lsf_projects->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Name&nbsp;(*)</td><td style="width: 10px;"><?php if ($lsf_projects->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_projects->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_projects->gid->Visible) { // gid ?>
	<?php if ($lsf_projects->SortUrl($lsf_projects->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_projects->SortUrl($lsf_projects->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($lsf_projects->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_projects->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_projects->Export == "") { ?>
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
foreach ($lsf_projects_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($lsf_projects->ExportAll && $lsf_projects->Export <> "") {
	$lsf_projects_list->lStopRec = $lsf_projects_list->lTotalRecs;
} else {
	$lsf_projects_list->lStopRec = $lsf_projects_list->lStartRec + $lsf_projects_list->lDisplayRecs - 1; // Set the last record to display
}
$lsf_projects_list->lRecCount = $lsf_projects_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$lsf_projects->SelectLimit && $lsf_projects_list->lStartRec > 1)
		$rs->Move($lsf_projects_list->lStartRec - 1);
}
$lsf_projects_list->lRowCnt = 0;
while (($lsf_projects->CurrentAction == "gridadd" || !$rs->EOF) &&
	$lsf_projects_list->lRecCount < $lsf_projects_list->lStopRec) {
	$lsf_projects_list->lRecCount++;
	if (intval($lsf_projects_list->lRecCount) >= intval($lsf_projects_list->lStartRec)) {
		$lsf_projects_list->lRowCnt++;

	// Init row class and style
	$lsf_projects->CssClass = "";
	$lsf_projects->CssStyle = "";
	$lsf_projects->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($lsf_projects->CurrentAction == "gridadd") {
		$lsf_projects_list->LoadDefaultValues(); // Load default values
	} else {
		$lsf_projects_list->LoadRowValues($rs); // Load row values
	}
	$lsf_projects->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$lsf_projects_list->RenderRow();
?>
	<tr<?php echo $lsf_projects->RowAttributes() ?>>
	<?php if ($lsf_projects->id->Visible) { // id ?>
		<td<?php echo $lsf_projects->id->CellAttributes() ?>>
<div<?php echo $lsf_projects->id->ViewAttributes() ?>><?php echo $lsf_projects->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_projects->name->Visible) { // name ?>
		<td<?php echo $lsf_projects->name->CellAttributes() ?>>
<div<?php echo $lsf_projects->name->ViewAttributes() ?>><?php echo $lsf_projects->name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_projects->gid->Visible) { // gid ?>
		<td<?php echo $lsf_projects->gid->CellAttributes() ?>>
<div<?php echo $lsf_projects->gid->ViewAttributes() ?>><?php echo $lsf_projects->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($lsf_projects->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $lsf_projects->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $lsf_projects->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $lsf_projects->CopyUrl() ?>">Copy</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $lsf_projects->DeleteUrl() ?>">Delete</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($lsf_projects_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($lsf_projects->CurrentAction <> "gridadd")
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
<?php if ($lsf_projects->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($lsf_projects->CurrentAction <> "gridadd" && $lsf_projects->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($lsf_projects_list->Pager)) $lsf_projects_list->Pager = new cPrevNextPager($lsf_projects_list->lStartRec, $lsf_projects_list->lDisplayRecs, $lsf_projects_list->lTotalRecs) ?>
<?php if ($lsf_projects_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($lsf_projects_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_projects_list->PageUrl() ?>start=<?php echo $lsf_projects_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($lsf_projects_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_projects_list->PageUrl() ?>start=<?php echo $lsf_projects_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $lsf_projects_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($lsf_projects_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_projects_list->PageUrl() ?>start=<?php echo $lsf_projects_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($lsf_projects_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_projects_list->PageUrl() ?>start=<?php echo $lsf_projects_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $lsf_projects_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $lsf_projects_list->Pager->FromIndex ?> to <?php echo $lsf_projects_list->Pager->ToIndex ?> of <?php echo $lsf_projects_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($lsf_projects_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($lsf_projects_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lsf_projects->AddUrl() ?>">Add</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($lsf_projects->Export == "" && $lsf_projects->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(lsf_projects_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
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
$lsf_projects_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_projects_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'lsf_projects';

	// Page Object Name
	var $PageObjName = 'lsf_projects_list';

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
	function clsf_projects_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_projects"] = new clsf_projects();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_projects', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
	$lsf_projects->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $lsf_projects->Export; // Get export parameter, used in header
	$gsExportFile = $lsf_projects->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $lsf_projects;
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
		if ($lsf_projects->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $lsf_projects->getRecordsPerPage(); // Restore from Session
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
		$lsf_projects->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$lsf_projects->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$lsf_projects->setStartRecordNumber($this->lStartRec);
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
		$lsf_projects->setSessionWhere($sFilter);
		$lsf_projects->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $lsf_projects;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $lsf_projects->name->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $lsf_projects;
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
			$lsf_projects->setBasicSearchKeyword($sSearchKeyword);
			$lsf_projects->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $lsf_projects;
		$this->sSrchWhere = "";
		$lsf_projects->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $lsf_projects;
		$lsf_projects->setBasicSearchKeyword("");
		$lsf_projects->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $lsf_projects;
		$this->sSrchWhere = $lsf_projects->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $lsf_projects;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$lsf_projects->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$lsf_projects->CurrentOrderType = @$_GET["ordertype"];
			$lsf_projects->UpdateSort($lsf_projects->id); // Field 
			$lsf_projects->UpdateSort($lsf_projects->name); // Field 
			$lsf_projects->UpdateSort($lsf_projects->gid); // Field 
			$lsf_projects->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $lsf_projects;
		$sOrderBy = $lsf_projects->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($lsf_projects->SqlOrderBy() <> "") {
				$sOrderBy = $lsf_projects->SqlOrderBy();
				$lsf_projects->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $lsf_projects;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$lsf_projects->setSessionOrderBy($sOrderBy);
				$lsf_projects->id->setSort("");
				$lsf_projects->name->setSort("");
				$lsf_projects->gid->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$lsf_projects->setStartRecordNumber($this->lStartRec);
		}
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $lsf_projects;

		// Call Recordset Selecting event
		$lsf_projects->Recordset_Selecting($lsf_projects->CurrentFilter);

		// Load list page SQL
		$sSql = $lsf_projects->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$lsf_projects->Recordset_Selected($rs);
		return $rs;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
