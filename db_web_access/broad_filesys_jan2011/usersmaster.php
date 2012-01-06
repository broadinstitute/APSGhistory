<?php

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
?>
<p><span class="phpmaker">Master Record: Users<br>
<a href="<?php echo $gsMasterReturnUrl ?>">Back to master page</a></span></p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<thead>
		<tr>
			<td class="ewTableHeader">Uid</td>
			<td class="ewTableHeader">Username</td>
			<td class="ewTableHeader">Gecos</td>
			<td class="ewTableHeader">Role</td>
			<td class="ewTableHeader">Gid</td>
			<td class="ewTableHeader">Cobj</td>
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
