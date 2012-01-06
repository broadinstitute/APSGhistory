<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "complete_fs_viewinfo.php" ?>
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
$complete_fs_view_search = new ccomplete_fs_view_search();
$Page =& $complete_fs_view_search;

// Page init processing
$complete_fs_view_search->Page_Init();

// Page main processing
$complete_fs_view_search->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var complete_fs_view_search = new ew_Page("complete_fs_view_search");

// page properties
complete_fs_view_search.PageID = "search"; // page ID
var EW_PAGE_ID = complete_fs_view_search.PageID; // for backward compatibility

// extend page with validate function for search
complete_fs_view_search.ValidateSearch = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	var infix = "";
	elm = fobj.elements["x" + infix + "_id"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Id");
	elm = fobj.elements["x" + infix + "_parent"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Parent");
	elm = fobj.elements["x" + infix + "_deprecated"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Deprecated");
	elm = fobj.elements["x" + infix + "_gid"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Gid");
	elm = fobj.elements["x" + infix + "_snapshot"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Snapshot");
	elm = fobj.elements["x" + infix + "_tapebackup"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Tapebackup");
	elm = fobj.elements["x" + infix + "_diskbackup"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Diskbackup");
	elm = fobj.elements["x" + infix + "_type"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Type");

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	for (var i=0;i<fobj.elements.length;i++) {
		var elem = fobj.elements[i];
		if (elem.name.substring(0,2) == "s_" || elem.name.substring(0,3) == "sv_")
			elem.value = "";
	}
	return true;
}

// extend page with Form_CustomValidate function
complete_fs_view_search.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
complete_fs_view_search.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
complete_fs_view_search.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Search View: Complete Fs View<br><br>
<a href="<?php echo $complete_fs_view->getReturnUrl() ?>">Back to List</a></span></p>
<?php $complete_fs_view_search->ShowMessage() ?>
<form name="fcomplete_fs_viewsearch" id="fcomplete_fs_viewsearch" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return complete_fs_view_search.ValidateSearch(this);">
<p>
<input type="hidden" name="t" id="t" value="complete_fs_view">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr<?php echo $complete_fs_view->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $complete_fs_view->id->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_id" id="z_id" value="="></span></td>
		<td<?php echo $complete_fs_view->id->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_id" id="x_id" size="30" value="<?php echo $complete_fs_view->id->EditValue ?>"<?php echo $complete_fs_view->id->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount</td>
		<td<?php echo $complete_fs_view->mount->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_mount" id="z_mount" value="LIKE"></span></td>
		<td<?php echo $complete_fs_view->mount->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_mount" id="x_mount" size="30" maxlength="100" value="<?php echo $complete_fs_view->mount->EditValue ?>"<?php echo $complete_fs_view->mount->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->path->RowAttributes ?>>
		<td class="ewTableHeader">Path</td>
		<td<?php echo $complete_fs_view->path->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_path" id="z_path" value="LIKE"></span></td>
		<td<?php echo $complete_fs_view->path->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_path" id="x_path" size="30" maxlength="100" value="<?php echo $complete_fs_view->path->EditValue ?>"<?php echo $complete_fs_view->path->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $complete_fs_view->parent->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_parent" id="z_parent" value="="></span></td>
		<td<?php echo $complete_fs_view->parent->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_parent" id="x_parent" size="30" value="<?php echo $complete_fs_view->parent->EditValue ?>"<?php echo $complete_fs_view->parent->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $complete_fs_view->deprecated->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_deprecated" id="z_deprecated" value="="></span></td>
		<td<?php echo $complete_fs_view->deprecated->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_deprecated" id="x_deprecated" size="30" value="<?php echo $complete_fs_view->deprecated->EditValue ?>"<?php echo $complete_fs_view->deprecated->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $complete_fs_view->gid->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_gid" id="z_gid" value="="></span></td>
		<td<?php echo $complete_fs_view->gid->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $complete_fs_view->gid->EditValue ?>"<?php echo $complete_fs_view->gid->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->group_name->RowAttributes ?>>
		<td class="ewTableHeader">Group Name</td>
		<td<?php echo $complete_fs_view->group_name->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_group_name" id="z_group_name" value="LIKE"></span></td>
		<td<?php echo $complete_fs_view->group_name->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_group_name" id="x_group_name" size="30" maxlength="100" value="<?php echo $complete_fs_view->group_name->EditValue ?>"<?php echo $complete_fs_view->group_name->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->snapshot->RowAttributes ?>>
		<td class="ewTableHeader">Snapshot</td>
		<td<?php echo $complete_fs_view->snapshot->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_snapshot" id="z_snapshot" value="="></span></td>
		<td<?php echo $complete_fs_view->snapshot->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_snapshot" id="x_snapshot" size="30" value="<?php echo $complete_fs_view->snapshot->EditValue ?>"<?php echo $complete_fs_view->snapshot->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->tapebackup->RowAttributes ?>>
		<td class="ewTableHeader">Tapebackup</td>
		<td<?php echo $complete_fs_view->tapebackup->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_tapebackup" id="z_tapebackup" value="="></span></td>
		<td<?php echo $complete_fs_view->tapebackup->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_tapebackup" id="x_tapebackup" size="30" value="<?php echo $complete_fs_view->tapebackup->EditValue ?>"<?php echo $complete_fs_view->tapebackup->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->diskbackup->RowAttributes ?>>
		<td class="ewTableHeader">Diskbackup</td>
		<td<?php echo $complete_fs_view->diskbackup->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_diskbackup" id="z_diskbackup" value="="></span></td>
		<td<?php echo $complete_fs_view->diskbackup->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_diskbackup" id="x_diskbackup" size="30" value="<?php echo $complete_fs_view->diskbackup->EditValue ?>"<?php echo $complete_fs_view->diskbackup->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->type->RowAttributes ?>>
		<td class="ewTableHeader">Type</td>
		<td<?php echo $complete_fs_view->type->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_type" id="z_type" value="="></span></td>
		<td<?php echo $complete_fs_view->type->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_type" id="x_type" size="30" value="<?php echo $complete_fs_view->type->EditValue ?>"<?php echo $complete_fs_view->type->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $complete_fs_view->server_type->RowAttributes ?>>
		<td class="ewTableHeader">Server Type</td>
		<td<?php echo $complete_fs_view->server_type->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_server_type" id="z_server_type" value="LIKE"></span></td>
		<td<?php echo $complete_fs_view->server_type->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_server_type" id="x_server_type" size="30" maxlength="45" value="<?php echo $complete_fs_view->server_type->EditValue ?>"<?php echo $complete_fs_view->server_type->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="  Search  ">
<input type="button" name="Reset" id="Reset" value="   Reset   " onclick="ew_ClearForm(this.form);">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$complete_fs_view_search->Page_Terminate();
?>
<?php

//
// Page Class
//
class ccomplete_fs_view_search {

	// Page ID
	var $PageID = 'search';

	// Table Name
	var $TableName = 'complete_fs_view';

	// Page Object Name
	var $PageObjName = 'complete_fs_view_search';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $complete_fs_view;
		if ($complete_fs_view->UseTokenInUrl) $PageUrl .= "t=" . $complete_fs_view->TableVar . "&"; // add page token
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
		global $objForm, $complete_fs_view;
		if ($complete_fs_view->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($complete_fs_view->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($complete_fs_view->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccomplete_fs_view_search() {
		global $conn;

		// Initialize table object
		$GLOBALS["complete_fs_view"] = new ccomplete_fs_view();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'complete_fs_view', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $complete_fs_view;

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

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $complete_fs_view;
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$complete_fs_view->CurrentAction = $objForm->GetValue("a_search");
			switch ($complete_fs_view->CurrentAction) {
				case "S": // Get Search Criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $complete_fs_view->UrlParm($sSrchStr);
						$this->Page_Terminate("complete_fs_viewlist.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$complete_fs_view->RowType = EW_ROWTYPE_SEARCH;
		$this->RenderRow();
	}

// Build advanced search
function BuildAdvancedSearch() {
	global $complete_fs_view;
	$sSrchUrl = "";
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->id); // id
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->mount); // mount
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->path); // path
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->parent); // parent
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->deprecated); // deprecated
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->gid); // gid
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->group_name); // group_name
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->snapshot); // snapshot
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->tapebackup); // tapebackup
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->diskbackup); // diskbackup
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->type); // type
	$this->BuildSearchUrl($sSrchUrl, $complete_fs_view->server_type); // server_type
	return $sSrchUrl;
}

// Function to build search URL
function BuildSearchUrl(&$Url, &$Fld) {
	global $objForm;
	$sWrk = "";
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = $objForm->GetValue("x_$FldParm");
	$FldOpr = $objForm->GetValue("z_$FldParm");
	$FldCond = $objForm->GetValue("v_$FldParm");
	$FldVal2 = $objForm->GetValue("y_$FldParm");
	$FldOpr2 = $objForm->GetValue("w_$FldParm");
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$FldOpr = strtoupper(trim($FldOpr));
	if ($FldOpr == "BETWEEN") {
		$IsValidValue = ($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType == EW_DATATYPE_NUMBER && is_numeric($FldVal) && is_numeric($FldVal2));
		if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
			$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
				"&y_" . $FldParm . "=" . urlencode($FldVal2) .
				"&z_" . $FldParm . "=" . urlencode($FldOpr);
		}
	} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL") {
		$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
			"&z_" . $FldParm . "=" . urlencode($FldOpr);
	} else {
		$IsValidValue = ($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType = EW_DATATYPE_NUMBER && is_numeric($FldVal));
		if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $Fld->FldDataType)) {

			//$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
				"&z_" . $FldParm . "=" . urlencode($FldOpr);
		}
		$IsValidValue = ($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType = EW_DATATYPE_NUMBER && is_numeric($FldVal2));
		if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $Fld->FldDataType)) {

			//$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
			$sWrk .= "&y_" . $FldParm . "=" . urlencode($FldVal2) .
				"&w_" . $FldParm . "=" . urlencode($FldOpr2);
		}
	}
	if ($sWrk <> "") {
		if ($Url <> "") $Url .= "&";
		$Url .= $sWrk;
	}
}

	// Convert search value for date
	function ConvertSearchValue(&$Fld, $FldVal) {
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_DATE && $FldVal <> "")
			$Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		return $Value;
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm, $complete_fs_view;

		// Load search values
		// id

		$complete_fs_view->id->AdvancedSearch->SearchValue = $objForm->GetValue("x_id");
		$complete_fs_view->id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_id");

		// mount
		$complete_fs_view->mount->AdvancedSearch->SearchValue = $objForm->GetValue("x_mount");
		$complete_fs_view->mount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_mount");

		// path
		$complete_fs_view->path->AdvancedSearch->SearchValue = $objForm->GetValue("x_path");
		$complete_fs_view->path->AdvancedSearch->SearchOperator = $objForm->GetValue("z_path");

		// parent
		$complete_fs_view->parent->AdvancedSearch->SearchValue = $objForm->GetValue("x_parent");
		$complete_fs_view->parent->AdvancedSearch->SearchOperator = $objForm->GetValue("z_parent");

		// deprecated
		$complete_fs_view->deprecated->AdvancedSearch->SearchValue = $objForm->GetValue("x_deprecated");
		$complete_fs_view->deprecated->AdvancedSearch->SearchOperator = $objForm->GetValue("z_deprecated");

		// gid
		$complete_fs_view->gid->AdvancedSearch->SearchValue = $objForm->GetValue("x_gid");
		$complete_fs_view->gid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_gid");

		// group_name
		$complete_fs_view->group_name->AdvancedSearch->SearchValue = $objForm->GetValue("x_group_name");
		$complete_fs_view->group_name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_group_name");

		// snapshot
		$complete_fs_view->snapshot->AdvancedSearch->SearchValue = $objForm->GetValue("x_snapshot");
		$complete_fs_view->snapshot->AdvancedSearch->SearchOperator = $objForm->GetValue("z_snapshot");

		// tapebackup
		$complete_fs_view->tapebackup->AdvancedSearch->SearchValue = $objForm->GetValue("x_tapebackup");
		$complete_fs_view->tapebackup->AdvancedSearch->SearchOperator = $objForm->GetValue("z_tapebackup");

		// diskbackup
		$complete_fs_view->diskbackup->AdvancedSearch->SearchValue = $objForm->GetValue("x_diskbackup");
		$complete_fs_view->diskbackup->AdvancedSearch->SearchOperator = $objForm->GetValue("z_diskbackup");

		// type
		$complete_fs_view->type->AdvancedSearch->SearchValue = $objForm->GetValue("x_type");
		$complete_fs_view->type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_type");

		// server_type
		$complete_fs_view->server_type->AdvancedSearch->SearchValue = $objForm->GetValue("x_server_type");
		$complete_fs_view->server_type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_server_type");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $complete_fs_view;

		// Call Row_Rendering event
		$complete_fs_view->Row_Rendering();

		// Common render codes for all row types
		// id

		$complete_fs_view->id->CellCssStyle = "";
		$complete_fs_view->id->CellCssClass = "";

		// mount
		$complete_fs_view->mount->CellCssStyle = "";
		$complete_fs_view->mount->CellCssClass = "";

		// path
		$complete_fs_view->path->CellCssStyle = "";
		$complete_fs_view->path->CellCssClass = "";

		// parent
		$complete_fs_view->parent->CellCssStyle = "";
		$complete_fs_view->parent->CellCssClass = "";

		// deprecated
		$complete_fs_view->deprecated->CellCssStyle = "";
		$complete_fs_view->deprecated->CellCssClass = "";

		// gid
		$complete_fs_view->gid->CellCssStyle = "";
		$complete_fs_view->gid->CellCssClass = "";

		// group_name
		$complete_fs_view->group_name->CellCssStyle = "";
		$complete_fs_view->group_name->CellCssClass = "";

		// snapshot
		$complete_fs_view->snapshot->CellCssStyle = "";
		$complete_fs_view->snapshot->CellCssClass = "";

		// tapebackup
		$complete_fs_view->tapebackup->CellCssStyle = "";
		$complete_fs_view->tapebackup->CellCssClass = "";

		// diskbackup
		$complete_fs_view->diskbackup->CellCssStyle = "";
		$complete_fs_view->diskbackup->CellCssClass = "";

		// type
		$complete_fs_view->type->CellCssStyle = "";
		$complete_fs_view->type->CellCssClass = "";

		// server_type
		$complete_fs_view->server_type->CellCssStyle = "";
		$complete_fs_view->server_type->CellCssClass = "";
		if ($complete_fs_view->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$complete_fs_view->id->ViewValue = $complete_fs_view->id->CurrentValue;
			$complete_fs_view->id->CssStyle = "";
			$complete_fs_view->id->CssClass = "";
			$complete_fs_view->id->ViewCustomAttributes = "";

			// mount
			$complete_fs_view->mount->ViewValue = $complete_fs_view->mount->CurrentValue;
			$complete_fs_view->mount->CssStyle = "";
			$complete_fs_view->mount->CssClass = "";
			$complete_fs_view->mount->ViewCustomAttributes = "";

			// path
			$complete_fs_view->path->ViewValue = $complete_fs_view->path->CurrentValue;
			$complete_fs_view->path->CssStyle = "";
			$complete_fs_view->path->CssClass = "";
			$complete_fs_view->path->ViewCustomAttributes = "";

			// parent
			$complete_fs_view->parent->ViewValue = $complete_fs_view->parent->CurrentValue;
			$complete_fs_view->parent->CssStyle = "";
			$complete_fs_view->parent->CssClass = "";
			$complete_fs_view->parent->ViewCustomAttributes = "";

			// deprecated
			$complete_fs_view->deprecated->ViewValue = $complete_fs_view->deprecated->CurrentValue;
			$complete_fs_view->deprecated->CssStyle = "";
			$complete_fs_view->deprecated->CssClass = "";
			$complete_fs_view->deprecated->ViewCustomAttributes = "";

			// gid
			$complete_fs_view->gid->ViewValue = $complete_fs_view->gid->CurrentValue;
			$complete_fs_view->gid->CssStyle = "";
			$complete_fs_view->gid->CssClass = "";
			$complete_fs_view->gid->ViewCustomAttributes = "";

			// group_name
			$complete_fs_view->group_name->ViewValue = $complete_fs_view->group_name->CurrentValue;
			$complete_fs_view->group_name->CssStyle = "";
			$complete_fs_view->group_name->CssClass = "";
			$complete_fs_view->group_name->ViewCustomAttributes = "";

			// snapshot
			$complete_fs_view->snapshot->ViewValue = $complete_fs_view->snapshot->CurrentValue;
			$complete_fs_view->snapshot->CssStyle = "";
			$complete_fs_view->snapshot->CssClass = "";
			$complete_fs_view->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$complete_fs_view->tapebackup->ViewValue = $complete_fs_view->tapebackup->CurrentValue;
			$complete_fs_view->tapebackup->CssStyle = "";
			$complete_fs_view->tapebackup->CssClass = "";
			$complete_fs_view->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$complete_fs_view->diskbackup->ViewValue = $complete_fs_view->diskbackup->CurrentValue;
			$complete_fs_view->diskbackup->CssStyle = "";
			$complete_fs_view->diskbackup->CssClass = "";
			$complete_fs_view->diskbackup->ViewCustomAttributes = "";

			// type
			$complete_fs_view->type->ViewValue = $complete_fs_view->type->CurrentValue;
			$complete_fs_view->type->CssStyle = "";
			$complete_fs_view->type->CssClass = "";
			$complete_fs_view->type->ViewCustomAttributes = "";

			// server_type
			$complete_fs_view->server_type->ViewValue = $complete_fs_view->server_type->CurrentValue;
			$complete_fs_view->server_type->CssStyle = "";
			$complete_fs_view->server_type->CssClass = "";
			$complete_fs_view->server_type->ViewCustomAttributes = "";

			// id
			$complete_fs_view->id->HrefValue = "";

			// mount
			$complete_fs_view->mount->HrefValue = "";

			// path
			$complete_fs_view->path->HrefValue = "";

			// parent
			$complete_fs_view->parent->HrefValue = "";

			// deprecated
			$complete_fs_view->deprecated->HrefValue = "";

			// gid
			$complete_fs_view->gid->HrefValue = "";

			// group_name
			$complete_fs_view->group_name->HrefValue = "";

			// snapshot
			$complete_fs_view->snapshot->HrefValue = "";

			// tapebackup
			$complete_fs_view->tapebackup->HrefValue = "";

			// diskbackup
			$complete_fs_view->diskbackup->HrefValue = "";

			// type
			$complete_fs_view->type->HrefValue = "";

			// server_type
			$complete_fs_view->server_type->HrefValue = "";
		} elseif ($complete_fs_view->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$complete_fs_view->id->EditCustomAttributes = "";
			$complete_fs_view->id->EditValue = ew_HtmlEncode($complete_fs_view->id->AdvancedSearch->SearchValue);

			// mount
			$complete_fs_view->mount->EditCustomAttributes = "";
			$complete_fs_view->mount->EditValue = ew_HtmlEncode($complete_fs_view->mount->AdvancedSearch->SearchValue);

			// path
			$complete_fs_view->path->EditCustomAttributes = "";
			$complete_fs_view->path->EditValue = ew_HtmlEncode($complete_fs_view->path->AdvancedSearch->SearchValue);

			// parent
			$complete_fs_view->parent->EditCustomAttributes = "";
			$complete_fs_view->parent->EditValue = ew_HtmlEncode($complete_fs_view->parent->AdvancedSearch->SearchValue);

			// deprecated
			$complete_fs_view->deprecated->EditCustomAttributes = "";
			$complete_fs_view->deprecated->EditValue = ew_HtmlEncode($complete_fs_view->deprecated->AdvancedSearch->SearchValue);

			// gid
			$complete_fs_view->gid->EditCustomAttributes = "";
			$complete_fs_view->gid->EditValue = ew_HtmlEncode($complete_fs_view->gid->AdvancedSearch->SearchValue);

			// group_name
			$complete_fs_view->group_name->EditCustomAttributes = "";
			$complete_fs_view->group_name->EditValue = ew_HtmlEncode($complete_fs_view->group_name->AdvancedSearch->SearchValue);

			// snapshot
			$complete_fs_view->snapshot->EditCustomAttributes = "";
			$complete_fs_view->snapshot->EditValue = ew_HtmlEncode($complete_fs_view->snapshot->AdvancedSearch->SearchValue);

			// tapebackup
			$complete_fs_view->tapebackup->EditCustomAttributes = "";
			$complete_fs_view->tapebackup->EditValue = ew_HtmlEncode($complete_fs_view->tapebackup->AdvancedSearch->SearchValue);

			// diskbackup
			$complete_fs_view->diskbackup->EditCustomAttributes = "";
			$complete_fs_view->diskbackup->EditValue = ew_HtmlEncode($complete_fs_view->diskbackup->AdvancedSearch->SearchValue);

			// type
			$complete_fs_view->type->EditCustomAttributes = "";
			$complete_fs_view->type->EditValue = ew_HtmlEncode($complete_fs_view->type->AdvancedSearch->SearchValue);

			// server_type
			$complete_fs_view->server_type->EditCustomAttributes = "";
			$complete_fs_view->server_type->EditValue = ew_HtmlEncode($complete_fs_view->server_type->AdvancedSearch->SearchValue);
		}

		// Call Row Rendered event
		$complete_fs_view->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $complete_fs_view;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($complete_fs_view->id->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Id";
		}
		if (!ew_CheckInteger($complete_fs_view->parent->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Parent";
		}
		if (!ew_CheckInteger($complete_fs_view->deprecated->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Deprecated";
		}
		if (!ew_CheckInteger($complete_fs_view->gid->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Gid";
		}
		if (!ew_CheckInteger($complete_fs_view->snapshot->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Snapshot";
		}
		if (!ew_CheckInteger($complete_fs_view->tapebackup->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Tapebackup";
		}
		if (!ew_CheckInteger($complete_fs_view->diskbackup->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Diskbackup";
		}
		if (!ew_CheckInteger($complete_fs_view->type->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Type";
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= $sFormCustomError;
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		global $complete_fs_view;
		$complete_fs_view->id->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_id");
		$complete_fs_view->mount->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_mount");
		$complete_fs_view->path->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_path");
		$complete_fs_view->parent->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_parent");
		$complete_fs_view->deprecated->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_deprecated");
		$complete_fs_view->gid->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_gid");
		$complete_fs_view->group_name->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_group_name");
		$complete_fs_view->snapshot->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_snapshot");
		$complete_fs_view->tapebackup->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_tapebackup");
		$complete_fs_view->diskbackup->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_diskbackup");
		$complete_fs_view->type->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_type");
		$complete_fs_view->server_type->AdvancedSearch->SearchValue = $complete_fs_view->getAdvancedSearch("x_server_type");
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
