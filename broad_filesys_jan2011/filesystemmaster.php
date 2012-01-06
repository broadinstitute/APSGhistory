<?php

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
?>
<p><span class="phpmaker">Master Record: Filesystem<br>
<a href="<?php echo $gsMasterReturnUrl ?>">Back to master page</a></span></p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<thead>
		<tr>
			<td class="ewTableHeader">Id</td>
			<td class="ewTableHeader">Mount</td>
			<td class="ewTableHeader">Path</td>
			<td class="ewTableHeader">Parent</td>
			<td class="ewTableHeader">Deprecated</td>
			<td class="ewTableHeader">Gid</td>
			<td class="ewTableHeader">Snapshot</td>
			<td class="ewTableHeader">Tapebackup</td>
			<td class="ewTableHeader">Diskbackup</td>
			<td class="ewTableHeader">Type</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td<?php echo $filesystem->id->CellAttributes() ?>>
<div<?php echo $filesystem->id->ViewAttributes() ?>><?php echo $filesystem->id->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->mount->CellAttributes() ?>>
<div<?php echo $filesystem->mount->ViewAttributes() ?>><?php echo $filesystem->mount->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->path->CellAttributes() ?>>
<div<?php echo $filesystem->path->ViewAttributes() ?>><?php echo $filesystem->path->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->parent->CellAttributes() ?>>
<div<?php echo $filesystem->parent->ViewAttributes() ?>><?php echo $filesystem->parent->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->deprecated->CellAttributes() ?>>
<div<?php echo $filesystem->deprecated->ViewAttributes() ?>><?php echo $filesystem->deprecated->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->gid->CellAttributes() ?>>
<div<?php echo $filesystem->gid->ViewAttributes() ?>><?php echo $filesystem->gid->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->snapshot->CellAttributes() ?>>
<div<?php echo $filesystem->snapshot->ViewAttributes() ?>><?php echo $filesystem->snapshot->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->tapebackup->CellAttributes() ?>>
<div<?php echo $filesystem->tapebackup->ViewAttributes() ?>><?php echo $filesystem->tapebackup->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->diskbackup->CellAttributes() ?>>
<div<?php echo $filesystem->diskbackup->ViewAttributes() ?>><?php echo $filesystem->diskbackup->ListViewValue() ?></div></td>
			<td<?php echo $filesystem->type->CellAttributes() ?>>
<div<?php echo $filesystem->type->ViewAttributes() ?>><?php echo $filesystem->type->ListViewValue() ?></div></td>
		</tr>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
