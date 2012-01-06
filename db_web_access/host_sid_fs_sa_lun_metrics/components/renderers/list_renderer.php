<?php

require_once 'renderer.php';
require_once 'components/env_variables.php';
require_once 'components/utils/html_utils.php';


class ViewAllRenderer extends Renderer
{
    public $renderSingleRow;

    private function GetStylesForColumn($grid, $rowData)
    {
        $cellFontColor = array();
        $cellFontSize = array();
        $cellBgColor = array();
        $cellItalicAttr = array();
        $cellBoldAttr = array();

        $grid->OnCustomDrawCell_Simple->Fire(array($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr));

        $result = array();
        $fieldNames = array_unique(array_merge(
            array_keys($cellFontColor),
            array_keys($cellFontSize),
            array_keys($cellBgColor),
            array_keys($cellItalicAttr),
            array_keys($cellBoldAttr)));

        $fieldStylesBuilder = new StyleBuilder();
        foreach ($fieldNames as $fieldName)
        {
            $fieldStylesBuilder->Clear();
            if (array_key_exists($fieldName, $cellFontColor))
                $fieldStylesBuilder->Add('color', $cellFontColor[$fieldName]);
            if (array_key_exists($fieldName, $cellFontSize))
                $fieldStylesBuilder->Add('font-size', $cellFontSize[$fieldName]);
            if (array_key_exists($fieldName, $cellBgColor))
                $fieldStylesBuilder->Add('background-color', $cellBgColor[$fieldName]);
            if (array_key_exists($fieldName, $cellItalicAttr))
                $fieldStylesBuilder->Add('font-style',
                    $cellItalicAttr[$fieldName] ? 'italic' : 'normal');
            if (array_key_exists($fieldName, $cellBoldAttr))
            {
                $fieldStylesBuilder->Add('font-weight',
                    $cellBoldAttr[$fieldName] ? 'bold' : 'normal');
            }
            $result[$fieldName] = $fieldStylesBuilder->GetStyleString();
        }

        return $result;
    }

    #region Pages

    public function RenderPage($Page)
    {
        $this->SetHTTPContentTypeByPage($Page);
        $Page->BeforePageRender->Fire(array(&$Page));

        $Grid = $this->Render($Page->GetGrid());
        
        $isAdvancedSearchActive = false;
        if (isset($Page->AdvancedSearchControl))
        {
            $isAdvancedSearchActive = $Page->AdvancedSearchControl->IsActive();
            $linkBuilder = $Page->CreateLinkBuilder();
            $linkBuilder->AddParameter(OPERATION_PARAMNAME, OPERATION_ADVANCED_SEARCH);
            $Page->AdvancedSearchControl->SetOpenInNewWindowLink($linkBuilder->GetLink());
        }

        
        $this->DisplayTemplate('list/page.tpl',
            array(
                    'Page' => $Page
                    ),
                array(
                    'Grid' => $Grid,
                    'AdvancedSearch' => $this->RenderDef($Page->AdvancedSearchControl),
                    'FriendlyAdvancedSearchCondition' => isset($Page->AdvancedSearchControl) ? $Page->AdvancedSearchControl->GetUserFriendlySearchConditions() : '',
                    'PageNavigator' => $this->RenderDef($Page->GetPageNavigator(), '', array('PageNavId' => 1)),
                    'PageNavigator2' => $this->RenderDef($Page->GetPageNavigator(), '', array('PageNavId' => 2)),
                    'IsAdvancedSearchActive' => $isAdvancedSearchActive,
                    'PageList' => $this->RenderDef($Page->GetPageList()),
                    'Variables' => $this->GetPageVariables($Page)
                    )
                );
    }
    
    #endregion

    #region Page parts

