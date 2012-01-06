<?php

// Global variable for table object
$filesystem = NULL;

//
// Table class for filesystem
//
class cfilesystem {
	var $TableVar = 'filesystem';
	var $TableName = 'filesystem';
	var $TableType = 'TABLE';
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
	var $maxdepth;
	var $fields = array();
	var $UseTokenInUrl = EW_USE_TOKEN_IN_URL;
	var $Export; // Export
	var $ExportOriginalValue = EW_EXPORT_ORIGINAL_VALUE;
	var $ExportAll = TRUE;
	var $SendEmail; // Send email
	var $TableCustomInnerHtml; // Custom inner HTML
	var $BasicSearchKeyword; // Basic search keyword
	var $BasicSearchType; // Basic search type
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type
	var $RowType; // Row type
	var $CssClass; // CSS class
	var $CssStyle; // CSS style
	var $RowAttrs = array(); // Row custom attributes
	var $TableFilter = "";
	var $CurrentAction; // Current action
	var $UpdateConflict; // Update conflict
	var $EventName; // Event name
	var $EventCancelled; // Event cancelled
	var $CancelMessage; // Cancel message

	//
	// Table class constructor
	//
	function cfilesystem() {
		global $Language;

		// id
		$this->id = new cField('filesystem', 'filesystem', 'x_id', 'id', '`id`', 3, -1, FALSE, '`id`', FALSE);
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] =& $this->id;

		// mount
		$this->mount = new cField('filesystem', 'filesystem', 'x_mount', 'mount', '`mount`', 200, -1, FALSE, '`mount`', FALSE);
		$this->fields['mount'] =& $this->mount;

		// path
		$this->path = new cField('filesystem', 'filesystem', 'x_path', 'path', '`path`', 200, -1, FALSE, '`path`', FALSE);
		$this->fields['path'] =& $this->path;

		// parent
		$this->parent = new cField('filesystem', 'filesystem', 'x_parent', 'parent', '`parent`', 19, -1, FALSE, '`parent`', FALSE);
		$this->parent->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['parent'] =& $this->parent;

		// deprecated
		$this->deprecated = new cField('filesystem', 'filesystem', 'x_deprecated', 'deprecated', '`deprecated`', 16, -1, FALSE, '`deprecated`', FALSE);
		$this->deprecated->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['deprecated'] =& $this->deprecated;

		// gid
		$this->gid = new cField('filesystem', 'filesystem', 'x_gid', 'gid', '`gid`', 19, -1, FALSE, '`gid`', FALSE);
		$this->gid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['gid'] =& $this->gid;

		// snapshot
		$this->snapshot = new cField('filesystem', 'filesystem', 'x_snapshot', 'snapshot', '`snapshot`', 16, -1, FALSE, '`snapshot`', FALSE);
		$this->snapshot->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['snapshot'] =& $this->snapshot;

		// tapebackup
		$this->tapebackup = new cField('filesystem', 'filesystem', 'x_tapebackup', 'tapebackup', '`tapebackup`', 16, -1, FALSE, '`tapebackup`', FALSE);
		$this->tapebackup->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tapebackup'] =& $this->tapebackup;

		// diskbackup
		$this->diskbackup = new cField('filesystem', 'filesystem', 'x_diskbackup', 'diskbackup', '`diskbackup`', 16, -1, FALSE, '`diskbackup`', FALSE);
		$this->diskbackup->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['diskbackup'] =& $this->diskbackup;

		// type
		$this->type = new cField('filesystem', 'filesystem', 'x_type', 'type', '`type`', 19, -1, FALSE, '`type`', FALSE);
		$this->type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['type'] =& $this->type;

		// contact
		$this->contact = new cField('filesystem', 'filesystem', 'x_contact', 'contact', '`contact`', 19, -1, FALSE, '`contact`', FALSE);
		$this->fields['contact'] =& $this->contact;

		// contact2
		$this->contact2 = new cField('filesystem', 'filesystem', 'x_contact2', 'contact2', '`contact2`', 3, -1, FALSE, '`contact2`', FALSE);
		$this->fields['contact2'] =& $this->contact2;

		// rescomp
		$this->rescomp = new cField('filesystem', 'filesystem', 'x_rescomp', 'rescomp', '`rescomp`', 3, -1, FALSE, '`rescomp`', FALSE);
		$this->fields['rescomp'] =& $this->rescomp;

