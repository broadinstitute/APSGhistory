<%@ page import="com.atlassian.crowd.integration.directory.connector.LDAPPropertiesMapper" %>
<%@ page import="com.atlassian.crowd.util.connector.LDAPPropertiesHelper" %>
<%@ page import="com.atlassian.spring.container.ContainerManager" %>
<%@ page import="java.util.Collection" %>
<%@ page import="java.util.Iterator" %>
<%@ page import="java.util.Properties" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="directoryconnectorcreate.title"/>
    </title>

    <meta name="section" content="directories"/>
    <meta name="pagename" content="add"/>
    <meta name="help.url" content="<ww:property value="getText('help.directory.add.connector.details')"/>"/>

    <script type="text/javascript" language="javascript">

        function init()
        {
            processTabs(tab);
        }

        function configurePage()
        {
            hideShowUserEncryption();
            hideShowUseNestedGroups();
        <ww:if test="initialLoad == true">
            updateConfiguration();
        </ww:if>
        }

        // sets the default values for the ldap connector
        function updateConfiguration()
        {

            // get the form
            var form = document.directoryconnector;
            
        <%
            LDAPPropertiesHelper ldapPropertiesHelper =(LDAPPropertiesHelper) ContainerManager.getComponent("ldapPropertiesHelper");
            Collection values = ldapPropertiesHelper.getImplementations().values();

            for (Iterator itr = values.iterator(); itr.hasNext(); ) {
                String impl = (String) itr.next();
                Properties props = ldapPropertiesHelper.getConfigurationDetails().get(impl);
        %>

            if (form.connector.value == '<%=impl%>')
            {

                form.groupDescriptionAttr.value = '<%=props.get(LDAPPropertiesMapper.GROUP_DESCRIPTION_KEY)%>';
                form.groupMemberAttr.value = '<%=props.get(LDAPPropertiesMapper.GROUP_USERNAMES_KEY)%>';
                form.groupNameAttr.value = '<%=props.get(LDAPPropertiesMapper.GROUP_NAME_KEY)%>';
                form.groupObjectClass.value = '<%=props.get(LDAPPropertiesMapper.GROUP_OBJECTCLASS_KEY)%>';
                form.groupObjectFilter.value = '<%=props.get(LDAPPropertiesMapper.GROUP_OBJECTFILTER_KEY)%>';

                form.roleDescriptionAttr.value = '<%=props.get(LDAPPropertiesMapper.ROLE_DESCRIPTION_KEY)%>';
                form.roleMemberAttr.value = '<%=props.get(LDAPPropertiesMapper.ROLE_USERNAMES_KEY)%>';
                form.roleNameAttr.value = '<%=props.get(LDAPPropertiesMapper.ROLE_NAME_KEY)%>';
                form.roleObjectClass.value = '<%=props.get(LDAPPropertiesMapper.ROLE_OBJECTCLASS_KEY)%>';
                form.roleObjectFilter.value = '<%=props.get(LDAPPropertiesMapper.ROLE_OBJECTFILTER_KEY)%>';

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

                form.pagedResults.checked = <%=props.get(LDAPPropertiesMapper.LDAP_PAGEDRESULTS_KEY)%>;
                form.referral.checked = <%=props.get(LDAPPropertiesMapper.LDAP_REFERRAL_KEY)%>;
                form.useRelaxedDNStandardisation.checked = <%=props.get(LDAPPropertiesMapper.LDAP_RELAXED_DN_STANDARDISATION)%>;
            }
        <%
            }
        %>
            // Hide the user encryption if we are not using OpenLDAP
            hideShowUserEncryption();
            // Hide nested groups for directories that don't support them.
            hideShowUseNestedGroups();

            // Hide the paged results option if we are not using paged results.
            hideShowPagedResultsSize();

            // The "memberOf" for group membership only applies to AD.
            hideShowUseUMAForGroupMembership();

            // caching stuff
            hideShowUseCaching();
            hideShowPollingInterval();
            hideShowCacheMaxElements();
        }

        function hideShowUserEncryption()
        {

            // get the form
            var form = document.directoryconnector;
            
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

        function hideShowPagedResultsSize()
        {
            // get the form
            var form = document.directoryconnector;

            // Hide the user encryption if we are not using OpenLDAP
            if (form.pagedResults.checked)
            {
                document.getElementById("paged_results_size").style.display="block";
            }
            else
            {
                document.getElementById("paged_results_size").style.display="none";
            }
        }

        function hideShowUseNestedGroups()
        {
            // get the form
            var form = document.directoryconnector;

            // Hide nested groups for the directories that don't support them.
            if (form.connector.value == 'com.atlassian.crowd.integration.directory.connector.Rfc2307'
                || form.connector.value == 'com.atlassian.crowd.integration.directory.connector.AppleOpenDirectory'
                || form.connector.value == 'com.atlassian.crowd.integration.directory.connector.OpenLDAPRfc2307'
                || form.connector.value == 'com.atlassian.crowd.integration.directory.connector.FedoraDS')
            {
                document.getElementById("nested_groups").style.display="none";
            }
            else
            {
                document.getElementById("nested_groups").style.display="block";
            }
        }

        function hideShowUseUMAForGroupMembership()
        {
            // get the form
            var form = document.directoryconnector;

            // Hide nested groups for the directories that don't support them.
            if (form.connector.value == 'com.atlassian.crowd.integration.directory.connector.MicrosoftActiveDirectory')
            {
                document.getElementById("uma_groupmembership").style.display="block";
            }
            else
            {
                document.getElementById("uma_groupmembership").style.display="none";
            }
        }

        function isPollingCapable(connector)
        {
            <%
                for (String connectorClass : ldapPropertiesHelper.getPollingCapableImplementations())
                {
            %>
                    if (connector == '<%= connectorClass %>')
                    {
                        return true;
                    }
            <%
                }
            %>

            return false;
        }

        function isMonitorCapable(connector)
        {
            <%
                for (String connectorClass : ldapPropertiesHelper.getMonitorCapableImplementations())
                {
            %>
                    if (connector == '<%= connectorClass %>')
                    {
                        return true;
                    }
            <%
                }
            %>

            return false;
        }

        function hideShowUseCaching()
        {
            // get the form
            var form = document.directoryconnector;

            // hide caching for the directories that don't support monitoring
            if (isMonitorCapable(form.connector.value))
            {
                document.getElementById("caching").style.display="block";
            }
            else
            {
                document.getElementById("caching").style.display="none";
            }
        }

        function hideShowCacheMaxElements()
        {
            // get the form
            var form = document.directoryconnector;

            // show when caching enabled
            if (form.useCaching.checked)
            {
                document.getElementById("cache_max_elements").style.display="block";
            }
            else
            {
                document.getElementById("cache_max_elements").style.display="none";
            }
        }

        function hideShowPollingInterval()
        {
            // get the form
            var form = document.directoryconnector;

            // show polling interval for the directories are polling capable when caching is selected
            if (form.useCaching.checked && isPollingCapable(form.connector.value))
            {
                document.getElementById("polling_interval").style.display="block";
            }
            else
            {
                document.getElementById("polling_interval").style.display="none";
            }
        }

        function testConfiguration()
        {
            document.directoryconnector.action = "<ww:url namespace="/console/secure/directory" action="testConfiguration" method="testConfiguration" includeParams="none"/>";

            var tabNumberElement = document.createElement("input");
            tabNumberElement.setAttribute("type", "hidden");
            tabNumberElement.setAttribute("name", "tab");
            tabNumberElement.setAttribute("id", "tab");
            tabNumberElement.setAttribute("value", "2");

            document.directoryconnector.appendChild(tabNumberElement);

            document.directoryconnector.submit();
        }

        function testGroupSearch()
        {
            document.directoryconnector.action = "<ww:url namespace="/console/secure/directory" action="testGroupSearch" method="testGroupSearch" includeParams="none"/>";

            setDirectoryConnectorReturnTab(3);

            document.directoryconnector.submit();
        }

        function testRoleSearch()
        {
            document.directoryconnector.action = "<ww:url namespace="/console/secure/directory" action="testRoleSearch" method="testRoleSearch" includeParams="none"/>";

            setDirectoryConnectorReturnTab(3);

            document.directoryconnector.submit();
        }

        function testPrincipalSearch()
        {
            document.directoryconnector.action = "<ww:url namespace="/console/secure/directory" action="testPrincipalSearch" method="testPrincipalSearch" includeParams="none"/>";

            setDirectoryConnectorReturnTab(3);

            document.directoryconnector.submit();
        }

        function setDirectoryConnectorReturnTab(tabNumber) {
            var tabNumberElement = document.createElement("input");
            tabNumberElement.setAttribute("type", "hidden");
            tabNumberElement.setAttribute("name", "tab");
            tabNumberElement.setAttribute("id", "tab");
            tabNumberElement.setAttribute("value", tabNumber);

            document.directoryconnector.appendChild(tabNumberElement);
        }

        function processTabsAndSetHelpLink(tab) {
            switch (tab) {
            case 1:
                setHelpLink('<ww:property value="getText('help.directory.add.connector.details')"/>'); break;
            case 2:
                setHelpLink('<ww:property value="getText('help.directory.add.connector.connector')"/>'); break;
            case 3:
                setHelpLink('<ww:property value="getText('help.directory.add.connector.configuration')"/>'); break;
            case 4:
                setHelpLink('<ww:property value="getText('help.directory.add.connector.permissions')"/>'); break;
            }
            processTabs(tab);
        }

    </script>
    <jsp:include page="../../decorator/javascript_tabs.jsp">
        <jsp:param name="totalTabs" value="4"/>
    </jsp:include>
</head>
<body onload="init(); configurePage();">

    <form name="directoryconnector" method="post" action="<ww:url namespace="/console/secure/directory" action="createconnector" method="update" includeParams="none" />">

    <h2>
        <ww:text name="directoryconnectorcreate.title"/>
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
                    <ww:property value="getText('menu.connector.label')"/>
                </a>
            </li>

            <li id="hreftab3">
                <a href="javascript:processTabsAndSetHelpLink(3);">
                    <ww:property value="getText('menu.configuration.label')"/>
                </a>
            </li>

            <li id="hreftab4">
                <a href="javascript:processTabsAndSetHelpLink(4);">
                    <ww:property value="getText('menu.permissions.label')"/>
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

                    <ww:select name="connector" list="connectors" listKey="value" listValue="key" onchange="javascript:updateConfiguration();">
                        <ww:param name="label" value="getText('directory.connector.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directory.connector.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true" />
                    </ww:select>

                    <ww:textfield name="URL" size="50">
                        <ww:param name="label" value="getText('directoryconnector.url.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.url.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true" />
                    </ww:textfield>

                    <ww:checkbox name="secure" fieldValue="true">
                        <ww:param name="label" value="getText('directoryconnector.secure.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.secure.description')"/>
                        </ww:param>
                    </ww:checkbox>

                    <ww:checkbox name="referral" fieldValue="true">
                        <ww:param name="label" value="getText('directoryconnector.referral.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.referral.description')"/>
                        </ww:param>
                    </ww:checkbox>

                    <div id="nested_groups">
                    <ww:checkbox name="nestedGroupsDisabled" fieldValue="true">
                        <ww:param name="label" value="getText('directoryconnector.nestedgroups.disable.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.nestedgroups.disable.description')"/>
                        </ww:param>
                    </ww:checkbox>
                    </div>

                    <ww:checkbox name="useUserMembershipAttribute" fieldValue="true">
                        <ww:param name="label" value="getText('directoryconnector.useusermembershipattribute.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.useusermembershipattribute.description')"/>
                        </ww:param>
                    </ww:checkbox>

                    <div id="uma_groupmembership">
                    <ww:checkbox name="useUserMembershipAttributeForGroupMembership" fieldValue="true">
                        <ww:param name="label" value="getText('directoryconnector.useuma.forgroupmembership.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.useuma.forgroupmembership.description')"/>
                        </ww:param>
                    </ww:checkbox>
                    </div>

                    <ww:checkbox name="pagedResults" fieldValue="true" onchange="javascript:hideShowPagedResultsSize();" >
                        <ww:param name="label" value="getText('directoryconnector.pagedresultscontrol.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.pagedresultscontrol.description')"/>
                        </ww:param>
                    </ww:checkbox>

                    <div id="paged_results_size">
                    <ww:textfield name="pagedResultsSize">
                        <ww:param name="label" value="getText('directoryconnector.pagedresultscontrolsize.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.pagedresultscontrolsize.description')"/>
                        </ww:param>
                    </ww:textfield>
                    </div>

                    <ww:checkbox name="useRelaxedDNStandardisation" fieldValue="true">
                        <ww:param name="label" value="getText('directoryconnector.useRelaxedDNStandardisation.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.useRelaxedDNStandardisation.description')"/>
                        </ww:param>
                    </ww:checkbox>

                    <div id="caching">
                    <ww:checkbox name="useCaching" fieldValue="true" onchange="javascript:hideShowPollingInterval();hideShowCacheMaxElements();">
                        <ww:param name="label" value="getText('directoryconnector.caching.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.caching.description')"/>
                        </ww:param>
                    </ww:checkbox>
                    </div>

                    <div id="cache_max_elements">
                    <ww:textfield name="cacheMaxElements" required="true">
                        <ww:param name="label" value="getText('directoryconnector.cache.elements.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.cache.elements.description')"/>
                        </ww:param>
                    </ww:textfield>
                    </div>

                    <div id="polling_interval">
                    <ww:textfield name="pollingInterval" required="true">
                        <ww:param name="label" value="getText('directoryconnector.polling.interval.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.polling.interval.description')"/>
                        </ww:param>
                    </ww:textfield>
                    </div>

                    <div id="user_encryption">
                    <ww:select list="userEncryptionMethods" name="userEncryptionMethod" listKey="key" listValue="value">
                        <ww:param name="label" value="getText('directoryconnector.userencryptionmethod.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.userencryptionmethod.ldap.description')"/>
                        </ww:param>
                    </ww:select>
                    </div>

                    <ww:textfield name="baseDN" size="50">
                        <ww:param name="label" value="getText('directoryconnector.basedn.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.basedn.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true" />
                    </ww:textfield>

                    <ww:textfield name="userDN" size="50">
                        <ww:param name="label" value="getText('directoryconnector.userdn.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.userdn.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:password name="ldapPassword" size="50">
                        <ww:param name="label" value="getText('directoryconnector.password.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.password.description')"/>
                        </ww:param>
                    </ww:password>


                    <div class="textFieldButton buttons" style="">
                        <input type="button" class="button" style="width: 125px;" value="<ww:property value="getText('directoryconnector.testconnection.label')"/>" onClick="testConfiguration();"/>
                    </div>

                </div>
                <div class="formFooter wizardFooter">

                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';"/>
                    </div>
                </div>

            </div>

        </div>

        <div class="tabContent" id="tab3">

        <div class="crowdForm">

        <ww:component template="form_tab_messages.jsp">
            <ww:param name="tabID" value="3"/>
        </ww:component>

        <h3 style="border-top: none">
            <ww:property value="getText('directoryconnector.groupconfiguration.label')"/>
        </h3>

        <div class="formBody">

        <ww:textfield name="groupDNaddition" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.groupdnaddition.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.groupdnaddition.description')"/>
            </ww:param>
        </ww:textfield>

        <ww:textfield name="groupObjectClass" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.groupobjectclass.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.groupobjectclass.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="groupObjectFilter" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.groupobjectfilter.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.groupobjectfilter.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="groupNameAttr" size="'35px;'">
            <ww:param name="label" value="getText('directoryconnector.groupname.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.groupname.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="groupDescriptionAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.groupdescription.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.groupdescription.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="groupMemberAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.groupmember.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.groupmember.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <div class="textFieldButton buttons" style="">
            <input type="button" class="button" style="width: 125px;" value="<ww:property value="getText('directoryconnector.testsearch.label')"/>" onClick="testGroupSearch();"/>
        </div>

        </div>
        <h3>
            <ww:property value="getText('directoryconnector.roleconfiguration.label')"/>
        </h3>
        <div class="formBody">
        <ww:checkbox name="rolesDisabled" fieldValue="true">
            <ww:param name="label" value="getText('directoryconnector.rolesdisabled.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.rolesdisabled.description')"/>
            </ww:param>
        </ww:checkbox>

        <ww:textfield name="roleDNaddition" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.rolednaddition.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.rolednaddition.description')"/>
            </ww:param>
        </ww:textfield>

        <ww:textfield name="roleObjectClass" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.roleobjectclass.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.roleobjectclass.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="roleObjectFilter" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.roleobjectfilter.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.roleobjectfilter.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="roleNameAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.rolename.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.rolename.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="roleDescriptionAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.roledescription.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.roledescription.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="roleMemberAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.rolemember.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.rolemember.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <div class="textFieldButton buttons" style="">
            <input type="button" class="button" style="width: 125px;" value="<ww:property value="getText('directoryconnector.testsearch.label')"/>" onClick="testRoleSearch();"/>
        </div>

        </div>
        <h3>
            <ww:property value="getText('directoryconnector.userconfiguration.label')"/>
        </h3>
        <div class="formBody">
        <ww:textfield name="userDNaddition" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userdnaddition.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.userdnaddition.description')"/>
            </ww:param>
        </ww:textfield>

        <ww:textfield name="userObjectClass" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userobjectclass.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.userobjectclass.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userObjectFilter" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userobjectfilter.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.userobjectfilter.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userNameAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.usernameattribute.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.usernameattribute.description')"/>
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
                <ww:property value="getText('directoryconnector.userfirstnameattribute.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userLastnameAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userlastnameattribute.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.userlastnameattribute.description')"/>
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
                <ww:property value="getText('directoryconnector.usermailattribute.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userGroupMemberAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.usermemberofattribute.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.usermemberofattribute.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <ww:textfield name="userPasswordAttr" size="35px;">
            <ww:param name="label" value="getText('directoryconnector.userpassword.label')"/>
            <ww:param name="description">
                <ww:property value="getText('directoryconnector.userpassword.description')"/>
            </ww:param>
            <ww:param name="required" value="true" />
        </ww:textfield>

        <div class="textFieldButton buttons" style="">
            <input type="button" class="button" style="width: 125px;" value="<ww:property value="getText('directoryconnector.testsearch.label')"/>" onClick="testPrincipalSearch();"/>
        </div>


        </div>
        <div class="formFooter wizardFooter">

            <div class="buttons">
                <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';"/>
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
