<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('administration.import.title')"/>
    </title>
    <meta name="section" content="administration"/>
</head>

<body>

<h2>
    <ww:property value="getText('administration.import.title')"/>
</h2>

<div class="tabContent create">

    <div class="crowdForm">

        <ww:component template="form_messages.jsp"/>

        <p>
            <ww:property value="getText('administration.import.text')"/>
        </p>

        <form method="post" action="<ww:url namespace="/console/secure/admin" action="import" method="execute" includeParams="none" />">

            <ww:textfield name="filePath" size="50">
                <ww:param name="label" value="getText('administration.import.filepath.label')"/>
            </ww:textfield>

            <div class="formFooter wizardFooter">

                <div class="buttons">


                    <input type="submit" class="button" value="<ww:property value="getText('submit.label')"/> &raquo;"/>


                </div>
            </div>

        </form>
    </div>
</div>
</body>
</html>