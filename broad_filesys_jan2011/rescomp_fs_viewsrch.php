<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "rescomp_fs_viewinfo.php" ?>
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
$rescomp_fs_view_search = new crescomp_fs_view_search();
$Page =& $rescomp_fs_view_search;

// Page init processing
$rescomp_fs_view_search->Page_Init();

// Page main processing
$rescomp_fs_view_search->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var rescomp_fs_view_search = new ew_Page("rescomp_fs_view_search");

// page properties
rescomp_fs_view_search.PageID = "search"; // page ID
var EW_PAGE_ID = rescomp_fs_view_search.PageID; // for backward compatibility

// extend page with validate function for search
rescomp_fs_view_search.ValidateSearch = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	var infix = "";

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
rescomp_fs_view_search.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rescomp_fs_view_search.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rescomp_fs_view_search.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Search View: Rescomp Fs View<br><br>
<a href="<?php echo $rescomp_fs_view->getReturnUrl() ?>">Back to List</a></span></p>
<?php $rescomp_fs_view_search->ShowMessage() ?>
<form name="frescomp_fs_viewsearch" id="frescomp_fs_viewsearch" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return rescomp_fs_view_search.ValidateSearch(this);">
<p>
<input type="hidden" name="t" id="t" value="rescomp_fs_view">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr<?php echo $rescomp_fs_view->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount</td>
		<td<?php echo $rescomp_fs_view->mount->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_mount" id="z_mount" value="LIKE"></span></td>
		<td<?php echo $rescomp_fs_view->mount->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_mount" id="x_mount" size="30" maxlength="100" value="<?php echo $rescomp_fs_view->mount->EditValue ?>"<?php echo $rescomp_fs_view->mount->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $rescomp_fs_view->path->RowAttributes ?>>
		<td class="ewTableHeader">Path</td>
		<td<?php echo $rescomp_fs_view->path->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_path" id="z_path" value="LIKE"></span></td>
		<td<?php echo $rescomp_fs_view->path->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_path" id="x_path" size="30" maxlength="100" value="<?php echo $rescomp_fs_view->path->EditValue ?>"<?php echo $rescomp_fs_view->path->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $rescomp_fs_view->gecos->RowAttributes ?>>
		<td class="ewTableHeader">Gecos</td>
		<td<?php echo $rescomp_fs_view->gecos->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_gecos" id="z_gecos" value="LIKE"></span></td>
		<td<?php echo $rescomp_fs_view->gecos->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_gecos" id="x_gecos" size="30" maxlength="80" value="<?php echo $rescomp_fs_view->gecos->EditValue ?>"<?php echo $rescomp_fs_view->gecos->EditAttributes() ?>>
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
$rescomp_fs_view_search->Page_Terminate();
?>
<?php

//
// Page Class
//
class crescomp_fs_view_search {

	// Page ID
	var $PageID = 'search';

	// Table Name
	var $TableName = 'rescomp_fs_view';

