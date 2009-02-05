<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.addapplication.label')"/>
    </title>
    <meta name="section" content="applications"/>
    <meta name="pagename" content="add"/>
    <meta name="help.url" content="<ww:property value="getText('help.application.add')"/>"/>

    <script type="text/javascript">
        function addGroupToDirectory(selectListID)
        {
            if (selectListID != null)
            {
                var form = document.addgrouptodirectory;
                form.directoryGroup.value = document.getElementById(selectListID).value;
                form.submit();
            }
        }

        function hideShowGroupSelection(directoryID)
        {
            var groupselectionelement = document.getElementById("groupselection-" + directoryID);

            var groupselectioncheckbox = document.getElementById("<ww:property
                            value="@com.atlassian.crowd.console.action.application.AddApplicationAuthorisationDetails@ALLOW_ALL_TO_AUTHENTICATE_FOR_DIRECTORY"/>"+directoryID);
            if (groupselectioncheckbox.checked)
            {
                groupselectionelement.style.display = 'none';
            }
            else
            {
                groupselectionelement.style.display = 'block';
            }
        }

        function hideShowAllGroupSelection()
        {
            var directoryIds = [<ww:iterator value="configuration.directoryids" status="#status"><ww:property/>,</ww:iterator>];

            for (var i = 0; i < directoryIds.length; i++)
            {
                var directoryid = directoryIds[i];
                hideShowGroupSelection(directoryid);
            }
        }

    </script>


</head>
<body onload="hideShowAllGroupSelection();">

<h2>
    <ww:property value="getText('menu.addapplication.label')"/> - <ww:property value="name"/>
</h2>

<div class="page-content">

    <ul class="tabs">
        <li id="hreftab1">
            <a href="<ww:url action="addapplicationdetails" namespace="/console/secure/application" includeParams="none"/>">1. <ww:property
                    value="getText('menu.details.label')"/></a>
        </li>

        <li id="hreftab2">
            <a href="<ww:url action="addapplicationconnectiondetails" namespace="/console/secure/application" includeParams="none"/>">2. <ww:property
                    value="getText('menu.connection.label')"/></a>
        </li>

        <li id="hreftab3">
            <a href="<ww:url action="addapplicationdirectorydetails" namespace="/console/secure/application" includeParams="none"/>">3. <ww:property
                    value="getText('menu.directory.label')"/></a>
        </li>

        <li class="on" id="hreftab4">
            <span class="tab">4. <ww:property value="getText('menu.authorisation.label')"/></span>
        </li>

        <li id="hreftab5">
            <span class="tab">5. <ww:property value="getText('menu.confirmation.label')"/></span>
        </li>
    </ul>

    <div class="crowdForm">

        <form method="post"
              action="<ww:url namespace="/console/secure/application" action="addapplicationauthorisationdetails" method="completeStep" includeParams="none"/>">

            <div class="formBodyNoTop">

                <div class="descriptionSection"><ww:text name="application.authorisation.description"><ww:param id="0">'<ww:property value="configuration.name"/>'</ww:param></ww:text></div>

                <ww:component template="form_messages.jsp"/>

                <ww:iterator value="directories">

                <ww:set name="directoryID" value="ID"/>

                <div class="sectionSubTitle"><ww:text name="directory.label"/>&nbsp;&ndash;&nbsp;<ww:property value="name"/></div>

                <div class="fieldArea required">
                    <label class="fieldLabelArea" for="<ww:property value="@com.atlassian.crowd.console.action.application.AddApplicationAuthorisationDetails@ALLOW_ALL_TO_AUTHENTICATE_FOR_DIRECTORY"/><ww:property value="#directoryID"/>">
                        <ww:text name="application.authorisation.allow.all.label"/>:
                    </label>
                    <div class="fieldValueArea">
                        <input name="<ww:property value="@com.atlassian.crowd.console.action.application.AddApplicationAuthorisationDetails@ALLOW_ALL_TO_AUTHENTICATE_FOR_DIRECTORY"/><ww:property value="#directoryID"/>"
                               id="<ww:property value="@com.atlassian.crowd.console.action.application.AddApplicationAuthorisationDetails@ALLOW_ALL_TO_AUTHENTICATE_FOR_DIRECTORY"/><ww:property value="#directoryID"/>"
                               value="true"
                               onclick="hideShowGroupSelection(<ww:property value="#directoryID"/>);"
                               type="checkbox"
                               <ww:if test="isAllowAllForDirectory(#directoryID)">checked</ww:if>
                                >
                        <div class="fieldDescription"><ww:text name="application.authorisation.allow.all.description"><ww:param id="0">'<ww:property
                            value="configuration.name"/>'</ww:param></ww:text></div>
                    </div>
                </div>

                <div id="groupselection-<ww:property value="#directoryID"/>">
                    <ww:set name="selectedgroups" value="getSelectedGroupsForDirectory(#directoryID)"/>
                    <ww:if test="!#selectedgroups.empty">
                        <div class="fieldArea">
                            <label class="fieldLabelArea"><ww:text name="application.groups.authorised.label"/>:</label>

                            <div class="fieldValueArea">
                                    <span id="subscribed-group-<ww:property value="#directoryID"/>">
                                        <ww:iterator value="#selectedgroups" status="status">
                                            <a href="<ww:url namespace="/console/secure/application" action="addapplicationauthorisationdetails" method="removeGroup" includeParams="none"><ww:param name="groupName"><ww:property/></ww:param><ww:param name="directoryID" value="#directoryID"/></ww:url>"
                                               title="Remove Group: <ww:property/>"><ww:property/></a><ww:if test="!#status.last">,&nbsp;</ww:if>
                                        </ww:iterator>
                                    </span>
                            </div>
                        </div>
                    </ww:if>

                    <ww:set name="unsubscribedgroups" value="getUnsubscribedGroupsForDirectory(#directoryID)"/>
                    <ww:if test="!#unsubscribedgroups.empty">
                        <div class="fieldArea required">
                            <label class="fieldLabelArea" for="addgrouptodirectory-<ww:property value="#directoryID"/>"><ww:text
                                    name="application.groups.label"/>:</label>

                            <div class="fieldValueArea">
                                <select id="addgrouptodirectory-<ww:property value="#directoryID"/>"
                                        name="addgrouptodirectory-<ww:property value="#directoryID"/>">
                                    <option><ww:text name="selectdirectory.label"/></option>
                                    <ww:iterator value="getUnsubscribedGroupsForDirectory(#directoryID)">
                                        <option value="<ww:property value="#directoryID"/>-<ww:property />"><ww:property/></option>
                                    </ww:iterator>
                                </select>
                                <span id="add-group" style="margin-left:20px"><input id="add-group-<ww:property value="#directoryID"/>" type="button" name="add-group" value="Add Group"
                                                                                     onclick="addGroupToDirectory('addgrouptodirectory-<ww:property value="#directoryID"/>');"></span>
                            </div>
                        </div>
                    </ww:if>
                </div>
                </ww:iterator>

            </div>

            <div class="formFooter wizardFooter">

                <div class="buttons">

                    <input type="submit" class="button" value="<ww:property value="getText('next.label')"/> &raquo;"/>
                    <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                           onClick="window.location='<ww:url namespace="/console/secure/application" action="addapplicationdetails" method="cancel" />';"/>

                </div>

            </div>

        </form>

        <form name="addgrouptodirectory" method="post"
              action="<ww:url namespace="/console/secure/application" action="addapplicationauthorisationdetails" method="addGroupToDirectory" includeParams="none"/>">
            <input type="hidden" name="directoryGroup"/>
        </form>


    </div>
</div>

</body>
</html>