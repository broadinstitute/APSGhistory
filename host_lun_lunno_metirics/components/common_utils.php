<?php

require_once 'utils/string_utils.php';
require_once 'utils/dataset_utils.php';

// TODO : move to dataset utils
function FormatDatasetFieldsTemplate($dataset, $template)
{
    return DatasetUtils::FormatDatasetFieldsTemplate($dataset, $template);
}

function ApplyVarablesMapToTemplate($template, $varArray)
{
    return StringUtils::ApplyVarablesMapToTemplate($template, $varArray);
}

function FormatExceptionTrace($exception)
{
    return '<pre>'.$exception->getTraceAsString().'</pre>';
}

define('METHOD_POST', 1); // deprectated
define('METHOD_GET', 2); // deprectated

// TODO : deprectated function, use the SuperGlobals 
function ExtractInputValue($name, $method = METHOD_GET)
{
    $result = null;
    if ($method == METHOD_GET)
    {
        if (GetApplication()->IsGETValueSet($name))
        {
            $result = GetApplication()->GetGETValue($name);
        }
    }
    elseif ($method == METHOD_POST)
    {
        if (GetApplication()->IsPOSTValueSet($name))
        {
            $result = GetApplication()->GetPOSTValue($name);
        }
    }
    return $result;
}

function ExtractPrimaryKeyValues(&$primaryKeyValues, $method = METHOD_GET)
{
    $paramNumber = 0;
    if ($method == METHOD_GET)
    {
        while(GetApplication()->IsGETValueSet("pk$paramNumber"))
        {
            $primaryKeyValues[] = GetApplication()->GetGETValue("pk$paramNumber");
            $paramNumber++;
        }
    }
    elseif ($method == METHOD_POST)
    {
        while(GetApplication()->IsPOSTValueSet("pk$paramNumber"))
        {
            $primaryKeyValues[] = GetApplication()->GetPOSTValue("pk$paramNumber");
            $paramNumber++;
        }
    }
}

function AddPrimaryKeyParametersToArray(&$targetArray, $primaryKeyValues)
{
    $paramNumber = 0;
    foreach($primaryKeyValues as $primaryKeyValue)
    {
        $targetArray["pk$paramNumber"] = $primaryKeyValue;
        $paramNumber++;
    }
}

function AddPrimaryKeyParameters($linkBuilder, $PrimaryKeyValues)
{
    $KeyValueList = '';
    $KeyValueNumber = 0;
    foreach($PrimaryKeyValues as $PrimaryKeyValue)
    {
        $linkBuilder->AddParameter("pk$KeyValueNumber", $PrimaryKeyValue);
        $KeyValueNumber ++;
    }
    return $KeyValueList;
}

function BuildPrimaryKeyLink($PrimaryKeyValues)
{
    $KeyValueList = '';
    $KeyValueNumber = 0;
    foreach($PrimaryKeyValues as $PrimaryKeyValue)
    {
        AddStr($KeyValueList, "pk$KeyValueNumber=$PrimaryKeyValue", '&');
        $KeyValueNumber ++;
    }
    return $KeyValueList;
}

// TODO : move to StringUtils and add description
function ReplaceFirst($target, $pattern, $newValue)
{
    $result = preg_replace("/(\W|\s)$pattern((\W|\s)|$)/i", "\${1}".'___SM_REMPLACEMENT_STUB___'."\${2}", $target);
    return str_replace('___SM_REMPLACEMENT_STUB___', $newValue, $result);
}

function ConvertTextToEncoding($text, $sourceEncoding, $targetEncoding)
{
    $iconvEncodings = array('windows-1250', 'windows-1253', 'windows-1254', 'windows-1255', 'windows-1256', 'windows-1257');

    if ($sourceEncoding != '' && $targetEncoding != '' && $targetEncoding != $sourceEncoding) 
    {
        if (!in_array($sourceEncoding, $iconvEncodings) && function_exists("mb_convert_encoding"))
        {
            if ($sourceEncoding == null)
                return mb_convert_encoding($text, $targetEncoding);
            else
                return mb_convert_encoding($text, $targetEncoding, $sourceEncoding);
        }
        elseif (function_exists("iconv")) 
            return iconv($sourceEncoding, $targetEncoding, $text);
        else
            return $text;
    } 
    else 
    {
        return $text;
    }
}

// TODO : use StringUtils::AddStr intead
function AddStr(&$AResult, $AString, $ADelimiter = '')
{
    if(isset($AString) && $AString != '')
    {
        if(!($AResult == ''))
            $AResult = $AResult . $ADelimiter;
        $AResult = $AResult . $AString;
    }
}

function Combine($Left, $Right, $Delimiter = ' = ')
{
    return StringUtils::Combine($Left, $Right, $Delimiter);
}

?>