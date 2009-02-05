<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('dataimport.csv.title')"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.csv.mapping')"/>"/>    
</head>
<body>

<h2>
    <ww:property value="getText('dataimport.csv.title')"/>
</h2>

<div class="page-content">
    <ol class="tabs">

        <li>
            <a href='<ww:url action="importcsv" namespace="/console/secure/dataimport" method="default"/>'>
            1.&nbsp;<ww:property value="getText('dataimport.csv.configuration.label')"/>
            </a>
        </li>
        <li class="on">
            <span class="tab">2.&nbsp;<ww:property value="getText('dataimport.csv.mapping.label')"/></span>
        </li>
        <li>
            <span class="tab">3.&nbsp;<ww:property value="getText('dataimport.csv.confirmation.label')"/></span>
        </li>
        <li>
            <span class="tab">4.&nbsp;<ww:property value="getText('dataimport.result.label')"/></span>
        </li>
    </ol>

    <div class="tabContent static">

        <div class="crowdForm">
            <div class="titleSection">
                <ww:property value="getText('dataimport.csv.configuration.text')"/>
            </div>

            <form name="dataimport" method="post" action="<ww:url namespace="/console/secure/dataimport" action="csvmapping" method="doExecute" includeParams="none"/>">

                <div class="formBody">

                    <ww:component template="form_messages.jsp"/>
                    <h3><ww:text name="dataimport.csv.configuration.principalmapping.label" /></h3>
                    <table>
                        <tr>
                            <th width="15%">
                                <ww:text name="dataimport.csv.configuration.headerrow" />
                            </th>
                            <th width="35%">
                                <ww:text name="dataimport.csv.configuration.sampledata" />
                            </th>
                            <th width="50%">
                                <ww:text name="dataimport.csv.configuration.mapping" />
                            </th>
                        <ww:iterator value="configuration.principalHeaderRow" status="rowStatus">
                        <tr>
                            <td>
                                <ww:property />
                            </td>
                            <td>
                                <ww:property value="configuration.principalSampleRow.get(#rowStatus.index)" />
                            </td>
                            <td>
                                <select id="principal.<ww:property value="#rowStatus.index"/>" name="principal.<ww:property value="#rowStatus.index"/>">
                                    <ww:set name="selectIdValue" value="'principal.' + #rowStatus.index"/>
                                    <ww:iterator value="principalMappingOptions">
                                    <ww:set name="currentoptionkey" value="key"/>
                                    <option id="<ww:property value="key"/>" value="<ww:property value="key"/>" <ww:if test="isPrincipalMappingSelected(#selectIdValue, #currentoptionkey)">selected</ww:if> ><ww:property value="value"/></option>
                                    </ww:iterator>
                                </select>
                            </td>
                        </tr>
                        </ww:iterator>

                    </table>
                    <ww:if test="configuration.groupMemberships != null" >
                    <br />
                    <h3><ww:text name="dataimport.csv.configuration.groupmapping.label" /></h3>
                    <table>
                        <tr>
                            <th width="15%">
                                <ww:text name="dataimport.csv.configuration.headerrow" />
                            </th>
                            <th width="35%">
                                <ww:text name="dataimport.csv.configuration.sampledata" />
                            </th>
                            <th width="50%">
                                <ww:text name="dataimport.csv.configuration.mapping" />
                            </th>
                        <ww:iterator value="configuration.groupHeaderRow" status="rowStatus">
                        <tr>
                            <td>
                                <ww:property />
                            </td>
                            <td>
                                <ww:property value="configuration.groupSampleRow.get(#rowStatus.index)" />
                            </td>
                            <td>
                                <select id="group.<ww:property value="#rowStatus.index"/>" name="group.<ww:property value="#rowStatus.index"/>">
                                    <ww:set name="selectIdValue" value="'group.' + #rowStatus.index"/>
                                    <ww:iterator value="groupMappingOptions">
                                        <ww:set name="currentoptionkey" value="key"/>
                                        <option id="<ww:property value="key"/>" value="<ww:property value="key"/>" <ww:if test="isGroupMappingSelected(#selectIdValue, #currentoptionkey)">selected</ww:if>><ww:property value="value"/></option>
                                    </ww:iterator>
                                </select>
                            </td>
                        </tr>
                        </ww:iterator>

                    </table>
                    </ww:if>
                    <br/>

                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">

                        <input type="button" name="backButton" value="&laquo; <ww:property value="getText('previous.label')"/>" title="&laquo; <ww:property value="getText('previous.label')"/>" onclick="location.href='<ww:url action="importcsv" namespace="/console/secure/dataimport" method="default"/>'"/>
                        <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>

                    </div>
                </div>

            </form>

        </div>

    </div>
</div>
</body>
</html>