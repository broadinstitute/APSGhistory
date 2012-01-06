<?php

require_once 'components/grid/grid.php';
require_once 'components/utils/file_utils.php';
require_once 'components/utils/html_utils.php';

abstract class Renderer
{
    protected $result;
    private $captions;
    private $renderScripts = true;
    private $renderText = true;
    private $additionalParams = null;

    protected function DisableCacheControl()
    {
        // Fixes the IE bug
        // see http://www.alagad.com/blog/post.cfm/error-internet-explorer-cannot-download-filename-from-webserver
        header('Pragma: public');
        header('Cache-Control: max-age=0');
    }

    protected function SetHTTPContentTypeByPage($page) 
    {
        $headerString = 'Content-Type: text/html';
        if ($page->GetContentEncoding() != null)
            AddStr($headerString, 'charset=' . $page->GetContentEncoding(), ';');
        header($headerString);
    }

    protected function Captions() {
        return $this->captions;
    }

    public function GetCaptions()
    {
        return $this->captions;
    }

    private function CreateSmatryObject() 
    {
        $result = new Smarty();
        $result->template_dir = 'components/templates';
        return $result;
    }

    public function __construct($captions) {
        $this->captions = $captions;
    }

    #region Rendering

    public function DisplayTemplate($TemplateName, $InputObjects, $InputValues) {
        $smarty = $this->CreateSmatryObject();
        foreach($InputObjects as $ObjectName => &$Object)
            $smarty->assign_by_ref($ObjectName, $Object);
        $smarty->assign_by_ref('Renderer', $this);
        $smarty->assign_by_ref('Captions', $this->captions);
        $smarty->assign('RenderScripts', $this->renderScripts);
        $smarty->assign('RenderText', $this->renderText);
        
        if (isset($this->additionalParams))
        {
            foreach($this->additionalParams as $ValueName => $Value)
            {
                $smarty->assign($ValueName, $Value);
            }
        }

        foreach($InputValues as $ValueName => $Value)
            $smarty->assign($ValueName, $Value);

        $this->result = $smarty->fetch($TemplateName);
    }

    public function Render($Object, $renderScripts = true, $renderText = true, $additionalParams = null)
    {
        $oldRenderScripts = $this->renderScripts;
        $oldRenderText = $this->renderText;
        $oldAdditionalParams = $this->additionalParams;

        $this->renderScripts = $renderScripts;
        $this->renderText = $renderText;
        if (isset($additionalParams))
            $this->additionalParams = $additionalParams;

        $Object->Accept($this);

        $this->renderScripts = $oldRenderScripts;
        $this->renderText = $oldRenderText;
        $this->additionalParams = $oldAdditionalParams;
        return $this->result;
    }

    public function RenderDef($object, $default = '', $additionalParams = null)
    {
        if (isset($object))
            return $this->Render($object, true, true, $additionalParams);
        else
            return $default;
    }

    #endregion

    #region Editors

    private function RenderEditor(CustomEditor $editor, $nameInTemplate, $templateFile, $additionalParams = array())
    {
        $validatorsInfo = array();
        $validatorsInfo['InputAttributes'] = $editor->GetValidationAttributes();
        $validatorsInfo['InputAttributes'] .= StringUtils::Format(
            ' legacy-field-name="%s" pgui-legacy-validate="true"',
            $editor->GetFieldName()
        );

        $this->DisplayTemplate(Path::Combine('editors', $templateFile),
            array($nameInTemplate => $editor),
            array_merge(
                array(
                    'Validators' => $validatorsInfo
                ),
                $additionalParams
            ));
    }

    public function RenderTimeEdit(TimeEdit $editor)
    {
        $this->RenderEditor($editor, 'Editor', 'time_edit.tpl');
    }

    public function RenderMaskedEdit(MaskedEdit $editor)
    {
        $this->RenderEditor($editor, 'Editor', 'masked_edit.tpl');
    }

