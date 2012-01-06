<?php

// id
$grp->id->CellCssStyle = "";
$grp->id->CellCssClass = "";

// name
$grp->name->CellCssStyle = "";
$grp->name->CellCssClass = "";
?>
<p><span class="phpmaker">Master Record: Grp<br>
<a href="<?php echo $gsMasterReturnUrl ?>">Back to master page</a></span></p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<thead>
		<tr>
			<td class="ewTableHeader">Id</td>
			<td class="ewTableHeader">Name</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td<?php echo $grp->id->CellAttributes() ?>>
<div<?php echo $grp->id->ViewAttributes() ?>><?php echo $grp->id->ListViewValue() ?></div></td>
			<td<?php echo $grp->name->CellAttributes() ?>>
<div<?php echo $grp->name->ViewAttributes() ?>><?php echo $grp->name->ListViewValue() ?></div></td>
		</tr>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
