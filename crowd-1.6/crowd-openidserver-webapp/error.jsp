<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('error.title')"/>
    </title>
</head>

<body>
    <h2>
        <ww:property value="getText('error.title')"/>
    </h2>

    <p>
        <ww:property value="getText('error.text')"/>
    </p>

        <ww:iterator value="actionErrors">
            <p class="error">
                <ww:property />
                <br/>
            </p>
        </ww:iterator>
</body>
</html>