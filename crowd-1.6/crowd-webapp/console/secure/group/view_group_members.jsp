<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.viewgroup.label')"/>
    </title>
    <meta name="section" content="groups"/>
    <meta name="pagename" content="viewgroupmembers" />
    <meta name="help.url" content="<ww:property value="getText('help.group.view.users')"/>"/>

    <script type="text/javascript" language="JavaScript">
        function addGroup()
        {
            var form = document.addGroupsForm;
            form.action = '<ww:url namespace="/console/secure/group" action="updatemembers" method="addGroup" includeParams="none" />';
            form.submit();
        }
    </script>
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
        <li class="on">
            <span class="tab"><ww:property value="getText('group.directmembers.label')"/></span>
        </li>
        <ww:if test="!subGroups.empty">
        <li>
            <a id="view-group-nested-principals"
               href='<ww:url action="viewnestedusers" namespace="/console/secure/group" includeParams="none" ><ww:param name="directoryID" value="directoryID"/><ww:param name="groupName" value="groupName"/></ww:url>'>
                <ww:property value="getText('group.nestedmembers.label')"/>
            </a>
        </li>
        </ww:if>
    </ol>

    <div class="tabContent static">

        <div class="crowdForm">
            <div class="formBody">
                <ww:component template="form_messages.jsp"/>               

                <ww:if test="principals.empty && subGroups.empty">
                    <p class="infoBox">
                        <ww:text name="viewprincipals.group.noprincipals.assigned">
                            <ww:param value="groupName"/>
                        </ww:text>
                    </p>
                </ww:if>
                <ww:if test="!subGroups.empty">
                    <table id="view-group-groups">
                        <tr>
                            <th width="80%">
                                <ww:property value="getText('group.name')"/>
                            </th>
                            <th width="10%">
                                <ww:property value="getText('group.active.label')"/>
                            </th>
                            <th width="10%">
                                <ww:property value="getText('browser.action.label')"/>
                            </th>
                        </tr>
                        <ww:iterator value="subGroups" status="rowstatus">
                            <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                            <ww:else><tr class="even"></ww:else>
                            <td valign="top">
                                <a href="<ww:url namespace="/console/secure/group" action="view" method="default" includeParams="none"><ww:param name="name" value="name" /><ww:param name="directoryID" value="[1].directoryID" /></ww:url>"
                                   title="<ww:property value="getText('browser.view.label')"/>">
                                    <ww:property value="name"/>
                                </a>
                            </td>
                            <td valign="top">
                                <ww:property value="active"/>
                            </td>
                            <td valign="top">
                                <a id="removegroup-<ww:property value="name" />-<ww:property value="#directoryName" />" href="<ww:url namespace="/console/secure/group" action="updatemembers" method="removeGroup" includeParams="none" ><ww:param name="directoryID" value="[1].directoryID" /><ww:param name="childGroup" value="name" /><ww:param name="parentGroup" value="groupName" /></ww:url>">
                                    <ww:text name="remove.label"/>
                                </a>
                            </td>
                            </tr>
                        </ww:iterator>
                    </table>
                </ww:if>
                <ww:if test="supportsNestedGroups"> <!-- Make sure it doesn't appear for Internal Directories -->
                    <form method="post" action="<ww:url namespace="/console/secure/group" action="updatemembers" method="addGroup" includeParams="none" />" name="addGroupsForm">
                        <div class="formFooter wizardFooter">
                            <div class="buttons">
                                <ww:if test="!allNonMemberGroups.empty">
                                    <ww:text name="group.add.child"/>:&nbsp;
                                    <select name="childGroup" style="width: 270px;">
                                        <ww:iterator value="allNonMemberGroups">
                                            <option value="<ww:property value="name" />">
                                                <ww:property value="name"/>
                                            </option>
                                        </ww:iterator>
                                    </select>                                    
                                    <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                                    <input type="hidden" name="parentGroup" value="<ww:property value="groupName" />"/>

                                    <input id="add-selected-group" type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;"
                                           onClick="addGroup();"/>
                                    &nbsp;&nbsp;&nbsp;
                                </ww:if>

                                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                       onClick="window.location='<ww:url namespace="/console/secure/group" action="viewmembers" includeParams="none" ><ww:param name="directoryID" value="directoryID" /><ww:param name="groupName" value="groupName"/></ww:url>';"/>
                            </div>
                        </div>
                    </form>
                </ww:if>
                <ww:if test="!principals.empty">
                    <table id="view-group-principals">
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
                </ww:if>
            </div>
        </div>
    </div>

</div>
</body>
</html>