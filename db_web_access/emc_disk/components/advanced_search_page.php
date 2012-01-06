<?php

require_once 'phpgen_settings.php';
require_once 'components/utils/string_utils.php';
require_once 'components/superglobal_wrapper.php';
require_once 'components/renderers/renderer.php';
require_once 'components/editors/editors.php';

abstract class SearchColumn
{
    private $fieldName;
    private $editorControl;
    private $secondEditorControl;
    private $caption;
    private $superGlobals;
    private $variableContainer;
    
    private $applyNotOperator;
    private $filterIndex;
    private $firstValue;
    private $secondValue;

    /** @var Captions */
    protected $localizerCaptions;

    protected function GetApplyNotOperator()
    {
        return $this->applyNotOperator;
    }

    protected function SetApplyNotOperator($value)
    {
        $this->applyNotOperator = $value;
    }

    protected function GetFilterIndex()
    {
        return $this->filterIndex;
    }
    
    protected function SetFilterIndex($value)
    {
        $this->filterIndex = $value;
    }

    public function __construct($fieldName, $caption, $stringLocalizer, SuperGlobals $superGlobals,
        IVariableContainer $variableContainer)
    {
        $this->fieldName = $fieldName;
        $this->localizerCaptions = $stringLocalizer;
        $this->editorControl = $this->CreateEditorControl();
        $this->secondEditorControl = $this->CreateSecondEditorControl();
        $this->caption = $caption;
        $this->superGlobals = $superGlobals;
        $this->variableContainer = $variableContainer;
    }

    public function GetCaption()
    {
        return $this->caption;
    }
    
    public function SetCaption($value)
    {
        $this->caption = $value;
    }

    protected abstract function CreateEditorControl();
    protected abstract function CreateSecondEditorControl();

    protected abstract function SetEditorControlValue($value);
    protected abstract function SetSecondEditorControlValue($value);

    public function GetFieldName()
    {
        return $this->fieldName;
    }

    public function GetAvailableFilterTypes()
    {
        return array();
    }

    public function GetActiveFilterType()
    {
        return '';
    }

    /**
     * @return CustomEditor
     */
    public function GetEditorControl()
    {
        return $this->editorControl;
    }

    /**
     * @return CustomEditor
     */
    public function GetSecondEditorControl()
    {
        return $this->secondEditorControl;
    }

    public function ExtractSearchValuesFromSession()
    {
        if ($this->superGlobals->IsSessionVariableSet('not_' . $this->GetFieldName()))
        {
            $this->applyNotOperator = $this->superGlobals->GetSessionVariable('not_' . $this->GetFieldName());
            $this->filterIndex = $this->superGlobals->GetSessionVariable('filtertype_' . $this->GetFieldName());
            $this->firstValue = $this->superGlobals->GetSessionVariable($this->GetEditorControl()->GetName());
            $this->secondValue = $this->superGlobals->GetSessionVariable($this->GetSecondEditorControl()->GetName());

            $this->SetEditorControlValue($this->firstValue);
            $this->SetSecondEditorControlValue($this->secondValue);
        }
    }

    private function SaveSearchValuesToSession()
    {
        $this->superGlobals->SetSessionVariable('not_' . $this->GetFieldName(), $this->applyNotOperator);
        $this->superGlobals->SetSessionVariable('filtertype_' . $this->GetFieldName(), $this->filterIndex);
        $this->superGlobals->SetSessionVariable($this->GetEditorControl()->GetName(), $this->firstValue);
        $this->superGlobals->SetSessionVariable($this->GetSecondEditorControl()->GetName(), $this->secondValue);
    }

    private function ResetSessionValues()
    {
        $this->superGlobals->UnSetSessionVariable('not_' . $this->GetFieldName());
        $this->superGlobals->UnSetSessionVariable('filtertype_' . $this->GetFieldName());
        $this->superGlobals->UnSetSessionVariable($this->GetEditorControl()->GetName());
        $this->superGlobals->UnSetSessionVariable($this->GetSecondEditorControl()->GetName());
    }

