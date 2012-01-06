<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "lsf_projectsinfo.php" ?>
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
$lsf_projects_delete = new clsf_projects_delete();
$Page =& $lsf_projects_delete;

// Page init processing
$lsf_projects_delete->Page_Init();

// Page main processing
$lsf_projects_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var lsf_projects_delete = new ew_Page("lsf_projects_delete");

// page properties
lsf_projects_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = lsf_projects_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lsf_projects_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lsf_projects_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lsf_projects_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $lsf_projects_delete->LoadRecordset();
$lsf_projects_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($lsf_projects_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$lsf_projects_delete->Page_Terminate("lsf_projectslist.php"); // Return to list
}
?>
<p><span class="phpmaker">Delete From TABLE: Lsf Projects<br><br>
<a href="<?php echo $lsf_projects->getReturnUrl() ?>">Go Back</a></span></p>
<?php $lsf_projects_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="lsf_projects">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($lsf_projects_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $lsf_projects->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Id</td>
		<td valign="top">Name</td>
		<td valign="top">Gid</td>
	</tr>
	</thead>
	<tbody>
<?php
$lsf_projects_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$lsf_projects_delete->lRecCnt++;

	// Set row properties
	$lsf_projects->CssClass = "";
	$lsf_projects->CssStyle = "";
	$lsf_projects->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$lsf_projects_delete->LoadRowValues($rs);

	// Render row
	$lsf_projects_delete->RenderRow();
?>
	<tr<?php echo $lsf_projects->RowAttributes() ?>>
		<td<?php echo $lsf_projects->id->CellAttributes() ?>>
<div<?php echo $lsf_projects->id->ViewAttributes() ?>><?php echo $lsf_projects->id->ListViewValue() ?></div></td>
		<td<?php echo $lsf_projects->name->CellAttributes() ?>>
<div<?php echo $lsf_projects->name->ViewAttributes() ?>><?php echo $lsf_projects->name->ListViewValue() ?></div></td>
		<td<?php echo $lsf_projects->gid->CellAttributes() ?>>
<div<?php echo $lsf_projects->gid->ViewAttributes() ?>><?php echo $lsf_projects->gid->ListViewValue() ?></div></td>
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
$lsf_projects_delete->Page_Terminate();
?>
<?php

//
// Page Class
//
class clsf_projects_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'lsf_projects';

	// Page Object Name
	var $PageObjName = 'lsf_projects_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lsf_projects;
		if ($lsf_projects->UseTokenInUrl) $PageUrl .= "t=" . $lsf_projects->TableVar . "&"; // add page token
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
		global $objForm, $lsf_projects;
		if ($lsf_projects->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($lsf_projects->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lsf_projects->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function clsf_projects_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["lsf_projects"] = new clsf_projects();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lsf_projects', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $lsf_projects;
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
		global $lsf_projects;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id"] <> "") {
			$lsf_projects->id->setQueryStringValue($_GET["id"]);
			if (!is_numeric($lsf_projects->id->QueryStringValue))
				$this->Page_Terminate("lsf_projectslist.php"); // Prevent SQL injection, exit
			$sKey .= $lsf_projects->id->QueryStringValue;
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
			$this->Page_Terminate("lsf_projectslist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("lsf_projectslist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in lsf_projects class, lsf_projectsinfo.php

		$lsf_projects->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$lsf_projects->CurrentAction = $_POST["a_delete"];
		} else {
			$lsf_projects->CurrentAction = "I"; // Display record
		}
		switch ($lsf_projects->CurrentAction) {
			case "D": // Delete
				$lsf_projects->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Delete succeeded"); // Set up success message
					$this->Page_Terminate($lsf_projects->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $lsf_projects;
		$DeleteRows = TRUE;
		$sWrkFilter = $lsf_projects->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in lsf_projects class, lsf_projectsinfo.php

		$lsf_projects->CurrentFilter = $sWrkFilter;
		$sSql = $lsf_projects->SQL();
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
				$DeleteRows = $lsf_projects->Row_Deleting($row);
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
				$DeleteRows = $conn->Execute($lsf_projects->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($lsf_projects->CancelMessage <> "") {
				$this->setMessage($lsf_projects->CancelMessage);
				$lsf_projects->CancelMessage = "";
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
				$lsf_projects->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $lsf_projects;

		// Call Recordset Selecting event
		$lsf_projects->Recordset_Selecting($lsf_projects->CurrentFilter);

		// Load list page SQL
		$sSql = $lsf_projects->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$lsf_projects->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lsf_projects;
		$sFilter = $lsf_projects->KeyFilter();

		// Call Row Selecting event
		$lsf_projects->Row_Selecting($sFilter);

		// Load sql based on filter
		$lsf_projects->CurrentFilter = $sFilter;
		$sSql = $lsf_projects->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$lsf_projects->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $lsf_projects;
		$lsf_projects->id->setDbValue($rs->fields('id'));
		$lsf_projects->name->setDbValue($rs->fields('name'));
		$lsf_projects->gid->setDbValue($rs->fields('gid'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $lsf_projects;

		// Call Row_Rendering event
		$lsf_projects->Row_Rendering();

		// Common render codes for all row types
		// id

		$lsf_projects->id->CellCssStyle = "";
		$lsf_projects->id->CellCssClass = "";

		// name
		$lsf_projects->name->CellCssStyle = "";
		$lsf_projects->name->CellCssClass = "";

		// gid
		$lsf_projects->gid->CellCssStyle = "";
		$lsf_projects->gid->CellCssClass = "";
		if ($lsf_projects->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$lsf_projects->id->ViewValue = $lsf_projects->id->CurrentValue;
			$lsf_projects->id->CssStyle = "";
			$lsf_projects->id->CssClass = "";
			$lsf_projects->id->ViewCustomAttributes = "";

			// name
			$lsf_projects->name->ViewValue = $lsf_projects->name->CurrentValue;
			$lsf_projects->name->CssStyle = "";
			$lsf_projects->name->CssClass = "";
			$lsf_projects->name->ViewCustomAttributes = "";

			// gid
			$lsf_projects->gid->ViewValue = $lsf_projects->gid->CurrentValue;
			$lsf_projects->gid->CssStyle = "";
			$lsf_projects->gid->CssClass = "";
			$lsf_projects->gid->ViewCustomAttributes = "";

			// id
			$lsf_projects->id->HrefValue = "";

			// name
			$lsf_projects->name->HrefValue = "";

			// gid
			$lsf_projects->gid->HrefValue = "";
		}

		// Call Row Rendered event
		$lsf_projects->Row_Rendered();
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
