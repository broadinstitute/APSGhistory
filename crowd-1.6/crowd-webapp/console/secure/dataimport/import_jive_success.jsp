<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:property value="getText('directory.importjive.title')"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.jive.results')"/>"/>
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

            <li>
                    <span class="tab">
                        2. <ww:property value="getText('dataimport.options.label')"/>
                    </span>
            </li>

            <li class="on">
                    <span class="tab">
                        3. <ww:property value="getText('dataimport.result.label')"/>
                    </span>
            </li>

        </ul>



        <div class="tabContent static">

            <div class="crowdForm">
                <div class="formBody">
                    <ww:component template="form_messages.jsp"/>

                    <p>
                        <ww:property value="getText('directory.importjivesuccess.text')"/>
                    </p>

                    <ww:component template="form_row.jsp">
                       <ww:param name="label" value="getText('directory.importusercount.label')" />
                        <ww:param name="value">
                                <ww:property value="userImportCount"/>
                        </ww:param>
                    </ww:component>

                    <ww:component template="form_row.jsp">
                       <ww:param name="label" value="getText('directory.importgroupcount.label')" />
                        <ww:param name="value">
                                <ww:property value="groupImportCount"/>
                        </ww:param>
                    </ww:component>
                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">

                        <input style="width: 100px;" type="button" value="<ww:property value="getText('menu.principal.label')"/> &raquo;"
                               onclick="window.location='<ww:url namespace="/console/secure/user" action="browse" includeParams="none" ><ww:param name="directoryID" value="directoryID" /></ww:url>';"/>

                    </div>
                </div>

            </div>

        </div>
    </div>
</body>
</html>