<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('console.title')"/></title>
        <meta name="section" content="home" />
    </head>

    <body>
            <h2><ww:property value="getText('console.title')"/></h2>

            <div class="page-content">
                <p><ww:property value="getText('console.text')"/></p>
            </div>
    </body>
</html>