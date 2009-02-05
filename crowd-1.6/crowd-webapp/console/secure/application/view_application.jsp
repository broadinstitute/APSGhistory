<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="menu.viewapplication.label"/>
    </title>
    <meta name="section" content="applications"/>
    <meta name="pagename" content="view"/>
    <meta name="help.url" content="<ww:text name="help.application.view.details"/>"/>

    <script type="text/javascript" language="JavaScript">
        function addDirectory()
        {
            var form = document.directoriesForm;
            form.action = '<ww:url namespace="/console/secure/application" action="updatedirectory" method="addDirectory" includeParams="none" />';
            form.submit();
        }

        function addGroup()
        {
            var form = document.groupsForm;
            form.action = '<ww:url namespace="/console/secure/application" action="updategroups" method="addGroup" includeParams="none"/>';
            form.submit();
        }

        function addAddress()
        {
            var form = document.addressForm;
            form.action = '<ww:url namespace="/console/secure/application" action="updateaddresses" method="addAddress" includeParams="none" />';
            form.submit();
        }

        function viewPermissionMappings(directoryId)
        {
            var form = document.permissionForm;
            form.directoryId.value=directoryId;
            form.action = '<ww:url namespace="/console/secure/application" action="view" method="doDefault" includeParams="none" />';
            form.submit();
        }

        function removeDirectoryCheck()
        {
            // check if user is trying to delete the only directory mapped to a permanent application
            if (<ww:property value="application.perminant && application.directoryMappings.size() == 1"/>)
            {
                return confirm('<ww:text name="application.remove.directory.warning" />');
            }
            else
            {
                // if not, go ahead and delete
                return true;
            }
        }

        function removeCrowdAdminGroupCheck(groupName)
        {
            // check if user is trying to delete the crowd admin group in a permanent application
            if (groupName == '<ww:text name="defaultadmin.group.default" />' && <ww:property value="application.perminant"/>)
            {
                return confirm('<ww:text name="application.remove.crowdadmin.group.warning" />');
            }
            return true;
        }

        function processTabsAndSetHelpLink(tab) {
            switch (tab) {
            case 1:
                setHelpLink('<ww:property value="getText('help.application.view.details')"/>'); break;
            case 2:
                setHelpLink('<ww:property value="getText('help.application.view.directories')"/>'); break;
            case 3:
                setHelpLink('<ww:property value="getText('help.application.view.groups')"/>'); break;
            case 4:
                setHelpLink('<ww:property value="getText('help.application.view.permissions')"/>'); break;
            case 5:
                setHelpLink('<ww:property value="getText('help.application.view.remoteaddr')"/>'); break;
            case 6:
                setHelpLink('<ww:property value="getText('help.application.view.configtest')"/>'); break;
            }
            processTabs(tab);
        }

    </script>
</head>
<body onload="init();">


<jsp:include page="../../decorator/javascript_tabs.jsp">
    <jsp:param name="totalTabs" value="6"/>
</jsp:include>

<h2 id="application-name">
    <img class="application-icon" style="padding-bottom:3px;" title="<ww:property value="getImageTitle(application.active, application.applicationType)"/>" alt="<ww:property value="getImageTitle(application.active, application.applicationType)"/>" src="<ww:property value="getImageLocation(application.active, application.applicationType)" />"/>
    <ww:property value="application.name"/>
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
            <ww:property value="getText('menu.directory.label')"/>
        </a>
    </li>

    <li id="hreftab3">
        <a href="javascript:processTabsAndSetHelpLink(3);">
            <ww:property value="getText('menu.group.label')"/>
        </a>
    </li>

    <li id="hreftab4">
        <a href="javascript:processTabsAndSetHelpLink(4);">
            <ww:property value="getText('menu.permissions.label')"/>
        </a>
    </li>

    <ww:if test="!pluginApplication">
    <li id="hreftab5">
        <a href="javascript:processTabsAndSetHelpLink(5);">
            <ww:property value="getText('menu.address.label')"/>
        </a
    </li>
    </ww:if>

    <li id="hreftab6">
        <a href="javascript:processTabsAndSetHelpLink(6);">
            <ww:property value="getText('menu.configtest.label')"/>
        </a>
    </li>

    <ww:iterator value="getWebItemsForApplication()">
        <li>
            <a id="<ww:property value="link.id"/>" href="<ww:property value="getLink(link)"/>"><ww:property value="getText(webLabel.key)"/></a>
        </li>
    </ww:iterator>
    
