<?php

require_once 'components/renderers/renderer.php';
require_once 'components/component.php';
require_once 'components/editors/editors.php';
require_once 'components/editors/multilevel_selection.php';

define('otAscending', 1);
define('otDescending', 2);

function GetOrderTypeAsSQL($orderType)
{
    return $orderType == otAscending ? 'ASC' : 'DESC';
}

$orderTypeCaptions = array(
    otAscending  => 'a',
    otDescending => 'd');

abstract class GridState
{
    /**
     * @var Grid
     */
    protected $grid;

    public function __construct($Grid)
    {
        $this->grid = $Grid;
    }

    protected function GetPage()
    {
        return $this->grid->GetPage();
    }

    protected function ChangeState($stateIdentifier)
    {
        GetApplication()->SetOperation($stateIdentifier);
        $this->grid->SetState($stateIdentifier);
    }

    protected function ApplyState($stateIdentifier)
    {
        $this->ChangeState($stateIdentifier);
        $this->grid->GetState()->ProcessMessages();
    }

    protected function GetDataset()
    {
        return $this->grid->GetDataset();
    }

    /**
     * @param array $oldValues associative array (fieldNames => fieldValues) of old values
     * @param array $newValues associative array (fieldNames => fieldValues) of new values
     * @param Dataset $dataset dataset where changes between old and new values must be written
     */
    protected function WriteChangesToDataset($oldValues, $newValues, Dataset $dataset)
    {
        foreach($newValues as $fieldName => $fieldValue)
            if (!isset($oldValues[$fieldName]) || ($oldValues[$fieldName] != $fieldValue))
                $dataset->SetFieldValueByName($fieldName, $fieldValue);
    }

    protected function SetGridSimpleErrorMessage($message, $decodeMessage = true)
    {
        if ($decodeMessage)
            $this->grid->SetErrorMessage($this->GetPage()->RenderText($message));
        else
            $this->grid->SetErrorMessage($message);
    }

    /**
     * @param Exception $exception
     * @return string
     */
    protected function ExceptionToErrorMessage($exception)
    {
        $result = $exception->getMessage();
        if (defined('DEBUG_LEVEL') && DEBUG_LEVEL > 0)
            $result .= '<br>Program trace: <br>'.FormatExceptionTrace($exception);
        return $result;
    }

    /**
     * @param SMException[] $exceptions
     * @return string
     */
    protected function ExceptionsToErrorMessage($exceptions)
    {
        $result = '';
        foreach($exceptions as $exception)
        {
            if (is_subclass_of($exception, 'SMException'))
                AddStr($result, $exception->getLocalizedMessage($this->GetPage()->GetLocalizerCaptions()), '<br><br>');
            else
                AddStr($result, $exception->getMessage(), '<br><br>');

            if (defined('DEBUG_LEVEL') && DEBUG_LEVEL > 0)
                $result .= '<br>Program trace: <br>'.FormatExceptionTrace($exception);
        }
        return $result;
    }

    protected function SetGridErrorMessage($exception)
    {
        $this->SetGridSimpleErrorMessage(
            $this->ExceptionToErrorMessage($exception), false);
    }

    protected function SetGridErrorMessages($exceptions)
    {
        $this->SetGridSimpleErrorMessage(
            $this->ExceptionsToErrorMessage($exceptions), false);
    }

    protected function DoCanChangeData(&$rowValues, &$message)
    {
        return true;
    }

    protected function CanChangeData(&$rowValues, &$message)
    {
        $cancel = false;
        $this->grid->OnBeforeDataChange->Fire(array($this->grid->GetPage(), &$rowValues, &$cancel, &$message));
        return !$cancel && $this->DoCanChangeData($rowValues, $message);
    }

    public abstract function ProcessMessages();
}

class DeleteSelectedGridState extends GridState
{
    protected function DoCanChangeData(&$rowValues, &$message)
    {
        $cancel = false;
        $this->grid->BeforeDeleteRecord->Fire(array($this->GetPage(), &$rowValues, &$cancel, &$message,
                                                   $this->GetDataset()->GetName()));
        return !$cancel;
    }

    public function ProcessMessages()
    {
        $primaryKeysArray = array();
        for($i = 0; $i < GetApplication()->GetPOSTValue('recordCount'); $i++)
        {
            if (GetApplication()->IsPOSTValueSet('rec'.$i))
            {
                // TODO : move GetPrimaryKeyFieldNames function to private
                $primaryKeys = array();
                $primaryKeyNames = $this->grid->GetDataset()->GetPrimaryKeyFieldNames();
                for($j = 0; $j < count($primaryKeyNames); $j++)
                    $primaryKeys[] = GetApplication()->GetPOSTValue('rec' . $i . '_pk' . $j);
                $primaryKeysArray[] = $primaryKeys;
            }
        }
        
        $inlineInsertedRecordPrimaryKeyNames = GetApplication()->GetSuperGlobals()->GetPostVariablesIf(
            create_function('$str', 'return StringUtils::StartsWith($str, \'inline_inserted_rec_\') && !StringUtils::Contains($str, \'pk\');')
            );
        
        foreach($inlineInsertedRecordPrimaryKeyNames as $name => $value)
        {
            $primaryKeys = array();
            $primaryKeyNames = $this->grid->GetDataset()->GetPrimaryKeyFieldNames();
            for($i = 0; $i < count($primaryKeyNames); $i++)
                $primaryKeys[] = GetApplication()->GetSuperGlobals()->GetPostValue($name . '_pk' . $i);
            $primaryKeysArray[] = $primaryKeys;
        }        

        foreach($primaryKeysArray as $primaryKeyValues)
        {
            $this->grid->GetDataset()->SetSingleRecordState($primaryKeyValues);
            $this->grid->GetDataset()->Open();

            if ($this->grid->GetDataset()->Next())
            {
                $message = '';

                $fieldValues = $this->grid->GetDataset()->GetCurrentFieldValues();
                if ($this->CanChangeData($fieldValues, $message))
                {
                    try
                    {
                        $this->grid->GetDataset()->Delete();
                    }
                    catch(Exception $e)
                    {
                        $this->grid->GetDataset()->SetAllRecordsState();
                        $this->ChangeState(OPERATION_VIEWALL);
                        $this->SetGridErrorMessage($e);
                        return;
                    }
                }
                else
                {
                    $this->grid->GetDataset()->SetAllRecordsState();
                    $this->ChangeState(OPERATION_VIEWALL);
                    $this->SetGridSimpleErrorMessage($message);
                    return;
                }
            }
            $this->grid->GetDataset()->Close();
        }
        
        $this->ApplyState(OPERATION_VIEWALL);
    }
}

