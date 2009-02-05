<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.addapplication.label')"/>
    </title>
    <meta name="section" content="applications"/>
    <meta name="pagename" content="add"/>
    <meta name="help.url" content="<ww:property value="getText('help.application.add')"/>"/>
</head>
<body>

<h2>
    <ww:property value="getText('menu.addapplication.label')"/>
</h2>

<div class="page-content">

    <ul class="tabs">
        <li class="on" id="hreftab1">
            <span class="tab">1. <ww:property value="getText('menu.details.label')"/></span>
        </li>

        <li id="hreftab2">
            <span class="tab">2. <ww:property value="getText('menu.connection.label')"/></span>
        </li>

        <li id="hreftab3">
            <span class="tab">3. <ww:property value="getText('menu.directory.label')"/></span>
        </li>

        <li id="hreftab4">
            <span class="tab">4. <ww:property value="getText('menu.authorisation.label')"/></span>
        </li>

        <li id="hreftab5">
            <span class="tab">5. <ww:property value="getText('menu.confirmation.label')"/></span>
        </li>
    </ul>

    <div class="crowdForm">

        <form method="post" action="<ww:url namespace="/console/secure/application" action="addapplicationdetails" method="completeStep" />">

            <div class="formBodyNoTop">

                <ww:component template="form_messages.jsp"/>

                <ww:select list="applicationTypes" name="applicationType" listKey="key" listValue="value">
                    <ww:param name="emptyOption" value="getText('application.type.empty.option')"/>
                    <ww:param name="label" value="getText('application.type.label')"/>
                    <ww:param name="required" value="true"/>
                    <ww:param name="description">
                        <ww:property value="getText('application.type.description')"/>
                    </ww:param>
                </ww:select>

                <ww:textfield name="name" size="35px;">
                    <ww:param name="label" value="getText('application.name.label')"/>
                    <ww:param name="required" value="true"/>
                    <ww:param name="description">
                        <ww:property value="getText('application.name.description')"/>
                    </ww:param>
                </ww:textfield>

                <ww:textfield name="description" size="35px;">
                    <ww:param name="label" value="getText('application.description.label')"/>
                    <ww:param name="description">
                        <ww:property value="getText('application.description.description')"/>
                    </ww:param>
                </ww:textfield>

                <ww:password name="password" size="35px;">
                    <ww:param name="label" value="getText('password.label')"/>
                    <ww:param name="required" value="true"/>
                </ww:password>

                <ww:password name="passwordConfirmation" size="35px;">
                    <ww:param name="label" value="getText('passwordconfirm.label')"/>
                    <ww:param name="required" value="true"/>
                </ww:password>

            </div>

            <div class="formFooter wizardFooter">

                <div class="buttons">

                    <input type="submit" class="button" value="<ww:property value="getText('next.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="addapplicationdetails" method="cancel" />';"/>

                </div>

            </div>

        </form>

    </div>
</div>

</body>
</html>
