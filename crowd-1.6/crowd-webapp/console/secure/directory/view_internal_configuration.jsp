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
    <meta name="help.url" content="<ww:text name="help.directory.internal.configuration"/>"/>
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
            <a id="internal-general" href="<ww:url action="viewinternal" namespace="/console/secure/directory" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.details.label"/></a>
        </li>

        <li class="on">
            <span class="tab"><ww:text name="menu.configuration.label"/></span>
        </li>

        <li>
            <a id="internal-permissions" href="<ww:url namespace="/console/secure/directory" action="updateinternalpermissions" includeParams="none"><ww:param name="ID" value="ID" /></ww:url>"><ww:text name="menu.permissions.label"/></a>
        </li>

    </ol>


    <div class="tabContent static" id="tab2">

        <div class="crowdForm">
            <form method="post" name="updateConfiguration"
                  action="<ww:url namespace="/console/secure/directory" action="updateinternalconfiguration" method="update" includeParams="none" />">
                <div class="formBody">

                    <ww:component template="form_messages.jsp"/>

                    <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

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

                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('directoryconnector.userencryptionmethod.label')"/>
                        <ww:param name="value">
                            <ww:property value="userEncryptionMethod"/>
                        </ww:param>
                    </ww:component>
                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">

                        <input type="submit" class="button"
                               value="<ww:property value="getText('update.label')"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewinternal" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>';"/>
                    </div>
                </div>

            </form>

        </div>
    </div>


</div>
</body>
</html>