<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_acctinfo.php" ?>
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
$lsf_acct_list = new clsf_acct_list();
$Page =& $lsf_acct_list;

// Page init processing
$lsf_acct_list->Page_Init();

// Page main processing
$lsf_acct_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lsf_acct->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_acct_list = new ew_Page("lsf_acct_list");

// page properties
lsf_acct_list.PageID = "list"; // page ID
var EW_PAGE_ID = lsf_acct_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_acct_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_acct_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_acct_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($lsf_acct->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($lsf_acct->Export == "" && $lsf_acct->SelectLimit);
	if (!$bSelectLimit)
		$rs = $lsf_acct_list->LoadRecordset();
	$lsf_acct_list->lTotalRecs = ($bSelectLimit) ? $lsf_acct->SelectRecordCount() : $rs->RecordCount();
	$lsf_acct_list->lStartRec = 1;
	if ($lsf_acct_list->lDisplayRecs <= 0) // Display all records
		$lsf_acct_list->lDisplayRecs = $lsf_acct_list->lTotalRecs;
	if (!($lsf_acct->ExportAll && $lsf_acct->Export <> ""))
		$lsf_acct_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $lsf_acct_list->LoadRecordset($lsf_acct_list->lStartRec-1, $lsf_acct_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Lsf Acct
</span></p>
<?php $lsf_acct_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="flsf_acctlist" id="flsf_acctlist" class="ewForm" action="" method="post">
<?php if ($lsf_acct_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$lsf_acct_list->lOptionCnt = 0;
	$lsf_acct_list->lOptionCnt += count($lsf_acct_list->ListOptions->Items); // Custom list options
?>
<?php echo $lsf_acct->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($lsf_acct->date->Visible) { // date ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->date) == "") { ?>
		<td>Date</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->date) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Date</td><td style="width: 10px;"><?php if ($lsf_acct->date->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->date->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->uid->Visible) { // uid ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->uid) == "") { ?>
		<td>Uid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->uid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Uid</td><td style="width: 10px;"><?php if ($lsf_acct->uid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->uid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->qid->Visible) { // qid ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->qid) == "") { ?>
		<td>Qid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->qid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Qid</td><td style="width: 10px;"><?php if ($lsf_acct->qid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->qid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->pid->Visible) { // pid ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->pid) == "") { ?>
		<td>Pid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->pid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Pid</td><td style="width: 10px;"><?php if ($lsf_acct->pid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->pid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->cpu->Visible) { // cpu ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->cpu) == "") { ?>
		<td>Cpu</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->cpu) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cpu</td><td style="width: 10px;"><?php if ($lsf_acct->cpu->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->cpu->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->mem->Visible) { // mem ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->mem) == "") { ?>
		<td>Mem</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->mem) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Mem</td><td style="width: 10px;"><?php if ($lsf_acct->mem->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->mem->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->swap->Visible) { // swap ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->swap) == "") { ?>
		<td>Swap</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->swap) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Swap</td><td style="width: 10px;"><?php if ($lsf_acct->swap->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->swap->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->run->Visible) { // run ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->run) == "") { ?>
		<td>Run</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->run) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Run</td><td style="width: 10px;"><?php if ($lsf_acct->run->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->run->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->pend->Visible) { // pend ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->pend) == "") { ?>
		<td>Pend</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->pend) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Pend</td><td style="width: 10px;"><?php if ($lsf_acct->pend->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->pend->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->success->Visible) { // success ?>
	<?php if ($lsf_acct->SortUrl($lsf_acct->success) == "") { ?>
		<td>Success</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_acct->SortUrl($lsf_acct->success) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Success</td><td style="width: 10px;"><?php if ($lsf_acct->success->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_acct->success->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_acct->Export == "") { ?>
<?php

// Custom list options
foreach ($lsf_acct_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($lsf_acct->ExportAll && $lsf_acct->Export <> "") {
	$lsf_acct_list->lStopRec = $lsf_acct_list->lTotalRecs;
} else {
	$lsf_acct_list->lStopRec = $lsf_acct_list->lStartRec + $lsf_acct_list->lDisplayRecs - 1; // Set the last record to display
}
$lsf_acct_list->lRecCount = $lsf_acct_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$lsf_acct->SelectLimit && $lsf_acct_list->lStartRec > 1)
		$rs->Move($lsf_acct_list->lStartRec - 1);
}
$lsf_acct_list->lRowCnt = 0;
while (($lsf_acct->CurrentAction == "gridadd" || !$rs->EOF) &&
	$lsf_acct_list->lRecCount < $lsf_acct_list->lStopRec) {
	$lsf_acct_list->lRecCount++;
	if (intval($lsf_acct_list->lRecCount) >= intval($lsf_acct_list->lStartRec)) {
		$lsf_acct_list->lRowCnt++;

	// Init row class and style
	$lsf_acct->CssClass = "";
	$lsf_acct->CssStyle = "";
	$lsf_acct->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($lsf_acct->CurrentAction == "gridadd") {
		$lsf_acct_list->LoadDefaultValues(); // Load default values
	} else {
		$lsf_acct_list->LoadRowValues($rs); // Load row values
	}
	$lsf_acct->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$lsf_acct_list->RenderRow();
?>
	<tr<?php echo $lsf_acct->RowAttributes() ?>>
	<?php if ($lsf_acct->date->Visible) { // date ?>
		<td<?php echo $lsf_acct->date->CellAttributes() ?>>
<div<?php echo $lsf_acct->date->ViewAttributes() ?>><?php echo $lsf_acct->date->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->uid->Visible) { // uid ?>
		<td<?php echo $lsf_acct->uid->CellAttributes() ?>>
<div<?php echo $lsf_acct->uid->ViewAttributes() ?>><?php echo $lsf_acct->uid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->qid->Visible) { // qid ?>
		<td<?php echo $lsf_acct->qid->CellAttributes() ?>>
<div<?php echo $lsf_acct->qid->ViewAttributes() ?>><?php echo $lsf_acct->qid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->pid->Visible) { // pid ?>
		<td<?php echo $lsf_acct->pid->CellAttributes() ?>>
<div<?php echo $lsf_acct->pid->ViewAttributes() ?>><?php echo $lsf_acct->pid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->cpu->Visible) { // cpu ?>
		<td<?php echo $lsf_acct->cpu->CellAttributes() ?>>
<div<?php echo $lsf_acct->cpu->ViewAttributes() ?>><?php echo $lsf_acct->cpu->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->mem->Visible) { // mem ?>
		<td<?php echo $lsf_acct->mem->CellAttributes() ?>>
<div<?php echo $lsf_acct->mem->ViewAttributes() ?>><?php echo $lsf_acct->mem->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->swap->Visible) { // swap ?>
		<td<?php echo $lsf_acct->swap->CellAttributes() ?>>
<div<?php echo $lsf_acct->swap->ViewAttributes() ?>><?php echo $lsf_acct->swap->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->run->Visible) { // run ?>
		<td<?php echo $lsf_acct->run->CellAttributes() ?>>
<div<?php echo $lsf_acct->run->ViewAttributes() ?>><?php echo $lsf_acct->run->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->pend->Visible) { // pend ?>
		<td<?php echo $lsf_acct->pend->CellAttributes() ?>>
<div<?php echo $lsf_acct->pend->ViewAttributes() ?>><?php echo $lsf_acct->pend->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($lsf_acct->success->Visible) { // success ?>
		<td<?php echo $lsf_acct->success->CellAttributes() ?>>
<div<?php echo $lsf_acct->success->ViewAttributes() ?>><?php echo $lsf_acct->success->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($lsf_acct->Export == "") { ?>
<?php

// Custom list options
foreach ($lsf_acct_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($lsf_acct->CurrentAction <> "gridadd")
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
<?php if ($lsf_acct->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($lsf_acct->CurrentAction <> "gridadd" && $lsf_acct->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($lsf_acct_list->Pager)) $lsf_acct_list->Pager = new cPrevNextPager($lsf_acct_list->lStartRec, $lsf_acct_list->lDisplayRecs, $lsf_acct_list->lTotalRecs) ?>
<?php if ($lsf_acct_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($lsf_acct_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_acct_list->PageUrl() ?>start=<?php echo $lsf_acct_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($lsf_acct_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_acct_list->PageUrl() ?>start=<?php echo $lsf_acct_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $lsf_acct_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($lsf_acct_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_acct_list->PageUrl() ?>start=<?php echo $lsf_acct_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($lsf_acct_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_acct_list->PageUrl() ?>start=<?php echo $lsf_acct_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $lsf_acct_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $lsf_acct_list->Pager->FromIndex ?> to <?php echo $lsf_acct_list->Pager->ToIndex ?> of <?php echo $lsf_acct_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($lsf_acct_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($lsf_acct_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($lsf_acct->Export == "" && $lsf_acct->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(lsf_acct_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($lsf_acct->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lsf_acct_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_acct_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'lsf_acct';

	// Page Object Name
	var $PageObjName = 'lsf_acct_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_acct;
		if ($lsf_acct->UseTokenInUrl) $PageUrl .= "t=" . $lsf_acct->TableVar . "&"; // add page token
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
		global $objForm, $lsf_acct;
		if ($lsf_acct->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_acct->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_acct->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_acct_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_acct"] = new clsf_acct();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_acct', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_acct;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$lsf_acct->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $lsf_acct->Export; // Get export parameter, used in header
	$gsExportFile = $lsf_acct->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $lsf_acct;
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
		if ($lsf_acct->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $lsf_acct->getRecordsPerPage(); // Restore from Session
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
		$lsf_acct->setSessionWhere($sFilter);
		$lsf_acct->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $lsf_acct;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$lsf_acct->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$lsf_acct->CurrentOrderType = @$_GET["ordertype"];
			$lsf_acct->UpdateSort($lsf_acct->date); // Field 
			$lsf_acct->UpdateSort($lsf_acct->uid); // Field 
			$lsf_acct->UpdateSort($lsf_acct->qid); // Field 
			$lsf_acct->UpdateSort($lsf_acct->pid); // Field 
			$lsf_acct->UpdateSort($lsf_acct->cpu); // Field 
			$lsf_acct->UpdateSort($lsf_acct->mem); // Field 
			$lsf_acct->UpdateSort($lsf_acct->swap); // Field 
			$lsf_acct->UpdateSort($lsf_acct->run); // Field 
			$lsf_acct->UpdateSort($lsf_acct->pend); // Field 
			$lsf_acct->UpdateSort($lsf_acct->success); // Field 
			$lsf_acct->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $lsf_acct;
		$sOrderBy = $lsf_acct->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($lsf_acct->SqlOrderBy() <> "") {
				$sOrderBy = $lsf_acct->SqlOrderBy();
				$lsf_acct->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $lsf_acct;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$lsf_acct->setSessionOrderBy($sOrderBy);
				$lsf_acct->date->setSort("");
				$lsf_acct->uid->setSort("");
				$lsf_acct->qid->setSort("");
				$lsf_acct->pid->setSort("");
				$lsf_acct->cpu->setSort("");
				$lsf_acct->mem->setSort("");
				$lsf_acct->swap->setSort("");
				$lsf_acct->run->setSort("");
				$lsf_acct->pend->setSort("");
				$lsf_acct->success->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$lsf_acct->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $lsf_acct;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lsf_acct->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lsf_acct->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lsf_acct->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lsf_acct->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lsf_acct->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lsf_acct->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $lsf_acct;

		// Call Recordset Selecting event
		$lsf_acct->Recordset_Selecting($lsf_acct->CurrentFilter);

		// Load list page SQL
		$sSql = $lsf_acct->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$lsf_acct->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_acct;
		$sFilter = $lsf_acct->KeyFilter();

		// Call Row Selecting event
		$lsf_acct->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_acct->CurrentFilter = $sFilter;
		$sSql = $lsf_acct->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_acct->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_acct;
		$lsf_acct->date->setDbValue($rs->fields('date'));
		$lsf_acct->uid->setDbValue($rs->fields('uid'));
		$lsf_acct->qid->setDbValue($rs->fields('qid'));
		$lsf_acct->pid->setDbValue($rs->fields('pid'));
		$lsf_acct->cpu->setDbValue($rs->fields('cpu'));
		$lsf_acct->mem->setDbValue($rs->fields('mem'));
		$lsf_acct->swap->setDbValue($rs->fields('swap'));
		$lsf_acct->run->setDbValue($rs->fields('run'));
		$lsf_acct->pend->setDbValue($rs->fields('pend'));
		$lsf_acct->success->setDbValue($rs->fields('success'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_acct;

		// Call Row_Rendering event
		$lsf_acct->Row_Rendering();

		// Common render codes for all row types
		// date

		$lsf_acct->date->CellCssStyle = "";
		$lsf_acct->date->CellCssClass = "";

		// uid
		$lsf_acct->uid->CellCssStyle = "";
		$lsf_acct->uid->CellCssClass = "";

		// qid
		$lsf_acct->qid->CellCssStyle = "";
		$lsf_acct->qid->CellCssClass = "";

		// pid
		$lsf_acct->pid->CellCssStyle = "";
		$lsf_acct->pid->CellCssClass = "";

		// cpu
		$lsf_acct->cpu->CellCssStyle = "";
		$lsf_acct->cpu->CellCssClass = "";

		// mem
		$lsf_acct->mem->CellCssStyle = "";
		$lsf_acct->mem->CellCssClass = "";

		// swap
		$lsf_acct->swap->CellCssStyle = "";
		$lsf_acct->swap->CellCssClass = "";

		// run
		$lsf_acct->run->CellCssStyle = "";
		$lsf_acct->run->CellCssClass = "";

		// pend
		$lsf_acct->pend->CellCssStyle = "";
		$lsf_acct->pend->CellCssClass = "";

		// success
		$lsf_acct->success->CellCssStyle = "";
		$lsf_acct->success->CellCssClass = "";
		if ($lsf_acct->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$lsf_acct->date->ViewValue = $lsf_acct->date->CurrentValue;
			$lsf_acct->date->CssStyle = "";
			$lsf_acct->date->CssClass = "";
			$lsf_acct->date->ViewCustomAttributes = "";

			// uid
			$lsf_acct->uid->ViewValue = $lsf_acct->uid->CurrentValue;
			$lsf_acct->uid->CssStyle = "";
			$lsf_acct->uid->CssClass = "";
			$lsf_acct->uid->ViewCustomAttributes = "";

			// qid
			$lsf_acct->qid->ViewValue = $lsf_acct->qid->CurrentValue;
			$lsf_acct->qid->CssStyle = "";
			$lsf_acct->qid->CssClass = "";
			$lsf_acct->qid->ViewCustomAttributes = "";

			// pid
			$lsf_acct->pid->ViewValue = $lsf_acct->pid->CurrentValue;
			$lsf_acct->pid->CssStyle = "";
			$lsf_acct->pid->CssClass = "";
			$lsf_acct->pid->ViewCustomAttributes = "";

			// cpu
			$lsf_acct->cpu->ViewValue = $lsf_acct->cpu->CurrentValue;
			$lsf_acct->cpu->CssStyle = "";
			$lsf_acct->cpu->CssClass = "";
			$lsf_acct->cpu->ViewCustomAttributes = "";

			// mem
			$lsf_acct->mem->ViewValue = $lsf_acct->mem->CurrentValue;
			$lsf_acct->mem->CssStyle = "";
			$lsf_acct->mem->CssClass = "";
			$lsf_acct->mem->ViewCustomAttributes = "";

			// swap
			$lsf_acct->swap->ViewValue = $lsf_acct->swap->CurrentValue;
			$lsf_acct->swap->CssStyle = "";
			$lsf_acct->swap->CssClass = "";
			$lsf_acct->swap->ViewCustomAttributes = "";

			// run
			$lsf_acct->run->ViewValue = $lsf_acct->run->CurrentValue;
			$lsf_acct->run->CssStyle = "";
			$lsf_acct->run->CssClass = "";
			$lsf_acct->run->ViewCustomAttributes = "";

			// pend
			$lsf_acct->pend->ViewValue = $lsf_acct->pend->CurrentValue;
			$lsf_acct->pend->CssStyle = "";
			$lsf_acct->pend->CssClass = "";
			$lsf_acct->pend->ViewCustomAttributes = "";

			// success
			$lsf_acct->success->ViewValue = $lsf_acct->success->CurrentValue;
			$lsf_acct->success->CssStyle = "";
			$lsf_acct->success->CssClass = "";
			$lsf_acct->success->ViewCustomAttributes = "";

			// date
			$lsf_acct->date->HrefValue = "";

			// uid
			$lsf_acct->uid->HrefValue = "";

			// qid
			$lsf_acct->qid->HrefValue = "";

			// pid
			$lsf_acct->pid->HrefValue = "";

			// cpu
			$lsf_acct->cpu->HrefValue = "";

			// mem
			$lsf_acct->mem->HrefValue = "";

			// swap
			$lsf_acct->swap->HrefValue = "";

			// run
			$lsf_acct->run->HrefValue = "";

			// pend
			$lsf_acct->pend->HrefValue = "";

			// success
			$lsf_acct->success->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_acct->Row_Rendered();
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