    public function GetFiterTypeInputName()
    {
        return 'filtertype_' . 
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName());
    }

    public function GetNotMarkInputName()
    {
        return 'not_' . 
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName());
    }

    public function ExtractSearchValuesFromPost()
    {
        $valueChanged = true;
        $this->applyNotOperator = GetApplication()->GetSuperGlobals()->IsPostValueSet($this->GetNotMarkInputName());
        $this->filterIndex = GetApplication()->GetSuperGlobals()->GetPostValue($this->GetFiterTypeInputName());
        $this->firstValue = $this->GetEditorControl()->ExtractsValueFromPost($valueChanged);
        $this->secondValue = $this->GetSecondEditorControl()->ExtractsValueFromPost($valueChanged);

        $this->SaveSearchValuesToSession();

        $this->SetEditorControlValue($this->firstValue);
        $this->SetSecondEditorControlValue($this->secondValue);
    }

    public function ResetFilter()
    {
        $this->applyNotOperator = null;
        $this->filterIndex = null;
        $this->firstValue = null;
        $this->secondValue = null;

        $this->ResetSessionValues();
    }

    public function GetFilterForField()
    {
        $result = null;
        $filter = null;
        if ($this->DoGetFilterForField($filter))
            $result = $filter;
        if (!isset($result) && isset($this->firstValue) && $this->firstValue != '')
        {
            if ($this->filterIndex == 'between')
                $result = new BetweenFieldFilter(
                    EnvVariablesUtils::EvaluateVariableTemplate($this->variableContainer, $this->firstValue),
                    EnvVariablesUtils::EvaluateVariableTemplate($this->variableContainer, $this->secondValue));
            elseif ($this->filterIndex == 'STARTS')
                $result = new FieldFilter(
                    EnvVariablesUtils::EvaluateVariableTemplate($this->variableContainer, $this->firstValue) .'%', 'ILIKE');
            elseif ($this->filterIndex == 'ENDS')
                $result = new FieldFilter(
                    '%'.EnvVariablesUtils::EvaluateVariableTemplate($this->variableContainer, $this->firstValue), 'ILIKE');
            elseif ($this->filterIndex == 'CONTAINS')
                $result = new FieldFilter(
                    '%'.EnvVariablesUtils::EvaluateVariableTemplate($this->variableContainer, $this->firstValue).'%', 'ILIKE');
            else
                $result = new FieldFilter(
                    EnvVariablesUtils::EvaluateVariableTemplate($this->variableContainer, $this->firstValue), $this->filterIndex);
        }
        if (isset($result) && $this->applyNotOperator)
            $result = new NotPredicateFilter($result);
        return $result;
    }

    protected function DoGetFilterForField(&$filter)
    {
        $filter = null;
        return false;
    }

    protected function GetValueForUserFriendlyCondition($originalValue)
    {
        return $originalValue;
    }

    public function GetUserFriendlyCondition()
    {
        $result = '';
        $filterTypes = $this->GetAvailableFilterTypes();
        if (isset($this->firstValue) && $this->firstValue != '')
        {
            if ($this->filterIndex == 'between')
                $result = sprintf("between <strong>%s</strong> and <strong>%s</strong>",
                        $this->GetValueForUserFriendlyCondition($this->firstValue),
                        $this->GetValueForUserFriendlyCondition($this->secondValue));
            else
                $result = $filterTypes[$this->filterIndex] . ' ' . '<b>'.
                        $this->GetValueForUserFriendlyCondition($this->firstValue)
                        .'</b>';
            if ($this->applyNotOperator)
                $result = $this->localizerCaptions->GetMessageString('Not') . ' (' . $result . ')';
        }
        return $result;
    }

    public function IsFilterActive()
    {
        $result = false;
        if (isset($this->filterIndex))
        {
            $result = isset($this->firstValue) && $this->firstValue != '';
            if ($this->filterIndex == 'between')
                $result = $result && isset($this->secondValue) && $this->secondValue != '';
        }
        return $result;
    }

    public function GetActiveFilterIndex()
    {
        return $this->filterIndex;
    }

    public function GetFilterValue()
    {
        return $this->firstValue;
    }

    public function IsApplyNotOperator()
    {
        return $this->applyNotOperator;
    }

    public function GetLocalizerCaptions()
    {
        return $this->localizerCaptions;
    }

}

class BlobSearchColumn extends SearchColumn
{
    protected function CreateEditorControl()
    {
        return new NullComponent($this->GetFieldName() . '_value');
    }

