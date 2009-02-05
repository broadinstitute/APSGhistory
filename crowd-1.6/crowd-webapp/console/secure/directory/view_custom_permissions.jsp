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
    <meta name="help.url" content="<ww:property value="getText('help.directory.custom.permissions')"/>"/>
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
                <a id="custom-general" href="<ww:url namespace="/console/secure/directory" action="viewcustom" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.details.label"/></a>
            </li>

            <li>
                <a id="custom-attributes" href="<ww:url namespace="/console/secure/directory" action="updatecustomattributes" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.attributes.label"/></a>
            </li>

            <li class="on">
                <a id="custom-permissions" href="<ww:url namespace="/console/secure/directory" action="updatecustompermissions" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.permissions.label"/></a>
            </li>

        </ol>


        <div class="tabContent static" id="tab1">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/console/secure/directory" action="updatecustompermissions" method="update" includeParams="none" />">
                    <div class="formBody">


                        <ww:component template="form_messages.jsp"/>

                        <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                        <ww:checkbox name="permissionGroupAdd" fieldValue="true">
                            <ww:param name="label" value="getText('permission.addgroup.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.addgroup.description')"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionPrincipalAdd" fieldValue="true">
                            <ww:param name="label" value="getText('permission.addprincipal.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.addprincipal.description')"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionRoleAdd" fieldValue="true">
                            <ww:param name="label" value="getText('permission.addrole.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.addrole.description')"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionGroupModify" fieldValue="true">
                            <ww:param name="label" value="getText('permission.modifygroup.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.modifygroup.description')"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionPrincipalModify" fieldValue="true">
                            <ww:param name="label" value="getText('permission.modifyprincipal.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.modifyprincipal.description')"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionRoleModify" fieldValue="true">
                            <ww:param name="label" value="getText('permission.modifyrole.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.modifyrole.description')"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionGroupRemove" fieldValue="true">
                            <ww:param name="label" value="getText('permission.removegroup.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.removegroup.description')"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionPrincipalRemove" fieldValue="true">
                            <ww:param name="label" value="getText('permission.removeprincipal.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.removeprincipal.description')"/>
                            </ww:param>
                        </ww:checkbox>

                        <ww:checkbox name="permissionRoleRemove" fieldValue="true">
                            <ww:param name="label" value="getText('permission.removerole.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('permission.removerole.description')"/>
                            </ww:param>
                        </ww:checkbox>
                    </div>
                    <div class="formFooter wizardFooter">

                        <div class="buttons">

                            <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewcustom" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
</body>
</html>