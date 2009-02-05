<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="sitemesh-page" prefix="page" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
    <ww:property value="getText('menu.restore.label')"/></title>
    <meta name="section" content="administration" />
    <meta name="pagename" content="restore" />
    <meta name="help.url" content="<ww:property value="getText('help.admin.restore')"/>"/>
</head>

    <body>
            <h2><ww:property value="getText('menu.restore.label')"/></h2>

            <div class="page-content">
                <div class="crowdForm">
                    <form method="post" action="<ww:url namespace="/console/secure/admin" action="restore" method="import" includeParams="none" />" name="import">
                        <div class="formBody">

                            <p><ww:text name="administration.restore.text"/></p>

                            <p class="noteBox"><ww:text name="administration.restore.warning.text"/></p>

                            <ww:if test="importResponseMessage != null" >
                                <p class="success"><ww:property value="importResponseMessage"/></p>
                            </ww:if>

                            <ww:component template="form_messages.jsp"/>

                            <ww:textfield name="importFilePath" size="50">
                                <ww:param name="label" value="getText('administration.restore.filepath.label')"/>
                                <ww:param name="description">
                                    <ww:property value="getText('administration.restore.filepath.pathinfo')"/>
                                </ww:param>

                            </ww:textfield>

                        </div>
                        <div class="formFooter wizardFooter">

                            <div class="buttons">
                                <input name="import-submit" type="submit" class="button" value="<ww:property value="getText('submit.label')"/> &raquo;"/>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
    </body>
</html>                                                                                                     