<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.addgroup.label')"/>
    </title>
    <meta name="section" content="groups"/>
    <meta name="pagename" content="addgroup"/>
    <meta name="help.url" content="<ww:property value="getText('help.group.add')"/>"/>
</head>
<body>

<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console/secure/group" action="add" method="update" includeParams="none"/>">

        <div class="formTitle">
            <h2>
                <ww:property value="getText('menu.addgroup.label')"/>
            </h2>
        </div>

        <div class="formBody">

            <ww:component template="form_messages.jsp"/>

            <ww:textfield name="name" size="'35px;'">
                <ww:param name="label" value="getText('group.name.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('group.name.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
            </ww:textfield>

            <ww:textfield name="description" size="'35px;'">
                <ww:param name="label" value="getText('group.description.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('group.description.description')"/>
                </ww:param>
            </ww:textfield>

            <ww:select name="directoryID" list="directories" listKey="ID" listValue="name">
                <ww:param name="headerKey" value="-1"/>
                <ww:param name="headerValue" value="getText('selectdirectory.label')"/>
                <ww:param name="label" value="getText('group.directory.label')"/>
                <ww:param name="description">
                    <ww:property value="getText('group.directory.description')"/>
                </ww:param>
                <ww:param name="required" value="true"/>
            </ww:select>

            <ww:checkbox name="active" fieldValue="true">
                <ww:param name="label" value="getText('group.active.label')"/>
            </ww:checkbox>
        </div>

        <div class="formFooter wizardFooter">

            <div class="buttons">
                <input type="submit" class="button" value="<ww:property value="getText('create.label')"/> &raquo;"/>
                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/group" action="browse" includeParams="none" />';"/>
            </div>
        </div>

    </form>

</div>

</body>
</html>