    public function RenderMultiLevelComboBoxEditor(MultiLevelComboBoxEditor $editor)
    {
        $params = array();
        $editors = array();
        foreach($editor->GetLevels() as $level)
        {
            $editorInfo = array();
            $editorInfo['Name'] = $level->GetName();
            $editorInfo['DataURL'] = $level->GetDataUrl();
            $editorInfo['ParentEditor'] = $level->GetParentEditor();
            $editorInfo['DisplayValue'] = $level->GetDisplayValue();
            $editorInfo['Value'] = $level->GetValue();
            $editorInfo['Caption'] = $level->GetCaption();
            $editors[] = $editorInfo; 
        }
        $params['Editors'] = $editors; 

       
        $this->RenderEditor($editor, 'MultilevelEditor', 'multilevel_selection.tpl', $params);
    }    

    public final function RenderAutocompleteComboBox(AutocomleteComboBox $comboBox) 
    {
        $this->RenderEditor($comboBox, 'ComboBox', 'autocomplete_combo_box.tpl');
    }

    public final function RenderCheckBox(CheckBox $checkBox) 
    {
        $this->RenderEditor($checkBox, 'CheckBox', 'check_box.tpl');
    }

    public final function RenderCheckBoxGroup(CheckBoxGroup $checkBoxGroup) 
    {
        $this->RenderEditor($checkBoxGroup, 'CheckBoxGroup', 'check_box_group.tpl');
    }

    public final function RenderComboBox(ComboBox $comboBox) 
    {
        $this->RenderEditor($comboBox, 'ComboBox', 'combo_box.tpl');
    }

    public final function RenderDateTimeEdit(DateTimeEdit $dateTimeEdit) 
    {
        $this->RenderEditor($dateTimeEdit, 'DateTimeEdit', 'datetime_edit.tpl');
    }

    public final function RenderHtmlWysiwygEditor(HtmlWysiwygEditor $editor)
    {
        $this->RenderEditor($editor, 'Editor', 'html_wysiwyg_editor.tpl');
    }

    protected function ForceHideImageUploaderImage()
    {
        return false;
    }

    public final function RenderImageUploader(ImageUploader $imageUploader)
    {
        $this->RenderEditor($imageUploader, 'Uploader', 'image_uploader.tpl', 
            array('HideImage' => $this->ForceHideImageUploaderImage()));
    }

    public final function RenderRadioEdit(RadioEdit $radioEdit) 
    {   
        $this->RenderEditor($radioEdit, 'RadioEdit', 'radio_edit.tpl');
    }

    public final function RenderSpinEdit(SpinEdit $spinEdit) 
    {
        $this->RenderEditor($spinEdit, 'SpinEdit', 'spin_edit.tpl');
    }

    public final function RenderTextEdit(TextEdit $textEdit) 
    {
        $this->RenderEditor($textEdit, 'TextEdit', 'text_edit.tpl');
    }

    public final function RenderTextAreaEdit(TextAreaEdit $textArea) 
    {
        $this->RenderEditor($textArea, 'TextArea', 'textarea.tpl');
    }

    #endregion

    #region HTML Components
    
    public function RenderComponent($Component) 
    {
        $this->result = '';
    }

    public function RenderTextBox($textBox) 
    {
        $this->result = $textBox->GetCaption();
    }

    public function RenderImage($Image) 
    {
        $this->DisplayTemplate('image.tpl',
            array('Image' => $Image),
            array());
    }

    public function RenderCustomHtmlControl($control) 
    {
        $this->result = $control->GetHtml();
    }

    public function RenderHyperLink($hyperLink) 
    {
        $this->result = sprintf('<a href="%s">%s</a>%s', $hyperLink->GetLink(), $hyperLink->GetInnerText(), $hyperLink->GetAfterLinkText());
    }

    public function RenderHintedTextBox($textBox) 
    {
        $this->DisplayTemplate('hinted_text_box.tpl',
            array('TextBox' => $textBox),
            array());
    }

    #endregion

    #region Variables

    public function GetPageVariables(Page $page)
    {
        if (defined('SHOW_VARIABLES'))
        {
            $this->RenderVariableContainer(
                $page->GetColumnVariableContainer()
                );
            $variables = $this->result;
        }
        else
        {
            $variables = '';
        }
        return $variables;
    }

