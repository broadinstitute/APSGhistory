<?php

class InsertRenderer extends EditRenderer
{
    protected function ForceHideImageUploaderImage()
    {
        return true;
    }
    
    public function RenderGrid(Grid $Grid)
    {
        $hiddenValues = array(OPERATION_PARAMNAME => OPERATION_COMMIT_INSERT);

        $this->DisplayTemplate('insert/grid.tpl',
            array(
            'Title' => $Grid->GetPage()->GetShortCaption(),
            'Grid' => $Grid,
            'Columns' => $Grid->GetInsertColumns(),
            'ClientValidationScript' => $Grid->GetInsertClientValidationScript()
            ),
            array(
            'HiddenValues' => $hiddenValues
            )
        );
    }
}

?>
