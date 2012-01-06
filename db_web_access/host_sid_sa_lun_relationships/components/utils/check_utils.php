<?php

function CheckPHPVersion()
{
    $versionString = phpversion();
    $version = explode('.', $versionString);
    if ($version[0] < 5)
    {
        header('Content-Type: text/html; charset=UTF-8');
        echo str_replace('{PHP_VERSION}', $versionString,
            file_get_contents('components/templates/unsupported_php_version.html'));
        exit;
    }
}

?>