    public function RenderVariableContainer(IVariableContainer $variableContainer)
    {
        $values = array();
        $variableContainer->FillVariablesValues($values);
        $this->DisplayTemplate('variables_container.tpl',
            array(),
            array('Variables' => $values)
            );
    }

    #endregion
    
    #region Columns

    private function GetNullValuePresentation($column) 
    {
        if ($this->ShowHtmlNullValue())
            return '<em class="pgui-null-value">NULL</em>';
        else
            return '';
    }

    /**
     * @param CustomViewColumn $column
     * @return void
     */
    public final function RenderCustomViewColumn(CustomViewColumn $column)
    {
        $this->result = $column->GetValue();
    }

    protected function GetFriendlyColumnName(CustomViewColumn  $column)
    {
        return $column->GetGrid()->GetDataset()->IsLookupField($column->GetName()) ?
            $column->GetGrid()->GetDataset()->IsLookupFieldNameByDisplayFieldName($column->GetName()) :
            $column->GetName();
    }

    /**
     * @param CustomViewColumn $column
     * @param array $rowValues
     * @return string
     */
    protected function GetCustomRenderedViewColumn(CustomViewColumn $column, $rowValues)
    {
        return null;
    }

    /**
     * @param \CustomViewColumn $column
     * @param array $rowValues
     * @return string
     */
    public final function RenderViewColumn(CustomViewColumn $column, $rowValues)
    {
        $customValue = $this->GetCustomRenderedViewColumn($column, $rowValues);
        if (isset($customValue))
            return $column->GetGrid()->GetPage()->RenderText($customValue);
        else
            return $this->Render($column);
    }

    public final function RenderCustomDatasetFieldViewColumn(CustomDatasetFieldViewColumn $column)
    {
        $value = $column->GetValue();
        if (!isset($value)) 
            $this->result = $this->GetNullValuePresentation($column);
        else
            $this->result = $value;
    }

    public function RenderTextViewColumn($column) 
    {
        $value = $column->GetValue();
        $dataset = $column->GetDataset();

        $column->BeforeColumnRender->Fire(array(&$value, &$dataset));

        if (!isset($value))
        {
            $this->result = $this->GetNullValuePresentation($column);
        }
        else 
        {
            if ($column->GetEscapeHTMLSpecialChars())
                $value = htmlspecialchars($value);

            $columnMaxLength = $column->GetMaxLength();
            
            if ($this->HttpHandlersAvailable() && 
                $this->ChildPagesAvailable() && 
                isset($columnMaxLength) && 
                isset($value) && 
                strlen($value) > $columnMaxLength) 
            {
                $originalValue = $value;
                if ($this->HtmlMarkupAvailable() && $column->GetReplaceLFByBR())
                    $originalValue = str_replace("\n", "<br/>", $originalValue);

                $value = substr($value, 0, $columnMaxLength) . '...';

                $value .= 
                    '<span class="more_hint"><a href="' . $column->GetMoreLink() . '" '.
                    'onClick="javascript: pwin = window.open(\'\',null,\'height=300,width=400,status=yes,resizable=yes,toolbar=no,menubar=no,location=no,left=150,top=200,scrollbars=yes\'); pwin.location=\''.
                    $column->GetMoreLink() . '\'; return false;">' . $this->captions->GetMessageString('more') .
                    '</a>';
                $value .= 
                    '<div class="box_hidden">' . $originalValue . '</div></span>';
            }

            if ($this->HtmlMarkupAvailable() && $column->GetReplaceLFByBR())
                $value = str_replace("\n", "<br/>", $value);

            $this->result = $value;
        }
    }

    public function RenderCheckBoxViewColumn($column) 
    {
        $value = $column->GetInnerField()->GetData();

        if (!isset($value))
            $this->result = $this->Render($column->GetInnerField());
        else if (empty($value)) 
        {
            if ($this->HtmlMarkupAvailable())
                $this->result = $column->GetFalseValue();
            else
                $this->result = 'false';
        }
        else 
        {
            if ($this->HtmlMarkupAvailable())
                $this->result = $column->GetTrueValue();
            else
                $this->result = 'true';

        }
    }

