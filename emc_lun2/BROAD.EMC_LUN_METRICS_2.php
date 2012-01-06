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
    
    class BROAD_EMC_LUN_METRICS_2DetailView0Page extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."EMC_LUN_METRICS_2"');
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
            $result = new Grid($this, $this->dataset, 'BROAD_EMC_LUN_METRICS_2DetailViewGrid0');
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
    
    class BROAD_EMC_LUN_METRICS_2DetailEdit0Page extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."EMC_LUN_METRICS_2"');
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
            $grid->SearchControl = new SimpleSearch('BROAD_EMC_LUN_METRICS_2DetailEdit0ssearch', $this->dataset,
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_EMC_LUN_METRICS_2DetailEdit0asearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
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
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns($grid)
        {
    
        }
    
        protected function AddInsertColumns($grid)
        {
            //
            // Edit column for AVG_SEEK_DISTANCE_GB field
            //
            $editor = new TextEdit('avg_seek_distance_gb_edit');
            $editColumn = new CustomEditColumn('AVG SEEK DISTANCE GB', 'AVG_SEEK_DISTANCE_GB', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
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
            $result = new Grid($this, $this->dataset, 'BROAD_EMC_LUN_METRICS_2DetailEditGrid0');
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
    
            $this->SetShowPageList(false);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(false);
            $this->SetPrinterFriendlyAvailable(false);
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
    
    class BROAD_EMC_LUN_METRICS_2Page extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."EMC_LUN_METRICS_2"');
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
            if (GetCurrentUserGrantForDataSource('BROAD.EMC_LUN_METRICS_2')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('BROAD.EMC LUN METRICS 2'), 'BROAD.EMC_LUN_METRICS_2.php', $this->RenderText('BROAD.EMC LUN METRICS 2'), $currentPageCaption == $this->RenderText('BROAD.EMC LUN METRICS 2')));
            
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
            $grid->SearchControl = new SimpleSearch('BROAD_EMC_LUN_METRICS_2ssearch', $this->dataset,
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_EMC_LUN_METRICS_2asearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
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
    
        }
    
        protected function AddFieldColumns($grid)
        {
            if (GetCurrentUserGrantForDataSource('BROAD.EMC_LUN_METRICS_2.')->HasViewGrant())
            {
              //
            // View column for BROAD_EMC_LUN_METRICS_2DetailView0 detail
            //
            $column = new DetailColumn(array('SAN_ARRAY'), 'detail0', 'BROAD_EMC_LUN_METRICS_2DetailEdit0_handler', 'BROAD_EMC_LUN_METRICS_2DetailView0_handler', $this->dataset, 'BROAD.EMC LUN METRICS 2');
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
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_UTILIZATION_PCT field
            //
            $column = new TextViewColumn('AVG_UTILIZATION_PCT', 'AVG UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_QUEUE_LGTH field
            //
            $column = new TextViewColumn('AVG_QUEUE_LGTH', 'AVG QUEUE LGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_RESPONSE_MS field
            //
            $column = new TextViewColumn('AVG_RESPONSE_MS', 'AVG RESPONSE MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_TOT_BANDWTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_BANDWTH_MB_SEC', 'AVG TOT BANDWTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_TOT_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_TOT_THROUGHPUT_IO_SEC', 'AVG TOT THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_READ_BANDWIDTH_MB_SEC', 'AVG READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_READ_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_READ_SIZE_KB', 'AVG READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_READ_THROUGHPU_SEC field
            //
            $column = new TextViewColumn('AVG_READ_THROUGHPU_SEC', 'AVG READ THROUGHPU SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_WRITE_BANDWITH_MB_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_BANDWITH_MB_SEC', 'AVG WRITE BANDWITH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('AVG_WRITE_SIZE_KB', 'AVG WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_WRITE_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('AVG_WRITE_THROUGHPUT_IO_SEC', 'AVG WRITE THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_DISK_CROSSINGS_SEC field
            //
            $column = new TextViewColumn('AVG_DISK_CROSSINGS_SEC', 'AVG DISK CROSSINGS SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('AVG_SERVICE_TIME_MS', 'AVG SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVG_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVG_SEEK_DISTANCE_GB', 'AVG SEEK DISTANCE GB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns($grid)
        {
            //
            // Edit column for SAN_ARRAY field
            //
            $editor = new TextEdit('san_array_edit');
            $editor->SetSize(50);
            $editColumn = new CustomEditColumn('SAN ARRAY', 'SAN_ARRAY', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
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
    
        function CreateMasterDetailRecordGridForBROAD_EMC_LUN_METRICS_2DetailEdit0Grid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForBROAD_EMC_LUN_METRICS_2DetailEdit0');
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
            $result = new Grid($this, $this->dataset, 'BROAD_EMC_LUN_METRICS_2Grid');
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
    
            $this->SetShowPageList(false);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(false);
            $this->SetPrinterFriendlyAvailable(false);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            $handler = new PageHTTPHandler('BROAD_EMC_LUN_METRICS_2DetailView0_handler', new BROAD_EMC_LUN_METRICS_2DetailView0Page('BROAD.EMC LUN METRICS 2', 'BROAD.EMC LUN METRICS 2', array('SAN_ARRAY'), GetCurrentUserGrantForDataSource('BROAD.EMC_LUN_METRICS_2.'), 'UTF-8', 20, 'BROAD_EMC_LUN_METRICS_2DetailEdit0_handler'));
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new BROAD_EMC_LUN_METRICS_2DetailEdit0Page($this, array('SAN_ARRAY'), array('SAN_ARRAY'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForBROAD_EMC_LUN_METRICS_2DetailEdit0Grid(), $this->dataset, GetCurrentUserGrantForDataSource('BROAD.EMC_LUN_METRICS_2.'), 'UTF-8');
            $pageEdit->SetShortCaption('BROAD.EMC LUN METRICS 2');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('BROAD.EMC LUN METRICS 2');
            $pageEdit->SetHttpHandlerName('BROAD_EMC_LUN_METRICS_2DetailEdit0_handler');
            $handler = new PageHTTPHandler('BROAD_EMC_LUN_METRICS_2DetailEdit0_handler', $pageEdit);
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
        $Page = new BROAD_EMC_LUN_METRICS_2Page("BROAD.EMC_LUN_METRICS_2.php", "BROAD_EMC_LUN_METRICS_2", GetCurrentUserGrantForDataSource("BROAD_EMC_LUN_METRICS_2"), 'UTF-8');
        $Page->SetShortCaption('BROAD.EMC LUN METRICS 2');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('BROAD.EMC LUN METRICS 2');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("BROAD.EMC_LUN_METRICS_2"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