class ViewAllGridState extends GridState
{
    function ProcessMessages()
    {
        /* $primaryKeyValues = array();
        ExtractPrimaryKeyValues($primaryKeyValues, METHOD_GET);
        if (count($primaryKeyValues) > 0)
            $this->grid->GetDataset()->SetSingleRecordState($primaryKeyValues);
        */
        $orderColumn = $this->grid->GetOrderColumnFieldName();
        $orderType = $this->grid->GetOrderType();
        if (isset($orderType) && isset($orderColumn))
            $this->grid->GetDataset()->SetOrderBy($orderColumn, GetOrderTypeAsSQL($orderType));

        foreach( $this->grid->GetViewColumns() as $column)
            $column->ProcessMessages();
    }
}

class OpenInlineInsertEditorsGridState extends GridState
{
    private $nameSuffix;

    function ProcessMessages()
    {
        $this->nameSuffix = '_inline_' . mt_rand();
        
        $columns = $this->grid->GetViewColumns();
        foreach($columns as $column)
        {
            $inlineEditColumn = $column->GetInsertOperationColumn();
            if (isset($inlineEditColumn))
            {
                $editControl = $inlineEditColumn->GetEditControl();
                $editControl->SetName($editControl->GetName() . $this->GetNameSuffix());
                $inlineEditColumn->ProcessMessages();
            }
        }
    }

    public function GetNameSuffix()
    {
        return $this->nameSuffix;
    }
}

class OpenInlineEditorsGridState extends GridState
{
    private $nameSuffix;

    function ProcessMessages()
    {
        $primaryKeyValues = $this->grid->GetPrimaryKeyValuesFromGet();

        $this->nameSuffix = '_inline_' . mt_rand();

        $this->grid->GetDataset()->SetSingleRecordState($primaryKeyValues);
        $this->grid->GetDataset()->Open();
        
        if ($this->grid->GetDataset()->Next())
        {
            $columns = $this->grid->GetViewColumns();
            foreach($columns as $column)
            {
                $inlineEditColumn = $column->GetEditOperationColumn();
                if (isset($inlineEditColumn))
                {
                    $editControl = $inlineEditColumn->GetEditControl();
                    $editControl->SetName($editControl->GetName() . $this->GetNameSuffix());
                }
            }
            array_walk($columns, create_function('$column', '$column->ProcessMessages();'));
        }
        
        //$this->grid->GetDataset()->Close();
    }

    public function GetNameSuffix()
    {
        return $this->nameSuffix;
    }
}

class EditGridState extends GridState
{
    function ProcessMessages()
    {
        $primaryKeyValues = $this->grid->GetPrimaryKeyValuesFromGet();

        $this->grid->GetDataset()->SetSingleRecordState($primaryKeyValues);
        $this->grid->GetDataset()->Open();

        if ($this->grid->GetDataset()->Next())
        {
            $columns = $this->grid->GetEditColumns();
            array_walk($columns, create_function('$column', '$column->ProcessMessages();'));
        }
        $this->grid->GetDataset()->Close();
    }
}

class CopyGridState extends GridState
{
    function ProcessMessages()
    {
        $primaryKeyValues = $this->grid->GetPrimaryKeyValuesFromGet();

        $this->grid->GetDataset()->SetSingleRecordState($primaryKeyValues);
        $this->grid->GetDataset()->Open();

        if ($this->grid->GetDataset()->Next())
            foreach($this->grid->GetInsertColumns() as $column)
                $column->ProcessMessages();
    }
}

class InsertGridState extends GridState
{
    function ProcessMessages()
    {
        foreach($this->grid->GetInsertColumns() as $column)
            $column->ProcessMessages();
    }
}

abstract class CommitValuesGridState extends GridState
{

}

class CommitNewValuesGridState extends CommitValuesGridState
{
    protected function DoCanChangeData(&$rowValues, &$message)
    {
        $cancel = false;
        $this->grid->BeforeInsertRecord->Fire(array($this->GetPage(), &$rowValues, &$cancel, &$message,
                                              $this->GetDataset()->GetName()));
        return !$cancel;
    }

