<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "CustomView1info.php" ?>
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
$CustomView1_search = new cCustomView1_search();
$Page =& $CustomView1_search;

// Page init processing
$CustomView1_search->Page_Init();

// Page main processing
$CustomView1_search->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var CustomView1_search = new ew_Page("CustomView1_search");

// page properties
CustomView1_search.PageID = "search"; // page ID
var EW_PAGE_ID = CustomView1_search.PageID; // for backward compatibility

// extend page with validate function for search
CustomView1_search.ValidateSearch = function(fobj) {
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
CustomView1_search.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
CustomView1_search.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
CustomView1_search.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Search CUSTOM VIEW: Custom View 1<br><br>
<a href="<?php echo $CustomView1->getReturnUrl() ?>">Back to List</a></span></p>
<?php $CustomView1_search->ShowMessage() ?>
<form name="fCustomView1search" id="fCustomView1search" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return CustomView1_search.ValidateSearch(this);">
<p>
<input type="hidden" name="t" id="t" value="CustomView1">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr<?php echo $CustomView1->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $CustomView1->id->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_id" id="z_id" value="="></span></td>
		<td<?php echo $CustomView1->id->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_id" id="x_id" value="<?php echo $CustomView1->id->EditValue ?>"<?php echo $CustomView1->id->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount</td>
		<td<?php echo $CustomView1->mount->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_mount" id="z_mount" value="LIKE"></span></td>
		<td<?php echo $CustomView1->mount->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_mount" id="x_mount" size="30" maxlength="100" value="<?php echo $CustomView1->mount->EditValue ?>"<?php echo $CustomView1->mount->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->path->RowAttributes ?>>
		<td class="ewTableHeader">Path</td>
		<td<?php echo $CustomView1->path->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_path" id="z_path" value="LIKE"></span></td>
		<td<?php echo $CustomView1->path->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_path" id="x_path" size="30" maxlength="100" value="<?php echo $CustomView1->path->EditValue ?>"<?php echo $CustomView1->path->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $CustomView1->parent->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_parent" id="z_parent" value="="></span></td>
		<td<?php echo $CustomView1->parent->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_parent" id="x_parent" size="30" value="<?php echo $CustomView1->parent->EditValue ?>"<?php echo $CustomView1->parent->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $CustomView1->deprecated->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_deprecated" id="z_deprecated" value="="></span></td>
		<td<?php echo $CustomView1->deprecated->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_deprecated" id="x_deprecated" size="30" value="<?php echo $CustomView1->deprecated->EditValue ?>"<?php echo $CustomView1->deprecated->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $CustomView1->gid->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_gid" id="z_gid" value="="></span></td>
		<td<?php echo $CustomView1->gid->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $CustomView1->gid->EditValue ?>"<?php echo $CustomView1->gid->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->snapshot->RowAttributes ?>>
		<td class="ewTableHeader">Snapshot</td>
		<td<?php echo $CustomView1->snapshot->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_snapshot" id="z_snapshot" value="="></span></td>
		<td<?php echo $CustomView1->snapshot->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_snapshot" id="x_snapshot" size="30" value="<?php echo $CustomView1->snapshot->EditValue ?>"<?php echo $CustomView1->snapshot->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->tapebackup->RowAttributes ?>>
		<td class="ewTableHeader">Tapebackup</td>
		<td<?php echo $CustomView1->tapebackup->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_tapebackup" id="z_tapebackup" value="="></span></td>
		<td<?php echo $CustomView1->tapebackup->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_tapebackup" id="x_tapebackup" size="30" value="<?php echo $CustomView1->tapebackup->EditValue ?>"<?php echo $CustomView1->tapebackup->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->diskbackup->RowAttributes ?>>
		<td class="ewTableHeader">Diskbackup</td>
		<td<?php echo $CustomView1->diskbackup->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_diskbackup" id="z_diskbackup" value="="></span></td>
		<td<?php echo $CustomView1->diskbackup->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_diskbackup" id="x_diskbackup" size="30" value="<?php echo $CustomView1->diskbackup->EditValue ?>"<?php echo $CustomView1->diskbackup->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $CustomView1->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $CustomView1->name->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_name" id="z_name" value="LIKE"></span></td>
		<td<?php echo $CustomView1->name->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_name" id="x_name" size="30" maxlength="45" value="<?php echo $CustomView1->name->EditValue ?>"<?php echo $CustomView1->name->EditAttributes() ?>>
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
$CustomView1_search->Page_Terminate();
?>
<?php

//
// Page Class
//
class cCustomView1_search {

	// Page ID
	var $PageID = 'search';

	// Table Name
	var $TableName = 'CustomView1';

	// Page Object Name
	var $PageObjName = 'CustomView1_search';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $CustomView1;
		if ($CustomView1->UseTokenInUrl) $PageUrl .= "t=" . $CustomView1->TableVar . "&"; // add page token
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
		global $objForm, $CustomView1;
		if ($CustomView1->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($CustomView1->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($CustomView1->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cCustomView1_search() {
		global $conn;

		// Initialize table object
		$GLOBALS["CustomView1"] = new cCustomView1();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'CustomView1', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $CustomView1;
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

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $CustomView1;
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$CustomView1->CurrentAction = $objForm->GetValue("a_search");
			switch ($CustomView1->CurrentAction) {
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
						$sSrchStr = $CustomView1->UrlParm($sSrchStr);
						$this->Page_Terminate("CustomView1list.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$CustomView1->RowType = EW_ROWTYPE_SEARCH;
		$this->RenderRow();
	}

// Build advanced search
function BuildAdvancedSearch() {
	global $CustomView1;
	$sSrchUrl = "";
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->id); // id
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->mount); // mount
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->path); // path
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->parent); // parent
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->deprecated); // deprecated
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->gid); // gid
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->snapshot); // snapshot
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->tapebackup); // tapebackup
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->diskbackup); // diskbackup
	$this->BuildSearchUrl($sSrchUrl, $CustomView1->name); // name
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
		global $objForm, $CustomView1;

		// Load search values
		// id

		$CustomView1->id->AdvancedSearch->SearchValue = $objForm->GetValue("x_id");
		$CustomView1->id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_id");

		// mount
		$CustomView1->mount->AdvancedSearch->SearchValue = $objForm->GetValue("x_mount");
		$CustomView1->mount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_mount");

		// path
		$CustomView1->path->AdvancedSearch->SearchValue = $objForm->GetValue("x_path");
		$CustomView1->path->AdvancedSearch->SearchOperator = $objForm->GetValue("z_path");

		// parent
		$CustomView1->parent->AdvancedSearch->SearchValue = $objForm->GetValue("x_parent");
		$CustomView1->parent->AdvancedSearch->SearchOperator = $objForm->GetValue("z_parent");

		// deprecated
		$CustomView1->deprecated->AdvancedSearch->SearchValue = $objForm->GetValue("x_deprecated");
		$CustomView1->deprecated->AdvancedSearch->SearchOperator = $objForm->GetValue("z_deprecated");

		// gid
		$CustomView1->gid->AdvancedSearch->SearchValue = $objForm->GetValue("x_gid");
		$CustomView1->gid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_gid");

		// snapshot
		$CustomView1->snapshot->AdvancedSearch->SearchValue = $objForm->GetValue("x_snapshot");
		$CustomView1->snapshot->AdvancedSearch->SearchOperator = $objForm->GetValue("z_snapshot");

		// tapebackup
		$CustomView1->tapebackup->AdvancedSearch->SearchValue = $objForm->GetValue("x_tapebackup");
		$CustomView1->tapebackup->AdvancedSearch->SearchOperator = $objForm->GetValue("z_tapebackup");

		// diskbackup
		$CustomView1->diskbackup->AdvancedSearch->SearchValue = $objForm->GetValue("x_diskbackup");
		$CustomView1->diskbackup->AdvancedSearch->SearchOperator = $objForm->GetValue("z_diskbackup");

		// name
		$CustomView1->name->AdvancedSearch->SearchValue = $objForm->GetValue("x_name");
		$CustomView1->name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_name");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $CustomView1;

		// Call Row_Rendering event
		$CustomView1->Row_Rendering();

		// Common render codes for all row types
		// id

		$CustomView1->id->CellCssStyle = "";
		$CustomView1->id->CellCssClass = "";

		// mount
		$CustomView1->mount->CellCssStyle = "";
		$CustomView1->mount->CellCssClass = "";

		// path
		$CustomView1->path->CellCssStyle = "";
		$CustomView1->path->CellCssClass = "";

		// parent
		$CustomView1->parent->CellCssStyle = "";
		$CustomView1->parent->CellCssClass = "";

		// deprecated
		$CustomView1->deprecated->CellCssStyle = "";
		$CustomView1->deprecated->CellCssClass = "";

		// gid
		$CustomView1->gid->CellCssStyle = "";
		$CustomView1->gid->CellCssClass = "";

		// snapshot
		$CustomView1->snapshot->CellCssStyle = "";
		$CustomView1->snapshot->CellCssClass = "";

		// tapebackup
		$CustomView1->tapebackup->CellCssStyle = "";
		$CustomView1->tapebackup->CellCssClass = "";

		// diskbackup
		$CustomView1->diskbackup->CellCssStyle = "";
		$CustomView1->diskbackup->CellCssClass = "";

		// name
		$CustomView1->name->CellCssStyle = "";
		$CustomView1->name->CellCssClass = "";
		if ($CustomView1->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$CustomView1->id->ViewValue = $CustomView1->id->CurrentValue;
			$CustomView1->id->CssStyle = "";
			$CustomView1->id->CssClass = "";
			$CustomView1->id->ViewCustomAttributes = "";

			// mount
			$CustomView1->mount->ViewValue = $CustomView1->mount->CurrentValue;
			$CustomView1->mount->CssStyle = "";
			$CustomView1->mount->CssClass = "";
			$CustomView1->mount->ViewCustomAttributes = "";

			// path
			$CustomView1->path->ViewValue = $CustomView1->path->CurrentValue;
			$CustomView1->path->CssStyle = "";
			$CustomView1->path->CssClass = "";
			$CustomView1->path->ViewCustomAttributes = "";

			// parent
			$CustomView1->parent->ViewValue = $CustomView1->parent->CurrentValue;
			$CustomView1->parent->CssStyle = "";
			$CustomView1->parent->CssClass = "";
			$CustomView1->parent->ViewCustomAttributes = "";

			// deprecated
			$CustomView1->deprecated->ViewValue = $CustomView1->deprecated->CurrentValue;
			$CustomView1->deprecated->CssStyle = "";
			$CustomView1->deprecated->CssClass = "";
			$CustomView1->deprecated->ViewCustomAttributes = "";

			// gid
			$CustomView1->gid->ViewValue = $CustomView1->gid->CurrentValue;
			$CustomView1->gid->CssStyle = "";
			$CustomView1->gid->CssClass = "";
			$CustomView1->gid->ViewCustomAttributes = "";

			// snapshot
			$CustomView1->snapshot->ViewValue = $CustomView1->snapshot->CurrentValue;
			$CustomView1->snapshot->CssStyle = "";
			$CustomView1->snapshot->CssClass = "";
			$CustomView1->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$CustomView1->tapebackup->ViewValue = $CustomView1->tapebackup->CurrentValue;
			$CustomView1->tapebackup->CssStyle = "";
			$CustomView1->tapebackup->CssClass = "";
			$CustomView1->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$CustomView1->diskbackup->ViewValue = $CustomView1->diskbackup->CurrentValue;
			$CustomView1->diskbackup->CssStyle = "";
			$CustomView1->diskbackup->CssClass = "";
			$CustomView1->diskbackup->ViewCustomAttributes = "";

			// name
			$CustomView1->name->ViewValue = $CustomView1->name->CurrentValue;
			$CustomView1->name->CssStyle = "";
			$CustomView1->name->CssClass = "";
			$CustomView1->name->ViewCustomAttributes = "";

			// id
			$CustomView1->id->HrefValue = "";

			// mount
			$CustomView1->mount->HrefValue = "";

			// path
			$CustomView1->path->HrefValue = "";

			// parent
			$CustomView1->parent->HrefValue = "";

			// deprecated
			$CustomView1->deprecated->HrefValue = "";

			// gid
			$CustomView1->gid->HrefValue = "";

			// snapshot
			$CustomView1->snapshot->HrefValue = "";

			// tapebackup
			$CustomView1->tapebackup->HrefValue = "";

			// diskbackup
			$CustomView1->diskbackup->HrefValue = "";

			// name
			$CustomView1->name->HrefValue = "";
		} elseif ($CustomView1->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$CustomView1->id->EditCustomAttributes = "";
			$CustomView1->id->EditValue = ew_HtmlEncode($CustomView1->id->AdvancedSearch->SearchValue);

			// mount
			$CustomView1->mount->EditCustomAttributes = "";
			$CustomView1->mount->EditValue = ew_HtmlEncode($CustomView1->mount->AdvancedSearch->SearchValue);

			// path
			$CustomView1->path->EditCustomAttributes = "";
			$CustomView1->path->EditValue = ew_HtmlEncode($CustomView1->path->AdvancedSearch->SearchValue);

			// parent
			$CustomView1->parent->EditCustomAttributes = "";
			$CustomView1->parent->EditValue = ew_HtmlEncode($CustomView1->parent->AdvancedSearch->SearchValue);

			// deprecated
			$CustomView1->deprecated->EditCustomAttributes = "";
			$CustomView1->deprecated->EditValue = ew_HtmlEncode($CustomView1->deprecated->AdvancedSearch->SearchValue);

			// gid
			$CustomView1->gid->EditCustomAttributes = "";
			$CustomView1->gid->EditValue = ew_HtmlEncode($CustomView1->gid->AdvancedSearch->SearchValue);

			// snapshot
			$CustomView1->snapshot->EditCustomAttributes = "";
			$CustomView1->snapshot->EditValue = ew_HtmlEncode($CustomView1->snapshot->AdvancedSearch->SearchValue);

			// tapebackup
			$CustomView1->tapebackup->EditCustomAttributes = "";
			$CustomView1->tapebackup->EditValue = ew_HtmlEncode($CustomView1->tapebackup->AdvancedSearch->SearchValue);

			// diskbackup
			$CustomView1->diskbackup->EditCustomAttributes = "";
			$CustomView1->diskbackup->EditValue = ew_HtmlEncode($CustomView1->diskbackup->AdvancedSearch->SearchValue);

			// name
			$CustomView1->name->EditCustomAttributes = "";
			$CustomView1->name->EditValue = ew_HtmlEncode($CustomView1->name->AdvancedSearch->SearchValue);
		}

		// Call Row Rendered event
		$CustomView1->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $CustomView1;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($CustomView1->id->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Id";
		}
		if (!ew_CheckInteger($CustomView1->parent->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Parent";
		}
		if (!ew_CheckInteger($CustomView1->deprecated->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Deprecated";
		}
		if (!ew_CheckInteger($CustomView1->gid->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Gid";
		}
		if (!ew_CheckInteger($CustomView1->snapshot->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Snapshot";
		}
		if (!ew_CheckInteger($CustomView1->tapebackup->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Tapebackup";
		}
		if (!ew_CheckInteger($CustomView1->diskbackup->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Diskbackup";
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
		global $CustomView1;
		$CustomView1->id->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_id");
		$CustomView1->mount->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_mount");
		$CustomView1->path->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_path");
		$CustomView1->parent->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_parent");
		$CustomView1->deprecated->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_deprecated");
		$CustomView1->gid->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_gid");
		$CustomView1->snapshot->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_snapshot");
		$CustomView1->tapebackup->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_tapebackup");
		$CustomView1->diskbackup->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_diskbackup");
		$CustomView1->name->AdvancedSearch->SearchValue = $CustomView1->getAdvancedSearch("x_name");
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
