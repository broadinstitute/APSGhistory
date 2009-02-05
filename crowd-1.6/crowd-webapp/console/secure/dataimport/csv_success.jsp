<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="dataimport.csv.title"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.csv.results')"/>"/>    
</head>
<body>

<h2>
    <ww:text name="dataimport.csv.title"/>
</h2>

<div class="page-content">
    <ol class="tabs">

        <li>
            <span class="tab">1.&nbsp;<ww:text name="dataimport.csv.configuration.label"/></span>
        </li>
        <li>
            <span class="tab">2.&nbsp;<ww:text name="dataimport.csv.mapping.label"/></span>
        </li>
        <li>
            <span class="tab">3.&nbsp;<ww:text name="dataimport.csv.confirmation.label"/></span>
        </li>
        <li class="on">
            <span class="tab">4.&nbsp;<ww:text name="dataimport.result.label"/></span>
        </li>
    </ol>

    <div class="tabContent static">

        <div class="crowdForm">
            <div class="titleSection">
                <ww:text name="dataimport.csv.result.text"/>
            </div>

            <div class="formBody">
                <ww:component template="form_messages.jsp"/>


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

                <p id="membersips-imported"><ww:text name="dataimport.importgroupmemberships.label"/>:&nbsp;<ww:property value="result.groupMembershipsImported"/></p>

                <ww:if test="result.membershipsFailedImport != null && result.membershipsFailedImport.size > 0">

                <p id="memberships-failed-import"><ww:text name="dataimport.importgroupmembershipfailed.label"/>:&nbsp;
                        <ww:iterator value="result.membershipsFailedImport" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                </p>
                </ww:if>
            </div>
        </div>

    </div>
</div>
</body>
</html>
