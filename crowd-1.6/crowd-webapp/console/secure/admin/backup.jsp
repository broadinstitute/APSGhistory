<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="sitemesh-page" prefix="page" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
    <ww:property value="getText('menu.backup.label')"/></title>
    <meta name="section" content="administration" />
    <meta name="pagename" content="backup" />
    <meta name="help.url" content="<ww:property value="getText('help.admin.backup')"/>"/>
</head>

    <body>
            <h2><ww:property value="getText('menu.backup.label')"/></h2>

            <div class="page-content">
                <div class="crowdForm">
                    <form method="post" action="<ww:url namespace="/console/secure/admin" action="backup" method="export" includeParams="none" />" name="export">
                        <div class="formBody">

                            <ww:component template="form_messages.jsp"/>

                            <p><ww:text name="administration.backup.text"/></p>

                            <ww:if test="exportResponseMessage != null" >
                                <p class="success"><ww:property value="exportResponseMessage"/></p>
                            </ww:if>

                            <ww:component template="form_messages.jsp"/>

                            <ww:checkbox name="resetDomain" fieldValue="true">
                                <ww:param name="label" value="getText('administration.backup.resetdomain.label')"/>
                                <ww:param name="description">
                                    <ww:property value="getText('administration.backup.resetdomain.description')"/>
                                </ww:param>
                            </ww:checkbox>

                            <ww:textfield name="exportFilePath" size="50">
                                <ww:param name="label" value="getText('administration.backup.filepath.label')"/>
                                <ww:param name="description">
                                    <ww:property value="getText('administration.backup.filepath.pathinfo')"/>
                                </ww:param>
                            </ww:textfield>
                        </div>
                        <div class="formFooter wizardFooter">

                            <div class="buttons">
                                <input type="submit" class="button" value="<ww:property value="getText('submit.label')"/> &raquo;"/>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
    </body>
</html>