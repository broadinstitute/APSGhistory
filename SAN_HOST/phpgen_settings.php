<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


require_once 'components/utils/system_utils.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('America/New_York');

function GetGlobalConnectionOptions()
{
    return array(
  'username' => 'OPS$DAVE',
  'password' => 'BROAD',
  'database' => 'EMGC11G_LUTETIUM'
);
}

function GetPageInfos()
{
    $result = array();
    
    return $result;
}

function GetPagesHeader()
{
    return
    '<div style="width: 100%; color: red;"><h2 style="color: red;">This website was created by Dave Gregoire.</h2><h2 style="color: red;">The Broad Institute.</h2></div>';
}

function GetPagesFooter()
{
    return
        '<div style="width: 100%; text-align: center;" align="center"><div style="text-align: right; padding: 4px; border: 1px solid black;"><a href="http://www.sqlmaestro.com/products/oracle/phpgenerator/">(C) 2002-2009 SQL Maestro Group</a></div></div>'; 
    }

function ApplyCommonPageSettings($page, $grid)
{
    $page->SetShowUserAuthBar(false);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
}

/*
  Default code page: 1252
*/
function GetAnsiEncoding() { return 'windows-1252'; }

function Global_BeforeUpdateHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeDeleteHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeInsertHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}
?>
