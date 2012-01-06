<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "acct_updateinfo.php" ?>
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
$acct_update_list = new cacct_update_list();
$Page =& $acct_update_list;

// Page init processing
$acct_update_list->Page_Init();

// Page main processing
$acct_update_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($acct_update->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var acct_update_list = new ew_Page("acct_update_list");

// page properties
acct_update_list.PageID = "list"; // page ID
var EW_PAGE_ID = acct_update_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
acct_update_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
acct_update_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
acct_update_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($acct_update->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($acct_update->Export == "" && $acct_update->SelectLimit);
	if (!$bSelectLimit)
		$rs = $acct_update_list->LoadRecordset();
	$acct_update_list->lTotalRecs = ($bSelectLimit) ? $acct_update->SelectRecordCount() : $rs->RecordCount();
	$acct_update_list->lStartRec = 1;
	if ($acct_update_list->lDisplayRecs <= 0) // Display all records
		$acct_update_list->lDisplayRecs = $acct_update_list->lTotalRecs;
	if (!($acct_update->ExportAll && $acct_update->Export <> ""))
		$acct_update_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $acct_update_list->LoadRecordset($acct_update_list->lStartRec-1, $acct_update_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Acct Update
</span></p>
<?php $acct_update_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="facct_updatelist" id="facct_updatelist" class="ewForm" action="" method="post">
<?php if ($acct_update_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$acct_update_list->lOptionCnt = 0;
	$acct_update_list->lOptionCnt += count($acct_update_list->ListOptions->Items); // Custom list options
?>
<?php echo $acct_update->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($acct_update->date->Visible) { // date ?>
	<?php if ($acct_update->SortUrl($acct_update->date) == "") { ?>
		<td>Date</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $acct_update->SortUrl($acct_update->date) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Date</td><td style="width: 10px;"><?php if ($acct_update->date->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($acct_update->date->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($acct_update->sum->Visible) { // sum ?>
	<?php if ($acct_update->SortUrl($acct_update->sum) == "") { ?>
		<td>Sum</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $acct_update->SortUrl($acct_update->sum) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Sum</td><td style="width: 10px;"><?php if ($acct_update->sum->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($acct_update->sum->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($acct_update->Export == "") { ?>
<?php

// Custom list options
foreach ($acct_update_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($acct_update->ExportAll && $acct_update->Export <> "") {
	$acct_update_list->lStopRec = $acct_update_list->lTotalRecs;
} else {
	$acct_update_list->lStopRec = $acct_update_list->lStartRec + $acct_update_list->lDisplayRecs - 1; // Set the last record to display
}
$acct_update_list->lRecCount = $acct_update_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$acct_update->SelectLimit && $acct_update_list->lStartRec > 1)
		$rs->Move($acct_update_list->lStartRec - 1);
}
$acct_update_list->lRowCnt = 0;
while (($acct_update->CurrentAction == "gridadd" || !$rs->EOF) &&
	$acct_update_list->lRecCount < $acct_update_list->lStopRec) {
	$acct_update_list->lRecCount++;
	if (intval($acct_update_list->lRecCount) >= intval($acct_update_list->lStartRec)) {
		$acct_update_list->lRowCnt++;

	// Init row class and style
	$acct_update->CssClass = "";
	$acct_update->CssStyle = "";
	$acct_update->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($acct_update->CurrentAction == "gridadd") {
		$acct_update_list->LoadDefaultValues(); // Load default values
	} else {
		$acct_update_list->LoadRowValues($rs); // Load row values
	}
	$acct_update->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$acct_update_list->RenderRow();
?>
	<tr<?php echo $acct_update->RowAttributes() ?>>
	<?php if ($acct_update->date->Visible) { // date ?>
		<td<?php echo $acct_update->date->CellAttributes() ?>>
<div<?php echo $acct_update->date->ViewAttributes() ?>><?php echo $acct_update->date->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($acct_update->sum->Visible) { // sum ?>
		<td<?php echo $acct_update->sum->CellAttributes() ?>>
<div<?php echo $acct_update->sum->ViewAttributes() ?>><?php echo $acct_update->sum->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($acct_update->Export == "") { ?>
<?php

// Custom list options
foreach ($acct_update_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($acct_update->CurrentAction <> "gridadd")
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
<?php if ($acct_update->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($acct_update->CurrentAction <> "gridadd" && $acct_update->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($acct_update_list->Pager)) $acct_update_list->Pager = new cPrevNextPager($acct_update_list->lStartRec, $acct_update_list->lDisplayRecs, $acct_update_list->lTotalRecs) ?>
<?php if ($acct_update_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($acct_update_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $acct_update_list->PageUrl() ?>start=<?php echo $acct_update_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($acct_update_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $acct_update_list->PageUrl() ?>start=<?php echo $acct_update_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $acct_update_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($acct_update_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $acct_update_list->PageUrl() ?>start=<?php echo $acct_update_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($acct_update_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $acct_update_list->PageUrl() ?>start=<?php echo $acct_update_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $acct_update_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $acct_update_list->Pager->FromIndex ?> to <?php echo $acct_update_list->Pager->ToIndex ?> of <?php echo $acct_update_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($acct_update_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($acct_update_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($acct_update->Export == "" && $acct_update->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(acct_update_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($acct_update->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$acct_update_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class cacct_update_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'acct_update';

	// Page Object Name
	var $PageObjName = 'acct_update_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $acct_update;
		if ($acct_update->UseTokenInUrl) $PageUrl .= "t=" . $acct_update->TableVar . "&"; // add page token
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
		global $objForm, $acct_update;
		if ($acct_update->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($acct_update->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($acct_update->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cacct_update_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["acct_update"] = new cacct_update();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'acct_update', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $acct_update;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$acct_update->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $acct_update->Export; // Get export parameter, used in header
	$gsExportFile = $acct_update->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $acct_update;
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
		if ($acct_update->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $acct_update->getRecordsPerPage(); // Restore from Session
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
		$acct_update->setSessionWhere($sFilter);
		$acct_update->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $acct_update;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$acct_update->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$acct_update->CurrentOrderType = @$_GET["ordertype"];
			$acct_update->UpdateSort($acct_update->date); // Field 
			$acct_update->UpdateSort($acct_update->sum); // Field 
			$acct_update->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $acct_update;
		$sOrderBy = $acct_update->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($acct_update->SqlOrderBy() <> "") {
				$sOrderBy = $acct_update->SqlOrderBy();
				$acct_update->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $acct_update;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$acct_update->setSessionOrderBy($sOrderBy);
				$acct_update->date->setSort("");
				$acct_update->sum->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$acct_update->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $acct_update;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$acct_update->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$acct_update->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $acct_update->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$acct_update->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$acct_update->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$acct_update->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $acct_update;

		// Call Recordset Selecting event
		$acct_update->Recordset_Selecting($acct_update->CurrentFilter);

		// Load list page SQL
		$sSql = $acct_update->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$acct_update->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $acct_update;
		$sFilter = $acct_update->KeyFilter();

		// Call Row Selecting event
		$acct_update->Row_Selecting($sFilter);

		// Load sql based on filter
		$acct_update->CurrentFilter = $sFilter;
		$sSql = $acct_update->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$acct_update->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $acct_update;
		$acct_update->date->setDbValue($rs->fields('date'));
		$acct_update->sum->setDbValue($rs->fields('sum'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $acct_update;

		// Call Row_Rendering event
		$acct_update->Row_Rendering();

		// Common render codes for all row types
		// date

		$acct_update->date->CellCssStyle = "";
		$acct_update->date->CellCssClass = "";

		// sum
		$acct_update->sum->CellCssStyle = "";
		$acct_update->sum->CellCssClass = "";
		if ($acct_update->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$acct_update->date->ViewValue = $acct_update->date->CurrentValue;
			$acct_update->date->CssStyle = "";
			$acct_update->date->CssClass = "";
			$acct_update->date->ViewCustomAttributes = "";

			// sum
			$acct_update->sum->ViewValue = $acct_update->sum->CurrentValue;
			$acct_update->sum->CssStyle = "";
			$acct_update->sum->CssClass = "";
			$acct_update->sum->ViewCustomAttributes = "";

			// date
			$acct_update->date->HrefValue = "";

			// sum
			$acct_update->sum->HrefValue = "";
		}

		// Call Row Rendered event
		$acct_update->Row_Rendered();
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