    public function RenderGrid(Grid $Grid)
    {
        $Rows = array();
        $RowPrimaryKeys = array();
        $AfterRows = array();
        $rowCssStyles = array();
        $rowColumnsChars = array();
        $rowColumnsCssStyles = array();
        $bandHeadColumnsStyles = array();
        $columnsNames = array();

        $bands = $Grid->GetViewBands();
        for($i = 0; $i < count($bands); $i++)
        {
            $band = $bands[$i];
            $headColumnsStyles = array();
            foreach($band->GetColumns() as $Column)
            {
                $headColumnsStyleBuilder = new StyleBuilder();

                if ($Column->GetFixedWidth() != null)
                    $headColumnsStyleBuilder->Add('width', $Column->GetFixedWidth());
                
                $headColumnsStyles[] = $headColumnsStyleBuilder->GetStyleString();
                $columnsNames[] = $Column->GetName();
            }
            if ($i < (count($bands) - 1))
            {
                $bandBorderStyle =
                    ($Grid->GetPage()->GetPageDirection() == 'rtl' ? 'border-left: ' : 'border-right: ' ) .
                    'solid 2px #000000;'; 
                $headColumnsStyles[count($headColumnsStyles) - 1] .= $bandBorderStyle; 
            }
            $bandHeadColumnsStyles[] = $headColumnsStyles;
        }

        $Grid->GetDataset()->Open();
        $recordCount = 0;
        while($Grid->GetDataset()->Next())
        {
            $show = true;
            $Grid->BeforeShowRecord->Fire(array(&$show));
            if (!$show)
                continue;

            $Row = array();
            $AfterRowControls = '';

            $rowValues = $Grid->GetDataset()->GetFieldValues();
            $rowCssStyle = '';
            $cellCssStyles = array();

            $Grid->OnCustomDrawCell->Fire(array($rowValues, &$cellCssStyles, &$rowCssStyle));
            $cellCssStyles_Simple = $this->GetStylesForColumn($Grid, $rowValues);
            $cellCssStyles = array_merge($cellCssStyles_Simple, $cellCssStyles);

            $currentRowColumnsCssStyles = array();

            $columnsChars = array();
            for($i = 0; $i < count($bands); $i++)
            {
                $band = $bands[$i];
                
                foreach($band->GetColumns() as $Column)
                {
                    $columnName = $Grid->GetDataset()->IsLookupField($Column->GetName()) ?
                        $Grid->GetDataset()->IsLookupFieldNameByDisplayFieldName($Column->GetName()) :
                        $Column->GetName();

                    
                    if (array_key_exists($columnName, $cellCssStyles))
                    {
                        $styleBuilder = new StyleBuilder();
                        $styleBuilder->AddStyleString($rowCssStyle);
                        $styleBuilder->AddStyleString($cellCssStyles[$columnName]);
                        $currentRowColumnsCssStyles[] = $styleBuilder->GetStyleString();
                    }
                    else
                        $currentRowColumnsCssStyles[] = $rowCssStyle;    

                    if ($Column->GetFixedWidth() != null)
                        $currentRowColumnsCssStyles[count($currentRowColumnsCssStyles) - 1] .=  sprintf('width: %s;', $Column->GetFixedWidth());
                    if (!$Column->GetWordWrap())
                        $currentRowColumnsCssStyles[count($currentRowColumnsCssStyles) - 1] .=  sprintf('white-space: nowrap;', $Column->GetFixedWidth());


                    $columnRenderResult = '';
                    $customRenderColumnHandled = false;
                    $Grid->OnCustomRenderColumn->Fire(array($columnName, $Column->GetData(), $rowValues, &$columnRenderResult, &$customRenderColumnHandled));
                    $columnRenderResult = $customRenderColumnHandled ? $Grid->GetPage()->RenderText($columnRenderResult) : $this->Render($Column);
                    $Row[] = $columnRenderResult;
                    $columnsChars[] = ($Column->IsDataColumn() ? 'data' : 'misc');

                    $afterRow = $Column->GetAfterRowControl();
                    if (isset($afterRow))
                        $AfterRowControls .= $this->Render($afterRow);
                }

                if ($i < (count($bands) - 1))
                    $currentRowColumnsCssStyles[count($currentRowColumnsCssStyles) - 1] .= ($Grid->GetPage()->GetPageDirection() == 'rtl' ? 'border-left: ' : 'border-right: ' ). 'solid 2px' . ' #000000;';
            }
            $recordCount++;
            if ($Grid->GetAllowDeleteSelected())
                $RowPrimaryKeys[] = $Grid->GetDataset()->GetPrimaryKeyValues();
            $Rows[] = $Row;
            $AfterRows[] = $AfterRowControls;
            $rowCssStyles[] = $rowCssStyle;
            $rowColumnsCssStyles[] = $currentRowColumnsCssStyles;
            $rowColumnsChars[] = $columnsChars;
        }

        $totals = array();
        if ($Grid->HasTotals())
        {
            $totalValues = $Grid->GetTotalValues();
            for($i = 0; $i < count($bands); $i++)
            {
                $band = $bands[$i];
                $columns = $band->GetColumns();
                for($j = 0; $j < count($columns); $j++)
                {
                    $column = $columns[$j];
                    $total = array();
                    if(isset($totalValues[$column->GetName()]))
                    {
                        $total['IsEmpty'] = false;
                        $totalValue = $totalValues[$column->GetName()];
                        if (is_numeric($totalValue))
                            $totalValue = number_format((double)$totalValue, 2);
                        $total['Value'] = $totalValue;
                        $total['Aggregate'] = $Grid->GetAggregateFor($column)->AsString();

                        $aggregate = $Grid->GetAggregateFor($column)->AsString();
                        $customTotalValue = '';
                        $handled = false;
                        $Grid->OnCustomRenderTotal->Fire(array($totalValue, $aggregate, $column->GetName(), &$customTotalValue, &$handled));
                        if ($handled)
                        {
                            $total['UserHTML'] = $customTotalValue;
                            $total['CustomValue'] = true;
                        }
                    }
                    else
                    {
                        $total['IsEmpty'] = true;
                    }

                    if ($i < (count($bands) - 1) && ($j == count($columns) - 1))
                    {
                        $total['Style'] =
                                ($Grid->GetPage()->GetPageDirection() == 'rtl' ? 'border-left: ' : 'border-right: ' ) .
                                        'solid 2px #000000;';
                    }

                    $totals[] = $total;
                }
            }
        }

        $startLineNumber = 1;
        $paginationControl = $Grid->GetPage()->GetPaginationControl();
        if (isset($paginationControl))
        {
            $startLineNumber =
                    ($paginationControl->CurrentPageNumber() - 1) * ($paginationControl->GetRowsPerPage()) + 1; 
        }

        $this->DisplayTemplate(
            $this->renderSingleRow ? 'list/single_row.tpl' : 'list/grid.tpl',
            array(
                'Grid' => $Grid,
                'Page' => $Grid->GetPage()
            ),
            array(
                'LineNumberPadCount' => 'optimal',
                'ShowLineNumbers' => $Grid->GetShowLineNumbers(),
                'StartLineNumbers' => $startLineNumber,
                'SearchControl' => isset($Grid->SearchControl) ? $this->Render($Grid->SearchControl) : '',
                'Columns' => $Grid->GetViewColumns(),
                'Bands' => $Grid->GetViewBands(),
                'AfterRows' => $AfterRows,
                'ColumnCount' => count($Grid->GetViewColumns()) +
                        ($Grid->GetAllowDeleteSelected() ? 1 : 0) +
                        ($Grid->GetShowLineNumbers() ? 1 : 0),
                'Rows' => $Rows,
                'UseFilter' => $Grid->GetPage()->GetSimpleSearchAvailable() && $Grid->UseFilter,
                'RowCssStyles' => $rowCssStyles,
                'RowColumnsCssStyles' => $rowColumnsCssStyles,
                'HeadColumnsStyles' => $bandHeadColumnsStyles,
                'RowPrimaryKeys' => $RowPrimaryKeys,
                'AllowDeleteSelected' => $Grid->GetAllowDeleteSelected(),
                'RecordCount' => $recordCount,
                'RowColumnsChars' => $rowColumnsChars,
                'ColumnsNames' => $columnsNames,
                'Totals' => $totals
            ));
    }

