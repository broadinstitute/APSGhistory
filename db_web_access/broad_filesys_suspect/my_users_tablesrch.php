<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "my_users_tableinfo.php" ?>
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
$my_users_table_search = new cmy_users_table_search();
$Page =& $my_users_table_search;

// Page init processing
$my_users_table_search->Page_Init();

// Page main processing
$my_users_table_search->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var my_users_table_search = new ew_Page("my_users_table_search");

// page properties
my_users_table_search.PageID = "search"; // page ID
var EW_PAGE_ID = my_users_table_search.PageID; // for backward compatibility

// extend page with validate function for search
my_users_table_search.ValidateSearch = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	var infix = "";
	elm = fobj.elements["x" + infix + "_uid"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Uid");
	elm = fobj.elements["x" + infix + "_role"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Role");
	elm = fobj.elements["x" + infix + "_gid"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Gid");

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
my_users_table_search.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
my_users_table_search.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
my_users_table_search.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Search TABLE: My Users Table<br><br>
<a href="<?php echo $my_users_table->getReturnUrl() ?>">Back to List</a></span></p>
<?php $my_users_table_search->ShowMessage() ?>
<form name="fmy_users_tablesearch" id="fmy_users_tablesearch" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return my_users_table_search.ValidateSearch(this);">
<p>
<input type="hidden" name="t" id="t" value="my_users_table">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr<?php echo $my_users_table->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid</td>
		<td<?php echo $my_users_table->uid->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_uid" id="z_uid" value="="></span></td>
		<td<?php echo $my_users_table->uid->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_uid" id="x_uid" size="30" value="<?php echo $my_users_table->uid->EditValue ?>"<?php echo $my_users_table->uid->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $my_users_table->username->RowAttributes ?>>
		<td class="ewTableHeader">Username</td>
		<td<?php echo $my_users_table->username->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_username" id="z_username" value="LIKE"></span></td>
		<td<?php echo $my_users_table->username->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_username" id="x_username" size="30" maxlength="16" value="<?php echo $my_users_table->username->EditValue ?>"<?php echo $my_users_table->username->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $my_users_table->gecos->RowAttributes ?>>
		<td class="ewTableHeader">Gecos</td>
		<td<?php echo $my_users_table->gecos->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_gecos" id="z_gecos" value="LIKE"></span></td>
		<td<?php echo $my_users_table->gecos->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_gecos" id="x_gecos" size="30" maxlength="80" value="<?php echo $my_users_table->gecos->EditValue ?>"<?php echo $my_users_table->gecos->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $my_users_table->role->RowAttributes ?>>
		<td class="ewTableHeader">Role</td>
		<td<?php echo $my_users_table->role->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_role" id="z_role" value="="></span></td>
		<td<?php echo $my_users_table->role->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_role" id="x_role" size="30" value="<?php echo $my_users_table->role->EditValue ?>"<?php echo $my_users_table->role->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $my_users_table->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $my_users_table->gid->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_gid" id="z_gid" value="="></span></td>
		<td<?php echo $my_users_table->gid->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $my_users_table->gid->EditValue ?>"<?php echo $my_users_table->gid->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $my_users_table->cobj->RowAttributes ?>>
		<td class="ewTableHeader">Cobj</td>
		<td<?php echo $my_users_table->cobj->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_cobj" id="z_cobj" value="LIKE"></span></td>
		<td<?php echo $my_users_table->cobj->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_cobj" id="x_cobj" size="30" maxlength="200" value="<?php echo $my_users_table->cobj->EditValue ?>"<?php echo $my_users_table->cobj->EditAttributes() ?>>
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
$my_users_table_search->Page_Terminate();
?>
<?php

//
// Page Class
//
class cmy_users_table_search {

	// Page ID
	var $PageID = 'search';

	// Table Name
	var $TableName = 'my_users_table';

	// Page Object Name
	var $PageObjName = 'my_users_table_search';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $my_users_table;
		if ($my_users_table->UseTokenInUrl) $PageUrl .= "t=" . $my_users_table->TableVar . "&"; // add page token
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
		global $objForm, $my_users_table;
		if ($my_users_table->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($my_users_table->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($my_users_table->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmy_users_table_search() {
		global $conn;

		// Initialize table object
		$GLOBALS["my_users_table"] = new cmy_users_table();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'my_users_table', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $my_users_table;
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
		global $objForm, $gsSearchError, $my_users_table;
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$my_users_table->CurrentAction = $objForm->GetValue("a_search");
			switch ($my_users_table->CurrentAction) {
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
						$sSrchStr = $my_users_table->UrlParm($sSrchStr);
						$this->Page_Terminate("my_users_tablelist.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$my_users_table->RowType = EW_ROWTYPE_SEARCH;
		$this->RenderRow();
	}

// Build advanced search
function BuildAdvancedSearch() {
	global $my_users_table;
	$sSrchUrl = "";
	$this->BuildSearchUrl($sSrchUrl, $my_users_table->uid); // uid
	$this->BuildSearchUrl($sSrchUrl, $my_users_table->username); // username
	$this->BuildSearchUrl($sSrchUrl, $my_users_table->gecos); // gecos
	$this->BuildSearchUrl($sSrchUrl, $my_users_table->role); // role
	$this->BuildSearchUrl($sSrchUrl, $my_users_table->gid); // gid
	$this->BuildSearchUrl($sSrchUrl, $my_users_table->cobj); // cobj
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
		global $objForm, $my_users_table;

		// Load search values
		// uid

		$my_users_table->uid->AdvancedSearch->SearchValue = $objForm->GetValue("x_uid");
		$my_users_table->uid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_uid");

		// username
		$my_users_table->username->AdvancedSearch->SearchValue = $objForm->GetValue("x_username");
		$my_users_table->username->AdvancedSearch->SearchOperator = $objForm->GetValue("z_username");

		// gecos
		$my_users_table->gecos->AdvancedSearch->SearchValue = $objForm->GetValue("x_gecos");
		$my_users_table->gecos->AdvancedSearch->SearchOperator = $objForm->GetValue("z_gecos");

		// role
		$my_users_table->role->AdvancedSearch->SearchValue = $objForm->GetValue("x_role");
		$my_users_table->role->AdvancedSearch->SearchOperator = $objForm->GetValue("z_role");

		// gid
		$my_users_table->gid->AdvancedSearch->SearchValue = $objForm->GetValue("x_gid");
		$my_users_table->gid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_gid");

		// cobj
		$my_users_table->cobj->AdvancedSearch->SearchValue = $objForm->GetValue("x_cobj");
		$my_users_table->cobj->AdvancedSearch->SearchOperator = $objForm->GetValue("z_cobj");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $my_users_table;

		// Call Row_Rendering event
		$my_users_table->Row_Rendering();

		// Common render codes for all row types
		// uid

		$my_users_table->uid->CellCssStyle = "";
		$my_users_table->uid->CellCssClass = "";

		// username
		$my_users_table->username->CellCssStyle = "";
		$my_users_table->username->CellCssClass = "";

		// gecos
		$my_users_table->gecos->CellCssStyle = "";
		$my_users_table->gecos->CellCssClass = "";

		// role
		$my_users_table->role->CellCssStyle = "";
		$my_users_table->role->CellCssClass = "";

		// gid
		$my_users_table->gid->CellCssStyle = "";
		$my_users_table->gid->CellCssClass = "";

		// cobj
		$my_users_table->cobj->CellCssStyle = "";
		$my_users_table->cobj->CellCssClass = "";
		if ($my_users_table->RowType == EW_ROWTYPE_VIEW) { // View row

			// uid
			$my_users_table->uid->ViewValue = $my_users_table->uid->CurrentValue;
			$my_users_table->uid->CssStyle = "";
			$my_users_table->uid->CssClass = "";
			$my_users_table->uid->ViewCustomAttributes = "";

			// username
			$my_users_table->username->ViewValue = $my_users_table->username->CurrentValue;
			$my_users_table->username->CssStyle = "";
			$my_users_table->username->CssClass = "";
			$my_users_table->username->ViewCustomAttributes = "";

			// gecos
			$my_users_table->gecos->ViewValue = $my_users_table->gecos->CurrentValue;
			$my_users_table->gecos->CssStyle = "";
			$my_users_table->gecos->CssClass = "";
			$my_users_table->gecos->ViewCustomAttributes = "";

			// role
			$my_users_table->role->ViewValue = $my_users_table->role->CurrentValue;
			$my_users_table->role->CssStyle = "";
			$my_users_table->role->CssClass = "";
			$my_users_table->role->ViewCustomAttributes = "";

			// gid
			$my_users_table->gid->ViewValue = $my_users_table->gid->CurrentValue;
			$my_users_table->gid->CssStyle = "";
			$my_users_table->gid->CssClass = "";
			$my_users_table->gid->ViewCustomAttributes = "";

			// cobj
			$my_users_table->cobj->ViewValue = $my_users_table->cobj->CurrentValue;
			$my_users_table->cobj->CssStyle = "";
			$my_users_table->cobj->CssClass = "";
			$my_users_table->cobj->ViewCustomAttributes = "";

			// uid
			$my_users_table->uid->HrefValue = "";

			// username
			$my_users_table->username->HrefValue = "";

			// gecos
			$my_users_table->gecos->HrefValue = "";

			// role
			$my_users_table->role->HrefValue = "";

			// gid
			$my_users_table->gid->HrefValue = "";

			// cobj
			$my_users_table->cobj->HrefValue = "";
		} elseif ($my_users_table->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// uid
			$my_users_table->uid->EditCustomAttributes = "";
			$my_users_table->uid->EditValue = ew_HtmlEncode($my_users_table->uid->AdvancedSearch->SearchValue);

			// username
			$my_users_table->username->EditCustomAttributes = "";
			$my_users_table->username->EditValue = ew_HtmlEncode($my_users_table->username->AdvancedSearch->SearchValue);

			// gecos
			$my_users_table->gecos->EditCustomAttributes = "";
			$my_users_table->gecos->EditValue = ew_HtmlEncode($my_users_table->gecos->AdvancedSearch->SearchValue);

			// role
			$my_users_table->role->EditCustomAttributes = "";
			$my_users_table->role->EditValue = ew_HtmlEncode($my_users_table->role->AdvancedSearch->SearchValue);

			// gid
			$my_users_table->gid->EditCustomAttributes = "";
			$my_users_table->gid->EditValue = ew_HtmlEncode($my_users_table->gid->AdvancedSearch->SearchValue);

			// cobj
			$my_users_table->cobj->EditCustomAttributes = "";
			$my_users_table->cobj->EditValue = ew_HtmlEncode($my_users_table->cobj->AdvancedSearch->SearchValue);
		}

		// Call Row Rendered event
		$my_users_table->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $my_users_table;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($my_users_table->uid->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Uid";
		}
		if (!ew_CheckInteger($my_users_table->role->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Role";
		}
		if (!ew_CheckInteger($my_users_table->gid->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Gid";
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
		global $my_users_table;
		$my_users_table->uid->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_uid");
		$my_users_table->username->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_username");
		$my_users_table->gecos->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_gecos");
		$my_users_table->role->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_role");
		$my_users_table->gid->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_gid");
		$my_users_table->cobj->AdvancedSearch->SearchValue = $my_users_table->getAdvancedSearch("x_cobj");
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
