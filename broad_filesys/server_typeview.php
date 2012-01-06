<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "server_typeinfo.php" ?>
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
$server_type_view = new cserver_type_view();
$Page =& $server_type_view;

// Page init
$server_type_view->Page_Init();

// Page main
$server_type_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($server_type->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var server_type_view = new ew_Page("server_type_view");

// page properties
server_type_view.PageID = "view"; // page ID
server_type_view.FormID = "fserver_typeview"; // form ID
var EW_PAGE_ID = server_type_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
server_type_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
server_type_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
server_type_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $server_type->TableCaption() ?>
<br><br>
<?php if ($server_type->Export == "") { ?>
<a href="<?php echo $server_type_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $server_type_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="filesystemlist.php?<?php echo EW_TABLE_SHOW_MASTER ?>=server_type&id=<?php echo urlencode(strval($server_type->id->CurrentValue)) ?>"><?php echo $Language->Phrase("ViewPageDetailLink") ?><?php echo $Language->TablePhrase("filesystem", "TblCaption") ?>
</a>
&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$server_type_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($server_type->id->Visible) { // id ?>
	<tr<?php echo $server_type->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $server_type->id->FldCaption() ?></td>
		<td<?php echo $server_type->id->CellAttributes() ?>>
<div<?php echo $server_type->id->ViewAttributes() ?>><?php echo $server_type->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($server_type->name->Visible) { // name ?>
	<tr<?php echo $server_type->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $server_type->name->FldCaption() ?></td>
		<td<?php echo $server_type->name->CellAttributes() ?>>
<div<?php echo $server_type->name->ViewAttributes() ?>><?php echo $server_type->name->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($server_type->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$server_type_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cserver_type_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'server_type';

	// Page object name
	var $PageObjName = 'server_type_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $server_type;
		if ($server_type->UseTokenInUrl) $PageUrl .= "t=" . $server_type->TableVar . "&"; // Add page token
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
		global $objForm, $server_type;
		if ($server_type->UseTokenInUrl) {
			if ($objForm)
				return ($server_type->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($server_type->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cserver_type_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (server_type)
		$GLOBALS["server_type"] = new cserver_type();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'server_type', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $server_type;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

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
	var $lDisplayRecs = 1;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $lRecCnt;
	var $arRecKey = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $server_type;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$server_type->id->setQueryStringValue($_GET["id"]);
				$this->arRecKey["id"] = $server_type->id->QueryStringValue;
			} else {
				$sReturnUrl = "server_typelist.php"; // Return to list
			}

			// Get action
			$server_type->CurrentAction = "I"; // Display form
			switch ($server_type->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "server_typelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "server_typelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$server_type->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $server_type;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$server_type->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$server_type->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $server_type->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$server_type->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$server_type->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$server_type->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $server_type;
		$sFilter = $server_type->KeyFilter();

		// Call Row Selecting event
		$server_type->Row_Selecting($sFilter);

		// Load SQL based on filter
		$server_type->CurrentFilter = $sFilter;
		$sSql = $server_type->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$server_type->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $server_type;
		$server_type->id->setDbValue($rs->fields('id'));
		$server_type->name->setDbValue($rs->fields('name'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $server_type;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id=" . urlencode($server_type->id->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id=" . urlencode($server_type->id->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id=" . urlencode($server_type->id->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id=" . urlencode($server_type->id->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id=" . urlencode($server_type->id->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id=" . urlencode($server_type->id->CurrentValue);
		$this->AddUrl = $server_type->AddUrl();
		$this->EditUrl = $server_type->EditUrl();
		$this->CopyUrl = $server_type->CopyUrl();
		$this->DeleteUrl = $server_type->DeleteUrl();
		$this->ListUrl = $server_type->ListUrl();

		// Call Row_Rendering event
		$server_type->Row_Rendering();

		// Common render codes for all row types
		// id

		$server_type->id->CellCssStyle = ""; $server_type->id->CellCssClass = "";
		$server_type->id->CellAttrs = array(); $server_type->id->ViewAttrs = array(); $server_type->id->EditAttrs = array();

		// name
		$server_type->name->CellCssStyle = ""; $server_type->name->CellCssClass = "";
		$server_type->name->CellAttrs = array(); $server_type->name->ViewAttrs = array(); $server_type->name->EditAttrs = array();
		if ($server_type->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$server_type->id->ViewValue = $server_type->id->CurrentValue;
			$server_type->id->CssStyle = "";
			$server_type->id->CssClass = "";
			$server_type->id->ViewCustomAttributes = "";

			// name
			$server_type->name->ViewValue = $server_type->name->CurrentValue;
			$server_type->name->CssStyle = "";
			$server_type->name->CssClass = "";
			$server_type->name->ViewCustomAttributes = "";

			// id
			$server_type->id->HrefValue = "";
			$server_type->id->TooltipValue = "";

			// name
			$server_type->name->HrefValue = "";
			$server_type->name->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($server_type->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$server_type->Row_Rendered();
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
}
?>
