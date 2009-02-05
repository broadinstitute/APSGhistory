<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.viewprincipal.label')"/>
    </title>
    <meta name="section" content="users"/>
    <meta name="pagename" content="viewuser"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.view.details')"/>"/>

    <jsp:include page="../../decorator/javascript_tabs.jsp">
        <jsp:param name="totalTabs" value="4"/>
    </jsp:include>

    <script type="text/javascript" language="JavaScript">

        function addGroup()
        {
            var form = document.groupsForm;
            form.action = '<ww:url namespace="/console/secure/user" action="updategroups" method="addGroup" includeParams="none" />';
            form.submit();
        }

        function addRole()
        {
            var form = document.rolesForm;
            form.action = '<ww:url namespace="/console/secure/user" action="updateroles" method="addRole" includeParams="none" />';
            form.submit();
        }

        function addAttribute()
        {
            var form = document.attributesForm;
            form.action = '<ww:url namespace="/console/secure/user" action="updateattributes" method="addAttribute" includeParams="none" />';
            form.submit();
        }

        function processTabsAndSetHelpLink(tab) {
            switch (tab) {
            case 1:
                setHelpLink('<ww:property value="getText('help.user.view.details')"/>'); break;
            case 2:
                setHelpLink('<ww:property value="getText('help.user.view.attributes')"/>'); break;
            case 3:
                setHelpLink('<ww:property value="getText('help.user.view.groups')"/>'); break;
            case 4:
                setHelpLink('<ww:property value="getText('help.user.view.roles')"/>'); break;
            }
            processTabs(tab);
        }

    </script>
