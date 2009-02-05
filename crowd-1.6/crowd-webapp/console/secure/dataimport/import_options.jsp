<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="dataimport.title"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="pagename" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import')"/>"/>
</head>

<body>

<h2>
    <ww:text name="dataimport.title"/>
</h2>

<div class="page-content">

    <ol class="tabs">

        <li class="on">
            <span class="tab">1. <ww:text name="dataimport.type.label"/></span>
        </li>

        <li>
            <span class="tab">2. <ww:text name="dataimport.options.label"/></span>
        </li>

        <li>
            <span class="tab">3. <ww:text name="dataimport.result.label"/></span>
        </li>

    </ol>

    <div class="tabContent static">

        <div class="crowdForm">

            <div class="titleSection">
                <ww:text name="dataimport.text"/>
            </div>

            <div class="formBody">
                <form>
                <p><ww:text name="dataimport.atlassian.text"/></p>

                <p style="text-align: right;">
                    <input id="importatlassian" style="width: 150px;" type="button"
                           value="<ww:property value="getText('dataimport.atlassian.label')"/> &raquo;"
                           onclick="window.location='<ww:url namespace="/console/secure/dataimport" action="importatlassian" method="default" ><ww:param name="directoryID" value="directoryID" /></ww:url>';"/>
                </p>

                <p><ww:text name="dataimport.directory.text"/></p>

                <p style="text-align: right;">
                    <input id="importdirectory" style="width: 150px;" type="button"
                           value="<ww:property value="getText('dataimport.directory.label')"/> &raquo;"
                           onclick="window.location='<ww:url namespace="/console/secure/dataimport" action="importdirectory" />';"/>
                </p>

                <p><ww:text name="dataimport.csv.text"/></p>

                <p style="text-align: right;">
                    <input id="importcsv" style="width: 150px;" type="button"
                           value="<ww:property value="getText('dataimport.csv.label')"/> &raquo;"
                           onclick="window.location='<ww:url namespace="/console/secure/dataimport" action="importcsv" method="default"><ww:param name="directoryID" value="directoryID" /></ww:url>';"/>
                </p>

                <p><ww:text name="dataimport.jive.text"/></p>

                <p style="text-align: right;">
                    <input id="importjive" style="width: 150px;" type="button"
                           value="<ww:property value="getText('dataimport.jive.label')"/> &raquo;"
                           onclick="window.location='<ww:url namespace="/console/secure/dataimport" action="importjive" method="default" ><ww:param name="directoryID" value="directoryID" /></ww:url>';"/>
                </p>
                </form>
            </div>

        </div>
    </div>
</div>
</body>
</html>