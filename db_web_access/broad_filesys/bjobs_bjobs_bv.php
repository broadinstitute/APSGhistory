<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "bjobsinfo.php" ?>
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
$bjobs_bjobs_blobview = new cbjobs_bjobs_blobview();
$Page =& $bjobs_bjobs_blobview;

// Page init processing
$bjobs_bjobs_blobview->Page_Init();

// Page main processing
$bjobs_bjobs_blobview->Page_Main();
?>
<?php
$bjobs_bjobs_blobview->Page_Terminate();
?>
<?php

//
// Page Class
//
class cbjobs_bjobs_blobview {

	// Page ID
	var $PageID = 'blobview';

	// Page Object Name
	var $PageObjName = 'bjobs_bjobs_blobview';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
		return TRUE;
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cbjobs_bjobs_blobview() {
		global $conn;

		// Initialize table object
		$GLOBALS["bjobs"] = new cbjobs();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'blobview', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'bjobs', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $bjobs;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

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
		global $conn, $bjobs;

		// Get key
		if (@$_GET["checked"] <> "") {
			$bjobs->checked->setQueryStringValue($_GET["checked"]);
		} else {
			$this->Page_Terminate(); // Exit
			exit();
		}
		$objBinary = new cUpload('bjobs', 'x_bjobs');

		// Show thumbnail
		$bShowThumbnail = (@$_GET["showthumbnail"] == "1");
		if (@$_GET["thumbnailwidth"] == "" && @$_GET["thumbnailheight"] == "") {
			$iThumbnailWidth = EW_THUMBNAIL_DEFAULT_WIDTH; // Set default width
			$iThumbnailHeight = EW_THUMBNAIL_DEFAULT_HEIGHT; // Set default height
		} else {
			if (@$_GET["thumbnailwidth"] <> "") {
				$iThumbnailWidth = $_GET["thumbnailwidth"];
				if (!is_numeric($iThumbnailWidth) || $iThumbnailWidth < 0) $iThumbnailWidth = 0;
			}
			if (@$_GET["thumbnailheight"] <> "") {
				$iThumbnailHeight = $_GET["thumbnailheight"];
				if (!is_numeric($iThumbnailHeight) || $iThumbnailHeight < 0) $iThumbnailHeight = 0;
			}
		}
		if (@$_GET["quality"] <> "") {
			$quality = $_GET["quality"];
			if (!is_numeric($quality)) $quality = 75; // Set Default
		} else {
			$quality = 75;
		}
		$sFilter = $bjobs->KeyFilter();

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in bjobs class, bjobsinfo.php

		$bjobs->CurrentFilter = $sFilter;
		$sSql = $bjobs->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF) {
				if (strpos(ew_ServerVar("HTTP_USER_AGENT"), "MSIE") === FALSE)
					header("Content-type: images");
				$objBinary->Value = $rs->fields('bjobs');
				if ($bShowThumbnail) {
					ew_ResizeBinary($objBinary->Value, $iThumbnailWidth, $iThumbnailHeight, $quality);
				}
				$data = $objBinary->Value;
				if (substr($data, 0, 2) == "PK" && strpos($data, "[Content_Types].xml") > 0 &&
					strpos($data, "_rels") > 0 && strpos($data, "docProps") > 0) { // Fix Office 2007 documents
					if (substr($data, -4) <> "\0\0\0\0")
						$data .= "\0\0\0\0";
				}
				echo $data;
			}
			$rs->Close();
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}
}
?>