    public function RenderDivTagViewColumnDecorator($column) 
    {
        if ($this->HtmlMarkupAvailable()) 
        {
            $styles = '';
            $styleBuilder = new StyleBuilder();

            if (isset($column->Bold))
                $styleBuilder->Add('font-weight', ($column->Bold ? 'bold' : 'normal'));
            if (isset($column->Italic))
                $styleBuilder->Add('font-style', ($column->Italic ? 'italic' : 'normal'));

            $this->result = '<div '. (!$styleBuilder->IsEmpty() ? ('style="' . $styleBuilder->GetStyleString() . '"') : '') .
                (isset($column->Align) ? ' align="' . $column->Align . '" ' : '') .
                (isset($column->CustomAttributes) ? $column->CustomAttributes . ' ' : '') . '>'.
                $this->Render($column->GetInnerField()) .
                '</div>';
        }
        else 
        {
            $this->result = $this->Render($column->GetInnerField());
        }
    }

    public function RenderExtendedHyperLinkColumnDecorator($columDecorator)
    {
        if ($columDecorator->GetData() == null) 
        {
            $this->result = $this->GetNullValuePresentation($columDecorator);
        }
        else
        {
            if ($this->HtmlMarkupAvailable())
            {
                $this->result = sprintf('<a href="%s" target="%s">%s</a>',
                    $columDecorator->GetLink(),
                    $columDecorator->GetTarget(),
                    $this->Render($columDecorator->GetInnerField())
                    );
            }
            else
                $this->result = $this->Render($columDecorator->GetInnerField());
        }
    }

    public function RenderDownloadDataColumn($column)
    {
        if ($column->GetData() == null) 
        {
            $this->result = $this->GetNullValuePresentation($column);
        }
        else 
        {
            if ($this->HtmlMarkupAvailable() && $this->HttpHandlersAvailable())
                $this->result = '<a class="image" target="_blank" title="download" href="' . $column->GetDownloadLink() . '">' . $column->GetLinkInnerHtml() . '</a>';
            else
                $this->result = $this->Captions()->GetMessageString('BinaryDataCanNotBeExportedToXls');
        }
    }

    public function RenderImageViewColumn($column) 
    {
        if ($column->GetData() == null) 
        {
            $this->result = $this->GetNullValuePresentation($column);
        }
        else 
        {
            if ($this->HtmlMarkupAvailable() && $this->HttpHandlersAvailable()) 
            {
                if($column->GetEnablePictureZoom())
                    $this->result = sprintf(
                        '<a class="image" href="%s" rel="zoom" title="%s"><img data-image-column="true" src="%s" alt="%s"></a>',
                        $column->GetFullImageLink(),
                        $column->GetImageHint(),
                        $column->GetImageLink(),
                        $column->GetImageHint());
                else
                    $this->result = sprintf(
                        '<img data-image-column="true" src="%s" alt="%s">',
                        $column->GetImageLink(),
                        $column->GetImageHint());
            }
            else 
            {
                $this->result = $this->Captions()->GetMessageString('BinaryDataCanNotBeExportedToXls');
            }
        }
    }

    public function RenderDetailColumn($detailColumn) 
    {
        $this->result =
            '<a class="page_link" onclick="expand(' . $detailColumn->GetDataset()->GetCurrentRowIndex() .
            ' , this);" href="' . $detailColumn->GetLink() . '">+</a>&nbsp;' .
            '<a class="page_link" href="' . $detailColumn->GetSeparateViewLink() . '">view</a>';
    }

    #endregion

    #region Pages

    public function RenderPageNavigator($Page) { }

    public abstract function RenderPage($Page);

    public function RenderCustomErrorPage($errorPage) 
    {
        $this->DisplayTemplate('security_error_page.tpl',
            array(
                    'Page' => $errorPage),
                array(
                    'Message' => $errorPage->GetMessage(),
                    'Description' => $errorPage->GetDescription()
                    ));
    }

    public function RenderDetailPage($DetailPage) 
    {
        $this->SetHTTPContentTypeByPage($DetailPage);

        $Grid = $this->Render($DetailPage->GetGrid());
        $this->DisplayTemplate('list/detail_page.tpl',
            array(
                    'Page' => $DetailPage,
                    'DetailPage' => $DetailPage),
                array(
                    'Grid' => $Grid
                    )
                );
    }

