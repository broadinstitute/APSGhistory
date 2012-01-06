<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "grpinfo.php" ?>
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
$grp_search = new cgrp_search();
$Page =& $grp_search;

// Page init processing
$grp_search->Page_Init();

// Page main processing
$grp_search->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var grp_search = new ew_Page("grp_search");

// page properties
grp_search.PageID = "search"; // page ID
var EW_PAGE_ID = grp_search.PageID; // for backward compatibility

// extend page with validate function for search
grp_search.ValidateSearch = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	var infix = "";
	elm = fobj.elements["x" + infix + "_id"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Id");

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
grp_search.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
grp_search.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
grp_search.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Search TABLE: Grp<br><br>
<a href="<?php echo $grp->getReturnUrl() ?>">Back to List</a></span></p>
<?php $grp_search->ShowMessage() ?>
<form name="fgrpsearch" id="fgrpsearch" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return grp_search.ValidateSearch(this);">
<p>
<input type="hidden" name="t" id="t" value="grp">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr<?php echo $grp->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $grp->id->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_id" id="z_id" value="="></span></td>
		<td<?php echo $grp->id->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_id" id="x_id" size="30" value="<?php echo $grp->id->EditValue ?>"<?php echo $grp->id->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $grp->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $grp->name->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_name" id="z_name" value="LIKE"></span></td>
		<td<?php echo $grp->name->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_name" id="x_name" size="30" maxlength="100" value="<?php echo $grp->name->EditValue ?>"<?php echo $grp->name->EditAttributes() ?>>
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
$grp_search->Page_Terminate();
?>
<?php

//
// Page Class
//
class cgrp_search {

	// Page ID
	var $PageID = 'search';

	// Table Name
	var $TableName = 'grp';

	// Page Object Name
	var $PageObjName = 'grp_search';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $grp;
		if ($grp->UseTokenInUrl) $PageUrl .= "t=" . $grp->TableVar . "&"; // add page token
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
		global $objForm, $grp;
		if ($grp->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($grp->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($grp->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cgrp_search() {
		global $conn;

		// Initialize table object
		$GLOBALS["grp"] = new cgrp();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'grp', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $grp;
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
		global $objForm, $gsSearchError, $grp;
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$grp->CurrentAction = $objForm->GetValue("a_search");
			switch ($grp->CurrentAction) {
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
						$sSrchStr = $grp->UrlParm($sSrchStr);
						$this->Page_Terminate("grplist.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$grp->RowType = EW_ROWTYPE_SEARCH;
		$this->RenderRow();
	}

// Build advanced search
function BuildAdvancedSearch() {
	global $grp;
	$sSrchUrl = "";
	$this->BuildSearchUrl($sSrchUrl, $grp->id); // id
	$this->BuildSearchUrl($sSrchUrl, $grp->name); // name
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
		global $objForm, $grp;

		// Load search values
		// id

		$grp->id->AdvancedSearch->SearchValue = $objForm->GetValue("x_id");
		$grp->id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_id");

		// name
		$grp->name->AdvancedSearch->SearchValue = $objForm->GetValue("x_name");
		$grp->name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_name");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $grp;

		// Call Row_Rendering event
		$grp->Row_Rendering();

		// Common render codes for all row types
		// id

		$grp->id->CellCssStyle = "";
		$grp->id->CellCssClass = "";

		// name
		$grp->name->CellCssStyle = "";
		$grp->name->CellCssClass = "";
		if ($grp->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$grp->id->ViewValue = $grp->id->CurrentValue;
			$grp->id->CssStyle = "";
			$grp->id->CssClass = "";
			$grp->id->ViewCustomAttributes = "";

			// name
			$grp->name->ViewValue = $grp->name->CurrentValue;
			$grp->name->CssStyle = "";
			$grp->name->CssClass = "";
			$grp->name->ViewCustomAttributes = "";

			// id
			$grp->id->HrefValue = "";

			// name
			$grp->name->HrefValue = "";
		} elseif ($grp->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$grp->id->EditCustomAttributes = "";
			$grp->id->EditValue = ew_HtmlEncode($grp->id->AdvancedSearch->SearchValue);

			// name
			$grp->name->EditCustomAttributes = "";
			$grp->name->EditValue = ew_HtmlEncode($grp->name->AdvancedSearch->SearchValue);
		}

		// Call Row Rendered event
		$grp->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $grp;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($grp->id->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Id";
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
		global $grp;
		$grp->id->AdvancedSearch->SearchValue = $grp->getAdvancedSearch("x_id");
		$grp->name->AdvancedSearch->SearchValue = $grp->getAdvancedSearch("x_name");
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
