<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('directory.importjive.title')"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.jive')"/>"/>
</head>
<body>
    <h2>
        <ww:property value="getText('directory.importjive.title')"/>
    </h2>

    <div class="page-content">

        <ul class="tabs">

            <li>
                    <span class="tab">
                        1. <ww:property value="getText('dataimport.type.label')"/>
                    </span>

            </li>

            <li class="on">
                    <span class="tab">
                        2. <ww:property value="getText('dataimport.options.label')"/>
                    </span>
            </li>

            <li>
                    <span class="tab">
                        3. <ww:property value="getText('dataimport.result.label')"/>
                    </span>
            </li>

        </ul>

        <div class="tabContent static">

            <div class="crowdForm">

                <form method="post" action="<ww:url namespace="/console/secure/dataimport" action="importjive" method="update" includeParams="none" />">

                    <div class="formBody">

                        <ww:component template="form_messages.jsp"/>

                        <p>
                            <ww:property value="getText('directory.importjive.text')"/>
                        </p>



                        <ww:select name="directoryID" list="directories" listKey="ID" listValue="name">
                            <ww:param name="label" value="getText('dataimport.importdirectory.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('dataimport.importdirectory.description')"/>
                            </ww:param>
                        </ww:select>

                        <ww:textfield name="url" size="50">
                            <ww:param name="label" value="getText('directory.importjivedburl.label')"/>
                        </ww:textfield>

                        <ww:textfield name="driver" size="50">
                            <ww:param name="label" value="getText('directory.importjivedriver.label')"/>
                        </ww:textfield>

                        <ww:textfield name="username">
                            <ww:param name="label" value="getText('directory.importjivedbusername.label')"/>
                        </ww:textfield>

                        <ww:password name="password">
                            <ww:param name="label" value="getText('directory.importjivedbpassword.label')"/>
                        </ww:password>
                    </div>
                    <div class="formFooter wizardFooter">

                        <div class="buttons">


                            <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>

                            <ww:if test="directory.type.code == 1">
                                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                       onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewinternal" method="default" includeParams="none" ><ww:param name="ID" value="directoryID" /></ww:url>';"/>
                            </ww:if>
                            <ww:elseif test="directory.type.code == 2">
                                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                       onClick="window.location='<ww:url namespace="/console/secure/directory" action="viewconnector" method="default" includeParams="none" ><ww:param name="ID" value="directoryID" /></ww:url>';"/>
                            </ww:elseif>
                            <ww:else>
                                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                       onClick="history.back()"/>
                            </ww:else>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>
</body>
</html>