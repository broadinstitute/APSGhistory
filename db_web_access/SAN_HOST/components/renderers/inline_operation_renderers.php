<?php

require_once 'components/renderers/renderer.php';
require_once 'components/grid/grid.php';
require_once 'components/utils/system_utils.php';

class InlineEditRenderer extends Renderer
{
    public function RenderDetailPageEdit($detailPage)
    {
        header('Content-Type: application/xml');
        $this->DisplayTemplate('inline_operations/page.tpl',
            array(
                    ),
                array('Grid' => $this->Render($detailPage->GetGrid()))
                );
    }

    function RenderPage($Page)
    {
        header('Content-Type: application/xml');
        $this->DisplayTemplate('inline_operations/page.tpl',
            array(
                    ),
                array('Grid' => $this->Render($Page->GetGrid()))
                );
    }

    function RenderGrid(Grid $grid)
    {
        $columnEditors = array();

        foreach($grid->GetViewColumns() as $column)
        {
            $editor = $column->GetEditOperationEditor();
            if (isset($editor))
            {
                $columnEditors[$column->GetName()]['Html'] = $this->Render($editor, false, true);
                $columnEditors[$column->GetName()]['Script'] = $this->Render($editor, true, false);
            }
        }
        
        $this->DisplayTemplate('inline_operations/grid.tpl',
            array(
                    'ColumnEditors' => $columnEditors,
                    'EditorsNameSuffix' => $grid->GetState()->GetNameSuffix()),
                array()
                );
    }
}

class ComminInlineEditRenderer extends Renderer
{
    public function RenderDetailPageEdit($detailPage)
    {
        header('Content-Type: application/xml');
        $this->DisplayTemplate('inline_operations/page.tpl',
            array(
                    ),
                array('Grid' => $this->Render($detailPage->GetGrid()))
                );
    }

    function RenderPage($Page)
    {
        header('Content-Type: application/xml');
        $this->DisplayTemplate('inline_operations/page.tpl',
            array(
                    ),
                array('Grid' => $this->Render($Page->GetGrid()))
                );
    }

    function RenderGrid(Grid $grid)
    {
        $columnEditors = array();

        if ($grid->GetErrorMessage() != '')
        {
            foreach($grid->GetViewColumns() as $column)
            {
                $editor = $column->GetEditOperationEditor();
                if (isset($editor))
                {
                    $columnEditors[$column->GetName()]['Html'] = $this->Render($editor, false, true);
                    $columnEditors[$column->GetName()]['Script'] = $this->Render($editor, true, false);
                }
            }

            $this->DisplayTemplate('inline_operations/grid_edit_error_response.tpl',
                array(
                        'ErrorMessage' => $grid->GetErrorMessage(),
                        'ColumnEditors' => $columnEditors,
                        ),
                    array()
                    );
            
            return;
        }
        
        $grid->GetDataset()->Open();
        if ($grid->GetDataset()->Next())
        {
            foreach($grid->GetViewColumns() as $column)
            {
                $editor = $column->GetEditOperationEditor();
                //if (isset($editor))
                    $columnValues[$column->GetName()] = $this->Render($column);
            }

            $this->DisplayTemplate('inline_operations/grid_edit_commit_response.tpl',
                array('ColumnValues' => $columnValues),
                array()
                );
        }
    }

    protected function ShowHtmlNullValue() 
    {
        return true;
    }
}


class InlineInsertRenderer extends Renderer
{
    function RenderDetailPageEdit($Page)
    {
        header('Content-Type: application/xml');
        $this->DisplayTemplate('inline_operations/page.tpl',
            array(
                    ),
                array('Grid' => $this->Render($Page->GetGrid()))
                );
    }

    function RenderPage($Page)
    {
        header('Content-Type: application/xml');
        $this->DisplayTemplate('inline_operations/page.tpl',
            array(
                    ),
                array('Grid' => $this->Render($Page->GetGrid()))
                );
    }

    function RenderGrid(Grid $grid)
    {
        $columnEditors = array();
        
        foreach($grid->GetViewColumns() as $column)
        {
            $editor = $column->GetInsertOperationEditor();
            if (isset($editor))
            {
                $columnEditors[$column->GetName()]['Html'] = $this->Render($editor, false, true);
                $columnEditors[$column->GetName()]['Script'] = $this->Render($editor, true, false);
            }
        }
        
        $this->DisplayTemplate('inline_operations/grid.tpl',
            array(
                    'ColumnEditors' => $columnEditors,
                    'EditorsNameSuffix' => $grid->GetState()->GetNameSuffix()),
                array()
                );
    }
}

class ComminInlineInsertRenderer extends Renderer
{
    function RenderDetailPageEdit($Page)
    {
        header('Content-Type: application/xml');
        $this->DisplayTemplate('inline_operations/page.tpl',
            array(
                    ),
                array('Grid' => $this->Render($Page->GetGrid()))
                );
    }

    function RenderPage($Page)
    {
        header('Content-Type: application/xml');
        $this->DisplayTemplate('inline_operations/page.tpl',
            array(
                    ),
                array('Grid' => $this->Render($Page->GetGrid()))
                );
    }

    function RenderGrid(Grid $grid)
    {
        $columnEditors = array();

        if ($grid->GetErrorMessage() != '')
        {
            foreach($grid->GetViewColumns() as $column)
            {
                $editor = $column->GetInsertOperationEditor();
                if (isset($editor))
                {
                    $columnEditors[$column->GetName()]['Html'] = $this->Render($editor, false, true);
                    $columnEditors[$column->GetName()]['Script'] = $this->Render($editor, true, false);
                }
            }

            $this->DisplayTemplate('inline_operations/grid_edit_error_response.tpl',
                array(
                        'ErrorMessage' => $grid->GetErrorMessage(),
                        'ColumnEditors' => $columnEditors,
                        ),
                    array()
                    );
            
            return;
        }
        
        $columns = array();
        foreach($grid->GetViewColumns() as $column)
        {
            $columns[$column->GetName()]['Value'] = $this->Render($column);
            $columns[$column->GetName()]['AfterRowControl'] = $this->Render($column->GetAfterRowControl());
        }

        $primaryKeys = array();
        if ($grid->GetAllowDeleteSelected())
            $primaryKeys = $grid->GetDataset()->GetPrimaryKeyValues();

        $this->DisplayTemplate('inline_operations/grid_insert_commit_response.tpl',
            array(
                    'AllowDeleteSelected' => $grid->GetAllowDeleteSelected(),
                    'PrimaryKeys' => $primaryKeys,
                    'Columns' => $columns,
                    'RecordUID' => Random::GetIntRandom()
                    ),
                array()
                );
    }

    protected function ShowHtmlNullValue() 
    {
        return true;
    }
}

?>