		// maxdepth
		$this->maxdepth = new cField('filesystem', 'filesystem', 'x_maxdepth', 'maxdepth', '`maxdepth`', 2, -1, FALSE, '`maxdepth`', FALSE);
		$this->maxdepth->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['maxdepth'] =& $this->maxdepth;
	}

	// Table caption
	function TableCaption() {
		global $Language;
		return $Language->TablePhrase($this->TableVar, "TblCaption");
	}

	// Page caption
	function PageCaption($Page) {
		global $Language;
		$Caption = $Language->TablePhrase($this->TableVar, "TblPageCaption" . $Page);
		if ($Caption == "") $Caption = "Page " . $Page;
		return $Caption;
	}

	// Export return page
	function ExportReturnUrl() {
		$url = @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_EXPORT_RETURN_URL];
		return ($url <> "") ? $url : ew_CurrentPage();
	}

	function setExportReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_EXPORT_RETURN_URL] = $v;
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

	// Search highlight name
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

	// Basic search keyword
	function getSessionBasicSearchKeyword() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH];
	}

	function setSessionBasicSearchKeyword($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH] = $v;
	}

	// Basic search type
	function getSessionBasicSearchType() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE];
	}

	function setSessionBasicSearchType($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE] = $v;
	}

	// Search WHERE clause
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

	// Session WHERE clause
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

	// Session key
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

	// Session master WHERE clause
	function getMasterFilter() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_FILTER];
	}

	function setMasterFilter($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_FILTER] = $v;
	}

	// Session detail WHERE clause
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
	function SqlFrom() { // From
		return "`filesystem`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		if ($this->TableFilter <> "") {
			if ($sWhere <> "") $sWhere = "(" . $sWhere . ") AND (";
			$sWhere .= "(" . $this->TableFilter . ")";
		}
		return $sWhere;
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

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (EW_PAGE_ID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		if ($this->CurrentFilter <> "") {
			if ($sFilter <> "") $sFilter = "(" . $sFilter . ") AND ";
			$sFilter .= "(" . $this->CurrentFilter . ")";
		}
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($this->SelectSQL())) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		if (substr($names, -1) == ",") $names = substr($names, 0, strlen($names)-1);
		if (substr($values, -1) == ",") $values = substr($values, 0, strlen($values)-1);
		return "INSERT INTO `filesystem` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		global $conn;
		$SQL = "UPDATE `filesystem` SET ";
		foreach ($rs as $name => $value) {
			$SQL .= $this->fields[$name]->FldExpression . "=";
			$SQL .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		if (substr($SQL, -1) == ",") $SQL = substr($SQL, 0, strlen($SQL)-1);
		if ($this->CurrentFilter <> "")	$SQL .= " WHERE " . $this->CurrentFilter;
		return $SQL;
	}

	// DELETE statement
	function DeleteSQL(&$rs) {
		$SQL = "DELETE FROM `filesystem` WHERE ";
		$SQL .= ew_QuotedName('id') . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "filesystemlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function ListUrl() {
		return "filesystemlist.php";
	}

	// View URL
	function ViewUrl() {
		return $this->KeyUrl("filesystemview.php", $this->UrlParm());
	}

	// Add URL
	function AddUrl() {
		$AddUrl = "filesystemadd.php";
		$sUrlParm = $this->UrlParm();
		if ($sUrlParm <> "")
			$AddUrl .= "?" . $sUrlParm;
		return $AddUrl;
	}

	// Edit URL
	function EditUrl() {
		return $this->KeyUrl("filesystemedit.php", $this->UrlParm());
	}

	// Inline edit URL
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function CopyUrl() {
		return $this->KeyUrl("filesystemadd.php", $this->UrlParm());
	}

	// Inline copy URL
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function DeleteUrl() {
		return $this->KeyUrl("filesystemdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase(\"InvalidRecord\"));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Add URL parameter
	function UrlParm($parm = "") {
		$UrlParm = ($this->UseTokenInUrl) ? "t=filesystem" : "";
		if ($parm <> "") {
			if ($UrlParm <> "")
				$UrlParm .= "&";
			$UrlParm .= $parm;
		}
		return $UrlParm;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
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
		$this->maxdepth->setDbValue($rs->fields('maxdepth'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id

		$this->id->CellCssStyle = ""; $this->id->CellCssClass = "";
		$this->id->CellAttrs = array(); $this->id->ViewAttrs = array(); $this->id->EditAttrs = array();

		// mount
		$this->mount->CellCssStyle = ""; $this->mount->CellCssClass = "";
		$this->mount->CellAttrs = array(); $this->mount->ViewAttrs = array(); $this->mount->EditAttrs = array();

		// path
		$this->path->CellCssStyle = ""; $this->path->CellCssClass = "";
		$this->path->CellAttrs = array(); $this->path->ViewAttrs = array(); $this->path->EditAttrs = array();

		// parent
		$this->parent->CellCssStyle = ""; $this->parent->CellCssClass = "";
		$this->parent->CellAttrs = array(); $this->parent->ViewAttrs = array(); $this->parent->EditAttrs = array();

		// deprecated
		$this->deprecated->CellCssStyle = ""; $this->deprecated->CellCssClass = "";
		$this->deprecated->CellAttrs = array(); $this->deprecated->ViewAttrs = array(); $this->deprecated->EditAttrs = array();

		// gid
		$this->gid->CellCssStyle = ""; $this->gid->CellCssClass = "";
		$this->gid->CellAttrs = array(); $this->gid->ViewAttrs = array(); $this->gid->EditAttrs = array();

		// snapshot
		$this->snapshot->CellCssStyle = ""; $this->snapshot->CellCssClass = "";
		$this->snapshot->CellAttrs = array(); $this->snapshot->ViewAttrs = array(); $this->snapshot->EditAttrs = array();

		// tapebackup
		$this->tapebackup->CellCssStyle = ""; $this->tapebackup->CellCssClass = "";
		$this->tapebackup->CellAttrs = array(); $this->tapebackup->ViewAttrs = array(); $this->tapebackup->EditAttrs = array();

		// diskbackup
		$this->diskbackup->CellCssStyle = ""; $this->diskbackup->CellCssClass = "";
		$this->diskbackup->CellAttrs = array(); $this->diskbackup->ViewAttrs = array(); $this->diskbackup->EditAttrs = array();

		// type
		$this->type->CellCssStyle = ""; $this->type->CellCssClass = "";
		$this->type->CellAttrs = array(); $this->type->ViewAttrs = array(); $this->type->EditAttrs = array();

		// contact
		$this->contact->CellCssStyle = ""; $this->contact->CellCssClass = "";
		$this->contact->CellAttrs = array(); $this->contact->ViewAttrs = array(); $this->contact->EditAttrs = array();

		// contact2
		$this->contact2->CellCssStyle = ""; $this->contact2->CellCssClass = "";
		$this->contact2->CellAttrs = array(); $this->contact2->ViewAttrs = array(); $this->contact2->EditAttrs = array();

		// rescomp
		$this->rescomp->CellCssStyle = ""; $this->rescomp->CellCssClass = "";
		$this->rescomp->CellAttrs = array(); $this->rescomp->ViewAttrs = array(); $this->rescomp->EditAttrs = array();

		// maxdepth
		$this->maxdepth->CellCssStyle = ""; $this->maxdepth->CellCssClass = "";
		$this->maxdepth->CellAttrs = array(); $this->maxdepth->ViewAttrs = array(); $this->maxdepth->EditAttrs = array();

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
			$sFilterWrk = "`id` = " . ew_AdjustSql($this->gid->CurrentValue) . "";
		$sSqlWrk = "SELECT `id`, `name` FROM `grp`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
			$sWhereWrk .= "(" . $sFilterWrk . ")";
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			$sFilterWrk = "`id` = " . ew_AdjustSql($this->type->CurrentValue) . "";
		$sSqlWrk = "SELECT `id`, `name` FROM `server_type`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
			$sWhereWrk .= "(" . $sFilterWrk . ")";
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `id` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
			$sFilterWrk = "`uid` = " . ew_AdjustSql($this->contact->CurrentValue) . "";
		$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
			$sWhereWrk .= "(" . $sFilterWrk . ")";
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `uid` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
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
		if (strval($this->contact2->CurrentValue) <> "") {
			$sFilterWrk = "`uid` = " . ew_AdjustSql($this->contact2->CurrentValue) . "";
		$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
			$sWhereWrk .= "(" . $sFilterWrk . ")";
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `uid` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->contact2->ViewValue = $rswrk->fields('uid');
				$this->contact2->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
				$rswrk->Close();
			} else {
				$this->contact2->ViewValue = $this->contact2->CurrentValue;
			}
		} else {
			$this->contact2->ViewValue = NULL;
		}
		$this->contact2->CssStyle = "";
		$this->contact2->CssClass = "";
		$this->contact2->ViewCustomAttributes = "";

		// rescomp
		$this->rescomp->ViewValue = $this->rescomp->CurrentValue;
		if (strval($this->rescomp->CurrentValue) <> "") {
			$sFilterWrk = "`uid` = " . ew_AdjustSql($this->rescomp->CurrentValue) . "";
		$sSqlWrk = "SELECT `uid`, `gecos` FROM `users`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
			$sWhereWrk .= "(" . $sFilterWrk . ")";
		}
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `uid` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->rescomp->ViewValue = $rswrk->fields('uid');
				$this->rescomp->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('gecos');
				$rswrk->Close();
			} else {
				$this->rescomp->ViewValue = $this->rescomp->CurrentValue;
			}
		} else {
			$this->rescomp->ViewValue = NULL;
		}
		$this->rescomp->CssStyle = "";
		$this->rescomp->CssClass = "";
		$this->rescomp->ViewCustomAttributes = "";

		// maxdepth
		$this->maxdepth->ViewValue = $this->maxdepth->CurrentValue;
		$this->maxdepth->CssStyle = "";
		$this->maxdepth->CssClass = "";
		$this->maxdepth->ViewCustomAttributes = "";

		// id
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// mount
		$this->mount->HrefValue = "";
		$this->mount->TooltipValue = "";

		// path
		$this->path->HrefValue = "";
		$this->path->TooltipValue = "";

		// parent
		$this->parent->HrefValue = "";
		$this->parent->TooltipValue = "";

		// deprecated
		$this->deprecated->HrefValue = "";
		$this->deprecated->TooltipValue = "";

		// gid
		$this->gid->HrefValue = "";
		$this->gid->TooltipValue = "";

		// snapshot
		$this->snapshot->HrefValue = "";
		$this->snapshot->TooltipValue = "";

		// tapebackup
		$this->tapebackup->HrefValue = "";
		$this->tapebackup->TooltipValue = "";

		// diskbackup
		$this->diskbackup->HrefValue = "";
		$this->diskbackup->TooltipValue = "";

		// type
		$this->type->HrefValue = "";
		$this->type->TooltipValue = "";

		// contact
		$this->contact->HrefValue = "";
		$this->contact->TooltipValue = "";

		// contact2
		$this->contact2->HrefValue = "";
		$this->contact2->TooltipValue = "";

		// rescomp
		$this->rescomp->HrefValue = "";
		$this->rescomp->TooltipValue = "";

		// maxdepth
		$this->maxdepth->HrefValue = "";
		$this->maxdepth->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Row styles
	function RowStyles() {
		$sAtt = "";
		$sStyle = trim($this->CssStyle);
		if (@$this->RowAttrs["style"] <> "")
			$sStyle .= " " . $this->RowAttrs["style"];
		$sClass = trim($this->CssClass);
		if (@$this->RowAttrs["class"] <> "")
			$sClass .= " " . $this->RowAttrs["class"];
		if (trim($sStyle) <> "")
			$sAtt .= " style=\"" . trim($sStyle) . "\"";
		if (trim($sClass) <> "")
			$sAtt .= " class=\"" . trim($sClass) . "\"";
		return $sAtt;
	}

	// Row attributes
	function RowAttributes() {
		$sAtt = $this->RowStyles();
		if ($this->Export == "") {
			foreach ($this->RowAttrs as $k => $v) {
				if ($k <> "class" && $k <> "style" && trim($v) <> "")
					$sAtt .= " " . $k . "=\"" . trim($v) . "\"";
			}
		}
		return $sAtt;
	}

	// Field object by name
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

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

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

	// Row Update Conflict event
	function Row_UpdateConflict(&$rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
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