    protected function CreateSecondEditorControl()
    {
        return new NullComponent($this->GetFieldName() . '_secondvalue');
    }

    protected function SetEditorControlValue($value)
    { }
    
    protected function SetSecondEditorControlValue($value)
    { }

    public function GetAvailableFilterTypes()
    {
        return array(
            '' => '',
            'IS NULL' => $this->localizerCaptions->GetMessageString('isBlank'),
            'IS NOT NULL' => $this->localizerCaptions->GetMessageString('isNotBlank')
            );
    }

    public function IsFilterActive()
    {
        return $this->GetFilterIndex() != '';
    }

    public function GetFilterForField()
    {
        $result = null;
        if ($this->GetFilterIndex() != '')
        {
            if ($this->GetFilterIndex() == 'IS NULL')
                $result = new IsNullFieldFilter();
            elseif ($this->GetFilterIndex() == 'IS NOT NULL')
                $result = new NotPredicateFilter(new IsNullFieldFilter());
            if ($this->GetApplyNotOperator())
                $result = new NotPredicateFilter($result);
        }
        return $result;
    }

}

class StringSearchColumn extends SearchColumn
{
    protected function CreateEditorControl()
    {
        return new TextEdit(
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName()) .
            '_value');
    }

    protected function CreateSecondEditorControl()
    {
        return new TextEdit(
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName()) .
            '_secondvalue');
    }

    public function IsFilterActive()
    {
        if ($this->GetFilterIndex() == 'IS NULL')
            return true;
        else
            return parent::IsFilterActive();
    }

    protected function SetEditorControlValue($value)
    {
        $this->GetEditorControl()->SetValue($value);
    }

    protected function SetSecondEditorControlValue($value)
    {
        $this->GetSecondEditorControl()->SetValue($value);
    }

    protected function DoGetFilterForField(&$filter)
    {
        if ($this->GetFilterIndex() == 'IS NULL')
        {
            $filter = new IsNullFieldFilter();		
            return true;
        }
        $filter = null;
        return false;
    }

    public function GetUserFriendlyCondition()
    {
        if ($this->GetFilterIndex() == 'IS NULL')
        {
            $result = sprintf('is blank');
            if ($this->GetApplyNotOperator())
                $result = $this->localizerCaptions->GetMessageString('Not') . ' (' . $result . ')';
            return $result;
        }
        else
            return parent::GetUserFriendlyCondition();
    }

    public function GetAvailableFilterTypes()
    {
        return array(
            'LIKE' => $this->localizerCaptions->GetMessageString('Like'),
            'STARTS' => $this->localizerCaptions->GetMessageString('StartsWith'),
            'ENDS' => $this->localizerCaptions->GetMessageString('EndsWith'),
            'CONTAINS' => $this->localizerCaptions->GetMessageString('Contains'),
            'IS NULL' => $this->localizerCaptions->GetMessageString('isBlank'),
            'between' => $this->localizerCaptions->GetMessageString('between'),
            '='  => $this->localizerCaptions->GetMessageString('equals'),
            '<>' => $this->localizerCaptions->GetMessageString('doesNotEquals'),
            '>'  => $this->localizerCaptions->GetMessageString('isGreaterThan'),
            '>=' => $this->localizerCaptions->GetMessageString('isGreaterThanOrEqualsTo'),
            '<'  => $this->localizerCaptions->GetMessageString('isLessThan'),
            '<=' => $this->localizerCaptions->GetMessageString('isLessThanOrEqualsTo')
            );
    }
}

class DateTimeSearchColumn extends StringSearchColumn
{
    protected function CreateEditorControl()
    {
        return new DateTimeEdit(
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName()) .
            '_value', false, GetDefaultDateFormat());
    }

    protected function CreateSecondEditorControl()
    {
        return new DateTimeEdit(
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName()) . 
            '_secondvalue', false, GetDefaultDateFormat());
    }

    public function GetAvailableFilterTypes()
    {
        return array(
            '='  => $this->localizerCaptions->GetMessageString('equals'),
            'IS NULL' => $this->localizerCaptions->GetMessageString('isBlank'),
            'between' => $this->localizerCaptions->GetMessageString('between'),
            '<>' => $this->localizerCaptions->GetMessageString('doesNotEquals'),
            '>'  => $this->localizerCaptions->GetMessageString('isGreaterThan'),
            '>=' => $this->localizerCaptions->GetMessageString('isGreaterThanOrEqualsTo'),
            '<'  => $this->localizerCaptions->GetMessageString('isLessThan'),
            '<=' => $this->localizerCaptions->GetMessageString('isLessThanOrEqualsTo')
            );
    }    
}

