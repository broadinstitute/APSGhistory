<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('setup.title')"/>
    </title>
</head>

<body>
        <ww:component template="form_messages.jsp"/>
        <ww:text name="setup.alreadysetup">
            <ww:param id="0"><a href="<ww:url value="/console" includeParams="none"/>"></ww:param>
            <ww:param id="1"></a></ww:param>
        </ww:text>
</body>
</html>