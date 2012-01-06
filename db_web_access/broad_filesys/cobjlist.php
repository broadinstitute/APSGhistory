<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cobjinfo.php" ?>
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
$cobj_list = new ccobj_list();
$Page =& $cobj_list;

// Page init processing
$cobj_list->Page_Init();

// Page main processing
$cobj_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cobj->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cobj_list = new ew_Page("cobj_list");

// page properties
cobj_list.PageID = "list"; // page ID
var EW_PAGE_ID = cobj_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cobj_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cobj_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cobj_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($cobj->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($cobj->Export == "" && $cobj->SelectLimit);
	if (!$bSelectLimit)
		$rs = $cobj_list->LoadRecordset();
	$cobj_list->lTotalRecs = ($bSelectLimit) ? $cobj->SelectRecordCount() : $rs->RecordCount();
	$cobj_list->lStartRec = 1;
	if ($cobj_list->lDisplayRecs <= 0) // Display all records
		$cobj_list->lDisplayRecs = $cobj_list->lTotalRecs;
	if (!($cobj->ExportAll && $cobj->Export <> ""))
		$cobj_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $cobj_list->LoadRecordset($cobj_list->lStartRec-1, $cobj_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Cobj
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($cobj->Export == "" && $cobj->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(cobj_list);" style="text-decoration: none;"><img id="cobj_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="cobj_list_SearchPanel">
<form name="fcobjlistsrch" id="fcobjlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="cobj">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cobj->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $cobj_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($cobj->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cobj->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cobj->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $cobj_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fcobjlist" id="fcobjlist" class="ewForm" action="" method="post">
<?php if ($cobj_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$cobj_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$cobj_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$cobj_list->lOptionCnt++; // edit
}
	$cobj_list->lOptionCnt += count($cobj_list->ListOptions->Items); // Custom list options
?>
<?php echo $cobj->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($cobj->cid->Visible) { // cid ?>
	<?php if ($cobj->SortUrl($cobj->cid) == "") { ?>
		<td>Cid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cobj->SortUrl($cobj->cid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cid</td><td style="width: 10px;"><?php if ($cobj->cid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cobj->cid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cobj->class->Visible) { // class ?>
	<?php if ($cobj->SortUrl($cobj->class) == "") { ?>
		<td>Class</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cobj->SortUrl($cobj->class) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Class&nbsp;(*)</td><td style="width: 10px;"><?php if ($cobj->class->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cobj->class->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cobj->name->Visible) { // name ?>
	<?php if ($cobj->SortUrl($cobj->name) == "") { ?>
		<td>Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cobj->SortUrl($cobj->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Name&nbsp;(*)</td><td style="width: 10px;"><?php if ($cobj->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cobj->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cobj->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($cobj_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($cobj->ExportAll && $cobj->Export <> "") {
	$cobj_list->lStopRec = $cobj_list->lTotalRecs;
} else {
	$cobj_list->lStopRec = $cobj_list->lStartRec + $cobj_list->lDisplayRecs - 1; // Set the last record to display
}
$cobj_list->lRecCount = $cobj_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$cobj->SelectLimit && $cobj_list->lStartRec > 1)
		$rs->Move($cobj_list->lStartRec - 1);
}
$cobj_list->lRowCnt = 0;
while (($cobj->CurrentAction == "gridadd" || !$rs->EOF) &&
	$cobj_list->lRecCount < $cobj_list->lStopRec) {
	$cobj_list->lRecCount++;
	if (intval($cobj_list->lRecCount) >= intval($cobj_list->lStartRec)) {
		$cobj_list->lRowCnt++;

	// Init row class and style
	$cobj->CssClass = "";
	$cobj->CssStyle = "";
	$cobj->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($cobj->CurrentAction == "gridadd") {
		$cobj_list->LoadDefaultValues(); // Load default values
	} else {
		$cobj_list->LoadRowValues($rs); // Load row values
	}
	$cobj->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$cobj_list->RenderRow();
?>
	<tr<?php echo $cobj->RowAttributes() ?>>
	<?php if ($cobj->cid->Visible) { // cid ?>
		<td<?php echo $cobj->cid->CellAttributes() ?>>
<div<?php echo $cobj->cid->ViewAttributes() ?>><?php echo $cobj->cid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cobj->class->Visible) { // class ?>
		<td<?php echo $cobj->class->CellAttributes() ?>>
<div<?php echo $cobj->class->ViewAttributes() ?>><?php echo $cobj->class->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cobj->name->Visible) { // name ?>
		<td<?php echo $cobj->name->CellAttributes() ?>>
<div<?php echo $cobj->name->ViewAttributes() ?>><?php echo $cobj->name->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($cobj->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $cobj->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $cobj->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($cobj_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($cobj->CurrentAction <> "gridadd")
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
<?php if ($cobj->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cobj->CurrentAction <> "gridadd" && $cobj->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cobj_list->Pager)) $cobj_list->Pager = new cPrevNextPager($cobj_list->lStartRec, $cobj_list->lDisplayRecs, $cobj_list->lTotalRecs) ?>
<?php if ($cobj_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($cobj_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cobj_list->PageUrl() ?>start=<?php echo $cobj_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cobj_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cobj_list->PageUrl() ?>start=<?php echo $cobj_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cobj_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cobj_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cobj_list->PageUrl() ?>start=<?php echo $cobj_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cobj_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cobj_list->PageUrl() ?>start=<?php echo $cobj_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $cobj_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $cobj_list->Pager->FromIndex ?> to <?php echo $cobj_list->Pager->ToIndex ?> of <?php echo $cobj_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($cobj_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($cobj_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($cobj->Export == "" && $cobj->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(cobj_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($cobj->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$cobj_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class ccobj_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'cobj';

	// Page Object Name
	var $PageObjName = 'cobj_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cobj;
		if ($cobj->UseTokenInUrl) $PageUrl .= "t=" . $cobj->TableVar . "&"; // add page token
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
		global $objForm, $cobj;
		if ($cobj->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cobj->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cobj->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccobj_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["cobj"] = new ccobj();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cobj', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cobj;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$cobj->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $cobj->Export; // Get export parameter, used in header
	$gsExportFile = $cobj->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $cobj;
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
		if ($cobj->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $cobj->getRecordsPerPage(); // Restore from Session
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
		$cobj->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$cobj->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$cobj->setStartRecordNumber($this->lStartRec);
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
		$cobj->setSessionWhere($sFilter);
		$cobj->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $cobj;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $cobj->class->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $cobj->name->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $cobj;
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
			$cobj->setBasicSearchKeyword($sSearchKeyword);
			$cobj->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $cobj;
		$this->sSrchWhere = "";
		$cobj->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $cobj;
		$cobj->setBasicSearchKeyword("");
		$cobj->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $cobj;
		$this->sSrchWhere = $cobj->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $cobj;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$cobj->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$cobj->CurrentOrderType = @$_GET["ordertype"];
			$cobj->UpdateSort($cobj->cid); // Field 
			$cobj->UpdateSort($cobj->class); // Field 
			$cobj->UpdateSort($cobj->name); // Field 
			$cobj->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $cobj;
		$sOrderBy = $cobj->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($cobj->SqlOrderBy() <> "") {
				$sOrderBy = $cobj->SqlOrderBy();
				$cobj->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $cobj;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$cobj->setSessionOrderBy($sOrderBy);
				$cobj->cid->setSort("");
				$cobj->class->setSort("");
				$cobj->name->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$cobj->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $cobj;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$cobj->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$cobj->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $cobj->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$cobj->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$cobj->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$cobj->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cobj;

		// Call Recordset Selecting event
		$cobj->Recordset_Selecting($cobj->CurrentFilter);

		// Load list page SQL
		$sSql = $cobj->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$cobj->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cobj;
		$sFilter = $cobj->KeyFilter();

		// Call Row Selecting event
		$cobj->Row_Selecting($sFilter);

		// Load sql based on filter
		$cobj->CurrentFilter = $sFilter;
		$sSql = $cobj->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cobj->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cobj;
		$cobj->cid->setDbValue($rs->fields('cid'));
		$cobj->class->setDbValue($rs->fields('class'));
		$cobj->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cobj;

		// Call Row_Rendering event
		$cobj->Row_Rendering();

		// Common render codes for all row types
		// cid

		$cobj->cid->CellCssStyle = "";
		$cobj->cid->CellCssClass = "";

		// class
		$cobj->class->CellCssStyle = "";
		$cobj->class->CellCssClass = "";

		// name
		$cobj->name->CellCssStyle = "";
		$cobj->name->CellCssClass = "";
		if ($cobj->RowType == EW_ROWTYPE_VIEW) { // View row

			// cid
			$cobj->cid->ViewValue = $cobj->cid->CurrentValue;
			$cobj->cid->CssStyle = "";
			$cobj->cid->CssClass = "";
			$cobj->cid->ViewCustomAttributes = "";

			// class
			$cobj->class->ViewValue = $cobj->class->CurrentValue;
			$cobj->class->CssStyle = "";
			$cobj->class->CssClass = "";
			$cobj->class->ViewCustomAttributes = "";

			// name
			$cobj->name->ViewValue = $cobj->name->CurrentValue;
			$cobj->name->CssStyle = "";
			$cobj->name->CssClass = "";
			$cobj->name->ViewCustomAttributes = "";

			// cid
			$cobj->cid->HrefValue = "";

			// class
			$cobj->class->HrefValue = "";

			// name
			$cobj->name->HrefValue = "";
		}

		// Call Row Rendered event
		$cobj->Row_Rendered();
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
