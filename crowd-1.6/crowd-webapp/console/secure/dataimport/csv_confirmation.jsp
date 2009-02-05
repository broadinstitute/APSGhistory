<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('dataimport.csv.title')"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.csv.confirm')"/>"/>    
</head>
<body>

<h2>
    <ww:property value="getText('dataimport.csv.title')"/>
</h2>

<div class="page-content">
<ol class="tabs">

    <li>
        <a href='<ww:url action="importcsv" namespace="/console/secure/dataimport" method="default"/>'>
            1.&nbsp;
            <ww:property value="getText('dataimport.csv.configuration.label')"/>
        </a>
    </li>
    <li>
        <a href='<ww:url action="csvmapping" namespace="/console/secure/dataimport" method="default"/>'>
            2.&nbsp;
            <ww:property value="getText('dataimport.csv.mapping.label')"/>
        </a>
    </li>
    <li class="on">
        <span class="tab">3.&nbsp;<ww:property value="getText('dataimport.csv.confirmation.label')"/></span>
    </li>
    <li>
        <span class="tab">4.&nbsp;<ww:property value="getText('dataimport.result.label')"/></span>
    </li>
</ol>

<div class="tabContent static">

<div class="crowdForm">
<div class="titleSection">
    <ww:property value="getText('dataimport.csv.configuration.confirmation.text')"/>
</div>

<form name="dataimport" method="post" action="<ww:url namespace="/console/secure/dataimport" action="csvconfirm" method="doExecute" includeParams="none"/>">

<div class="formBody">

    <p>
        <ww:text name="dataimport.csv.configuration.directoryconfirmation.text">
            <ww:param id="0" value="directoryName"/>
        </ww:text>
    </p>

    <p>
        <ww:text name="dataimport.csv.configuration.userfile.label">
            <ww:param id="0" value="configuration.users.absolutePath"/>
        </ww:text>
    </p>

    <p>
        <ww:if test="configuration.groupMemberships.absolutePath != null">
            <ww:text name="dataimport.csv.configuration.groupmembershipfile.label">
                <ww:param id="0" value="configuration.groupMemberships.absolutePath"/>
            </ww:text>
        </ww:if>
    </p>

    <p>
        <ww:set name="encryptingPasswords" value="encryptingPasswords"/>
        <ww:if test="#encryptingPasswords != null">
            <ww:text name="dataimport.csv.configuration.passwordencrypted.label">
                <ww:param id="0" value="#encryptingPasswords"/>
            </ww:text>
        </ww:if>
    </p>

    <ww:if test="configuration.principalMappingConfiguration != null">
        <h3>
            <ww:text name="dataimport.csv.configuration.principalmapping.label"/>
        </h3>
        <table id="principalmappings">
            <tr>
                <th width="50%">
                    <ww:text name="dataimport.csv.configuration.headerrow"/>
                </th>
                <th width="50%">
                    <ww:text name="dataimport.csv.configuration.mapping"/>
                </th>
            </tr>
            <ww:iterator value="configuration.principalMappingConfiguration">
                <tr>
                    <td>
                        <ww:property value="getHeaderRowValue(key, false)"/>
                    </td>
                    <td>
                        <ww:property value="getText(value)"/>
                    </td>
                </tr>
            </ww:iterator>
        </table>
    </ww:if>

    <ww:if test="configuration.groupMappingConfiguration != null">
        <br/>

        <h3>
            <ww:text name="dataimport.csv.configuration.groupmapping.label"/>
        </h3>
        <table id="groupmappings">
            <tr>
                <th width="50%">
                    <ww:text name="dataimport.csv.configuration.headerrow"/>
                </th>
                <th width="50%">
                    <ww:text name="dataimport.csv.configuration.mapping"/>
                </th>
            </tr>
            <ww:iterator value="configuration.groupMappingConfiguration">
                <tr>
                    <td>
                        <ww:property value="getHeaderRowValue(key, true)"/>
                    </td>
                    <td>
                        <ww:property value="getText(value)"/>
                    </td>
                </tr>
            </ww:iterator>
        </table>
    </ww:if>
    <br/>
</div>

<div class="formFooter wizardFooter">

    <div class="buttons">

        <input type="button" name="backButton"
               value="&laquo; <ww:property value="getText('previous.label')"/>"
               title="&laquo; <ww:property value="getText('previous.label')"/>"
               onclick="location.href='<ww:url action="csvmapping" namespace="/console/secure/dataimport" method="default"/>'"/>
        <input type="submit" class="button"
               value="<ww:property value="getText('continue.label')"/> &raquo;"/>

    </div>
</div>

</form>

</div>

</div>
</div>
</body>
</html>