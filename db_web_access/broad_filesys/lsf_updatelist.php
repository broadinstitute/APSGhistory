<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_updateinfo.php" ?>
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
$lsf_update_list = new clsf_update_list();
$Page =& $lsf_update_list;

// Page init processing
$lsf_update_list->Page_Init();

// Page main processing
$lsf_update_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lsf_update->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_update_list = new ew_Page("lsf_update_list");

// page properties
lsf_update_list.PageID = "list"; // page ID
var EW_PAGE_ID = lsf_update_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_update_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_update_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_update_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($lsf_update->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($lsf_update->Export == "" && $lsf_update->SelectLimit);
	if (!$bSelectLimit)
		$rs = $lsf_update_list->LoadRecordset();
	$lsf_update_list->lTotalRecs = ($bSelectLimit) ? $lsf_update->SelectRecordCount() : $rs->RecordCount();
	$lsf_update_list->lStartRec = 1;
	if ($lsf_update_list->lDisplayRecs <= 0) // Display all records
		$lsf_update_list->lDisplayRecs = $lsf_update_list->lTotalRecs;
	if (!($lsf_update->ExportAll && $lsf_update->Export <> ""))
		$lsf_update_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $lsf_update_list->LoadRecordset($lsf_update_list->lStartRec-1, $lsf_update_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: Lsf Update
</span></p>
<?php $lsf_update_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="flsf_updatelist" id="flsf_updatelist" class="ewForm" action="" method="post">
<?php if ($lsf_update_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$lsf_update_list->lOptionCnt = 0;
	$lsf_update_list->lOptionCnt += count($lsf_update_list->ListOptions->Items); // Custom list options
?>
<?php echo $lsf_update->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($lsf_update->last_update->Visible) { // last_update ?>
	<?php if ($lsf_update->SortUrl($lsf_update->last_update) == "") { ?>
		<td>Last Update</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $lsf_update->SortUrl($lsf_update->last_update) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Last Update</td><td style="width: 10px;"><?php if ($lsf_update->last_update->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($lsf_update->last_update->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($lsf_update->Export == "") { ?>
<?php

// Custom list options
foreach ($lsf_update_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($lsf_update->ExportAll && $lsf_update->Export <> "") {
	$lsf_update_list->lStopRec = $lsf_update_list->lTotalRecs;
} else {
	$lsf_update_list->lStopRec = $lsf_update_list->lStartRec + $lsf_update_list->lDisplayRecs - 1; // Set the last record to display
}
$lsf_update_list->lRecCount = $lsf_update_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$lsf_update->SelectLimit && $lsf_update_list->lStartRec > 1)
		$rs->Move($lsf_update_list->lStartRec - 1);
}
$lsf_update_list->lRowCnt = 0;
while (($lsf_update->CurrentAction == "gridadd" || !$rs->EOF) &&
	$lsf_update_list->lRecCount < $lsf_update_list->lStopRec) {
	$lsf_update_list->lRecCount++;
	if (intval($lsf_update_list->lRecCount) >= intval($lsf_update_list->lStartRec)) {
		$lsf_update_list->lRowCnt++;

	// Init row class and style
	$lsf_update->CssClass = "";
	$lsf_update->CssStyle = "";
	$lsf_update->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($lsf_update->CurrentAction == "gridadd") {
		$lsf_update_list->LoadDefaultValues(); // Load default values
	} else {
		$lsf_update_list->LoadRowValues($rs); // Load row values
	}
	$lsf_update->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$lsf_update_list->RenderRow();
?>
	<tr<?php echo $lsf_update->RowAttributes() ?>>
	<?php if ($lsf_update->last_update->Visible) { // last_update ?>
		<td<?php echo $lsf_update->last_update->CellAttributes() ?>>
<div<?php echo $lsf_update->last_update->ViewAttributes() ?>><?php echo $lsf_update->last_update->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($lsf_update->Export == "") { ?>
<?php

// Custom list options
foreach ($lsf_update_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($lsf_update->CurrentAction <> "gridadd")
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
<?php if ($lsf_update->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($lsf_update->CurrentAction <> "gridadd" && $lsf_update->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($lsf_update_list->Pager)) $lsf_update_list->Pager = new cPrevNextPager($lsf_update_list->lStartRec, $lsf_update_list->lDisplayRecs, $lsf_update_list->lTotalRecs) ?>
<?php if ($lsf_update_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($lsf_update_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_update_list->PageUrl() ?>start=<?php echo $lsf_update_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($lsf_update_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_update_list->PageUrl() ?>start=<?php echo $lsf_update_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $lsf_update_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($lsf_update_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_update_list->PageUrl() ?>start=<?php echo $lsf_update_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($lsf_update_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $lsf_update_list->PageUrl() ?>start=<?php echo $lsf_update_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $lsf_update_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Records <?php echo $lsf_update_list->Pager->FromIndex ?> to <?php echo $lsf_update_list->Pager->ToIndex ?> of <?php echo $lsf_update_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($lsf_update_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($lsf_update_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($lsf_update->Export == "" && $lsf_update->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(lsf_update_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($lsf_update->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lsf_update_list->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_update_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'lsf_update';

	// Page Object Name
	var $PageObjName = 'lsf_update_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_update;
		if ($lsf_update->UseTokenInUrl) $PageUrl .= "t=" . $lsf_update->TableVar . "&"; // add page token
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
		global $objForm, $lsf_update;
		if ($lsf_update->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_update->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_update->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_update_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_update"] = new clsf_update();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_update', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_update;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$lsf_update->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $lsf_update->Export; // Get export parameter, used in header
	$gsExportFile = $lsf_update->TableVar; // Get export file, used in header

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
		global $objForm, $gsSearchError, $Security, $lsf_update;
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
		if ($lsf_update->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $lsf_update->getRecordsPerPage(); // Restore from Session
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
		$lsf_update->setSessionWhere($sFilter);
		$lsf_update->CurrentFilter = "";
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $lsf_update;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$lsf_update->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$lsf_update->CurrentOrderType = @$_GET["ordertype"];
			$lsf_update->UpdateSort($lsf_update->last_update); // Field 
			$lsf_update->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $lsf_update;
		$sOrderBy = $lsf_update->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($lsf_update->SqlOrderBy() <> "") {
				$sOrderBy = $lsf_update->SqlOrderBy();
				$lsf_update->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $lsf_update;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$lsf_update->setSessionOrderBy($sOrderBy);
				$lsf_update->last_update->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$lsf_update->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $lsf_update;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lsf_update->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lsf_update->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lsf_update->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lsf_update->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lsf_update->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lsf_update->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $lsf_update;

		// Call Recordset Selecting event
		$lsf_update->Recordset_Selecting($lsf_update->CurrentFilter);

		// Load list page SQL
		$sSql = $lsf_update->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$lsf_update->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_update;
		$sFilter = $lsf_update->KeyFilter();

		// Call Row Selecting event
		$lsf_update->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_update->CurrentFilter = $sFilter;
		$sSql = $lsf_update->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_update->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_update;
		$lsf_update->last_update->setDbValue($rs->fields('last_update'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_update;

		// Call Row_Rendering event
		$lsf_update->Row_Rendering();

		// Common render codes for all row types
		// last_update

		$lsf_update->last_update->CellCssStyle = "";
		$lsf_update->last_update->CellCssClass = "";
		if ($lsf_update->RowType == EW_ROWTYPE_VIEW) { // View row

			// last_update
			$lsf_update->last_update->ViewValue = $lsf_update->last_update->CurrentValue;
			$lsf_update->last_update->CssStyle = "";
			$lsf_update->last_update->CssClass = "";
			$lsf_update->last_update->ViewCustomAttributes = "";

			// last_update
			$lsf_update->last_update->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_update->Row_Rendered();
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
