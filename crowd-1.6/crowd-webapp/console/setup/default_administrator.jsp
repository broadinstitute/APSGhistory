<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('defaultadmin.title')"/>
    </title>
    <meta name="help.url" content="<ww:property value="getText('help.setup.defaultadmin')"/>"/>
</head>
<body>

<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console/setup" action="defaultadministrator" method="update" />" name="administrator">

        <div class="formTitle">
            <h2>
                <ww:property value="getText('defaultadmin.title')"/>
            </h2>
        </div>

        <div class="formBody">

            <p>
                <ww:property value="getText('defaultadmin.text')"/>
            </p>

            <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

            <ww:component template="form_messages.jsp"/>

            <ww:textfield name="email" size="50">
                <ww:param name="label" value="getText('principal.email.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('principal.email.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
            </ww:textfield>

            <ww:textfield name="name">
                <ww:param name="label" value="getText('principal.name.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('principal.adminname.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
            </ww:textfield>

            <ww:password name="password">
                <ww:param name="label" value="getText('principal.password.label')"/>
                <ww:param name="required" value="true"/>
            </ww:password>

            <ww:password name="passwordConfirm">
                <ww:param name="label" value="getText('principal.passwordconfirm.label')"/>
                <ww:param name="required" value="true"/>
            </ww:password>

            <ww:textfield name="firstname">
                <ww:param name="label" value="getText('principal.firstname.label')"/>
                <ww:param name="required" value="true"/>
            </ww:textfield>

            <ww:textfield name="lastname">
                <ww:param name="label" value="getText('principal.lastname.label')"/>
                <ww:param name="required" value="true"/>
            </ww:textfield>
        </div>

        <div class="formFooter wizardFooter">

            <div class="buttons">
                <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
            </div>
        </div>

    </form>

</div>

</body>
</html>