<?php

require_once 'string_utils.php';

class StyleBuilder
{
    private $styles;
    private $styleStrings;

    public function  __construct()
    {
        $this->styles = array();
        $this->styleStrings = array();
    }

    public function Add($paramName, $paramValue)
    {
        $this->styles[$paramName] = $paramValue;
    }

    public function AddStyleString($styleString)
    {
        $this->styleStrings[] = $styleString;
    }

    public function Remove($paramName)
    {
        unset($this->styles[$paramName]);
    }

    public function Clear()
    {
        $this->styles = array();
    }

    public function IsEmpty()
    {
        return 
            (count($this->styles) == 0) && 
            (count($this->styleStrings) == 0);
    }

    public function GetStyleString()
    {
        $result = '';
        foreach($this->styles as $paramName => $paramValue)
            StringUtils::AddStr($result, "$paramName: $paramValue;", ' ');

        foreach($this->styleStrings as $styleString)
        {
            if (!StringUtils::IsNullOrEmpty($styleString) && !StringUtils::EndsBy($styleString, ';'))
                $styleString .= ';';
            StringUtils::AddStr($result, $styleString, ' ');
        }
        return $result;
    }
}
?>