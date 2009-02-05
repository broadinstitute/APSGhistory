<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.viewgroup.label')"/>
    </title>
    <meta name="section" content="groups"/>
    <meta name="pagename" content="viewgroupnestedusers" />
    <meta name="help.url" content="<ww:property value="getText('help.group.view.allusers')"/>"/>
</head>
<body>
<h2>
    <ww:property value="getText('menu.viewgroup.label')"/>
    &nbsp;&ndash;&nbsp;
    <ww:property value="groupName"/>
</h2>

<div class="page-content">

    <ol class="tabs">

        <li>
            <a href='<ww:url action="view" namespace="/console/secure/group" method="default" includeParams="none">
            <ww:param name="directoryID" value="directoryID"/><ww:param name="name" value="groupName" /> </ww:url>'>
                <ww:property value="getText('menu.details.label')"/>
            </a>
        </li>
        <li>
            <a id="view-group-principals"
               href='<ww:url action="viewmembers" namespace="/console/secure/group" includeParams="none" ><ww:param name="directoryID" value="directoryID"/><ww:param name="groupName" value="groupName"/></ww:url>'>
                <ww:property value="getText('group.directmembers.label')"/>
            </a>
        </li>
        <li class="on">
            <span class="tab"><ww:property value="getText('group.nestedmembers.label')"/></span>
        </li>
    </ol>

    <div class="tabContent static">

        <div class="crowdForm">
            <div class="formBody">
                <ww:if test="principals.empty">
                    <p class="infoBox">
                        <ww:text name="viewprincipals.group.noprincipals.assigned">
                            <ww:param value="groupName"/>
                        </ww:text>
                    </p>
                </ww:if>
                <ww:else>
                    <table id="view-group-nested-principals">
                        <tr>
                            <th width="30%">
                                <ww:text name="principal.name.label"/>
                            </th>
                            <th width="60%">
                                <ww:text name="principal.email.label"/>
                            </th>
                            <th width="10%">
                                <ww:text name="principal.active.label"/>
                            </th>
                        </tr>

                        <ww:iterator value="principals" status="rowstatus">
                            <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                            <ww:else><tr class="even"></ww:else>
                            <td valign="top">
                                <a id="view-principal"
                                   href="<ww:url namespace="/console/secure/user" action="view" method="default" includeParams="none"><ww:param name="name" value="name" /><ww:param name="directoryID" value="[1].directoryID" /></ww:url>"
                                   title="<ww:property value="getText('browser.view.label')"/>">
                                    <ww:property value="name"/>
                                </a>
                            </td>
                            <td valign="top">
                                <ww:property value="email"/>
                            </td>
                            <td valign="top">
                                <ww:property value="active"/>
                            </td>
                            </tr>
                        </ww:iterator>
                    </table>
                </ww:else>
            </div>
        </div>
    </div>

</div>
</body>
</html>