class LookupSearchColumn extends StringSearchColumn
{
    /**
     * @var LinkBuilder
     */
    private $linkBuilder;

    /**
     * @var Dataset
     */
    private $lookupDataset;

    /**
     * @var string
     */
    private $idColumn;

    /**
     * @var string
     */
    private $valueColumn;

    /**
     * @var string
     */
    private $handlerName;

    /** @var boolean */
    private $useComboBox;

    public function __construct($fieldName, $caption, $stringLocalizer,
        SuperGlobals $superGlobals,
        IVariableContainer $variableContainer,
        LinkBuilder $linkBuilder,
        Dataset $lookupDataset,
        $idColumn, $valueColumn, $useComboBox = false)
    {
        $this->linkBuilder = $linkBuilder;
        $this->lookupDataset = $lookupDataset;
        $this->idColumn = $idColumn;
        $this->valueColumn = $valueColumn;
        $this->useComboBox = $useComboBox;
        $this->handlerName = StringUtils::ReplaceIllegalPostVariableNameChars($fieldName . '_advanced_search_lookup_handler');
        parent::__construct($fieldName, $caption, $stringLocalizer, $superGlobals, $variableContainer);

        GetApplication()->RegisterHTTPHandler(
            new LookupSearchColumnDataHandler($lookupDataset, $this->handlerName, $idColumn, $valueColumn)
        );

    }

    protected function CreateEditorControl()
    {
        $controlName = StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName()) . '_value';
        if (!$this->useComboBox)
        {
            $result = new AutocomleteComboBox($controlName, $this->linkBuilder);
            $result->SetHandlerName($this->handlerName);
            $result->SetSize('155px');
        }
        else
        {
            $result = new ComboBox($controlName, $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));

            $this->lookupDataset->Open();
            while ($this->lookupDataset->Next())
            {
                $result->AddValue(
                    $this->lookupDataset->GetFieldValueByName($this->idColumn),
                    $this->lookupDataset->GetFieldValueByName($this->valueColumn)
                );
            }
            $this->lookupDataset->CLose();
        }
        return $result;
    }

    protected function CreateSecondEditorControl()
    {
        $controlName = StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName()) . '_secondvalue';
        if (!$this->useComboBox)
        {
            $result = new AutocomleteComboBox($controlName, $this->linkBuilder);
            $result->SetHandlerName($this->handlerName);
            $result->SetSize('155px');
        }
        else
        {
            $result = new ComboBox($controlName, $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));

            $this->lookupDataset->Open();
            while ($this->lookupDataset->Next())
            {
                $result->AddValue(
                    $this->lookupDataset->GetFieldValueByName($this->idColumn),
                    $this->lookupDataset->GetFieldValueByName($this->valueColumn)
                );
            }
            $this->lookupDataset->CLose();
        }
        return $result;
    }

    private function GetDisplayValueById($idValue)
    {
        $result = '';
        $this->lookupDataset->AddFieldFilter($this->idColumn, new FieldFilter($idValue, '='));
        $this->lookupDataset->Open();
        if ($this->lookupDataset->Next())
        {
            $result = $this->lookupDataset->GetFieldValueByName($this->valueColumn);
        }
        $this->lookupDataset->CLose();
        $this->lookupDataset->ClearFieldFilters();
        return $result;
    }

    protected function SetEditorControlValue($value)
    {
        parent::SetEditorControlValue($value);

        if (!$this->useComboBox)
        {
            $this->lookupDataset->AddFieldFilter($this->idColumn, new FieldFilter($value, '='));
            $this->lookupDataset->Open();
            if ($this->lookupDataset->Next())
            {
                /** @var AutocomleteComboBox $editorControl */
                $editorControl = $this->GetEditorControl();
                $editorControl->SetDisplayValue($this->lookupDataset->GetFieldValueByName($this->valueColumn));
            }
            $this->lookupDataset->CLose();
            $this->lookupDataset->ClearFieldFilters();
        }
    }

    protected function SetSecondEditorControlValue($value)
    {
        parent::SetSecondEditorControlValue($value);

        if (!$this->useComboBox)
        {
            $this->lookupDataset->AddFieldFilter($this->idColumn, new FieldFilter($value, '='));
            $this->lookupDataset->Open();
            if ($this->lookupDataset->Next())
            {
                /** @var AutocomleteComboBox $editorControl */
                $editorControl = $this->GetSecondEditorControl();
                $editorControl->SetDisplayValue($this->lookupDataset->GetFieldValueByName($this->valueColumn));
            }
            $this->lookupDataset->CLose();
            $this->lookupDataset->ClearFieldFilters();
        }
    }

    protected function GetValueForUserFriendlyCondition($originalValue)
    {
        return $this->GetDisplayValueById($originalValue);
    }

    public function GetAvailableFilterTypes()
    {
        return array(
            '='  => $this->localizerCaptions->GetMessageString('equals'),
            'IS NULL' => $this->localizerCaptions->GetMessageString('isBlank')
            );
    }
}

