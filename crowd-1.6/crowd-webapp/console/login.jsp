<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('login.title')"/></title>

        <meta name="help.url" content="<ww:property value="getText('help.login')"/>"/>
    </head>

    <body onload="document.login.j_username.focus()">

    <!-- The double use of console is necessary to get Webwork 2.2.6 to render the form action url properly. -->
    <form method="post" action="<ww:url namespace="/console" value="/console/j_security_check"/>" id="login" name="login">

        <div class="crowdForm">

            <h2><ww:text name="login.title"/> <ww:text name="login.to"/> <ww:property value="applicationName"/></h2>

            <div class="formBodyNoTop">

                <ww:component template="form_messages.jsp"/>

                <ww:textfield name="j_username" size="30">
                    <ww:param name="label" value="getText('username.label')"/>
                    <ww:param name="required" value="true"/>
                </ww:textfield>

                <ww:password name="j_password" size="30">
                    <ww:param name="label" value="getText('password.label')"/>
                    <ww:param name="required" value="true"/>
                </ww:password>

            </div>
            
            <ww:if test="showForgotPassword">
            <div class="fieldArea">
                <div class="secondColumn"><a id="forgottenpassword" href="<ww:url namespace="/console" action="forgottenpassword" method="default"/>"><ww:text name="forgottenpassword.link.label" /></a></div>
            </div>
            </ww:if>

            <div class="formFooter wizardFooter">
                <div class="buttons">
                    <input type="submit" class="button" value="<ww:property value="getText('login.label')"/> &raquo;"/>
                </div>
            </div>

        </div>

    </form>

    </body>
</html>