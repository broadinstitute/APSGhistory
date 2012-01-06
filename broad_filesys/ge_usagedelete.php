<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "ge_usageinfo.php" ?>
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
$ge_usage_delete = new cge_usage_delete();
$Page =& $ge_usage_delete;

// Page init processing
$ge_usage_delete->Page_Init();

// Page main processing
$ge_usage_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var ge_usage_delete = new ew_Page("ge_usage_delete");

// page properties
ge_usage_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = ge_usage_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ge_usage_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_usage_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_usage_delete.ValidateRequired = false; // no JavaScript validation
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
<?php

// Load records for display
$rs = $ge_usage_delete->LoadRecordset();
$ge_usage_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($ge_usage_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$ge_usage_delete->Page_Terminate("ge_usagelist.php"); // Return to list
}
?>
<p><span class="phpmaker">Delete From TABLE: Ge Usage<br><br>
<a href="<?php echo $ge_usage->getReturnUrl() ?>">Go Back</a></span></p>
<?php $ge_usage_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="ge_usage">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ge_usage_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $ge_usage->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Date</td>
		<td valign="top">Uid</td>
		<td valign="top">Qid</td>
		<td valign="top">Pid</td>
		<td valign="top">Cpu</td>
		<td valign="top">Job</td>
	</tr>
	</thead>
	<tbody>
<?php
$ge_usage_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$ge_usage_delete->lRecCnt++;

	// Set row properties
	$ge_usage->CssClass = "";
	$ge_usage->CssStyle = "";
	$ge_usage->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ge_usage_delete->LoadRowValues($rs);

	// Render row
	$ge_usage_delete->RenderRow();
?>
	<tr<?php echo $ge_usage->RowAttributes() ?>>
		<td<?php echo $ge_usage->date->CellAttributes() ?>>
<div<?php echo $ge_usage->date->ViewAttributes() ?>><?php echo $ge_usage->date->ListViewValue() ?></div></td>
		<td<?php echo $ge_usage->uid->CellAttributes() ?>>
<div<?php echo $ge_usage->uid->ViewAttributes() ?>><?php echo $ge_usage->uid->ListViewValue() ?></div></td>
		<td<?php echo $ge_usage->qid->CellAttributes() ?>>
<div<?php echo $ge_usage->qid->ViewAttributes() ?>><?php echo $ge_usage->qid->ListViewValue() ?></div></td>
		<td<?php echo $ge_usage->pid->CellAttributes() ?>>
<div<?php echo $ge_usage->pid->ViewAttributes() ?>><?php echo $ge_usage->pid->ListViewValue() ?></div></td>
		<td<?php echo $ge_usage->cpu->CellAttributes() ?>>
<div<?php echo $ge_usage->cpu->ViewAttributes() ?>><?php echo $ge_usage->cpu->ListViewValue() ?></div></td>
		<td<?php echo $ge_usage->job->CellAttributes() ?>>