class LookupSearchColumnDataHandler extends HTTPHandler
{
    /**
     * @var \Dataset
     */
    private $dataset;

    /**
     * @var string
     */
    private $idField;

    /**
     * @var string
     */
    private $valueField;

    /**
     * @param Dataset $dataset
     * @param string $name
     * @param string $idField
     * @param string $valueField
     */
    public function __construct(Dataset $dataset, $name, $idField, $valueField)
    {
        parent::__construct($name);
        $this->dataset = $dataset;
        $this->idField = $idField;
        $this->valueField = $valueField;
    }

    /**
     * @param Renderer $renderer
     * @return void
     */
    public function Render(Renderer $renderer)
    {
        if (GetApplication()->GetSuperGlobals()->IsGetValueSet('term'))
        {
            $this->dataset->AddFieldFilter(
                $this->valueField,
                new FieldFilter('%'.GetApplication()->GetSuperGlobals()->GetGetValue('term').'%', 'ILIKE', true)
            );
        }

        $this->dataset->Open();

        $result = array();

        $highLightCallback = Delegate::CreateFromMethod($this, 'ApplyHighlight')->Bind(array(
            Argument::$Arg3 => $this->valueField,
            Argument::$Arg4 => GetApplication()->GetSuperGlobals()->GetGetValue('term')
        ));
        $this->dataset->SetLimit(20);

        while ($this->dataset->Next())
        {
            $result[] = array(
                "id" => $this->dataset->GetFieldValueByName($this->idField),
                "label" => (
                            $highLightCallback->Call(
                                $this->dataset->GetFieldValueByName($this->valueField),
                                $this->valueField
                            )
                ),
                "value" => $this->dataset->GetFieldValueByName($this->valueField)
            );
        }

        echo SystemUtils::ToJSON($result);

        $this->dataset->Close();
    }

    public function ApplyHighlight($value, $currentFieldName, $displayFieldName, $term)
    {
        if ($currentFieldName == $displayFieldName && !StringUtils::IsNullOrEmpty($term))
        {
            $patterns = array();
            $patterns[0] = '/(' . preg_quote($term) . ')/i';
            $replacements = array();
            $replacements[0] = '<em class="highlight_autocomplete">' . '$1' . '</em>';
            return preg_replace($patterns, $replacements, $value);
        }
        else
            return $value;
    }
}

