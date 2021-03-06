<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 'On');
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in browser (Internet Explorer, Mozilla firefox, etc.)
 * this means that
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */


    require_once 'components/utils/check_utils.php';
    CheckPHPVersion();



    require_once 'database_engine/oracle_engine.php';
    require_once 'components/page.php';
    require_once 'phpgen_settings.php';


    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'AL32UTF8';
        GetApplication()->GetUserAuthorizationStrategy()->ApplyIdentityToConnectionOptions($result);
        return $result;
    }

    
    ?><?php
    
    ?><?php
    
    class BROAD_FS2LUN_HOST_HISTORYPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."FS2LUN_HOST_HISTORY"');
            $field = new StringField('HOST_NAME');
            $this->dataset->AddField($field, true);
            $field = new StringField('DEVICE');
            $this->dataset->AddField($field, true);
            $field = new StringField('FILE_SYSTEM');
            $this->dataset->AddField($field, true);
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('LUN_NO');
            $this->dataset->AddField($field, true);
            $field = new StringField('LUN_ID');
            $this->dataset->AddField($field, false);
            $field = new DateField('ENTRY_DT');
            $this->dataset->AddField($field, true);
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            $currentPageCaption = $this->GetShortCaption();
            $result = new PageList();
            if (GetCurrentUserGrantForDataSource('BROAD.FS2LUN_HOST_HISTORY')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('BROAD.FS2LUN HOST HISTORY'), 'BROAD.FS2LUN_HOST_HISTORY.php', $this->RenderText('BROAD.FS2LUN HOST HISTORY'), $currentPageCaption == $this->RenderText('BROAD.FS2LUN HOST HISTORY')));
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('BROAD_FS2LUN_HOST_HISTORYssearch', $this->dataset,
                array('HOST_NAME', 'DEVICE', 'FILE_SYSTEM', 'SAN_ARRAY', 'LUN_NO', 'LUN_ID', 'ENTRY_DT'),
                array($this->RenderText('HOST NAME'), $this->RenderText('DEVICE'), $this->RenderText('FILE SYSTEM'), $this->RenderText('SAN ARRAY'), $this->RenderText('LUN NO'), $this->RenderText('LUN ID'), $this->RenderText('ENTRY DT')),
                array(
                    '=' => $this->GetLocalizerCaptions()->GetMessageString('equals'),
                    '<>' => $this->GetLocalizerCaptions()->GetMessageString('doesNotEquals'),
                    '<' => $this->GetLocalizerCaptions()->GetMessageString('isLessThan'),
                    '<=' => $this->GetLocalizerCaptions()->GetMessageString('isLessThanOrEqualsTo'),
                    '>' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThan'),
                    '>=' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThanOrEqualsTo'),
                    'ILIKE' => $this->GetLocalizerCaptions()->GetMessageString('Like'),
                    'STARTS' => $this->GetLocalizerCaptions()->GetMessageString('StartsWith'),
                    'ENDS' => $this->GetLocalizerCaptions()->GetMessageString('EndsWith'),
                    'CONTAINS' => $this->GetLocalizerCaptions()->GetMessageString('Contains')
                    ), $this->GetLocalizerCaptions(), $this, 'CONTAINS'
                );
        }
    
        protected function CreateGridAdvancedSearchControl($grid)
        {
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_FS2LUN_HOST_HISTORYasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('HOST_NAME', $this->RenderText('HOST NAME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('DEVICE', $this->RenderText('DEVICE')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FILE_SYSTEM', $this->RenderText('FILE SYSTEM')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('LUN_NO', $this->RenderText('LUN NO')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('LUN_ID', $this->RenderText('LUN ID')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('ENTRY_DT', $this->RenderText('ENTRY DT')));
        }
    
        protected function AddOperationsColumns($grid)
        {
            $actionsBandName = 'actions';
            $grid->AddBandToBegin($actionsBandName, $this->GetLocalizerCaptions()->GetMessageString('Actions'), true);
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/view_action.png');
            }
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/edit_action.png');
                $column->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/delete_action.png');
                $column->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            $column->SetAdditionalAttribute("modal-delete", "true");
            $column->SetAdditionalAttribute("delete-handler-name", $this->GetModalGridDeleteHandler());
            }
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/copy_action.png');
            }
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for HOST_NAME field
            //
            $editor = new TextEdit('host_name_edit');
            $editor->SetSize(20);
            $editColumn = new CustomEditColumn('HOST NAME', 'HOST_NAME', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for HOST_NAME field
            //
            $editor = new TextEdit('host_name_edit');
            $editor->SetSize(20);
            $editColumn = new CustomEditColumn('HOST NAME', 'HOST_NAME', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for DEVICE field
            //
            $column = new TextViewColumn('DEVICE', 'DEVICE', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DEVICE_handler');
            
            /* <inline edit column> */
            //
            // Edit column for DEVICE field
            //
            $editor = new TextEdit('device_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('DEVICE', 'DEVICE', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for DEVICE field
            //
            $editor = new TextEdit('device_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('DEVICE', 'DEVICE', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('FILE_SYSTEM_handler');
            
            /* <inline edit column> */
            //
            // Edit column for FILE_SYSTEM field
            //
            $editor = new TextEdit('file_system_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('FILE SYSTEM', 'FILE_SYSTEM', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for FILE_SYSTEM field
            //
            $editor = new TextEdit('file_system_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('FILE SYSTEM', 'FILE_SYSTEM', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('SAN_ARRAY_handler');
            
            /* <inline edit column> */
            //
            // Edit column for SAN_ARRAY field
            //
            $editor = new TextEdit('san_array_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('SAN ARRAY', 'SAN_ARRAY', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for SAN_ARRAY field
            //
            $editor = new TextEdit('san_array_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('SAN ARRAY', 'SAN_ARRAY', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for LUN_NO field
            //
            $editor = new TextEdit('lun_no_edit');
            $editColumn = new CustomEditColumn('LUN NO', 'LUN_NO', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for LUN_NO field
            //
            $editor = new TextEdit('lun_no_edit');
            $editColumn = new CustomEditColumn('LUN NO', 'LUN_NO', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for LUN_ID field
            //
            $column = new TextViewColumn('LUN_ID', 'LUN ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('LUN_ID_handler');
            
            /* <inline edit column> */
            //
            // Edit column for LUN_ID field
            //
            $editor = new TextAreaEdit('lun_id_edit', 50, 8);
            $editColumn = new CustomEditColumn('LUN ID', 'LUN_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for LUN_ID field
            //
            $editor = new TextAreaEdit('lun_id_edit', 50, 8);
            $editColumn = new CustomEditColumn('LUN ID', 'LUN_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ENTRY_DT field
            //
            $column = new DateTimeViewColumn('ENTRY_DT', 'ENTRY DT', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for ENTRY_DT field
            //
            $editor = new DateTimeEdit('entry_dt_edit', false, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('ENTRY DT', 'ENTRY_DT', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for ENTRY_DT field
            //
            $editor = new DateTimeEdit('entry_dt_edit', false, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('ENTRY DT', 'ENTRY_DT', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns($grid)
        {
            //
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for DEVICE field
            //
            $column = new TextViewColumn('DEVICE', 'DEVICE', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DEVICE_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('FILE_SYSTEM_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('SAN_ARRAY_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for LUN_ID field
            //
            $column = new TextViewColumn('LUN_ID', 'LUN ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('LUN_ID_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ENTRY_DT field
            //
            $column = new DateTimeViewColumn('ENTRY_DT', 'ENTRY DT', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns($grid)
        {
            //
            // Edit column for HOST_NAME field
            //
            $editor = new TextEdit('host_name_edit');
            $editor->SetSize(20);
            $editColumn = new CustomEditColumn('HOST NAME', 'HOST_NAME', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for DEVICE field
            //
            $editor = new TextEdit('device_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('DEVICE', 'DEVICE', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for FILE_SYSTEM field
            //
            $editor = new TextEdit('file_system_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('FILE SYSTEM', 'FILE_SYSTEM', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for SAN_ARRAY field
            //
            $editor = new TextEdit('san_array_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('SAN ARRAY', 'SAN_ARRAY', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for LUN_NO field
            //
            $editor = new TextEdit('lun_no_edit');
            $editColumn = new CustomEditColumn('LUN NO', 'LUN_NO', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for LUN_ID field
            //
            $editor = new TextAreaEdit('lun_id_edit', 50, 8);
            $editColumn = new CustomEditColumn('LUN ID', 'LUN_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ENTRY_DT field
            //
            $editor = new DateTimeEdit('entry_dt_edit', false, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('ENTRY DT', 'ENTRY_DT', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns($grid)
        {
            //
            // Edit column for HOST_NAME field
            //
            $editor = new TextEdit('host_name_edit');
            $editor->SetSize(20);
            $editColumn = new CustomEditColumn('HOST NAME', 'HOST_NAME', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for DEVICE field
            //
            $editor = new TextEdit('device_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('DEVICE', 'DEVICE', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for FILE_SYSTEM field
            //
            $editor = new TextEdit('file_system_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('FILE SYSTEM', 'FILE_SYSTEM', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SAN_ARRAY field
            //
            $editor = new TextEdit('san_array_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('SAN ARRAY', 'SAN_ARRAY', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for LUN_NO field
            //
            $editor = new TextEdit('lun_no_edit');
            $editColumn = new CustomEditColumn('LUN NO', 'LUN_NO', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for LUN_ID field
            //
            $editor = new TextAreaEdit('lun_id_edit', 50, 8);
            $editColumn = new CustomEditColumn('LUN ID', 'LUN_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ENTRY_DT field
            //
            $editor = new DateTimeEdit('entry_dt_edit', false, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('ENTRY DT', 'ENTRY_DT', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(true);
                $grid->SetShowInlineAddButton(false);
            }
            else
            {
                $grid->SetShowInlineAddButton(false);
                $grid->SetShowAddButton(false);
            }
        }
    
        protected function AddPrintColumns($grid)
        {
            //
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for DEVICE field
            //
            $column = new TextViewColumn('DEVICE', 'DEVICE', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for LUN_ID field
            //
            $column = new TextViewColumn('LUN_ID', 'LUN ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ENTRY_DT field
            //
            $column = new DateTimeViewColumn('ENTRY_DT', 'ENTRY DT', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns($grid)
        {
            //
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for DEVICE field
            //
            $column = new TextViewColumn('DEVICE', 'DEVICE', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for LUN_ID field
            //
            $column = new TextViewColumn('LUN_ID', 'LUN ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for ENTRY_DT field
            //
            $column = new DateTimeViewColumn('ENTRY_DT', 'ENTRY DT', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties($column)
        {
            $column->SetShowSetToNullCheckBox(true);
    	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function ShowEditButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasEditGrant($this->GetDataset());
        }
        public function ShowDeleteButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasDeleteGrant($this->GetDataset());
        }
        
        public function GetModalGridDeleteHandler() { return 'BROAD_FS2LUN_HOST_HISTORY_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'BROAD_FS2LUN_HOST_HISTORYGrid');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->CreateGridSearchControl($result);
            $this->CreateGridAdvancedSearchControl($result);
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->SetShowPageList(true);
            $this->SetExportToExcelAvailable(false);
            $this->SetExportToWordAvailable(false);
            $this->SetExportToXmlAvailable(false);
            $this->SetExportToCsvAvailable(false);
            $this->SetExportToPdfAvailable(false);
            $this->SetPrinterFriendlyAvailable(false);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(false);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            //
            // View column for DEVICE field
            //
            $column = new TextViewColumn('DEVICE', 'DEVICE', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for DEVICE field
            //
            $editor = new TextEdit('device_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('DEVICE', 'DEVICE', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for DEVICE field
            //
            $editor = new TextEdit('device_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('DEVICE', 'DEVICE', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DEVICE_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for FILE_SYSTEM field
            //
            $editor = new TextEdit('file_system_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('FILE SYSTEM', 'FILE_SYSTEM', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for FILE_SYSTEM field
            //
            $editor = new TextEdit('file_system_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('FILE SYSTEM', 'FILE_SYSTEM', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'FILE_SYSTEM_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for SAN_ARRAY field
            //
            $editor = new TextEdit('san_array_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('SAN ARRAY', 'SAN_ARRAY', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for SAN_ARRAY field
            //
            $editor = new TextEdit('san_array_edit');
            $editor->SetSize(100);
            $editColumn = new CustomEditColumn('SAN ARRAY', 'SAN_ARRAY', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for LUN_ID field
            //
            $column = new TextViewColumn('LUN_ID', 'LUN ID', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for LUN_ID field
            //
            $editor = new TextAreaEdit('lun_id_edit', 50, 8);
            $editColumn = new CustomEditColumn('LUN ID', 'LUN_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for LUN_ID field
            //
            $editor = new TextAreaEdit('lun_id_edit', 50, 8);
            $editColumn = new CustomEditColumn('LUN ID', 'LUN_ID', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'LUN_ID_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for DEVICE field
            //
            $column = new TextViewColumn('DEVICE', 'DEVICE', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DEVICE_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'FILE_SYSTEM_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for LUN_ID field
            //
            $column = new TextViewColumn('LUN_ID', 'LUN ID', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'LUN_ID_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
        
        protected function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '';
        }
    }



    try
    {
        $Page = new BROAD_FS2LUN_HOST_HISTORYPage("BROAD.FS2LUN_HOST_HISTORY.php", "BROAD_FS2LUN_HOST_HISTORY", GetCurrentUserGrantForDataSource("BROAD_FS2LUN_HOST_HISTORY"), 'UTF-8');
        $Page->SetShortCaption('BROAD.FS2LUN HOST HISTORY');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('BROAD.FS2LUN HOST HISTORY');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("BROAD_FS2LUN_HOST_HISTORY"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
