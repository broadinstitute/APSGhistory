<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "ge_queuesinfo.php" ?>
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
$ge_queues_delete = new cge_queues_delete();
$Page =& $ge_queues_delete;

// Page init processing
$ge_queues_delete->Page_Init();

// Page main processing
$ge_queues_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var ge_queues_delete = new ew_Page("ge_queues_delete");

// page properties
ge_queues_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = ge_queues_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ge_queues_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
ge_queues_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ge_queues_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $ge_queues_delete->LoadRecordset();
$ge_queues_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($ge_queues_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$ge_queues_delete->Page_Terminate("ge_queueslist.php"); // Return to list
}
?>
<p><span class="phpmaker">Delete From TABLE: Ge Queues<br><br>
<a href="<?php echo $ge_queues->getReturnUrl() ?>">Go Back</a></span></p>
<?php $ge_queues_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="ge_queues">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ge_queues_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $ge_queues->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Id</td>
		<td valign="top">Name</td>
		<td valign="top">Gid</td>
	</tr>
	</thead>
	<tbody>
<?php
$ge_queues_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$ge_queues_delete->lRecCnt++;

	// Set row properties
	$ge_queues->CssClass = "";
	$ge_queues->CssStyle = "";
	$ge_queues->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ge_queues_delete->LoadRowValues($rs);

	// Render row
	$ge_queues_delete->RenderRow();
?>
	<tr<?php echo $ge_queues->RowAttributes() ?>>
		<td<?php echo $ge_queues->id->CellAttributes() ?>>
<div<?php echo $ge_queues->id->ViewAttributes() ?>><?php echo $ge_queues->id->ListViewValue() ?></div></td>
		<td<?php echo $ge_queues->name->CellAttributes() ?>>
<div<?php echo $ge_queues->name->ViewAttributes() ?>><?php echo $ge_queues->name->ListViewValue() ?></div></td>
		<td<?php echo $ge_queues->gid->CellAttributes() ?>>
<div<?php echo $ge_queues->gid->ViewAttributes() ?>><?php echo $ge_queues->gid->ListViewValue() ?></div></td>
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
$ge_queues_delete->Page_Terminate();
?>
<?php

//
// Page Class
//
class cge_queues_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'ge_queues';

	// Page Object Name
	var $PageObjName = 'ge_queues_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ge_queues;
		if ($ge_queues->UseTokenInUrl) $PageUrl .= "t=" . $ge_queues->TableVar . "&"; // add page token
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
		global $objForm, $ge_queues;
		if ($ge_queues->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($ge_queues->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ge_queues->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cge_queues_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["ge_queues"] = new cge_queues();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ge_queues', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ge_queues;
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
		global $ge_queues;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id"] <> "") {
			$ge_queues->id->setQueryStringValue($_GET["id"]);
			if (!is_numeric($ge_queues->id->QueryStringValue))
				$this->Page_Terminate("ge_queueslist.php"); // Prevent SQL injection, exit
			$sKey .= $ge_queues->id->QueryStringValue;
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
			$this->Page_Terminate("ge_queueslist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("ge_queueslist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in ge_queues class, ge_queuesinfo.php

		$ge_queues->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$ge_queues->CurrentAction = $_POST["a_delete"];
		} else {
			$ge_queues->CurrentAction = "I"; // Display record
		}
		switch ($ge_queues->CurrentAction) {
			case "D": // Delete
				$ge_queues->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Delete succeeded"); // Set up success message
					$this->Page_Terminate($ge_queues->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $ge_queues;
		$DeleteRows = TRUE;
		$sWrkFilter = $ge_queues->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in ge_queues class, ge_queuesinfo.php

		$ge_queues->CurrentFilter = $sWrkFilter;
		$sSql = $ge_queues->SQL();
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
				$DeleteRows = $ge_queues->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($ge_queues->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($ge_queues->CancelMessage <> "") {
				$this->setMessage($ge_queues->CancelMessage);
				$ge_queues->CancelMessage = "";
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
				$ge_queues->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $ge_queues;

		// Call Recordset Selecting event
		$ge_queues->Recordset_Selecting($ge_queues->CurrentFilter);

		// Load list page SQL
		$sSql = $ge_queues->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$ge_queues->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ge_queues;
		$sFilter = $ge_queues->KeyFilter();

		// Call Row Selecting event
		$ge_queues->Row_Selecting($sFilter);

		// Load sql based on filter
		$ge_queues->CurrentFilter = $sFilter;
		$sSql = $ge_queues->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$ge_queues->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $ge_queues;
		$ge_queues->id->setDbValue($rs->fields('id'));
		$ge_queues->name->setDbValue($rs->fields('name'));
		$ge_queues->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $ge_queues;

		// Call Row_Rendering event
		$ge_queues->Row_Rendering();

		// Common render codes for all row types
		// id

		$ge_queues->id->CellCssStyle = "";
		$ge_queues->id->CellCssClass = "";

		// name
		$ge_queues->name->CellCssStyle = "";
		$ge_queues->name->CellCssClass = "";

		// gid
		$ge_queues->gid->CellCssStyle = "";
		$ge_queues->gid->CellCssClass = "";
		if ($ge_queues->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$ge_queues->id->ViewValue = $ge_queues->id->CurrentValue;
			$ge_queues->id->CssStyle = "";
			$ge_queues->id->CssClass = "";
			$ge_queues->id->ViewCustomAttributes = "";

			// name
			$ge_queues->name->ViewValue = $ge_queues->name->CurrentValue;
			$ge_queues->name->CssStyle = "";
			$ge_queues->name->CssClass = "";
			$ge_queues->name->ViewCustomAttributes = "";

			// gid
			$ge_queues->gid->ViewValue = $ge_queues->gid->CurrentValue;
			$ge_queues->gid->CssStyle = "";
			$ge_queues->gid->CssClass = "";
			$ge_queues->gid->ViewCustomAttributes = "";

			// id
			$ge_queues->id->HrefValue = "";

			// name
			$ge_queues->name->HrefValue = "";

			// gid
			$ge_queues->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$ge_queues->Row_Rendered();
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