</ul>


<div class="tabContent create" id="tab1">
    <div class="crowdForm">
        <form name="applicationDetails" method="post"
              action="<ww:url namespace="/console/secure/application" action="update" method="update" includeParams="none" />">

            <div class="formBodyNoTop">

                <ww:component template="form_tab_messages.jsp">
                    <ww:param name="tabID" value="1"/>
                </ww:component>

                <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                <ww:textfield name="name" size="35px;" disabled="application.perminant">
                    <ww:param name="required" value="!application.perminant" />
                    <ww:param name="label" value="getText('application.name.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('application.name.description')"/>
                    </ww:param>
                </ww:textfield>

                <!-- disabled fields aren't set back to the server -->
                <ww:if test="application.perminant">
                    <input type="hidden" name="name" value="<ww:property value="name"/>"/>
                </ww:if>

                <ww:textfield name="applicationDescription" size="35px;">
                    <ww:param name="label" value="getText('application.description.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('application.description.description')"/>
                    </ww:param>
                </ww:textfield>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('application.type.label')"/>
                    <ww:param name="value">
                        <ww:property value="application.applicationType.displayName"/>
                    </ww:param>
                </ww:component>


                <ww:checkbox name="active" disabled="crowdApplication">
                    <ww:param name="label" value="getText('application.active.label')"/>
                </ww:checkbox>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('application.conception.label')"/>
                    <ww:param name="value">
                        <ww:date format="dd MMM yyyy, HH:mm:ss" name="application.conception"/>
                    </ww:param>
                </ww:component>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('application.lastmodified.label')"/>
                    <ww:param name="value">
                        <ww:date format="dd MMM yyyy, HH:mm:ss" name="application.lastModified"/>
                    </ww:param>
                </ww:component>

                <ww:if test="!pluginApplication">
                    <ww:password name="password" size="35px;">
                        <ww:param name="label" value="getText('password.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('application.password.description')"/>
                        </ww:param>
                    </ww:password>

                    <ww:password name="passwordConfirm" size="35px;">
                        <ww:param name="label" value="getText('passwordconfirm.label')"/>
                    </ww:password>
                </ww:if>

            </div>

            <div class="formFooter wizardFooter">

                <div class="buttons">

                    <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="view" method="default" includeParams="none"><ww:param name="ID" value="ID"/><ww:param name="tab" value="1"/></ww:url>'"/>
                </div>
            </div>

        </form>

    </div>

</div>

<div class="tabContent" id="tab2">

<div class="crowdForm">

<form method="post"
      action="<ww:url namespace="/console/secure/application" action="updatedirectory" method="update" includeParams="none"/>"
      name="directoriesForm">

<div class="formBodyNoTop">

    <ww:component template="form_tab_messages.jsp">
        <ww:param name="tabID" value="2"/>
    </ww:component>

<p>
    <ww:property value="getText('application.directorymappings.text')"/>
</p>

<input type="hidden" name="ID" value="<ww:property value="ID" />"/>
<input type="hidden" name="tab" value="2"/>

