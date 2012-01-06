<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "dbserversinfo.php" ?>
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
$dbservers_delete = new cdbservers_delete();
$Page =& $dbservers_delete;

// Page init processing
$dbservers_delete->Page_Init();

// Page main processing
$dbservers_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var dbservers_delete = new ew_Page("dbservers_delete");

// page properties
dbservers_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = dbservers_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
dbservers_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
dbservers_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
dbservers_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $dbservers_delete->LoadRecordset();
$dbservers_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($dbservers_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$dbservers_delete->Page_Terminate("dbserverslist.php"); // Return to list
}
?>
<p><span class="phpmaker">Delete From TABLE: Dbservers<br><br>
<a href="<?php echo $dbservers->getReturnUrl() ?>">Go Back</a></span></p>
<?php $dbservers_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="dbservers">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($dbservers_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $dbservers->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Id</td>
		<td valign="top">Name</td>
		<td valign="top">Gid</td>
	</tr>
	</thead>
	<tbody>
<?php
$dbservers_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$dbservers_delete->lRecCnt++;

	// Set row properties
	$dbservers->CssClass = "";
	$dbservers->CssStyle = "";
	$dbservers->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$dbservers_delete->LoadRowValues($rs);

	// Render row
	$dbservers_delete->RenderRow();
?>
	<tr<?php echo $dbservers->RowAttributes() ?>>
		<td<?php echo $dbservers->id->CellAttributes() ?>>
<div<?php echo $dbservers->id->ViewAttributes() ?>><?php echo $dbservers->id->ListViewValue() ?></div></td>
		<td<?php echo $dbservers->name->CellAttributes() ?>>
<div<?php echo $dbservers->name->ViewAttributes() ?>><?php echo $dbservers->name->ListViewValue() ?></div></td>
		<td<?php echo $dbservers->gid->CellAttributes() ?>>
<div<?php echo $dbservers->gid->ViewAttributes() ?>><?php echo $dbservers->gid->ListViewValue() ?></div></td>
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
$dbservers_delete->Page_Terminate();
?>
<?php

//
// Page Class
//
class cdbservers_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'dbservers';

	// Page Object Name
	var $PageObjName = 'dbservers_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $dbservers;
		if ($dbservers->UseTokenInUrl) $PageUrl .= "t=" . $dbservers->TableVar . "&"; // add page token
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
		global $objForm, $dbservers;
		if ($dbservers->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($dbservers->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($dbservers->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdbservers_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["dbservers"] = new cdbservers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dbservers', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $dbservers;
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
		global $dbservers;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id"] <> "") {
			$dbservers->id->setQueryStringValue($_GET["id"]);
			if (!is_numeric($dbservers->id->QueryStringValue))
				$this->Page_Terminate("dbserverslist.php"); // Prevent SQL injection, exit
			$sKey .= $dbservers->id->QueryStringValue;
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
			$this->Page_Terminate("dbserverslist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("dbserverslist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in dbservers class, dbserversinfo.php

		$dbservers->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$dbservers->CurrentAction = $_POST["a_delete"];
		} else {
			$dbservers->CurrentAction = "I"; // Display record
		}
		switch ($dbservers->CurrentAction) {
			case "D": // Delete
				$dbservers->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Delete succeeded"); // Set up success message
					$this->Page_Terminate($dbservers->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $dbservers;
		$DeleteRows = TRUE;
		$sWrkFilter = $dbservers->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in dbservers class, dbserversinfo.php

		$dbservers->CurrentFilter = $sWrkFilter;
		$sSql = $dbservers->SQL();
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
				$DeleteRows = $dbservers->Row_Deleting($row);
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
				$DeleteRows = $conn->Execute($dbservers->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($dbservers->CancelMessage <> "") {
				$this->setMessage($dbservers->CancelMessage);
				$dbservers->CancelMessage = "";
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
				$dbservers->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $dbservers;

		// Call Recordset Selecting event
		$dbservers->Recordset_Selecting($dbservers->CurrentFilter);

		// Load list page SQL
		$sSql = $dbservers->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$dbservers->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $dbservers;
		$sFilter = $dbservers->KeyFilter();

		// Call Row Selecting event
		$dbservers->Row_Selecting($sFilter);

		// Load sql based on filter
		$dbservers->CurrentFilter = $sFilter;
		$sSql = $dbservers->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$dbservers->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $dbservers;
		$dbservers->id->setDbValue($rs->fields('id'));
		$dbservers->name->setDbValue($rs->fields('name'));
		$dbservers->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $dbservers;

		// Call Row_Rendering event
		$dbservers->Row_Rendering();

		// Common render codes for all row types
		// id

		$dbservers->id->CellCssStyle = "";
		$dbservers->id->CellCssClass = "";

		// name
		$dbservers->name->CellCssStyle = "";
		$dbservers->name->CellCssClass = "";

		// gid
		$dbservers->gid->CellCssStyle = "";
		$dbservers->gid->CellCssClass = "";
		if ($dbservers->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$dbservers->id->ViewValue = $dbservers->id->CurrentValue;
			$dbservers->id->CssStyle = "";
			$dbservers->id->CssClass = "";
			$dbservers->id->ViewCustomAttributes = "";

			// name
			$dbservers->name->ViewValue = $dbservers->name->CurrentValue;
			$dbservers->name->CssStyle = "";
			$dbservers->name->CssClass = "";
			$dbservers->name->ViewCustomAttributes = "";

			// gid
			$dbservers->gid->ViewValue = $dbservers->gid->CurrentValue;
			$dbservers->gid->CssStyle = "";
			$dbservers->gid->CssClass = "";
			$dbservers->gid->ViewCustomAttributes = "";

			// id
			$dbservers->id->HrefValue = "";

			// name
			$dbservers->name->HrefValue = "";

			// gid
			$dbservers->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$dbservers->Row_Rendered();
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
