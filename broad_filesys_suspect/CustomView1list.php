<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "CustomView1info.php" ?>
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
$CustomView1_list = new cCustomView1_list();
$Page =& $CustomView1_list;

// Page init processing
$CustomView1_list->Page_Init();

// Page main processing
$CustomView1_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($CustomView1->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var CustomView1_list = new ew_Page("CustomView1_list");

// page properties
CustomView1_list.PageID = "list"; // page ID
var EW_PAGE_ID = CustomView1_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
CustomView1_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
CustomView1_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
CustomView1_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($CustomView1->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($CustomView1->Export == "" && $CustomView1->SelectLimit);
	if (!$bSelectLimit)
		$rs = $CustomView1_list->LoadRecordset();
	$CustomView1_list->lTotalRecs = ($bSelectLimit) ? $CustomView1->SelectRecordCount() : $rs->RecordCount();
	$CustomView1_list->lStartRec = 1;
	if ($CustomView1_list->lDisplayRecs <= 0) // Display all records
		$CustomView1_list->lDisplayRecs = $CustomView1_list->lTotalRecs;
	if (!($CustomView1->ExportAll && $CustomView1->Export <> ""))
		$CustomView1_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $CustomView1_list->LoadRecordset($CustomView1_list->lStartRec-1, $CustomView1_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">CUSTOM VIEW: Custom View 1
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($CustomView1->Export == "" && $CustomView1->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(CustomView1_list);" style="text-decoration: none;"><img id="CustomView1_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="CustomView1_list_SearchPanel">
<form name="fCustomView1listsrch" id="fCustomView1listsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="CustomView1">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<a href="<?php echo $CustomView1_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
			<a href="CustomView1srch.php">Advanced Search</a>&nbsp;
		</span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $CustomView1_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fCustomView1list" id="fCustomView1list" class="ewForm" action="" method="post">
<?php if ($CustomView1_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$CustomView1_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$CustomView1_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$CustomView1_list->lOptionCnt++; // edit
}
	$CustomView1_list->lOptionCnt += count($CustomView1_list->ListOptions->Items); // Custom list options
?>
<?php echo $CustomView1->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($CustomView1->id->Visible) { // id ?>
	<?php if ($CustomView1->SortUrl($CustomView1->id) == "") { ?>
		<td>Id</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id</td><td style="width: 10px;"><?php if ($CustomView1->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->mount->Visible) { // mount ?>
	<?php if ($CustomView1->SortUrl($CustomView1->mount) == "") { ?>
		<td>Mount</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->mount) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Mount</td><td style="width: 10px;"><?php if ($CustomView1->mount->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->mount->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->path->Visible) { // path ?>
	<?php if ($CustomView1->SortUrl($CustomView1->path) == "") { ?>
		<td>Path</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->path) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Path</td><td style="width: 10px;"><?php if ($CustomView1->path->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->path->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->parent->Visible) { // parent ?>
	<?php if ($CustomView1->SortUrl($CustomView1->parent) == "") { ?>
		<td>Parent</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->parent) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Parent</td><td style="width: 10px;"><?php if ($CustomView1->parent->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->parent->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->deprecated->Visible) { // deprecated ?>
	<?php if ($CustomView1->SortUrl($CustomView1->deprecated) == "") { ?>
		<td>Deprecated</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->deprecated) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Deprecated</td><td style="width: 10px;"><?php if ($CustomView1->deprecated->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->deprecated->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->gid->Visible) { // gid ?>
	<?php if ($CustomView1->SortUrl($CustomView1->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($CustomView1->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->snapshot->Visible) { // snapshot ?>
	<?php if ($CustomView1->SortUrl($CustomView1->snapshot) == "") { ?>
		<td>Snapshot</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->snapshot) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Snapshot</td><td style="width: 10px;"><?php if ($CustomView1->snapshot->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->snapshot->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->tapebackup->Visible) { // tapebackup ?>
	<?php if ($CustomView1->SortUrl($CustomView1->tapebackup) == "") { ?>
		<td>Tapebackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->tapebackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Tapebackup</td><td style="width: 10px;"><?php if ($CustomView1->tapebackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->tapebackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->diskbackup->Visible) { // diskbackup ?>
	<?php if ($CustomView1->SortUrl($CustomView1->diskbackup) == "") { ?>
		<td>Diskbackup</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->diskbackup) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Diskbackup</td><td style="width: 10px;"><?php if ($CustomView1->diskbackup->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->diskbackup->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->name->Visible) { // name ?>
	<?php if ($CustomView1->SortUrl($CustomView1->name) == "") { ?>
		<td>Name</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Name</td><td style="width: 10px;"><?php if ($CustomView1->name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($CustomView1_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($CustomView1->ExportAll && $CustomView1->Export <> "") {
	$CustomView1_list->lStopRec = $CustomView1_list->lTotalRecs;
} else {
	$CustomView1_list->lStopRec = $CustomView1_list->lStartRec + $CustomView1_list->lDisplayRecs - 1; // Set the last record to display
}
$CustomView1_list->lRecCount = $CustomView1_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$CustomView1->SelectLimit && $CustomView1_list->lStartRec > 1)
		$rs->Move($CustomView1_list->lStartRec - 1);
}
$CustomView1_list->lRowCnt = 0;
while (($CustomView1->CurrentAction == "gridadd" || !$rs->EOF) &&
	$CustomView1_list->lRecCount < $CustomView1_list->lStopRec) {
	$CustomView1_list->lRecCount++;
	if (intval($CustomView1_list->lRecCount) >= intval($CustomView1_list->lStartRec)) {
		$CustomView1_list->lRowCnt++;

	// Init row class and style
	$CustomView1->CssClass = "";
	$CustomView1->CssStyle = "";
	$CustomView1->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($CustomView1->CurrentAction == "gridadd") {
		$CustomView1_list->LoadDefaultValues(); // Load default values
	} else {
		$CustomView1_list->LoadRowValues($rs); // Load row values
	}
	$CustomView1->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$CustomView1_list->RenderRow();
?>
	<tr<?php echo $CustomView1->RowAttributes() ?>>
	<?php if ($CustomView1->id->Visible) { // id ?>
		<td<?php echo $CustomView1->id->CellAttributes() ?>>
<div<?php echo $CustomView1->id->ViewAttributes() ?>><?php echo $CustomView1->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->mount->Visible) { // mount ?>
		<td<?php echo $CustomView1->mount->CellAttributes() ?>>
<div<?php echo $CustomView1->mount->ViewAttributes() ?>><?php echo $CustomView1->mount->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->path->Visible) { // path ?>
		<td<?php echo $CustomView1->path->CellAttributes() ?>>
<div<?php echo $CustomView1->path->ViewAttributes() ?>><?php echo $CustomView1->path->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->parent->Visible) { // parent ?>
		<td<?php echo $CustomView1->parent->CellAttributes() ?>>
<div<?php echo $CustomView1->parent->ViewAttributes() ?>><?php echo $CustomView1->parent->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->deprecated->Visible) { // deprecated ?>
		<td<?php echo $CustomView1->deprecated->CellAttributes() ?>>
<div<?php echo $CustomView1->deprecated->ViewAttributes() ?>><?php echo $CustomView1->deprecated->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->gid->Visible) { // gid ?>
		<td<?php echo $CustomView1->gid->CellAttributes() ?>>
<div<?php echo $CustomView1->gid->ViewAttributes() ?>><?php echo $CustomView1->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->snapshot->Visible) { // snapshot ?>
		<td<?php echo $CustomView1->snapshot->CellAttributes() ?>>
<div<?php echo $CustomView1->snapshot->ViewAttributes() ?>><?php echo $CustomView1->snapshot->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->tapebackup->Visible) { // tapebackup ?>
		<td<?php echo $CustomView1->tapebackup->CellAttributes() ?>>
<div<?php echo $CustomView1->tapebackup->ViewAttributes() ?>><?php echo $CustomView1->tapebackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->diskbackup->Visible) { // diskbackup ?>
		<td<?php echo $CustomView1->diskbackup->CellAttributes() ?>>
<div<?php echo $CustomView1->diskbackup->ViewAttributes() ?>><?php echo $CustomView1->diskbackup->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->name->Visible) { // name ?>
		<td<?php echo $CustomView1->name->CellAttributes() ?>>
<div<?php echo $CustomView1->name->ViewAttributes() ?>><?php echo $CustomView1->name->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($CustomView1->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $CustomView1->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $CustomView1->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($CustomView1_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($CustomView1->CurrentAction <> "gridadd")
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
<?php if ($CustomView1->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($CustomView1->CurrentAction <> "gridadd" && $CustomView1->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($CustomView1_list->Pager)) $CustomView1_list->Pager = new cPrevNextPager($CustomView1_list->lStartRec, $CustomView1_list->lDisplayRecs, $CustomView1_list->lTotalRecs) ?>
<?php if ($CustomView1_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($CustomView1_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $CustomView1_list->PageUrl() ?>start=<?php echo $CustomView1_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($CustomView1_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $CustomView1_list->PageUrl() ?>start=<?php echo $CustomView1_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $CustomView1_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($CustomView1_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $CustomView1_list->PageUrl() ?>start=<?php echo $CustomView1_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($CustomView1_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $CustomView1_list->PageUrl() ?>start=<?php echo $CustomView1_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $CustomView1_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $CustomView1_list->Pager->FromIndex ?> to <?php echo $CustomView1_list->Pager->ToIndex ?> of <?php echo $CustomView1_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($CustomView1_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($CustomView1_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($CustomView1->Export == "" && $CustomView1->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(CustomView1_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($CustomView1->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$CustomView1_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cCustomView1_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'CustomView1';

	// Page Object Name
	var $PageObjName = 'CustomView1_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $CustomView1;
		if ($CustomView1->UseTokenInUrl) $PageUrl .= "t=" . $CustomView1->TableVar . "&"; // add page token
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
		global $objForm, $CustomView1;
		if ($CustomView1->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($CustomView1->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($CustomView1->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cCustomView1_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["CustomView1"] = new cCustomView1();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'CustomView1', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $CustomView1;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$CustomView1->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $CustomView1->Export; // Get export parameter, used in header
	$gsExportFile = $CustomView1->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $CustomView1;
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

			// Get search criteria for advanced search
			$this->LoadSearchValues(); // Get search values
			if ($this->ValidateSearch()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			} else {
				$this->setMessage($gsSearchError);
			}

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($CustomView1->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $CustomView1->getRecordsPerPage(); // Restore from Session
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
		$CustomView1->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchAdvanced == "")
				$this->ResetAdvancedSearchParms();
			$CustomView1->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$CustomView1->setStartRecordNumber($this->lStartRec);
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
		$CustomView1->setSessionWhere($sFilter);
		$CustomView1->CurrentFilter = "";
	}

	// Return Advanced Search Where based on QueryString parameters
	function AdvancedSearchWhere() {
		global $Security, $CustomView1;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $CustomView1->id, FALSE); // Field id
		$this->BuildSearchSql($sWhere, $CustomView1->mount, FALSE); // Field mount
		$this->BuildSearchSql($sWhere, $CustomView1->path, FALSE); // Field path
		$this->BuildSearchSql($sWhere, $CustomView1->parent, FALSE); // Field parent
		$this->BuildSearchSql($sWhere, $CustomView1->deprecated, FALSE); // Field deprecated
		$this->BuildSearchSql($sWhere, $CustomView1->gid, FALSE); // Field gid
		$this->BuildSearchSql($sWhere, $CustomView1->snapshot, FALSE); // Field snapshot
		$this->BuildSearchSql($sWhere, $CustomView1->tapebackup, FALSE); // Field tapebackup
		$this->BuildSearchSql($sWhere, $CustomView1->diskbackup, FALSE); // Field diskbackup
		$this->BuildSearchSql($sWhere, $CustomView1->name, FALSE); // Field name

		// Set up search parm
		if ($sWhere <> "") {
			$this->SetSearchParm($CustomView1->id); // Field id
			$this->SetSearchParm($CustomView1->mount); // Field mount
			$this->SetSearchParm($CustomView1->path); // Field path
			$this->SetSearchParm($CustomView1->parent); // Field parent
			$this->SetSearchParm($CustomView1->deprecated); // Field deprecated
			$this->SetSearchParm($CustomView1->gid); // Field gid
			$this->SetSearchParm($CustomView1->snapshot); // Field snapshot
			$this->SetSearchParm($CustomView1->tapebackup); // Field tapebackup
			$this->SetSearchParm($CustomView1->diskbackup); // Field diskbackup
			$this->SetSearchParm($CustomView1->name); // Field name
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);		
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldVal) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldVal2) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2);
		}
		if ($sWrk <> "") {
			if ($Where <> "") $Where .= " AND ";
			$Where .= "(" . $sWrk . ")";
		}
	}

	// Set search parameters
	function SetSearchParm(&$Fld) {
		global $CustomView1;
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$CustomView1->setAdvancedSearch("x_$FldParm", $FldVal);
		$CustomView1->setAdvancedSearch("z_$FldParm", $Fld->AdvancedSearch->SearchOperator); // @$_GET["z_$FldParm"]
		$CustomView1->setAdvancedSearch("v_$FldParm", $Fld->AdvancedSearch->SearchCondition); // @$_GET["v_$FldParm"]
		$CustomView1->setAdvancedSearch("y_$FldParm", $FldVal2);
		$CustomView1->setAdvancedSearch("w_$FldParm", $Fld->AdvancedSearch->SearchOperator2); // @$_GET["w_$FldParm"]
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $CustomView1;
		$this->sSrchWhere = "";
		$CustomView1->setSearchWhere($this->sSrchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {

		// Clear advanced search parameters
		global $CustomView1;
		$CustomView1->setAdvancedSearch("x_id", "");
		$CustomView1->setAdvancedSearch("x_mount", "");
		$CustomView1->setAdvancedSearch("x_path", "");
		$CustomView1->setAdvancedSearch("x_parent", "");
		$CustomView1->setAdvancedSearch("x_deprecated", "");
		$CustomView1->setAdvancedSearch("x_gid", "");
		$CustomView1->setAdvancedSearch("x_snapshot", "");
		$CustomView1->setAdvancedSearch("x_tapebackup", "");
		$CustomView1->setAdvancedSearch("x_diskbackup", "");
		$CustomView1->setAdvancedSearch("x_name", "");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $CustomView1;
		$this->sSrchWhere = $CustomView1->getSearchWhere();

		// Restore advanced search settings
		if ($gsSearchError == "")
			$this->RestoreAdvancedSearchParms();
	}

	// Restore all advanced search parameters
	function RestoreAdvancedSearchParms() {

		// Restore advanced search parms
		global $CustomView1;
		 $CustomView1->id->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_id");
		 $CustomView1->mount->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_mount");
		 $CustomView1->path->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_path");
		 $CustomView1->parent->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_parent");
		 $CustomView1->deprecated->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_deprecated");
		 $CustomView1->gid->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_gid");
		 $CustomView1->snapshot->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_snapshot");
		 $CustomView1->tapebackup->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_tapebackup");
		 $CustomView1->diskbackup->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_diskbackup");
		 $CustomView1->name->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_name");
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $CustomView1;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$CustomView1->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$CustomView1->CurrentOrderType = @$_GET["ordertype"];
			$CustomView1->UpdateSort($CustomView1->id); // Field 
			$CustomView1->UpdateSort($CustomView1->mount); // Field 
			$CustomView1->UpdateSort($CustomView1->path); // Field 
			$CustomView1->UpdateSort($CustomView1->parent); // Field 
			$CustomView1->UpdateSort($CustomView1->deprecated); // Field 
			$CustomView1->UpdateSort($CustomView1->gid); // Field 
			$CustomView1->UpdateSort($CustomView1->snapshot); // Field 
			$CustomView1->UpdateSort($CustomView1->tapebackup); // Field 
			$CustomView1->UpdateSort($CustomView1->diskbackup); // Field 
			$CustomView1->UpdateSort($CustomView1->name); // Field 
			$CustomView1->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $CustomView1;
		$sOrderBy = $CustomView1->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($CustomView1->SqlOrderBy() <> "") {
				$sOrderBy = $CustomView1->SqlOrderBy();
				$CustomView1->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $CustomView1;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$CustomView1->setSessionOrderBy($sOrderBy);
				$CustomView1->id->setSort("");
				$CustomView1->mount->setSort("");
				$CustomView1->path->setSort("");
				$CustomView1->parent->setSort("");
				$CustomView1->deprecated->setSort("");
				$CustomView1->gid->setSort("");
				$CustomView1->snapshot->setSort("");
				$CustomView1->tapebackup->setSort("");
				$CustomView1->diskbackup->setSort("");
				$CustomView1->name->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$CustomView1->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $CustomView1;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$CustomView1->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$CustomView1->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $CustomView1->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$CustomView1->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$CustomView1->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$CustomView1->setStartRecordNumber($this->lStartRec);
		}
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm, $CustomView1;

		// Load search values
		// id

		$CustomView1->id->AdvancedSearch->SearchValue = @$_GET["x_id"];
		$CustomView1->id->AdvancedSearch->SearchOperator = @$_GET["z_id"];

		// mount
		$CustomView1->mount->AdvancedSearch->SearchValue = @$_GET["x_mount"];
		$CustomView1->mount->AdvancedSearch->SearchOperator = @$_GET["z_mount"];

		// path
		$CustomView1->path->AdvancedSearch->SearchValue = @$_GET["x_path"];
		$CustomView1->path->AdvancedSearch->SearchOperator = @$_GET["z_path"];

		// parent
		$CustomView1->parent->AdvancedSearch->SearchValue = @$_GET["x_parent"];
		$CustomView1->parent->AdvancedSearch->SearchOperator = @$_GET["z_parent"];

		// deprecated
		$CustomView1->deprecated->AdvancedSearch->SearchValue = @$_GET["x_deprecated"];
		$CustomView1->deprecated->AdvancedSearch->SearchOperator = @$_GET["z_deprecated"];

		// gid
		$CustomView1->gid->AdvancedSearch->SearchValue = @$_GET["x_gid"];
		$CustomView1->gid->AdvancedSearch->SearchOperator = @$_GET["z_gid"];

		// snapshot
		$CustomView1->snapshot->AdvancedSearch->SearchValue = @$_GET["x_snapshot"];
		$CustomView1->snapshot->AdvancedSearch->SearchOperator = @$_GET["z_snapshot"];

		// tapebackup
		$CustomView1->tapebackup->AdvancedSearch->SearchValue = @$_GET["x_tapebackup"];
		$CustomView1->tapebackup->AdvancedSearch->SearchOperator = @$_GET["z_tapebackup"];

		// diskbackup
		$CustomView1->diskbackup->AdvancedSearch->SearchValue = @$_GET["x_diskbackup"];
		$CustomView1->diskbackup->AdvancedSearch->SearchOperator = @$_GET["z_diskbackup"];

		// name
		$CustomView1->name->AdvancedSearch->SearchValue = @$_GET["x_name"];
		$CustomView1->name->AdvancedSearch->SearchOperator = @$_GET["z_name"];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $CustomView1;

		// Call Recordset Selecting event
		$CustomView1->Recordset_Selecting($CustomView1->CurrentFilter);

		// Load list page SQL
		$sSql = $CustomView1->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$CustomView1->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $CustomView1;
		$sFilter = $CustomView1->KeyFilter();

		// Call Row Selecting event
		$CustomView1->Row_Selecting($sFilter);

		// Load sql based on filter
		$CustomView1->CurrentFilter = $sFilter;
		$sSql = $CustomView1->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$CustomView1->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $CustomView1;
		$CustomView1->id->setDbValue($rs->fields('id'));
		$CustomView1->mount->setDbValue($rs->fields('mount'));
		$CustomView1->path->setDbValue($rs->fields('path'));
		$CustomView1->parent->setDbValue($rs->fields('parent'));
		$CustomView1->deprecated->setDbValue($rs->fields('deprecated'));
		$CustomView1->gid->setDbValue($rs->fields('gid'));
		$CustomView1->snapshot->setDbValue($rs->fields('snapshot'));
		$CustomView1->tapebackup->setDbValue($rs->fields('tapebackup'));
		$CustomView1->diskbackup->setDbValue($rs->fields('diskbackup'));
		$CustomView1->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $CustomView1;

		// Call Row_Rendering event
		$CustomView1->Row_Rendering();

		// Common render codes for all row types
		// id

		$CustomView1->id->CellCssStyle = "";
		$CustomView1->id->CellCssClass = "";

		// mount
		$CustomView1->mount->CellCssStyle = "";
		$CustomView1->mount->CellCssClass = "";

		// path
		$CustomView1->path->CellCssStyle = "";
		$CustomView1->path->CellCssClass = "";

		// parent
		$CustomView1->parent->CellCssStyle = "";
		$CustomView1->parent->CellCssClass = "";

		// deprecated
		$CustomView1->deprecated->CellCssStyle = "";
		$CustomView1->deprecated->CellCssClass = "";

		// gid
		$CustomView1->gid->CellCssStyle = "";
		$CustomView1->gid->CellCssClass = "";

		// snapshot
		$CustomView1->snapshot->CellCssStyle = "";
		$CustomView1->snapshot->CellCssClass = "";

		// tapebackup
		$CustomView1->tapebackup->CellCssStyle = "";
		$CustomView1->tapebackup->CellCssClass = "";

		// diskbackup
		$CustomView1->diskbackup->CellCssStyle = "";
		$CustomView1->diskbackup->CellCssClass = "";

		// name
		$CustomView1->name->CellCssStyle = "";
		$CustomView1->name->CellCssClass = "";
		if ($CustomView1->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$CustomView1->id->ViewValue = $CustomView1->id->CurrentValue;
			$CustomView1->id->CssStyle = "";
			$CustomView1->id->CssClass = "";
			$CustomView1->id->ViewCustomAttributes = "";

			// mount
			$CustomView1->mount->ViewValue = $CustomView1->mount->CurrentValue;
			$CustomView1->mount->CssStyle = "";
			$CustomView1->mount->CssClass = "";
			$CustomView1->mount->ViewCustomAttributes = "";

			// path
			$CustomView1->path->ViewValue = $CustomView1->path->CurrentValue;
			$CustomView1->path->CssStyle = "";
			$CustomView1->path->CssClass = "";
			$CustomView1->path->ViewCustomAttributes = "";

			// parent
			$CustomView1->parent->ViewValue = $CustomView1->parent->CurrentValue;
			$CustomView1->parent->CssStyle = "";
			$CustomView1->parent->CssClass = "";
			$CustomView1->parent->ViewCustomAttributes = "";

			// deprecated
			$CustomView1->deprecated->ViewValue = $CustomView1->deprecated->CurrentValue;
			$CustomView1->deprecated->CssStyle = "";
			$CustomView1->deprecated->CssClass = "";
			$CustomView1->deprecated->ViewCustomAttributes = "";

			// gid
			$CustomView1->gid->ViewValue = $CustomView1->gid->CurrentValue;
			$CustomView1->gid->CssStyle = "";
			$CustomView1->gid->CssClass = "";
			$CustomView1->gid->ViewCustomAttributes = "";

			// snapshot
			$CustomView1->snapshot->ViewValue = $CustomView1->snapshot->CurrentValue;
			$CustomView1->snapshot->CssStyle = "";
			$CustomView1->snapshot->CssClass = "";
			$CustomView1->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$CustomView1->tapebackup->ViewValue = $CustomView1->tapebackup->CurrentValue;
			$CustomView1->tapebackup->CssStyle = "";
			$CustomView1->tapebackup->CssClass = "";
			$CustomView1->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$CustomView1->diskbackup->ViewValue = $CustomView1->diskbackup->CurrentValue;
			$CustomView1->diskbackup->CssStyle = "";
			$CustomView1->diskbackup->CssClass = "";
			$CustomView1->diskbackup->ViewCustomAttributes = "";

			// name
			$CustomView1->name->ViewValue = $CustomView1->name->CurrentValue;
			$CustomView1->name->CssStyle = "";
			$CustomView1->name->CssClass = "";
			$CustomView1->name->ViewCustomAttributes = "";

			// id
			$CustomView1->id->HrefValue = "";

			// mount
			$CustomView1->mount->HrefValue = "";

			// path
			$CustomView1->path->HrefValue = "";

			// parent
			$CustomView1->parent->HrefValue = "";

			// deprecated
			$CustomView1->deprecated->HrefValue = "";

			// gid
			$CustomView1->gid->HrefValue = "";

			// snapshot
			$CustomView1->snapshot->HrefValue = "";

			// tapebackup
			$CustomView1->tapebackup->HrefValue = "";

			// diskbackup
			$CustomView1->diskbackup->HrefValue = "";

			// name
			$CustomView1->name->HrefValue = "";
		}

		// Call Row Rendered event
		$CustomView1->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $CustomView1;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= $sFormCustomError;
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		global $CustomView1;
		$CustomView1->id->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_id");
		$CustomView1->mount->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_mount");
		$CustomView1->path->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_path");
		$CustomView1->parent->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_parent");
		$CustomView1->deprecated->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_deprecated");
		$CustomView1->gid->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_gid");
		$CustomView1->snapshot->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_snapshot");
		$CustomView1->tapebackup->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_tapebackup");
		$CustomView1->diskbackup->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_diskbackup");
		$CustomView1->name->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_name");
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
