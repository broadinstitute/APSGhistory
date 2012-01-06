<?php
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
    
    class BROAD_EMC_RAID_GROUPDetailView0Page extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."EMC_RAID_GROUP"');
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('OBJECT_NAME');
            $this->dataset->AddField($field, false);
            $field = new StringField('POLL_TIME');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('UTILIZATION_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('QUEUE_LENGTH');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('RESPONSE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('TOTAL_BANDWIDTH_MB_P_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('TOTAL_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_THROUGHPUTIO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('USED_PREFETCHES_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SP_CACHE_DIRTY_PAGES');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SP_CACHE_FORCED_FLUSHES');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVERAGE_BUSY_QUEUE_LEN');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('DISK_CROSSINGS_PER_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SERVICE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVERAGE_SEEK_DISTANCE_GB');
            $this->dataset->AddField($field, true);
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('SAN_ARRAY_handler');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('OBJECT_NAME_handler');
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
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
            $result = new Grid($this, $this->dataset, 'BROAD_EMC_RAID_GROUPDetailViewGrid0');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddFieldColumns($result);
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'OBJECT_NAME_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    ?><?php
    
    ?><?php
    
    class BROAD_EMC_RAID_GROUPDetailEdit0Page extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."EMC_RAID_GROUP"');
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('OBJECT_NAME');
            $this->dataset->AddField($field, false);
            $field = new StringField('POLL_TIME');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('UTILIZATION_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('QUEUE_LENGTH');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('RESPONSE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('TOTAL_BANDWIDTH_MB_P_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('TOTAL_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_THROUGHPUTIO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('USED_PREFETCHES_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SP_CACHE_DIRTY_PAGES');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SP_CACHE_FORCED_FLUSHES');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVERAGE_BUSY_QUEUE_LEN');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('DISK_CROSSINGS_PER_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SERVICE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVERAGE_SEEK_DISTANCE_GB');
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
            return null;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('BROAD_EMC_RAID_GROUPDetailEdit0ssearch', $this->dataset,
                array('SAN_ARRAY', 'OBJECT_NAME', 'POLL_TIME', 'UTILIZATION_PCT', 'QUEUE_LENGTH', 'RESPONSE_TIME_MS', 'TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL_THROUGHPUT_IO_SEC', 'READ_BANDWIDTH_MB_SEC', 'READ_SIZE_KB', 'READ_THROUGHPUT_IO_SEC', 'WRITE_BANDWIDTH_MB_SEC', 'WRITE_SIZE_KB', 'WRITE_THROUGHPUTIO_SEC', 'USED_PREFETCHES_PCT', 'SP_CACHE_DIRTY_PAGES', 'SP_CACHE_FORCED_FLUSHES', 'AVERAGE_BUSY_QUEUE_LEN', 'DISK_CROSSINGS_PER_SEC', 'SERVICE_TIME_MS', 'AVERAGE_SEEK_DISTANCE_GB'),
                array($this->RenderText('SAN ARRAY'), $this->RenderText('OBJECT NAME'), $this->RenderText('POLL TIME'), $this->RenderText('UTILIZATION PCT'), $this->RenderText('QUEUE LENGTH'), $this->RenderText('RESPONSE TIME MS'), $this->RenderText('TOTAL BANDWIDTH MB P SEC'), $this->RenderText('TOTAL THROUGHPUT IO SEC'), $this->RenderText('READ BANDWIDTH MB SEC'), $this->RenderText('READ SIZE KB'), $this->RenderText('READ THROUGHPUT IO SEC'), $this->RenderText('WRITE BANDWIDTH MB SEC'), $this->RenderText('WRITE SIZE KB'), $this->RenderText('WRITE THROUGHPUTIO SEC'), $this->RenderText('USED PREFETCHES PCT'), $this->RenderText('SP CACHE DIRTY PAGES'), $this->RenderText('SP CACHE FORCED FLUSHES'), $this->RenderText('AVERAGE BUSY QUEUE LEN'), $this->RenderText('DISK CROSSINGS PER SEC'), $this->RenderText('SERVICE TIME MS'), $this->RenderText('AVERAGE SEEK DISTANCE GB')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_EMC_RAID_GROUPDetailEdit0asearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('OBJECT_NAME', $this->RenderText('OBJECT NAME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('POLL_TIME', $this->RenderText('POLL TIME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('UTILIZATION_PCT', $this->RenderText('UTILIZATION PCT')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('QUEUE_LENGTH', $this->RenderText('QUEUE LENGTH')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('RESPONSE_TIME_MS', $this->RenderText('RESPONSE TIME MS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('TOTAL_BANDWIDTH_MB_P_SEC', $this->RenderText('TOTAL BANDWIDTH MB P SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('TOTAL_THROUGHPUT_IO_SEC', $this->RenderText('TOTAL THROUGHPUT IO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('READ_BANDWIDTH_MB_SEC', $this->RenderText('READ BANDWIDTH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('READ_SIZE_KB', $this->RenderText('READ SIZE KB')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('READ_THROUGHPUT_IO_SEC', $this->RenderText('READ THROUGHPUT IO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('WRITE_BANDWIDTH_MB_SEC', $this->RenderText('WRITE BANDWIDTH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('WRITE_SIZE_KB', $this->RenderText('WRITE SIZE KB')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('WRITE_THROUGHPUTIO_SEC', $this->RenderText('WRITE THROUGHPUTIO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('USED_PREFETCHES_PCT', $this->RenderText('USED PREFETCHES PCT')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SP_CACHE_DIRTY_PAGES', $this->RenderText('SP CACHE DIRTY PAGES')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SP_CACHE_FORCED_FLUSHES', $this->RenderText('SP CACHE FORCED FLUSHES')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVERAGE_BUSY_QUEUE_LEN', $this->RenderText('AVERAGE BUSY QUEUE LEN')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('DISK_CROSSINGS_PER_SEC', $this->RenderText('DISK CROSSINGS PER SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SERVICE_TIME_MS', $this->RenderText('SERVICE TIME MS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVERAGE_SEEK_DISTANCE_GB', $this->RenderText('AVERAGE SEEK DISTANCE GB')));
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
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('SAN_ARRAY_handler');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('OBJECT_NAME_handler');
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
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('SAN_ARRAY_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('OBJECT_NAME_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
            $result = new Grid($this, $this->dataset, 'BROAD_EMC_RAID_GROUPDetailEditGrid0');
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
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'OBJECT_NAME_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'OBJECT_NAME_handler', $column);
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
    ?><?php
    
    ?><?php
    
    class BROAD_EMC_RAID_GROUPPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."EMC_RAID_GROUP"');
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new StringField('OBJECT_NAME');
            $this->dataset->AddField($field, false);
            $field = new StringField('POLL_TIME');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('UTILIZATION_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('QUEUE_LENGTH');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('RESPONSE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('TOTAL_BANDWIDTH_MB_P_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('TOTAL_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('READ_THROUGHPUT_IO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_BANDWIDTH_MB_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_SIZE_KB');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('WRITE_THROUGHPUTIO_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('USED_PREFETCHES_PCT');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SP_CACHE_DIRTY_PAGES');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SP_CACHE_FORCED_FLUSHES');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVERAGE_BUSY_QUEUE_LEN');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('DISK_CROSSINGS_PER_SEC');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('SERVICE_TIME_MS');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('AVERAGE_SEEK_DISTANCE_GB');
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
            if (GetCurrentUserGrantForDataSource('BROAD.EMC_RAID_GROUP')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('BROAD.EMC RAID GROUP'), 'BROAD.EMC_RAID_GROUP.php', $this->RenderText('BROAD.EMC RAID GROUP'), $currentPageCaption == $this->RenderText('BROAD.EMC RAID GROUP')));
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('BROAD_EMC_RAID_GROUPssearch', $this->dataset,
                array('SAN_ARRAY', 'OBJECT_NAME', 'POLL_TIME', 'UTILIZATION_PCT', 'QUEUE_LENGTH', 'RESPONSE_TIME_MS', 'TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL_THROUGHPUT_IO_SEC', 'READ_BANDWIDTH_MB_SEC', 'READ_SIZE_KB', 'READ_THROUGHPUT_IO_SEC', 'WRITE_BANDWIDTH_MB_SEC', 'WRITE_SIZE_KB', 'WRITE_THROUGHPUTIO_SEC', 'USED_PREFETCHES_PCT', 'SP_CACHE_DIRTY_PAGES', 'SP_CACHE_FORCED_FLUSHES', 'AVERAGE_BUSY_QUEUE_LEN', 'DISK_CROSSINGS_PER_SEC', 'SERVICE_TIME_MS', 'AVERAGE_SEEK_DISTANCE_GB'),
                array($this->RenderText('SAN ARRAY'), $this->RenderText('OBJECT NAME'), $this->RenderText('POLL TIME'), $this->RenderText('UTILIZATION PCT'), $this->RenderText('QUEUE LENGTH'), $this->RenderText('RESPONSE TIME MS'), $this->RenderText('TOTAL BANDWIDTH MB P SEC'), $this->RenderText('TOTAL THROUGHPUT IO SEC'), $this->RenderText('READ BANDWIDTH MB SEC'), $this->RenderText('READ SIZE KB'), $this->RenderText('READ THROUGHPUT IO SEC'), $this->RenderText('WRITE BANDWIDTH MB SEC'), $this->RenderText('WRITE SIZE KB'), $this->RenderText('WRITE THROUGHPUTIO SEC'), $this->RenderText('USED PREFETCHES PCT'), $this->RenderText('SP CACHE DIRTY PAGES'), $this->RenderText('SP CACHE FORCED FLUSHES'), $this->RenderText('AVERAGE BUSY QUEUE LEN'), $this->RenderText('DISK CROSSINGS PER SEC'), $this->RenderText('SERVICE TIME MS'), $this->RenderText('AVERAGE SEEK DISTANCE GB')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_EMC_RAID_GROUPasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('OBJECT_NAME', $this->RenderText('OBJECT NAME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('POLL_TIME', $this->RenderText('POLL TIME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('UTILIZATION_PCT', $this->RenderText('UTILIZATION PCT')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('QUEUE_LENGTH', $this->RenderText('QUEUE LENGTH')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('RESPONSE_TIME_MS', $this->RenderText('RESPONSE TIME MS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('TOTAL_BANDWIDTH_MB_P_SEC', $this->RenderText('TOTAL BANDWIDTH MB P SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('TOTAL_THROUGHPUT_IO_SEC', $this->RenderText('TOTAL THROUGHPUT IO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('READ_BANDWIDTH_MB_SEC', $this->RenderText('READ BANDWIDTH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('READ_SIZE_KB', $this->RenderText('READ SIZE KB')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('READ_THROUGHPUT_IO_SEC', $this->RenderText('READ THROUGHPUT IO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('WRITE_BANDWIDTH_MB_SEC', $this->RenderText('WRITE BANDWIDTH MB SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('WRITE_SIZE_KB', $this->RenderText('WRITE SIZE KB')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('WRITE_THROUGHPUTIO_SEC', $this->RenderText('WRITE THROUGHPUTIO SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('USED_PREFETCHES_PCT', $this->RenderText('USED PREFETCHES PCT')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SP_CACHE_DIRTY_PAGES', $this->RenderText('SP CACHE DIRTY PAGES')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SP_CACHE_FORCED_FLUSHES', $this->RenderText('SP CACHE FORCED FLUSHES')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVERAGE_BUSY_QUEUE_LEN', $this->RenderText('AVERAGE BUSY QUEUE LEN')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('DISK_CROSSINGS_PER_SEC', $this->RenderText('DISK CROSSINGS PER SEC')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SERVICE_TIME_MS', $this->RenderText('SERVICE TIME MS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('AVERAGE_SEEK_DISTANCE_GB', $this->RenderText('AVERAGE SEEK DISTANCE GB')));
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
            if (GetCurrentUserGrantForDataSource('BROAD_EMC_RAID_GROUPDetailView0')->HasViewGrant())
            {
              //
            // View column for BROAD_EMC_RAID_GROUPDetailView0 detail
            //
            $column = new DetailColumn(array('SAN_ARRAY'), 'detail0', 'BROAD_EMC_RAID_GROUPDetailEdit0_handler', 'BROAD_EMC_RAID_GROUPDetailView0_handler', $this->dataset, 'BROAD.EMC RAID GROUP');
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('SAN_ARRAY_handler');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('OBJECT_NAME_handler');
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
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('SAN_ARRAY_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('OBJECT_NAME_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for POLL_TIME field
            //
            $column = new TextViewColumn('POLL_TIME', 'POLL TIME', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
    
        function CreateMasterDetailRecordGridForBROAD_EMC_RAID_GROUPDetailEdit0Grid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForBROAD_EMC_RAID_GROUPDetailEdit0');
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetName('master_grid');
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('SAN_ARRAY_handler');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('OBJECT_NAME_handler');
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
            // View column for UTILIZATION_PCT field
            //
            $column = new TextViewColumn('UTILIZATION_PCT', 'UTILIZATION PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for QUEUE_LENGTH field
            //
            $column = new TextViewColumn('QUEUE_LENGTH', 'QUEUE LENGTH', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for RESPONSE_TIME_MS field
            //
            $column = new TextViewColumn('RESPONSE_TIME_MS', 'RESPONSE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for TOTAL_BANDWIDTH_MB_P_SEC field
            //
            $column = new TextViewColumn('TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL BANDWIDTH MB P SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for TOTAL_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('TOTAL_THROUGHPUT_IO_SEC', 'TOTAL THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for READ_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('READ_BANDWIDTH_MB_SEC', 'READ BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for READ_SIZE_KB field
            //
            $column = new TextViewColumn('READ_SIZE_KB', 'READ SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for READ_THROUGHPUT_IO_SEC field
            //
            $column = new TextViewColumn('READ_THROUGHPUT_IO_SEC', 'READ THROUGHPUT IO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for WRITE_BANDWIDTH_MB_SEC field
            //
            $column = new TextViewColumn('WRITE_BANDWIDTH_MB_SEC', 'WRITE BANDWIDTH MB SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for WRITE_SIZE_KB field
            //
            $column = new TextViewColumn('WRITE_SIZE_KB', 'WRITE SIZE KB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for WRITE_THROUGHPUTIO_SEC field
            //
            $column = new TextViewColumn('WRITE_THROUGHPUTIO_SEC', 'WRITE THROUGHPUTIO SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for USED_PREFETCHES_PCT field
            //
            $column = new TextViewColumn('USED_PREFETCHES_PCT', 'USED PREFETCHES PCT', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for SP_CACHE_DIRTY_PAGES field
            //
            $column = new TextViewColumn('SP_CACHE_DIRTY_PAGES', 'SP CACHE DIRTY PAGES', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for SP_CACHE_FORCED_FLUSHES field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES', 'SP CACHE FORCED FLUSHES', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVERAGE_BUSY_QUEUE_LEN field
            //
            $column = new TextViewColumn('AVERAGE_BUSY_QUEUE_LEN', 'AVERAGE BUSY QUEUE LEN', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for DISK_CROSSINGS_PER_SEC field
            //
            $column = new TextViewColumn('DISK_CROSSINGS_PER_SEC', 'DISK CROSSINGS PER SEC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for SERVICE_TIME_MS field
            //
            $column = new TextViewColumn('SERVICE_TIME_MS', 'SERVICE TIME MS', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $column = new TextViewColumn('AVERAGE_SEEK_DISTANCE_GB', 'AVERAGE SEEK DISTANCE GB', $this->dataset);
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
        public function ShowDeleteButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasDeleteGrant($this->GetDataset());
        }
        
        public function GetModalGridDeleteHandler() { return 'BROAD_EMC_RAID_GROUP_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'BROAD_EMC_RAID_GROUPGrid');
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
            $handler = new PageHTTPHandler('BROAD_EMC_RAID_GROUPDetailView0_handler', new BROAD_EMC_RAID_GROUPDetailView0Page('BROAD.EMC RAID GROUP', 'BROAD.EMC RAID GROUP', array('SAN_ARRAY'), GetCurrentUserGrantForDataSource('BROAD_EMC_RAID_GROUPDetailView0'), 'UTF-8', 20, 'BROAD_EMC_RAID_GROUPDetailEdit0_handler'));
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new BROAD_EMC_RAID_GROUPDetailEdit0Page($this, array('SAN_ARRAY'), array('SAN_ARRAY'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForBROAD_EMC_RAID_GROUPDetailEdit0Grid(), $this->dataset, GetCurrentUserGrantForDataSource('BROAD_EMC_RAID_GROUPDetailEdit0'), 'UTF-8');
            $pageEdit->SetShortCaption('BROAD.EMC RAID GROUP');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('BROAD.EMC RAID GROUP');
            $pageEdit->SetHttpHandlerName('BROAD_EMC_RAID_GROUPDetailEdit0_handler');
            $handler = new PageHTTPHandler('BROAD_EMC_RAID_GROUPDetailEdit0_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'OBJECT_NAME_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for OBJECT_NAME field
            //
            $column = new TextViewColumn('OBJECT_NAME', 'OBJECT NAME', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'OBJECT_NAME_handler', $column);
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
        $Page = new BROAD_EMC_RAID_GROUPPage("BROAD.EMC_RAID_GROUP.php", "BROAD_EMC_RAID_GROUP", GetCurrentUserGrantForDataSource("BROAD_EMC_RAID_GROUP"), 'UTF-8');
        $Page->SetShortCaption('BROAD.EMC RAID GROUP');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('BROAD.EMC RAID GROUP');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("BROAD_EMC_RAID_GROUP"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
