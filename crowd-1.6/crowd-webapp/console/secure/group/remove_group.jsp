<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('group.remove.title')"/>
    </title>
    <meta name="section" content="groups"/>
    <meta name="pagename" content="removegroup"/>
    <meta name="help.url" content="<ww:property value="getText('help.group.remove')"/>"/>
</head>
<body>


<div class="crowdForm">

    <div class="formTitle">
        <h2>
            <ww:property value="getText('group.remove.title')"/>
            &nbsp;&ndash;&nbsp;
            <ww:property value="name"/>
        </h2>
    </div>

    <div class="formBody">
        <ww:component template="form_messages.jsp"/>

        <ww:component template="form_row.jsp">
           <ww:param name="warning" value="getText('group.remove.text')" />
           <ww:param name="label" value="getText('group.name.label')" />
           <ww:param name="value" value="group.name" />
           <ww:param name="description" value=""/>
        </ww:component>

        <ww:component template="form_row.jsp">
           <ww:param name="label" value="getText('group.directory.label')" />
           <ww:param name="value" value="directory.name" />
           <ww:param name="description" value=""/>
        </ww:component>
    </div>

    <div class="formFooter wizardFooter">

        <div class="buttons">

            <form method="post" action="<ww:url namespace="/console/secure/group" action="remove" method="update" includeParams="none" />">

                <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                <input type="hidden" name="name" value="<ww:property value="name" />"/>

                <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                       onClick="window.location='<ww:url namespace="/console/secure/group" action="view" method="default" includeParams="none" ><ww:param name="directoryID" value="directoryID" /><ww:param name="name" value="name" /></ww:url>';"/>

            </form>
        </div>

    </div>


</div>

</body>
</html>