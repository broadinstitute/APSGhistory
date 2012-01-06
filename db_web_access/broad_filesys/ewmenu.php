<?php

// Menu
define("EW_MENUBAR_CLASSNAME", "ewMenuBarVertical", TRUE);
define("EW_MENUBAR_SUBMENU_CLASSNAME", "", TRUE);
?>
<?php

// MenuItem Adding event
function MenuItem_Adding(&$Item) {

	//var_dump($Item);
	// Return FALSE if menu item not allowed

	return TRUE;
}
?>
<!-- Begin Main Menu -->
<div class="phpmaker">
<?php

// Generate all menu items
$RootMenu = new cMenu("RootMenu");
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(4, $Language->MenuPhrase("4", "MenuText"), "filesystemlist.php?cmd=resetall", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(7, $Language->MenuPhrase("7", "MenuText"), "grplist.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(12, $Language->MenuPhrase("12", "MenuText"), "server_typelist.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(15, $Language->MenuPhrase("15", "MenuText"), "userslist.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(16, $Language->MenuPhrase("16", "MenuText"), "rescomp_fs_viewlist.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(17, $Language->MenuPhrase("17", "MenuText"), "fs_multijoin_vlist.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
