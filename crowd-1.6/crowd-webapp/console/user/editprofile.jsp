<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>

<head>
    <title><ww:text name="menu.user.console.editprofile.label"/></title>

    <meta name="section" content="user.console"/>
    <meta name="pagename" content="editprofile"/>
    <meta name="help.url" content="<ww:text name="help.user.console.editprofile"/>"/>
</head>

<body>

    <h2><ww:text name="menu.user.console.editprofile.label"/></h2>

    <div class="page-content">
        <div class="crowdForm">
            <form id="general" method="post" action="<ww:url namespace="/console/user" action="updateprofile" includeParams="none"/>" name="updateprofile">

                <div class="formBody">

                    <ww:component template="form_messages.jsp"/>

                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('principal.name.label')" />
                        <ww:param name="value">
                            <ww:property value="username"/>
                        </ww:param>
                    </ww:component>

                    <ww:textfield name="firstname">
                        <ww:param name="label" value="getText('principal.firstname.label')"/>
                    </ww:textfield>

                    <ww:textfield name="lastname">
                        <ww:param name="label" value="getText('principal.lastname.label')"/>
                    </ww:textfield>

                    <ww:textfield name="email" size="50">
                        <ww:param name="label" value="getText('principal.email.label')"/>
                    </ww:textfield>

                </div>

                <div class="formFooter wizardFooter">
                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                        <input type="button" class="button" id="cancel" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/user" action="viewprofile" includeParams="none"></ww:url>';"/>
                    </div>
                </div>

            </form>
        </div>
    </div>

</body>
</html>