    function ProcessMessages()
    {
        $this->grid->GetDataset()->Insert();

        $exceptions = array();
        foreach($this->grid->GetInsertColumns() as $column)
        {
            try
            {
                $column->ProcessMessages();
            }
            catch(Exception $e)
            {
                $exceptions[] = $e;
            }
        }
        foreach($this->grid->GetInsertColumns() as $column)
        {
            try
            {
                $column->AfterSetAllDatasetValues();
            }
            catch(Exception $e)
            {
                $exceptions[] = $e;
            }
        }

            
        $message = '';
        $oldFieldValues = $this->GetDataset()->GetCurrentFieldValues();
        $fieldValues = $this->GetDataset()->GetCurrentFieldValues();
        if ($this->CanChangeData($fieldValues, $message))
        {
            if (count($exceptions) > 0)
            {
                $this->ChangeState(OPERATION_INSERT);
                $this->SetGridErrorMessages($exceptions);
                return;
            }
            try
            {
                $this->WriteChangesToDataset($oldFieldValues, $fieldValues, $this->GetDataset());
                $this->GetDataset()->Post();
            }
            catch(Exception $e)
            {
                $this->ChangeState(OPERATION_INSERT);
                $columns = $this->grid->GetInsertColumns();
                array_walk($columns, create_function('$column', '$column->PrepareEditorControl();'));
                $this->SetGridErrorMessage($e);
                return;
            }
        }
        else
        {
            $this->ChangeState(OPERATION_INSERT);
            $this->SetGridSimpleErrorMessage($message);
            $columns = $this->grid->GetInsertColumns();
            array_walk($columns, create_function('$column', '$column->PrepareEditorControl();'));
            return;
        }
        $this->ApplyState(OPERATION_VIEWALL);
    }
}

class CommitEditedValueGridState extends CommitValuesGridState
{
    protected function DoCanChangeData(&$rowValues, &$message)
    {
        $cancel = false;
        $this->grid->BeforeUpdateRecord->Fire(array($this->GetPage(), &$rowValues, &$cancel, &$message,
            $this->GetDataset()->GetName()));
        return !$cancel;
    }

    private function HandleError($message, $decode = true)
    {
        $this->ChangeState(OPERATION_EDIT);
        $this->SetGridSimpleErrorMessage($message, $decode);
        $columns = $this->grid->GetEditColumns();
        array_walk($columns, create_function('$column', '$column->PrepareEditorControl();'));
        $this->GetDataset()->Close();
    }

    public function ProcessMessages()
    {
        $primaryKeyValues = array();
        ExtractPrimaryKeyValues($primaryKeyValues, METHOD_POST);

        $this->GetDataset()->SetSingleRecordState($primaryKeyValues);
        $this->GetDataset()->Open();
        
        if ($this->GetDataset()->Next())
        {
            $this->GetDataset()->Edit();

            $exceptions = array();
            foreach($this->grid->GetEditColumns() as $column)
            {
                try
                {
                    $column->ProcessMessages();
                }
                catch(Exception $e)
                {
                    $exceptions[] = $e;
                }
            }
            foreach($this->grid->GetEditColumns() as $column)
            {
                try
                {
                    $column->AfterSetAllDatasetValues();
                }
                catch(Exception $e)
                {
                    $exceptions[] = $e;
                }
            }


            $message = '';
            $oldFieldValues = array_merge($this->GetDataset()->GetFieldValues(), $this->GetDataset()->GetCurrentFieldValues());
            $fieldValues = array_merge($this->GetDataset()->GetFieldValues(), $this->GetDataset()->GetCurrentFieldValues());


            if ($this->CanChangeData($fieldValues, $message))
            {
                if (count($exceptions) > 0)
                {
                    $this->HandleError($this->ExceptionsToErrorMessage($exceptions), false);
                    return;
                }
                try
                {
                    $this->WriteChangesToDataset($oldFieldValues, $fieldValues, $this->GetDataset());
                    $this->GetDataset()->Post();
                }
                catch(Exception $e)
                {
                    $this->HandleError($this->ExceptionToErrorMessage($e), false);
                    return;
                }
            }
            else
            {
                $this->HandleError($message, true);
                return;
            }
            $this->grid->GetDataset()->Close();
        }
        $this->ApplyState(OPERATION_VIEWALL);
    }
}

class CommitInlineInsertedValuesGridState extends CommitValuesGridState
{
    protected function DoCanChangeData(&$rowValues, &$message)
    {
        $cancel = false;
        $this->grid->BeforeInsertRecord->Fire(array($this->GetPage(), &$rowValues, &$cancel, &$message,
                                                   $this->GetDataset()->GetName()));
        return !$cancel;
    }

    private function HandleError($message, $decode = true)
    {
        $this->SetGridSimpleErrorMessage($message, $decode);
        array_walk($this->GetColumns(), create_function('$column', '$column->PrepareEditorControl();'));
    }

    /**
     * @return CustomEditColumn[]
     */
    private function GetColumns()
    {
        $result = array();

        foreach($this->grid->GetViewColumns() as $column)
        {
            $editColumn = $column->GetInsertOperationColumn();
            if (isset($editColumn))
                $result[] = $editColumn;
        }
        return $result;
    }
 
