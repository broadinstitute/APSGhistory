<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('administration.export.title')"/>
    </title>
    <meta name="section" content="administration"/>
</head>

<body>

<h2>
    <ww:property value="getText('administration.export.title')"/>
</h2>

<div class="tabContent create">

    <div class="crowdForm">

        <ww:component template="form_messages.jsp"/>

        <p>
            <ww:property value="getText('administration.export..success.text')"/>
        </p>

    </div>
</div>
</body>
</html>