	// Page Object Name
	var $PageObjName = 'rescomp_fs_view_search';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $rescomp_fs_view;
		if ($rescomp_fs_view->UseTokenInUrl) $PageUrl .= "t=" . $rescomp_fs_view->TableVar . "&"; // add page token
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
		global $objForm, $rescomp_fs_view;
		if ($rescomp_fs_view->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($rescomp_fs_view->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($rescomp_fs_view->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function crescomp_fs_view_search() {
		global $conn;

		// Initialize table object
		$GLOBALS["rescomp_fs_view"] = new crescomp_fs_view();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rescomp_fs_view', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $rescomp_fs_view;

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
		global $objForm, $gsSearchError, $rescomp_fs_view;
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$rescomp_fs_view->CurrentAction = $objForm->GetValue("a_search");
			switch ($rescomp_fs_view->CurrentAction) {
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
						$sSrchStr = $rescomp_fs_view->UrlParm($sSrchStr);
						$this->Page_Terminate("rescomp_fs_viewlist.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$rescomp_fs_view->RowType = EW_ROWTYPE_SEARCH;
		$this->RenderRow();
	}

// Build advanced search
function BuildAdvancedSearch() {
	global $rescomp_fs_view;
	$sSrchUrl = "";
	$this->BuildSearchUrl($sSrchUrl, $rescomp_fs_view->mount); // mount
	$this->BuildSearchUrl($sSrchUrl, $rescomp_fs_view->path); // path
	$this->BuildSearchUrl($sSrchUrl, $rescomp_fs_view->gecos); // gecos
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
		global $objForm, $rescomp_fs_view;

		// Load search values
		// mount

		$rescomp_fs_view->mount->AdvancedSearch->SearchValue = $objForm->GetValue("x_mount");
		$rescomp_fs_view->mount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_mount");

		// path
		$rescomp_fs_view->path->AdvancedSearch->SearchValue = $objForm->GetValue("x_path");
		$rescomp_fs_view->path->AdvancedSearch->SearchOperator = $objForm->GetValue("z_path");

		// gecos
		$rescomp_fs_view->gecos->AdvancedSearch->SearchValue = $objForm->GetValue("x_gecos");
		$rescomp_fs_view->gecos->AdvancedSearch->SearchOperator = $objForm->GetValue("z_gecos");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $rescomp_fs_view;

		// Call Row_Rendering event
		$rescomp_fs_view->Row_Rendering();

		// Common render codes for all row types
		// mount

		$rescomp_fs_view->mount->CellCssStyle = "";
		$rescomp_fs_view->mount->CellCssClass = "";

		// path
		$rescomp_fs_view->path->CellCssStyle = "";
		$rescomp_fs_view->path->CellCssClass = "";

		// gecos
		$rescomp_fs_view->gecos->CellCssStyle = "";
		$rescomp_fs_view->gecos->CellCssClass = "";
		if ($rescomp_fs_view->RowType == EW_ROWTYPE_VIEW) { // View row

			// mount
			$rescomp_fs_view->mount->ViewValue = $rescomp_fs_view->mount->CurrentValue;
			$rescomp_fs_view->mount->CssStyle = "";
			$rescomp_fs_view->mount->CssClass = "";
			$rescomp_fs_view->mount->ViewCustomAttributes = "";

			// path
			$rescomp_fs_view->path->ViewValue = $rescomp_fs_view->path->CurrentValue;
			$rescomp_fs_view->path->CssStyle = "";
			$rescomp_fs_view->path->CssClass = "";
			$rescomp_fs_view->path->ViewCustomAttributes = "";

			// gecos
			$rescomp_fs_view->gecos->ViewValue = $rescomp_fs_view->gecos->CurrentValue;
			$rescomp_fs_view->gecos->CssStyle = "";
			$rescomp_fs_view->gecos->CssClass = "";
			$rescomp_fs_view->gecos->ViewCustomAttributes = "";

			// mount
			$rescomp_fs_view->mount->HrefValue = "";

			// path
			$rescomp_fs_view->path->HrefValue = "";

			// gecos
			$rescomp_fs_view->gecos->HrefValue = "";
		} elseif ($rescomp_fs_view->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// mount
			$rescomp_fs_view->mount->EditCustomAttributes = "";
			$rescomp_fs_view->mount->EditValue = ew_HtmlEncode($rescomp_fs_view->mount->AdvancedSearch->SearchValue);

			// path
			$rescomp_fs_view->path->EditCustomAttributes = "";
			$rescomp_fs_view->path->EditValue = ew_HtmlEncode($rescomp_fs_view->path->AdvancedSearch->SearchValue);

			// gecos
			$rescomp_fs_view->gecos->EditCustomAttributes = "";
			$rescomp_fs_view->gecos->EditValue = ew_HtmlEncode($rescomp_fs_view->gecos->AdvancedSearch->SearchValue);
		}

		// Call Row Rendered event
		$rescomp_fs_view->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $rescomp_fs_view;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

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
		global $rescomp_fs_view;
		$rescomp_fs_view->mount->AdvancedSearch->SearchValue = $rescomp_fs_view->getAdvancedSearch("x_mount");
		$rescomp_fs_view->path->AdvancedSearch->SearchValue = $rescomp_fs_view->getAdvancedSearch("x_path");
		$rescomp_fs_view->gecos->AdvancedSearch->SearchValue = $rescomp_fs_view->getAdvancedSearch("x_gecos");
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