    public function ProcessMessages()
    {
        $nameSuffix = ExtractInputValue('namesuffix', METHOD_POST);
        $columns = $this->grid->GetViewColumns();
        foreach($columns as $column)
        {
            $inlineEditColumn = $column->GetInsertOperationColumn();
            if (isset($inlineEditColumn))
            {
                $editControl = $inlineEditColumn->GetEditControl();
                $editControl->SetName($editControl->GetName() . $nameSuffix);
            }
        }

        $this->GetDataset()->Insert();

        $exceptions = array();

        foreach($this->GetColumns() as $column)
        {
            try
            {
                $column->ProcessMessages();
            }
            catch(Exception $e)
            {
                $exceptions[] = $e;
            }
        }

        foreach($this->GetColumns() as $column)
        {
            try
            {
                $column->AfterSetAllDatasetValues();
            }
            catch(Exception $e)
            {
                $exceptions[] = $e;
            }
        }


        $message = '';
        $oldFieldValues = $this->GetDataset()->GetCurrentFieldValues();
        $fieldValues = $this->GetDataset()->GetCurrentFieldValues();

        if ($this->CanChangeData($fieldValues, $message))
        {
            if (count($exceptions) > 0)
            {
                $this->HandleError($this->ExceptionsToErrorMessage($exceptions), false);
                return;
            }
            try
            {
                $this->WriteChangesToDataset($oldFieldValues, $fieldValues, $this->GetDataset());
                $this->GetDataset()->Post();

                $primaryKeyValues = $this->GetDataset()->GetPrimaryKeyValues();
                $this->GetDataset()->SetSingleRecordState($primaryKeyValues);
                $this->GetDataset()->Open();
                $this->GetDataset()->Next();
            }
            catch(Exception $e)
            {
                $this->HandleError($this->ExceptionToErrorMessage($e), false);
                return;
            }
        }
        else
        {
            $this->HandleError($message, true);
            return;
        }
    
    }
}

class CommitInlineEditedValuesGridState extends CommitValuesGridState
{
    protected function DoCanChangeData(&$rowValues, &$message)
    {
        $cancel = false;
        $this->grid->BeforeUpdateRecord->Fire(array($this->GetPage(), &$rowValues, &$cancel, &$message,
                                              $this->GetDataset()->GetName()));
        return !$cancel;
    }

    private function HandleError($message, $decode = true)
    {
        $this->SetGridSimpleErrorMessage($message, $decode);
        array_walk($this->GetColumns(), create_function('$column', '$column->PrepareEditorControl();'));
        $this->GetDataset()->Close();
    }

    /**
     * @return CustomEditColumn[]
     */
    private function GetColumns()
    {
        $result = array();

        foreach($this->grid->GetViewColumns() as $column)
        {
            $editColumn = $column->GetEditOperationColumn();
            if (isset($editColumn))
                $result[] = $editColumn;
        }
        return $result;
    }

    public function ProcessMessages()
    {
        $primaryKeyValues = array();
        ExtractPrimaryKeyValues($primaryKeyValues, METHOD_POST);
        
        $nameSuffix = ExtractInputValue('namesuffix', METHOD_POST);
        $columns = $this->grid->GetViewColumns();
        foreach($columns as $column)
        {
            $inlineEditColumn = $column->GetEditOperationColumn();
            if (isset($inlineEditColumn))
            {
                $editControl = $inlineEditColumn->GetEditControl();
                $editControl->SetName($editControl->GetName() . $nameSuffix);
            }
        }

        $this->GetDataset()->SetSingleRecordState($primaryKeyValues);
        $this->GetDataset()->Open();

        if ($this->GetDataset()->Next())
        {
            
            $this->GetDataset()->Edit();

            $exceptions = array();

            foreach($this->GetColumns() as $column)
            {
                try
                {
                    $column->ProcessMessages();
                }
                catch(Exception $e)
                {
                    $exceptions[] = $e;
                }
            }
            foreach($this->GetColumns() as $column)
            {
                try
                {
                    $column->AfterSetAllDatasetValues();
                }
                catch(Exception $e)
                {
                    $exceptions[] = $e;
                }
            }

            $message = '';
            $oldFieldValues = array_merge($this->GetDataset()->GetFieldValues(), $this->GetDataset()->GetCurrentFieldValues());
            $fieldValues = array_merge($this->GetDataset()->GetFieldValues(), $this->GetDataset()->GetCurrentFieldValues());

            if ($this->CanChangeData($fieldValues, $message))
            {
                if (count($exceptions) > 0)
                {
                    $this->HandleError($this->ExceptionsToErrorMessage($exceptions), false);
                    return;
                }
                try
                {
                    $this->WriteChangesToDataset($oldFieldValues, $fieldValues, $this->GetDataset());
                    
                    $primaryKeyValues = $this->GetDataset()->GetPrimaryKeyValues();
                    $this->GetDataset()->Post();
                    $this->GetDataset()->Close();
                    $this->GetDataset()->SetSingleRecordState($primaryKeyValues);
                }
                catch(Exception $e)
                {
                    $this->HandleError($this->ExceptionToErrorMessage($e), false);
                    return;
                }
            }
            else
            {
                $this->HandleError($message, true);
                return;
            }
            $this->grid->GetDataset()->Close();
            $this->GetDataset()->SetSingleRecordState($primaryKeyValues);
        }
    }
}

class DeleteGridState extends GridState
{
    public function ProcessMessages()
    {
        $primaryKeyValues = array();
        ExtractPrimaryKeyValues($primaryKeyValues, METHOD_GET);
        $this->grid->GetDataset()->SetSingleRecordState($primaryKeyValues);
    }
}

class ViewGridState extends GridState
{
    public function ProcessMessages()
    {
        $primaryKeyValues = array();
        ExtractPrimaryKeyValues($primaryKeyValues, METHOD_GET);
        $this->grid->GetDataset()->SetSingleRecordState($primaryKeyValues);
    }
}

