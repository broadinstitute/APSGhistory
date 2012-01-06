<?php
error_reporting(E_ALL ^ E_NOTICE);
 ini_set('display_errors', 'On');
  ini_set("memory_limit","20M");
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
    
    class BROAD_HOST_SID_FS_SA_LUNDetailView0Page extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."HOST_SID_FS_SA_LUN"');
            $field = new StringField('HOST');
            $this->dataset->AddField($field, true);
            $field = new StringField('SID');
            $this->dataset->AddField($field, true);
            $field = new StringField('FILE_SYSTEM');
            $this->dataset->AddField($field, true);
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('LUN_NO');
            $this->dataset->AddField($field, true);
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties($column)
        {
            $column->SetShowSetToNullCheckBox(true);
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'BROAD_HOST_SID_FS_SA_LUNDetailViewGrid0');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddFieldColumns($result);
    
            return $result;
        }
    }
    
    
    
    ?><?php
    
    ?><?php
    
    class BROAD_HOST_SID_FS_SA_LUNDetailEdit0Page extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."HOST_SID_FS_SA_LUN"');
            $field = new StringField('HOST');
            $this->dataset->AddField($field, true);
            $field = new StringField('SID');
            $this->dataset->AddField($field, true);
            $field = new StringField('FILE_SYSTEM');
            $this->dataset->AddField($field, true);
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('LUN_NO');
            $this->dataset->AddField($field, true);
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(30);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            return null;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('BROAD_HOST_SID_FS_SA_LUNDetailEdit0ssearch', $this->dataset,
                array('HOST', 'SID', 'FILE_SYSTEM', 'SAN_ARRAY', 'LUN_NO'),
                array($this->RenderText('HOST'), $this->RenderText('SID'), $this->RenderText('FILE SYSTEM'), $this->RenderText('SAN ARRAY'), $this->RenderText('LUN NO')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_HOST_SID_FS_SA_LUNDetailEdit0asearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('HOST', $this->RenderText('HOST')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SID', $this->RenderText('SID')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FILE_SYSTEM', $this->RenderText('FILE SYSTEM')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('LUN_NO', $this->RenderText('LUN NO')));
        }
    
        public function GetPageDirection()
        {
            return null;
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
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/delete_action.png');
                $column->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            $column->SetAdditionalAttribute("modal-delete", "true");
            $column->SetAdditionalAttribute("delete-handler-name", $this->GetModalGridDeleteHandler());
            }
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns($grid)
        {
            //
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns($grid)
        {
    
        }
    
        protected function AddInsertColumns($grid)
        {
    
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(false);
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
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
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
        }
    
        protected function AddExportColumns($grid)
        {
            //
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
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
        public function ShowDeleteButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasDeleteGrant($this->GetDataset());
        }
        
        public function GetModalGridDeleteHandler() { return 'BROAD_HOST_SID_FS_SA_LUNDetailEdit0_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'BROAD_HOST_SID_FS_SA_LUNDetailEditGrid0');
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
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
    
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
    ?><?php
    
    ?><?php
    
    class BROAD_HOST_SID_FS_SA_LUNPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."HOST_SID_FS_SA_LUN"');
            $field = new StringField('HOST');
            $this->dataset->AddField($field, true);
            $field = new StringField('SID');
            $this->dataset->AddField($field, true);
            $field = new StringField('FILE_SYSTEM');
            $this->dataset->AddField($field, true);
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('LUN_NO');
            $this->dataset->AddField($field, true);
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(30);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            $currentPageCaption = $this->GetShortCaption();
            $result = new PageList();
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('BROAD_HOST_SID_FS_SA_LUNssearch', $this->dataset,
                array('HOST', 'SID', 'FILE_SYSTEM', 'SAN_ARRAY', 'LUN_NO'),
                array($this->RenderText('HOST'), $this->RenderText('SID'), $this->RenderText('FILE SYSTEM'), $this->RenderText('SAN ARRAY'), $this->RenderText('LUN NO')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_HOST_SID_FS_SA_LUNasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('HOST', $this->RenderText('HOST')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SID', $this->RenderText('SID')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FILE_SYSTEM', $this->RenderText('FILE SYSTEM')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('LUN_NO', $this->RenderText('LUN NO')));
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
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/copy_action.png');
            }
        }
    
        protected function AddFieldColumns($grid)
        {
            if (GetCurrentUserGrantForDataSource('BROAD_HOST_SID_FS_SA_LUNDetailView0')->HasViewGrant())
            {
              //
            // View column for BROAD_HOST_SID_FS_SA_LUNDetailView0 detail
            //
            $column = new DetailColumn(array('HOST'), 'detail0', 'BROAD_HOST_SID_FS_SA_LUNDetailEdit0_handler', 'BROAD_HOST_SID_FS_SA_LUNDetailView0_handler', $this->dataset, 'BROAD.HOST SID FS SA LUN');
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns($grid)
        {
            //
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns($grid)
        {
    
        }
    
        protected function AddInsertColumns($grid)
        {
    
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
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
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
        }
    
        protected function AddExportColumns($grid)
        {
            //
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
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
    
        function CreateMasterDetailRecordGridForBROAD_HOST_SID_FS_SA_LUNDetailEdit0Grid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForBROAD_HOST_SID_FS_SA_LUNDetailEdit0');
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetName('master_grid');
            //
            // View column for HOST field
            //
            $column = new TextViewColumn('HOST', 'HOST', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for SID field
            //
            $column = new TextViewColumn('SID', 'SID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'BROAD_HOST_SID_FS_SA_LUNGrid');
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
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            $handler = new PageHTTPHandler('BROAD_HOST_SID_FS_SA_LUNDetailView0_handler', new BROAD_HOST_SID_FS_SA_LUNDetailView0Page('HOST_SID_FS_SAN_LUN_RELATIONSHIPS', 'HOST_SID_FS_SAN_LUN_RELATIONSHIPS', array('SID'), GetCurrentUserGrantForDataSource('BROAD_HOST_SID_FS_SA_LUNDetailView0'), 'UTF-8', 20, 'BROAD_HOST_SID_FS_SA_LUNDetailEdit0_handler'));
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new BROAD_HOST_SID_FS_SA_LUNDetailEdit0Page($this, array('SID'), array('HOST'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForBROAD_HOST_SID_FS_SA_LUNDetailEdit0Grid(), $this->dataset, GetCurrentUserGrantForDataSource('BROAD_HOST_SID_FS_SA_LUNDetailEdit0'), 'UTF-8');
            $pageEdit->SetShortCaption('HOST SID FS SA LUN');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('HOST_SID_FS_SAN_LUN_RELATIONSHIPS');
            $pageEdit->SetHttpHandlerName('BROAD_HOST_SID_FS_SA_LUNDetailEdit0_handler');
            $handler = new PageHTTPHandler('BROAD_HOST_SID_FS_SA_LUNDetailEdit0_handler', $pageEdit);
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
        $Page = new BROAD_HOST_SID_FS_SA_LUNPage("BROAD.HOST_SID_FS_SA_LUN.php", "BROAD_HOST_SID_FS_SA_LUN", GetCurrentUserGrantForDataSource("BROAD_HOST_SID_FS_SA_LUN"), 'UTF-8');
        $Page->SetShortCaption('HOST SID FS SA LUN');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('HOST_SID_FS_SAN_LUN_RELATIONSHIPS');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("BROAD_HOST_SID_FS_SA_LUN"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