    public function RenderDetailPageEdit($DetailPage) 
    {
        $this->SetHTTPContentTypeByPage($DetailPage);

        $Grid = $this->Render($DetailPage->GetGrid());
        $PageNavigator = $DetailPage->GetPageNavigator();
        if ($DetailPage->GetPageList() != null)
            $pageList = $this->Render($DetailPage->GetPageList());
        else
            $pageList = null;
        if (isset($PageNavigator))
            $PageNavigator = $this->Render($DetailPage->GetPageNavigator());
        else
            $PageNavigator = '';

        $isAdvancedSearchActive = false;
        $userFriendlySearchCondition = '';
        if (isset($DetailPage->AdvancedSearchControl)) {
            $isAdvancedSearchActive = $DetailPage->AdvancedSearchControl->IsActive();
            $userFriendlySearchCondition = $DetailPage->AdvancedSearchControl->GetUserFriendlySearchConditions();
            $linkBuilder = $DetailPage->CreateLinkBuilder();
            $linkBuilder->AddParameter(OPERATION_PARAMNAME, OPERATION_ADVANCED_SEARCH);
            $DetailPage->AdvancedSearchControl->SetOpenInNewWindowLink($linkBuilder->GetLink());
        }

        $this->DisplayTemplate('list/detail_page_edit.tpl',
            array(
                    'Page' => $DetailPage,
                    'DetailPage' => $DetailPage,
                    'PageList' => $pageList
                    ),
                array(
                    'Grid' => $Grid,
                    'AdvancedSearch' => isset($DetailPage->AdvancedSearchControl) ? $this->Render($DetailPage->AdvancedSearchControl) : '',
                    'IsAdvancedSearchActive' => $isAdvancedSearchActive,
                    'FriendlyAdvancedSearchCondition' => $userFriendlySearchCondition,
                    'PageNavigator' => $PageNavigator,
                    'MasterGrid' => $this->Render($DetailPage->GetMasterGrid()),
                    'Variables' => $this->GetPageVariables($DetailPage)
                    )
                );
    }

    public function RenderLoginPage($loginPage) 
    {
        $this->SetHTTPContentTypeByPage($loginPage);

        $this->DisplayTemplate('login_page.tpl',
            array(
                    'Page' => $loginPage,
                    'LoginControl' => $loginPage->GetLoginControl()),
                array());
    }

    #endregion

    #region Page parts

    public function RenderTextBlobViewer($textBlobViewer) 
    {
        $this->DisplayTemplate('text_blob_viewer.tpl',
            array(
                    'Viewer' => $textBlobViewer,
                    'Page' => $textBlobViewer->GetParentPage()),
                array());
    }

    public abstract function RenderGrid(Grid $Grid);

    public function RenderSimpleSearch($searchControl) 
    {
        $this->DisplayTemplate('search_control.tpl',
            array('SearchControl' => $searchControl),
            array());
    }

    public function RenderVerticalGrid(VerticalGrid $grid)
    {
        if ($grid->GetState() == VerticalGridState::JSONResponse)
        {
            $this->result = SystemUtils::ToXML($grid->GetResponse());
        }
        else if ($grid->GetState() == VerticalGridState::DisplayGrid)
        {
            $hiddenValues = array(OPERATION_PARAMNAME => OPERATION_COMMIT);
            AddPrimaryKeyParametersToArray($hiddenValues, $grid->GetGrid()->GetDataset()->GetPrimaryKeyValues());

            $primaryKeyMap = $grid->GetGrid()->GetDataset()->GetPrimaryKeyValuesMap();

            $this->DisplayTemplate('edit/vertical_grid.tpl',
                array(
                'Title' => $grid->GetGrid()->GetPage()->GetShortCaption(),
                'Grid' => $grid->GetGrid(),
                'Columns' => $grid->GetGrid()->GetEditColumns(),
                'PrimaryKeyMap' => $primaryKeyMap,
                'ClientValidationScript' => $grid->GetGrid()->GetEditClientValidationScript()
                ),
                array(
                'HiddenValues' => $hiddenValues
                )
            ); 
        }
        else if ($grid->GetState() == VerticalGridState::DisplayInsertGrid)
        {
            $hiddenValues = array(OPERATION_PARAMNAME => OPERATION_COMMIT);
            
            $this->DisplayTemplate('insert/vertical_grid.tpl',
                array(
                'Title' => $grid->GetGrid()->GetPage()->GetShortCaption(),
                'Grid' => $grid->GetGrid(),
                'Columns' => $grid->GetGrid()->GetInsertColumns(),
                'ClientValidationScript' => $grid->GetGrid()->GetEditClientValidationScript()
                ),
                array(
                'HiddenValues' => $hiddenValues
                )
            );
        }

    }