class CommitDeleteGridState extends GridState
{
    private $useGetToExtractPrimaryKeys = false;

    protected function DoCanChangeData(&$rowValues, &$message)
    {
        $cancel = false;
        $this->grid->BeforeDeleteRecord->Fire(array($this->GetPage(), &$rowValues, &$cancel, &$message,
                                              $this->GetDataset()->GetName()));
        return !$cancel;
    }

    public function ProcessMessages()
    {
        $primaryKeyValues = array();
        if ($this->useGetToExtractPrimaryKeys)
            ExtractPrimaryKeyValues($primaryKeyValues, METHOD_GET);
        else
            ExtractPrimaryKeyValues($primaryKeyValues, METHOD_POST);

        $this->grid->GetDataset()->SetSingleRecordState($primaryKeyValues);
        $this->grid->GetDataset()->Open();

        if ($this->grid->GetDataset()->Next())
        {

            $message = '';
            $fieldValues = $this->grid->GetDataset()->GetCurrentFieldValues();
            if ($this->CanChangeData($fieldValues, $message))
            {
                try
                {
                    $this->grid->GetDataset()->Delete();
                }
                catch(Exception $e)
                {
                    
                    $this->ChangeState(OPERATION_DELETE);
                    $this->SetGridErrorMessage($e);
                    return;
                }
            }
            else
            {
                $this->ChangeState(OPERATION_DELETE);
                $this->SetGridSimpleErrorMessage($message);
                return;
            }
        }
        $this->grid->GetDataset()->Close();

        $this->grid->GetDataset()->Open();
        $this->ApplyState(OPERATION_VIEWALL);
    }

    public function SetUseGetToExtractPrimaryKeys($value)
    {
        $this->useGetToExtractPrimaryKeys = $value;
    }
}

class GridBand
{
    private $name;
    private $caption;
    private $columns;
    private $useConsolidatedHeader;

    public function  __construct($name, $caption, $useConsolidatedHeader = false)
    {
        $this->name = $name;
        $this->caption = $caption;
        $this->useConsolidatedHeader = $useConsolidatedHeader;
        $this->columns = array();
    }

    public function GetUseConsolidatedHeader()
    { return $this->useConsolidatedHeader; }

    public function GetColumnCount()
    { return count($this->columns); }

    public function GetName()
    { return $this->name; }

    public function HasColumns()
    {
        return $this->GetColumnCount() > 0;
    }

    public function AddColumn($column)
    {
        $this->columns[] = $column;
    }

    public function AddColumns($columns)
    {
        foreach($columns as $column)
            $this->AddColumn($column);
    }

    public function GetColumns()
    { return $this->columns; }

    public function GetCaption()
    { return $this->caption; }
    public function SetCaption($value)
    { $this->caption = $value; }
}

class Grid
{
    /** @var string */
    private $name;

    /** @var CustomEditColumn[] */
    private $editColumns;

    /** @var CustomViewColumn[] */
    private $viewColumns;

    /** @var CustomViewColumn[] */
    private $printColumns;

    /** @var CustomEditColumn[] */
    private $insertColumns;

    /** @var CustomViewColumn[] */
    private $exportColumns;

    /** @var CustomViewColumn[] */
    private $singleRecordViewColumns;
    //

    /** @var Dataset */
    private $dataset;

    /** @var GridState */
    private $gridState;

    /** @var Page */
    private $page;

    /** @var bool */
    private $showAddButton;

    /** @var bool */
    private $showInlineAddButton;

    /** @var string */
    private $message;

    /** @var bool */
    private $allowDeleteSelected;
    //
    public $Width;
    public $Margin;

    //
    public $SearchControl;
    public $UseFilter;
    //
    private $orderColumnFieldName;
    private $orderType;
    private $highlightRowAtHover;
    private $errorMessage;
    //
    public $OnDisplayText;
    //
    private $defaultOrderColumnFieldName;
    private $defaultOrderType;
    private $useImagesForActions;
    //
    /** @var GridBand[] */
    private $bands;
    private $defaultBand;
    //
    private $editClientValidationScript;
    private $insertClientValidationScript;
    private $enabledInlineEditing;
    private $internalName;
    private $showUpdateLink = true;
    private $useFixedHeader;
    private $showLineNumbers;
    private $useModalInserting;
    private $width;

    /** @var Aggregate[] */
    private $totals = array();

    /** @var bool */
    private $allowOrdering;


    /** @var Event */
    public $OnCustomRenderColumn;

    /** @var Event */
    public $OnCustomDrawCell;

    /** @var Event */
    public $BeforeShowRecord;

    /** @var Event */
    public $BeforeUpdateRecord;

    /** @var Event */
    public $BeforeInsertRecord;

    /** @var Event */
    public $BeforeDeleteRecord;

    /** @var Event */
    public $OnBeforeDataChange;

    /** @var Event */
    public $OnCustomDrawCell_Simple;
    
    /** @var Event */
    public $OnCustomRenderTotal;

    /** @var Event */
    public $OnCustomRenderPrintColumn;

    /** @var Event */
    public $OnCustomRenderExportColumn;

