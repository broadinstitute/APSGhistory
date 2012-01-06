<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 'On');
ini_set("memory_limit","80M");
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
    
    class BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailView0Page extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."AVG_LUN_METRICS_BY_TIMESLICE"');
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('OBJECT_NAME');
            $this->dataset->AddField($field, true);
            $field = new StringField('POLL_TIME');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_UTILIZATION_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_QUEUE_LGTH');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_RESPONSE_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_TOT_BANDWTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_TOT_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_THROUGHPU_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_BANDWITH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_DISK_CROSSINGS_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_SERVICE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_SEEK_DISTANCE_GB');
            $this->dataset->AddField($field, true);
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
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
            $result = new Grid($this, $this->dataset, 'BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailViewGrid0');
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
    
    class BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0Page extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."AVG_LUN_METRICS_BY_TIMESLICE"');
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('OBJECT_NAME');
            $this->dataset->AddField($field, true);
            $field = new StringField('POLL_TIME');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_UTILIZATION_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_QUEUE_LGTH');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_RESPONSE_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_TOT_BANDWTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_TOT_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_THROUGHPU_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_BANDWITH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_DISK_CROSSINGS_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_SERVICE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_SEEK_DISTANCE_GB');
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
            $grid->SearchControl = new SimpleSearch('BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0ssearch', $this->dataset,
                array('SAN_ARRAY', 'OBJECT_NAME', 'POLL_TIME', 'AVG_UTILIZATION_PCT', 'AVG_QUEUE_LGTH', 'AVG_RESPONSE_MS', 'AVG_TOT_BANDWTH_MB_SEC', 'AVG_TOT_THROUGHPUT_IO_SEC', 'AVG_READ_BANDWIDTH_MB_SEC', 'AVG_READ_SIZE_KB', 'AVG_READ_THROUGHPU_SEC', 'AVG_WRITE_BANDWITH_MB_SEC', 'AVG_WRITE_SIZE_KB', 'AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG_DISK_CROSSINGS_SEC', 'AVG_SERVICE_TIME_MS', 'AVG_SEEK_DISTANCE_GB'),
                array($this->RenderText('SAN ARRAY'), $this->RenderText('OBJECT NAME'), $this->RenderText('POLL TIME'), $this->RenderText('AVG UTILIZATION PCT'), $this->RenderText('AVG QUEUE LGTH'), $this->RenderText('AVG RESPONSE MS'), $this->RenderText('AVG TOT BANDWTH MB SEC'), $this->RenderText('AVG TOT THROUGHPUT IO SEC'), $this->RenderText('AVG READ BANDWIDTH MB SEC'), $this->RenderText('AVG READ SIZE KB'), $this->RenderText('AVG READ THROUGHPU SEC'), $this->RenderText('AVG WRITE BANDWITH MB SEC'), $this->RenderText('AVG WRITE SIZE KB'), $this->RenderText('AVG WRITE THROUGHPUT IO SEC'), $this->RenderText('AVG DISK CROSSINGS SEC'), $this->RenderText('AVG SERVICE TIME MS'), $this->RenderText('AVG SEEK DISTANCE GB')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0asearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('OBJECT_NAME', $this->RenderText('OBJECT NAME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('POLL_TIME', $this->RenderText('POLL TIME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_UTILIZATION_PCT', $this->RenderText('AVG UTILIZATION PCT')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_QUEUE_LGTH', $this->RenderText('AVG QUEUE LGTH')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_RESPONSE_MS', $this->RenderText('AVG RESPONSE MS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_TOT_BANDWTH_MB_SEC', $this->RenderText('AVG TOT BANDWTH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_TOT_THROUGHPUT_IO_SEC', $this->RenderText('AVG TOT THROUGHPUT IO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_READ_BANDWIDTH_MB_SEC', $this->RenderText('AVG READ BANDWIDTH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_READ_SIZE_KB', $this->RenderText('AVG READ SIZE KB')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_READ_THROUGHPU_SEC', $this->RenderText('AVG READ THROUGHPU SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_WRITE_BANDWITH_MB_SEC', $this->RenderText('AVG WRITE BANDWITH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_WRITE_SIZE_KB', $this->RenderText('AVG WRITE SIZE KB')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_WRITE_THROUGHPUT_IO_SEC', $this->RenderText('AVG WRITE THROUGHPUT IO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_DISK_CROSSINGS_SEC', $this->RenderText('AVG DISK CROSSINGS SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_SERVICE_TIME_MS', $this->RenderText('AVG SERVICE TIME MS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_SEEK_DISTANCE_GB', $this->RenderText('AVG SEEK DISTANCE GB')));
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
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/copy_action.png');
            }
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns($grid)
        {
    
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
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns($grid)
        {
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
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
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEditGrid0');
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
    
    class BROAD_AVG_LUN_METRICS_BY_TIMESLICEPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."AVG_LUN_METRICS_BY_TIMESLICE"');
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('OBJECT_NAME');
            $this->dataset->AddField($field, true);
            $field = new StringField('POLL_TIME');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_UTILIZATION_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_QUEUE_LGTH');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_RESPONSE_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_TOT_BANDWTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_TOT_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_READ_THROUGHPU_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_BANDWITH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_WRITE_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_DISK_CROSSINGS_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_SERVICE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVG_SEEK_DISTANCE_GB');
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
            if (GetCurrentUserGrantForDataSource('BROAD.AVG_LUN_METRICS_BY_TIMESLICE')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('BROAD.AVG LUN METRICS BY TIMESLICE'), 'BROAD.AVG_LUN_METRICS_BY_TIMESLICE.php', $this->RenderText('BROAD.AVG LUN METRICS BY TIMESLICE'), $currentPageCaption == $this->RenderText('BROAD.AVG LUN METRICS BY TIMESLICE')));
            
            if ( HasAdminPage() && GetApplication()->HasAdminGrantForCurrentUser() )
              $result->AddPage(new PageLink($this->RenderText('Admin page'), 'phpgen_admin.php', 'Admin page', false, true));
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('BROAD_AVG_LUN_METRICS_BY_TIMESLICEssearch', $this->dataset,
                array('SAN_ARRAY', 'OBJECT_NAME', 'POLL_TIME', 'AVG_UTILIZATION_PCT', 'AVG_QUEUE_LGTH', 'AVG_RESPONSE_MS', 'AVG_TOT_BANDWTH_MB_SEC', 'AVG_TOT_THROUGHPUT_IO_SEC', 'AVG_READ_BANDWIDTH_MB_SEC', 'AVG_READ_SIZE_KB', 'AVG_READ_THROUGHPU_SEC', 'AVG_WRITE_BANDWITH_MB_SEC', 'AVG_WRITE_SIZE_KB', 'AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG_DISK_CROSSINGS_SEC', 'AVG_SERVICE_TIME_MS', 'AVG_SEEK_DISTANCE_GB'),
                array($this->RenderText('SAN ARRAY'), $this->RenderText('OBJECT NAME'), $this->RenderText('POLL TIME'), $this->RenderText('AVG UTILIZATION PCT'), $this->RenderText('AVG QUEUE LGTH'), $this->RenderText('AVG RESPONSE MS'), $this->RenderText('AVG TOT BANDWTH MB SEC'), $this->RenderText('AVG TOT THROUGHPUT IO SEC'), $this->RenderText('AVG READ BANDWIDTH MB SEC'), $this->RenderText('AVG READ SIZE KB'), $this->RenderText('AVG READ THROUGHPU SEC'), $this->RenderText('AVG WRITE BANDWITH MB SEC'), $this->RenderText('AVG WRITE SIZE KB'), $this->RenderText('AVG WRITE THROUGHPUT IO SEC'), $this->RenderText('AVG DISK CROSSINGS SEC'), $this->RenderText('AVG SERVICE TIME MS'), $this->RenderText('AVG SEEK DISTANCE GB')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_AVG_LUN_METRICS_BY_TIMESLICEasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('OBJECT_NAME', $this->RenderText('OBJECT NAME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('POLL_TIME', $this->RenderText('POLL TIME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_UTILIZATION_PCT', $this->RenderText('AVG UTILIZATION PCT')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_QUEUE_LGTH', $this->RenderText('AVG QUEUE LGTH')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_RESPONSE_MS', $this->RenderText('AVG RESPONSE MS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_TOT_BANDWTH_MB_SEC', $this->RenderText('AVG TOT BANDWTH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_TOT_THROUGHPUT_IO_SEC', $this->RenderText('AVG TOT THROUGHPUT IO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_READ_BANDWIDTH_MB_SEC', $this->RenderText('AVG READ BANDWIDTH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_READ_SIZE_KB', $this->RenderText('AVG READ SIZE KB')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_READ_THROUGHPU_SEC', $this->RenderText('AVG READ THROUGHPU SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_WRITE_BANDWITH_MB_SEC', $this->RenderText('AVG WRITE BANDWITH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_WRITE_SIZE_KB', $this->RenderText('AVG WRITE SIZE KB')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_WRITE_THROUGHPUT_IO_SEC', $this->RenderText('AVG WRITE THROUGHPUT IO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_DISK_CROSSINGS_SEC', $this->RenderText('AVG DISK CROSSINGS SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_SERVICE_TIME_MS', $this->RenderText('AVG SERVICE TIME MS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVG_SEEK_DISTANCE_GB', $this->RenderText('AVG SEEK DISTANCE GB')));
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
            if (GetCurrentUserGrantForDataSource('BROAD.AVG_LUN_METRICS_BY_TIMESLICE.BROAD.AVG_LUN_METRICS_BY_TIMESLICE')->HasViewGrant())
            {
              //
            // View column for BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailView0 detail
            //
            $column = new DetailColumn(array('SAN_ARRAY'), 'detail0', 'BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0_handler', 'BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailView0_handler', $this->dataset, 'BROAD.AVG LUN METRICS BY TIMESLICE');
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns($grid)
        {
    
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
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns($grid)
        {
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
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
    
        function CreateMasterDetailRecordGridForBROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0Grid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForBROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0');
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetName('master_grid');
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
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
            $result = new Grid($this, $this->dataset, 'BROAD_AVG_LUN_METRICS_BY_TIMESLICEGrid');
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
            $handler = new PageHTTPHandler('BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailView0_handler', new BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailView0Page('BROAD.AVG LUN METRICS BY TIMESLICE', 'BROAD.AVG LUN METRICS BY TIMESLICE', array('OBJECT_NAME'), GetCurrentUserGrantForDataSource('BROAD.AVG_LUN_METRICS_BY_TIMESLICE.BROAD.AVG_LUN_METRICS_BY_TIMESLICE'), 'UTF-8', 20, 'BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0_handler'));
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0Page($this, array('OBJECT_NAME'), array('SAN_ARRAY'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForBROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0Grid(), $this->dataset, GetCurrentUserGrantForDataSource('BROAD.AVG_LUN_METRICS_BY_TIMESLICE.BROAD.AVG_LUN_METRICS_BY_TIMESLICE'), 'UTF-8');
            $pageEdit->SetShortCaption('BROAD.AVG LUN METRICS BY TIMESLICE');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('BROAD.AVG LUN METRICS BY TIMESLICE');
            $pageEdit->SetHttpHandlerName('BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0_handler');
            $handler = new PageHTTPHandler('BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0_handler', $pageEdit);
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
        $Page = new BROAD_AVG_LUN_METRICS_BY_TIMESLICEPage("BROAD.AVG_LUN_METRICS_BY_TIMESLICE.php", "BROAD_AVG_LUN_METRICS_BY_TIMESLICE", GetCurrentUserGrantForDataSource("BROAD_AVG_LUN_METRICS_BY_TIMESLICE"), 'UTF-8');
        $Page->SetShortCaption('BROAD.AVG LUN METRICS BY TIMESLICE');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('BROAD.AVG LUN METRICS BY TIMESLICE');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("BROAD.AVG_LUN_METRICS_BY_TIMESLICE"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
