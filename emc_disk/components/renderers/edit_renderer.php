<?php

require_once 'renderer.php';

class EditRenderer extends Renderer
{
    #region Pages

    function RenderPage($Page)
    {
        $this->SetHTTPContentTypeByPage($Page);
        $Page->BeforePageRender->Fire(array(&$Page));

        $this->DisplayTemplate('edit/page.tpl',
            array('Page' => $Page),
            array(
                'Grid' => $this->Render($Page->GetGrid()),
                    'Variables' => $this->GetPageVariables($Page)
        ));
    }

    function RenderDetailPageEdit($Page)
    {
        $this->DisplayTemplate('edit/page.tpl',
            array('Page' => $Page),
            array(
            'Grid' => $this->Render($Page->GetGrid())
        ));
    }

    #endregion

    #region Page parts

    function RenderGrid(Grid $Grid)
    {
        $hiddenValues = array(OPERATION_PARAMNAME => OPERATION_COMMIT);
        AddPrimaryKeyParametersToArray($hiddenValues, $Grid->GetDataset()->GetPrimaryKeyValues());

        $primaryKeyMap = $Grid->GetDataset()->GetPrimaryKeyValuesMap();

        $this->DisplayTemplate('edit/grid.tpl',
            array(
            'Title' => $Grid->GetPage()->GetShortCaption(),
            'Grid' => $Grid,
            'Columns' => $Grid->GetEditColumns(),
            'PrimaryKeyMap' => $primaryKeyMap,
            'ClientValidationScript' => $Grid->GetEditClientValidationScript()
            ),
            array(
            'HiddenValues' => $hiddenValues
            )
        );
    }

    #endregion
}
?>