class AdvancedSearchControl
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Dataset
     */
    private $dataset;

    /** @var SearchColumn[] */
    private $columns;

    /**
     * @var boolean
     */
    private $applyAndOperator;

    /**
     * @var string
     */
    private $target;

    /**
     * @var boolean
     */
    private $hidden;

    /**
     * @var Captions
     */
    private $stringLocalizer;

    /**
     * @var boolean
     */
    private $allowOpenInNewWindow;

    /** @var boolean */
    private $openInNewWindowLink;

    /** @var \IVariableContainer */
    private $variableContainer;

    /** @var \LinkBuilder */
    private $linkBuilder;
    
    public function __construct($name, $dataset, $stringLocalizer, IVariableContainer $variableContainer, LinkBuilder $linkBuilder)
    {
        $this->name = $name;
        $this->dataset = $dataset;
        $this->stringLocalizer = $stringLocalizer;
        //
        $this->columns = array();
        $this->applyAndOperator = null;
        $this->isActive = false;
        $this->hidden = true;
        $this->target = '';
        $this->allowOpenInNewWindow = true;
        $this->variableContainer = $variableContainer;
        $this->linkBuilder = $linkBuilder;
    }

    #region Factory methods

    public function CreateLookupSearchInput($fieldName, $caption, Dataset $lookupDataset, $idColumn, $valueColumn, $useComboBox = false)
    {
        return new LookupSearchColumn($fieldName, $caption, $this->stringLocalizer,
            new SuperGlobals($this->name), $this->variableContainer, $this->linkBuilder->CloneLinkBuilder(),
            $lookupDataset, $idColumn, $valueColumn, $useComboBox
        );
    }

    public function CreateDateTimeSearchInput($fieldName, $caption)
    {
        return new DateTimeSearchColumn($fieldName, $caption, $this->stringLocalizer,
            new SuperGlobals($this->name), $this->variableContainer
        );
    }

    public function CreateStringSearchInput($fieldName, $caption)
    {
        return new StringSearchColumn($fieldName, $caption, $this->stringLocalizer, 
            new SuperGlobals($this->name), $this->variableContainer
        );
    }

    public function CreateBlobSearchInput($fieldName, $caption)
    {
        return new BlobSearchColumn($fieldName, $caption, $this->stringLocalizer,
            new SuperGlobals($this->name), $this->variableContainer
        );
    }

    #endregion

    #region Options

    public function GetTarget()
    {
        return $this->target;
    }

    public function SetTarget($value)
    {
        $this->target = $value;
    }

    public function SetAllowOpenInNewWindow($value)
    {
        $this->allowOpenInNewWindow = $value;
    }

    public function GetAllowOpenInNewWindow()
    {
        return $this->allowOpenInNewWindow;
    }

    public function GetOpenInNewWindowLink()
    {
        return $this->openInNewWindowLink;
    }

    public function SetOpenInNewWindowLink($value)
    {
        $this->openInNewWindowLink = $value;
    }

    public function SetHidden($value)
    {
        $this->hidden = $value;
    }

    public function GetHidden()
    {
        return $this->hidden;
    }

    #endregion

    /**
     * @param Renderer $renderer
     * @return void
     */
    public function Accept($renderer)
    {
        $renderer->RenderAdvancedSearchControl($this);
    }

    public function AddSearchColumn($column)
    {
        $this->columns[] = $column;
    }

    public function GetSearchColumns()
    {
        return $this->columns;
    }
    
    public function GetIsApplyAndOperator()
    {
        return $this->applyAndOperator;
    }

    private function ResetFilter()
    {
        foreach($this->columns as $column)
            $column->ResetFilter();
        $this->applyAndOperator = null;
        GetApplication()->UnSetSessionVariable($this->name . 'SearchType');
    }

    private function ExtractValuesFromSession()
    {
        foreach($this->columns as $column)
            $column->ExtractSearchValuesFromSession();
        $this->applyAndOperator = GetApplication()->GetSessionVariable($this->name . 'SearchType');
    }

    private function ExtractValuesFromPost()
    {
        foreach($this->columns as $column)
            $column->ExtractSearchValuesFromPost();
        $this->applyAndOperator = GetApplication()->GetPOSTValue('SearchType') == 'and';
        GetApplication()->SetSessionVariable($this->name . 'SearchType', $this->applyAndOperator);
    }

    private function ApplyFilterToDataset()
    {
        $fieldNames = array();
        $fieldFilters = array();

        foreach($this->columns as $column)
            if ($column->IsFilterActive())
            {
                $fieldNames[] = $column->GetFieldName();
                $fieldFilters[] = $column->GetFilterForField();
            }

        if (count($fieldFilters) > 0)
            $this->dataset->AddCompositeFieldFilter(
                $this->applyAndOperator ? 'AND' : 'OR',
                $fieldNames,
                $fieldFilters);
        $this->isActive = (count($fieldFilters) > 0);
    }

    public function GetUserFriendlySearchConditions()
    {
        $result = array();

        foreach($this->columns as $column)
            if ($column->IsFilterActive())
            {
                $result[] = array(
                    'Caption' => $column->GetCaption(),
                    'Condition' => $column->GetUserFriendlyCondition()
                    );
            }
        return $result;
    }

    public function IsActive()
    {
        return $this->isActive;
    }

    public function HasCondition()
    {
        if ((GetApplication()->IsPOSTValueSet('ResetFilter') && GetApplication()->GetPOSTValue('ResetFilter') == '1') || (GetApplication()->IsPOSTValueSet('operation') && GetApplication()->GetPOSTValue('operation') == 'ssearch'))
            return false;
        else
        {
            return 
                GetApplication()->IsPOSTValueSet('SearchType') ||
                GetApplication()->IsSessionVariableSet($this->name . 'SearchType');
        }
    }

    public function ProcessMessages()
    {
        if ((GetApplication()->IsPOSTValueSet('ResetFilter') && GetApplication()->GetPOSTValue('ResetFilter') == '1') || (GetApplication()->IsPOSTValueSet('operation') && GetApplication()->GetPOSTValue('operation') == 'ssearch'))
        {
            $this->ResetFilter();
        }
        else
        {
            if (GetApplication()->IsSessionVariableSet($this->name . 'SearchType'))
                $this->ExtractValuesFromSession();

            if (GetApplication()->IsPOSTValueSet('SearchType'))
                $this->ExtractValuesFromPost();

            if (isset($this->applyAndOperator))
                $this->ApplyFilterToDataset();
        }
    }

    #region Client Highlighting
    private function IsFilterTypeAllowsHighlighting($filterType)
    {
        in_array($filterType,
            array('LIKE', '=', 'STARTS', 'ENDS', 'CONTAINS')
            );
    }

    public function GetHighlightedFields()
    {
        $result = array();
        foreach($this->columns as $column)
            if (
                $column->IsFilterActive() &&
                    $this->IsFilterTypeAllowsHighlighting($column->GetActiveFilterIndex())
                )
                $result[] = $column->GetFieldName();
        return $result;
    }

    public function GetHighlightedFieldText()
    {
        $result = array();
        foreach($this->columns as $column)
            if ($column->IsFilterActive() && (
                ($column->GetActiveFilterIndex() == 'LIKE') ||
                ($column->GetActiveFilterIndex() == '=') ||
                ($column->GetActiveFilterIndex() == 'STARTS') ||
                ($column->GetActiveFilterIndex() == 'ENDS') ||
                ($column->GetActiveFilterIndex() == 'CONTAINS')
                ))
                $result[] = str_replace('%', '', $column->GetFilterValue());
        return $result;
    }

    public function GetHighlightedFieldOptions()
    {
        $result = array();
        foreach($this->columns as $column)
            if ($column->IsFilterActive() && (
                ($column->GetActiveFilterIndex() == 'LIKE') ||
                ($column->GetActiveFilterIndex() == '=')  ||
                ($column->GetActiveFilterIndex() == 'STARTS') ||
                ($column->GetActiveFilterIndex() == 'ENDS') ||
                ($column->GetActiveFilterIndex() == 'CONTAINS')
                ))
            {
                $trimmed = trim($column->GetFilterValue());
                if ($column->GetActiveFilterIndex() == 'LIKE')
                {
                    if ($trimmed[0] == '%' && $trimmed[strlen($trimmed) - 1] == '%')
                        $result[] =  'ALL';
                    elseif ($trimmed[0] == '%')
                        $result[] =  'END';
                    elseif ($trimmed[strlen($trimmed) - 1] == '%')
                        $result[] =  'START';
                }
                elseif ($column->GetActiveFilterIndex() == 'STARTS')
                    $result[] = 'START';
                elseif ($column->GetActiveFilterIndex() == 'ENDS')
                    $result[] = 'END';
                elseif ($column->GetActiveFilterIndex() == 'CONTAINS')
                    $result[] = 'ALL';
                else
                    $result[] =  'ALL';
            }
        return $result;
    }

    #endregion
}
?>
