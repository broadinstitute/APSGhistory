<?php

class JavaScriptStringLiteralEscapeMode
{
    const DoubleQuote = 1;
    const SingleQuote = 2;
}

class StringUtils
{
    const EmptyStr = '';
    const Space = ' ';

    public static function SameText($val1, $val2)
    {
        return strtolower($val1) == strtolower($val2);
    }

    public static function JSStringLiteral($stringLiteral, 
        $mode = JavaScriptStringLiteralEscapeMode::DoubleQuote)
    {
        switch ($mode)
        {
            case JavaScriptStringLiteralEscapeMode::DoubleQuote:
                $searches = array( '"', "\n" );
                $replacements = array( '\\"', "\\n\"\n\t+\"" );
                $quote = '"';
                break;
            case JavaScriptStringLiteralEscapeMode::SingleQuote:
                $searches = array( "'", "\n" );
                $replacements = array( "\\'", "\\n'\n\t+'" );
                $quote = "'";
                break;
        }
        return $quote . str_replace( $searches, $replacements, $stringLiteral ) . $quote;
    }

    public static function ReplaceVariableInTemplate($template, $varName, $varValue)
    {
        return str_ireplace('%' . $varName . '%', $varValue, $template);
    }

    public static function StartsWith($string, $pattern)
    {
        $matches = array();
        return preg_match("/^$pattern/", $string, $matches) >= 1;
    }

    public static function EndsBy($string, $pattern)
    {
        $matches = array();
        return preg_match('/' . $pattern . '$/', $string, $matches) >= 1;
    }

    public static function Contains($string, $pattern)
    {
        $matches = array();
        return preg_match("/$pattern/", $string, $matches) >= 1;
    }

    public static function EscapeXmlString($strin) 
    {
        $strout = null;

        for ($i = 0; $i < strlen($strin); $i++) {
            $ord = ord($strin[$i]);

            if (($ord > 0 && $ord < 32) || ($ord >= 127)) {
                $strout .= "&amp;#{$ord};";
            }
            else {
                switch ($strin[$i]) {
                    case '<':
                        $strout .= '&lt;';
                        break;
                    case '>':
                        $strout .= '&gt;';
                        break;
                    case '&':
                        $strout .= '&amp;';
                        break;
                    case '"':
                        $strout .= '&quot;';
                        break;
                    default:
                        $strout .= $strin[$i];
                }
            }
        }

        return $strout;
    }

    public static function AddStr(&$result, $string, $delimiter = '')
    {
        if (isset($string) && $string != '')
        {
            if(!($result == ''))
                $result = $result . $delimiter;
            $result = $result . $string;
        }
    }

    public static function Replace($oldValue, $newValue, $string)
    {
        return str_replace($oldValue, $newValue, $string);
    }
    
    public static function ApplyVarablesMapToTemplate($template, $varArray)
    {
        $result = $template;
        foreach($varArray as $varName => $varValue)
            $result = StringUtils::ReplaceVariableInTemplate($result, $varName, $varValue);
        return $result;
    }

    public static function Combine($Left, $Right, $Delimiter = ' = ')
    {
        return $Left . $Delimiter . $Right;
    }

    public static function IsNullOrEmpty($value, $trimmed = false)
    {
        if (!isset($value))
            return true;
        else if (!$trimmed)
            return ($value === '');
        else
            return (trim($value) === '');
    }

    public static function ReplaceIllegalPostVariableNameChars($string)
    {
        return StringUtils::Replace(' ', '_', $string);
    }

    public static function Format($format)
    {
        $arg_list = func_get_args(); 
        return call_user_func_array('sprintf', $arg_list);
    }    
}

?>