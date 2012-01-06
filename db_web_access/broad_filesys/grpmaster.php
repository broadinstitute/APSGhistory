<?php

// Call Row_Rendering event
$grp->Row_Rendering();

// id
$grp->id->CellCssStyle = ""; $grp->id->CellCssClass = "";
$grp->id->CellAttrs = array(); $grp->id->ViewAttrs = array(); $grp->id->EditAttrs = array();

// name
$grp->name->CellCssStyle = ""; $grp->name->CellCssClass = "";
$grp->name->CellAttrs = array(); $grp->name->ViewAttrs = array(); $grp->name->EditAttrs = array();

// parent
$grp->parent->CellCssStyle = ""; $grp->parent->CellCssClass = "";
$grp->parent->CellAttrs = array(); $grp->parent->ViewAttrs = array(); $grp->parent->EditAttrs = array();

// Call Row_Rendered event
$grp->Row_Rendered();
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("MasterRecord") ?><?php echo $grp->TableCaption() ?><br>
<a href="<?php echo $gsMasterReturnUrl ?>"><?php echo $Language->Phrase("BackToMasterPage") ?></a></span></p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
	<thead>
		<tr>
			<td class="ewTableHeader"><?php echo $grp->id->FldCaption() ?></td>
			<td class="ewTableHeader"><?php echo $grp->name->FldCaption() ?></td>
			<td class="ewTableHeader"><?php echo $grp->parent->FldCaption() ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td<?php echo $grp->id->CellAttributes() ?>>
<div<?php echo $grp->id->ViewAttributes() ?>><?php echo $grp->id->ListViewValue() ?></div></td>
			<td<?php echo $grp->name->CellAttributes() ?>>
<div<?php echo $grp->name->ViewAttributes() ?>><?php echo $grp->name->ListViewValue() ?></div></td>
			<td<?php echo $grp->parent->CellAttributes() ?>>
<div<?php echo $grp->parent->ViewAttributes() ?>><?php echo $grp->parent->ListViewValue() ?></div></td>
		</tr>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
