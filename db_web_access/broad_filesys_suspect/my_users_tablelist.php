<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "my_users_tableinfo.php" ?>
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
$my_users_table_list = new cmy_users_table_list();
$Page =& $my_users_table_list;

// Page init processing
$my_users_table_list->Page_Init();

// Page main processing
$my_users_table_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($my_users_table->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var my_users_table_list = new ew_Page("my_users_table_list");

// page properties
my_users_table_list.PageID = "list"; // page ID
var EW_PAGE_ID = my_users_table_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
my_users_table_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
my_users_table_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
my_users_table_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($my_users_table->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($my_users_table->Export == "" && $my_users_table->SelectLimit);
	if (!$bSelectLimit)
		$rs = $my_users_table_list->LoadRecordset();
	$my_users_table_list->lTotalRecs = ($bSelectLimit) ? $my_users_table->SelectRecordCount() : $rs->RecordCount();
	$my_users_table_list->lStartRec = 1;
	if ($my_users_table_list->lDisplayRecs <= 0) // Display all records
		$my_users_table_list->lDisplayRecs = $my_users_table_list->lTotalRecs;
	if (!($my_users_table->ExportAll && $my_users_table->Export <> ""))
		$my_users_table_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $my_users_table_list->LoadRecordset($my_users_table_list->lStartRec-1, $my_users_table_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: My Users Table
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($my_users_table->Export == "" && $my_users_table->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(my_users_table_list);" style="text-decoration: none;"><img id="my_users_table_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;Search</span><br>
<div id="my_users_table_list_SearchPanel">
<form name="fmy_users_tablelistsrch" id="fmy_users_tablelistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="my_users_table">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($my_users_table->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Search (*)">&nbsp;
			<a href="<?php echo $my_users_table_list->PageUrl() ?>cmd=reset">Show all</a>&nbsp;
			<a href="my_users_tablesrch.php">Advanced Search</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($my_users_table->getBasicSearchType() == "") { ?> checked="checked"<?php } ?>>Exact phrase</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($my_users_table->getBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>>All words</label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($my_users_table->getBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>>Any word</label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php $my_users_table_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fmy_users_tablelist" id="fmy_users_tablelist" class="ewForm" action="" method="post">
<?php if ($my_users_table_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$my_users_table_list->lOptionCnt = 0;
	$my_users_table_list->lOptionCnt += count($my_users_table_list->ListOptions->Items); // Custom list options
?>
<?php echo $my_users_table->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($my_users_table->uid->Visible) { // uid ?>
	<?php if ($my_users_table->SortUrl($my_users_table->uid) == "") { ?>
		<td>Uid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $my_users_table->SortUrl($my_users_table->uid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Uid</td><td style="width: 10px;"><?php if ($my_users_table->uid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($my_users_table->uid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($my_users_table->username->Visible) { // username ?>
	<?php if ($my_users_table->SortUrl($my_users_table->username) == "") { ?>
		<td>Username</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $my_users_table->SortUrl($my_users_table->username) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Username&nbsp;(*)</td><td style="width: 10px;"><?php if ($my_users_table->username->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($my_users_table->username->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($my_users_table->gecos->Visible) { // gecos ?>
	<?php if ($my_users_table->SortUrl($my_users_table->gecos) == "") { ?>
		<td>Gecos</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $my_users_table->SortUrl($my_users_table->gecos) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gecos&nbsp;(*)</td><td style="width: 10px;"><?php if ($my_users_table->gecos->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($my_users_table->gecos->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($my_users_table->role->Visible) { // role ?>
	<?php if ($my_users_table->SortUrl($my_users_table->role) == "") { ?>
		<td>Role</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $my_users_table->SortUrl($my_users_table->role) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Role</td><td style="width: 10px;"><?php if ($my_users_table->role->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($my_users_table->role->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($my_users_table->gid->Visible) { // gid ?>
	<?php if ($my_users_table->SortUrl($my_users_table->gid) == "") { ?>
		<td>Gid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $my_users_table->SortUrl($my_users_table->gid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Gid</td><td style="width: 10px;"><?php if ($my_users_table->gid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($my_users_table->gid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($my_users_table->cobj->Visible) { // cobj ?>
	<?php if ($my_users_table->SortUrl($my_users_table->cobj) == "") { ?>
		<td>Cobj</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $my_users_table->SortUrl($my_users_table->cobj) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cobj&nbsp;(*)</td><td style="width: 10px;"><?php if ($my_users_table->cobj->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($my_users_table->cobj->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($my_users_table->Export == "") { ?>
<?php

// Custom list options
foreach ($my_users_table_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($my_users_table->ExportAll && $my_users_table->Export <> "") {
	$my_users_table_list->lStopRec = $my_users_table_list->lTotalRecs;
} else {
	$my_users_table_list->lStopRec = $my_users_table_list->lStartRec + $my_users_table_list->lDisplayRecs - 1; // Set the last record to display
}
$my_users_table_list->lRecCount = $my_users_table_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$my_users_table->SelectLimit && $my_users_table_list->lStartRec > 1)
		$rs->Move($my_users_table_list->lStartRec - 1);
}
$my_users_table_list->lRowCnt = 0;
while (($my_users_table->CurrentAction == "gridadd" || !$rs->EOF) &&
	$my_users_table_list->lRecCount < $my_users_table_list->lStopRec) {
	$my_users_table_list->lRecCount++;
	if (intval($my_users_table_list->lRecCount) >= intval($my_users_table_list->lStartRec)) {
		$my_users_table_list->lRowCnt++;

	// Init row class and style
	$my_users_table->CssClass = "";
	$my_users_table->CssStyle = "";
	$my_users_table->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($my_users_table->CurrentAction == "gridadd") {
		$my_users_table_list->LoadDefaultValues(); // Load default values
	} else {
		$my_users_table_list->LoadRowValues($rs); // Load row values
	}
	$my_users_table->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$my_users_table_list->RenderRow();
?>
	<tr<?php echo $my_users_table->RowAttributes() ?>>
	<?php if ($my_users_table->uid->Visible) { // uid ?>
		<td<?php echo $my_users_table->uid->CellAttributes() ?>>
<div<?php echo $my_users_table->uid->ViewAttributes() ?>><?php echo $my_users_table->uid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($my_users_table->username->Visible) { // username ?>
		<td<?php echo $my_users_table->username->CellAttributes() ?>>
<div<?php echo $my_users_table->username->ViewAttributes() ?>><?php echo $my_users_table->username->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($my_users_table->gecos->Visible) { // gecos ?>
		<td<?php echo $my_users_table->gecos->CellAttributes() ?>>
<div<?php echo $my_users_table->gecos->ViewAttributes() ?>><?php echo $my_users_table->gecos->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($my_users_table->role->Visible) { // role ?>
		<td<?php echo $my_users_table->role->CellAttributes() ?>>
<div<?php echo $my_users_table->role->ViewAttributes() ?>><?php echo $my_users_table->role->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($my_users_table->gid->Visible) { // gid ?>
		<td<?php echo $my_users_table->gid->CellAttributes() ?>>
<div<?php echo $my_users_table->gid->ViewAttributes() ?>><?php echo $my_users_table->gid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($my_users_table->cobj->Visible) { // cobj ?>
		<td<?php echo $my_users_table->cobj->CellAttributes() ?>>
<div<?php echo $my_users_table->cobj->ViewAttributes() ?>><?php echo $my_users_table->cobj->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($my_users_table->Export == "") { ?>
<?php

// Custom list options
foreach ($my_users_table_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($my_users_table->CurrentAction <> "gridadd")
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
<?php if ($my_users_table->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($my_users_table->CurrentAction <> "gridadd" && $my_users_table->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($my_users_table_list->Pager)) $my_users_table_list->Pager = new cPrevNextPager($my_users_table_list->lStartRec, $my_users_table_list->lDisplayRecs, $my_users_table_list->lTotalRecs) ?>
<?php if ($my_users_table_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($my_users_table_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $my_users_table_list->PageUrl() ?>start=<?php echo $my_users_table_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($my_users_table_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $my_users_table_list->PageUrl() ?>start=<?php echo $my_users_table_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $my_users_table_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($my_users_table_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $my_users_table_list->PageUrl() ?>start=<?php echo $my_users_table_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($my_users_table_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $my_users_table_list->PageUrl() ?>start=<?php echo $my_users_table_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $my_users_table_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $my_users_table_list->Pager->FromIndex ?> to <?php echo $my_users_table_list->Pager->ToIndex ?> of <?php echo $my_users_table_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($my_users_table_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($my_users_table_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($my_users_table->Export == "" && $my_users_table->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(my_users_table_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($my_users_table->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$my_users_table_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cmy_users_table_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'my_users_table';

	// Page Object Name
	var $PageObjName = 'my_users_table_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $my_users_table;
		if ($my_users_table->UseTokenInUrl) $PageUrl .= "t=" . $my_users_table->TableVar . "&"; // add page token
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
		global $objForm, $my_users_table;
		if ($my_users_table->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($my_users_table->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($my_users_table->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmy_users_table_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["my_users_table"] = new cmy_users_table();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'my_users_table', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $my_users_table;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$my_users_table->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $my_users_table->Export; // Get export parameter, used in header
	$gsExportFile = $my_users_table->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $my_users_table;
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

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($my_users_table->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $my_users_table->getRecordsPerPage(); // Restore from Session
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
		$my_users_table->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			if ($sSrchAdvanced == "")
				$this->ResetAdvancedSearchParms();
			$my_users_table->setSearchWhere($this->sSrchWhere); // Save to Session
			$this->lStartRec = 1; // Reset start record counter
			$my_users_table->setStartRecordNumber($this->lStartRec);
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
		$my_users_table->setSessionWhere($sFilter);
		$my_users_table->CurrentFilter = "";
	}

	// Return Advanced Search Where based on QueryString parameters
	function AdvancedSearchWhere() {
		global $Security, $my_users_table;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $my_users_table->uid, FALSE); // Field uid
		$this->BuildSearchSql($sWhere, $my_users_table->username, FALSE); // Field username
		$this->BuildSearchSql($sWhere, $my_users_table->gecos, FALSE); // Field gecos
		$this->BuildSearchSql($sWhere, $my_users_table->role, FALSE); // Field role
		$this->BuildSearchSql($sWhere, $my_users_table->gid, FALSE); // Field gid
		$this->BuildSearchSql($sWhere, $my_users_table->cobj, FALSE); // Field cobj

		// Set up search parm
		if ($sWhere <> "") {
			$this->SetSearchParm($my_users_table->uid); // Field uid
			$this->SetSearchParm($my_users_table->username); // Field username
			$this->SetSearchParm($my_users_table->gecos); // Field gecos
			$this->SetSearchParm($my_users_table->role); // Field role
			$this->SetSearchParm($my_users_table->gid); // Field gid
			$this->SetSearchParm($my_users_table->cobj); // Field cobj
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
		global $my_users_table;
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$my_users_table->setAdvancedSearch("x_$FldParm", $FldVal);
		$my_users_table->setAdvancedSearch("z_$FldParm", $Fld->AdvancedSearch->SearchOperator); // @$_GET["z_$FldParm"]
		$my_users_table->setAdvancedSearch("v_$FldParm", $Fld->AdvancedSearch->SearchCondition); // @$_GET["v_$FldParm"]
		$my_users_table->setAdvancedSearch("y_$FldParm", $FldVal2);
		$my_users_table->setAdvancedSearch("w_$FldParm", $Fld->AdvancedSearch->SearchOperator2); // @$_GET["w_$FldParm"]
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

	// Return Basic Search sql
	function BasicSearchSQL($Keyword) {
		global $my_users_table;
		$sKeyword = ew_AdjustSql($Keyword);
		$sql = "";
		$sql .= $my_users_table->username->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $my_users_table->gecos->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		$sql .= $my_users_table->cobj->FldExpression . " LIKE '%" . $sKeyword . "%' OR ";
		if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
		return $sql;
	}

	// Return Basic Search Where based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $my_users_table;
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
			$my_users_table->setBasicSearchKeyword($sSearchKeyword);
			$my_users_table->setBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search where
		global $my_users_table;
		$this->sSrchWhere = "";
		$my_users_table->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {

		// Clear basic search parameters
		global $my_users_table;
		$my_users_table->setBasicSearchKeyword("");
		$my_users_table->setBasicSearchType("");
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {

		// Clear advanced search parameters
		global $my_users_table;
		$my_users_table->setAdvancedSearch("x_uid", "");
		$my_users_table->setAdvancedSearch("x_username", "");
		$my_users_table->setAdvancedSearch("x_gecos", "");
		$my_users_table->setAdvancedSearch("x_role", "");
		$my_users_table->setAdvancedSearch("x_gid", "");
		$my_users_table->setAdvancedSearch("x_cobj", "");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $gsSearchError, $my_users_table;
		$this->sSrchWhere = $my_users_table->getSearchWhere();

		// Restore advanced search settings
		if ($gsSearchError == "")
			$this->RestoreAdvancedSearchParms();
	}

	// Restore all advanced search parameters
	function RestoreAdvancedSearchParms() {

		// Restore advanced search parms
		global $my_users_table;
		 $my_users_table->uid->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_uid");
		 $my_users_table->username->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_username");
		 $my_users_table->gecos->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_gecos");
		 $my_users_table->role->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_role");
		 $my_users_table->gid->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_gid");
		 $my_users_table->cobj->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_cobj");
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $my_users_table;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$my_users_table->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$my_users_table->CurrentOrderType = @$_GET["ordertype"];
			$my_users_table->UpdateSort($my_users_table->uid); // Field 
			$my_users_table->UpdateSort($my_users_table->username); // Field 
			$my_users_table->UpdateSort($my_users_table->gecos); // Field 
			$my_users_table->UpdateSort($my_users_table->role); // Field 
			$my_users_table->UpdateSort($my_users_table->gid); // Field 
			$my_users_table->UpdateSort($my_users_table->cobj); // Field 
			$my_users_table->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $my_users_table;
		$sOrderBy = $my_users_table->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($my_users_table->SqlOrderBy() <> "") {
				$sOrderBy = $my_users_table->SqlOrderBy();
				$my_users_table->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $my_users_table;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$my_users_table->setSessionOrderBy($sOrderBy);
				$my_users_table->uid->setSort("");
				$my_users_table->username->setSort("");
				$my_users_table->gecos->setSort("");
				$my_users_table->role->setSort("");
				$my_users_table->gid->setSort("");
				$my_users_table->cobj->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$my_users_table->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $my_users_table;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$my_users_table->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$my_users_table->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $my_users_table->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$my_users_table->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$my_users_table->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$my_users_table->setStartRecordNumber($this->lStartRec);
		}
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm, $my_users_table;

		// Load search values
		// uid

		$my_users_table->uid->AdvancedSearch->SearchValue = @$_GET["x_uid"];
		$my_users_table->uid->AdvancedSearch->SearchOperator = @$_GET["z_uid"];

		// username
		$my_users_table->username->AdvancedSearch->SearchValue = @$_GET["x_username"];
		$my_users_table->username->AdvancedSearch->SearchOperator = @$_GET["z_username"];

		// gecos
		$my_users_table->gecos->AdvancedSearch->SearchValue = @$_GET["x_gecos"];
		$my_users_table->gecos->AdvancedSearch->SearchOperator = @$_GET["z_gecos"];

		// role
		$my_users_table->role->AdvancedSearch->SearchValue = @$_GET["x_role"];
		$my_users_table->role->AdvancedSearch->SearchOperator = @$_GET["z_role"];

		// gid
		$my_users_table->gid->AdvancedSearch->SearchValue = @$_GET["x_gid"];
		$my_users_table->gid->AdvancedSearch->SearchOperator = @$_GET["z_gid"];

		// cobj
		$my_users_table->cobj->AdvancedSearch->SearchValue = @$_GET["x_cobj"];
		$my_users_table->cobj->AdvancedSearch->SearchOperator = @$_GET["z_cobj"];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $my_users_table;

		// Call Recordset Selecting event
		$my_users_table->Recordset_Selecting($my_users_table->CurrentFilter);

		// Load list page SQL
		$sSql = $my_users_table->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$my_users_table->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $my_users_table;
		$sFilter = $my_users_table->KeyFilter();

		// Call Row Selecting event
		$my_users_table->Row_Selecting($sFilter);

		// Load sql based on filter
		$my_users_table->CurrentFilter = $sFilter;
		$sSql = $my_users_table->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$my_users_table->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $my_users_table;
		$my_users_table->uid->setDbValue($rs->fields('uid'));
		$my_users_table->username->setDbValue($rs->fields('username'));
		$my_users_table->gecos->setDbValue($rs->fields('gecos'));
		$my_users_table->role->setDbValue($rs->fields('role'));
		$my_users_table->gid->setDbValue($rs->fields('gid'));
		$my_users_table->cobj->setDbValue($rs->fields('cobj'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $my_users_table;

		// Call Row_Rendering event
		$my_users_table->Row_Rendering();

		// Common render codes for all row types
		// uid

		$my_users_table->uid->CellCssStyle = "";
		$my_users_table->uid->CellCssClass = "";

		// username
		$my_users_table->username->CellCssStyle = "";
		$my_users_table->username->CellCssClass = "";

		// gecos
		$my_users_table->gecos->CellCssStyle = "";
		$my_users_table->gecos->CellCssClass = "";

		// role
		$my_users_table->role->CellCssStyle = "";
		$my_users_table->role->CellCssClass = "";

		// gid
		$my_users_table->gid->CellCssStyle = "";
		$my_users_table->gid->CellCssClass = "";

		// cobj
		$my_users_table->cobj->CellCssStyle = "";
		$my_users_table->cobj->CellCssClass = "";
		if ($my_users_table->RowType == EW_ROWTYPE_VIEW) { // View row

			// uid
			$my_users_table->uid->ViewValue = $my_users_table->uid->CurrentValue;
			$my_users_table->uid->CssStyle = "";
			$my_users_table->uid->CssClass = "";
			$my_users_table->uid->ViewCustomAttributes = "";

			// username
			$my_users_table->username->ViewValue = $my_users_table->username->CurrentValue;
			$my_users_table->username->CssStyle = "";
			$my_users_table->username->CssClass = "";
			$my_users_table->username->ViewCustomAttributes = "";

			// gecos
			$my_users_table->gecos->ViewValue = $my_users_table->gecos->CurrentValue;
			$my_users_table->gecos->CssStyle = "";
			$my_users_table->gecos->CssClass = "";
			$my_users_table->gecos->ViewCustomAttributes = "";

			// role
			$my_users_table->role->ViewValue = $my_users_table->role->CurrentValue;
			$my_users_table->role->CssStyle = "";
			$my_users_table->role->CssClass = "";
			$my_users_table->role->ViewCustomAttributes = "";

			// gid
			$my_users_table->gid->ViewValue = $my_users_table->gid->CurrentValue;
			$my_users_table->gid->CssStyle = "";
			$my_users_table->gid->CssClass = "";
			$my_users_table->gid->ViewCustomAttributes = "";

			// cobj
			$my_users_table->cobj->ViewValue = $my_users_table->cobj->CurrentValue;
			$my_users_table->cobj->CssStyle = "";
			$my_users_table->cobj->CssClass = "";
			$my_users_table->cobj->ViewCustomAttributes = "";

			// uid
			$my_users_table->uid->HrefValue = "";

			// username
			$my_users_table->username->HrefValue = "";

			// gecos
			$my_users_table->gecos->HrefValue = "";

			// role
			$my_users_table->role->HrefValue = "";

			// gid
			$my_users_table->gid->HrefValue = "";

			// cobj
			$my_users_table->cobj->HrefValue = "";
		}

		// Call Row Rendered event
		$my_users_table->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $my_users_table;

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
		global $my_users_table;
		$my_users_table->uid->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_uid");
		$my_users_table->username->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_username");
		$my_users_table->gecos->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_gecos");
		$my_users_table->role->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_role");
		$my_users_table->gid->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_gid");
		$my_users_table->cobj->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_cobj");
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
