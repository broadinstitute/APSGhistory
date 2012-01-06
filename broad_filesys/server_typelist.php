<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "server_typeinfo.php" ?>
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
$server_type_list = new cserver_type_list();
$Page =& $server_type_list;

// Page init
$server_type_list->Page_Init();

// Page main
$server_type_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($server_type->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var server_type_list = new ew_Page("server_type_list");

// page properties
server_type_list.PageID = "list"; // page ID
server_type_list.FormID = "fserver_typelist"; // form ID
var EW_PAGE_ID = server_type_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
server_type_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
server_type_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
server_type_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($server_type->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$server_type_list->lTotalRecs = $server_type->SelectRecordCount();
	} else {
		if ($rs = $server_type_list->LoadRecordset())
			$server_type_list->lTotalRecs = $rs->RecordCount();
	}
	$server_type_list->lStartRec = 1;
	if ($server_type_list->lDisplayRecs <= 0 || ($server_type->Export <> "" && $server_type->ExportAll)) // Display all records
		$server_type_list->lDisplayRecs = $server_type_list->lTotalRecs;
	if (!($server_type->Export <> "" && $server_type->ExportAll))
		$server_type_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $server_type_list->LoadRecordset($server_type_list->lStartRec-1, $server_type_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $server_type->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($server_type->Export == "" && $server_type->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(server_type_list);" style="text-decoration: none;"><img id="server_type_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="server_type_list_SearchPanel">
<form name="fserver_typelistsrch" id="fserver_typelistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="server_type">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($server_type->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $server_type_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($server_type->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($server_type->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($server_type->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$server_type_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fserver_typelist" id="fserver_typelist" class="ewForm" action="" method="post">
<div id="gmp_server_type" class="ewGridMiddlePanel">
<?php if ($server_type_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $server_type->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$server_type_list->RenderListOptions();

// Render list options (header, left)
$server_type_list->ListOptions->Render("header", "left");
?>
<?php if ($server_type->id->Visible) { // id ?>
	<?php if ($server_type->SortUrl($server_type->id) == "") { ?>
		<td><?php echo $server_type->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $server_type->SortUrl($server_type->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $server_type->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($server_type->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($server_type->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($server_type->name->Visible) { // name ?>
	<?php if ($server_type->SortUrl($server_type->name) == "") { ?>
		<td><?php echo $server_type->name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $server_type->SortUrl($server_type->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $server_type->name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($server_type->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($server_type->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$server_type_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($server_type->ExportAll && $server_type->Export <> "") {
	$server_type_list->lStopRec = $server_type_list->lTotalRecs;
} else {
	$server_type_list->lStopRec = $server_type_list->lStartRec + $server_type_list->lDisplayRecs - 1; // Set the last record to display
}
$server_type_list->lRecCount = $server_type_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $server_type_list->lStartRec > 1)
		$rs->Move($server_type_list->lStartRec - 1);
}

// Initialize aggregate
$server_type->RowType = EW_ROWTYPE_AGGREGATEINIT;
$server_type_list->RenderRow();
$server_type_list->lRowCnt = 0;
while (($server_type->CurrentAction == "gridadd" || !$rs->EOF) &&
	$server_type_list->lRecCount < $server_type_list->lStopRec) {
	$server_type_list->lRecCount++;
	if (intval($server_type_list->lRecCount) >= intval($server_type_list->lStartRec)) {
		$server_type_list->lRowCnt++;

	// Init row class and style
	$server_type->CssClass = "";
	$server_type->CssStyle = "";
	$server_type->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($server_type->CurrentAction == "gridadd") {
		$server_type_list->LoadDefaultValues(); // Load default values
	} else {
		$server_type_list->LoadRowValues($rs); // Load row values
	}
	$server_type->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$server_type_list->RenderRow();

	// Render list options
	$server_type_list->RenderListOptions();
?>
	<tr<?php echo $server_type->RowAttributes() ?>>
<?php

// Render list options (body, left)
$server_type_list->ListOptions->Render("body", "left");
?>
	<?php if ($server_type->id->Visible) { // id ?>
		<td<?php echo $server_type->id->CellAttributes() ?>>
<div<?php echo $server_type->id->ViewAttributes() ?>><?php echo $server_type->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($server_type->name->Visible) { // name ?>
		<td<?php echo $server_type->name->CellAttributes() ?>>
<div<?php echo $server_type->name->ViewAttributes() ?>><?php echo $server_type->name->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$server_type_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($server_type->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($server_type->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($server_type->CurrentAction <> "gridadd" && $server_type->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($server_type_list->Pager)) $server_type_list->Pager = new cPrevNextPager($server_type_list->lStartRec, $server_type_list->lDisplayRecs, $server_type_list->lTotalRecs) ?>
<?php if ($server_type_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($server_type_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $server_type_list->PageUrl() ?>start=<?php echo $server_type_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($server_type_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $server_type_list->PageUrl() ?>start=<?php echo $server_type_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $server_type_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($server_type_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $server_type_list->PageUrl() ?>start=<?php echo $server_type_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($server_type_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $server_type_list->PageUrl() ?>start=<?php echo $server_type_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $server_type_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $server_type_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $server_type_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $server_type_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($server_type_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($server_type_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($server_type->Export == "" && $server_type->CurrentAction == "") { ?>
<?php } ?>
<?php if ($server_type->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$server_type_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cserver_type_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'server_type';

	// Page object name
	var $PageObjName = 'server_type_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $server_type;
		if ($server_type->UseTokenInUrl) $PageUrl .= "t=" . $server_type->TableVar . "&"; // Add page token
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
		global $objForm, $server_type;
		if ($server_type->UseTokenInUrl) {
			if ($objForm)
				return ($server_type->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($server_type->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cserver_type_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (server_type)
		$GLOBALS["server_type"] = new cserver_type();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["server_type"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "server_typedelete.php";
		$this->MultiUpdateUrl = "server_typeupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'server_type', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $server_type;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$server_type->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$server_type->Export = $_POST["exporttype"];
		} else {
			$server_type->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $server_type->Export; // Get export parameter, used in header
		$gsExportFile = $server_type->TableVar; // Get export file, used in header

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

	// Class variables
	var $ListOptions; // List options
	var $lDisplayRecs = 20;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $sSrchWhere = ""; // Search WHERE clause
	var $lRecCnt = 0; // Record count
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex; // Row index
	var $lRecPerRow = 0;
	var $lColCnt = 0;
	var $sDbMasterFilter = ""; // Master filter
	var $sDbDetailFilter = ""; // Detail filter
	var $bMasterRecordExists;	
	var $sMultiSelectKey;
	var $RestoreSearch;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError, $Security, $server_type;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$server_type->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($server_type->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $server_type->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		if ($sSrchAdvanced <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchAdvanced . ")" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchBasic. ")" : $sSrchBasic;

		// Call Recordset_Searching event
		$server_type->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$server_type->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$server_type->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $server_type->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$server_type->setSessionWhere($sFilter);
		$server_type->CurrentFilter = "";
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $server_type;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $server_type->name, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . " LIKE " . ew_QuotedValue("%" . $Keyword . "%", $lFldDataType);
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $server_type;
		$sSearchStr = "";
		$sSearchKeyword = $server_type->BasicSearchKeyword;
		$sSearchType = $server_type->BasicSearchType;
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
			$server_type->setSessionBasicSearchKeyword($sSearchKeyword);
			$server_type->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $server_type;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$server_type->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $server_type;
		$server_type->setSessionBasicSearchKeyword("");
		$server_type->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $server_type;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$server_type->BasicSearchKeyword = $server_type->getSessionBasicSearchKeyword();
			$server_type->BasicSearchType = $server_type->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $server_type;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$server_type->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$server_type->CurrentOrderType = @$_GET["ordertype"];
			$server_type->UpdateSort($server_type->id); // id
			$server_type->UpdateSort($server_type->name); // name
			$server_type->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $server_type;
		$sOrderBy = $server_type->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($server_type->SqlOrderBy() <> "") {
				$sOrderBy = $server_type->SqlOrderBy();
				$server_type->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $server_type;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$server_type->setSessionOrderBy($sOrderBy);
				$server_type->id->setSort("");
				$server_type->name->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$server_type->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $server_type;

		// "view"
		$this->ListOptions->Add("view");
		$item =& $this->ListOptions->Items["view"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "edit"
		$this->ListOptions->Add("edit");
		$item =& $this->ListOptions->Items["edit"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "detail_filesystem"
		$this->ListOptions->Add("detail_filesystem");
		$item =& $this->ListOptions->Items["detail_filesystem"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($server_type->Export <> "" ||
			$server_type->CurrentAction == "gridadd" ||
			$server_type->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $server_type;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt =& $this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible)
			$oListOpt->Body = "<a href=\"" . $this->ViewUrl . "\">" . $Language->Phrase("ViewLink") . "</a>";

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
		}

		// "detail_filesystem"
		$oListOpt =& $this->ListOptions->Items["detail_filesystem"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = $Language->Phrase("DetailLink") . $Language->TablePhrase("filesystem", "TblCaption");
			$oListOpt->Body = "<a href=\"filesystemlist.php?" . EW_TABLE_SHOW_MASTER . "=server_type&id=" . urlencode(strval($server_type->id->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $server_type;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $server_type;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$server_type->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$server_type->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $server_type->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$server_type->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$server_type->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$server_type->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $server_type;
		$server_type->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$server_type->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $server_type;

		// Call Recordset Selecting event
		$server_type->Recordset_Selecting($server_type->CurrentFilter);

		// Load List page SQL
		$sSql = $server_type->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$server_type->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $server_type;
		$sFilter = $server_type->KeyFilter();

		// Call Row Selecting event
		$server_type->Row_Selecting($sFilter);

		// Load SQL based on filter
		$server_type->CurrentFilter = $sFilter;
		$sSql = $server_type->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$server_type->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $server_type;
		$server_type->id->setDbValue($rs->fields('id'));
		$server_type->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $server_type;

		// Initialize URLs
		$this->ViewUrl = $server_type->ViewUrl();
		$this->EditUrl = $server_type->EditUrl();
		$this->InlineEditUrl = $server_type->InlineEditUrl();
		$this->CopyUrl = $server_type->CopyUrl();
		$this->InlineCopyUrl = $server_type->InlineCopyUrl();
		$this->DeleteUrl = $server_type->DeleteUrl();

		// Call Row_Rendering event
		$server_type->Row_Rendering();

		// Common render codes for all row types
		// id

		$server_type->id->CellCssStyle = ""; $server_type->id->CellCssClass = "";
		$server_type->id->CellAttrs = array(); $server_type->id->ViewAttrs = array(); $server_type->id->EditAttrs = array();

		// name
		$server_type->name->CellCssStyle = ""; $server_type->name->CellCssClass = "";
		$server_type->name->CellAttrs = array(); $server_type->name->ViewAttrs = array(); $server_type->name->EditAttrs = array();
		if ($server_type->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$server_type->id->ViewValue = $server_type->id->CurrentValue;
			$server_type->id->CssStyle = "";
			$server_type->id->CssClass = "";
			$server_type->id->ViewCustomAttributes = "";

			// name
			$server_type->name->ViewValue = $server_type->name->CurrentValue;
			$server_type->name->CssStyle = "";
			$server_type->name->CssClass = "";
			$server_type->name->ViewCustomAttributes = "";

			// id
			$server_type->id->HrefValue = "";
			$server_type->id->TooltipValue = "";

			// name
			$server_type->name->HrefValue = "";
			$server_type->name->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($server_type->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$server_type->Row_Rendered();
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example: 
		//$this->ListOptions->Add("new");
		//$this->ListOptions->Items["new"]->OnLeft = TRUE; // Link on left
		//$this->ListOptions->MoveItem("new", 0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
