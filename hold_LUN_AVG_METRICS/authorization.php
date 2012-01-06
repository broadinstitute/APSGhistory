<?php

require_once 'components/page.php';
require_once 'components/security/datasource_security_info.php';
require_once 'components/security/security_info.php';
require_once 'components/security/hardcoded_auth.php';
require_once 'components/security/user_grants_manager.php';

$users = array('broad' => 'broad');

$usersIds = array('broad' => -1);

$dataSourceRecordPermissions = array();

$grants = array('guest' => 
        array()
    ,
    'defaultUser' => 
        array('BROAD_AVG_LUN_METRICS_BY_TIMESLICE' => new DataSourceSecurityInfo(false, false, false, false),
        'BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'guest' => 
        array('BROAD_AVG_LUN_METRICS_BY_TIMESLICE' => new DataSourceSecurityInfo(false, false, false, false),
        'BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'broad' => 
        array('BROAD_AVG_LUN_METRICS_BY_TIMESLICE' => new DataSourceSecurityInfo(false, false, false, false),
        'BROAD_AVG_LUN_METRICS_BY_TIMESLICEDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false))
    );

$appGrants = array('guest' => new DataSourceSecurityInfo(false, false, false, false),
    'defaultUser' => new DataSourceSecurityInfo(true, false, false, false),
    'guest' => new DataSourceSecurityInfo(false, false, false, false),
    'broad' => new AdminDataSourceSecurityInfo());

function SetUpUserAuthorization()
{
    global $usersIds;
    global $grants;
    global $appGrants;
    global $dataSourceRecordPermissions;
    $userAuthorizationStrategy = new HardCodedUserAuthorization(new HardCodedUserGrantsManager($grants, $appGrants), $usersIds);
    GetApplication()->SetUserAuthorizationStrategy($userAuthorizationStrategy);

GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(
    new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}

function GetIdentityCheckStrategy()
{
    global $users;
    return new SimpleIdentityCheckStrategy($users, ENCRYPTION_NONE);
}

?>