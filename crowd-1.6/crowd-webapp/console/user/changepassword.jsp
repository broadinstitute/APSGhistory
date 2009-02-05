<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>

<head>
    <title><ww:text name="menu.user.console.changepassword.label"/></title>

    <meta name="section" content="user.console"/>
    <meta name="pagename" content="changepassword"/>
    <meta name="help.url" content="<ww:text name="help.user.console.changepassword"/>"/>
</head>

<body>

    <h2><ww:text name="menu.user.console.changepassword.label"/></h2>

    <div class="page-content">
        <div class="crowdForm">
            <form id="general" method="post" action="<ww:url namespace="/console/user" action="changepassword" includeParams="none"/>" name="changepassword">

                <div class="formBody">

                    <ww:component template="form_messages.jsp"/>

                    <ww:password name="originalPassword" size="45" required="true">
                        <ww:param name="value" value="originalPassword"/>
                        <ww:param name="label">
                            <ww:property value="getText('originalpassword.label')"/>
                        </ww:param>
                    </ww:password>

                    <ww:password name="password" size="45" required="true">
                        <ww:param name="value" value="password"/>
                        <ww:param name="label">
                            <ww:property value="getText('newpassword.label')"/>
                        </ww:param>
                    </ww:password>

                    <ww:password name="confirmPassword" size="45" required="true">
                        <ww:param name="value" value="confirmPassword"/>
                        <ww:param name="label">
                            <ww:property value="getText('confirmpassword.label')"/>
                        </ww:param>
                    </ww:password>

                </div>

                <div class="formFooter wizardFooter">
                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                        <input type="button" class="button" id="cancel" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/user" action="viewchangepassword" includeParams="none"></ww:url>';"/>
                    </div>
                </div>

            </form>
        </div>
    </div>

</body>
</html>