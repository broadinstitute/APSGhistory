<?php

// Call Row_Rendering event
$users->Row_Rendering();

// uid
$users->uid->CellCssStyle = ""; $users->uid->CellCssClass = "";
$users->uid->CellAttrs = array(); $users->uid->ViewAttrs = array(); $users->uid->EditAttrs = array();

// username
$users->username->CellCssStyle = ""; $users->username->CellCssClass = "";
$users->username->CellAttrs = array(); $users->username->ViewAttrs = array(); $users->username->EditAttrs = array();

// gecos
$users->gecos->CellCssStyle = ""; $users->gecos->CellCssClass = "";
$users->gecos->CellAttrs = array(); $users->gecos->ViewAttrs = array(); $users->gecos->EditAttrs = array();

// role
$users->role->CellCssStyle = ""; $users->role->CellCssClass = "";
$users->role->CellAttrs = array(); $users->role->ViewAttrs = array(); $users->role->EditAttrs = array();

// gid
$users->gid->CellCssStyle = ""; $users->gid->CellCssClass = "";
$users->gid->CellAttrs = array(); $users->gid->ViewAttrs = array(); $users->gid->EditAttrs = array();

// cobj
$users->cobj->CellCssStyle = ""; $users->cobj->CellCssClass = "";
$users->cobj->CellAttrs = array(); $users->cobj->ViewAttrs = array(); $users->cobj->EditAttrs = array();

// Call Row_Rendered event
$users->Row_Rendered();
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $users->TableCaption() ?><br>
<a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterPage") ?></a></span></p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<thead>
		<tr>
			<td class="ewTableHeader"><?php echo $users->uid->FldCaption() ?></td>
			<td class="ewTableHeader"><?php echo $users->username->FldCaption() ?></td>
			<td class="ewTableHeader"><?php echo $users->gecos->FldCaption() ?></td>
			<td class="ewTableHeader"><?php echo $users->role->FldCaption() ?></td>
			<td class="ewTableHeader"><?php echo $users->gid->FldCaption() ?></td>
			<td class="ewTableHeader"><?php echo $users->cobj->FldCaption() ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td<?php echo $users->uid->CellAttributes() ?>>
<div<?php echo $users->uid->ViewAttributes() ?>><?php echo $users->uid->ListViewValue() ?></div></td>
			<td<?php echo $users->username->CellAttributes() ?>>
<div<?php echo $users->username->ViewAttributes() ?>><?php echo $users->username->ListViewValue() ?></div></td>
			<td<?php echo $users->gecos->CellAttributes() ?>>
<div<?php echo $users->gecos->ViewAttributes() ?>><?php echo $users->gecos->ListViewValue() ?></div></td>
			<td<?php echo $users->role->CellAttributes() ?>>
<div<?php echo $users->role->ViewAttributes() ?>><?php echo $users->role->ListViewValue() ?></div></td>
			<td<?php echo $users->gid->CellAttributes() ?>>
<div<?php echo $users->gid->ViewAttributes() ?>><?php echo $users->gid->ListViewValue() ?></div></td>
			<td<?php echo $users->cobj->CellAttributes() ?>>
<div<?php echo $users->cobj->ViewAttributes() ?>><?php echo $users->cobj->ListViewValue() ?></div></td>
		</tr>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
