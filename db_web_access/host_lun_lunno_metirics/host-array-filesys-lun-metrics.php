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

    class BROAD_HOST_LUN_LUN_NO_METRICSDetailView0Page extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."HOST_LUN_LUN_NO_METRICS"');
            $field = new StringField('HOST_NAME');
            $this->dataset->AddField($field, true);
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('LUN_NO');
            $this->dataset->AddField($field, true);
            $field = new StringField('FILE_SYSTEM');
            $this->dataset->AddField($field, true);
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
            $field = new IntegerField('SP_CACHE_FORCED_FLUSHES_SEC');
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
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);

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
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);

            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('FILE_SYSTEM_handler');
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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

            /* <inline insert column> */
            //
            // Edit column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $editor = new TextEdit('average_seek_distance_gb_edit');
            $editColumn = new CustomEditColumn('AVERAGE SEEK DISTANCE GB', 'AVERAGE_SEEK_DISTANCE_GB', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
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
            $result = new Grid($this, $this->dataset, 'BROAD_HOST_LUN_LUN_NO_METRICSDetailViewGrid0');
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
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'FILE_SYSTEM_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }



    ?><?php

    ?><?php

    class BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0Page extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."HOST_LUN_LUN_NO_METRICS"');
            $field = new StringField('HOST_NAME');
            $this->dataset->AddField($field, true);
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('LUN_NO');
            $this->dataset->AddField($field, true);
            $field = new StringField('FILE_SYSTEM');
            $this->dataset->AddField($field, true);
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
            $field = new IntegerField('SP_CACHE_FORCED_FLUSHES_SEC');
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
            $grid->SearchControl = new SimpleSearch('BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0ssearch', $this->dataset,
                array('HOST_NAME', 'SAN_ARRAY', 'LUN_NO', 'FILE_SYSTEM', 'POLL_TIME', 'UTILIZATION_PCT', 'QUEUE_LENGTH', 'RESPONSE_TIME_MS', 'TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL_THROUGHPUT_IO_SEC', 'READ_BANDWIDTH_MB_SEC', 'READ_SIZE_KB', 'READ_THROUGHPUT_IO_SEC', 'WRITE_BANDWIDTH_MB_SEC', 'WRITE_SIZE_KB', 'WRITE_THROUGHPUTIO_SEC', 'USED_PREFETCHES_PCT', 'SP_CACHE_FORCED_FLUSHES_SEC', 'AVERAGE_BUSY_QUEUE_LEN', 'DISK_CROSSINGS_PER_SEC', 'SERVICE_TIME_MS', 'AVERAGE_SEEK_DISTANCE_GB'),
                array($this->RenderText('HOST NAME'), $this->RenderText('SAN ARRAY'), $this->RenderText('LUN NO'), $this->RenderText('FILE SYSTEM'), $this->RenderText('POLL TIME'), $this->RenderText('UTILIZATION PCT'), $this->RenderText('QUEUE LENGTH'), $this->RenderText('RESPONSE TIME MS'), $this->RenderText('TOTAL BANDWIDTH MB P SEC'), $this->RenderText('TOTAL THROUGHPUT IO SEC'), $this->RenderText('READ BANDWIDTH MB SEC'), $this->RenderText('READ SIZE KB'), $this->RenderText('READ THROUGHPUT IO SEC'), $this->RenderText('WRITE BANDWIDTH MB SEC'), $this->RenderText('WRITE SIZE KB'), $this->RenderText('WRITE THROUGHPUTIO SEC'), $this->RenderText('USED PREFETCHES PCT'), $this->RenderText('SP CACHE FORCED FLUSHES SEC'), $this->RenderText('AVERAGE BUSY QUEUE LEN'), $this->RenderText('DISK CROSSINGS PER SEC'), $this->RenderText('SERVICE TIME MS'), $this->RenderText('AVERAGE SEEK DISTANCE GB')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0asearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('HOST_NAME', $this->RenderText('HOST NAME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('LUN_NO', $this->RenderText('LUN NO')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FILE_SYSTEM', $this->RenderText('FILE SYSTEM')));
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
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SP_CACHE_FORCED_FLUSHES_SEC', $this->RenderText('SP CACHE FORCED FLUSHES SEC')));
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
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(true);
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

            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('FILE_SYSTEM_handler');
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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

            /* <inline insert column> */
            //
            // Edit column for AVERAGE_SEEK_DISTANCE_GB field
            //
            $editor = new TextEdit('average_seek_distance_gb_edit');
            $editColumn = new CustomEditColumn('AVERAGE SEEK DISTANCE GB', 'AVERAGE_SEEK_DISTANCE_GB', $editor, $this->dataset);
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
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('FILE_SYSTEM_handler');
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
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
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
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
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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
        public function ShowDeleteButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasDeleteGrant($this->GetDataset());
        }

        public function GetModalGridDeleteHandler() { return 'BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0_modal_delete'; }
        protected function GetEnableModalGridDelete() { return true; }

        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'BROAD_HOST_LUN_LUN_NO_METRICSDetailEditGrid0');
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
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'FILE_SYSTEM_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'FILE_SYSTEM_handler', $column);
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

    class BROAD_HOST_LUN_LUN_NO_METRICSPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new OracleConnectionFactory(),
                GetConnectionOptions(),
                '"BROAD"."HOST_LUN_LUN_NO_METRICS"');
            $field = new StringField('HOST_NAME');
            $this->dataset->AddField($field, true);
            $field = new StringField('SAN_ARRAY');
            $this->dataset->AddField($field, true);
            $field = new IntegerField('LUN_NO');
            $this->dataset->AddField($field, true);
            $field = new StringField('FILE_SYSTEM');
            $this->dataset->AddField($field, true);
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
            $field = new IntegerField('SP_CACHE_FORCED_FLUSHES_SEC');
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
            $partitionNavigator->SetRowsPerPage(30);
            $result->AddPageNavigator($partitionNavigator);

            return $result;
        }

        public function GetPageList()
        {
            $currentPageCaption = $this->GetShortCaption();
            $result = new PageList();
            if (GetCurrentUserGrantForDataSource('BROAD.HOST_LUN_LUN_NO_METRICS')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('host-array-filesys-lun-metrics'), 'host-array-filesys-lun-metrics.php', $this->RenderText('host-array-filesys-lun-metrics'), $currentPageCaption == $this->RenderText('host-array-filesys-lun-metrics')));
            return $result;
        }

        protected function CreateRssGenerator()
        {
            return null;
        }

        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('BROAD_HOST_LUN_LUN_NO_METRICSssearch', $this->dataset,
                array('HOST_NAME', 'SAN_ARRAY', 'LUN_NO', 'FILE_SYSTEM', 'POLL_TIME', 'UTILIZATION_PCT', 'QUEUE_LENGTH', 'RESPONSE_TIME_MS', 'TOTAL_BANDWIDTH_MB_P_SEC', 'TOTAL_THROUGHPUT_IO_SEC', 'READ_BANDWIDTH_MB_SEC', 'READ_SIZE_KB', 'READ_THROUGHPUT_IO_SEC', 'WRITE_BANDWIDTH_MB_SEC', 'WRITE_SIZE_KB', 'WRITE_THROUGHPUTIO_SEC', 'USED_PREFETCHES_PCT', 'SP_CACHE_FORCED_FLUSHES_SEC', 'AVERAGE_BUSY_QUEUE_LEN', 'DISK_CROSSINGS_PER_SEC', 'SERVICE_TIME_MS', 'AVERAGE_SEEK_DISTANCE_GB'),
                array($this->RenderText('HOST NAME'), $this->RenderText('SAN ARRAY'), $this->RenderText('LUN NO'), $this->RenderText('FILE SYSTEM'), $this->RenderText('POLL TIME'), $this->RenderText('UTILIZATION PCT'), $this->RenderText('QUEUE LENGTH'), $this->RenderText('RESPONSE TIME MS'), $this->RenderText('TOTAL BANDWIDTH MB P SEC'), $this->RenderText('TOTAL THROUGHPUT IO SEC'), $this->RenderText('READ BANDWIDTH MB SEC'), $this->RenderText('READ SIZE KB'), $this->RenderText('READ THROUGHPUT IO SEC'), $this->RenderText('WRITE BANDWIDTH MB SEC'), $this->RenderText('WRITE SIZE KB'), $this->RenderText('WRITE THROUGHPUTIO SEC'), $this->RenderText('USED PREFETCHES PCT'), $this->RenderText('SP CACHE FORCED FLUSHES SEC'), $this->RenderText('AVERAGE BUSY QUEUE LEN'), $this->RenderText('DISK CROSSINGS PER SEC'), $this->RenderText('SERVICE TIME MS'), $this->RenderText('AVERAGE SEEK DISTANCE GB')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('BROAD_HOST_LUN_LUN_NO_METRICSasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('HOST_NAME', $this->RenderText('HOST NAME')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SAN_ARRAY', $this->RenderText('SAN ARRAY')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('LUN_NO', $this->RenderText('LUN NO')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FILE_SYSTEM', $this->RenderText('FILE SYSTEM')));
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
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SP_CACHE_FORCED_FLUSHES_SEC', $this->RenderText('SP CACHE FORCED FLUSHES SEC')));
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
        }

        protected function AddFieldColumns($grid)
        {
            if (GetCurrentUserGrantForDataSource('BROAD_HOST_LUN_LUN_NO_METRICSDetailView0')->HasViewGrant())
            {
              //
            // View column for BROAD_HOST_LUN_LUN_NO_METRICSDetailView0 detail
            //
            $column = new DetailColumn(array('HOST_NAME'), 'detail0', 'BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0_handler', 'BROAD_HOST_LUN_LUN_NO_METRICSDetailView0_handler', $this->dataset, 'BROAD.HOST LUN LUN NO METRICS');
              $grid->AddViewColumn($column);
            }

            //
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(true);
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

            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('FILE_SYSTEM_handler');
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('FILE_SYSTEM_handler');
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
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
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
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
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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

        function CreateMasterDetailRecordGridForBROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0Grid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForBROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0');
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetName('master_grid');
            //
            // View column for HOST_NAME field
            //
            $column = new TextViewColumn('HOST_NAME', 'HOST NAME', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);

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
            // View column for LUN_NO field
            //
            $column = new TextViewColumn('LUN_NO', 'LUN NO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);

            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('FILE_SYSTEM_handler');
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
            // View column for SP_CACHE_FORCED_FLUSHES_SEC field
            //
            $column = new TextViewColumn('SP_CACHE_FORCED_FLUSHES_SEC', 'SP CACHE FORCED FLUSHES SEC', $this->dataset);
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

        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'BROAD_HOST_LUN_LUN_NO_METRICSGrid');
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
            $handler = new PageHTTPHandler('BROAD_HOST_LUN_LUN_NO_METRICSDetailView0_handler', new BROAD_HOST_LUN_LUN_NO_METRICSDetailView0Page('host-array-filesys-lun-metrics', 'host-array-filesys-lun-metrics', array('LUN_NO'), GetCurrentUserGrantForDataSource('BROAD_HOST_LUN_LUN_NO_METRICSDetailView0'), 'UTF-8', 20, 'BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0_handler'));
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0Page($this, array('LUN_NO'), array('HOST_NAME'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForBROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0Grid(), $this->dataset, GetCurrentUserGrantForDataSource('BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0'), 'UTF-8');
            $pageEdit->SetShortCaption('host-array-filesys-lun-metrics');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('host-array-filesys-lun-metrics');
            $pageEdit->SetHttpHandlerName('BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0_handler');
            $handler = new PageHTTPHandler('BROAD_HOST_LUN_LUN_NO_METRICSDetailEdit0_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'FILE_SYSTEM_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for SAN_ARRAY field
            //
            $column = new TextViewColumn('SAN_ARRAY', 'SAN ARRAY', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'SAN_ARRAY_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for FILE_SYSTEM field
            //
            $column = new TextViewColumn('FILE_SYSTEM', 'FILE SYSTEM', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'FILE_SYSTEM_handler', $column);
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
        $Page = new BROAD_HOST_LUN_LUN_NO_METRICSPage("host-array-filesys-lun-metrics.php", "BROAD_HOST_LUN_LUN_NO_METRICS", GetCurrentUserGrantForDataSource("BROAD_HOST_LUN_LUN_NO_METRICS"), 'UTF-8');
        $Page->SetShortCaption('host-array-filesys-lun-metrics');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('host-array-filesys-lun-metrics');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("BROAD_HOST_LUN_LUN_NO_METRICS"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
