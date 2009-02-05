<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('changepassword.title')"/></title>
    </head>

    <body>

        <form method="post" action="<ww:url namespace="/console/secure/" action="changepassword" method="update" includeParams="none"/>" name="changepassword">

            <div class="crowdForm">

                <h2><ww:property value="getText('changepassword.title')"/></h2>

                <ww:component template="form_messages.jsp"/>

                <div class="formBodyNoTop">

                    <ww:password name="originalPassword" size="60">
                        <ww:param name="value" value="originalPassword"/>
                        <ww:param name="label">
                            <ww:property value="getText('originalpassword.label')"/>
                        </ww:param>
                    </ww:password>

                    <ww:password name="password" size="60">
                        <ww:param name="value" value="password"/>
                        <ww:param name="label">
                            <ww:property value="getText('password.label')"/>
                        </ww:param>
                    </ww:password>

                    <ww:password name="confirmPassword" size="60">
                        <ww:param name="value" value="confirmPassword"/>
                        <ww:param name="label">
                            <ww:property value="getText('confirmpassword.label')"/>
                        </ww:param>
                    </ww:password>
                </div>

                <div class="formFooter wizardFooter">
                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/secure" action="console" includeParams="none"/>';"/>
                    </div>
                </div>

            </div>
        </form>

    </body>
</html>