    function __construct($page, $dataset, $name)
    {
        $this->page = $page;
        $this->dataset = $dataset;
        $this->internalName = $name;
        //
        $this->editColumns = array();
        $this->viewColumns = array();
        $this->printColumns = array();
        $this->insertColumns = array();
        $this->exportColumns = array();
        $this->singleRecordViewColumns = array();
        //
        $this->SearchControl = new NullComponent('Search');
        $this->UseFilter = false;
        //
        $this->showAddButton = false;
        //
        $this->OnCustomRenderTotal = new Event();
        $this->OnCustomDrawCell = new Event();
        $this->BeforeShowRecord = new Event();
        $this->BeforeUpdateRecord = new Event();
        $this->BeforeInsertRecord = new Event();
        $this->BeforeDeleteRecord = new Event();
        $this->OnCustomDrawCell_Simple = new Event();
        $this->OnCustomRenderColumn = new Event();
        $this->OnBeforeDataChange = new Event();
        $this->OnDisplayText = new Event();
        $this->OnCustomRenderPrintColumn = new Event();
        $this->OnCustomRenderExportColumn = new Event();

        //
        $this->SetState(OPERATION_VIEWALL);
        $this->allowDeleteSelected = false;
        $this->highlightRowAtHover = false;

        $this->defaultOrderColumnFieldName = null;
        $this->defaultOrderType = null;

        $this->bands = array();
        $this->defaultBand = new GridBand('defaultBand', 'defaultBand');
        $this->bands[] = $this->defaultBand;
        //
        $this->useImagesForActions = true;
        $this->SetWidth(null);
        $this->SetEditClientValidationScript('');
        $this->SetInsertClientValidationScript('');

        $this->name = 'grid';
        $this->enabledInlineEditing = true;
        $this->useFixedHeader = false;
        $this->showLineNumbers = false;
        $this->useModalInserting = false;
        $this->allowOrdering = true;
    }

    #region Options

    public function GetUseModalInserting() { return $this->useModalInserting; }

    public function SetUseModalInserting($value) { $this->useModalInserting = $value; }

    public function GetShowLineNumbers() { return $this->showLineNumbers; }

    public function SetShowLineNumbers($showLineNumbers) { $this->showLineNumbers = $showLineNumbers; }    

    public function GetUseFixedHeader() { return $this->useFixedHeader; }

    public function SetUseFixedHeader($useFixedHeader) { $this->useFixedHeader = $useFixedHeader; }    

    public function GetHighlightRowAtHover()
    {
        return $this->highlightRowAtHover;
    }

    public function SetHighlightRowAtHover($value)
    {
        $this->highlightRowAtHover = $value;
    }

    public function GetUseImagesForActions()
    {
        return $this->useImagesForActions;
    }

    public function SetUseImagesForActions($value)
    {
        $this->useImagesForActions = $value;
    }

    public function UseAutoWidth()
    {
        return !isset($this->width);
    }

    public function GetWidth()
    {
        return $this->width;
    }

    public function SetWidth($value)
    {
        $this->width = $value;
    }

    public function GetEditClientValidationScript()
    {
        return $this->editClientValidationScript;
    }

    public function GetInsertClientValidationScript()
    {
        return $this->insertClientValidationScript;
    }

    public function SetEditClientValidationScript($value)
    {
        $this->editClientValidationScript = $value;
    }

    public function SetInsertClientValidationScript($value)
    {
        $this->insertClientValidationScript = $value;
    }

    #endregion

    #region Session variables

    private function SetSessionVariable($name, $value)
    {
        GetApplication()->SetSessionVariable($this->GetName() . '_' . $name, $value);
    }

    private function UnSetSessionVariable($name)
    {
        GetApplication()->UnSetSessionVariable($this->GetName() . '_' . $name);
    }

    private function IsSessionVariableSet($name)
    {
        return GetApplication()->IsSessionVariableSet($this->GetName() . '_' . $name);
    }

    private function GetSessionVariable($name)
    {
        return GetApplication()->GetSessionVariable($this->GetName() . '_' . $name);
    }

    #endregion

    public function SetErrorMessage($value)
    {
        $this->errorMessage = $value;
    }
    public function GetErrorMessage() { return $this->errorMessage; }

    public function SetGridMessage($value)
    {
        $this->message = $value;
    }

    public function GetGridMessage()
    {
        return $this->message;
    }

    /**
     * @return Page
     */
    function GetPage()
    { return $this->page; }

    /**
     * @return Dataset
     */
    function GetDataset()
    { return $this->dataset; }

    function GetSingleRecordViewColumns()
    { return $this->singleRecordViewColumns; }

    #region Bands
    
    public function AddBand($bandName, $caption, $useConsolidatedHeader = false)
    {
        $result = new GridBand($bandName, $caption, $useConsolidatedHeader);
        $this->bands[] = $result;
        return $result;
    }

    public function AddBandToBegin($bandName, $caption, $useConsolidatedHeader = false)
    {
        $result = new GridBand($bandName, $caption, $useConsolidatedHeader);
        $this->bands = array_merge(array($result), $this->bands);
        return $result;
    }

    public function GetBandByName($name)
    {
        foreach($this->bands as $band)
            if ($band->GetName() == $name)
                return $band;
        return null;
    }

    public function GetDefaultBand()
    {
        return $this->defaultBand;
    }

    public function GetViewBands()
    {
        return $this->bands;
    }

    #endregion

    function CreateLinkBuilder()
    {
        return $this->GetPage()->CreateLinkBuilder();
    }

    /**
     * @param CustomViewColumn $column
     * @return string
     */
    function GetVerticalLineBeforeWidth($column)
    {
        if (is_subclass_of($column, 'CustomViewColumn'))
            return $column->GetVerticalLine();
        return null;
    }
    
    function AddVericalLine($style)
    {
        if (count($this->viewColumns) > 0)
            $this->viewColumns[count($this->viewColumns) - 1]->SetVerticalLine($style);
    }

