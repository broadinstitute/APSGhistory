<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="sitemesh-page" prefix="page" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
    <ww:property value="getText('options.title')"/></title>
    <meta name="section" content="administration" />
    <meta name="pagename" content="general" />
    <meta name="help.url" content="<ww:property value="getText('help.admin.general')"/>"/>
</head>

    <body>
            <h2><ww:property value="getText('menu.options.label')"/></h2>

            <div class="page-content">
                <div class="crowdForm">
                    <form id="general" method="post" action="<ww:url namespace="/console/secure/admin" action="general" method="update" includeParams="none"/>" name="general">
                        <div class="formBody">

                            <ww:component template="form_messages.jsp"/>

                            <ww:textfield name="title" >
                                <ww:param name="label" value="getText('options.title.label')" />
                                <ww:param name="description" value="getText('options.title.description')" />
                                <ww:param name="required" value="true"/>
                            </ww:textfield>

                            <ww:textfield name="domain" >
                                <ww:param name="label" value="getText('options.domain.label')" />
                                <ww:param name="description"><ww:property value="getText('options.domain.description')"/></ww:param>
                            </ww:textfield>

                            <ww:checkbox name="secureCookie" fieldValue="true" >
                                <ww:param name="label" value="getText('options.securecookie.label')" />
                                <ww:param name="description"><ww:property value="getText('options.securecookie.description')"/></ww:param>
                            </ww:checkbox>

                            <ww:checkbox name="cachingEnabled" fieldValue="true" >
                                <ww:param name="label" value="getText('caching.enabled.label')" />
                                <ww:param name="description"><ww:property value="getText('caching.enabled.description')"/></ww:param>
                            </ww:checkbox>

                            <ww:checkbox name="gzip">
                                <ww:param name="label" value="getText('options.gzip.label')" />
                                <ww:param name="description"><ww:property value="getText('options.gzip.description')"/></ww:param>
                            </ww:checkbox>

                            <ww:textfield name="seed" >
                                <ww:param name="label" value="getText('options.seed.label')" />
                                <ww:param name="description"><ww:property value="getText('options.seed.description')"/></ww:param>
                                <ww:param name="required" value="true"/>
                            </ww:textfield>

                        </div>

                        <div class="formFooter wizardFooter">

                            <div class="buttons">
                                <input id="generate-token-seed" type="button" class="button" value="<ww:property value="getText('generate.label')"/>" onclick="document.general.action='<ww:url namespace="/console/secure/admin" action="general" method="generate" includeParams="none"/>';document.general.submit();" />
                                <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                                <input type="button" class="button" id="cancel" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/admin" action="general" method="default" includeParams="none"></ww:url>';"/>
                            </div>
                        </div>

                    </form>

                </div>
        </div>
    </body>
</html>