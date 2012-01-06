<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "dbserversinfo.php" ?>
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
$dbservers_list = new cdbservers_list();
$Page =& $dbservers_list;

// Page init processing
$dbservers_list->Page_Init();

// Page main processing
$dbservers_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($dbservers->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var dbservers_list = new ew_Page("dbservers_list");

// page properties
dbservers_list.PageID = "list"; // page ID
var EW_PAGE_ID = dbservers_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
dbservers_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
dbservers_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
dbservers_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($dbservers->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($dbservers->Export == "" && $dbservers->SelectLimit);
	if (!$bSelectLimit)
		$rs = $dbservers_list->LoadRecordset();
	$dbservers_list->lTotalRecs = ($bSelectLimit) ? $dbservers->SelectRecordCount() : $rs->RecordCount();
	$dbservers_list->lStartRec = 1;
	if ($dbservers_list->lDisplayRecs <= 0) // Display all records
		$dbservers_list->lDisplayRecs = $dbservers_list->lTotalRecs;
	if (!($dbservers->ExportAll && $dbservers->Export <> ""))
		$dbservers_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $dbservers_list->LoadRecordset($dbservers_list->lStartRec-1, $dbservers_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Dbservers
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($dbservers->Export == "" && $dbservers->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(dbservers_list);" style="text-decoration: none;"><img id="dbservers_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="dbservers_list_SearchPanel">
<form name="fdbserverslistsrch" id="fdbserverslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="dbservers">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($dbservers->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $dbservers_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($dbservers->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($dbservers->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($dbservers->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $dbservers_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fdbserverslist" id="fdbserverslist" class="ewForm" action="" method="post">
<?php if ($dbservers_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$dbservers_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$dbservers_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$dbservers_list->lOptionCnt++; // edit
}
if ($Security->IsLoggedIn()) {
	$dbservers_list->lOptionCnt++; // copy
}
if ($Security->IsLoggedIn()) {
	$dbservers_list->lOptionCnt++; // Delete
}
	$dbservers_list->lOptionCnt += count($dbservers_list->ListOptions->Items); // Custom list options
?>
<?php echo $dbservers->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($dbservers->id->Visible) { // id ?>
	<?php if ($dbservers->SortUrl($dbservers->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $dbservers->SortUrl($dbservers->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($dbservers->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbservers->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($dbservers->name->Visible) { // name ?>
	<?php if ($dbservers->SortUrl($dbservers->name) == "") { ?>
		<td>Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $dbservers->SortUrl($dbservers->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Name&nbsp;(*)</td><td style="width: 10px;"><?php if ($dbservers->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbservers->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($dbservers->gid->Visible) { // gid ?>
	<?php if ($dbservers->SortUrl($dbservers->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $dbservers->SortUrl($dbservers->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($dbservers->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbservers->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($dbservers->Export == "") { ?>
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
foreach ($dbservers_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($dbservers->ExportAll && $dbservers->Export <> "") {
	$dbservers_list->lStopRec = $dbservers_list->lTotalRecs;
} else {
	$dbservers_list->lStopRec = $dbservers_list->lStartRec + $dbservers_list->lDisplayRecs - 1; // Set the last record to display
}
$dbservers_list->lRecCount = $dbservers_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$dbservers->SelectLimit && $dbservers_list->lStartRec > 1)
		$rs->Move($dbservers_list->lStartRec - 1);
}
$dbservers_list->lRowCnt = 0;
while (($dbservers->CurrentAction == "gridadd" || !$rs->EOF) &&
	$dbservers_list->lRecCount < $dbservers_list->lStopRec) {
	$dbservers_list->lRecCount++;
	if (intval($dbservers_list->lRecCount) >= intval($dbservers_list->lStartRec)) {
		$dbservers_list->lRowCnt++;

	// Init row class and style
	$dbservers->CssClass = "";
	$dbservers->CssStyle = "";
	$dbservers->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($dbservers->CurrentAction == "gridadd") {
		$dbservers_list->LoadDefaultValues(); // Load default values
	} else {
		$dbservers_list->LoadRowValues($rs); // Load row values
	}
	$dbservers->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$dbservers_list->RenderRow();
?>
	<tr<?php echo $dbservers->RowAttributes() ?>>
	<?php if ($dbservers->id->Visible) { // id ?>
		<td<?php echo $dbservers->id->CellAttributes() ?>>
<div<?php echo $dbservers->id->ViewAttributes() ?>><?php echo $dbservers->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($dbservers->name->Visible) { // name ?>
		<td<?php echo $dbservers->name->CellAttributes() ?>>
<div<?php echo $dbservers->name->ViewAttributes() ?>><?php echo $dbservers->name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($dbservers->gid->Visible) { // gid ?>
		<td<?php echo $dbservers->gid->CellAttributes() ?>>
<div<?php echo $dbservers->gid->ViewAttributes() ?>><?php echo $dbservers->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($dbservers->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $dbservers->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $dbservers->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $dbservers->CopyUrl() ?>">Copy</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $dbservers->DeleteUrl() ?>">Delete</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($dbservers_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($dbservers->CurrentAction <> "gridadd")
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
<?php if ($dbservers->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($dbservers->CurrentAction <> "gridadd" && $dbservers->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($dbservers_list->Pager)) $dbservers_list->Pager = new cPrevNextPager($dbservers_list->lStartRec, $dbservers_list->lDisplayRecs, $dbservers_list->lTotalRecs) ?>
<?php if ($dbservers_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($dbservers_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $dbservers_list->PageUrl() ?>start=<?php echo $dbservers_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($dbservers_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $dbservers_list->PageUrl() ?>start=<?php echo $dbservers_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $dbservers_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($dbservers_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $dbservers_list->PageUrl() ?>start=<?php echo $dbservers_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($dbservers_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $dbservers_list->PageUrl() ?>start=<?php echo $dbservers_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $dbservers_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $dbservers_list->Pager->FromIndex ?> to <?php echo $dbservers_list->Pager->ToIndex ?> of <?php echo $dbservers_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($dbservers_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($dbservers_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbservers->AddUrl() ?>">Add</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($dbservers->Export == "" && $dbservers->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(dbservers_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($dbservers->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$dbservers_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cdbservers_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'dbservers';

	// Page Object Name
	var $PageObjName = 'dbservers_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $dbservers;
		if ($dbservers->UseTokenInUrl) $PageUrl .= "t=" . $dbservers->TableVar . "&"; // add page token
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
		global $objForm, $dbservers;
		if ($dbservers->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($dbservers->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($dbservers->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdbservers_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["dbservers"] = new cdbservers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dbservers', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $dbservers;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$dbservers->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $dbservers->Export; // Get export parameter, used in header
	$gsExportFile = $dbservers->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $dbservers;
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
		if ($dbservers->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $dbservers->getRecordsPerPage(); // Restore from Session
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
		$dbservers->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$dbservers->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$dbservers->setStartRecordNumber($this->lStartRec);
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
		$dbservers->setSessionWhere($sFilter);
		$dbservers->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $dbservers;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $dbservers->name->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $dbservers;
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
			$dbservers->setBasicSearchKeyword($sSearchKeyword);
			$dbservers->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $dbservers;
		$this->sSrchWhere = "";
		$dbservers->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $dbservers;
		$dbservers->setBasicSearchKeyword("");
		$dbservers->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $dbservers;
		$this->sSrchWhere = $dbservers->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $dbservers;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$dbservers->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$dbservers->CurrentOrderType = @$_GET["ordertype"];
			$dbservers->UpdateSort($dbservers->id); // Field 
			$dbservers->UpdateSort($dbservers->name); // Field 
			$dbservers->UpdateSort($dbservers->gid); // Field 
			$dbservers->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $dbservers;
		$sOrderBy = $dbservers->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($dbservers->SqlOrderBy() <> "") {
				$sOrderBy = $dbservers->SqlOrderBy();
				$dbservers->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $dbservers;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$dbservers->setSessionOrderBy($sOrderBy);
				$dbservers->id->setSort("");
				$dbservers->name->setSort("");
				$dbservers->gid->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$dbservers->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $dbservers;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$dbservers->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$dbservers->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $dbservers->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$dbservers->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$dbservers->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$dbservers->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $dbservers;

		// Call Recordset Selecting event
		$dbservers->Recordset_Selecting($dbservers->CurrentFilter);

		// Load list page SQL
		$sSql = $dbservers->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$dbservers->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $dbservers;
		$sFilter = $dbservers->KeyFilter();

		// Call Row Selecting event
		$dbservers->Row_Selecting($sFilter);

		// Load sql based on filter
		$dbservers->CurrentFilter = $sFilter;
		$sSql = $dbservers->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$dbservers->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $dbservers;
		$dbservers->id->setDbValue($rs->fields('id'));
		$dbservers->name->setDbValue($rs->fields('name'));
		$dbservers->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $dbservers;

		// Call Row_Rendering event
		$dbservers->Row_Rendering();

		// Common render codes for all row types
		// id

		$dbservers->id->CellCssStyle = "";
		$dbservers->id->CellCssClass = "";

		// name
		$dbservers->name->CellCssStyle = "";
		$dbservers->name->CellCssClass = "";

		// gid
		$dbservers->gid->CellCssStyle = "";
		$dbservers->gid->CellCssClass = "";
		if ($dbservers->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$dbservers->id->ViewValue = $dbservers->id->CurrentValue;
			$dbservers->id->CssStyle = "";
			$dbservers->id->CssClass = "";
			$dbservers->id->ViewCustomAttributes = "";

			// name
			$dbservers->name->ViewValue = $dbservers->name->CurrentValue;
			$dbservers->name->CssStyle = "";
			$dbservers->name->CssClass = "";
			$dbservers->name->ViewCustomAttributes = "";

			// gid
			$dbservers->gid->ViewValue = $dbservers->gid->CurrentValue;
			$dbservers->gid->CssStyle = "";
			$dbservers->gid->CssClass = "";
			$dbservers->gid->ViewCustomAttributes = "";

			// id
			$dbservers->id->HrefValue = "";

			// name
			$dbservers->name->HrefValue = "";

			// gid
			$dbservers->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$dbservers->Row_Rendered();
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
