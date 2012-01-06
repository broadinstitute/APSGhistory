<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "usersinfo.php" ?>
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
$users_search = new cusers_search();
$Page =& $users_search;

// Page init processing
$users_search->Page_Init();

// Page main processing
$users_search->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var users_search = new ew_Page("users_search");

// page properties
users_search.PageID = "search"; // page ID
var EW_PAGE_ID = users_search.PageID; // for backward compatibility

// extend page with validate function for search
users_search.ValidateSearch = function(fobj) {
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
users_search.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
users_search.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
users_search.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Search TABLE: Users<br><br>
<a href="<?php echo $users->getReturnUrl() ?>">Back to List</a></span></p>
<?php $users_search->ShowMessage() ?>
<form name="fuserssearch" id="fuserssearch" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return users_search.ValidateSearch(this);">
<p>
<input type="hidden" name="t" id="t" value="users">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr<?php echo $users->uid->RowAttributes ?>>
		<td class="ewTableHeader">Uid</td>
		<td<?php echo $users->uid->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_uid" id="z_uid" value="="></span></td>
		<td<?php echo $users->uid->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_uid" id="x_uid" size="30" value="<?php echo $users->uid->EditValue ?>"<?php echo $users->uid->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $users->username->RowAttributes ?>>
		<td class="ewTableHeader">Username</td>
		<td<?php echo $users->username->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_username" id="z_username" value="LIKE"></span></td>
		<td<?php echo $users->username->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_username" id="x_username" size="30" maxlength="16" value="<?php echo $users->username->EditValue ?>"<?php echo $users->username->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $users->gecos->RowAttributes ?>>
		<td class="ewTableHeader">Gecos</td>
		<td<?php echo $users->gecos->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_gecos" id="z_gecos" value="LIKE"></span></td>
		<td<?php echo $users->gecos->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_gecos" id="x_gecos" size="30" maxlength="80" value="<?php echo $users->gecos->EditValue ?>"<?php echo $users->gecos->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $users->role->RowAttributes ?>>
		<td class="ewTableHeader">Role</td>
		<td<?php echo $users->role->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_role" id="z_role" value="="></span></td>
		<td<?php echo $users->role->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_role" id="x_role" size="30" value="<?php echo $users->role->EditValue ?>"<?php echo $users->role->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $users->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $users->gid->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_gid" id="z_gid" value="="></span></td>
		<td<?php echo $users->gid->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $users->gid->EditValue ?>"<?php echo $users->gid->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $users->cobj->RowAttributes ?>>
		<td class="ewTableHeader">Cobj</td>
		<td<?php echo $users->cobj->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_cobj" id="z_cobj" value="LIKE"></span></td>
		<td<?php echo $users->cobj->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_cobj" id="x_cobj" size="30" maxlength="200" value="<?php echo $users->cobj->EditValue ?>"<?php echo $users->cobj->EditAttributes() ?>>
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
$users_search->Page_Terminate();
?>
<?php

//
// Page Class
//
class cusers_search {

	// Page ID
	var $PageID = 'search';

	// Table Name
	var $TableName = 'users';

	// Page Object Name
	var $PageObjName = 'users_search';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $users;
		if ($users->UseTokenInUrl) $PageUrl .= "t=" . $users->TableVar . "&"; // add page token
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
		global $objForm, $users;
		if ($users->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($users->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($users->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cusers_search() {
		global $conn;

		// Initialize table object
		$GLOBALS["users"] = new cusers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $users;

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
		global $objForm, $gsSearchError, $users;
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$users->CurrentAction = $objForm->GetValue("a_search");
			switch ($users->CurrentAction) {
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
						$sSrchStr = $users->UrlParm($sSrchStr);
						$this->Page_Terminate("userslist.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$users->RowType = EW_ROWTYPE_SEARCH;
		$this->RenderRow();
	}

// Build advanced search
function BuildAdvancedSearch() {
	global $users;
	$sSrchUrl = "";
	$this->BuildSearchUrl($sSrchUrl, $users->uid); // uid
	$this->BuildSearchUrl($sSrchUrl, $users->username); // username
	$this->BuildSearchUrl($sSrchUrl, $users->gecos); // gecos
	$this->BuildSearchUrl($sSrchUrl, $users->role); // role
	$this->BuildSearchUrl($sSrchUrl, $users->gid); // gid
	$this->BuildSearchUrl($sSrchUrl, $users->cobj); // cobj
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
		global $objForm, $users;

		// Load search values
		// uid

		$users->uid->AdvancedSearch->SearchValue = $objForm->GetValue("x_uid");
		$users->uid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_uid");

		// username
		$users->username->AdvancedSearch->SearchValue = $objForm->GetValue("x_username");
		$users->username->AdvancedSearch->SearchOperator = $objForm->GetValue("z_username");

		// gecos
		$users->gecos->AdvancedSearch->SearchValue = $objForm->GetValue("x_gecos");
		$users->gecos->AdvancedSearch->SearchOperator = $objForm->GetValue("z_gecos");

		// role
		$users->role->AdvancedSearch->SearchValue = $objForm->GetValue("x_role");
		$users->role->AdvancedSearch->SearchOperator = $objForm->GetValue("z_role");

		// gid
		$users->gid->AdvancedSearch->SearchValue = $objForm->GetValue("x_gid");
		$users->gid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_gid");

		// cobj
		$users->cobj->AdvancedSearch->SearchValue = $objForm->GetValue("x_cobj");
		$users->cobj->AdvancedSearch->SearchOperator = $objForm->GetValue("z_cobj");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $users;

		// Call Row_Rendering event
		$users->Row_Rendering();

		// Common render codes for all row types
		// uid

		$users->uid->CellCssStyle = "";
		$users->uid->CellCssClass = "";

		// username
		$users->username->CellCssStyle = "";
		$users->username->CellCssClass = "";

		// gecos
		$users->gecos->CellCssStyle = "";
		$users->gecos->CellCssClass = "";

		// role
		$users->role->CellCssStyle = "";
		$users->role->CellCssClass = "";

		// gid
		$users->gid->CellCssStyle = "";
		$users->gid->CellCssClass = "";

		// cobj
		$users->cobj->CellCssStyle = "";
		$users->cobj->CellCssClass = "";
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

			// username
			$users->username->HrefValue = "";

			// gecos
			$users->gecos->HrefValue = "";

			// role
			$users->role->HrefValue = "";

			// gid
			$users->gid->HrefValue = "";

			// cobj
			$users->cobj->HrefValue = "";
		} elseif ($users->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// uid
			$users->uid->EditCustomAttributes = "";
			$users->uid->EditValue = ew_HtmlEncode($users->uid->AdvancedSearch->SearchValue);

			// username
			$users->username->EditCustomAttributes = "";
			$users->username->EditValue = ew_HtmlEncode($users->username->AdvancedSearch->SearchValue);

			// gecos
			$users->gecos->EditCustomAttributes = "";
			$users->gecos->EditValue = ew_HtmlEncode($users->gecos->AdvancedSearch->SearchValue);

			// role
			$users->role->EditCustomAttributes = "";
			$users->role->EditValue = ew_HtmlEncode($users->role->AdvancedSearch->SearchValue);

			// gid
			$users->gid->EditCustomAttributes = "";
			$users->gid->EditValue = ew_HtmlEncode($users->gid->AdvancedSearch->SearchValue);

			// cobj
			$users->cobj->EditCustomAttributes = "";
			$users->cobj->EditValue = ew_HtmlEncode($users->cobj->AdvancedSearch->SearchValue);
		}

		// Call Row Rendered event
		$users->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $users;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($users->uid->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Uid";
		}
		if (!ew_CheckInteger($users->role->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Role";
		}
		if (!ew_CheckInteger($users->gid->AdvancedSearch->SearchValue)) {
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
		global $users;
		$users->uid->AdvancedSearch->SearchValue = $users->getAdvancedSearch("x_uid");
		$users->username->AdvancedSearch->SearchValue = $users->getAdvancedSearch("x_username");
		$users->gecos->AdvancedSearch->SearchValue = $users->getAdvancedSearch("x_gecos");
		$users->role->AdvancedSearch->SearchValue = $users->getAdvancedSearch("x_role");
		$users->gid->AdvancedSearch->SearchValue = $users->getAdvancedSearch("x_gid");
		$users->cobj->AdvancedSearch->SearchValue = $users->getAdvancedSearch("x_cobj");
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
