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

    <li class="on">
        <span class="tab"><ww:text name="menu.connector.label"/></span>
    </li>

    <li>
        <a id="delegated-configuration"
           href="<ww:url namespace="/console/secure/directory" action="updatedelegatedconfiguration" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text
                name="menu.configuration.label"/></a>
    </li>

    <li>
        <a id="delegated-permissions"
           href="<ww:url namespace="/console/secure/directory" action="updatedelegatedpermissions" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text
                name="menu.permissions.label"/></a>
    </li>

</ol>

<div class="tabContent static" id="tab1">

    <div class="crowdForm">
        <form id="connectordetails" name="connectordetails" method="post"
              action="<ww:url namespace="/console/secure/directory" action="updatedelegatedconnection" method="update" includeParams="none" />">
            <div class="formBody">

                <ww:component template="form_messages.jsp"/>

                <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('directory.delegated.type.label')"/>
                    <ww:param name="value">
                        <ww:property value="delegatedDirectoryType"/>
                    </ww:param>
                </ww:component>

                <ww:textfield name="URL" size="50">
                    <ww:param name="label" value="getText('directoryconnector.url.label')"/>
                    <ww:param name="required" value="true" />
                    <ww:param name="description">
                        <ww:text name="directoryconnector.url.description"/>
                    </ww:param>
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

                <ww:if test="userEncryptionConfigurable">
                    <ww:select list="userEncryptionMethods" name="userEncryptionMethod" listKey="key" listValue="value">
                        <ww:param name="label" value="getText('directoryconnector.userencryptionmethod.label')"/>
                        <ww:param name="description">
                            <ww:text name="directoryconnector.userencryptionmethod.ldap.description"/>
                        </ww:param>
                    </ww:select>
                </ww:if>

                <ww:textfield name="baseDN" size="50">
                    <ww:param name="required" value="true" />
                    <ww:param name="label" value="getText('directoryconnector.basedn.label')"/>
                    <ww:param name="description">
                        <ww:text name="directoryconnector.basedn.description"/>
                    </ww:param>
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
                        <ww:text name="directoryconnector.passwordupdate.description"/>
                    </ww:param>
                </ww:password>
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
