<?php

// Call Row_Rendering event
$server_type->Row_Rendering();

// id
$server_type->id->CellCssStyle = ""; $server_type->id->CellCssClass = "";
$server_type->id->CellAttrs = array(); $server_type->id->ViewAttrs = array(); $server_type->id->EditAttrs = array();

// name
$server_type->name->CellCssStyle = ""; $server_type->name->CellCssClass = "";
$server_type->name->CellAttrs = array(); $server_type->name->ViewAttrs = array(); $server_type->name->EditAttrs = array();

// Call Row_Rendered event
$server_type->Row_Rendered();
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $server_type->TableCaption() ?><br>
<a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterPage") ?></a></span></p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<thead>
		<tr>
			<td class="ewTableHeader"><?php echo $server_type->id->FldCaption() ?></td>
			<td class="ewTableHeader"><?php echo $server_type->name->FldCaption() ?></td>
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