</head>
<body onload="init();">

    <h2>
        <ww:property value="getText('menu.viewprincipal.label')"/>
        &nbsp;&ndash;&nbsp;
        <ww:property value="name"/>
    </h2>

    <div class="page-content">

        <ul class="tabs">
            <li class="on" id="hreftab1">
                <a href="javascript:processTabsAndSetHelpLink(1);">
                    <ww:property value="getText('menu.details.label')"/>
                </a>
            </li>

            <li id="hreftab2">
                <a href="javascript:processTabsAndSetHelpLink(2);">
                    <ww:property value="getText('menu.attributes.label')"/>
                </a>
            </li>

            <li id="hreftab3">
                <a href="javascript:processTabsAndSetHelpLink(3);">
                    <ww:property value="getText('menu.groups.label')"/>
                </a>
            </li>


            <li id="hreftab4">
                <a href="javascript:processTabsAndSetHelpLink(4);">
                    <ww:property value="getText('menu.roles.label')"/>
                </a>
            </li>

        </ul>

        <div class="tabContent" id="tab1">

            <div class="crowdForm">
                <form name="updateprincipalForm" method="post" action="<ww:url namespace="/console/secure/user" action="update" method="updateGeneral" includeParams="none" />">
                    <div class="formBody">

                        <ww:component template="form_tab_messages.jsp">
                            <ww:param name="tabID" value="1"/>
                        </ww:component>

                        <input type="hidden" name="tab" value="1"/>
                        <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                        <input type="hidden" name="name" value="<ww:property value="name" />"/>

                        <ww:component template="form_row.jsp">
                           <ww:param name="label" value="getText('principal.name.label')" />
                            <ww:param name="value">
                                    <ww:property value="name"/>
                            </ww:param>
                        </ww:component>

                        <ww:component template="form_row.jsp">
                           <ww:param name="label" value="getText('principal.directory.label')" />
                            <ww:param name="value">
                                    <ww:property value="directory.name"/>&nbsp;&mdash;&nbsp;<ww:property value="directory.implementation.directoryType"/>
                            </ww:param>
                        </ww:component>

                        <ww:textfield name="email" size="50">
                            <ww:param name="label" value="getText('principal.email.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('principal.email.description')"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:checkbox name="active" fieldValue="true">
                            <ww:param name="label" value="getText('principal.active.label')"/>
                        </ww:checkbox>

                        <ww:textfield name="firstname">
                            <ww:param name="label" value="getText('principal.firstname.label')"/>
                        </ww:textfield>

                        <ww:textfield name="lastname">
                            <ww:param name="label" value="getText('principal.lastname.label')"/>
                        </ww:textfield>

                        <ww:password name="password">
                            <ww:param name="label" value="getText('password.label')"/>
                            <ww:param name="'description'">
                                <ww:property value="getText('principal.editpassword.description')"/>
                            </ww:param>
                        </ww:password>

                        <ww:password name="passwordConfirm">
                            <ww:param name="label" value="getText('passwordconfirm.label')"/>
                        </ww:password>
                    </div>

                    <div class="formFooter wizardFooter">
                        <div class="buttons">
                            <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/user" action="view" method="default" includeParams="none"><ww:param name="directoryID" value="directoryID"/><ww:param name="name" value="name"/><ww:param name="tab" value="1"/></ww:url>';"/>
                        </div>
                    </div>

                </form>

            </div>

        </div>

        <div class="tabContent" id="tab2">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/console/secure/user" action="updateattributes" method="updateAttributes" includeParams="none" />" name="attributesForm">
                    <div class="formBody">

                        <ww:component template="form_tab_messages.jsp">
                            <ww:param name="tabID" value="2"/>
                        </ww:component>

                        <input type="hidden" name="tab" value="2"/>
                        <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                        <input type="hidden" name="name" value="<ww:property value="name" />"/>

                        <table id="attributesTable" class="formTable">
                            <tr>
                                <th width="40%">
                                    <ww:property value="getText('attribute.label')"/>
                                </th>
                                <th width="40%">
                                    <ww:property value="getText('values.label')"/>
                                </th>
                                <th width="20%">
                                    <ww:property value="getText('browser.action.label')"/>
                                </th>
                            </tr>

                            <ww:iterator value="principalAttributes" status="rowstatus">

                                <input type="hidden" name="attributes" value="<ww:property value="key" />"/>

                                <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                                <ww:else><tr class="even"></ww:else>
                                <td>
                                    <ww:property value="key"/>
                                </td>
                                <td>
                                    <ww:iterator value="value.values" status="valuestatus">
                                        <input type="text" name="<ww:property value="key" /><ww:property value="#valuestatus.count" />" value="<ww:property />" size="30"/><br/>
                                    </ww:iterator>
                                </td>
                                <td>
                                    <a id="remove-<ww:property value="key"/>" href="<ww:url namespace="/console/secure/user" action="updateattributes" method="removeAttribute" includeParams="none" ><ww:param name="name" value="name" /><ww:param name="attribute" value="key" /><ww:param name="directoryID" value="directoryID" /><ww:param name="tab" value="2"/></ww:url>"
                                       title="<ww:property value="getText('remove.label')"/>">
                                        <ww:property value="getText('remove.label')"/>
                                    </a>
                                </td>
                                </tr>

                            </ww:iterator>
                        </table>
                    </div>

                    <div class="formFooter wizardFooter">
                        <div class="buttons">
                            <ww:property value="getText('attribute.label')"/>
                            :&nbsp;<input type="text" name="attribute" size="15" value="<ww:property value="attribute" />"/>&nbsp;
                            <ww:property value="getText('value.label')"/>
                            :&nbsp;<input type="text" name="value" size="15" value="<ww:property value="value" />"/>&nbsp;
                            <input id="add-attribute" type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;" onClick="addAttribute();"/>
                            &nbsp;&nbsp;&nbsp;
                            <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/user" action="view" method="default" includeParams="none" ><ww:param name="directoryID" value="directoryID"/><ww:param name="name" value="name"/><ww:param name="tab" value="2" /></ww:url>';"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>


        <div class="tabContent" id="tab3">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/console/secure/user" action="updategroups" method="update" includeParams="none" />" name="groupsForm">
                    <div class="formBody">


                        <ww:component template="form_tab_messages.jsp">
                            <ww:param name="tabID" value="3"/>
                        </ww:component>

                        <p>
                            <ww:property value="getText('principal.groupmappings.text')"/>
                        </p>

                        <ww:set name="userName" value="[0].name"/>
                        <ww:set name="directory" value="directoryID" />
                        <ww:set name="directoryName" value="directory.name" />

                        <input type="hidden" name="tab" value="3"/>
                        <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                        <input type="hidden" name="name" value="<ww:property value="userName" />"/>

                        <table id="groupsTable" class="formTable">
                            <tr>
                                <th width="64%">
                                    <ww:property value="getText('browser.group.label')"/>
                                </th>
                                <th width="36%">
                                    <ww:property value="getText('browser.action.label')"/>
                                </th>
                            </tr>

                            <ww:iterator value="groups" status="rowstatus">

                                <ww:if test="#rowstatus.odd == true">
                                    <tr class="odd">
                                </ww:if>
                                <ww:else>
                                    <tr class="even">
                                </ww:else>

                                <td>
                                    <a id="viewgroup-<ww:property value="name" />-<ww:property value="#directoryName" />" href="<ww:url namespace="/console/secure/group" action="view" includeParams="none" ><ww:param name="directoryID" value="#directory" /><ww:param name="directoryID" value="#directory" /><ww:param name="name" value="name" /></ww:url>">
                                        <ww:property value="name"/>
                                    </a>
                                </td>

                                <td>
                                    <a id="removegroup-<ww:property value="name" />-<ww:property value="#directoryName" />" href="<ww:url namespace="/console/secure/user" action="updategroups" method="removeGroup" includeParams="none" ><ww:param name="directoryID" value="#directory" /><ww:param name="tab" value="3" /><ww:param name="removeGroup" value="name" /><ww:param name="name" value="#userName" /></ww:url>">
                                        <ww:text name="remove.label"/>
                                    </a>
                                </td>

                                </tr>

                            </ww:iterator>

                        </table>
                    </div>


                    <div class="formFooter wizardFooter">
                        <div class="buttons">
                            <ww:if test="unsubscribedGroups.size > 0">
                                <select name="unsubscribedGroup" style="width: 270px;">
                                    <ww:iterator value="unsubscribedGroups">
                                        <option value="<ww:property value="name" />">
                                            <ww:property value="name"/>
                                        </option>
                                    </ww:iterator>
                                </select>

                                <input id="add-selected-group" type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;" onClick="addGroup();"/>
                                &nbsp;&nbsp;&nbsp;
                            </ww:if>

                            <input id="update-group" type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/user" action="view" method="default" includeParams="none" ><ww:param name="directoryID" value="directoryID" /><ww:param name="name" value="userName"/><ww:param name="tab" value="3" /></ww:url>';"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="tabContent" id="tab4">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/console/secure/user" action="updateroles" method="update" includeParams="none" />" name="rolesForm">
                    <div class="formBody">

                        <ww:component template="form_tab_messages.jsp">
                            <ww:param name="tabID" value="4"/>
                        </ww:component>

                        <p>
                            <ww:property value="getText('principal.rolemappings.text')"/>
                        </p>

                        <ww:set name="userName" value="[0].name"/>
                        <ww:set name="directory" value="directoryID" />
                        <ww:set name="directoryName" value="directory.name" />

                        <input type="hidden" name="tab" value="4"/>
                        <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                        <input type="hidden" name="name" value="<ww:property value="userName" />"/>

                        <table id="rolesTable" class="formTable">
                            <tr>
                                <th width="64%">
                                    <ww:property value="getText('browser.role.label')"/>
                                </th>
                                <th width="36%">
                                    <ww:property value="getText('browser.action.label')"/>
                                </th>
                            </tr>

                            <ww:iterator value="roles" status="rowstatus">

                                <ww:if test="#rowstatus.odd == true">
                                    <tr class="odd">
                                </ww:if>
                                <ww:else>
                                    <tr class="even">
                                </ww:else>

                                <td>
                                    <a id="viewrole-<ww:property value="name" />-<ww:property value="#directoryName" />" href="<ww:url namespace="/console/secure/role" action="view" includeParams="none" ><ww:param name="directoryID" value="#directory" /><ww:param name="directoryID" value="#directory" /><ww:param name="name" value="name" /></ww:url>">
                                        <ww:property value="name"/>
                                    </a>
                                </td>

                                <td>
                                    <a id="removerole-<ww:property value="name" />-<ww:property value="#directoryName" />" href="<ww:url namespace="/console/secure/user" action="updateroles" method="removeRole" includeParams="none" ><ww:param name="directoryID" value="#directory" /><ww:param name="tab" value="4" /><ww:param name="removeRole" value="name" /><ww:param name="name" value="userName" /></ww:url>">
                                        <ww:text name="remove.label"/>
                                    </a>
                                </td>

                                </tr>

                            </ww:iterator>

                        </table>
                    </div>

                    <div class="formFooter wizardFooter">
                        <div class="buttons">
                            <ww:if test="unsubscribedRoles.size > 0">
                                <select name="unsubscribedRole" style="width: 270px;">
                                    <ww:iterator value="unsubscribedRoles">
                                        <option value="<ww:property value="name" />">
                                            <ww:property value="name"/>
                                        </option>
                                    </ww:iterator>
                                </select>

                                <input id="add-role" type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;" onClick="addRole();"/>
                                &nbsp;&nbsp;&nbsp;
                            </ww:if>

                            <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/user" action="view" method="default" includeParams="none" ><ww:param name="directoryID" value="directoryID"/><ww:param name="name" value="name"/><ww:param name="tab" value="4" /></ww:url>';"/>
                        </div>
                    </div>

              </form>
            </div>
        </div>

    </div>
</body>
</html>