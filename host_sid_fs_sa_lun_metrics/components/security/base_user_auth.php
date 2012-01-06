<?php

require_once 'datasource_security_info.php';

define('ENCRYPTION_NONE', 0);
define('ENCRYPTION_MD5', 1);
define('ENCRYPTION_SHA1', 2);
define('ENCRYPTION_PHPASS', 3);

abstract class AbstractUserAuthorization
{
    public abstract function GetCurrentUserId();

    public abstract function GetCurrentUser();

    public abstract function IsCurrentUserLoggedIn();

    public abstract function GetUserRoles($userName, $dataSourceName);
    
    public function ApplyIdentityToConnectionOptions(&$connectoinOptions) { }
}

class NullUserAuthorization
{
    public function GetCurrentUser()
    {
        return null; 
    }
    
    public function GetUserRoles($userName, $dataSourceName)
    {
        return new AdminDataSourceSecurityInfo();
    } 
    
    public function IsCurrentUserLoggedIn() { }

    public function GetCurrentUserId()
    {
        return 0; 
    }    
    
    public function ApplyIdentityToConnectionOptions(&$connectoinOptions) { }
}

class IdentityCheckStrategy
{
    function ApplyIdentityToConnectionOptions($connectionOptions) { }
}

?>