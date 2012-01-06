<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "usersinfo.php" ?>
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
$users_view = new cusers_view();
$Page =& $users_view;

// Page init
$users_view->Page_Init();

// Page main
$users_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var users_view = new ew_Page("users_view");

// page properties
users_view.PageID = "view"; // page ID
users_view.FormID = "fusersview"; // form ID
var EW_PAGE_ID = users_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
users_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
users_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
users_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $users->TableCaption() ?>
<br><br>
<?php if ($users->Export == "") { ?>
<a href="<?php echo $users_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $users_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="filesystemlist.php?<?php echo EW_TABLE_SHOW_MASTER ?>=users&uid=<?php echo urlencode(strval($users->uid->CurrentValue)) ?>"><?php echo $Language->Phrase("ViewPageDetailLink") ?><?php echo $Language->TablePhrase("filesystem", "TblCaption") ?>
</a>
&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$users_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($users->uid->Visible) { // uid ?>
	<tr<?php echo $users->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $users->uid->FldCaption() ?></td>
		<td<?php echo $users->uid->CellAttributes() ?>>
<div<?php echo $users->uid->ViewAttributes() ?>><?php echo $users->uid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($users->username->Visible) { // username ?>
	<tr<?php echo $users->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $users->username->FldCaption() ?></td>
		<td<?php echo $users->username->CellAttributes() ?>>
<div<?php echo $users->username->ViewAttributes() ?>><?php echo $users->username->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($users->gecos->Visible) { // gecos ?>
	<tr<?php echo $users->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $users->gecos->FldCaption() ?></td>
		<td<?php echo $users->gecos->CellAttributes() ?>>
<div<?php echo $users->gecos->ViewAttributes() ?>><?php echo $users->gecos->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($users->role->Visible) { // role ?>
	<tr<?php echo $users->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $users->role->FldCaption() ?></td>
		<td<?php echo $users->role->CellAttributes() ?>>
<div<?php echo $users->role->ViewAttributes() ?>><?php echo $users->role->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($users->gid->Visible) { // gid ?>
	<tr<?php echo $users->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $users->gid->FldCaption() ?></td>
		<td<?php echo $users->gid->CellAttributes() ?>>
<div<?php echo $users->gid->ViewAttributes() ?>><?php echo $users->gid->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($users->cobj->Visible) { // cobj ?>
	<tr<?php echo $users->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $users->cobj->FldCaption() ?></td>
		<td<?php echo $users->cobj->CellAttributes() ?>>
<div<?php echo $users->cobj->ViewAttributes() ?>><?php echo $users->cobj->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($users->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$users_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cusers_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $users;
		if ($users->UseTokenInUrl) $PageUrl .= "t=" . $users->TableVar . "&"; // Add page token
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
		global $objForm, $users;
		if ($users->UseTokenInUrl) {
			if ($objForm)
				return ($users->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($users->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cusers_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (users)
		$GLOBALS["users"] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

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
		global $users;

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
		global $Language, $users;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["uid"] <> "") {
				$users->uid->setQueryStringValue($_GET["uid"]);
				$this->arRecKey["uid"] = $users->uid->QueryStringValue;
			} else {
				$sReturnUrl = "userslist.php"; // Return to list
			}

			// Get action
			$users->CurrentAction = "I"; // Display form
			switch ($users->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "userslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "userslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$users->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $users;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$users->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$users->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $users->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$users->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$users->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$users->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $users;
		$sFilter = $users->KeyFilter();

		// Call Row Selecting event
		$users->Row_Selecting($sFilter);

		// Load SQL based on filter
		$users->CurrentFilter = $sFilter;
		$sSql = $users->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$users->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $users;
		$users->uid->setDbValue($rs->fields('uid'));
		$users->username->setDbValue($rs->fields('username'));
		$users->gecos->setDbValue($rs->fields('gecos'));
		$users->role->setDbValue($rs->fields('role'));
		$users->gid->setDbValue($rs->fields('gid'));
		$users->cobj->setDbValue($rs->fields('cobj'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $users;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "uid=" . urlencode($users->uid->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "uid=" . urlencode($users->uid->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "uid=" . urlencode($users->uid->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "uid=" . urlencode($users->uid->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "uid=" . urlencode($users->uid->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "uid=" . urlencode($users->uid->CurrentValue);
		$this->AddUrl = $users->AddUrl();
		$this->EditUrl = $users->EditUrl();
		$this->CopyUrl = $users->CopyUrl();
		$this->DeleteUrl = $users->DeleteUrl();
		$this->ListUrl = $users->ListUrl();

		// Call Row_Rendering event
		$users->Row_Rendering();

		// Common render codes for all row types
		// uid

		$users->uid->CellCssStyle = ""; $users->uid->CellCssClass = "";
		$users->uid->CellAttrs = array(); $users->uid->ViewAttrs = array(); $users->uid->EditAttrs = array();

		// username
		$users->username->CellCssStyle = ""; $users->username->CellCssClass = "";
		$users->username->CellAttrs = array(); $users->username->ViewAttrs = array(); $users->username->EditAttrs = array();

		// gecos
		$users->gecos->CellCssStyle = ""; $users->gecos->CellCssClass = "";
		$users->gecos->CellAttrs = array(); $users->gecos->ViewAttrs = array(); $users->gecos->EditAttrs = array();

		// role
		$users->role->CellCssStyle = ""; $users->role->CellCssClass = "";
		$users->role->CellAttrs = array(); $users->role->ViewAttrs = array(); $users->role->EditAttrs = array();

		// gid
		$users->gid->CellCssStyle = ""; $users->gid->CellCssClass = "";
		$users->gid->CellAttrs = array(); $users->gid->ViewAttrs = array(); $users->gid->EditAttrs = array();

		// cobj
		$users->cobj->CellCssStyle = ""; $users->cobj->CellCssClass = "";
		$users->cobj->CellAttrs = array(); $users->cobj->ViewAttrs = array(); $users->cobj->EditAttrs = array();
		if ($users->RowType == EW_ROWTYPE_VIEW) { // View row

			// uid
			$users->uid->ViewValue = $users->uid->CurrentValue;
			$users->uid->CssStyle = "";
			$users->uid->CssClass = "";
			$users->uid->ViewCustomAttributes = "";

			// username
			$users->username->ViewValue = $users->username->CurrentValue;
			$users->username->CssStyle = "";
			$users->username->CssClass = "";
			$users->username->ViewCustomAttributes = "";

			// gecos
			$users->gecos->ViewValue = $users->gecos->CurrentValue;
			$users->gecos->CssStyle = "";
			$users->gecos->CssClass = "";
			$users->gecos->ViewCustomAttributes = "";

			// role
			$users->role->ViewValue = $users->role->CurrentValue;
			$users->role->CssStyle = "";
			$users->role->CssClass = "";
			$users->role->ViewCustomAttributes = "";

			// gid
			$users->gid->ViewValue = $users->gid->CurrentValue;
			$users->gid->CssStyle = "";
			$users->gid->CssClass = "";
			$users->gid->ViewCustomAttributes = "";

			// cobj
			$users->cobj->ViewValue = $users->cobj->CurrentValue;
			$users->cobj->CssStyle = "";
			$users->cobj->CssClass = "";
			$users->cobj->ViewCustomAttributes = "";

			// uid
			$users->uid->HrefValue = "";
			$users->uid->TooltipValue = "";

			// username
			$users->username->HrefValue = "";
			$users->username->TooltipValue = "";

			// gecos
			$users->gecos->HrefValue = "";
			$users->gecos->TooltipValue = "";

			// role
			$users->role->HrefValue = "";
			$users->role->TooltipValue = "";

			// gid
			$users->gid->HrefValue = "";
			$users->gid->TooltipValue = "";

			// cobj
			$users->cobj->HrefValue = "";
			$users->cobj->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($users->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$users->Row_Rendered();
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
