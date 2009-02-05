<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('administration.title')"/>
    </title>
    <meta name="section" content="administration"/>
</head>

<body>

<div id="adminMenu">
    <div class="webMenu">
        <div class="webMenuSection">
            <ul>
                <h2 style="background-image: url(../../images/icons/icon_computer.gif)">System</h2>
                <li><a id="export" href="/crowd/console/secure/admin/export!default.action">Export</a></li>
                <li><a id="import" href="/crowd/console/secure/admin/import!default.action">Import</a></li>
            </ul>
        </div>
    </div>
</div>


</body>
</html>