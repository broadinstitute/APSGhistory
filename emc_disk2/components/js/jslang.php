<?php
set_include_path('../..' . PATH_SEPARATOR . get_include_path());
include_once 'components/captions.php';

header('Content-Type: application/json');

$captions = GetCaptions('UTF-8');

/**
 * @param Captions $captions
 * @param string $code
 * @internal param string $value
 * @param bool $suppressComma
 * @return void
 */
function BuildLocalizationString($captions, $code, $suppressComma = false)
{
    echo sprintf('"%s": "%s"', $code, $captions->GetMessageString($code));
    if (!$suppressComma)
        echo ',';
}

?>{<?php

BuildLocalizationString($captions, 'SaveAndInsert');
BuildLocalizationString($captions, 'SaveAndBackToList');
BuildLocalizationString($captions, 'SaveAndEdit');
BuildLocalizationString($captions, 'Save', true);

?>}