    public function RenderCustomPageNavigator($pageNavigator)
    {
        if ($pageNavigator->GetNavigationStyle() == NS_LIST)
            $templateName = 'custom_page_navigator.tpl';
        elseif ($pageNavigator->GetNavigationStyle() == NS_COMBOBOX)
            $templateName = 'combo_box_custom_page_navigator.tpl';

        $this->DisplayTemplate('list/'.$templateName,
            array(
                    'PageNavigator' => $pageNavigator,
                    'PageNavigatorPages' => $pageNavigator->GetPages()),
                array()
                );
    }

    public function RenderCompositePageNavigator($PageNavigator)
    {
        $this->DisplayTemplate('list/composite_page_navigator.tpl',
            array(
                    'PageNavigator' => $PageNavigator),
                array()
                );
    }

    public function RenderPageNavigator($PageNavigator)
    {
        $this->DisplayTemplate('list/page_navigator.tpl',
            array(
                    'PageNavigator' => $PageNavigator,
                    'PageNavigatorPages' => $PageNavigator->GetPages()),
                array()
                );
    }

    #endregion

    #region Column rendering options
    
    protected function ShowHtmlNullValue()
    { 
        return true; 
    }

    #endregion
}

class ErrorStateRenderer extends ViewAllRenderer
{
    private $exception;

    public function  __construct($captions, $exception)
    {
        parent::__construct($captions);
        $this->exception = $exception;
    }

    function RenderPage($Page)
    {
        $this->SetHTTPContentTypeByPage($Page);

        $PageList = $Page->GetPageList();
        $PageList = isset($PageList) ? $this->Render($PageList) : '';

        $this->DisplayTemplate('list/error_page.tpl',
            array('Page' => $Page),
            array(
                'PageList' => $PageList,
                'ErrorMessage' => $this->exception->getMessage(),
                )
        );
    }
}


?>