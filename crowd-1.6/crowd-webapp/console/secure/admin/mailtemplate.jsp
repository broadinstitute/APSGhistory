<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="sitemesh-page" prefix="page" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
    <ww:property value="getText('options.title')"/></title>
    <meta name="section" content="administration" />
    <meta name="pagename" content="mailtemplate" />
    <meta name="help.url" content="<ww:property value="getText('help.admin.mailtemplate')"/>"/>
</head>

    <body>
            <h2><ww:property value="getText('menu.mailtemplate.label')"/></h2>

            <div class="page-content">
                <div class="crowdForm">
                    <form id="mailtemplate" method="post" action="<ww:url namespace="/console/secure/admin" action="mailtemplate" method="update" includeParams="none"/>" name="mailtemplate">
                        <div class="formBody">

                            <ww:component template="form_messages.jsp"/>

                            <ww:textarea name="template" rows="10" cols="80" >
                                <ww:param name="label" value="getText('mailtemplate.template.label')" />
                                <ww:param name="description"><ww:property value="getText('mailtemplate.template.description')" escape="false"/></ww:param>
                            </ww:textarea>
                        </div>
                        <div class="formFooter wizardFooter">

                            <div class="buttons">
                                <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                                <input type="button" class="button" id="cancel" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/admin" action="mailtemplate" method="default" includeParams="none" ></ww:url>';"/>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
    </body>
</html>