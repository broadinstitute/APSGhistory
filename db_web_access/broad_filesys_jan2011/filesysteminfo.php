<?php

// PHPMaker 6 configuration for Table filesystem
$filesystem = NULL; // Initialize table object

// Define table class
class cfilesystem {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $id;
	var $mount;
	var $path;
	var $parent;
	var $deprecated;
	var $gid;
	var $snapshot;
	var $tapebackup;
	var $diskbackup;
	var $type;
	var $contact;
	var $contact2;
	var $rescomp;
	var $fields = array();
	var $UseTokenInUrl = EW_USE_TOKEN_IN_URL;
	var $Export; // Export
	var $ExportOriginalValue = EW_EXPORT_ORIGINAL_VALUE;
	var	$ExportAll = EW_EXPORT_ALL;
	var $SendEmail; // Send Email
	var $TableCustomInnerHtml; // Custom Inner Html

	function cfilesystem() {
		$this->TableVar = "filesystem";
		$this->TableName = "filesystem";
		$this->SelectLimit = TRUE;
		$this->id = new cField('filesystem', 'x_id', 'id', "`id`", 3, -1, FALSE);
		$this->fields['id'] =& $this->id;
		$this->mount = new cField('filesystem', 'x_mount', 'mount', "`mount`", 200, -1, FALSE);
		$this->fields['mount'] =& $this->mount;
		$this->path = new cField('filesystem', 'x_path', 'path', "`path`", 200, -1, FALSE);
		$this->fields['path'] =& $this->path;
		$this->parent = new cField('filesystem', 'x_parent', 'parent', "`parent`", 19, -1, FALSE);
		$this->fields['parent'] =& $this->parent;
		$this->deprecated = new cField('filesystem', 'x_deprecated', 'deprecated', "`deprecated`", 16, -1, FALSE);
		$this->fields['deprecated'] =& $this->deprecated;
		$this->gid = new cField('filesystem', 'x_gid', 'gid', "`gid`", 19, -1, FALSE);
		$this->fields['gid'] =& $this->gid;
		$this->snapshot = new cField('filesystem', 'x_snapshot', 'snapshot', "`snapshot`", 16, -1, FALSE);
		$this->fields['snapshot'] =& $this->snapshot;
		$this->tapebackup = new cField('filesystem', 'x_tapebackup', 'tapebackup', "`tapebackup`", 16, -1, FALSE);
		$this->fields['tapebackup'] =& $this->tapebackup;
		$this->diskbackup = new cField('filesystem', 'x_diskbackup', 'diskbackup', "`diskbackup`", 16, -1, FALSE);
		$this->fields['diskbackup'] =& $this->diskbackup;
		$this->type = new cField('filesystem', 'x_type', 'type', "`type`", 19, -1, FALSE);
		$this->fields['type'] =& $this->type;
		$this->contact = new cField('filesystem', 'x_contact', 'contact', "`contact`", 19, -1, FALSE);
		$this->fields['contact'] =& $this->contact;
		$this->contact2 = new cField('filesystem', 'x_contact2', 'contact2', "`contact2`", 3, -1, FALSE);
		$this->fields['contact2'] =& $this->contact2;
		$this->rescomp = new cField('filesystem', 'x_rescomp', 'rescomp', "`rescomp`", 3, -1, FALSE);
		$this->fields['rescomp'] =& $this->rescomp;
	}