<table id="directoriesTable" class="formTable">

    <ww:if test="application.directoryMappings.size > 1">
        <tr>
            <th width="40%">
                <ww:property value="getText('browser.directory.label')"/>
            </th>
            <th width="15%">
                <ww:property value="getText('browser.directoryorder.label')"/>
            </th>
            <th width="25%">
                <ww:property value="getText('browser.allowalltoauthenticate.label')"/>
            </th>
            <th width="20%">
                <ww:property value="getText('browser.action.label')"/>
            </th>
        </tr>
    </ww:if>
    <ww:else>
        <tr>
            <th width="55%">
                <ww:property value="getText('browser.directory.label')"/>
            </th>
            <th width="25%">
                <ww:property value="getText('browser.allowalltoauthenticate.label')"/>
            </th>
            <th width="20%">
                <ww:property value="getText('browser.action.label')"/>
            </th>
        </tr>
    </ww:else>

    <ww:iterator value="application.directoryMappings" status="rowstatus">

        <input type="hidden" name="directory<ww:property value="#rowstatus.count" />"
               value="<ww:property value="directory.ID" />"/>

        <ww:if test="#rowstatus/odd == true">
            <tr class="odd">
        </ww:if>
        <ww:else>
            <tr class="even">
        </ww:else>

        <td>
            <ww:property value="directory.name"/>
        </td>

        <ww:if test="application.directoryMappings.size > 1">
            <td style="text-align: center;">
                <ww:if test="#rowstatus.count > 1 && #rowstatus.count != 0">
                    <a href="<ww:url namespace="/console/secure/application" action="updatedirectory" method="up" includeParams="none"><ww:param name="ID" value="ID"/><ww:param name="directoryID" value="directory.ID"/><ww:param name="tab" value="2"/></ww:url>"
                       name="<ww:property value="getText('moveup.label')" />"><img
                            src="<ww:url value="/console/images/icons/16x16/arrow_up_blue.gif" />"
                            alt="<ww:property value="getText('moveup.label')" />"/></a>
                </ww:if>

                <ww:if test="#rowstatus.last == false">

                    <ww:if test="#rowstatus.first == false">
                        &nbsp;
                    </ww:if>
                    <a href="<ww:url namespace="/console/secure/application" action="updatedirectory" method="down" includeParams="none"><ww:param name="ID" value="ID"/><ww:param name="directoryID" value="directory.ID"/><ww:param name="tab" value="2"/></ww:url>"
                       name="<ww:property value="getText('movedown.label')" />"><img
                            src="<ww:url value="/console/images/icons/16x16/arrow_down_blue.gif" />"
                            alt="<ww:property value="getText('movedown.label')" />"/></a>
                </ww:if>
            </td>
        </ww:if>

        <td>
            <select name="directory<ww:property value="#rowstatus.count" />-allowAll" style="width: 130px;">
                <option value="true"
                        <ww:if test="allowAllToAuthenticate == true">selected</ww:if>
                        >
                    <ww:property value="getText('true.label')"/>
                </option>
                <option value="false"
                        <ww:if test="allowAllToAuthenticate == false">selected</ww:if>
                        >
                    <ww:property value="getText('false.label')"/>
                </option>
            </select>
        </td>


        <td>
            <a href="<ww:url namespace="/console/secure/application" action="updatedirectory" method="removeDirectory" includeParams="none"><ww:param name="ID" value="ID"/><ww:param name="directoryID" value="directory.ID"/><ww:param name="tab" value="2"/></ww:url>"
               title="<ww:property value="getText('remove.label')"/>" onclick="return removeDirectoryCheck();">
                <ww:property value="getText('remove.label')"/>
            </a>

        </td>

        </tr>

    </ww:iterator>

</table>
</div>

<div class="formFooter wizardFooter">

    <div class="buttons">
        <ww:if test="unsubscribedDirectories.size > 0">
            <select name="unsubscribedDirectoriesID" style="width: 270px;">
                <ww:iterator value="unsubscribedDirectories">
                    <option value="<ww:property value="ID" />">
                        <ww:property value="name"/>
                    </option>
                </ww:iterator>
            </select>

            <input id="add-directory" type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;"
                   onClick="addDirectory();"/>
            &nbsp;&nbsp;&nbsp;
        </ww:if>

        <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
               onClick="window.location='<ww:url namespace="/console/secure/application" action="view" method="default" includeParams="none"><ww:param name="ID" value="ID"/><ww:param name="tab" value="2"/></ww:url>';"/>
    </div>
</div>

</form>

</div>
</div>


<div class="tabContent" id="tab3">

<div class="crowdForm">

<form method="post"
      action="<ww:url namespace="/console/secure/application" action="updategroups" method="update" includeParams="none"/>"
      name="groupsForm">

