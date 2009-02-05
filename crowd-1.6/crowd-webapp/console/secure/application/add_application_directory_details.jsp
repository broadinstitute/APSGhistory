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

        <li class="on" id="hreftab3">
            <span class="tab">3. <ww:property value="getText('menu.directory.label')"/></span>
        </li>

        <li id="hreftab4">
            <span class="tab">4. <ww:property value="getText('menu.authorisation.label')"/></span>
        </li>

        <li id="hreftab5">
            <span class="tab">5. <ww:property value="getText('menu.confirmation.label')"/></span>
        </li>
    </ul>

    <div class="crowdForm">

        <form method="post"
              action="<ww:url namespace="/console/secure/application" action="addapplicationdirectorydetails" method="completeStep" includeParams="none"/>">

            <div class="formBodyNoTop">

                <div class="descriptionSection"><ww:text name="application.directories.description"/></div>

                <ww:component template="form_messages.jsp"/>

                <ww:iterator value="directories" status="status">

                    <ww:set name="directoryid" value="ID"/>
                    <div class="fieldArea required">
                        <label class="fieldLabelArea" for="directory-<ww:property value="#directoryid"/>"><ww:property value="name"/>:</label>
                        <div class="fieldValueArea">
                            <input name="selecteddirectories" value="<ww:property value="#directoryid"/>" id="directory-<ww:property value="#directoryid"/>" type="checkbox" <ww:if test="isSelectedDirectory(#directoryid)">checked</ww:if> />
                                <div class="fieldDescription"><ww:property value="implementation.directoryType"/><ww:if test="description != null && description.length() > 0">&nbsp;&ndash;&nbsp;<ww:property value="description"/></ww:if></div>
                        </div>
                    </div>

                </ww:iterator>

            </div>

            <div class="formFooter wizardFooter">

                <div class="buttons">

                    <input type="submit" class="button" value="<ww:property value="getText('next.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="addapplicationdetails" method="cancel" />';"/>

                </div>

            </div>

        </form>

    </div>
</div>

</body>
</html>