    public function RenderAdvancedSearchControl($advancedSearchControl) {

        $this->DisplayTemplate('advanced_search_control.tpl',
            array(
                    'AdvancedSearchControl' => $advancedSearchControl
                    ),
                array(
                    'TextsForHighlight' => $advancedSearchControl->GetHighlightedFieldText(),
                    'HighlightOptions' => $advancedSearchControl->GetHighlightedFieldOptions(),
                    'EditorControl' => '' //$this->Render($Column->GetEditorControl())
                    ));
    }

    public function RenderPageList($pageList) 
    {
        $this->DisplayTemplate('page_list.tpl',
            array('PageList' => $pageList),
            array());
    }

    public function RenderLoginControl($loginControl) 
    {
        $this->DisplayTemplate('login_control.tpl',
            array('LoginControl' => $loginControl),
            array());
    }

    public function RenderComplexActionsColumn(ComplexActionsColumn $column)
    {
        $this->DisplayTemplate('list/actions_column.tpl',
            array('Column' => $column),
            array());
    }

    #endregion    

    #region Column rendering options
    
    protected function ShowHtmlNullValue() 
    {
        return false;
    }
    
    protected function HttpHandlersAvailable() 
    {
        return true;
    }
    
    protected function HtmlMarkupAvailable() 
    {
        return true;
    }
    
    protected function ChildPagesAvailable() 
    {
        return true;
    }
    
    #endregion

}

class SingleAdvancedSearchRenderer extends Renderer
{
    function RenderPage($Page)
    {
        $this->SetHTTPContentTypeByPage($Page);
        $Page->BeforePageRender->Fire(array(&$Page));

        if (isset($Page->AdvancedSearchControl))
        {
            $Page->AdvancedSearchControl->SetHidden(false);
            $Page->AdvancedSearchControl->SetAllowOpenInNewWindow(false);
            $linkBuilder = $Page->CreateLinkBuilder();
            $Page->AdvancedSearchControl->SetTarget($linkBuilder->GetLink());
        }
        $this->DisplayTemplate('common/single_advanced_search_page.tpl',
            array(
                    'Page' => $Page
                    ),
                array(
                    'AdvancedSearch' => $this->RenderDef($Page->AdvancedSearchControl),
                    'PageList' => $this->RenderDef($Page->GetPageList())
                    )
                );
    }

    function RenderDetailPageEdit($Page)
    {
        $this->SetHTTPContentTypeByPage($Page);
        $Page->BeforePageRender->Fire(array(&$Page));

        if (isset($Page->AdvancedSearchControl))
        {
            $Page->AdvancedSearchControl->SetHidden(false);
            $Page->AdvancedSearchControl->SetAllowOpenInNewWindow(false);
            $linkBuilder = $Page->CreateLinkBuilder();
            $Page->AdvancedSearchControl->SetTarget($linkBuilder->GetLink());
        }
        $this->DisplayTemplate('common/single_advanced_search_page.tpl',
            array(
                    'Page' => $Page
                    ),
                array(
                    'AdvancedSearch' => $this->RenderDef($Page->AdvancedSearchControl),
                    'PageList' => $this->RenderDef($Page->GetPageList())
                    )
                );
    }

    function RenderGrid(Grid $Grid)
    {
        $this->result = '';
    }
}

?>