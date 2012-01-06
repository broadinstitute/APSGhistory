<?php

// id
$server_type->id->CellCssStyle = "";
$server_type->id->CellCssClass = "";

// name
$server_type->name->CellCssStyle = "";
$server_type->name->CellCssClass = "";
?>
<p><span class="phpmaker">Master Record: Server Type<br>
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
			<td<?php echo $server_type->id->CellAttributes() ?>>
<div<?php echo $server_type->id->ViewAttributes() ?>><?php echo $server_type->id->ListViewValue() ?></div></td>
			<td<?php echo $server_type->name->CellAttributes() ?>>
<div<?php echo $server_type->name->ViewAttributes() ?>><?php echo $server_type->name->ListViewValue() ?></div></td>
		</tr>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
