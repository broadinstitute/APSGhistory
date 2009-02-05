<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('forgottenpassword.title')"/>
    </title>
</head>

<body>

<form method="post" action="<ww:url namespace="/console" action="forgottenpassword" method="input" />"
      name="forgottenpassword">

    <div class="crowdForm">

        <h2>
            <ww:text name="forgottenpassword.title" />
        </h2>

        <div class="formBodyNoTop">

            <ww:component template="form_messages.jsp"/>

            <div class="titleSection">
                <ww:text name="forgottenpassword.message.label" />
            </div>            

            <ww:textfield name="username" size="30">
                <ww:param name="label" value="getText('username.label')"/>
                <ww:param name="required" value="true"/>
                <ww:param name="description" value="getText('forgottenpassword.username.description')"/>
            </ww:textfield>

        </div>
        <div class="formFooter wizardFooter">
            <div class="buttons">
                <input type="submit" name="save"
                       value="<ww:property value="getText('continue.label')"/>"/>
            </div>
        </div>

    </div>

</form>

</body>
</html>