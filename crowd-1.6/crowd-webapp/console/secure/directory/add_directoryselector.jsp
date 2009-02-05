<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="directory.selector.title"/>
    </title>

    <meta name="section" content="directories"/>
    <meta name="pagename" content="addselector"/>
    <meta name="help.url" content="<ww:property value="getText('help.directory.add')"/>"/>    
</head>

<body>
    <h2>
        <ww:text name="directory.selector.title"/>
    </h2>

<div class="crowdForm">


    <div class="formBody">

        <p><ww:text name="directory.internal.text"/></p>

        <!-- The below form is present so the following links work in JWebUnit -->
        <form>
        <p style="text-align: right;">
            <input id="create-internal" style="width: 160px;" type="button"
                   value="<ww:text name="directory.internal.label"/> &raquo;"
                   onclick="window.location='<ww:url namespace="/console/secure/directory" action="createinternal" includeParams="none"/>';"/>
        </p>

        <p><ww:text name="directory.delegating.text"/></p>

        <p style="text-align: right;">
            <input id="create-delegating" style="width: 160px;" type="button"
                   value="<ww:text name="directory.delegating.label"/> &raquo;"
                   onclick="window.location='<ww:url namespace="/console/secure/directory" action="createdelegated" includeParams="none"/>';"/>
        </p>

        <p><ww:text name="directory.connector.text"/></p>

        <p style="text-align: right;">
            <input id="create-connector" style="width: 160px;" type="button"
                   value="<ww:text name="directory.connector.label"/> &raquo;"
                   onclick="window.location='<ww:url namespace="/console/secure/directory" action="createconnector" includeParams="none" />';"/>
        </p>

        <p><ww:property value="getText('directory.custom.text')"/></p>

        <p style="text-align: right;">
            <input id="create-custom" style="width: 160px" type="button"
                   value="<ww:text name="directory.custom.label"/> &raquo;"
                   onclick="window.location='<ww:url namespace="/console/secure/directory" action="createcustom" includeParams="none" />';"/>
        </p>
        </form>

    </div>

</div>


</body>
</html>