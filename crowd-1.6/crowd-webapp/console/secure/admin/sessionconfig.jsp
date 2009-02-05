<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="sitemesh-page" prefix="page" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
    <ww:property value="getText('options.title')"/></title>
    <meta name="section" content="administration" />
    <meta name="pagename" content="sessionconfig" />
    <meta name="help.url" content="<ww:property value="getText('help.admin.sessionconfig')"/>"/>
</head>

    <body>
            <h2><ww:property value="getText('menu.sessionconfig.label')"/></h2>

            <div class="page-content">
                <div class="crowdForm">
                    <form id="session" method="post" action="<ww:url namespace="/console/secure/admin" action="sessionconfig" method="update" includeParams="none"/>" name="session">
                        <div class="formBody">

                            <ww:component template="form_messages.jsp"/>

                            <ww:textfield name="sessionTime" >
                                <ww:param name="label" value="getText('session.sessiontime.label')" />
                                <ww:param name="description"><ww:property value="getText('session.sessiontime.description')"/></ww:param>
                            </ww:textfield>

                            <ww:radio
                                list="tokenStorageOptions"
                                name="tokenStorageLocation"
                                listKey="key"
                                listValue="value">
                                <ww:param name="label" value="getText('caching.token.label')" />
                                <ww:param name="description" value="getText('caching.token.description')" />
                            </ww:radio>
                        </div>

                        <div class="formFooter wizardFooter">

                            <div class="buttons">
                                <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/admin" action="sessionconfig" method="default" includeParams="none"><ww:param name="tab" value="6"/></ww:url>';"/>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
    </body>
</html>