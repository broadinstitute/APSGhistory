<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "user_fs_viewinfo.php" ?>
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
$user_fs_view_list = new cuser_fs_view_list();
$Page =& $user_fs_view_list;

// Page init processing
$user_fs_view_list->Page_Init();

// Page main processing
$user_fs_view_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($user_fs_view->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var user_fs_view_list = new ew_Page("user_fs_view_list");

// page properties
user_fs_view_list.PageID = "list"; // page ID
var EW_PAGE_ID = user_fs_view_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
user_fs_view_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
user_fs_view_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
user_fs_view_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($user_fs_view->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($user_fs_view->Export == "" && $user_fs_view->SelectLimit);
	if (!$bSelectLimit)
		$rs = $user_fs_view_list->LoadRecordset();
	$user_fs_view_list->lTotalRecs = ($bSelectLimit) ? $user_fs_view->SelectRecordCount() : $rs->RecordCount();
	$user_fs_view_list->lStartRec = 1;
	if ($user_fs_view_list->lDisplayRecs <= 0) // Display all records
		$user_fs_view_list->lDisplayRecs = $user_fs_view_list->lTotalRecs;
	if (!($user_fs_view->ExportAll && $user_fs_view->Export <> ""))
		$user_fs_view_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $user_fs_view_list->LoadRecordset($user_fs_view_list->lStartRec-1, $user_fs_view_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">View: User Fs View
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($user_fs_view->Export == "" && $user_fs_view->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(user_fs_view_list);" style="text-decoration: none;"><img id="user_fs_view_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="user_fs_view_list_SearchPanel">
<form name="fuser_fs_viewlistsrch" id="fuser_fs_viewlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="user_fs_view">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($user_fs_view->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $user_fs_view_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($user_fs_view->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($user_fs_view->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($user_fs_view->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $user_fs_view_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fuser_fs_viewlist" id="fuser_fs_viewlist" class="ewForm" action="" method="post">
<?php if ($user_fs_view_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$user_fs_view_list->lOptionCnt = 0;
	$user_fs_view_list->lOptionCnt += count($user_fs_view_list->ListOptions->Items); // Custom list options
?>
<?php echo $user_fs_view->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($user_fs_view->uid->Visible) { // uid ?>
	<?php if ($user_fs_view->SortUrl($user_fs_view->uid) == "") { ?>
		<td>Uid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $user_fs_view->SortUrl($user_fs_view->uid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Uid</td><td style="width: 10px;"><?php if ($user_fs_view->uid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($user_fs_view->uid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($user_fs_view->username->Visible) { // username ?>
	<?php if ($user_fs_view->SortUrl($user_fs_view->username) == "") { ?>
		<td>Username</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $user_fs_view->SortUrl($user_fs_view->username) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Username&nbsp;(*)</td><td style="width: 10px;"><?php if ($user_fs_view->username->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($user_fs_view->username->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($user_fs_view->gecos->Visible) { // gecos ?>
	<?php if ($user_fs_view->SortUrl($user_fs_view->gecos) == "") { ?>
		<td>Gecos</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $user_fs_view->SortUrl($user_fs_view->gecos) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gecos&nbsp;(*)</td><td style="width: 10px;"><?php if ($user_fs_view->gecos->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($user_fs_view->gecos->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($user_fs_view->role->Visible) { // role ?>
	<?php if ($user_fs_view->SortUrl($user_fs_view->role) == "") { ?>
		<td>Role</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $user_fs_view->SortUrl($user_fs_view->role) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Role</td><td style="width: 10px;"><?php if ($user_fs_view->role->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($user_fs_view->role->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($user_fs_view->gid->Visible) { // gid ?>
	<?php if ($user_fs_view->SortUrl($user_fs_view->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $user_fs_view->SortUrl($user_fs_view->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($user_fs_view->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($user_fs_view->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($user_fs_view->cobj->Visible) { // cobj ?>
	<?php if ($user_fs_view->SortUrl($user_fs_view->cobj) == "") { ?>
		<td>Cobj</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $user_fs_view->SortUrl($user_fs_view->cobj) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cobj&nbsp;(*)</td><td style="width: 10px;"><?php if ($user_fs_view->cobj->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($user_fs_view->cobj->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($user_fs_view->Export == "") { ?>
<?php

// Custom list options
foreach ($user_fs_view_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($user_fs_view->ExportAll && $user_fs_view->Export <> "") {
	$user_fs_view_list->lStopRec = $user_fs_view_list->lTotalRecs;
} else {
	$user_fs_view_list->lStopRec = $user_fs_view_list->lStartRec + $user_fs_view_list->lDisplayRecs - 1; // Set the last record to display
}
$user_fs_view_list->lRecCount = $user_fs_view_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$user_fs_view->SelectLimit && $user_fs_view_list->lStartRec > 1)
		$rs->Move($user_fs_view_list->lStartRec - 1);
}
$user_fs_view_list->lRowCnt = 0;
while (($user_fs_view->CurrentAction == "gridadd" || !$rs->EOF) &&
	$user_fs_view_list->lRecCount < $user_fs_view_list->lStopRec) {
	$user_fs_view_list->lRecCount++;
	if (intval($user_fs_view_list->lRecCount) >= intval($user_fs_view_list->lStartRec)) {
		$user_fs_view_list->lRowCnt++;

	// Init row class and style
	$user_fs_view->CssClass = "";
	$user_fs_view->CssStyle = "";
	$user_fs_view->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($user_fs_view->CurrentAction == "gridadd") {
		$user_fs_view_list->LoadDefaultValues(); // Load default values
	} else {
		$user_fs_view_list->LoadRowValues($rs); // Load row values
	}
	$user_fs_view->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$user_fs_view_list->RenderRow();
?>
	<tr<?php echo $user_fs_view->RowAttributes() ?>>
	<?php if ($user_fs_view->uid->Visible) { // uid ?>
		<td<?php echo $user_fs_view->uid->CellAttributes() ?>>
<div<?php echo $user_fs_view->uid->ViewAttributes() ?>><?php echo $user_fs_view->uid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($user_fs_view->username->Visible) { // username ?>
		<td<?php echo $user_fs_view->username->CellAttributes() ?>>
<div<?php echo $user_fs_view->username->ViewAttributes() ?>><?php echo $user_fs_view->username->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($user_fs_view->gecos->Visible) { // gecos ?>
		<td<?php echo $user_fs_view->gecos->CellAttributes() ?>>
<div<?php echo $user_fs_view->gecos->ViewAttributes() ?>><?php echo $user_fs_view->gecos->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($user_fs_view->role->Visible) { // role ?>
		<td<?php echo $user_fs_view->role->CellAttributes() ?>>
<div<?php echo $user_fs_view->role->ViewAttributes() ?>><?php echo $user_fs_view->role->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($user_fs_view->gid->Visible) { // gid ?>
		<td<?php echo $user_fs_view->gid->CellAttributes() ?>>
<div<?php echo $user_fs_view->gid->ViewAttributes() ?>><?php echo $user_fs_view->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($user_fs_view->cobj->Visible) { // cobj ?>
		<td<?php echo $user_fs_view->cobj->CellAttributes() ?>>
<div<?php echo $user_fs_view->cobj->ViewAttributes() ?>><?php echo $user_fs_view->cobj->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($user_fs_view->Export == "") { ?>
<?php

// Custom list options
foreach ($user_fs_view_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($user_fs_view->CurrentAction <> "gridadd")
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
<?php if ($user_fs_view->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($user_fs_view->CurrentAction <> "gridadd" && $user_fs_view->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($user_fs_view_list->Pager)) $user_fs_view_list->Pager = new cPrevNextPager($user_fs_view_list->lStartRec, $user_fs_view_list->lDisplayRecs, $user_fs_view_list->lTotalRecs) ?>
<?php if ($user_fs_view_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($user_fs_view_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $user_fs_view_list->PageUrl() ?>start=<?php echo $user_fs_view_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($user_fs_view_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $user_fs_view_list->PageUrl() ?>start=<?php echo $user_fs_view_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $user_fs_view_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($user_fs_view_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $user_fs_view_list->PageUrl() ?>start=<?php echo $user_fs_view_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($user_fs_view_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $user_fs_view_list->PageUrl() ?>start=<?php echo $user_fs_view_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $user_fs_view_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $user_fs_view_list->Pager->FromIndex ?> to <?php echo $user_fs_view_list->Pager->ToIndex ?> of <?php echo $user_fs_view_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($user_fs_view_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($user_fs_view_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($user_fs_view->Export == "" && $user_fs_view->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(user_fs_view_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($user_fs_view->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$user_fs_view_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cuser_fs_view_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'user_fs_view';

	// Page Object Name
	var $PageObjName = 'user_fs_view_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $user_fs_view;
		if ($user_fs_view->UseTokenInUrl) $PageUrl .= "t=" . $user_fs_view->TableVar . "&"; // add page token
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
		global $objForm, $user_fs_view;
		if ($user_fs_view->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($user_fs_view->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($user_fs_view->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cuser_fs_view_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["user_fs_view"] = new cuser_fs_view();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'user_fs_view', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $user_fs_view;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$user_fs_view->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $user_fs_view->Export; // Get export parameter, used in header
	$gsExportFile = $user_fs_view->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $user_fs_view;
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
		if ($user_fs_view->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $user_fs_view->getRecordsPerPage(); // Restore from Session
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
		$user_fs_view->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$user_fs_view->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$user_fs_view->setStartRecordNumber($this->lStartRec);
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
		$user_fs_view->setSessionWhere($sFilter);
		$user_fs_view->CurrentFilter = "";
	}

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $user_fs_view;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $user_fs_view->username->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $user_fs_view->gecos->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $user_fs_view->cobj->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $user_fs_view;
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
			$user_fs_view->setBasicSearchKeyword($sSearchKeyword);
			$user_fs_view->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $user_fs_view;
		$this->sSrchWhere = "";
		$user_fs_view->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $user_fs_view;
		$user_fs_view->setBasicSearchKeyword("");
		$user_fs_view->setBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $user_fs_view;
		$this->sSrchWhere = $user_fs_view->getSearchWhere();
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $user_fs_view;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$user_fs_view->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$user_fs_view->CurrentOrderType = @$_GET["ordertype"];
			$user_fs_view->UpdateSort($user_fs_view->uid); // Field 
			$user_fs_view->UpdateSort($user_fs_view->username); // Field 
			$user_fs_view->UpdateSort($user_fs_view->gecos); // Field 
			$user_fs_view->UpdateSort($user_fs_view->role); // Field 
			$user_fs_view->UpdateSort($user_fs_view->gid); // Field 
			$user_fs_view->UpdateSort($user_fs_view->cobj); // Field 
			$user_fs_view->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $user_fs_view;
		$sOrderBy = $user_fs_view->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($user_fs_view->SqlOrderBy() <> "") {
				$sOrderBy = $user_fs_view->SqlOrderBy();
				$user_fs_view->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $user_fs_view;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$user_fs_view->setSessionOrderBy($sOrderBy);
				$user_fs_view->uid->setSort("");
				$user_fs_view->username->setSort("");
				$user_fs_view->gecos->setSort("");
				$user_fs_view->role->setSort("");
				$user_fs_view->gid->setSort("");
				$user_fs_view->cobj->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$user_fs_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $user_fs_view;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$user_fs_view->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$user_fs_view->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $user_fs_view->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$user_fs_view->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$user_fs_view->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$user_fs_view->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $user_fs_view;

		// Call Recordset Selecting event
		$user_fs_view->Recordset_Selecting($user_fs_view->CurrentFilter);

		// Load list page SQL
		$sSql = $user_fs_view->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$user_fs_view->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $user_fs_view;
		$sFilter = $user_fs_view->KeyFilter();

		// Call Row Selecting event
		$user_fs_view->Row_Selecting($sFilter);

		// Load sql based on filter
		$user_fs_view->CurrentFilter = $sFilter;
		$sSql = $user_fs_view->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$user_fs_view->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $user_fs_view;
		$user_fs_view->uid->setDbValue($rs->fields('uid'));
		$user_fs_view->username->setDbValue($rs->fields('username'));
		$user_fs_view->gecos->setDbValue($rs->fields('gecos'));
		$user_fs_view->role->setDbValue($rs->fields('role'));
		$user_fs_view->gid->setDbValue($rs->fields('gid'));
		$user_fs_view->cobj->setDbValue($rs->fields('cobj'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $user_fs_view;

		// Call Row_Rendering event
		$user_fs_view->Row_Rendering();

		// Common render codes for all row types
		// uid

		$user_fs_view->uid->CellCssStyle = "";
		$user_fs_view->uid->CellCssClass = "";

		// username
		$user_fs_view->username->CellCssStyle = "";
		$user_fs_view->username->CellCssClass = "";

		// gecos
		$user_fs_view->gecos->CellCssStyle = "";
		$user_fs_view->gecos->CellCssClass = "";

		// role
		$user_fs_view->role->CellCssStyle = "";
		$user_fs_view->role->CellCssClass = "";

		// gid
		$user_fs_view->gid->CellCssStyle = "";
		$user_fs_view->gid->CellCssClass = "";

		// cobj
		$user_fs_view->cobj->CellCssStyle = "";
		$user_fs_view->cobj->CellCssClass = "";
		if ($user_fs_view->RowType == EW_ROWTYPE_VIEW) { // View row

			// uid
			$user_fs_view->uid->ViewValue = $user_fs_view->uid->CurrentValue;
			$user_fs_view->uid->CssStyle = "";
			$user_fs_view->uid->CssClass = "";
			$user_fs_view->uid->ViewCustomAttributes = "";

			// username
			$user_fs_view->username->ViewValue = $user_fs_view->username->CurrentValue;
			$user_fs_view->username->CssStyle = "";
			$user_fs_view->username->CssClass = "";
			$user_fs_view->username->ViewCustomAttributes = "";

			// gecos
			$user_fs_view->gecos->ViewValue = $user_fs_view->gecos->CurrentValue;
			$user_fs_view->gecos->CssStyle = "";
			$user_fs_view->gecos->CssClass = "";
			$user_fs_view->gecos->ViewCustomAttributes = "";

			// role
			$user_fs_view->role->ViewValue = $user_fs_view->role->CurrentValue;
			$user_fs_view->role->CssStyle = "";
			$user_fs_view->role->CssClass = "";
			$user_fs_view->role->ViewCustomAttributes = "";

			// gid
			$user_fs_view->gid->ViewValue = $user_fs_view->gid->CurrentValue;
			$user_fs_view->gid->CssStyle = "";
			$user_fs_view->gid->CssClass = "";
			$user_fs_view->gid->ViewCustomAttributes = "";

			// cobj
			$user_fs_view->cobj->ViewValue = $user_fs_view->cobj->CurrentValue;
			$user_fs_view->cobj->CssStyle = "";
			$user_fs_view->cobj->CssClass = "";
			$user_fs_view->cobj->ViewCustomAttributes = "";

			// uid
			$user_fs_view->uid->HrefValue = "";

			// username
			$user_fs_view->username->HrefValue = "";

			// gecos
			$user_fs_view->gecos->HrefValue = "";

			// role
			$user_fs_view->role->HrefValue = "";

			// gid
			$user_fs_view->gid->HrefValue = "";

			// cobj
			$user_fs_view->cobj->HrefValue = "";
		}

		// Call Row Rendered event
		$user_fs_view->Row_Rendered();
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