    function AddSingleRecordViewColumn($column)
    {
        $this->singleRecordViewColumns[] = $column;
        $this->DoAddColumn($column);
        return $column;
    }
 
    #region Columns

    /**
     * @param CustomEditColumn|CustomViewColumn $column
     * @return void
     */
    private function DoAddColumn($column)
    {
        $column->SetGrid($this);
    }

    public function AddViewColumn($column, $bandName = null)
    {
        $this->viewColumns[] = $column;
        $this->DoAddColumn($column);
        
        $band = $this->GetBandByName($bandName);
        if (!isset($band))
            $band = $this->GetDefaultBand();
        $band->AddColumn($column);

        return $column;
    }

    public function AddEditColumn($column)
    {
        $this->editColumns[] = $column;
        $this->DoAddColumn($column);
        return $column;
    }

    public function AddPrintColumn($column)
    {
        $this->printColumns[] = $column;
        $this->DoAddColumn($column);
        return $column;
    }

    public function AddInsertColumn($column)
    {
        $this->insertColumns[] = $column;
        $this->DoAddColumn($column);
        return $column;
    }

    public function AddExportColumn($column)
    {
        $this->exportColumns[] = $column;
        $this->DoAddColumn($column);
        return $column;
    }

    /**
     * @return CustomEditColumn[]
     */
    public function GetEditColumns()
    { 
        return $this->editColumns; 
    }

    /**
     * @return CustomViewColumn[]
     */
    public function GetViewColumns()
    { 
        return $this->viewColumns; 
    }

    /**
     * @return array|CustomViewColumn[]
     */
    public function GetPrintColumns()
    { 
        return $this->printColumns; 
    }

    /**
     * @return CustomEditColumn[]
     */
    public function GetInsertColumns()
    { 
        return $this->insertColumns; 
    }

    public function GetExportColumns()
    { 
        return $this->exportColumns; 
    }

    #endregion

    /**
     * @param \Renderer $renderer
     * @return void
     */
    public function Accept(Renderer $renderer)
    {
        $renderer->RenderGrid($this);
    }

    public function SetState($StateName)
    {
        
        switch($StateName)
        {
            case OPERATION_VIEW :
                $this->gridState = new ViewGridState($this);
                break;
            case OPERATION_PRINT_ONE :
                $this->gridState = new ViewGridState($this);
                break;
            case OPERATION_EDIT :
                $this->gridState = new EditGridState($this);
                break;
            case OPERATION_VIEWALL :
                $this->gridState = new ViewAllGridState($this);
                break;
            case OPERATION_COMMIT :
                $this->gridState = new CommitEditedValueGridState($this);
                break;
            case OPERATION_INSERT:
                $this->gridState = new InsertGridState($this);
                break;
            case OPERATION_COPY:
                $this->gridState = new CopyGridState($this);
                break;
            case OPERATION_COMMIT_INSERT:
                $this->gridState = new CommitNewValuesGridState($this);
                break;
            case OPERATION_DELETE:
                $this->gridState = new DeleteGridState($this);
                break;
            case OPERATION_COMMIT_DELETE:
                $this->gridState = new CommitDeleteGridState($this);
                break;
            case OPERATION_DELETE_SELECTED:
                $this->gridState = new DeleteSelectedGridState($this);
                break;
            case OPERATION_AJAX_REQUERT_INLINE_EDIT:
                $this->gridState = new OpenInlineEditorsGridState($this);
                break;
            case OPERATION_AJAX_REQUERT_INLINE_EDIT_COMMIT:
                $this->gridState = new CommitInlineEditedValuesGridState($this);
                break;
            case OPERATION_AJAX_REQUERT_INLINE_INSERT:
                $this->gridState = new OpenInlineInsertEditorsGridState($this);
                break;
            case OPERATION_AJAX_REQUERT_INLINE_INSERT_COMMIT:
                $this->gridState = new CommitInlineInsertedValuesGridState($this);
                break;
        }
    }

    /**
     * @return GridState
     */
    public function GetState()
    {
        return $this->gridState;
    }

    public function GetEditPageAction()
    {
        $linkBuilder = $this->CreateLinkBuilder();
        return $linkBuilder->GetLink();
    }

    public function GetOpenInsertModalDialogLink()
    {
        $linkBuilder = $this->CreateLinkBuilder();
        $linkBuilder->AddParameter(OPERATION_HTTPHANDLER_NAME_PARAMNAME, $this->GetPage()->GetModalGridEditingHandler());
        $linkBuilder->AddParameter(ModalOperation::Param, ModalOperation::OpenModalInsertDialog);
        return $linkBuilder->GetLink();        
    }
    
    public function GetModalInsertPageAction()
    {
        $linkBuilder = $this->CreateLinkBuilder();
        $linkBuilder->AddParameter(OPERATION_HTTPHANDLER_NAME_PARAMNAME, $this->GetPage()->GetModalGridEditingHandler());
        return $linkBuilder->GetLink();        
    }

    public function GetModalEditPageAction()
    {
        $linkBuilder = $this->CreateLinkBuilder();
        $linkBuilder->AddParameter(OPERATION_HTTPHANDLER_NAME_PARAMNAME, $this->GetPage()->GetModalGridEditingHandler());
        return $linkBuilder->GetLink();        
    }

    public function GetReturnUrl()
    {
        $linkBuilder = $this->CreateLinkBuilder();
        $linkBuilder->AddParameter(OPERATION_PARAMNAME, 'return');
        return $linkBuilder->GetLink();
    }

