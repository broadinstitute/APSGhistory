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
    <meta name="help.url" content="<ww:property value="getText('help.directory.connector.details')"/>"/>
</head>
<body>
<h2>
    <ww:text name="menu.viewdirectory.label">
        <ww:param id="0" value="directory.name"/>
    </ww:text>
</h2>

<div class="page-content">

    <ol class="tabs">

        <li class="on">
            <span class="tab"><ww:text name="menu.details.label"/></span>
        </li>

        <li>
            <a id="connector-connectiondetails" href="<ww:url namespace="/console/secure/directory" action="updateconnectorconnection" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.connector.label"/></a>
        </li>

        <li>
            <a id="connector-configuration" href="<ww:url namespace="/console/secure/directory" action="updateconnectorconfiguration" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.configuration.label"/></a>
        </li>

        <li>
            <a id="connector-permissions" href="<ww:url namespace="/console/secure/directory" action="updateconnectorpermissions" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.permissions.label"/></a>
        </li>

    </ol>

    <div class="tabContent static" id="tab1">

        <div class="crowdForm">
            <form id="updateGeneral" method="post" action="<ww:url namespace="/console/secure/directory" action="updateconnector" includeParams="none" />">
                <div class="formBodyNoTop">

                    <ww:component template="form_messages.jsp"/>

                    <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                    <ww:textfield name="name" size="50">
                        <ww:param name="required" value="true"/>
                        <ww:param name="label" value="getText('directoryinternal.name.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.name.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:textfield name="directoryDescription" size="50">
                        <ww:param name="label" value="getText('directoryinternal.description.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('directoryinternal.description.description')"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('directory.type.label')"/>
                        <ww:param name="value">
                            <ww:property value="directory.implementation.directoryType"/>
                        </ww:param>
                    </ww:component>

                    <ww:checkbox name="active" fieldValue="true">
                        <ww:param name="label" value="getText('directory.active.label')"/>
                    </ww:checkbox>

                    <ww:if test="cachingConfigured">
                    <div class="eventCaching" display="none">
                        <ww:if test="!cachingInitialised">
                            <ww:component template="form_row.jsp">
                                <ww:param name="label" value="getText('directory.caching.present.label')"/>
                                <ww:param name="value">
                                    <ww:property value="getText('directory.caching.uninitialised.label')"/>
                                </ww:param>
                            </ww:component>
                        </ww:if>
                        <ww:else>
                            <ww:component template="form_row.jsp">
                                <ww:param name="label" value="getText('directory.caching.principals.label')"/>
                                <ww:param name="value">
                                    <ww:property value="cacheStats.numberOfPrincipals"/>
                                </ww:param>
                            </ww:component>

                            <ww:component template="form_row.jsp">
                                <ww:param name="label" value="getText('directory.caching.groups.label')"/>
                                <ww:param name="value">
                                    <ww:property value="cacheStats.numberOfGroups"/>
                                </ww:param>
                            </ww:component>

                            <ww:component template="form_row.jsp">
                                <ww:param name="label" value="getText('directory.caching.roles.label')"/>
                                <ww:param name="value">
                                    <ww:property value="cacheStats.numberOfRoles"/>
                                </ww:param>
                            </ww:component>

                            <div class="fieldArea required">
                                <label class="fieldLabelArea" for="Description">
                                    <ww:property value="getText('directory.caching.lastupdated.label')" escape="false"/>
                                </label>
                                <div class="fieldValueArea">
                                    <ww:if test="cacheStats.lastUpdated != null">
                                        <ww:date name="cacheStats.lastUpdated" nice="false" format="%{getText('directory.caching.lastupdated.format')}"/>
                                    </ww:if>
                                    <ww:else>
                                        <ww:property value="getText('directory.caching.lastupdated.unknown')"/>
                                    </ww:else>
                                </div>
                            </div>
                        </ww:else>
                    </div>
                    </ww:if>
                </div>

                <div class="formFooter wizardFooter">
                    <div class="buttons">

                        <ww:if test="cachingInitialised">
                            <input type="button" class="button" id="flushCacheButton" value="<ww:property value="getText('directory.caching.flush.label')"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/directory" action="flushconnectorcache" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>                            
                        </ww:if>
                        <input type="submit" class="button"
                               value="<ww:property value="getText('update.label')"/> &raquo;"/>
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