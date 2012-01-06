<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "fsusageinfo.php" ?>
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
$fsusage_list = new cfsusage_list();
$Page =& $fsusage_list;

// Page init processing
$fsusage_list->Page_Init();

// Page main processing
$fsusage_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($fsusage->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var fsusage_list = new ew_Page("fsusage_list");

// page properties
fsusage_list.PageID = "list"; // page ID
var EW_PAGE_ID = fsusage_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
fsusage_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
fsusage_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
fsusage_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($fsusage->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($fsusage->Export == "" && $fsusage->SelectLimit);
	if (!$bSelectLimit)
		$rs = $fsusage_list->LoadRecordset();
	$fsusage_list->lTotalRecs = ($bSelectLimit) ? $fsusage->SelectRecordCount() : $rs->RecordCount();
	$fsusage_list->lStartRec = 1;
	if ($fsusage_list->lDisplayRecs <= 0) // Display all records
		$fsusage_list->lDisplayRecs = $fsusage_list->lTotalRecs;
	if (!($fsusage->ExportAll && $fsusage->Export <> ""))
		$fsusage_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $fsusage_list->LoadRecordset($fsusage_list->lStartRec-1, $fsusage_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Fsusage
</span></p>
<?php $fsusage_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="ffsusagelist" id="ffsusagelist" class="ewForm" action="" method="post">
<?php if ($fsusage_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$fsusage_list->lOptionCnt = 0;
	$fsusage_list->lOptionCnt += count($fsusage_list->ListOptions->Items); // Custom list options
?>
<?php echo $fsusage->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($fsusage->fsid->Visible) { // fsid ?>
	<?php if ($fsusage->SortUrl($fsusage->fsid) == "") { ?>
		<td>Fsid</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsusage->SortUrl($fsusage->fsid) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fsid</td><td style="width: 10px;"><?php if ($fsusage->fsid->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsusage->fsid->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsusage->checked->Visible) { // checked ?>
	<?php if ($fsusage->SortUrl($fsusage->checked) == "") { ?>
		<td>Checked</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsusage->SortUrl($fsusage->checked) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Checked</td><td style="width: 10px;"><?php if ($fsusage->checked->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsusage->checked->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsusage->blocks->Visible) { // blocks ?>
	<?php if ($fsusage->SortUrl($fsusage->blocks) == "") { ?>
		<td>Blocks</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsusage->SortUrl($fsusage->blocks) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Blocks</td><td style="width: 10px;"><?php if ($fsusage->blocks->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsusage->blocks->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsusage->used->Visible) { // used ?>
	<?php if ($fsusage->SortUrl($fsusage->used) == "") { ?>
		<td>Used</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsusage->SortUrl($fsusage->used) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Used</td><td style="width: 10px;"><?php if ($fsusage->used->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsusage->used->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsusage->available->Visible) { // available ?>
	<?php if ($fsusage->SortUrl($fsusage->available) == "") { ?>
		<td>Available</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsusage->SortUrl($fsusage->available) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Available</td><td style="width: 10px;"><?php if ($fsusage->available->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsusage->available->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsusage->capacity->Visible) { // capacity ?>
	<?php if ($fsusage->SortUrl($fsusage->capacity) == "") { ?>
		<td>Capacity</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $fsusage->SortUrl($fsusage->capacity) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Capacity</td><td style="width: 10px;"><?php if ($fsusage->capacity->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($fsusage->capacity->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($fsusage->Export == "") { ?>
<?php

// Custom list options
foreach ($fsusage_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($fsusage->ExportAll && $fsusage->Export <> "") {
	$fsusage_list->lStopRec = $fsusage_list->lTotalRecs;
} else {
	$fsusage_list->lStopRec = $fsusage_list->lStartRec + $fsusage_list->lDisplayRecs - 1; // Set the last record to display
}
$fsusage_list->lRecCount = $fsusage_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$fsusage->SelectLimit && $fsusage_list->lStartRec > 1)
		$rs->Move($fsusage_list->lStartRec - 1);
}
$fsusage_list->lRowCnt = 0;
while (($fsusage->CurrentAction == "gridadd" || !$rs->EOF) &&
	$fsusage_list->lRecCount < $fsusage_list->lStopRec) {
	$fsusage_list->lRecCount++;
	if (intval($fsusage_list->lRecCount) >= intval($fsusage_list->lStartRec)) {
		$fsusage_list->lRowCnt++;

	// Init row class and style
	$fsusage->CssClass = "";
	$fsusage->CssStyle = "";
	$fsusage->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($fsusage->CurrentAction == "gridadd") {
		$fsusage_list->LoadDefaultValues(); // Load default values
	} else {
		$fsusage_list->LoadRowValues($rs); // Load row values
	}
	$fsusage->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$fsusage_list->RenderRow();
?>
	<tr<?php echo $fsusage->RowAttributes() ?>>
	<?php if ($fsusage->fsid->Visible) { // fsid ?>
		<td<?php echo $fsusage->fsid->CellAttributes() ?>>
<div<?php echo $fsusage->fsid->ViewAttributes() ?>><?php echo $fsusage->fsid->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsusage->checked->Visible) { // checked ?>
		<td<?php echo $fsusage->checked->CellAttributes() ?>>
<div<?php echo $fsusage->checked->ViewAttributes() ?>><?php echo $fsusage->checked->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsusage->blocks->Visible) { // blocks ?>
		<td<?php echo $fsusage->blocks->CellAttributes() ?>>
<div<?php echo $fsusage->blocks->ViewAttributes() ?>><?php echo $fsusage->blocks->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsusage->used->Visible) { // used ?>
		<td<?php echo $fsusage->used->CellAttributes() ?>>
<div<?php echo $fsusage->used->ViewAttributes() ?>><?php echo $fsusage->used->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsusage->available->Visible) { // available ?>
		<td<?php echo $fsusage->available->CellAttributes() ?>>
<div<?php echo $fsusage->available->ViewAttributes() ?>><?php echo $fsusage->available->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($fsusage->capacity->Visible) { // capacity ?>
		<td<?php echo $fsusage->capacity->CellAttributes() ?>>
<div<?php echo $fsusage->capacity->ViewAttributes() ?>><?php echo $fsusage->capacity->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($fsusage->Export == "") { ?>
<?php

// Custom list options
foreach ($fsusage_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($fsusage->CurrentAction <> "gridadd")
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
<?php if ($fsusage->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($fsusage->CurrentAction <> "gridadd" && $fsusage->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($fsusage_list->Pager)) $fsusage_list->Pager = new cPrevNextPager($fsusage_list->lStartRec, $fsusage_list->lDisplayRecs, $fsusage_list->lTotalRecs) ?>
<?php if ($fsusage_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($fsusage_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $fsusage_list->PageUrl() ?>start=<?php echo $fsusage_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($fsusage_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $fsusage_list->PageUrl() ?>start=<?php echo $fsusage_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $fsusage_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($fsusage_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $fsusage_list->PageUrl() ?>start=<?php echo $fsusage_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($fsusage_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $fsusage_list->PageUrl() ?>start=<?php echo $fsusage_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $fsusage_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $fsusage_list->Pager->FromIndex ?> to <?php echo $fsusage_list->Pager->ToIndex ?> of <?php echo $fsusage_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($fsusage_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($fsusage_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($fsusage->Export == "" && $fsusage->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(fsusage_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($fsusage->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$fsusage_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cfsusage_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'fsusage';

	// Page Object Name
	var $PageObjName = 'fsusage_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $fsusage;
		if ($fsusage->UseTokenInUrl) $PageUrl .= "t=" . $fsusage->TableVar . "&"; // add page token
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
		global $objForm, $fsusage;
		if ($fsusage->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($fsusage->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($fsusage->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cfsusage_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["fsusage"] = new cfsusage();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fsusage', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $fsusage;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$fsusage->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $fsusage->Export; // Get export parameter, used in header
	$gsExportFile = $fsusage->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $fsusage;
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
		if ($fsusage->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $fsusage->getRecordsPerPage(); // Restore from Session
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
		$fsusage->setSessionWhere($sFilter);
		$fsusage->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $fsusage;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$fsusage->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$fsusage->CurrentOrderType = @$_GET["ordertype"];
			$fsusage->UpdateSort($fsusage->fsid); // Field 
			$fsusage->UpdateSort($fsusage->checked); // Field 
			$fsusage->UpdateSort($fsusage->blocks); // Field 
			$fsusage->UpdateSort($fsusage->used); // Field 
			$fsusage->UpdateSort($fsusage->available); // Field 
			$fsusage->UpdateSort($fsusage->capacity); // Field 
			$fsusage->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $fsusage;
		$sOrderBy = $fsusage->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($fsusage->SqlOrderBy() <> "") {
				$sOrderBy = $fsusage->SqlOrderBy();
				$fsusage->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $fsusage;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$fsusage->setSessionOrderBy($sOrderBy);
				$fsusage->fsid->setSort("");
				$fsusage->checked->setSort("");
				$fsusage->blocks->setSort("");
				$fsusage->used->setSort("");
				$fsusage->available->setSort("");
				$fsusage->capacity->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$fsusage->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $fsusage;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$fsusage->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$fsusage->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $fsusage->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$fsusage->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$fsusage->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$fsusage->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $fsusage;

		// Call Recordset Selecting event
		$fsusage->Recordset_Selecting($fsusage->CurrentFilter);

		// Load list page SQL
		$sSql = $fsusage->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$fsusage->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $fsusage;
		$sFilter = $fsusage->KeyFilter();

		// Call Row Selecting event
		$fsusage->Row_Selecting($sFilter);

		// Load sql based on filter
		$fsusage->CurrentFilter = $sFilter;
		$sSql = $fsusage->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$fsusage->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $fsusage;
		$fsusage->fsid->setDbValue($rs->fields('fsid'));
		$fsusage->checked->setDbValue($rs->fields('checked'));
		$fsusage->blocks->setDbValue($rs->fields('blocks'));
		$fsusage->used->setDbValue($rs->fields('used'));
		$fsusage->available->setDbValue($rs->fields('available'));
		$fsusage->capacity->setDbValue($rs->fields('capacity'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $fsusage;

		// Call Row_Rendering event
		$fsusage->Row_Rendering();

		// Common render codes for all row types
		// fsid

		$fsusage->fsid->CellCssStyle = "";
		$fsusage->fsid->CellCssClass = "";

		// checked
		$fsusage->checked->CellCssStyle = "";
		$fsusage->checked->CellCssClass = "";

		// blocks
		$fsusage->blocks->CellCssStyle = "";
		$fsusage->blocks->CellCssClass = "";

		// used
		$fsusage->used->CellCssStyle = "";
		$fsusage->used->CellCssClass = "";

		// available
		$fsusage->available->CellCssStyle = "";
		$fsusage->available->CellCssClass = "";

		// capacity
		$fsusage->capacity->CellCssStyle = "";
		$fsusage->capacity->CellCssClass = "";
		if ($fsusage->RowType == EW_ROWTYPE_VIEW) { // View row

			// fsid
			$fsusage->fsid->ViewValue = $fsusage->fsid->CurrentValue;
			$fsusage->fsid->CssStyle = "";
			$fsusage->fsid->CssClass = "";
			$fsusage->fsid->ViewCustomAttributes = "";

			// checked
			$fsusage->checked->ViewValue = $fsusage->checked->CurrentValue;
			$fsusage->checked->CssStyle = "";
			$fsusage->checked->CssClass = "";
			$fsusage->checked->ViewCustomAttributes = "";

			// blocks
			$fsusage->blocks->ViewValue = $fsusage->blocks->CurrentValue;
			$fsusage->blocks->CssStyle = "";
			$fsusage->blocks->CssClass = "";
			$fsusage->blocks->ViewCustomAttributes = "";

			// used
			$fsusage->used->ViewValue = $fsusage->used->CurrentValue;
			$fsusage->used->CssStyle = "";
			$fsusage->used->CssClass = "";
			$fsusage->used->ViewCustomAttributes = "";

			// available
			$fsusage->available->ViewValue = $fsusage->available->CurrentValue;
			$fsusage->available->CssStyle = "";
			$fsusage->available->CssClass = "";
			$fsusage->available->ViewCustomAttributes = "";

			// capacity
			$fsusage->capacity->ViewValue = $fsusage->capacity->CurrentValue;
			$fsusage->capacity->CssStyle = "";
			$fsusage->capacity->CssClass = "";
			$fsusage->capacity->ViewCustomAttributes = "";

			// fsid
			$fsusage->fsid->HrefValue = "";

			// checked
			$fsusage->checked->HrefValue = "";

			// blocks
			$fsusage->blocks->HrefValue = "";

			// used
			$fsusage->used->HrefValue = "";

			// available
			$fsusage->available->HrefValue = "";

			// capacity
			$fsusage->capacity->HrefValue = "";
		}

		// Call Row Rendered event
		$fsusage->Row_Rendered();
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
