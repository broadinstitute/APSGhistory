<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "rescomp_fs_viewinfo.php" ?>
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
$rescomp_fs_view_list = new crescomp_fs_view_list();
$Page =& $rescomp_fs_view_list;

// Page init
$rescomp_fs_view_list->Page_Init();

// Page main
$rescomp_fs_view_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($rescomp_fs_view->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var rescomp_fs_view_list = new ew_Page("rescomp_fs_view_list");

// page properties
rescomp_fs_view_list.PageID = "list"; // page ID
rescomp_fs_view_list.FormID = "frescomp_fs_viewlist"; // form ID
var EW_PAGE_ID = rescomp_fs_view_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
rescomp_fs_view_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rescomp_fs_view_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rescomp_fs_view_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($rescomp_fs_view->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$rescomp_fs_view_list->lTotalRecs = $rescomp_fs_view->SelectRecordCount();
	} else {
		if ($rs = $rescomp_fs_view_list->LoadRecordset())
			$rescomp_fs_view_list->lTotalRecs = $rs->RecordCount();
	}
	$rescomp_fs_view_list->lStartRec = 1;
	if ($rescomp_fs_view_list->lDisplayRecs <= 0 || ($rescomp_fs_view->Export <> "" && $rescomp_fs_view->ExportAll)) // Display all records
		$rescomp_fs_view_list->lDisplayRecs = $rescomp_fs_view_list->lTotalRecs;
	if (!($rescomp_fs_view->Export <> "" && $rescomp_fs_view->ExportAll))
		$rescomp_fs_view_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $rescomp_fs_view_list->LoadRecordset($rescomp_fs_view_list->lStartRec-1, $rescomp_fs_view_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $rescomp_fs_view->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($rescomp_fs_view->Export == "" && $rescomp_fs_view->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(rescomp_fs_view_list);" style="text-decoration: none;"><img id="rescomp_fs_view_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="rescomp_fs_view_list_SearchPanel">
<form name="frescomp_fs_viewlistsrch" id="frescomp_fs_viewlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="rescomp_fs_view">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($rescomp_fs_view->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $rescomp_fs_view_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($rescomp_fs_view->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($rescomp_fs_view->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($rescomp_fs_view->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$rescomp_fs_view_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="frescomp_fs_viewlist" id="frescomp_fs_viewlist" class="ewForm" action="" method="post">
<div id="gmp_rescomp_fs_view" class="ewGridMiddlePanel">
<?php if ($rescomp_fs_view_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $rescomp_fs_view->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$rescomp_fs_view_list->RenderListOptions();

// Render list options (header, left)
$rescomp_fs_view_list->ListOptions->Render("header", "left");
?>
<?php if ($rescomp_fs_view->mount->Visible) { // mount ?>
	<?php if ($rescomp_fs_view->SortUrl($rescomp_fs_view->mount) == "") { ?>
		<td><?php echo $rescomp_fs_view->mount->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rescomp_fs_view->SortUrl($rescomp_fs_view->mount) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $rescomp_fs_view->mount->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($rescomp_fs_view->mount->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rescomp_fs_view->mount->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($rescomp_fs_view->path->Visible) { // path ?>
	<?php if ($rescomp_fs_view->SortUrl($rescomp_fs_view->path) == "") { ?>
		<td><?php echo $rescomp_fs_view->path->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rescomp_fs_view->SortUrl($rescomp_fs_view->path) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $rescomp_fs_view->path->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($rescomp_fs_view->path->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rescomp_fs_view->path->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($rescomp_fs_view->rescomp->Visible) { // rescomp ?>
	<?php if ($rescomp_fs_view->SortUrl($rescomp_fs_view->rescomp) == "") { ?>
		<td><?php echo $rescomp_fs_view->rescomp->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rescomp_fs_view->SortUrl($rescomp_fs_view->rescomp) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $rescomp_fs_view->rescomp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($rescomp_fs_view->rescomp->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rescomp_fs_view->rescomp->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$rescomp_fs_view_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($rescomp_fs_view->ExportAll && $rescomp_fs_view->Export <> "") {
	$rescomp_fs_view_list->lStopRec = $rescomp_fs_view_list->lTotalRecs;
} else {
	$rescomp_fs_view_list->lStopRec = $rescomp_fs_view_list->lStartRec + $rescomp_fs_view_list->lDisplayRecs - 1; // Set the last record to display
}
$rescomp_fs_view_list->lRecCount = $rescomp_fs_view_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $rescomp_fs_view_list->lStartRec > 1)
		$rs->Move($rescomp_fs_view_list->lStartRec - 1);
}

// Initialize aggregate
$rescomp_fs_view->RowType = EW_ROWTYPE_AGGREGATEINIT;
$rescomp_fs_view_list->RenderRow();
$rescomp_fs_view_list->lRowCnt = 0;
while (($rescomp_fs_view->CurrentAction == "gridadd" || !$rs->EOF) &&
	$rescomp_fs_view_list->lRecCount < $rescomp_fs_view_list->lStopRec) {
	$rescomp_fs_view_list->lRecCount++;
	if (intval($rescomp_fs_view_list->lRecCount) >= intval($rescomp_fs_view_list->lStartRec)) {
		$rescomp_fs_view_list->lRowCnt++;

	// Init row class and style
	$rescomp_fs_view->CssClass = "";
	$rescomp_fs_view->CssStyle = "";
	$rescomp_fs_view->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($rescomp_fs_view->CurrentAction == "gridadd") {
		$rescomp_fs_view_list->LoadDefaultValues(); // Load default values
	} else {
		$rescomp_fs_view_list->LoadRowValues($rs); // Load row values
	}
	$rescomp_fs_view->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$rescomp_fs_view_list->RenderRow();

	// Render list options
	$rescomp_fs_view_list->RenderListOptions();
?>
	<tr<?php echo $rescomp_fs_view->RowAttributes() ?>>
<?php

// Render list options (body, left)
$rescomp_fs_view_list->ListOptions->Render("body", "left");
?>
	<?php if ($rescomp_fs_view->mount->Visible) { // mount ?>
		<td<?php echo $rescomp_fs_view->mount->CellAttributes() ?>>
<div<?php echo $rescomp_fs_view->mount->ViewAttributes() ?>><?php echo $rescomp_fs_view->mount->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($rescomp_fs_view->path->Visible) { // path ?>
		<td<?php echo $rescomp_fs_view->path->CellAttributes() ?>>
<div<?php echo $rescomp_fs_view->path->ViewAttributes() ?>><?php echo $rescomp_fs_view->path->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($rescomp_fs_view->rescomp->Visible) { // rescomp ?>
		<td<?php echo $rescomp_fs_view->rescomp->CellAttributes() ?>>
<div<?php echo $rescomp_fs_view->rescomp->ViewAttributes() ?>><?php echo $rescomp_fs_view->rescomp->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$rescomp_fs_view_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($rescomp_fs_view->CurrentAction <> "gridadd")
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
<?php if ($rescomp_fs_view->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($rescomp_fs_view->CurrentAction <> "gridadd" && $rescomp_fs_view->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($rescomp_fs_view_list->Pager)) $rescomp_fs_view_list->Pager = new cPrevNextPager($rescomp_fs_view_list->lStartRec, $rescomp_fs_view_list->lDisplayRecs, $rescomp_fs_view_list->lTotalRecs) ?>
<?php if ($rescomp_fs_view_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($rescomp_fs_view_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $rescomp_fs_view_list->PageUrl() ?>start=<?php echo $rescomp_fs_view_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($rescomp_fs_view_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $rescomp_fs_view_list->PageUrl() ?>start=<?php echo $rescomp_fs_view_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $rescomp_fs_view_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($rescomp_fs_view_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $rescomp_fs_view_list->PageUrl() ?>start=<?php echo $rescomp_fs_view_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($rescomp_fs_view_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $rescomp_fs_view_list->PageUrl() ?>start=<?php echo $rescomp_fs_view_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $rescomp_fs_view_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $rescomp_fs_view_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $rescomp_fs_view_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $rescomp_fs_view_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($rescomp_fs_view_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($rescomp_fs_view_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($rescomp_fs_view->Export == "" && $rescomp_fs_view->CurrentAction == "") { ?>
<?php } ?>
<?php if ($rescomp_fs_view->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$rescomp_fs_view_list->Page_Terminate();
?>
<?php

//
// Page class
//
class crescomp_fs_view_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'rescomp_fs_view';

	// Page object name
	var $PageObjName = 'rescomp_fs_view_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $rescomp_fs_view;
		if ($rescomp_fs_view->UseTokenInUrl) $PageUrl .= "t=" . $rescomp_fs_view->TableVar . "&"; // Add page token
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
		global $objForm, $rescomp_fs_view;
		if ($rescomp_fs_view->UseTokenInUrl) {
			if ($objForm)
				return ($rescomp_fs_view->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($rescomp_fs_view->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crescomp_fs_view_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (rescomp_fs_view)
		$GLOBALS["rescomp_fs_view"] = new crescomp_fs_view();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["rescomp_fs_view"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "rescomp_fs_viewdelete.php";
		$this->MultiUpdateUrl = "rescomp_fs_viewupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rescomp_fs_view', TRUE);

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
		global $rescomp_fs_view;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$rescomp_fs_view->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$rescomp_fs_view->Export = $_POST["exporttype"];
		} else {
			$rescomp_fs_view->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $rescomp_fs_view->Export; // Get export parameter, used in header
		$gsExportFile = $rescomp_fs_view->TableVar; // Get export file, used in header

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
		global $objForm, $Language, $gsSearchError, $Security, $rescomp_fs_view;

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
			$rescomp_fs_view->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($rescomp_fs_view->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $rescomp_fs_view->getRecordsPerPage(); // Restore from Session
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
		$rescomp_fs_view->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$rescomp_fs_view->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$rescomp_fs_view->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $rescomp_fs_view->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$rescomp_fs_view->setSessionWhere($sFilter);
		$rescomp_fs_view->CurrentFilter = "";
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $rescomp_fs_view;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $rescomp_fs_view->mount, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $rescomp_fs_view->path, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $rescomp_fs_view->rescomp, $Keyword);
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
		global $Security, $rescomp_fs_view;
		$sSearchStr = "";
		$sSearchKeyword = $rescomp_fs_view->BasicSearchKeyword;
		$sSearchType = $rescomp_fs_view->BasicSearchType;
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
			$rescomp_fs_view->setSessionBasicSearchKeyword($sSearchKeyword);
			$rescomp_fs_view->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $rescomp_fs_view;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$rescomp_fs_view->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $rescomp_fs_view;
		$rescomp_fs_view->setSessionBasicSearchKeyword("");
		$rescomp_fs_view->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $rescomp_fs_view;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$rescomp_fs_view->BasicSearchKeyword = $rescomp_fs_view->getSessionBasicSearchKeyword();
			$rescomp_fs_view->BasicSearchType = $rescomp_fs_view->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $rescomp_fs_view;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$rescomp_fs_view->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$rescomp_fs_view->CurrentOrderType = @$_GET["ordertype"];
			$rescomp_fs_view->UpdateSort($rescomp_fs_view->mount); // mount
			$rescomp_fs_view->UpdateSort($rescomp_fs_view->path); // path
			$rescomp_fs_view->UpdateSort($rescomp_fs_view->rescomp); // rescomp
			$rescomp_fs_view->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $rescomp_fs_view;
		$sOrderBy = $rescomp_fs_view->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($rescomp_fs_view->SqlOrderBy() <> "") {
				$sOrderBy = $rescomp_fs_view->SqlOrderBy();
				$rescomp_fs_view->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $rescomp_fs_view;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$rescomp_fs_view->setSessionOrderBy($sOrderBy);
				$rescomp_fs_view->mount->setSort("");
				$rescomp_fs_view->path->setSort("");
				$rescomp_fs_view->rescomp->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$rescomp_fs_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $rescomp_fs_view;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($rescomp_fs_view->Export <> "" ||
			$rescomp_fs_view->CurrentAction == "gridadd" ||
			$rescomp_fs_view->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $rescomp_fs_view;
		$this->ListOptions->LoadDefault();
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $rescomp_fs_view;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $rescomp_fs_view;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$rescomp_fs_view->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$rescomp_fs_view->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $rescomp_fs_view->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$rescomp_fs_view->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$rescomp_fs_view->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$rescomp_fs_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $rescomp_fs_view;
		$rescomp_fs_view->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$rescomp_fs_view->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $rescomp_fs_view;

		// Call Recordset Selecting event
		$rescomp_fs_view->Recordset_Selecting($rescomp_fs_view->CurrentFilter);

		// Load List page SQL
		$sSql = $rescomp_fs_view->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$rescomp_fs_view->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $rescomp_fs_view;
		$sFilter = $rescomp_fs_view->KeyFilter();

		// Call Row Selecting event
		$rescomp_fs_view->Row_Selecting($sFilter);

		// Load SQL based on filter
		$rescomp_fs_view->CurrentFilter = $sFilter;
		$sSql = $rescomp_fs_view->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$rescomp_fs_view->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $rescomp_fs_view;
		$rescomp_fs_view->mount->setDbValue($rs->fields('mount'));
		$rescomp_fs_view->path->setDbValue($rs->fields('path'));
		$rescomp_fs_view->rescomp->setDbValue($rs->fields('rescomp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $rescomp_fs_view;

		// Initialize URLs
		$this->ViewUrl = $rescomp_fs_view->ViewUrl();
		$this->EditUrl = $rescomp_fs_view->EditUrl();
		$this->InlineEditUrl = $rescomp_fs_view->InlineEditUrl();
		$this->CopyUrl = $rescomp_fs_view->CopyUrl();
		$this->InlineCopyUrl = $rescomp_fs_view->InlineCopyUrl();
		$this->DeleteUrl = $rescomp_fs_view->DeleteUrl();

		// Call Row_Rendering event
		$rescomp_fs_view->Row_Rendering();

		// Common render codes for all row types
		// mount

		$rescomp_fs_view->mount->CellCssStyle = ""; $rescomp_fs_view->mount->CellCssClass = "";
		$rescomp_fs_view->mount->CellAttrs = array(); $rescomp_fs_view->mount->ViewAttrs = array(); $rescomp_fs_view->mount->EditAttrs = array();

		// path
		$rescomp_fs_view->path->CellCssStyle = ""; $rescomp_fs_view->path->CellCssClass = "";
		$rescomp_fs_view->path->CellAttrs = array(); $rescomp_fs_view->path->ViewAttrs = array(); $rescomp_fs_view->path->EditAttrs = array();

		// rescomp
		$rescomp_fs_view->rescomp->CellCssStyle = ""; $rescomp_fs_view->rescomp->CellCssClass = "";
		$rescomp_fs_view->rescomp->CellAttrs = array(); $rescomp_fs_view->rescomp->ViewAttrs = array(); $rescomp_fs_view->rescomp->EditAttrs = array();
		if ($rescomp_fs_view->RowType == EW_ROWTYPE_VIEW) { // View row

			// mount
			$rescomp_fs_view->mount->ViewValue = $rescomp_fs_view->mount->CurrentValue;
			$rescomp_fs_view->mount->CssStyle = "";
			$rescomp_fs_view->mount->CssClass = "";
			$rescomp_fs_view->mount->ViewCustomAttributes = "";

			// path
			$rescomp_fs_view->path->ViewValue = $rescomp_fs_view->path->CurrentValue;
			$rescomp_fs_view->path->CssStyle = "";
			$rescomp_fs_view->path->CssClass = "";
			$rescomp_fs_view->path->ViewCustomAttributes = "";

			// rescomp
			$rescomp_fs_view->rescomp->ViewValue = $rescomp_fs_view->rescomp->CurrentValue;
			$rescomp_fs_view->rescomp->CssStyle = "";
			$rescomp_fs_view->rescomp->CssClass = "";
			$rescomp_fs_view->rescomp->ViewCustomAttributes = "";

			// mount
			$rescomp_fs_view->mount->HrefValue = "";
			$rescomp_fs_view->mount->TooltipValue = "";

			// path
			$rescomp_fs_view->path->HrefValue = "";
			$rescomp_fs_view->path->TooltipValue = "";

			// rescomp
			$rescomp_fs_view->rescomp->HrefValue = "";
			$rescomp_fs_view->rescomp->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($rescomp_fs_view->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$rescomp_fs_view->Row_Rendered();
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
