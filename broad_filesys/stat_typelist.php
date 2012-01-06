<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "stat_typeinfo.php" ?>
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
$stat_type_list = new cstat_type_list();
$Page =& $stat_type_list;

// Page init processing
$stat_type_list->Page_Init();

// Page main processing
$stat_type_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($stat_type->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var stat_type_list = new ew_Page("stat_type_list");

// page properties
stat_type_list.PageID = "list"; // page ID
var EW_PAGE_ID = stat_type_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
stat_type_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
stat_type_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
stat_type_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($stat_type->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($stat_type->Export == "" && $stat_type->SelectLimit);
	if (!$bSelectLimit)
		$rs = $stat_type_list->LoadRecordset();
	$stat_type_list->lTotalRecs = ($bSelectLimit) ? $stat_type->SelectRecordCount() : $rs->RecordCount();
	$stat_type_list->lStartRec = 1;
	if ($stat_type_list->lDisplayRecs <= 0) // Display all records
		$stat_type_list->lDisplayRecs = $stat_type_list->lTotalRecs;
	if (!($stat_type->ExportAll && $stat_type->Export <> ""))
		$stat_type_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $stat_type_list->LoadRecordset($stat_type_list->lStartRec-1, $stat_type_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Stat Type
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($stat_type->Export == "" && $stat_type->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(stat_type_list);" style="text-decoration: none;"><img id="stat_type_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="stat_type_list_SearchPanel">
<form name="fstat_typelistsrch" id="fstat_typelistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="stat_type">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($stat_type->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $stat_type_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($stat_type->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($stat_type->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($stat_type->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $stat_type_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fstat_typelist" id="fstat_typelist" class="ewForm" action="" method="post">
<?php if ($stat_type_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$stat_type_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$stat_type_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$stat_type_list->lOptionCnt++; // edit
}
	$stat_type_list->lOptionCnt += count($stat_type_list->ListOptions->Items); // Custom list options
?>
<?php echo $stat_type->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($stat_type->id->Visible) { // id ?>
	<?php if ($stat_type->SortUrl($stat_type->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $stat_type->SortUrl($stat_type->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($stat_type->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($stat_type->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($stat_type->name->Visible) { // name ?>
	<?php if ($stat_type->SortUrl($stat_type->name) == "") { ?>
		<td>Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $stat_type->SortUrl($stat_type->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Name&nbsp;(*)</td><td style="width: 10px;"><?php if ($stat_type->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($stat_type->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($stat_type->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($stat_type_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($stat_type->ExportAll && $stat_type->Export <> "") {
	$stat_type_list->lStopRec = $stat_type_list->lTotalRecs;
} else {
	$stat_type_list->lStopRec = $stat_type_list->lStartRec + $stat_type_list->lDisplayRecs - 1; // Set the last record to display
}
$stat_type_list->lRecCount = $stat_type_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$stat_type->SelectLimit && $stat_type_list->lStartRec > 1)
		$rs->Move($stat_type_list->lStartRec - 1);
}
$stat_type_list->lRowCnt = 0;
while (($stat_type->CurrentAction == "gridadd" || !$rs->EOF) &&
	$stat_type_list->lRecCount < $stat_type_list->lStopRec) {
	$stat_type_list->lRecCount++;
	if (intval($stat_type_list->lRecCount) >= intval($stat_type_list->lStartRec)) {
		$stat_type_list->lRowCnt++;

	// Init row class and style
	$stat_type->CssClass = "";
	$stat_type->CssStyle = "";
	$stat_type->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($stat_type->CurrentAction == "gridadd") {
		$stat_type_list->LoadDefaultValues(); // Load default values
	} else {
		$stat_type_list->LoadRowValues($rs); // Load row values
	}
	$stat_type->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$stat_type_list->RenderRow();
?>
	<tr<?php echo $stat_type->RowAttributes() ?>>
	<?php if ($stat_type->id->Visible) { // id ?>
		<td<?php echo $stat_type->id->CellAttributes() ?>>
<div<?php echo $stat_type->id->ViewAttributes() ?>><?php echo $stat_type->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($stat_type->name->Visible) { // name ?>
		<td<?php echo $stat_type->name->CellAttributes() ?>>
<div<?php echo $stat_type->name->ViewAttributes() ?>><?php echo $stat_type->name->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($stat_type->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $stat_type->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $stat_type->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($stat_type_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($stat_type->CurrentAction <> "gridadd")
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
<?php if ($stat_type->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($stat_type->CurrentAction <> "gridadd" && $stat_type->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($stat_type_list->Pager)) $stat_type_list->Pager = new cPrevNextPager($stat_type_list->lStartRec, $stat_type_list->lDisplayRecs, $stat_type_list->lTotalRecs) ?>
<?php if ($stat_type_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($stat_type_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $stat_type_list->PageUrl() ?>start=<?php echo $stat_type_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($stat_type_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $stat_type_list->PageUrl() ?>start=<?php echo $stat_type_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $stat_type_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($stat_type_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $stat_type_list->PageUrl() ?>start=<?php echo $stat_type_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($stat_type_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $stat_type_list->PageUrl() ?>start=<?php echo $stat_type_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $stat_type_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $stat_type_list->Pager->FromIndex ?> to <?php echo $stat_type_list->Pager->ToIndex ?> of <?php echo $stat_type_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($stat_type_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($stat_type_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($stat_type->Export == "" && $stat_type->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(stat_type_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($stat_type->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$stat_type_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cstat_type_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'stat_type';

	// Page Object Name
	var $PageObjName = 'stat_type_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $stat_type;
		if ($stat_type->UseTokenInUrl) $PageUrl .= "t=" . $stat_type->TableVar . "&"; // add page token
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
		global $objForm, $stat_type;
		if ($stat_type->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($stat_type->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($stat_type->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cstat_type_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["stat_type"] = new cstat_type();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'stat_type', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $stat_type;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$stat_type->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $stat_type->Export; // Get export parameter, used in header
	$gsExportFile = $stat_type->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $stat_type;
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
		if ($stat_type->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $stat_type->getRecordsPerPage(); // Restore from Session
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
		$stat_type->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$stat_type->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$stat_type->setStartRecordNumber($this->lStartRec);
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
		$stat_type->setSessionWhere($sFilter);
		$stat_type->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $stat_type;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $stat_type->name->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $stat_type;
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
			$stat_type->setBasicSearchKeyword($sSearchKeyword);
			$stat_type->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $stat_type;
		$this->sSrchWhere = "";
		$stat_type->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $stat_type;
		$stat_type->setBasicSearchKeyword("");
		$stat_type->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $stat_type;
		$this->sSrchWhere = $stat_type->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $stat_type;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$stat_type->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$stat_type->CurrentOrderType = @$_GET["ordertype"];
			$stat_type->UpdateSort($stat_type->id); // Field 
			$stat_type->UpdateSort($stat_type->name); // Field 
			$stat_type->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $stat_type;
		$sOrderBy = $stat_type->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($stat_type->SqlOrderBy() <> "") {
				$sOrderBy = $stat_type->SqlOrderBy();
				$stat_type->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $stat_type;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$stat_type->setSessionOrderBy($sOrderBy);
				$stat_type->id->setSort("");
				$stat_type->name->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$stat_type->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $stat_type;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$stat_type->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$stat_type->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $stat_type->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$stat_type->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$stat_type->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$stat_type->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $stat_type;

		// Call Recordset Selecting event
		$stat_type->Recordset_Selecting($stat_type->CurrentFilter);

		// Load list page SQL
		$sSql = $stat_type->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$stat_type->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $stat_type;
		$sFilter = $stat_type->KeyFilter();

		// Call Row Selecting event
		$stat_type->Row_Selecting($sFilter);

		// Load sql based on filter
		$stat_type->CurrentFilter = $sFilter;
		$sSql = $stat_type->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$stat_type->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $stat_type;
		$stat_type->id->setDbValue($rs->fields('id'));
		$stat_type->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $stat_type;

		// Call Row_Rendering event
		$stat_type->Row_Rendering();

		// Common render codes for all row types
		// id

		$stat_type->id->CellCssStyle = "";
		$stat_type->id->CellCssClass = "";

		// name
		$stat_type->name->CellCssStyle = "";
		$stat_type->name->CellCssClass = "";
		if ($stat_type->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$stat_type->id->ViewValue = $stat_type->id->CurrentValue;
			$stat_type->id->CssStyle = "";
			$stat_type->id->CssClass = "";
			$stat_type->id->ViewCustomAttributes = "";

			// name
			$stat_type->name->ViewValue = $stat_type->name->CurrentValue;
			$stat_type->name->CssStyle = "";
			$stat_type->name->CssClass = "";
			$stat_type->name->ViewCustomAttributes = "";

			// id
			$stat_type->id->HrefValue = "";

			// name
			$stat_type->name->HrefValue = "";
		}

		// Call Row Rendered event
		$stat_type->Row_Rendered();
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
