<%@ page import="com.atlassian.crowd.integration.directory.connector.LDAPPropertiesMapper" %>
<%@ page import="com.atlassian.spring.container.ContainerManager" %>
<%@ page import="java.util.Collection" %>
<%@ page import="java.util.Iterator" %>
<%@ page import="java.util.Properties" %>
<%@ page import="com.atlassian.crowd.util.connector.LDAPPropertiesHelper" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="directory.delegated.create.title"/>
    </title>

    <meta name="section" content="directories"/>
    <meta name="pagename" content="adddelegated"/>
    <meta name="help.url" content="<ww:property value="getText('help.directory.add.delegated.details')"/>"/>

    <script type="text/javascript" language="javascript">

        function init()
        {
            processTabs(tab);
        }

        function configurePage()
        {
            hideShowUserEncryption();
        <ww:if test="initialLoad == true">
            updateConfiguration();
        </ww:if>
        }

        // sets the default values for the ldap connector
        function updateConfiguration()
        {

            // get the form
            var form = document.directorydelegated;

        <%
            LDAPPropertiesHelper ldapPropertiesHelper =(LDAPPropertiesHelper) ContainerManager.getComponent("ldapPropertiesHelper");
            Collection values = ldapPropertiesHelper.getImplementations().values();

            for (Iterator itr = values.iterator(); itr.hasNext(); ) {
                String impl = (String) itr.next();
                Properties props = ldapPropertiesHelper.getConfigurationDetails().get(impl);
        %>

            if (form.connector.value == '<%=impl%>')
            {
                form.userFirstnameAttr.value = '<%=props.get(LDAPPropertiesMapper.USER_FIRSTNAME_KEY)%>';
                form.userGroupMemberAttr.value = '<%=props.get(LDAPPropertiesMapper.USER_GROUP_KEY)%>';
                form.userMailAttr.value = '<%=props.get(LDAPPropertiesMapper.USER_EMAIL_KEY)%>';
                form.userNameAttr.value = '<%=props.get(LDAPPropertiesMapper.USER_USERNAME_KEY)%>';
                form.userNameRdnAttr.value = '<%=props.get(LDAPPropertiesMapper.USER_USERNAME_RDN_KEY)%>';
                form.userLastnameAttr.value = '<%=props.get(LDAPPropertiesMapper.USER_LASTNAME_KEY)%>';
                form.userDisplayNameAttr.value = '<%=props.get(LDAPPropertiesMapper.USER_DISPLAYNAME_KEY)%>';
                form.userObjectClass.value = '<%=props.get(LDAPPropertiesMapper.USER_OBJECTCLASS_KEY)%>';
                form.userPasswordAttr.value = '<%=props.get(LDAPPropertiesMapper.USER_PASSWORD_KEY)%>';
                form.userObjectFilter.value = '<%=props.get(LDAPPropertiesMapper.USER_OBJECTFILTER_KEY)%>';
            }
        <%
            }
        %>
            // Hide the user encryption if we are not using OpenLDAP
            hideShowUserEncryption();
        }

        function hideShowUserEncryption()
        {

            // get the form
            var form = document.directorydelegated;

            // Hide the user encryption if we are not using OpenLDAP
            if (form.connector.value == 'com.atlassian.crowd.integration.directory.connector.OpenLDAP'
                    || form.connector.value == 'com.atlassian.crowd.integration.directory.connector.GenericLDAP')
            {
                document.getElementById("user_encryption").style.display="block";
                form.userEncryptionMethod.value = "ssha";
            }
            else
            {
                document.getElementById("user_encryption").style.display="none";
                form.userEncryptionMethod.value = "";
            }
        }

        function testConfiguration()
        {
            document.directorydelegated.action = "<ww:url namespace="/console/secure/directory" action="createdelegated" method="testConfiguration" includeParams="none"/>";

            var tabNumberElement = document.createElement("input");
            tabNumberElement.setAttribute("type", "hidden");
            tabNumberElement.setAttribute("name", "tab");
            tabNumberElement.setAttribute("id", "tab");
            tabNumberElement.setAttribute("value", "2");

            document.directorydelegated.appendChild(tabNumberElement);

            document.directorydelegated.submit();
        }

        function setDirectoryConnectorReturnTab(tabNumber) {
            var tabNumberElement = document.createElement("input");
            tabNumberElement.setAttribute("type", "hidden");
            tabNumberElement.setAttribute("name", "tab");
            tabNumberElement.setAttribute("id", "tab");
            tabNumberElement.setAttribute("value", tabNumber);

            document.directorydelegated.appendChild(tabNumberElement);
        }

        function processTabsAndSetHelpLink(tab) {
            switch (tab) {
            case 1:
                setHelpLink('<ww:property value="getText('help.directory.add.delegated.details')"/>'); break;
            case 2:
                setHelpLink('<ww:property value="getText('help.directory.add.delegated.connector')"/>'); break;
            case 3:
                setHelpLink('<ww:property value="getText('help.directory.add.delegated.configuration')"/>'); break;
            case 4:
                setHelpLink('<ww:property value="getText('help.directory.add.delegated.permissions')"/>'); break;
            }
            processTabs(tab);
        }


    </script>
    <jsp:include page="../../decorator/javascript_tabs.jsp">
        <jsp:param name="totalTabs" value="4"/>
    </jsp:include>
