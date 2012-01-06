<?xml version="1.0" encoding="utf-8" ?>
<fieldvalues>
{foreach from=$ColumnValues key=name item=value name=Values}
    <fieldvalue name="{$name}">
    <![CDATA[
        <div>{$value}</div>
    ]]>
    </fieldvalue>
{/foreach}
</fieldvalues>
