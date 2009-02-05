<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('application.remove.title')"/>
    </title>
    <meta name="section" content="applications"/>
    <meta name="pagename" content="remove"/>
    <meta name="help.url" content="<ww:property value="getText('help.application.remove')"/>"/>        
</head>
<body>

<h2>
    <ww:property value="getText('application.remove.title')"/>
    &nbsp;&ndash;&nbsp;
    <ww:property value="name"/>
</h2>

<div class="crowdForm">

    <div class="formBody">
        <ww:component template="form_messages.jsp"/>

        <p class="warningBox">
            <ww:text name="application.remove.text">
                <ww:param id="0"><ww:property value="application.name"/></ww:param>
            </ww:text>
        </p>

        

    </div>
    <div class="formFooter wizardFooter">

        <div class="buttons">

            <form method="post"
                  action="<ww:url namespace="/console/secure/application" action="remove" method="update" />">

                <input type="hidden" name="ID" value="<ww:property value="ID" />"/>

                <input type="submit" class="button" value="<ww:property value="getText('remove.label')"/> &raquo;"/>
                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                       onClick="window.location='<ww:url namespace="/console/secure/application" action="view" method="default" ><ww:param name="ID" value="ID"/></ww:url>';"/>

            </form>
        </div>

    </div>

</div>

</body>
</html>