<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="dataimport.importatlassian.title"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:text name="help.user.import.atlassian.results"/>"/>
</head>
<body>
<h2>
    <ww:text name="dataimport.importatlassian.title"/>
</h2>

<div class="page-content">
    <ul class="tabs">

        <li>
            <span class="tab">1.&nbsp;<ww:text name="dataimport.type.label"/></span>
        </li>

        <li>
            <span class="tab">2.&nbsp;<ww:text name="dataimport.options.label"/></span>
        </li>

        <li class="on">
            <span class="tab">3.&nbsp;<ww:text name="dataimport.result.label"/></span>
        </li>

    </ul>


    <div class="tabContent static">

        <div class="crowdForm">

            <div class="formBody">
                <ww:component template="form_messages.jsp"/>

                <p>
                    <ww:text name="dataimport.atlassianimportsuccess.text"/>
                </p>

                <p id="users-imported"><ww:text name="dataimport.importusercount.label"/>:&nbsp;<ww:property value="result.usersImported"/></p>


                <ww:if test="result.usersAlreadyExist != null && result.usersAlreadyExist.size > 0">
                    <p id="users-already-exist">
                        <ww:text name="dataimport.importusersalreadyexist.label"/>:&nbsp;
                        <ww:iterator value="result.usersAlreadyExist" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                    </p>
                </ww:if>

                <ww:if test="result.usersFailedImport != null && result.usersFailedImport.size > 0">
                    <p id="users-failed-import"><ww:text name="dataimport.importusersfailed.label"/>:&nbsp;
                        <ww:iterator value="result.usersFailedImport" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                    </p>
                </ww:if>

                <p id="groups-imported"><ww:text name="dataimport.importgroupcount.label"/>:&nbsp;<ww:property value="result.groupsImported"/></p>

                <ww:if test="result.groupsAlreadyExist != null && result.groupsAlreadyExist.size > 0">
                    <p id="groups-already-exist"><ww:text name="dataimport.importgroupsalreadyexist.label"/>:&nbsp;
                        <ww:iterator value="result.groupsAlreadyExist" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                    </p>
                </ww:if>

                <ww:if test="result.groupsFailedImport != null && result.groupsFailedImport.size > 0">
                    <p id="groups-failed-import"><ww:text name="dataimport.importgroupsfailed.label"/>:&nbsp;
                        <ww:iterator value="result.groupsFailedImport" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                    </p>
                </ww:if>

                <p id="membersips-imported"><ww:text name="dataimport.importgroupmemberships.label"/>:&nbsp;<ww:property
                        value="result.groupMembershipsImported"/></p>

                <ww:if test="result.membershipsFailedImport != null && result.membershipsFailedImport.size > 0">

                    <p id="memberships-failed-import"><ww:text name="dataimport.importgroupmembershipfailed.label"/>:&nbsp;
                        <ww:iterator value="result.membershipsFailedImport" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                    </p>
                </ww:if>
            </div>

        </div>

        <div class="formFooter wizardFooter">

            <div class="buttons">

                <input style="width: 100px;" type="button" value="<ww:text name="menu.principal.label"/> &raquo;"
                       onclick="window.location='<ww:url namespace="/console/secure/user" action="browse" includeParams="none" ><ww:param name="directoryID" value="directoryID" /></ww:url>';"/>

            </div>
        </div>

    </div>
</div>
</body>
</html>
