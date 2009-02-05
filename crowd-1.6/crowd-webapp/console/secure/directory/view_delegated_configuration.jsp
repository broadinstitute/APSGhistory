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

            <li class="on">
                <span class="tab"><ww:text name="menu.configuration.label"/></span>
            </li>

            <li>
                <a id="delegated-permissions" href="<ww:url namespace="/console/secure/directory" action="updatedelegatedpermissions" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.permissions.label"/></a>
            </li>

        </ol>

        <div class="tabContent static" id="tab1">

            <div class="crowdForm">
                <form id="configuration_details" method="post" action="<ww:url namespace="/console/secure/directory" action="updatedelegatedconfiguration" method="update" includeParams="none" />">
                    <div class="formBody">

                        <ww:component template="form_messages.jsp"/>

                        <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                        <h3>
                            <ww:text name="directoryconnector.userconfiguration.label"/>
                        </h3>

                        <ww:textfield name="userDNaddition" size="35px;">
                            <ww:param name="label" value="getText('directoryconnector.userdnaddition.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.userdnaddition.description"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:textfield name="userObjectClass" size="35px;">
                            <ww:param name="required" value="true" />
                            <ww:param name="label" value="getText('directoryconnector.userobjectclass.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.userobjectclass.description"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:textfield name="userObjectFilter" size="35px;">
                            <ww:param name="required" value="true" />
                            <ww:param name="label" value="getText('directoryconnector.userobjectfilter.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.userobjectfilter.description"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:textfield name="userNameAttr" size="35px;">
                            <ww:param name="required" value="true" />
                            <ww:param name="label" value="getText('directoryconnector.usernameattribute.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.usernameattribute.description"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:textfield name="userNameRdnAttr" size="35px;">
                            <ww:param name="label" value="getText('directoryconnector.usernamerdnattribute.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('directoryconnector.usernamerdnattribute.description')"/>
                            </ww:param>
                            <ww:param name="required" value="true" />
                        </ww:textfield>

                        <ww:textfield name="userFirstnameAttr" size="35px;">
                            <ww:param name="required" value="true" />
                            <ww:param name="label" value="getText('directoryconnector.userfirstnameattribute.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.userfirstnameattribute.description"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:textfield name="userLastnameAttr" size="35px;">
                            <ww:param name="required" value="true" />
                            <ww:param name="label" value="getText('directoryconnector.userlastnameattribute.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.userlastnameattribute.description"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:textfield name="userDisplayNameAttr" size="35px;">
                            <ww:param name="label" value="getText('directoryconnector.userdisplaynameattribute.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('directoryconnector.userdisplaynameattribute.description')"/>
                            </ww:param>
                            <ww:param name="required" value="true" />
                        </ww:textfield>

                        <ww:textfield name="userMailAttr" size="35px;">
                            <ww:param name="required" value="true" />
                            <ww:param name="label" value="getText('directoryconnector.usermailattribute.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.usermailattribute.description"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:textfield name="userGroupMemberAttr" size="35px;">
                            <ww:param name="required" value="true" />
                            <ww:param name="label" value="getText('directoryconnector.usermemberofattribute.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.usermemberofattribute.description"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:textfield name="userPasswordAttr" size="35px;">
                            <ww:param name="required" value="true" />
                            <ww:param name="label" value="getText('directoryconnector.userpassword.label')"/>
                            <ww:param name="description">
                                <ww:text name="directoryconnector.userpassword.description"/>
                            </ww:param>
                        </ww:textfield>
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
