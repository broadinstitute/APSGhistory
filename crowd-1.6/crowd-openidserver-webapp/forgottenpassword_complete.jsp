<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('forgottenpassword.title')"/>
    </title>
</head>

<body>

<div class="crowdForm">

    <h2>
        <ww:property value="getText('forgottenpassword.title')"/>
    </h2>

    <div class="formBodyNoTop">

        <ww:include value="/include/generic_errors.jsp"/>

        <ww:property value="getText('forgottenpassword.complete.label')"/>

    </div>

</div>

</body>
</html>