    #region Ordering

    public function GetOrderType()
    { 
        return $this->orderType;    
    }

    public function SetOrderType($value)
    { 
        $this->orderType = $value; 
    }

    public function SetDefaultOrdering($fieldName, $orderType)
    {
        $this->defaultOrderColumnFieldName = $fieldName;
        $this->defaultOrderType = $orderType;
    }

    private function ApplyDefaultOrder()
    {
        $this->orderColumnFieldName = $this->defaultOrderColumnFieldName;
        $this->orderType = $this->defaultOrderType;
    }

    public function GetOrderColumnFieldName()
    { 
        return $this->orderColumnFieldName; 
    }

    public function SetOrderColumnFieldName($value)
    { 
        $this->orderColumnFieldName = $value; 
    }

    private function ExtractOrderValues()
    {
        if (GetApplication()->IsGETValueSet('order'))
        {
            $orderValue = GetApplication()->GetGETValue('order');
            $this->orderColumnFieldName = substr($orderValue, 1, strlen($orderValue) - 1);
            $this->orderType = $orderValue[0] == 'a' ? otAscending : otDescending;
            $this->SetSessionVariable($this->internalName . '_' . 'orderColumnFieldName', $this->orderColumnFieldName);
            $this->SetSessionVariable($this->internalName . '_' . 'orderType', $this->orderType);
        }
        elseif(GetOperation() == 'resetorder')
        {
            $this->UnSetSessionVariable($this->internalName . '_' . 'orderColumnFieldName');
            $this->UnSetSessionVariable($this->internalName . '_' . 'orderType');
            $this->ApplyDefaultOrder();
        }
        elseif ($this->IsSessionVariableSet($this->internalName . '_' . 'orderColumnFieldName'))
        {
            $this->orderColumnFieldName = $this->GetSessionVariable($this->internalName . '_' . 'orderColumnFieldName');
            $this->orderType = $this->GetSessionVariable($this->internalName . '_' . 'orderType');
        }
        else
        {
            $this->ApplyDefaultOrder();
        }
    }

    #endregion

    #region Buttons

    public function SetShowAddButton($value)
    { $this->showAddButton = $value; }
    public function GetShowAddButton()
    { return $this->showAddButton; }

    public function SetShowInlineAddButton($value)
    { $this->showInlineAddButton = $value; }
    public function GetShowInlineAddButton()
    { return $this->showInlineAddButton; }

    function GetPrintRecordLink()
    {
        $result = $this->CreateLinkBuilder();
        return $result->GetLink();
    }

    function GetInlineEditRequestsAddress()
    {
        $result = $this->CreateLinkBuilder();
        return $result->GetLink();
    }

    function GetDeleteSelectedLink()
    {
        $result = $this->CreateLinkBuilder();
        return $result->GetLink();
    }

    public function GetAddRecordLink()
    {
        $result = $this->CreateLinkBuilder();
        $result->AddParameter(OPERATION_PARAMNAME, OPERATION_INSERT);
        return $result->GetLink();
    }

    function GetUpdateLink()
    { return $this->CreateLinkBuilder()->GetLink(); }

    function GetShowUpdateLink()
    { return $this->showUpdateLink; }
    function SetShowUpdateLink($value)
    { $this->showUpdateLink = $value; }

    function SetAllowDeleteSelected($value)
    { $this->allowDeleteSelected = $value; }
    function GetAllowDeleteSelected()
    { return $this->allowDeleteSelected; }

    #endregion

    function ProcessMessages()
    {
        $this->ExtractOrderValues();
        $this->SearchControl->ProcessMessages();
        $this->gridState->ProcessMessages();
    }

    #region Utils
    
    function GetPrimaryKeyValuesFromGet()
    {
        $primaryKeyValues = array();
        ExtractPrimaryKeyValues($primaryKeyValues, METHOD_GET);
        return $primaryKeyValues;
    }

    #endregion

    public function GetName()
    {
        return $this->name;
    }

    public function SetName($value)
    {
        $this->name = $value;
    }

    public function SetEnabledInlineEditing($value)
    {
        $this->enabledInlineEditing = $value;
    }
    
    public function GetEnabledInlineEditing()
    {
        return $this->enabledInlineEditing;
    }

    #region Totals

    public function HasTotals()
    {
        return count($this->totals) > 0; 
    }

    public function SetTotal(CustomViewColumn $column, Aggregate $aggregate)
    {
        $this->totals[$column->GetName()] = $aggregate;
    }

    /**
     * @param CustomViewColumn $column
     * @return Aggregate
     */
    public function GetAggregateFor(CustomViewColumn $column)
    {
        return ArrayUtils::GetArrayValueDef($this->totals, $column->GetName());
    }

    public function GetTotalValues()
    {
        $command = new AggregationValuesQuery(
            $this->GetDataset()->GetSelectCommand(),
            $this->GetDataset()->GetCommandImp()
        );
        foreach($this->totals as $columnName => $aggregate)
            $command->AddAggregate($columnName, $aggregate, $columnName);

        $result = array();
        $this->GetDataset()->GetConnection()->ExecQueryToArray(
            $command->GetSQL(), $result
        );
        return $result[0];
    }

    public function GetAllowOrdering()
    {
        return $this->allowOrdering;
    }
    
    public function SetAllowOrdering($value)
    {
        $this->allowOrdering = $value;
    }


    #endregion
}
?>
