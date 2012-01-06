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
$subdir_list = new csubdir_list();
$Page =& $subdir_list;

// Page init processing
$subdir_list->Page_Init();

// Page main processing
$subdir_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($subdir->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var subdir_list = new ew_Page("subdir_list");

// page properties
subdir_list.PageID = "list"; // page ID
var EW_PAGE_ID = subdir_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
subdir_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
subdir_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
subdir_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($subdir->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($subdir->Export == "" && $subdir->SelectLimit);
	if (!$bSelectLimit)
		$rs = $subdir_list->LoadRecordset();
	$subdir_list->lTotalRecs = ($bSelectLimit) ? $subdir->SelectRecordCount() : $rs->RecordCount();
	$subdir_list->lStartRec = 1;
	if ($subdir_list->lDisplayRecs <= 0) // Display all records
		$subdir_list->lDisplayRecs = $subdir_list->lTotalRecs;
	if (!($subdir->ExportAll && $subdir->Export <> ""))
		$subdir_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $subdir_list->LoadRecordset($subdir_list->lStartRec-1, $subdir_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Subdir
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($subdir->Export == "" && $subdir->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(subdir_list);" style="text-decoration: none;"><img id="subdir_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="subdir_list_SearchPanel">
<form name="fsubdirlistsrch" id="fsubdirlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="subdir">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($subdir->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $subdir_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($subdir->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($subdir->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($subdir->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $subdir_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fsubdirlist" id="fsubdirlist" class="ewForm" action="" method="post">
<?php if ($subdir_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$subdir_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$subdir_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$subdir_list->lOptionCnt++; // edit
}
	$subdir_list->lOptionCnt += count($subdir_list->ListOptions->Items); // Custom list options
?>
<?php echo $subdir->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($subdir->fsid->Visible) { // fsid ?>
	<?php if ($subdir->SortUrl($subdir->fsid) == "") { ?>
		<td>Fsid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $subdir->SortUrl($subdir->fsid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fsid</td><td style="width: 10px;"><?php if ($subdir->fsid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($subdir->fsid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($subdir->dirid->Visible) { // dirid ?>
	<?php if ($subdir->SortUrl($subdir->dirid) == "") { ?>
		<td>Dirid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $subdir->SortUrl($subdir->dirid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Dirid</td><td style="width: 10px;"><?php if ($subdir->dirid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($subdir->dirid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($subdir->parent->Visible) { // parent ?>
	<?php if ($subdir->SortUrl($subdir->parent) == "") { ?>
		<td>Parent</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $subdir->SortUrl($subdir->parent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Parent</td><td style="width: 10px;"><?php if ($subdir->parent->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($subdir->parent->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($subdir->name->Visible) { // name ?>
	<?php if ($subdir->SortUrl($subdir->name) == "") { ?>
		<td>Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $subdir->SortUrl($subdir->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Name&nbsp;(*)</td><td style="width: 10px;"><?php if ($subdir->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($subdir->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($subdir->deprecated->Visible) { // deprecated ?>
	<?php if ($subdir->SortUrl($subdir->deprecated) == "") { ?>
		<td>Deprecated</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $subdir->SortUrl($subdir->deprecated) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Deprecated</td><td style="width: 10px;"><?php if ($subdir->deprecated->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($subdir->deprecated->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($subdir->level->Visible) { // level ?>
	<?php if ($subdir->SortUrl($subdir->level) == "") { ?>
		<td>Level</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $subdir->SortUrl($subdir->level) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Level</td><td style="width: 10px;"><?php if ($subdir->level->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($subdir->level->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($subdir->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($subdir_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($subdir->ExportAll && $subdir->Export <> "") {
	$subdir_list->lStopRec = $subdir_list->lTotalRecs;
} else {
	$subdir_list->lStopRec = $subdir_list->lStartRec + $subdir_list->lDisplayRecs - 1; // Set the last record to display
}
$subdir_list->lRecCount = $subdir_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$subdir->SelectLimit && $subdir_list->lStartRec > 1)
		$rs->Move($subdir_list->lStartRec - 1);
}
$subdir_list->lRowCnt = 0;
while (($subdir->CurrentAction == "gridadd" || !$rs->EOF) &&
	$subdir_list->lRecCount < $subdir_list->lStopRec) {
	$subdir_list->lRecCount++;
	if (intval($subdir_list->lRecCount) >= intval($subdir_list->lStartRec)) {
		$subdir_list->lRowCnt++;

	// Init row class and style
	$subdir->CssClass = "";
	$subdir->CssStyle = "";
	$subdir->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($subdir->CurrentAction == "gridadd") {
		$subdir_list->LoadDefaultValues(); // Load default values
	} else {
		$subdir_list->LoadRowValues($rs); // Load row values
	}
	$subdir->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$subdir_list->RenderRow();
?>
	<tr<?php echo $subdir->RowAttributes() ?>>
	<?php if ($subdir->fsid->Visible) { // fsid ?>
		<td<?php echo $subdir->fsid->CellAttributes() ?>>
<div<?php echo $subdir->fsid->ViewAttributes() ?>><?php echo $subdir->fsid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($subdir->dirid->Visible) { // dirid ?>
		<td<?php echo $subdir->dirid->CellAttributes() ?>>
<div<?php echo $subdir->dirid->ViewAttributes() ?>><?php echo $subdir->dirid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($subdir->parent->Visible) { // parent ?>
		<td<?php echo $subdir->parent->CellAttributes() ?>>
<div<?php echo $subdir->parent->ViewAttributes() ?>><?php echo $subdir->parent->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($subdir->name->Visible) { // name ?>
		<td<?php echo $subdir->name->CellAttributes() ?>>
<div<?php echo $subdir->name->ViewAttributes() ?>><?php echo $subdir->name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($subdir->deprecated->Visible) { // deprecated ?>
		<td<?php echo $subdir->deprecated->CellAttributes() ?>>
<div<?php echo $subdir->deprecated->ViewAttributes() ?>><?php echo $subdir->deprecated->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($subdir->level->Visible) { // level ?>
		<td<?php echo $subdir->level->CellAttributes() ?>>
<div<?php echo $subdir->level->ViewAttributes() ?>><?php echo $subdir->level->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($subdir->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $subdir->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $subdir->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($subdir_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($subdir->CurrentAction <> "gridadd")
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
<?php if ($subdir->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($subdir->CurrentAction <> "gridadd" && $subdir->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($subdir_list->Pager)) $subdir_list->Pager = new cPrevNextPager($subdir_list->lStartRec, $subdir_list->lDisplayRecs, $subdir_list->lTotalRecs) ?>
<?php if ($subdir_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($subdir_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $subdir_list->PageUrl() ?>start=<?php echo $subdir_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($subdir_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $subdir_list->PageUrl() ?>start=<?php echo $subdir_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $subdir_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($subdir_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $subdir_list->PageUrl() ?>start=<?php echo $subdir_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($subdir_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $subdir_list->PageUrl() ?>start=<?php echo $subdir_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $subdir_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $subdir_list->Pager->FromIndex ?> to <?php echo $subdir_list->Pager->ToIndex ?> of <?php echo $subdir_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($subdir_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($subdir_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($subdir->Export == "" && $subdir->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(subdir_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
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
$subdir_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class csubdir_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'subdir';

	// Page Object Name
	var $PageObjName = 'subdir_list';

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
	function csubdir_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["subdir"] = new csubdir();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'subdir', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
	$subdir->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $subdir->Export; // Get export parameter, used in header
	$gsExportFile = $subdir->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $subdir;
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
		if ($subdir->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $subdir->getRecordsPerPage(); // Restore from Session
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
		$subdir->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$subdir->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$subdir->setStartRecordNumber($this->lStartRec);
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
		$subdir->setSessionWhere($sFilter);
		$subdir->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $subdir;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $subdir->name->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $subdir;
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
			$subdir->setBasicSearchKeyword($sSearchKeyword);
			$subdir->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $subdir;
		$this->sSrchWhere = "";
		$subdir->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $subdir;
		$subdir->setBasicSearchKeyword("");
		$subdir->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $subdir;
		$this->sSrchWhere = $subdir->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $subdir;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$subdir->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$subdir->CurrentOrderType = @$_GET["ordertype"];
			$subdir->UpdateSort($subdir->fsid); // Field 
			$subdir->UpdateSort($subdir->dirid); // Field 
			$subdir->UpdateSort($subdir->parent); // Field 
			$subdir->UpdateSort($subdir->name); // Field 
			$subdir->UpdateSort($subdir->deprecated); // Field 
			$subdir->UpdateSort($subdir->level); // Field 
			$subdir->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $subdir;
		$sOrderBy = $subdir->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($subdir->SqlOrderBy() <> "") {
				$sOrderBy = $subdir->SqlOrderBy();
				$subdir->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $subdir;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$subdir->setSessionOrderBy($sOrderBy);
				$subdir->fsid->setSort("");
				$subdir->dirid->setSort("");
				$subdir->parent->setSort("");
				$subdir->name->setSort("");
				$subdir->deprecated->setSort("");
				$subdir->level->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$subdir->setStartRecordNumber($this->lStartRec);
		}
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $subdir;

		// Call Recordset Selecting event
		$subdir->Recordset_Selecting($subdir->CurrentFilter);

		// Load list page SQL
		$sSql = $subdir->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$subdir->Recordset_Selected($rs);
		return $rs;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
