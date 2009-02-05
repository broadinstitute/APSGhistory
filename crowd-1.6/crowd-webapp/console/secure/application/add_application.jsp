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
<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console/secure/application" action="add" method="update" />">

        <div class="formBodyNoTop">

            <ww:component template="form_messages.jsp"/>

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

            <ww:checkbox name="active" fieldValue="true">
                <ww:param name="label" value="getText('application.active.label')"/>
            </ww:checkbox>

            <ww:password name="password" size="35px;">
                <ww:param name="label" value="getText('password.label')"/>
                <ww:param name="required" value="true"/>
            </ww:password>

            <ww:password name="passwordConfirm" size="35px;">
                <ww:param name="label" value="getText('passwordconfirm.label')"/>
                <ww:param name="required" value="true"/>
            </ww:password>

            <ww:select name="directoryID" list="directories" listKey="ID" listValue="name">
                <ww:param name="headerKey" value="-1"/>
                <ww:param name="headerValue" value="getText('selectdirectory.label')"/>
                <ww:param name="label" value="getText('application.defaultdirectory.label')"/>
                <ww:param name="required" value="true"/>
                <ww:param name="description">
                    <ww:property value="getText('application.defaultdirectory.description')"/>
                </ww:param>
            </ww:select>
        </div>

        <div class="formFooter wizardFooter">

            <div class="buttons">

                <input type="submit" class="button" value="<ww:property value="getText('create.label')"/> &raquo;"/>
                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/application" action="browse" />';"/>

            </div>

        </div>

    </form>

</div>

</body>
</html>