	// Records per page
	function getRecordsPerPage() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE];
	}

	function setRecordsPerPage($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE] = $v;
	}

	// Start record number
	function getStartRecordNumber() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC];
	}

	function setStartRecordNumber($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC] = $v;
	}

	// Search Highlight Name
	function HighlightName() {
		return "filesystem_Highlight";
	}

	// Advanced search
	function getAdvancedSearch($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld];
	}

	function setAdvancedSearch($fld, $v) {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] <> $v) {
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] = $v;
		}
	}

	// Basic search Keyword
	function getBasicSearchKeyword() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH];
	}

	function setBasicSearchKeyword($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH] = $v;
	}

	// Basic Search Type
	function getBasicSearchType() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE];
	}

	function setBasicSearchType($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE] = $v;
	}

	// Search where clause
	function getSearchWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE];
	}

	function setSearchWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE] = $v;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session WHERE Clause
	function getSessionWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE];
	}

	function setSessionWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE] = $v;
	}

	// Session ORDER BY
	function getSessionOrderBy() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY];
	}

	function setSessionOrderBy($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY] = $v;
	}

	// Session Key
	function getKey($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld];
	}

	function setKey($fld, $v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld] = $v;
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master where clause
	function getMasterFilter() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_FILTER];
	}

	function setMasterFilter($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_FILTER] = $v;
	}

	// Session detail where clause
	function getDetailFilter() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_FILTER];
	}

	function setDetailFilter($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_FILTER] = $v;
	}

	// Master filter
	function SqlMasterFilter_grp() {
		return "`id`=@id@";
	}

	// Detail filter
	function SqlDetailFilter_grp() {
		return "`gid`=@gid@";
	}

	// Master filter
	function SqlMasterFilter_users() {
		return "`uid`=@uid@";
	}

	// Detail filter
	function SqlDetailFilter_users() {
		return "`contact`=@contact@";
	}

	// Master filter
	function SqlMasterFilter_server_type() {
		return "`id`=@id@";
	}

	// Detail filter
	function SqlDetailFilter_server_type() {
		return "`type`=@type@";
	}

	// Table level SQL
	function SqlSelect() { // Select
		return "SELECT * FROM `filesystem`";
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// SQL variables
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return table sql with list page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		if ($this->CurrentFilter <> "") {
			if ($sFilter <> "") $sFilter = "($sFilter) AND ";
			$sFilter .= "(" . $this->CurrentFilter . ")";
		}
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return record count
	function SelectRecordCount() {
		global $conn;
		$cnt = -1;
		$sFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		if ($this->SelectLimit) {
			$sSelect = $this->SelectSQL();
			if (strtoupper(substr($sSelect, 0, 13)) == "SELECT * FROM") {
				$sSelect = "SELECT COUNT(*) FROM" . substr($sSelect, 13);
				if ($rs = $conn->Execute($sSelect)) {
					if (!$rs->EOF)
						$cnt = $rs->fields[0];
					$rs->Close();
				}
			}
		}
		if ($cnt == -1) {
			if ($rs = $conn->Execute($this->SelectSQL())) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $sFilter;
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= (is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($names, -1) == ",") $names = substr($names, 0, strlen($names)-1);
		if (substr($values, -1) == ",") $values = substr($values, 0, strlen($values)-1);
		return "INSERT INTO `filesystem` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE `filesystem` SET ";
		foreach ($rs as $name => $value) {
			$SQL .= $this->fields[$name]->FldExpression . "=" .
					(is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($SQL, -1) == ",") $SQL = substr($SQL, 0, strlen($SQL)-1);
		if ($this->CurrentFilter <> "")	$SQL .= " WHERE " . $this->CurrentFilter;
		return $SQL;
	}

	// DELETE statement
	function DeleteSQL(&$rs) {
		$SQL = "DELETE FROM `filesystem` WHERE ";
		$SQL .= EW_DB_QUOTE_START . 'id' . EW_DB_QUOTE_END . '=' .	ew_QuotedValue($rs['id'], $this->id->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter for table
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Return Key filter for table
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return url
	function getReturnUrl() {

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "filesystemlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("filesystemview.php", $this->UrlParm());
	}

	// Add url
	function AddUrl() {
		$AddUrl = "filesystemadd.php";
		$sUrlParm = $this->UrlParm();
		if ($sUrlParm <> "")
			$AddUrl .= "?" . $sUrlParm;
		return $AddUrl;
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("filesystemedit.php", $this->UrlParm());
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("filesystemadd.php", $this->UrlParm());
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("filesystemdelete.php", $this->UrlParm());
	}

	// Key url
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:alert('Invalid Record! Key is null');";
		}
		return $sUrl;
	}

	// Sort Url
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			($fld->FldType == 205)) { // Unsortable data type
			return "";
		} else {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		}
	}

	// URL parm
	function UrlParm($parm = "") {
		$UrlParm = ($this->UseTokenInUrl) ? "t=filesystem" : "";
		if ($parm <> "") {
			if ($UrlParm <> "")
				$UrlParm .= "&";
			$UrlParm .= $parm;
		}
		return $UrlParm;
	}

	// Function LoadRs
	// - Load rows based on filter
	function LoadRs($sFilter) {
		global $conn;

		// Set up filter (Sql Where Clause) and get Return Sql
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		return $conn->Execute($sSql);
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->mount->setDbValue($rs->fields('mount'));
		$this->path->setDbValue($rs->fields('path'));
		$this->parent->setDbValue($rs->fields('parent'));
		$this->deprecated->setDbValue($rs->fields('deprecated'));
		$this->gid->setDbValue($rs->fields('gid'));
		$this->snapshot->setDbValue($rs->fields('snapshot'));
		$this->tapebackup->setDbValue($rs->fields('tapebackup'));
		$this->diskbackup->setDbValue($rs->fields('diskbackup'));
		$this->type->setDbValue($rs->fields('type'));
		$this->contact->setDbValue($rs->fields('contact'));
		$this->contact2->setDbValue($rs->fields('contact2'));
		$this->rescomp->setDbValue($rs->fields('rescomp'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->CssStyle = "";
		$this->id->CssClass = "";
		$this->id->ViewCustomAttributes = "";

		// mount
		$this->mount->ViewValue = $this->mount->CurrentValue;
		$this->mount->CssStyle = "";
		$this->mount->CssClass = "";
		$this->mount->ViewCustomAttributes = "";

		// path
		$this->path->ViewValue = $this->path->CurrentValue;
		$this->path->CssStyle = "";
		$this->path->CssClass = "";
		$this->path->ViewCustomAttributes = "";

		// parent
		$this->parent->ViewValue = $this->parent->CurrentValue;
		$this->parent->CssStyle = "";
		$this->parent->CssClass = "";
		$this->parent->ViewCustomAttributes = "";

		// deprecated
		$this->deprecated->ViewValue = $this->deprecated->CurrentValue;
		$this->deprecated->CssStyle = "";
		$this->deprecated->CssClass = "";
		$this->deprecated->ViewCustomAttributes = "";

		// gid
		if (strval($this->gid->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `id`, `name` FROM `grp` WHERE `id` = " . ew_AdjustSql($this->gid->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->gid->ViewValue = $rswrk->fields('id');
				$this->gid->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
				$rswrk->Close();
			} else {
				$this->gid->ViewValue = $this->gid->CurrentValue;
			}
		} else {
			$this->gid->ViewValue = NULL;
		}
		$this->gid->CssStyle = "";
		$this->gid->CssClass = "";
		$this->gid->ViewCustomAttributes = "";

		// snapshot
		$this->snapshot->ViewValue = $this->snapshot->CurrentValue;
		$this->snapshot->CssStyle = "";
		$this->snapshot->CssClass = "";
		$this->snapshot->ViewCustomAttributes = "";

		// tapebackup
		$this->tapebackup->ViewValue = $this->tapebackup->CurrentValue;
		$this->tapebackup->CssStyle = "";
		$this->tapebackup->CssClass = "";
		$this->tapebackup->ViewCustomAttributes = "";

		// diskbackup
		$this->diskbackup->ViewValue = $this->diskbackup->CurrentValue;
		$this->diskbackup->CssStyle = "";
		$this->diskbackup->CssClass = "";
		$this->diskbackup->ViewCustomAttributes = "";

		// type
		if (strval($this->type->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `id`, `name` FROM `server_type` WHERE `id` = " . ew_AdjustSql($this->type->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->type->ViewValue = $rswrk->fields('id');
				$this->type->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
				$rswrk->Close();
			} else {
				$this->type->ViewValue = $this->type->CurrentValue;
			}
		} else {
			$this->type->ViewValue = NULL;
		}
		$this->type->CssStyle = "";
		$this->type->CssClass = "";
		$this->type->ViewCustomAttributes = "";

		// contact
		$this->contact->ViewValue = $this->contact->CurrentValue;
		if (strval($this->contact->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `uid`, `gecos` FROM `users` WHERE `uid` = " . ew_AdjustSql($this->contact->CurrentValue) . "";
			$sSqlWrk .= " AND (" . "filesystem.gid = users.uid" . ")";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->contact->ViewValue = $rswrk->fields('uid');
				$this->contact->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
				$rswrk->Close();
			} else {
				$this->contact->ViewValue = $this->contact->CurrentValue;
			}
		} else {
			$this->contact->ViewValue = NULL;
		}
		$this->contact->CssStyle = "";
		$this->contact->CssClass = "";
		$this->contact->ViewCustomAttributes = "";

		// contact2
		$this->contact2->ViewValue = $this->contact2->CurrentValue;
		$this->contact2->CssStyle = "";
		$this->contact2->CssClass = "";
		$this->contact2->ViewCustomAttributes = "";

		// rescomp
		$this->rescomp->ViewValue = $this->rescomp->CurrentValue;
		$this->rescomp->CssStyle = "";
		$this->rescomp->CssClass = "";
		$this->rescomp->ViewCustomAttributes = "";

		// id
		$this->id->HrefValue = "";

		// mount
		$this->mount->HrefValue = "";

		// path
		$this->path->HrefValue = "";

		// parent
		$this->parent->HrefValue = "";

		// deprecated
		$this->deprecated->HrefValue = "";

		// gid
		$this->gid->HrefValue = "";

		// snapshot
		$this->snapshot->HrefValue = "";

		// tapebackup
		$this->tapebackup->HrefValue = "";

		// diskbackup
		$this->diskbackup->HrefValue = "";

		// type
		$this->type->HrefValue = "";

		// contact
		$this->contact->HrefValue = "";

		// contact2
		$this->contact2->HrefValue = "";

		// rescomp
		$this->rescomp->HrefValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $CurrentAction; // Current action
	var $EventName; // Event name
	var $EventCancelled; // Event cancelled
	var $CancelMessage; // Cancel message
	var $RowType; // Row Type
	var $CssClass; // Css class
	var $CssStyle; // Css style
	var $RowClientEvents; // Row client events

	// Row Attribute
	function RowAttributes() {
		$sAtt = "";
		if (trim($this->CssStyle) <> "") {
			$sAtt .= " style=\"" . trim($this->CssStyle) . "\"";
		}
		if (trim($this->CssClass) <> "") {
			$sAtt .= " class=\"" . trim($this->CssClass) . "\"";
		}
		if ($this->Export == "") {
			if (trim($this->RowClientEvents) <> "") {
				$sAtt .= " " . trim($this->RowClientEvents);
			}
		}
		return $sAtt;
	}

	// Field objects
	function fields($fldname) {
		return $this->fields[$fldname];
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Row Inserting event
	function Row_Inserting(&$rs) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted(&$rs) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating(&$rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated(&$rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}
}
?>