<div<?php echo $ge_usage->job->ViewAttributes() ?>><?php echo $ge_usage->job->ListViewValue() ?></div></td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="Confirm Delete">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$ge_usage_delete->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_usage_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'ge_usage';

	// Page Object Name
	var $PageObjName = 'ge_usage_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ge_usage;
		if ($ge_usage->UseTokenInUrl) $PageUrl .= "t=" . $ge_usage->TableVar . "&"; // add page token
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
		global $objForm, $ge_usage;
		if ($ge_usage->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($ge_usage->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ge_usage->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cge_usage_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_usage"] = new cge_usage();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ge_usage', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ge_usage;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

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
	var $lTotalRecs;
	var $lRecCnt;
	var $arRecKeys = array();

	// Page main processing
	function Page_Main() {
		global $ge_usage;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["date"] <> "") {
			$ge_usage->date->setQueryStringValue($_GET["date"]);
			if (!is_numeric($ge_usage->date->QueryStringValue))
				$this->Page_Terminate("ge_usagelist.php"); // Prevent SQL injection, exit
			$sKey .= $ge_usage->date->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if (@$_GET["uid"] <> "") {
			$ge_usage->uid->setQueryStringValue($_GET["uid"]);
			if (!is_numeric($ge_usage->uid->QueryStringValue))
				$this->Page_Terminate("ge_usagelist.php"); // Prevent SQL injection, exit
			if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sKey .= $ge_usage->uid->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if (@$_GET["qid"] <> "") {
			$ge_usage->qid->setQueryStringValue($_GET["qid"]);
			if (!is_numeric($ge_usage->qid->QueryStringValue))
				$this->Page_Terminate("ge_usagelist.php"); // Prevent SQL injection, exit
			if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sKey .= $ge_usage->qid->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if ($bSingleDelete) {
			$nKeySelected = 1; // Set up key selected count
			$this->arRecKeys[0] = $sKey;
		} else {
			if (isset($_POST["key_m"])) { // Key in form
				$nKeySelected = count($_POST["key_m"]); // Set up key selected count
				$this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
			}
		}
		if ($nKeySelected <= 0)
			$this->Page_Terminate("ge_usagelist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";
			$arKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, trim($sKey)); // Split key by separator
			if (count($arKeyFlds) <> 3)
				$this->Page_Terminate($ge_usage->getReturnUrl()); // Invalid key, exit

			// Set up key field
			$sKeyFld = $arKeyFlds[0];
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("ge_usagelist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`date`=" . ew_AdjustSql($sKeyFld) . " AND ";

			// Set up key field
			$sKeyFld = $arKeyFlds[1];
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("ge_usagelist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`uid`=" . ew_AdjustSql($sKeyFld) . " AND ";

			// Set up key field
			$sKeyFld = $arKeyFlds[2];
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("ge_usagelist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`qid`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in ge_usage class, ge_usageinfo.php

		$ge_usage->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$ge_usage->CurrentAction = $_POST["a_delete"];
		} else {
			$ge_usage->CurrentAction = "I"; // Display record
		}
		switch ($ge_usage->CurrentAction) {
			case "D": // Delete
				$ge_usage->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Delete succeeded"); // Set up success message
					$this->Page_Terminate($ge_usage->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $ge_usage;
		$DeleteRows = TRUE;
		$sWrkFilter = $ge_usage->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in ge_usage class, ge_usageinfo.php

		$ge_usage->CurrentFilter = $sWrkFilter;
		$sSql = $ge_usage->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setMessage("No records found"); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs) $rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $ge_usage->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['date'];
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['uid'];
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['qid'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($ge_usage->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($ge_usage->CancelMessage <> "") {
				$this->setMessage($ge_usage->CancelMessage);
				$ge_usage->CancelMessage = "";
			} else {
				$this->setMessage("Delete cancelled");
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call recordset deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$ge_usage->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $ge_usage;

		// Call Recordset Selecting event
		$ge_usage->Recordset_Selecting($ge_usage->CurrentFilter);

		// Load list page SQL
		$sSql = $ge_usage->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$ge_usage->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ge_usage;
		$sFilter = $ge_usage->KeyFilter();

		// Call Row Selecting event
		$ge_usage->Row_Selecting($sFilter);

		// Load sql based on filter
		$ge_usage->CurrentFilter = $sFilter;
		$sSql = $ge_usage->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$ge_usage->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $ge_usage;
		$ge_usage->date->setDbValue($rs->fields('date'));
		$ge_usage->uid->setDbValue($rs->fields('uid'));
		$ge_usage->qid->setDbValue($rs->fields('qid'));
		$ge_usage->pid->setDbValue($rs->fields('pid'));
		$ge_usage->cpu->setDbValue($rs->fields('cpu'));
		$ge_usage->job->setDbValue($rs->fields('job'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $ge_usage;

		// Call Row_Rendering event
		$ge_usage->Row_Rendering();

		// Common render codes for all row types
		// date

		$ge_usage->date->CellCssStyle = "";
		$ge_usage->date->CellCssClass = "";

		// uid
		$ge_usage->uid->CellCssStyle = "";
		$ge_usage->uid->CellCssClass = "";

		// qid
		$ge_usage->qid->CellCssStyle = "";
		$ge_usage->qid->CellCssClass = "";

		// pid
		$ge_usage->pid->CellCssStyle = "";
		$ge_usage->pid->CellCssClass = "";

		// cpu
		$ge_usage->cpu->CellCssStyle = "";
		$ge_usage->cpu->CellCssClass = "";

		// job
		$ge_usage->job->CellCssStyle = "";
		$ge_usage->job->CellCssClass = "";
		if ($ge_usage->RowType == EW_ROWTYPE_VIEW) { // View row

			// date
			$ge_usage->date->ViewValue = $ge_usage->date->CurrentValue;
			$ge_usage->date->CssStyle = "";
			$ge_usage->date->CssClass = "";
			$ge_usage->date->ViewCustomAttributes = "";

			// uid
			$ge_usage->uid->ViewValue = $ge_usage->uid->CurrentValue;
			$ge_usage->uid->CssStyle = "";
			$ge_usage->uid->CssClass = "";
			$ge_usage->uid->ViewCustomAttributes = "";

			// qid
			$ge_usage->qid->ViewValue = $ge_usage->qid->CurrentValue;
			$ge_usage->qid->CssStyle = "";
			$ge_usage->qid->CssClass = "";
			$ge_usage->qid->ViewCustomAttributes = "";

			// pid
			$ge_usage->pid->ViewValue = $ge_usage->pid->CurrentValue;
			$ge_usage->pid->CssStyle = "";
			$ge_usage->pid->CssClass = "";
			$ge_usage->pid->ViewCustomAttributes = "";

			// cpu
			$ge_usage->cpu->ViewValue = $ge_usage->cpu->CurrentValue;
			$ge_usage->cpu->CssStyle = "";
			$ge_usage->cpu->CssClass = "";
			$ge_usage->cpu->ViewCustomAttributes = "";

			// job
			$ge_usage->job->ViewValue = $ge_usage->job->CurrentValue;
			$ge_usage->job->CssStyle = "";
			$ge_usage->job->CssClass = "";
			$ge_usage->job->ViewCustomAttributes = "";

			// date
			$ge_usage->date->HrefValue = "";

			// uid
			$ge_usage->uid->HrefValue = "";

			// qid
			$ge_usage->qid->HrefValue = "";

			// pid
			$ge_usage->pid->HrefValue = "";

			// cpu
			$ge_usage->cpu->HrefValue = "";

			// job
			$ge_usage->job->HrefValue = "";
		}

		// Call Row Rendered event
		$ge_usage->Row_Rendered();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}
}
?>
