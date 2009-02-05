<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="dataimport.importdirectory.title"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.directory.confirm')"/>"/>    
</head>
<body>

<h2>
    <ww:text name="dataimport.importdirectory.title"/>
</h2>

<div class="page-content">

    <ol class="tabs">

        <li>
            <span class="tab">1.&nbsp;<ww:text name="dataimport.type.label"/></span>
        </li>

        <li>
            <a href="<ww:url namespace="/console/secure/dataimport" action="importdirectory" includeParams="none"/>">2.&nbsp;<ww:text name="dataimport.options.label"/></a>
        </li>

        <li class="on">
            <span class="tab">3.&nbsp;<ww:text name="dataimport.directory.confirmation.label"/></span>
        </li>

        <li>
            <span class="tab">4.&nbsp;<ww:text name="dataimport.result.label"/></span>
        </li>
    </ol>

    <div class="tabContent static">

        <form name="dataimport" method="post" action="<ww:url namespace="/console/secure/dataimport" action="directoryconfirmation" method="doExecute" includeParams="none"/>">
            <div class="crowdForm">
                <div class="titleSection">
                    <ww:text name="dataimport.directory.confirmation.text"/>
                </div>

                <div class="formBody">

                    <ww:component template="form_messages.jsp"/>

                    <p>
                        <ww:text name="dataimport.directory.source.confirmation.directory.text">
                            <ww:param id="0" value="sourceDirectoryName"/>
                        </ww:text>
                    </p>

                    <p>
                        <ww:text name="dataimport.directory.target.confirmation.directory.text">
                            <ww:param id="0" value="targetDirectoryName"/>
                        </ww:text>
                    </p>

                    <p>
                        <ww:text name="dataimport.directory.overwrite.confirmation.directory.text">
                            <ww:param id="0" value="overwriteDirectory"/>
                        </ww:text>
                    </p>


                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">
                        <input type="submit" class="button" value="<ww:text name="continue.label"/> &raquo;"/>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
</body>
</html>