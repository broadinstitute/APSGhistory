<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="dataimport.importdirectory.title"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.directory.options')"/>"/>
</head>
<body>

<h2>
    <ww:text name="dataimport.importdirectory.title"/>
</h2>

<div class="page-content">

    <ol class="tabs">

        <li>
            <a href='<ww:url action="importtype" namespace="/console/secure/dataimport" includeParams="none"/>'>
            1.&nbsp;<ww:text name="dataimport.type.label"/>
            </a>
        </li>

        <li class="on">
            <span class="tab">2.&nbsp;<ww:text name="dataimport.options.label"/></span>
        </li>

        <li>
            <span class="tab">3.&nbsp;<ww:text name="dataimport.directory.confirmation.label"/></span>
        </li>

        <li>
            <span class="tab">4.&nbsp;<ww:text name="dataimport.result.label"/></span>
        </li>

    </ol>

    <div class="tabContent static">

        <div class="crowdForm">
            <div class="titleSection">
                <ww:text name="dataimport.importdirectory.text"/>
            </div>

            <form name="dataimport" method="post"
                  action="<ww:url namespace="/console/secure/dataimport" action="importdirectory" method="import" includeParams="none"/>">

                <div class="formBody">
                    <ww:component template="form_messages.jsp"/>

                    <ww:select name="sourceDirectoryID" list="directories" listKey="ID" listValue="name">
                        <ww:param name="label" value="getText('dataimport.directory.sourcedirectory.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('dataimport.directory.sourcedirectory.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:select>

                    <ww:select name="targetDirectoryID" list="directories" listKey="ID" listValue="name">
                        <ww:param name="label" value="getText('dataimport.directory.targetdirectory.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('dataimport.directory.targetdirectory.description')"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:select>

                    <ww:checkbox name="overwriteTarget" value="overwriteTarget" fieldValue="true" >
                        <ww:param name="label" value="getText('dataimport.directory.overwritetarget.label')"/>
                        <ww:param name="description">
                            <ww:property value="getText('dataimport.directory.overwritetarget.description')"/>
                        </ww:param>
                    </ww:checkbox>

                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">
                        <input type="submit" class="button"
                               value="<ww:text name="continue.label"/> &raquo;"/>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>
</body>
</html>