<div class="formBodyNoTop">

    <ww:component template="form_tab_messages.jsp">
        <ww:param name="tabID" value="3"/>
    </ww:component>

    <p>
        <ww:property value="getText('application.groupmappings.text')"/>
    </p>

    <input type="hidden" name="ID" value="<ww:property value="ID" />"/>
    <input type="hidden" name="tab" value="3"/>

    <table id="groupsTable" class="formTable">
        <tr>
            <th width="64%">
                <ww:property value="getText('browser.directory.label')"/>
                &nbsp;&ndash;&nbsp;
                <ww:property value="getText('browser.group.label')"/>
            </th>
            <th width="18%">
                <ww:property value="getText('browser.active.label')"/>
            </th>
            <th width="18%">
                <ww:property value="getText('browser.action.label')"/>
            </th>
        </tr>

        <ww:iterator value="application.groupMappings" status="rowstatus">

            <input type="hidden" name="group<ww:property value="#rowstatus.count" />"
                   value="<ww:property value="directory.ID" />"/>

            <ww:if test="#rowstatus.odd == true">
                <tr class="odd">
            </ww:if>
            <ww:else>
                <tr class="even">
            </ww:else>

            <td>
                <ww:property value="directory.name"/>
                &nbsp;&ndash;&nbsp;
                <ww:property value="name"/>
            </td>

            <td>
                <select name="active-<ww:property value="directory.ID" />-<ww:property value="name" />"
                        style="width: 130px;">
                    <option value="true"
                            <ww:if test="active == true">selected</ww:if>
                            >
                        <ww:property value="getText('active.label')"/>
                    </option>
                    <option value="false"
                            <ww:if test="active == false">selected</ww:if>
                            >
                        <ww:property value="getText('inactive.label')"/>
                    </option>
                </select>
            </td>

            <td>
                <a href="<ww:url namespace="/console/secure/application" action="updategroups" method="removeGroup" includeParams="none" ><ww:param name="ID" value="ID"/><ww:param name="removeDirectoryID" value="directory.ID"/><ww:param name="removeName" value="name"/><ww:param name="tab" value="3"/></ww:url>"
                   title="<ww:property value="getText('remove.label')"/>"
                   onclick="return removeCrowdAdminGroupCheck('<ww:property value="name"/>');">
                    <ww:property value="getText('remove.label')"/>
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
                    <option value="<ww:property value="directory.ID" />-<ww:property value="name" />">
                        <ww:property value="directory.name"/>
                        &nbsp;&ndash;&nbsp;
                        <ww:property value="name"/>
                    </option>
                </ww:iterator>
            </select>

            <input type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;"
                   onClick="addGroup();"/>
            &nbsp;&nbsp;&nbsp;
        </ww:if>

        <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
               onClick="window.location='<ww:url namespace="/console/secure/application" action="view" method="default" includeParams="none"><ww:param name="ID" value="ID"/><ww:param name="tab" value="3"/></ww:url>';"/>
    </div>
</div>

</form>
</div>
</div>

