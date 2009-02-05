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
    <meta name="help.url" content="<ww:text name="help.directory.connector.connection"/>"/>

    <script type="text/javascript" language="javascript">

        function hideShowPagedResultsSize()
        {
            // get the form
            var form = document.connectordetails;

            // Hide the paged results if we are not using AD
            if (form.pagedResults.checked)
            {
                document.getElementById("paged_results_size").style.display = "block";
            }
            else
            {
                document.getElementById("paged_results_size").style.display = "none";
                form.pagedResultsSize.value = "";
            }
        }
        
        function hideShowPollingInterval()
        {
            <ww:if test="pollingCapable">
                // get the form
                var form = document.connectordetails;

                // show polling interval if required
                if (form.useCaching.checked)
                {
                    document.getElementById("polling_interval").style.display="block";
                }
                else
                {
                    document.getElementById("polling_interval").style.display="none";
                }
            </ww:if>
        }
        
        function hideShowCacheMaxElements()
        {
            <ww:if test="monitorCapable">
                // get the form
                var form = document.connectordetails;

                // show max elts if required
                if (form.useCaching.checked)
                {
                    document.getElementById("cache_max_elements").style.display="block";
                }
                else
                {
                    document.getElementById("cache_max_elements").style.display="none";
                }
            </ww:if>
        }

    </script>

</head>
<body onload="hideShowPagedResultsSize(); hideShowPollingInterval();hideShowCacheMaxElements();">
<h2>
    <ww:text name="menu.viewdirectory.label">
        <ww:param id="0" value="directory.name"/>
    </ww:text>
</h2>

<div class="page-content">

<ol class="tabs">

    <li>
        <a id="connector-general"
           href="<ww:url action="viewconnector" namespace="/console/secure/directory" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text
                name="menu.details.label"/></a>
    </li>

    <li class="on">
        <span class="tab"><ww:text name="menu.connector.label"/></span>
    </li>

    <li>
        <a id="connector-configuration"
           href="<ww:url namespace="/console/secure/directory" action="updateconnectorconfiguration" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text
                name="menu.configuration.label"/></a>
    </li>

    <li>
        <a id="connector-permissions"
           href="<ww:url namespace="/console/secure/directory" action="updateconnectorpermissions" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text
                name="menu.permissions.label"/></a>
    </li>

</ol>

<div class="tabContent static" id="tab1">

    <div class="crowdForm">
        <form id="connectordetails" name="connectordetails" method="post"
              action="<ww:url namespace="/console/secure/directory" action="updateconnectorconnection" method="update" includeParams="none" />">
            <div class="formBody">

                <ww:component template="form_messages.jsp"/>

                <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('directory.type.label')"/>
                    <ww:param name="value">
                        <ww:property value="directory.implementation.directoryType"/>
                    </ww:param>
                </ww:component>

                <ww:textfield name="URL" size="50">
                    <ww:param name="label" value="getText('directoryconnector.url.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('directoryconnector.url.description')"/>
                    </ww:param>
                    <ww:param name="required" value="true"/>
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

                <ww:checkbox name="useNestedGroups" fieldValue="true">
                    <ww:param name="label" value="getText('directoryconnector.nestedgroups.disable.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('directoryconnector.nestedgroups.disable.description')"/>
                    </ww:param>
                </ww:checkbox>

                <ww:checkbox name="useUserMembershipAttribute" fieldValue="true">
                    <ww:param name="label" value="getText('directoryconnector.useusermembershipattribute.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('directoryconnector.useusermembershipattribute.description')"/>
                    </ww:param>
                </ww:checkbox>
                
                <ww:checkbox name="useUserMembershipAttributeForGroupMembership" fieldValue="true">
                    <ww:param name="label" value="getText('directoryconnector.useuma.forgroupmembership.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('directoryconnector.useuma.forgroupmembership.description')"/>
                    </ww:param>
                </ww:checkbox>

                <ww:checkbox name="pagedResults" fieldValue="true" onchange="javascript:hideShowPagedResultsSize();">
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
                
                <ww:if test="monitorCapable">
                    <ww:checkbox name="useCaching" fieldValue="true" onchange="javascript:hideShowPollingInterval();javascript:hideShowCacheMaxElements();">
                        <ww:param name="label" value="getText('directoryconnector.caching.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.caching.description')"/>
                        </ww:param>
                    </ww:checkbox>

                    <div id="cache_max_elements">
                    <ww:textfield name="cacheMaxElements" required="true">
                        <ww:param name="label" value="getText('directoryconnector.cache.elements.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.cache.elements.description')"/>
                        </ww:param>
                    </ww:textfield>
                    </div>
                </ww:if>


                <ww:if test="pollingCapable">
                <div id="polling_interval">
                <ww:textfield name="pollingInterval" required="true">
                    <ww:param name="label" value="getText('directoryconnector.polling.interval.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('directoryconnector.polling.interval.description')"/>
                    </ww:param>
                </ww:textfield>
                </div>
                </ww:if>

                <ww:if test="userEncryptionConfigurable">
                    <ww:select list="userEncryptionMethods" name="userEncryptionMethod" listKey="key" listValue="value">
                        <ww:param name="label" value="getText('directoryconnector.userencryptionmethod.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryconnector.userencryptionmethod.ldap.description')"/>
                        </ww:param>
                    </ww:select>
                </ww:if>

                <ww:textfield name="baseDN" size="50">
                    <ww:param name="label" value="getText('directoryconnector.basedn.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('directoryconnector.basedn.description')"/>
                    </ww:param>
                    <ww:param name="required" value="true"/>
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
                        <ww:property value="getText('directoryconnector.passwordupdate.description')"/>
                    </ww:param>
                </ww:password>
            </div>

            <div class="formFooter wizardFooter">
                <div class="buttons">
                    <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewconnector" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                </div>
            </div>

        </form>

    </div>

</div>

</div>
</body>
</html>
