<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('directoryinternalcreate.title')"/>
    </title>

    <meta name="section" content="directories"/>
    <meta name="pagename" content="addinternal"/>
    <meta name="help.url" content="<ww:property value="getText('help.directory.add.internal.details')"/>"/>

    <script type="text/javascript" language="JavaScript">
        function processTabsAndSetHelpLink(tab) {
            switch (tab) {
            case 1:
                setHelpLink('<ww:property value="getText('help.directory.add.internal.details')"/>'); break;
            case 2:
                setHelpLink('<ww:property value="getText('help.directory.add.internal.permissions')"/>'); break;
            }
            processTabs(tab);
        }
    </script>
</head>
<body onload="init();">

<jsp:include page="../../decorator/javascript_tabs.jsp">
    <jsp:param name="totalTabs" value="2"/>
</jsp:include>


<form method="post" action="<ww:url namespace="/console/secure/directory" action="createinternal" method="update" includeParams="none" />" name="directoryinternal">

    <h2>
        <ww:property value="getText('directoryinternalcreate.title')"/>
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
                    <ww:property value="getText('menu.permissions.label')"/>
                </a>
            </li>
        </ul>

        <div class="tabContent create" id="tab1">

            <div class="crowdForm">
                <div class="formBody">

                    <ww:component template="form_tab_messages.jsp">
                        <ww:param name="tabID" value="1"/>
                    </ww:component>

                    <ww:textfield name="name" size="50">
                        <ww:param name="label" value="getText('directoryinternal.name.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.name.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true" />
                    </ww:textfield>

                    <ww:textfield name="description" size="50">
                        <ww:param name="label" value="getText('directoryinternal.description.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.description.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:checkbox name="active" fieldValue="true">
                        <ww:param name="label" value="getText('directory.active.label')"/>
                    </ww:checkbox>

                    <ww:textfield name="passwordRegex" size="50">
                        <ww:param name="label" value="getText('directoryinternal.passwordregex.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.passwordregex.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:textfield name="passwordMaxAttempts">
                        <ww:param name="label" value="getText('directoryinternal.passwordmaxattempts.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.passwordmaxattempts.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:textfield name="passwordMaxChangeTime">
                        <ww:param name="label" value="getText('directoryinternal.passwordmaxchangetime.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.passwordmaxchangetime.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:textfield name="passwordHistoryCount">
                        <ww:param name="label" value="getText('directoryinternal.passwordhistorycount.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.passwordhistorycount.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:select list="userEncryptionMethods" name="userEncryptionMethod" listKey="key" listValue="value" required="true">
                        <ww:param name="label" value="getText('directoryconnector.userencryptionmethod.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.userencryptionmethod.internal.description')"/>
                        </ww:param>
                    </ww:select>

                </div>
                <div class="formFooter wizardFooter">

                    <div class="buttons">

                        <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';"/>

                    </div>

                </div>

            </div>

        </div>

        <div class="tabContent" id="tab2">

            <div class="crowdForm">
                <div class="formBody">

                    <ww:component template="form_tab_messages.jsp">
                        <ww:param name="tabID" value="2"/>
                    </ww:component>

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

                        <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';"/>

                    </div>

                </div>
            </div>

        </div>
    </div>

</form>
</body>
</html>