<div class="tabContent" id="tab4">

    <div class="crowdForm">

        <form method="post" action="<ww:url namespace="/console/secure/application" action="updatePermissions" method="doUpdate" includeParams="none"/>" name="permissionForm">

            <input type="hidden" name="ID" value="<ww:property value="ID" />"/>
            <input type="hidden" name="tab" value="4"/>
            <input type="hidden" name="directoryId" value="<ww:property value="directoryId" />"/>

            <div class="formBodyNoTop">

                <ww:component template="form_tab_messages.jsp">
                    <ww:param name="tabID" value="4"/>
                </ww:component>

                <p>
                    <ww:property value="getText('application.permission.text')"/>
                </p>

                <fieldset id="directory-list" class="directory-list">
                    <legend>Directories</legend>
                    <select name="directory-select" id="directory-select" class="directory-select" size="17"
                            onchange="viewPermissionMappings(this.options[this.selectedIndex].value)" >
                        <ww:iterator value="application.directoryMappings">
                            <option <ww:if test="directoryId==directory.ID">selected</ww:if>
                                    value="<ww:property value="directory.ID"/>"><ww:property value="directory.name"/></option>
                        </ww:iterator>
                    </select>
                </fieldset>

                <fieldset id="permission-list" class="permission-list">
                    <legend>Permissions</legend>

                    <ww:if test="directoryId == null">
                           <span style="font-size: 1.1em;">You need to select a directory.</span>
                    </ww:if>
                    <ww:else>
                    <ol>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@ADD_GROUP) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_GROUP.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_GROUP.name"/>"
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@ADD_GROUP)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                    />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_GROUP.name"/>">
                                <ww:text name="permission.addgroup.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.addgroup.description"/></div>
                        </li>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@ADD_PRINCIPAL) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_PRINCIPAL.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_PRINCIPAL.name"/>" 
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@ADD_PRINCIPAL)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_PRINCIPAL.name"/>">
                                <ww:text name="permission.addprincipal.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.addprincipal.description"/></div>
                        </li>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@ADD_ROLE) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_ROLE.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_ROLE.name"/>"
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@ADD_ROLE)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@ADD_ROLE.name"/>">
                                <ww:text name="permission.addrole.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.addrole.description"/></div>
                        </li>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@MODIFY_GROUP) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_GROUP.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_GROUP.name"/>"
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@MODIFY_GROUP)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_GROUP.name"/>">
                                <ww:text name="permission.modifygroup.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.modifygroup.description"/></div>
                        </li>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@MODIFY_PRINCIPAL) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_PRINCIPAL.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_PRINCIPAL.name"/>"
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@MODIFY_PRINCIPAL)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_PRINCIPAL.name"/>">
                                <ww:text name="permission.modifyprincipal.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.modifyprincipal.description"/></div>
                        </li>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@MODIFY_ROLE) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_ROLE.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_ROLE.name"/>"
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@MODIFY_ROLE)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@MODIFY_ROLE.name"/>">
                                <ww:text name="permission.modifyrole.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.modifyrole.description"/></div>
                        </li>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@REMOVE_GROUP) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_GROUP.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_GROUP.name"/>"
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@REMOVE_GROUP)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_GROUP.name"/>">
                                <ww:text name="permission.removegroup.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.removegroup.description"/></div>
                        </li>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@REMOVE_PRINCIPAL) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_PRINCIPAL.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_PRINCIPAL.name"/>"
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@REMOVE_PRINCIPAL)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_PRINCIPAL.name"/>">
                                <ww:text name="permission.removeprincipal.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.removeprincipal.description"/></div>
                        </li>
                        <li>
                            <ww:set name="disabledglobally" value="permissionEnabledGlobally(@com.atlassian.crowd.model.permission.PermissionType@REMOVE_ROLE) != true" />
                            <input name="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_ROLE.name"/>"
                                   id="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_ROLE.name"/>"
                                   value="true"
                                   type="checkbox"
                                <ww:if test="hasPermission(@com.atlassian.crowd.model.permission.PermissionType@REMOVE_ROLE)"> checked="checked"</ww:if>
                                <ww:if test="disabledglobally"> disabled="disabled"</ww:if>
                                />
                            <label <ww:if test="disabledglobally">class="disabled"</ww:if> for="<ww:property value="@com.atlassian.crowd.model.permission.PermissionType@REMOVE_ROLE.name"/>">
                                <ww:text name="permission.removerole.label"/>
                                <ww:if test="disabledglobally">(<ww:text name="application.permission.disabledglobally"/>)</ww:if>
                            </label>
                            <div class="permission-description"><ww:text name="permission.removerole.description"/></div>
                        </li>
                    </ol>
                    </ww:else>
                </fieldset>
            </div>

            <div class="formFooter wizardFooter">
                <div class="buttons">
                    <input id="update-permissions" name="update-permissions" type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="view" method="default" includeParams="none"><ww:param name="ID" value="ID"/><ww:param name="tab" value="4"/></ww:url>';"/>
                </div>
            </div>
        </form>

    </div>

</div>

