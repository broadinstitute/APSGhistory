<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "bjobsinfo.php" ?>
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
$bjobs_list = new cbjobs_list();
$Page =& $bjobs_list;

// Page init processing
$bjobs_list->Page_Init();

// Page main processing
$bjobs_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($bjobs->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var bjobs_list = new ew_Page("bjobs_list");

// page properties
bjobs_list.PageID = "list"; // page ID
var EW_PAGE_ID = bjobs_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
bjobs_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
bjobs_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
bjobs_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($bjobs->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($bjobs->Export == "" && $bjobs->SelectLimit);
	if (!$bSelectLimit)
		$rs = $bjobs_list->LoadRecordset();
	$bjobs_list->lTotalRecs = ($bSelectLimit) ? $bjobs->SelectRecordCount() : $rs->RecordCount();
	$bjobs_list->lStartRec = 1;
	if ($bjobs_list->lDisplayRecs <= 0) // Display all records
		$bjobs_list->lDisplayRecs = $bjobs_list->lTotalRecs;
	if (!($bjobs->ExportAll && $bjobs->Export <> ""))
		$bjobs_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $bjobs_list->LoadRecordset($bjobs_list->lStartRec-1, $bjobs_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Bjobs
</span></p>
<?php $bjobs_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fbjobslist" id="fbjobslist" class="ewForm" action="" method="post">
<?php if ($bjobs_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$bjobs_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$bjobs_list->lOptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$bjobs_list->lOptionCnt++; // edit
}
	$bjobs_list->lOptionCnt += count($bjobs_list->ListOptions->Items); // Custom list options
?>
<?php echo $bjobs->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($bjobs->checked->Visible) { // checked ?>
	<?php if ($bjobs->SortUrl($bjobs->checked) == "") { ?>
		<td>Checked</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $bjobs->SortUrl($bjobs->checked) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Checked</td><td style="width: 10px;"><?php if ($bjobs->checked->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($bjobs->checked->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($bjobs->jobslots->Visible) { // jobslots ?>
	<?php if ($bjobs->SortUrl($bjobs->jobslots) == "") { ?>
		<td>Jobslots</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $bjobs->SortUrl($bjobs->jobslots) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Jobslots</td><td style="width: 10px;"><?php if ($bjobs->jobslots->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($bjobs->jobslots->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($bjobs->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($bjobs_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($bjobs->ExportAll && $bjobs->Export <> "") {
	$bjobs_list->lStopRec = $bjobs_list->lTotalRecs;
} else {
	$bjobs_list->lStopRec = $bjobs_list->lStartRec + $bjobs_list->lDisplayRecs - 1; // Set the last record to display
}
$bjobs_list->lRecCount = $bjobs_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bjobs->SelectLimit && $bjobs_list->lStartRec > 1)
		$rs->Move($bjobs_list->lStartRec - 1);
}
$bjobs_list->lRowCnt = 0;
while (($bjobs->CurrentAction == "gridadd" || !$rs->EOF) &&
	$bjobs_list->lRecCount < $bjobs_list->lStopRec) {
	$bjobs_list->lRecCount++;
	if (intval($bjobs_list->lRecCount) >= intval($bjobs_list->lStartRec)) {
		$bjobs_list->lRowCnt++;

	// Init row class and style
	$bjobs->CssClass = "";
	$bjobs->CssStyle = "";
	$bjobs->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($bjobs->CurrentAction == "gridadd") {
		$bjobs_list->LoadDefaultValues(); // Load default values
	} else {
		$bjobs_list->LoadRowValues($rs); // Load row values
	}
	$bjobs->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$bjobs_list->RenderRow();
?>
	<tr<?php echo $bjobs->RowAttributes() ?>>
	<?php if ($bjobs->checked->Visible) { // checked ?>
		<td<?php echo $bjobs->checked->CellAttributes() ?>>
<div<?php echo $bjobs->checked->ViewAttributes() ?>><?php echo $bjobs->checked->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($bjobs->jobslots->Visible) { // jobslots ?>
		<td<?php echo $bjobs->jobslots->CellAttributes() ?>>
<div<?php echo $bjobs->jobslots->ViewAttributes() ?>><?php echo $bjobs->jobslots->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($bjobs->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $bjobs->ViewUrl() ?>">View</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $bjobs->EditUrl() ?>">Edit</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($bjobs_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($bjobs->CurrentAction <> "gridadd")
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
<?php if ($bjobs->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($bjobs->CurrentAction <> "gridadd" && $bjobs->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($bjobs_list->Pager)) $bjobs_list->Pager = new cPrevNextPager($bjobs_list->lStartRec, $bjobs_list->lDisplayRecs, $bjobs_list->lTotalRecs) ?>
<?php if ($bjobs_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($bjobs_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $bjobs_list->PageUrl() ?>start=<?php echo $bjobs_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($bjobs_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $bjobs_list->PageUrl() ?>start=<?php echo $bjobs_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $bjobs_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($bjobs_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $bjobs_list->PageUrl() ?>start=<?php echo $bjobs_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($bjobs_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $bjobs_list->PageUrl() ?>start=<?php echo $bjobs_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $bjobs_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $bjobs_list->Pager->FromIndex ?> to <?php echo $bjobs_list->Pager->ToIndex ?> of <?php echo $bjobs_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($bjobs_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($bjobs_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($bjobs->Export == "" && $bjobs->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(bjobs_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($bjobs->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$bjobs_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cbjobs_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'bjobs';

	// Page Object Name
	var $PageObjName = 'bjobs_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $bjobs;
		if ($bjobs->UseTokenInUrl) $PageUrl .= "t=" . $bjobs->TableVar . "&"; // add page token
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
		global $objForm, $bjobs;
		if ($bjobs->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($bjobs->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($bjobs->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cbjobs_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["bjobs"] = new cbjobs();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'bjobs', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $bjobs;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$bjobs->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $bjobs->Export; // Get export parameter, used in header
	$gsExportFile = $bjobs->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $bjobs;
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
		if ($bjobs->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $bjobs->getRecordsPerPage(); // Restore from Session
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
		$bjobs->setSessionWhere($sFilter);
		$bjobs->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $bjobs;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$bjobs->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$bjobs->CurrentOrderType = @$_GET["ordertype"];
			$bjobs->UpdateSort($bjobs->checked); // Field 
			$bjobs->UpdateSort($bjobs->jobslots); // Field 
			$bjobs->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $bjobs;
		$sOrderBy = $bjobs->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($bjobs->SqlOrderBy() <> "") {
				$sOrderBy = $bjobs->SqlOrderBy();
				$bjobs->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $bjobs;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$bjobs->setSessionOrderBy($sOrderBy);
				$bjobs->checked->setSort("");
				$bjobs->jobslots->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$bjobs->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $bjobs;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$bjobs->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$bjobs->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $bjobs->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$bjobs->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$bjobs->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$bjobs->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $bjobs;

		// Call Recordset Selecting event
		$bjobs->Recordset_Selecting($bjobs->CurrentFilter);

		// Load list page SQL
		$sSql = $bjobs->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$bjobs->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $bjobs;
		$sFilter = $bjobs->KeyFilter();

		// Call Row Selecting event
		$bjobs->Row_Selecting($sFilter);

		// Load sql based on filter
		$bjobs->CurrentFilter = $sFilter;
		$sSql = $bjobs->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$bjobs->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $bjobs;
		$bjobs->checked->setDbValue($rs->fields('checked'));
		$bjobs->jobslots->setDbValue($rs->fields('jobslots'));
		$bjobs->bjobs->Upload->DbValue = $rs->fields('bjobs');
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $bjobs;

		// Call Row_Rendering event
		$bjobs->Row_Rendering();

		// Common render codes for all row types
		// checked

		$bjobs->checked->CellCssStyle = "";
		$bjobs->checked->CellCssClass = "";

		// jobslots
		$bjobs->jobslots->CellCssStyle = "";
		$bjobs->jobslots->CellCssClass = "";
		if ($bjobs->RowType == EW_ROWTYPE_VIEW) { // View row

			// checked
			$bjobs->checked->ViewValue = $bjobs->checked->CurrentValue;
			$bjobs->checked->CssStyle = "";
			$bjobs->checked->CssClass = "";
			$bjobs->checked->ViewCustomAttributes = "";

			// jobslots
			$bjobs->jobslots->ViewValue = $bjobs->jobslots->CurrentValue;
			$bjobs->jobslots->CssStyle = "";
			$bjobs->jobslots->CssClass = "";
			$bjobs->jobslots->ViewCustomAttributes = "";

			// checked
			$bjobs->checked->HrefValue = "";

			// jobslots
			$bjobs->jobslots->HrefValue = "";
		}

		// Call Row Rendered event
		$bjobs->Row_Rendered();
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
