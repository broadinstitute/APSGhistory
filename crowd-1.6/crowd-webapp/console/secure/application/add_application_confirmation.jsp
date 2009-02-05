<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.addapplication.label')"/>
    </title>
    <meta name="section" content="applications"/>
    <meta name="pagename" content="add"/>
    <meta name="help.url" content="<ww:property value="getText('help.application.add')"/>"/>
</head>
<body>

<h2>
    <ww:property value="getText('menu.addapplication.label')"/> - <ww:property value="configuration.name"/>
</h2>

<div class="page-content">

    <ul class="tabs">
        <li id="hreftab1">
            <a href="<ww:url action="addapplicationdetails" namespace="/console/secure/application" includeParams="none"/>">1. <ww:property
                    value="getText('menu.details.label')"/></a>
        </li>

        <li id="hreftab2">
            <a href="<ww:url action="addapplicationconnectiondetails" namespace="/console/secure/application" includeParams="none"/>">2. <ww:property
                    value="getText('menu.connection.label')"/></a>
        </li>

        <li id="hreftab3">
            <a href="<ww:url action="addapplicationdirectorydetails" namespace="/console/secure/application" includeParams="none"/>">3. <ww:property
                    value="getText('menu.directory.label')"/></a>
        </li>

        <li id="hreftab4">
            <a href="<ww:url action="addapplicationauthorisationdetails" namespace="/console/secure/application" includeParams="none"/>">4.
                <ww:property value="getText('menu.authorisation.label')"/></a>
        </li>

        <li class="on" id="hreftab5">
            <span class="tab">5. <ww:property value="getText('menu.confirmation.label')"/></span>
        </li>
    </ul>

    <div class="crowdForm">

            <div class="formBodyNoTop">

                <ww:component template="form_messages.jsp"/>

                <div class="fieldArea">
                    <label class="fieldLabelArea"><ww:text name="application.type.label"/>:</label>
                    <div class="fieldValueArea"><ww:property value="configuration.applicationType.displayName"/>
                    </div>
                </div>

                <div class="fieldArea">
                    <label class="fieldLabelArea"><ww:text name="application.name.label"/>:</label>
                    <div class="fieldValueArea"><ww:property value="configuration.name"/>
                    </div>
                </div>

                <ww:if test="configuration.description != null && configuration.description.length > 0">
                <div class="fieldArea">
                    <label class="fieldLabelArea"><ww:text name="application.description.label"/>:</label>
                    <div class="fieldValueArea"><ww:property value="configuration.description"/>
                    </div>
                </div>
                </ww:if>

                <div class="fieldArea">
                    <label class="fieldLabelArea"><ww:text name="application.url.label"/>:</label>
                    <div class="fieldValueArea"><ww:property value="configuration.applicationURL"/>
                    </div>
                </div>

                <div class="fieldArea">
                    <label class="fieldLabelArea"><ww:text name="application.remoteipaddress.label"/>:</label>
                    <div class="fieldValueArea">
                        <ww:iterator value="configuration.remoteAddresses" status="status">
                            <ww:property value="address"/><ww:if test="!#status.last">,&nbsp;</ww:if>
                        </ww:iterator>
                    </div>
                </div>

                <ww:iterator value="configuration.directoryids" id="id">
                    <ww:set name="directoryName" value="directory(#id).name"/>
                <div class="sectionSubTitle"><ww:text name="directory.label"/>&nbsp;&ndash;&nbsp;<ww:property value="#directoryName"/></div>

                    <ww:if test="configuration.allowAllForDirectory.get(#id)">
                        <div class="fieldArea required">
                            <div style="margin-left:100px;">
                                <ww:text name="application.directories.allow.all.confirmation"><ww:param id="0">'<ww:property value="configuration.name"/>'</ww:param></ww:text>
                            </div>
                        </div>
                    </ww:if>
                    <ww:else>
                        <div class="fieldArea">
                            <label class="fieldLabelArea"><ww:text name="application.groups.authorised.label"/>:</label>
                            <div class="fieldValueArea">
                                <ww:if test="configuration.directoryGroupMappings.get(#id) == null">
                                    <ww:text name="application.directories.none.authorised.confirmation">
                                        <ww:param id="0">'<ww:property value="configuration.name"/>'</ww:param>
                                        <ww:param id="1">'<ww:property value="#directoryName"/>'</ww:param>
                                    </ww:text>
                                </ww:if>
                                <ww:else>
                                    <ww:iterator value="configuration.directoryGroupMappings.get(#id)" status="status">
                                        <ww:property /><ww:if test="!#status.last">,&nbsp;</ww:if>
                                    </ww:iterator>
                                </ww:else>
                            </div>
                        </div>
                    </ww:else>

                </ww:iterator>

            </div>

            <div class="formFooter wizardFooter">

                <div class="buttons">

                    <form method="post" action="<ww:url namespace="/console/secure/application" action="addapplicationconfirmation" method="completeStep" />"> <!-- Required for JWebUnit -->

                    <input id="add-application" name="add-application" type="submit" class="button" value="<ww:property value="getText('menu.addapplication.label')"/>" style="width:auto;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="addapplicationdetails" method="cancel" />';"/>

                    </form>
                </div>

            </div>

    </div>
</div>

</body>
</html>