<div class="tabContent" id="tab5">

    <div class="crowdForm">

        <form method="post"
              action="<ww:url namespace="/console/secure/application" action="updateaddresses" method="update" includeParams="none"/>"
              name="addressForm">

            <div class="formBodyNoTop">

                <ww:component template="form_tab_messages.jsp">
                    <ww:param name="tabID" value="5"/>
                </ww:component>

                <p>
                    <ww:property value="getText('application.addressmappings.text')"/>
                </p>

                <input type="hidden" name="ID" value="<ww:property value="ID" />"/>
                <input type="hidden" name="tab" value="5"/>

                <table id="addressesTable" class="formTable">
                    <tr>
                        <th width="64%">
                            <ww:property value="getText('browser.address.label')"/>
                        </th>
                        <th width="18%">
                            <ww:property value="getText('browser.active.label')"/>
                        </th>
                        <th width="18%">
                            <ww:property value="getText('browser.action.label')"/>
                        </th>
                    </tr>

                    <ww:iterator value="application.addresses" status="rowstatus">

                        <ww:if test="#rowstatus.odd == true">
                            <tr class="odd">
                        </ww:if>
                        <ww:else>
                            <tr class="even">
                        </ww:else>

                        <td>
                            <ww:property value="address"/>
                        </td>

                        <td>
                            <select name="active-<ww:property value="address" />" style="width: 130px;">
                                <option value="true"
                                        <ww:if test="active == true">selected</ww:if>
                                        >
                                    <ww:property value="getText('true.label')"/>
                                </option>
                                <option value="false"
                                        <ww:if test="active == false">selected</ww:if>
                                        >
                                    <ww:property value="getText('false.label')"/>
                                </option>
                            </select>
                        </td>

                        <td>
                            <a href="<ww:url namespace="/console/secure/application" action="updateaddresses" method="removeAddress" includeParams="none" ><ww:param name="ID" value="ID" /><ww:param name="address" value="address" /><ww:param name="tab" value="5" /></ww:url>"
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
                    Address:&nbsp;<input type="text" name="address" size="20" style="width: 200px;" value=""/>&nbsp;
                    <input id="add-address" type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;"
                           onClick="addAddress();"/>
                    &nbsp;&nbsp;&nbsp;
                    <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="view" method="default" includeParams="none"><ww:param name="ID" value="ID"/><ww:param name="tab" value="5"/></ww:url>';"/>
                </div>
            </div>

        </form>

    </div>

</div>

<div class="tabContent create" id="tab6">

    <div class="crowdForm">

        <form method="post"
              action="<ww:url namespace="/console/secure/application" action="view" method="configTest" includeParams="none"/>">

            <div class="formBody">

                <ww:component template="form_tab_messages.jsp">
                    <ww:param name="tabID" value="6"/>
                </ww:component>

                <input type="hidden" name="ID" value="<ww:property value="ID" />"/>
                <input type="hidden" name="tab" value="6"/>

                <p style="margin-bottom: 10px;">
                    <ww:text name="configtest.text.1">
                        <ww:param value="application.name" />
                    </ww:text>
                </p>

                <div class="row">

                    <ww:if test="testAuthentication == true">

                        <ww:if test="validTestAuthentication == true">
                            <p class="success">
                                <ww:property value="getText('configtest.validauth.text')"/>
                            </p>
                        </ww:if>
                        <ww:else>
                            <p class="error">
                                <ww:property value="getText('configtest.invalidauth.text')"/>
                            </p>
                        </ww:else>

                    </ww:if>

                </div>

                <ww:textfield name="testUsername">
                    <ww:param name="label" value="getText('principal.name.label')"/>
                </ww:textfield>

                <ww:password name="testPassword">
                    <ww:param name="label" value="getText('principal.password.label')"/>
                </ww:password>

            </div>

            <div class="formFooter wizardFooter">

                <div class="buttons">

                    <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="view" method="default" includeParams="none" ><ww:param name="ID" value="ID"/><ww:param name="tab" value="6"/></ww:url>'"/>

                </div>
            </div>


        </form>

    </div>

</div>

</div>
</body>
</html>
