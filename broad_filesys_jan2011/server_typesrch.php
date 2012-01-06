<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "server_typeinfo.php" ?>
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
$server_type_search = new cserver_type_search();
$Page =& $server_type_search;

// Page init processing
$server_type_search->Page_Init();

// Page main processing
$server_type_search->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var server_type_search = new ew_Page("server_type_search");

// page properties
server_type_search.PageID = "search"; // page ID
var EW_PAGE_ID = server_type_search.PageID; // for backward compatibility

// extend page with validate function for search
server_type_search.ValidateSearch = function(fobj) {
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
server_type_search.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
server_type_search.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
server_type_search.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Search TABLE: Server Type<br><br>
<a href="<?php echo $server_type->getReturnUrl() ?>">Back to List</a></span></p>
<?php $server_type_search->ShowMessage() ?>
<form name="fserver_typesearch" id="fserver_typesearch" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return server_type_search.ValidateSearch(this);">
<p>
<input type="hidden" name="t" id="t" value="server_type">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr<?php echo $server_type->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $server_type->id->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_id" id="z_id" onchange="ew_SrchOprChanged('z_id')"><option value="="<?php echo ($server_type->id->AdvancedSearch->SearchOperator=="=") ? " selected=\"selected\"" : "" ?> >=</option><option value="<>"<?php echo ($server_type->id->AdvancedSearch->SearchOperator=="<>") ? " selected=\"selected\"" : "" ?> ><></option><option value="<"<?php echo ($server_type->id->AdvancedSearch->SearchOperator=="<") ? " selected=\"selected\"" : "" ?> ><</option><option value="<="<?php echo ($server_type->id->AdvancedSearch->SearchOperator=="<=") ? " selected=\"selected\"" : "" ?> ><=</option><option value=">"<?php echo ($server_type->id->AdvancedSearch->SearchOperator==">") ? " selected=\"selected\"" : "" ?> >></option><option value=">="<?php echo ($server_type->id->AdvancedSearch->SearchOperator==">=") ? " selected=\"selected\"" : "" ?> >>=</option><option value="BETWEEN"<?php echo ($server_type->id->AdvancedSearch->SearchOperator=="BETWEEN") ? " selected=\"selected\"" : "" ?> >between</option></select></span></td>
		<td<?php echo $server_type->id->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_id" id="x_id" value="<?php echo $server_type->id->EditValue ?>"<?php echo $server_type->id->EditAttributes() ?>>
</span></td>
				<td><span class="ewSearchOpr" style="display: none" id="btw1_id" name="btw1_id">&nbsp;and&nbsp;</span></td>
				<td><span class="phpmaker" style="display: none" id="btw1_id" name="btw1_id">
<input type="text" name="y_id" id="y_id" value="<?php echo $server_type->id->EditValue2 ?>"<?php echo $server_type->id->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $server_type->name->RowAttributes ?>>
		<td class="ewTableHeader">Name</td>
		<td<?php echo $server_type->name->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_name" id="z_name" onchange="ew_SrchOprChanged('z_name')"><option value="="<?php echo ($server_type->name->AdvancedSearch->SearchOperator=="=") ? " selected=\"selected\"" : "" ?> >=</option><option value="<>"<?php echo ($server_type->name->AdvancedSearch->SearchOperator=="<>") ? " selected=\"selected\"" : "" ?> ><></option><option value="<"<?php echo ($server_type->name->AdvancedSearch->SearchOperator=="<") ? " selected=\"selected\"" : "" ?> ><</option><option value="<="<?php echo ($server_type->name->AdvancedSearch->SearchOperator=="<=") ? " selected=\"selected\"" : "" ?> ><=</option><option value=">"<?php echo ($server_type->name->AdvancedSearch->SearchOperator==">") ? " selected=\"selected\"" : "" ?> >></option><option value=">="<?php echo ($server_type->name->AdvancedSearch->SearchOperator==">=") ? " selected=\"selected\"" : "" ?> >>=</option><option value="LIKE"<?php echo ($server_type->name->AdvancedSearch->SearchOperator=="LIKE") ? " selected=\"selected\"" : "" ?> >contains</option><option value="NOT LIKE"<?php echo ($server_type->name->AdvancedSearch->SearchOperator=="NOT LIKE") ? " selected=\"selected\"" : "" ?> >not contains</option><option value="STARTS WITH"<?php echo ($server_type->name->AdvancedSearch->SearchOperator=="STARTS WITH") ? " selected=\"selected\"" : "" ?> >starts with</option><option value="BETWEEN"<?php echo ($server_type->name->AdvancedSearch->SearchOperator=="BETWEEN") ? " selected=\"selected\"" : "" ?> >between</option></select></span></td>
		<td<?php echo $server_type->name->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_name" id="x_name" size="30" maxlength="45" value="<?php echo $server_type->name->EditValue ?>"<?php echo $server_type->name->EditAttributes() ?>>
</span></td>
				<td><span class="ewSearchOpr" style="display: none" id="btw1_name" name="btw1_name">&nbsp;and&nbsp;</span></td>
				<td><span class="phpmaker" style="display: none" id="btw1_name" name="btw1_name">
<input type="text" name="y_name" id="y_name" size="30" maxlength="45" value="<?php echo $server_type->name->EditValue2 ?>"<?php echo $server_type->name->EditAttributes() ?>>
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
ew_SrchOprChanged('z_id');
ew_SrchOprChanged('z_name');

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$server_type_search->Page_Terminate();
?>
<?php

//
// Page Class
//
class cserver_type_search {

	// Page ID
	var $PageID = 'search';

	// Table Name
	var $TableName = 'server_type';

	// Page Object Name
	var $PageObjName = 'server_type_search';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $server_type;
		if ($server_type->UseTokenInUrl) $PageUrl .= "t=" . $server_type->TableVar . "&"; // add page token
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
		global $objForm, $server_type;
		if ($server_type->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($server_type->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($server_type->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cserver_type_search() {
		global $conn;

		// Initialize table object
		$GLOBALS["server_type"] = new cserver_type();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'server_type', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $server_type;
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
		global $objForm, $gsSearchError, $server_type;
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$server_type->CurrentAction = $objForm->GetValue("a_search");
			switch ($server_type->CurrentAction) {
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
						$sSrchStr = $server_type->UrlParm($sSrchStr);
						$this->Page_Terminate("server_typelist.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$server_type->RowType = EW_ROWTYPE_SEARCH;
		$this->RenderRow();
	}

// Build advanced search
function BuildAdvancedSearch() {
	global $server_type;
	$sSrchUrl = "";
	$this->BuildSearchUrl($sSrchUrl, $server_type->id); // id
	$this->BuildSearchUrl($sSrchUrl, $server_type->name); // name
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
		global $objForm, $server_type;

		// Load search values
		// id

		$server_type->id->AdvancedSearch->SearchValue = $objForm->GetValue("x_id");
		$server_type->id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_id");
		$server_type->id->AdvancedSearch->SearchCondition = $objForm->GetValue("v_id");
		$server_type->id->AdvancedSearch->SearchValue2 = $objForm->GetValue("y_id");
		$server_type->id->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_id");

		// name
		$server_type->name->AdvancedSearch->SearchValue = $objForm->GetValue("x_name");
		$server_type->name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_name");
		$server_type->name->AdvancedSearch->SearchCondition = $objForm->GetValue("v_name");
		$server_type->name->AdvancedSearch->SearchValue2 = $objForm->GetValue("y_name");
		$server_type->name->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_name");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $server_type;

		// Call Row_Rendering event
		$server_type->Row_Rendering();

		// Common render codes for all row types
		// id

		$server_type->id->CellCssStyle = "";
		$server_type->id->CellCssClass = "";

		// name
		$server_type->name->CellCssStyle = "";
		$server_type->name->CellCssClass = "";
		if ($server_type->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$server_type->id->ViewValue = $server_type->id->CurrentValue;
			$server_type->id->CssStyle = "";
			$server_type->id->CssClass = "";
			$server_type->id->ViewCustomAttributes = "";

			// name
			$server_type->name->ViewValue = $server_type->name->CurrentValue;
			$server_type->name->CssStyle = "";
			$server_type->name->CssClass = "";
			$server_type->name->ViewCustomAttributes = "";

			// id
			$server_type->id->HrefValue = "";

			// name
			$server_type->name->HrefValue = "";
		} elseif ($server_type->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$server_type->id->EditCustomAttributes = "";
			$server_type->id->EditValue = ew_HtmlEncode($server_type->id->AdvancedSearch->SearchValue);
			$server_type->id->EditCustomAttributes = "";
			$server_type->id->EditValue2 = ew_HtmlEncode($server_type->id->AdvancedSearch->SearchValue2);

			// name
			$server_type->name->EditCustomAttributes = "";
			$server_type->name->EditValue = ew_HtmlEncode($server_type->name->AdvancedSearch->SearchValue);
			$server_type->name->EditCustomAttributes = "";
			$server_type->name->EditValue2 = ew_HtmlEncode($server_type->name->AdvancedSearch->SearchValue2);
		}

		// Call Row Rendered event
		$server_type->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $server_type;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($server_type->id->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Id";
		}
		if (!ew_CheckInteger($server_type->id->AdvancedSearch->SearchValue2)) {
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
		global $server_type;
		$server_type->id->AdvancedSearch->SearchValue = $server_type->getAdvancedSearch("x_id");
		$server_type->id->AdvancedSearch->SearchOperator = $server_type->getAdvancedSearch("z_id");
		$server_type->id->AdvancedSearch->SearchValue2 = $server_type->getAdvancedSearch("y_id");
		$server_type->name->AdvancedSearch->SearchValue = $server_type->getAdvancedSearch("x_name");
		$server_type->name->AdvancedSearch->SearchOperator = $server_type->getAdvancedSearch("z_name");
		$server_type->name->AdvancedSearch->SearchValue2 = $server_type->getAdvancedSearch("y_name");
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
