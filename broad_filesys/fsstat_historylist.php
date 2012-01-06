<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "fsstat_historyinfo.php" ?>
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
$fsstat_history_list = new cfsstat_history_list();
$Page =& $fsstat_history_list;

// Page init processing
$fsstat_history_list->Page_Init();

// Page main processing
$fsstat_history_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($fsstat_history->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var fsstat_history_list = new ew_Page("fsstat_history_list");

// page properties
fsstat_history_list.PageID = "list"; // page ID
var EW_PAGE_ID = fsstat_history_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
fsstat_history_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
fsstat_history_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fsstat_history_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($fsstat_history->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($fsstat_history->Export == "" && $fsstat_history->SelectLimit);
	if (!$bSelectLimit)
		$rs = $fsstat_history_list->LoadRecordset();
	$fsstat_history_list->lTotalRecs = ($bSelectLimit) ? $fsstat_history->SelectRecordCount() : $rs->RecordCount();
	$fsstat_history_list->lStartRec = 1;
	if ($fsstat_history_list->lDisplayRecs <= 0) // Display all records
		$fsstat_history_list->lDisplayRecs = $fsstat_history_list->lTotalRecs;
	if (!($fsstat_history->ExportAll && $fsstat_history->Export <> ""))
		$fsstat_history_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $fsstat_history_list->LoadRecordset($fsstat_history_list->lStartRec-1, $fsstat_history_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Fsstat History
</span></p>
<?php $fsstat_history_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="ffsstat_historylist" id="ffsstat_historylist" class="ewForm" action="" method="post">
<?php if ($fsstat_history_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$fsstat_history_list->lOptionCnt = 0;
	$fsstat_history_list->lOptionCnt += count($fsstat_history_list->ListOptions->Items); // Custom list options
?>
<?php echo $fsstat_history->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($fsstat_history->fsid->Visible) { // fsid ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->fsid) == "") { ?>
		<td>Fsid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->fsid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fsid</td><td style="width: 10px;"><?php if ($fsstat_history->fsid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->fsid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->dirid->Visible) { // dirid ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->dirid) == "") { ?>
		<td>Dirid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->dirid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Dirid</td><td style="width: 10px;"><?php if ($fsstat_history->dirid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->dirid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->checked->Visible) { // checked ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->checked) == "") { ?>
		<td>Checked</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->checked) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Checked</td><td style="width: 10px;"><?php if ($fsstat_history->checked->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->checked->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->latest->Visible) { // latest ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->latest) == "") { ?>
		<td>Latest</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->latest) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Latest</td><td style="width: 10px;"><?php if ($fsstat_history->latest->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->latest->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->uid->Visible) { // uid ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->uid) == "") { ?>
		<td>Uid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->uid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Uid</td><td style="width: 10px;"><?php if ($fsstat_history->uid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->uid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->type->Visible) { // type ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->type) == "") { ?>
		<td>Type</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Type</td><td style="width: 10px;"><?php if ($fsstat_history->type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->sumcnt->Visible) { // sumcnt ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->sumcnt) == "") { ?>
		<td>Sumcnt</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->sumcnt) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Sumcnt</td><td style="width: 10px;"><?php if ($fsstat_history->sumcnt->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->sumcnt->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->sumval->Visible) { // sumval ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->sumval) == "") { ?>
		<td>Sumval</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->sumval) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Sumval</td><td style="width: 10px;"><?php if ($fsstat_history->sumval->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->sumval->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->maxcnt->Visible) { // maxcnt ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->maxcnt) == "") { ?>
		<td>Maxcnt</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->maxcnt) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Maxcnt</td><td style="width: 10px;"><?php if ($fsstat_history->maxcnt->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->maxcnt->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->maxval->Visible) { // maxval ?>
	<?php if ($fsstat_history->SortUrl($fsstat_history->maxval) == "") { ?>
		<td>Maxval</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsstat_history->SortUrl($fsstat_history->maxval) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Maxval</td><td style="width: 10px;"><?php if ($fsstat_history->maxval->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsstat_history->maxval->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsstat_history->Export == "") { ?>
<?php

// Custom list options
foreach ($fsstat_history_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($fsstat_history->ExportAll && $fsstat_history->Export <> "") {
	$fsstat_history_list->lStopRec = $fsstat_history_list->lTotalRecs;
} else {
	$fsstat_history_list->lStopRec = $fsstat_history_list->lStartRec + $fsstat_history_list->lDisplayRecs - 1; // Set the last record to display
}
$fsstat_history_list->lRecCount = $fsstat_history_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$fsstat_history->SelectLimit && $fsstat_history_list->lStartRec > 1)
		$rs->Move($fsstat_history_list->lStartRec - 1);
}
$fsstat_history_list->lRowCnt = 0;
while (($fsstat_history->CurrentAction == "gridadd" || !$rs->EOF) &&
	$fsstat_history_list->lRecCount < $fsstat_history_list->lStopRec) {
	$fsstat_history_list->lRecCount++;
	if (intval($fsstat_history_list->lRecCount) >= intval($fsstat_history_list->lStartRec)) {
		$fsstat_history_list->lRowCnt++;

	// Init row class and style
	$fsstat_history->CssClass = "";
	$fsstat_history->CssStyle = "";
	$fsstat_history->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($fsstat_history->CurrentAction == "gridadd") {
		$fsstat_history_list->LoadDefaultValues(); // Load default values
	} else {
		$fsstat_history_list->LoadRowValues($rs); // Load row values
	}
	$fsstat_history->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$fsstat_history_list->RenderRow();
?>
	<tr<?php echo $fsstat_history->RowAttributes() ?>>
	<?php if ($fsstat_history->fsid->Visible) { // fsid ?>
		<td<?php echo $fsstat_history->fsid->CellAttributes() ?>>
<div<?php echo $fsstat_history->fsid->ViewAttributes() ?>><?php echo $fsstat_history->fsid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->dirid->Visible) { // dirid ?>
		<td<?php echo $fsstat_history->dirid->CellAttributes() ?>>
<div<?php echo $fsstat_history->dirid->ViewAttributes() ?>><?php echo $fsstat_history->dirid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->checked->Visible) { // checked ?>
		<td<?php echo $fsstat_history->checked->CellAttributes() ?>>
<div<?php echo $fsstat_history->checked->ViewAttributes() ?>><?php echo $fsstat_history->checked->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->latest->Visible) { // latest ?>
		<td<?php echo $fsstat_history->latest->CellAttributes() ?>>
<div<?php echo $fsstat_history->latest->ViewAttributes() ?>><?php echo $fsstat_history->latest->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->uid->Visible) { // uid ?>
		<td<?php echo $fsstat_history->uid->CellAttributes() ?>>
<div<?php echo $fsstat_history->uid->ViewAttributes() ?>><?php echo $fsstat_history->uid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->type->Visible) { // type ?>
		<td<?php echo $fsstat_history->type->CellAttributes() ?>>
<div<?php echo $fsstat_history->type->ViewAttributes() ?>><?php echo $fsstat_history->type->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->sumcnt->Visible) { // sumcnt ?>
		<td<?php echo $fsstat_history->sumcnt->CellAttributes() ?>>
<div<?php echo $fsstat_history->sumcnt->ViewAttributes() ?>><?php echo $fsstat_history->sumcnt->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->sumval->Visible) { // sumval ?>
		<td<?php echo $fsstat_history->sumval->CellAttributes() ?>>
<div<?php echo $fsstat_history->sumval->ViewAttributes() ?>><?php echo $fsstat_history->sumval->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->maxcnt->Visible) { // maxcnt ?>
		<td<?php echo $fsstat_history->maxcnt->CellAttributes() ?>>
<div<?php echo $fsstat_history->maxcnt->ViewAttributes() ?>><?php echo $fsstat_history->maxcnt->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsstat_history->maxval->Visible) { // maxval ?>
		<td<?php echo $fsstat_history->maxval->CellAttributes() ?>>
<div<?php echo $fsstat_history->maxval->ViewAttributes() ?>><?php echo $fsstat_history->maxval->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($fsstat_history->Export == "") { ?>
<?php

// Custom list options
foreach ($fsstat_history_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($fsstat_history->CurrentAction <> "gridadd")
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
<?php if ($fsstat_history->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($fsstat_history->CurrentAction <> "gridadd" && $fsstat_history->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($fsstat_history_list->Pager)) $fsstat_history_list->Pager = new cPrevNextPager($fsstat_history_list->lStartRec, $fsstat_history_list->lDisplayRecs, $fsstat_history_list->lTotalRecs) ?>
<?php if ($fsstat_history_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($fsstat_history_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $fsstat_history_list->PageUrl() ?>start=<?php echo $fsstat_history_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($fsstat_history_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $fsstat_history_list->PageUrl() ?>start=<?php echo $fsstat_history_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $fsstat_history_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($fsstat_history_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $fsstat_history_list->PageUrl() ?>start=<?php echo $fsstat_history_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($fsstat_history_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $fsstat_history_list->PageUrl() ?>start=<?php echo $fsstat_history_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $fsstat_history_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $fsstat_history_list->Pager->FromIndex ?> to <?php echo $fsstat_history_list->Pager->ToIndex ?> of <?php echo $fsstat_history_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($fsstat_history_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($fsstat_history_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($fsstat_history->Export == "" && $fsstat_history->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(fsstat_history_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($fsstat_history->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$fsstat_history_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cfsstat_history_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'fsstat_history';

	// Page Object Name
	var $PageObjName = 'fsstat_history_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $fsstat_history;
		if ($fsstat_history->UseTokenInUrl) $PageUrl .= "t=" . $fsstat_history->TableVar . "&"; // add page token
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
		global $objForm, $fsstat_history;
		if ($fsstat_history->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($fsstat_history->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($fsstat_history->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cfsstat_history_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["fsstat_history"] = new cfsstat_history();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fsstat_history', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $fsstat_history;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$fsstat_history->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $fsstat_history->Export; // Get export parameter, used in header
	$gsExportFile = $fsstat_history->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $fsstat_history;
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
		if ($fsstat_history->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $fsstat_history->getRecordsPerPage(); // Restore from Session
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
		$fsstat_history->setSessionWhere($sFilter);
		$fsstat_history->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $fsstat_history;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$fsstat_history->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$fsstat_history->CurrentOrderType = @$_GET["ordertype"];
			$fsstat_history->UpdateSort($fsstat_history->fsid); // Field 
			$fsstat_history->UpdateSort($fsstat_history->dirid); // Field 
			$fsstat_history->UpdateSort($fsstat_history->checked); // Field 
			$fsstat_history->UpdateSort($fsstat_history->latest); // Field 
			$fsstat_history->UpdateSort($fsstat_history->uid); // Field 
			$fsstat_history->UpdateSort($fsstat_history->type); // Field 
			$fsstat_history->UpdateSort($fsstat_history->sumcnt); // Field 
			$fsstat_history->UpdateSort($fsstat_history->sumval); // Field 
			$fsstat_history->UpdateSort($fsstat_history->maxcnt); // Field 
			$fsstat_history->UpdateSort($fsstat_history->maxval); // Field 
			$fsstat_history->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $fsstat_history;
		$sOrderBy = $fsstat_history->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($fsstat_history->SqlOrderBy() <> "") {
				$sOrderBy = $fsstat_history->SqlOrderBy();
				$fsstat_history->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $fsstat_history;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$fsstat_history->setSessionOrderBy($sOrderBy);
				$fsstat_history->fsid->setSort("");
				$fsstat_history->dirid->setSort("");
				$fsstat_history->checked->setSort("");
				$fsstat_history->latest->setSort("");
				$fsstat_history->uid->setSort("");
				$fsstat_history->type->setSort("");
				$fsstat_history->sumcnt->setSort("");
				$fsstat_history->sumval->setSort("");
				$fsstat_history->maxcnt->setSort("");
				$fsstat_history->maxval->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$fsstat_history->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $fsstat_history;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$fsstat_history->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$fsstat_history->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $fsstat_history->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$fsstat_history->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$fsstat_history->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$fsstat_history->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $fsstat_history;

		// Call Recordset Selecting event
		$fsstat_history->Recordset_Selecting($fsstat_history->CurrentFilter);

		// Load list page SQL
		$sSql = $fsstat_history->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$fsstat_history->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $fsstat_history;
		$sFilter = $fsstat_history->KeyFilter();

		// Call Row Selecting event
		$fsstat_history->Row_Selecting($sFilter);

		// Load sql based on filter
		$fsstat_history->CurrentFilter = $sFilter;
		$sSql = $fsstat_history->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$fsstat_history->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $fsstat_history;
		$fsstat_history->fsid->setDbValue($rs->fields('fsid'));
		$fsstat_history->dirid->setDbValue($rs->fields('dirid'));
		$fsstat_history->checked->setDbValue($rs->fields('checked'));
		$fsstat_history->latest->setDbValue($rs->fields('latest'));
		$fsstat_history->uid->setDbValue($rs->fields('uid'));
		$fsstat_history->type->setDbValue($rs->fields('type'));
		$fsstat_history->sumcnt->setDbValue($rs->fields('sumcnt'));
		$fsstat_history->sumval->setDbValue($rs->fields('sumval'));
		$fsstat_history->maxcnt->setDbValue($rs->fields('maxcnt'));
		$fsstat_history->maxval->setDbValue($rs->fields('maxval'));
		$fsstat_history->histogram->Upload->DbValue = $rs->fields('histogram');
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $fsstat_history;

		// Call Row_Rendering event
		$fsstat_history->Row_Rendering();

		// Common render codes for all row types
		// fsid

		$fsstat_history->fsid->CellCssStyle = "";
		$fsstat_history->fsid->CellCssClass = "";

		// dirid
		$fsstat_history->dirid->CellCssStyle = "";
		$fsstat_history->dirid->CellCssClass = "";

		// checked
		$fsstat_history->checked->CellCssStyle = "";
		$fsstat_history->checked->CellCssClass = "";

		// latest
		$fsstat_history->latest->CellCssStyle = "";
		$fsstat_history->latest->CellCssClass = "";

		// uid
		$fsstat_history->uid->CellCssStyle = "";
		$fsstat_history->uid->CellCssClass = "";

		// type
		$fsstat_history->type->CellCssStyle = "";
		$fsstat_history->type->CellCssClass = "";

		// sumcnt
		$fsstat_history->sumcnt->CellCssStyle = "";
		$fsstat_history->sumcnt->CellCssClass = "";

		// sumval
		$fsstat_history->sumval->CellCssStyle = "";
		$fsstat_history->sumval->CellCssClass = "";

		// maxcnt
		$fsstat_history->maxcnt->CellCssStyle = "";
		$fsstat_history->maxcnt->CellCssClass = "";

		// maxval
		$fsstat_history->maxval->CellCssStyle = "";
		$fsstat_history->maxval->CellCssClass = "";
		if ($fsstat_history->RowType == EW_ROWTYPE_VIEW) { // View row

			// fsid
			$fsstat_history->fsid->ViewValue = $fsstat_history->fsid->CurrentValue;
			$fsstat_history->fsid->CssStyle = "";
			$fsstat_history->fsid->CssClass = "";
			$fsstat_history->fsid->ViewCustomAttributes = "";

			// dirid
			$fsstat_history->dirid->ViewValue = $fsstat_history->dirid->CurrentValue;
			$fsstat_history->dirid->CssStyle = "";
			$fsstat_history->dirid->CssClass = "";
			$fsstat_history->dirid->ViewCustomAttributes = "";

			// checked
			$fsstat_history->checked->ViewValue = $fsstat_history->checked->CurrentValue;
			$fsstat_history->checked->CssStyle = "";
			$fsstat_history->checked->CssClass = "";
			$fsstat_history->checked->ViewCustomAttributes = "";

			// latest
			$fsstat_history->latest->ViewValue = $fsstat_history->latest->CurrentValue;
			$fsstat_history->latest->CssStyle = "";
			$fsstat_history->latest->CssClass = "";
			$fsstat_history->latest->ViewCustomAttributes = "";

			// uid
			$fsstat_history->uid->ViewValue = $fsstat_history->uid->CurrentValue;
			$fsstat_history->uid->CssStyle = "";
			$fsstat_history->uid->CssClass = "";
			$fsstat_history->uid->ViewCustomAttributes = "";

			// type
			$fsstat_history->type->ViewValue = $fsstat_history->type->CurrentValue;
			$fsstat_history->type->CssStyle = "";
			$fsstat_history->type->CssClass = "";
			$fsstat_history->type->ViewCustomAttributes = "";

			// sumcnt
			$fsstat_history->sumcnt->ViewValue = $fsstat_history->sumcnt->CurrentValue;
			$fsstat_history->sumcnt->CssStyle = "";
			$fsstat_history->sumcnt->CssClass = "";
			$fsstat_history->sumcnt->ViewCustomAttributes = "";

			// sumval
			$fsstat_history->sumval->ViewValue = $fsstat_history->sumval->CurrentValue;
			$fsstat_history->sumval->CssStyle = "";
			$fsstat_history->sumval->CssClass = "";
			$fsstat_history->sumval->ViewCustomAttributes = "";

			// maxcnt
			$fsstat_history->maxcnt->ViewValue = $fsstat_history->maxcnt->CurrentValue;
			$fsstat_history->maxcnt->CssStyle = "";
			$fsstat_history->maxcnt->CssClass = "";
			$fsstat_history->maxcnt->ViewCustomAttributes = "";

			// maxval
			$fsstat_history->maxval->ViewValue = $fsstat_history->maxval->CurrentValue;
			$fsstat_history->maxval->CssStyle = "";
			$fsstat_history->maxval->CssClass = "";
			$fsstat_history->maxval->ViewCustomAttributes = "";

			// fsid
			$fsstat_history->fsid->HrefValue = "";

			// dirid
			$fsstat_history->dirid->HrefValue = "";

			// checked
			$fsstat_history->checked->HrefValue = "";

			// latest
			$fsstat_history->latest->HrefValue = "";

			// uid
			$fsstat_history->uid->HrefValue = "";

			// type
			$fsstat_history->type->HrefValue = "";

			// sumcnt
			$fsstat_history->sumcnt->HrefValue = "";

			// sumval
			$fsstat_history->sumval->HrefValue = "";

			// maxcnt
			$fsstat_history->maxcnt->HrefValue = "";

			// maxval
			$fsstat_history->maxval->HrefValue = "";
		}

		// Call Row Rendered event
		$fsstat_history->Row_Rendered();
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
