<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "filesysteminfo.php" ?>
<?php include "grpinfo.php" ?>
<?php include "server_typeinfo.php" ?>
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
$filesystem_search = new cfilesystem_search();
$Page =& $filesystem_search;

// Page init processing
$filesystem_search->Page_Init();

// Page main processing
$filesystem_search->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var filesystem_search = new ew_Page("filesystem_search");

// page properties
filesystem_search.PageID = "search"; // page ID
var EW_PAGE_ID = filesystem_search.PageID; // for backward compatibility

// extend page with validate function for search
filesystem_search.ValidateSearch = function(fobj) {
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
	elm = fobj.elements["x" + infix + "_contact"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Contact");
	elm = fobj.elements["x" + infix + "_contact2"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Contact 2");
	elm = fobj.elements["x" + infix + "_rescomp"];
	if (elm && !ew_CheckInteger(elm.value))
		return ew_OnError(this, elm, "Incorrect integer - Rescomp");

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
filesystem_search.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
filesystem_search.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
filesystem_search.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Search TABLE: Filesystem<br><br>
<a href="<?php echo $filesystem->getReturnUrl() ?>">Back to List</a></span></p>
<?php $filesystem_search->ShowMessage() ?>
<form name="ffilesystemsearch" id="ffilesystemsearch" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return filesystem_search.ValidateSearch(this);">
<p>
<input type="hidden" name="t" id="t" value="filesystem">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
	<tr<?php echo $filesystem->id->RowAttributes ?>>
		<td class="ewTableHeader">Id</td>
		<td<?php echo $filesystem->id->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_id" id="z_id" value="="></span></td>
		<td<?php echo $filesystem->id->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_id" id="x_id" size="30" value="<?php echo $filesystem->id->EditValue ?>"<?php echo $filesystem->id->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->mount->RowAttributes ?>>
		<td class="ewTableHeader">Mount</td>
		<td<?php echo $filesystem->mount->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_mount" id="z_mount" value="LIKE"></span></td>
		<td<?php echo $filesystem->mount->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_mount" id="x_mount" size="30" maxlength="100" value="<?php echo $filesystem->mount->EditValue ?>"<?php echo $filesystem->mount->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->path->RowAttributes ?>>
		<td class="ewTableHeader">Path</td>
		<td<?php echo $filesystem->path->CellAttributes() ?>><span class="ewSearchOpr">contains<input type="hidden" name="z_path" id="z_path" value="LIKE"></span></td>
		<td<?php echo $filesystem->path->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_path" id="x_path" size="30" maxlength="100" value="<?php echo $filesystem->path->EditValue ?>"<?php echo $filesystem->path->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->parent->RowAttributes ?>>
		<td class="ewTableHeader">Parent</td>
		<td<?php echo $filesystem->parent->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_parent" id="z_parent" value="="></span></td>
		<td<?php echo $filesystem->parent->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_parent" id="x_parent" size="30" value="<?php echo $filesystem->parent->EditValue ?>"<?php echo $filesystem->parent->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->deprecated->RowAttributes ?>>
		<td class="ewTableHeader">Deprecated</td>
		<td<?php echo $filesystem->deprecated->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_deprecated" id="z_deprecated" value="="></span></td>
		<td<?php echo $filesystem->deprecated->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_deprecated" id="x_deprecated" size="30" value="<?php echo $filesystem->deprecated->EditValue ?>"<?php echo $filesystem->deprecated->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->gid->RowAttributes ?>>
		<td class="ewTableHeader">Gid</td>
		<td<?php echo $filesystem->gid->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_gid" id="z_gid" value="="></span></td>
		<td<?php echo $filesystem->gid->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_gid" id="x_gid" size="30" value="<?php echo $filesystem->gid->EditValue ?>"<?php echo $filesystem->gid->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->snapshot->RowAttributes ?>>
		<td class="ewTableHeader">Snapshot</td>
		<td<?php echo $filesystem->snapshot->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_snapshot" id="z_snapshot" value="="></span></td>
		<td<?php echo $filesystem->snapshot->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_snapshot" id="x_snapshot" size="30" value="<?php echo $filesystem->snapshot->EditValue ?>"<?php echo $filesystem->snapshot->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->tapebackup->RowAttributes ?>>
		<td class="ewTableHeader">Tapebackup</td>
		<td<?php echo $filesystem->tapebackup->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_tapebackup" id="z_tapebackup" value="="></span></td>
		<td<?php echo $filesystem->tapebackup->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_tapebackup" id="x_tapebackup" size="30" value="<?php echo $filesystem->tapebackup->EditValue ?>"<?php echo $filesystem->tapebackup->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->diskbackup->RowAttributes ?>>
		<td class="ewTableHeader">Diskbackup</td>
		<td<?php echo $filesystem->diskbackup->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_diskbackup" id="z_diskbackup" value="="></span></td>
		<td<?php echo $filesystem->diskbackup->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_diskbackup" id="x_diskbackup" size="30" value="<?php echo $filesystem->diskbackup->EditValue ?>"<?php echo $filesystem->diskbackup->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->type->RowAttributes ?>>
		<td class="ewTableHeader">Type</td>
		<td<?php echo $filesystem->type->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_type" id="z_type" value="="></span></td>
		<td<?php echo $filesystem->type->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_type" id="x_type" size="30" value="<?php echo $filesystem->type->EditValue ?>"<?php echo $filesystem->type->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->contact->RowAttributes ?>>
		<td class="ewTableHeader">Contact</td>
		<td<?php echo $filesystem->contact->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_contact" id="z_contact" value="="></span></td>
		<td<?php echo $filesystem->contact->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_contact" id="x_contact" size="30" value="<?php echo $filesystem->contact->EditValue ?>"<?php echo $filesystem->contact->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->contact2->RowAttributes ?>>
		<td class="ewTableHeader">Contact 2</td>
		<td<?php echo $filesystem->contact2->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_contact2" id="z_contact2" value="="></span></td>
		<td<?php echo $filesystem->contact2->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_contact2" id="x_contact2" size="30" value="<?php echo $filesystem->contact2->EditValue ?>"<?php echo $filesystem->contact2->EditAttributes() ?>>
</span></td>
			</tr></table>
		</td>
	</tr>
	<tr<?php echo $filesystem->rescomp->RowAttributes ?>>
		<td class="ewTableHeader">Rescomp</td>
		<td<?php echo $filesystem->rescomp->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_rescomp" id="z_rescomp" value="="></span></td>
		<td<?php echo $filesystem->rescomp->CellAttributes() ?>>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpmaker">
<input type="text" name="x_rescomp" id="x_rescomp" size="30" value="<?php echo $filesystem->rescomp->EditValue ?>"<?php echo $filesystem->rescomp->EditAttributes() ?>>
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
$filesystem_search->Page_Terminate();
?>
<?php

//
// Page Class
//
class cfilesystem_search {

	// Page ID
	var $PageID = 'search';

	// Table Name
	var $TableName = 'filesystem';

	// Page Object Name
	var $PageObjName = 'filesystem_search';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $filesystem;
		if ($filesystem->UseTokenInUrl) $PageUrl .= "t=" . $filesystem->TableVar . "&"; // add page token
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
		global $objForm, $filesystem;
		if ($filesystem->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($filesystem->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($filesystem->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cfilesystem_search() {
		global $conn;

		// Initialize table object
		$GLOBALS["filesystem"] = new cfilesystem();

		// Initialize other table object
		$GLOBALS['grp'] = new cgrp();

		// Initialize other table object
		$GLOBALS['server_type'] = new cserver_type();

		// Initialize other table object
		$GLOBALS['users'] = new cusers();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'filesystem', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $filesystem;

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
		global $objForm, $gsSearchError, $filesystem;
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$filesystem->CurrentAction = $objForm->GetValue("a_search");
			switch ($filesystem->CurrentAction) {
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
						$sSrchStr = $filesystem->UrlParm($sSrchStr);
						$this->Page_Terminate("filesystemlist.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$filesystem->RowType = EW_ROWTYPE_SEARCH;
		$this->RenderRow();
	}

// Build advanced search
function BuildAdvancedSearch() {
	global $filesystem;
	$sSrchUrl = "";
	$this->BuildSearchUrl($sSrchUrl, $filesystem->id); // id
	$this->BuildSearchUrl($sSrchUrl, $filesystem->mount); // mount
	$this->BuildSearchUrl($sSrchUrl, $filesystem->path); // path
	$this->BuildSearchUrl($sSrchUrl, $filesystem->parent); // parent
	$this->BuildSearchUrl($sSrchUrl, $filesystem->deprecated); // deprecated
	$this->BuildSearchUrl($sSrchUrl, $filesystem->gid); // gid
	$this->BuildSearchUrl($sSrchUrl, $filesystem->snapshot); // snapshot
	$this->BuildSearchUrl($sSrchUrl, $filesystem->tapebackup); // tapebackup
	$this->BuildSearchUrl($sSrchUrl, $filesystem->diskbackup); // diskbackup
	$this->BuildSearchUrl($sSrchUrl, $filesystem->type); // type
	$this->BuildSearchUrl($sSrchUrl, $filesystem->contact); // contact
	$this->BuildSearchUrl($sSrchUrl, $filesystem->contact2); // contact2
	$this->BuildSearchUrl($sSrchUrl, $filesystem->rescomp); // rescomp
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
		global $objForm, $filesystem;

		// Load search values
		// id

		$filesystem->id->AdvancedSearch->SearchValue = $objForm->GetValue("x_id");
		$filesystem->id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_id");

		// mount
		$filesystem->mount->AdvancedSearch->SearchValue = $objForm->GetValue("x_mount");
		$filesystem->mount->AdvancedSearch->SearchOperator = $objForm->GetValue("z_mount");

		// path
		$filesystem->path->AdvancedSearch->SearchValue = $objForm->GetValue("x_path");
		$filesystem->path->AdvancedSearch->SearchOperator = $objForm->GetValue("z_path");

		// parent
		$filesystem->parent->AdvancedSearch->SearchValue = $objForm->GetValue("x_parent");
		$filesystem->parent->AdvancedSearch->SearchOperator = $objForm->GetValue("z_parent");

		// deprecated
		$filesystem->deprecated->AdvancedSearch->SearchValue = $objForm->GetValue("x_deprecated");
		$filesystem->deprecated->AdvancedSearch->SearchOperator = $objForm->GetValue("z_deprecated");

		// gid
		$filesystem->gid->AdvancedSearch->SearchValue = $objForm->GetValue("x_gid");
		$filesystem->gid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_gid");

		// snapshot
		$filesystem->snapshot->AdvancedSearch->SearchValue = $objForm->GetValue("x_snapshot");
		$filesystem->snapshot->AdvancedSearch->SearchOperator = $objForm->GetValue("z_snapshot");

		// tapebackup
		$filesystem->tapebackup->AdvancedSearch->SearchValue = $objForm->GetValue("x_tapebackup");
		$filesystem->tapebackup->AdvancedSearch->SearchOperator = $objForm->GetValue("z_tapebackup");

		// diskbackup
		$filesystem->diskbackup->AdvancedSearch->SearchValue = $objForm->GetValue("x_diskbackup");
		$filesystem->diskbackup->AdvancedSearch->SearchOperator = $objForm->GetValue("z_diskbackup");

		// type
		$filesystem->type->AdvancedSearch->SearchValue = $objForm->GetValue("x_type");
		$filesystem->type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_type");

		// contact
		$filesystem->contact->AdvancedSearch->SearchValue = $objForm->GetValue("x_contact");
		$filesystem->contact->AdvancedSearch->SearchOperator = $objForm->GetValue("z_contact");

		// contact2
		$filesystem->contact2->AdvancedSearch->SearchValue = $objForm->GetValue("x_contact2");
		$filesystem->contact2->AdvancedSearch->SearchOperator = $objForm->GetValue("z_contact2");

		// rescomp
		$filesystem->rescomp->AdvancedSearch->SearchValue = $objForm->GetValue("x_rescomp");
		$filesystem->rescomp->AdvancedSearch->SearchOperator = $objForm->GetValue("z_rescomp");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $filesystem;

		// Call Row_Rendering event
		$filesystem->Row_Rendering();

		// Common render codes for all row types
		// id

		$filesystem->id->CellCssStyle = "";
		$filesystem->id->CellCssClass = "";

		// mount
		$filesystem->mount->CellCssStyle = "";
		$filesystem->mount->CellCssClass = "";

		// path
		$filesystem->path->CellCssStyle = "";
		$filesystem->path->CellCssClass = "";

		// parent
		$filesystem->parent->CellCssStyle = "";
		$filesystem->parent->CellCssClass = "";

		// deprecated
		$filesystem->deprecated->CellCssStyle = "";
		$filesystem->deprecated->CellCssClass = "";

		// gid
		$filesystem->gid->CellCssStyle = "";
		$filesystem->gid->CellCssClass = "";

		// snapshot
		$filesystem->snapshot->CellCssStyle = "";
		$filesystem->snapshot->CellCssClass = "";

		// tapebackup
		$filesystem->tapebackup->CellCssStyle = "";
		$filesystem->tapebackup->CellCssClass = "";

		// diskbackup
		$filesystem->diskbackup->CellCssStyle = "";
		$filesystem->diskbackup->CellCssClass = "";

		// type
		$filesystem->type->CellCssStyle = "";
		$filesystem->type->CellCssClass = "";

		// contact
		$filesystem->contact->CellCssStyle = "";
		$filesystem->contact->CellCssClass = "";

		// contact2
		$filesystem->contact2->CellCssStyle = "";
		$filesystem->contact2->CellCssClass = "";

		// rescomp
		$filesystem->rescomp->CellCssStyle = "";
		$filesystem->rescomp->CellCssClass = "";
		if ($filesystem->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$filesystem->id->ViewValue = $filesystem->id->CurrentValue;
			$filesystem->id->CssStyle = "";
			$filesystem->id->CssClass = "";
			$filesystem->id->ViewCustomAttributes = "";

			// mount
			$filesystem->mount->ViewValue = $filesystem->mount->CurrentValue;
			$filesystem->mount->CssStyle = "";
			$filesystem->mount->CssClass = "";
			$filesystem->mount->ViewCustomAttributes = "";

			// path
			$filesystem->path->ViewValue = $filesystem->path->CurrentValue;
			$filesystem->path->CssStyle = "";
			$filesystem->path->CssClass = "";
			$filesystem->path->ViewCustomAttributes = "";

			// parent
			$filesystem->parent->ViewValue = $filesystem->parent->CurrentValue;
			$filesystem->parent->CssStyle = "";
			$filesystem->parent->CssClass = "";
			$filesystem->parent->ViewCustomAttributes = "";

			// deprecated
			$filesystem->deprecated->ViewValue = $filesystem->deprecated->CurrentValue;
			$filesystem->deprecated->CssStyle = "";
			$filesystem->deprecated->CssClass = "";
			$filesystem->deprecated->ViewCustomAttributes = "";

			// gid
			$filesystem->gid->ViewValue = $filesystem->gid->CurrentValue;
			$filesystem->gid->CssStyle = "";
			$filesystem->gid->CssClass = "";
			$filesystem->gid->ViewCustomAttributes = "";

			// snapshot
			$filesystem->snapshot->ViewValue = $filesystem->snapshot->CurrentValue;
			$filesystem->snapshot->CssStyle = "";
			$filesystem->snapshot->CssClass = "";
			$filesystem->snapshot->ViewCustomAttributes = "";

			// tapebackup
			$filesystem->tapebackup->ViewValue = $filesystem->tapebackup->CurrentValue;
			$filesystem->tapebackup->CssStyle = "";
			$filesystem->tapebackup->CssClass = "";
			$filesystem->tapebackup->ViewCustomAttributes = "";

			// diskbackup
			$filesystem->diskbackup->ViewValue = $filesystem->diskbackup->CurrentValue;
			$filesystem->diskbackup->CssStyle = "";
			$filesystem->diskbackup->CssClass = "";
			$filesystem->diskbackup->ViewCustomAttributes = "";

			// type
			$filesystem->type->ViewValue = $filesystem->type->CurrentValue;
			$filesystem->type->CssStyle = "";
			$filesystem->type->CssClass = "";
			$filesystem->type->ViewCustomAttributes = "";

			// contact
			$filesystem->contact->ViewValue = $filesystem->contact->CurrentValue;
			$filesystem->contact->CssStyle = "";
			$filesystem->contact->CssClass = "";
			$filesystem->contact->ViewCustomAttributes = "";

			// contact2
			$filesystem->contact2->ViewValue = $filesystem->contact2->CurrentValue;
			$filesystem->contact2->CssStyle = "";
			$filesystem->contact2->CssClass = "";
			$filesystem->contact2->ViewCustomAttributes = "";

			// rescomp
			$filesystem->rescomp->ViewValue = $filesystem->rescomp->CurrentValue;
			$filesystem->rescomp->CssStyle = "";
			$filesystem->rescomp->CssClass = "";
			$filesystem->rescomp->ViewCustomAttributes = "";

			// id
			$filesystem->id->HrefValue = "";

			// mount
			$filesystem->mount->HrefValue = "";

			// path
			$filesystem->path->HrefValue = "";

			// parent
			$filesystem->parent->HrefValue = "";

			// deprecated
			$filesystem->deprecated->HrefValue = "";

			// gid
			$filesystem->gid->HrefValue = "";

			// snapshot
			$filesystem->snapshot->HrefValue = "";

			// tapebackup
			$filesystem->tapebackup->HrefValue = "";

			// diskbackup
			$filesystem->diskbackup->HrefValue = "";

			// type
			$filesystem->type->HrefValue = "";

			// contact
			$filesystem->contact->HrefValue = "";

			// contact2
			$filesystem->contact2->HrefValue = "";

			// rescomp
			$filesystem->rescomp->HrefValue = "";
		} elseif ($filesystem->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$filesystem->id->EditCustomAttributes = "";
			$filesystem->id->EditValue = ew_HtmlEncode($filesystem->id->AdvancedSearch->SearchValue);

			// mount
			$filesystem->mount->EditCustomAttributes = "";
			$filesystem->mount->EditValue = ew_HtmlEncode($filesystem->mount->AdvancedSearch->SearchValue);

			// path
			$filesystem->path->EditCustomAttributes = "";
			$filesystem->path->EditValue = ew_HtmlEncode($filesystem->path->AdvancedSearch->SearchValue);

			// parent
			$filesystem->parent->EditCustomAttributes = "";
			$filesystem->parent->EditValue = ew_HtmlEncode($filesystem->parent->AdvancedSearch->SearchValue);

			// deprecated
			$filesystem->deprecated->EditCustomAttributes = "";
			$filesystem->deprecated->EditValue = ew_HtmlEncode($filesystem->deprecated->AdvancedSearch->SearchValue);

			// gid
			$filesystem->gid->EditCustomAttributes = "";
			$filesystem->gid->EditValue = ew_HtmlEncode($filesystem->gid->AdvancedSearch->SearchValue);

			// snapshot
			$filesystem->snapshot->EditCustomAttributes = "";
			$filesystem->snapshot->EditValue = ew_HtmlEncode($filesystem->snapshot->AdvancedSearch->SearchValue);

			// tapebackup
			$filesystem->tapebackup->EditCustomAttributes = "";
			$filesystem->tapebackup->EditValue = ew_HtmlEncode($filesystem->tapebackup->AdvancedSearch->SearchValue);

			// diskbackup
			$filesystem->diskbackup->EditCustomAttributes = "";
			$filesystem->diskbackup->EditValue = ew_HtmlEncode($filesystem->diskbackup->AdvancedSearch->SearchValue);

			// type
			$filesystem->type->EditCustomAttributes = "";
			$filesystem->type->EditValue = ew_HtmlEncode($filesystem->type->AdvancedSearch->SearchValue);

			// contact
			$filesystem->contact->EditCustomAttributes = "";
			$filesystem->contact->EditValue = ew_HtmlEncode($filesystem->contact->AdvancedSearch->SearchValue);

			// contact2
			$filesystem->contact2->EditCustomAttributes = "";
			$filesystem->contact2->EditValue = ew_HtmlEncode($filesystem->contact2->AdvancedSearch->SearchValue);

			// rescomp
			$filesystem->rescomp->EditCustomAttributes = "";
			$filesystem->rescomp->EditValue = ew_HtmlEncode($filesystem->rescomp->AdvancedSearch->SearchValue);
		}

		// Call Row Rendered event
		$filesystem->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError, $filesystem;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($filesystem->id->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Id";
		}
		if (!ew_CheckInteger($filesystem->parent->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Parent";
		}
		if (!ew_CheckInteger($filesystem->deprecated->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Deprecated";
		}
		if (!ew_CheckInteger($filesystem->gid->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Gid";
		}
		if (!ew_CheckInteger($filesystem->snapshot->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Snapshot";
		}
		if (!ew_CheckInteger($filesystem->tapebackup->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Tapebackup";
		}
		if (!ew_CheckInteger($filesystem->diskbackup->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Diskbackup";
		}
		if (!ew_CheckInteger($filesystem->type->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Type";
		}
		if (!ew_CheckInteger($filesystem->contact->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Contact";
		}
		if (!ew_CheckInteger($filesystem->contact2->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Contact 2";
		}
		if (!ew_CheckInteger($filesystem->rescomp->AdvancedSearch->SearchValue)) {
			if ($gsSearchError <> "") $gsSearchError .= "<br>";
			$gsSearchError .= "Incorrect integer - Rescomp";
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
		global $filesystem;
		$filesystem->id->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_id");
		$filesystem->mount->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_mount");
		$filesystem->path->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_path");
		$filesystem->parent->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_parent");
		$filesystem->deprecated->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_deprecated");
		$filesystem->gid->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_gid");
		$filesystem->snapshot->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_snapshot");
		$filesystem->tapebackup->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_tapebackup");
		$filesystem->diskbackup->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_diskbackup");
		$filesystem->type->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_type");
		$filesystem->contact->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_contact");
		$filesystem->contact2->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_contact2");
		$filesystem->rescomp->AdvancedSearch->SearchValue = $filesystem->getAdvancedSearch("x_rescomp");
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
