<?php

require_once 'phpgen_settings.php';
require_once 'components/page.php';
require_once 'components/security/security_info.php';
require_once 'components/security/server_side_auth.php';
require_once 'database_engine/oracle_engine.php';

$fixedRoles = array(
    'viewRole'      => new DataSourceSecurityInfo(true, false, false, false),
    'editRole'      => new DataSourceSecurityInfo(false, true, false, false),
    'addRole'       => new DataSourceSecurityInfo(false, false, true, false),
    'deleteRole'    => new DataSourceSecurityInfo(false, false, false, true),
    'admin'         => new AdminDataSourceSecurityInfo()
);

$userRoles = array(
    'defaultUser' => array('viewRole'),
    'guest' => array());

$usersIds = array();

$dataSourceRecordPermissions = array();

function SetUpUserAuthorization()
{
    global $fixedRoles;
    global $userRoles;
    global $usersIds;
    global $dataSourceRecordPermissions;
    
    $userAuthorizationStrategy = new ServerSideUserAuthorization($fixedRoles, 'guest', true, 'OPS$DAVE', 'BROAD');
    
    GetApplication()->SetUserAuthorizationStrategy($userAuthorizationStrategy);

    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(
        new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions)
    );
}

function GetIdentityCheckStrategy()
{
    return new ServerSideIdentityCheckStrategy(new OracleConnectionFactory(), GetGlobalConnectionOptions());
}

?>