</head>
<body onload="init(); configurePage();">

    <form method="post" action="<ww:url namespace="/console/secure/directory" action="createdelegated" method="update" includeParams="none" />" name="directorydelegated">

    <h2>
        <ww:text name="directory.delegated.create.title"/>
    </h2>


    <div class="page-content">
        <ul class="tabs">
            <li class="on" id="hreftab1">
                <a href="javascript:processTabsAndSetHelpLink(1);">
                    <ww:text name="menu.details.label"/>
                </a>
            </li>

            <li id="hreftab2">
                <a href="javascript:processTabsAndSetHelpLink(2);">
                    <ww:text name="menu.connector.label"/>
                </a>
            </li>

            <li id="hreftab3">
                <a href="javascript:processTabsAndSetHelpLink(3);">
                    <ww:text name="menu.configuration.label"/>
                </a>
            </li>

            <li id="hreftab4">
                <a href="javascript:processTabsAndSetHelpLink(4);">
                    <ww:text name="menu.permissions.label"/>
                </a>
            </li>

        </ul>

        <div class="tabContent" id="tab1">

            <div class="crowdForm">
                <div class="formBody">

                    <ww:component template="form_tab_messages.jsp">
                        <ww:param name="tabID" value="1"/>
                    </ww:component>

                    <ww:textfield name="name" size="50">
                        <ww:param name="label" value="getText('directoryinternal.name.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryinternal.name.description"/>
                        </ww:param>
                        <ww:param name="required" value="true" />
                    </ww:textfield>

                    <ww:textfield name="description" size="50">
                        <ww:param name="label" value="getText('directoryinternal.description.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryinternal.description.description"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:checkbox name="active" fieldValue="true">
                        <ww:param name="label" value="getText('directory.active.label')"/>
                    </ww:checkbox>
                </div>
                <div class="formFooter wizardFooter">

                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:text name="continue.label"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:text name="cancel.label"/>" onClick="window.location='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';"/>
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

                    <ww:select name="connector" list="connectors" listKey="value" listValue="key" onchange="javascript:updateConfiguration();">
                        <ww:param name="label" value="getText('directory.connector.label')"/>
                        <ww:param name="description">
                            <ww:text name="directory.connector.description"/>
                        </ww:param>
                        <ww:param name="required" value="true" />
                    </ww:select>

                    <ww:textfield name="URL" size="50">
                        <ww:param name="label" value="getText('directoryconnector.url.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryconnector.url.description"/>
                        </ww:param>
                        <ww:param name="required" value="true" />
                    </ww:textfield>

                    <ww:checkbox name="secure" fieldValue="true">
                        <ww:param name="label" value="getText('directoryconnector.secure.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryconnector.secure.description"/>
                        </ww:param>
                    </ww:checkbox>

                    <ww:checkbox name="referral" fieldValue="true">
                        <ww:param name="label" value="getText('directoryconnector.referral.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryconnector.referral.description"/>
                        </ww:param>
                    </ww:checkbox>

                    <div id="user_encryption">
                    <ww:select list="userEncryptionMethods" name="userEncryptionMethod" listKey="key" listValue="value">
                        <ww:param name="label" value="getText('directoryconnector.userencryptionmethod.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryconnector.userencryptionmethod.ldap.description"/>
                        </ww:param>
                    </ww:select>
                    </div>

                    <ww:textfield name="baseDN" size="50">
                        <ww:param name="label" value="getText('directoryconnector.basedn.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryconnector.basedn.description"/>
                        </ww:param>
                        <ww:param name="required" value="true" />
                    </ww:textfield>

                    <ww:textfield name="userDN" size="50">
                        <ww:param name="label" value="getText('directoryconnector.userdn.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryconnector.userdn.description"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:password name="ldapPassword" size="50">
                        <ww:param name="label" value="getText('directoryconnector.password.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryconnector.password.description"/>
                        </ww:param>
                    </ww:password>


                    <div class="textFieldButton buttons" style="">
                        <input type="button" class="button" style="width: 125px;" value="<ww:text name="directoryconnector.testconnection.label"/>" onClick="testConfiguration();"/>
                    </div>

                </div>
                <div class="formFooter wizardFooter">

                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:text name="continue.label"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:text name="cancel.label"/>" onClick="window.location='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';"/>
                    </div>
                </div>

            </div>

        </div>

        <div class="tabContent" id="tab3">

        <div class="crowdForm">

        <ww:component template="form_tab_messages.jsp">
            <ww:param name="tabID" value="3"/>
        </ww:component>

        <h3>
            <ww:text name="directoryconnector.userconfiguration.label"/>
        </h3>
        <div class="formBody">
        <ww:textfield name="userDNaddition" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userdnaddition.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.userdnaddition.description"/>
            </ww:param>
        </ww:textfield>

        <ww:textfield name="userObjectClass" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userobjectclass.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.userobjectclass.description"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userObjectFilter" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userobjectfilter.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.userobjectfilter.description"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userNameAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.usernameattribute.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.usernameattribute.description"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userNameRdnAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.usernamerdnattribute.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.usernamerdnattribute.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userFirstnameAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userfirstnameattribute.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.userfirstnameattribute.description"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userLastnameAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userlastnameattribute.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.userlastnameattribute.description"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userDisplayNameAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userdisplaynameattribute.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.userdisplaynameattribute.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userMailAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.usermailattribute.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.usermailattribute.description"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userGroupMemberAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.usermemberofattribute.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.usermemberofattribute.description"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userPasswordAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userpassword.label')"/>
            <ww:param name="description">
                <ww:text name="directoryconnector.userpassword.description"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        </div>
        <div class="formFooter wizardFooter">

            <div class="buttons">
                <input type="submit" class="button" value="<ww:text name="continue.label"/> &raquo;"/>
                <input type="button" class="button" value="<ww:text name="cancel.label"/>" onClick="window.location='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';"/>
            </div>
        </div>

        </div>

        </div>

        <div class="tabContent" id="tab4">

            <div class="crowdForm">
            <div class="formBody">

            <ww:component template="form_tab_messages.jsp">
                <ww:param name="tabID" value="4"/>
            </ww:component>

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

                    <input type="submit" class="button" value="<ww:text name="continue.label"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:text name="cancel.label"/>" onClick="window.location='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';"/>
                </div>
            </div>

            </div>

        </div>
    </div>

    </form>

</body>
</html>
