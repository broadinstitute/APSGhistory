<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="menu.viewdirectory.label">
            <ww:param id="0" value="directory.name"/>
        </ww:text>
    </title>
    <meta name="section" content="directories"/>
    <meta name="pagename" content="view"/>

</head>
<body>
    <h2>
        <ww:text name="menu.viewdirectory.label">
            <ww:param id="0" value="directory.name"/>
        </ww:text>
    </h2>

    <div class="page-content">

        <ol class="tabs">

            <li>
                <a id="delegated-general"
                   href="<ww:url namespace="/console/secure/directory" action="viewdelegated" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text
                        name="menu.details.label"/></a>
            </li>

            <li>
                <a id="delegated-connectiondetails" href="<ww:url namespace="/console/secure/directory" action="updatedelegatedconnection" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.connector.label"/></a>
            </li>

            <li>
                <a id="delegated-configuration" href="<ww:url namespace="/console/secure/directory" action="updatedelegatedconfiguration" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.configuration.label"/></a>
            </li>

            <li class="on">
                <span class="tab"><ww:text name="menu.permissions.label"/></span>
            </li>

        </ol>

        <div class="tabContent static" id="tab1">

            <div class="crowdForm">
                <form id="permissions" method="post" action="<ww:url namespace="/console/secure/directory" action="updatedelegatedpermissions" method="update" includeParams="none" />">
                    <div class="formBody">

                        <ww:component template="form_messages.jsp"/>

                        <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                        <ww:checkbox name="permissionGroupAdd" fieldValue="true">
                            <ww:param name="label" value="getText('permission.addgroup.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.addgroup.description"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionPrincipalAdd" fieldValue="true">
                            <ww:param name="label" value="getText('permission.addprincipal.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.addprincipal.description"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionRoleAdd" fieldValue="true">
                            <ww:param name="label" value="getText('permission.addrole.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.addrole.description"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionGroupModify" fieldValue="true">
                            <ww:param name="label" value="getText('permission.modifygroup.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.modifygroup.description"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionPrincipalModify" fieldValue="true">
                            <ww:param name="label" value="getText('permission.modifyprincipal.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.modifyprincipal.description"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionRoleModify" fieldValue="true">
                            <ww:param name="label" value="getText('permission.modifyrole.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.modifyrole.description"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionGroupRemove" fieldValue="true">
                            <ww:param name="label" value="getText('permission.removegroup.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.removegroup.description"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionPrincipalRemove" fieldValue="true">
                            <ww:param name="label" value="getText('permission.removeprincipal.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.removeprincipal.description"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionRoleRemove" fieldValue="true">
                            <ww:param name="label" value="getText('permission.removerole.label')"/>
                            <ww:param name="description">
                                <ww:text name="permission.removerole.description"/>
                            </ww:param>
                        </ww:checkbox>

                    </div>

                    <div class="formFooter wizardFooter">

                        <div class="buttons">

                            <input type="submit" class="button" value="<ww:text name="update.label"/> &raquo;"/>
                            <input type="button" class="button" value="<ww:text name="cancel.label"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewdelegated" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>

                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
</body>
</html>