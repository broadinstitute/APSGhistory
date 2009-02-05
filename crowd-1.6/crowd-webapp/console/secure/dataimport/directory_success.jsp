<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="dataimport.importdirectory.title"/>
    </title>
    <meta name="section" content="dataimport"/>
    <meta name="help.url" content="<ww:property value="getText('help.user.import.directory.results')"/>"/>
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
            <span class="tab">2.&nbsp;<ww:text name="dataimport.options.label"/></span>
        </li>

        <li>
            <span class="tab">3.&nbsp;<ww:text name="dataimport.directory.confirmation.label"/></span>
        </li>

        <li class="on">
            <span class="tab">4.&nbsp;<ww:text name="dataimport.result.label"/></span>
        </li>
    </ol>

    <div class="tabContent static">

        <div class="crowdForm">
            <div class="titleSection">
                <ww:text name="dataimport.atlassianimportsuccess.text"/>
            </div>

            <div class="formBody">
                <ww:component template="form_messages.jsp"/>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('dataimport.importusercount.label')"/>
                    <ww:param name="value">
                        <ww:property value="result.usersImported"/>
                    </ww:param>
                </ww:component>

                <ww:if test="result.usersAlreadyExist != null && result.usersAlreadyExist.size > 0">
                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('dataimport.importusersalreadyexist.label')"/>
                        <ww:param name="value">
                        <ww:iterator value="result.usersAlreadyExist" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                        </ww:param>
                    </ww:component>
                </ww:if>

                <ww:if test="result.usersFailedImport != null && result.usersFailedImport.size > 0">
                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('dataimport.importusersfailed.label')"/>
                        <ww:param name="value">
                        <ww:iterator value="result.usersFailedImport" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                        </ww:param>
                    </ww:component>
                </ww:if>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('dataimport.importgroupcount.label')"/>
                    <ww:param name="value">
                        <ww:property value="result.groupsImported"/>
                    </ww:param>
                </ww:component>

                <ww:if test="result.groupsAlreadyExist != null && result.groupsAlreadyExist.size > 0">
                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('dataimport.importgroupsalreadyexist.label')"/>
                        <ww:param name="value">
                        <ww:iterator value="result.groupsAlreadyExist" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                        </ww:param>
                    </ww:component>
                </ww:if>

                <ww:if test="result.groupsFailedImport != null && result.groupsFailedImport.size > 0">
                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('dataimport.importgroupsfailed.label')"/>
                        <ww:param name="value">
                        <ww:iterator value="result.groupsFailedImport" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                        </ww:param>
                    </ww:component>
                </ww:if>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('dataimport.importgroupmemberships.label')"/>
                    <ww:param name="value">
                        <ww:property value="result.groupMembershipsImported"/>
                    </ww:param>
                </ww:component>

                <ww:if test="result.groupMembershipsFailedImport != null && result.groupMembershipsFailedImport.size > 0">
                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('dataimport.importgroupmembershipfailed.label')"/>
                        <ww:param name="value">
                        <ww:iterator value="groupMembershipsFailedImport" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                        </ww:param>
                    </ww:component>
                </ww:if>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('dataimport.importrolecount.label')"/>
                    <ww:param name="value">
                        <ww:property value="result.rolesImported"/>
                    </ww:param>
                </ww:component>

                <ww:if test="result.rolesAlreadyExist != null && result.rolesAlreadyExist.size > 0">
                    <ww:component template="form_row.jsp">
                        <ww:param name="label" value="getText('dataimport.importrolesalreadyexist.label')"/>
                        <ww:param name="value">
                        <ww:iterator value="result.rolesAlreadyExist" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                        </ww:param>
                    </ww:component>
                </ww:if>


                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('dataimport.importrolememberships.label')"/>
                    <ww:param name="value">
                        <ww:property value="result.roleMembershipsImported"/>
                    </ww:param>
                </ww:component>

                <ww:if test="result.roleMembershipsFailedImport != null && result.roleMembershipsFailedImport.size > 0">
                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('dataimport.importrolemembershipfailed.label')"/>
                    <ww:param name="value">
                        <ww:iterator value="result.roleMembershipsFailedImport" status="rowstatus">
                            <ww:property/><ww:if test="!#rowstatus.last">,</ww:if>
                        </ww:iterator>
                    </ww:param>
                </ww:component>
                </ww:if>
            </div>
        </div>

    </div>
</div>
</body>
</html>