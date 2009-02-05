<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('menu.viewprincipal.label')"/>
    </title>
    <meta name="section" content="principals"/>
</head>
<body onload="init();">

    <jsp:include page="../../decorator/javascript_tabs.jsp">
        <jsp:param name="totalTabs" value="4"/>
    </jsp:include>

    <script language="javascript">

        function addGroup()
        {
            var form = document.groupsForm;
            form.action = '<ww:url namespace="/secure/principal" action="updateprincipal" method="addGroup" includeParams="none" />';
            form.submit();
        }

        function addRole()
        {
            var form = document.rolesForm;
            form.action = '<ww:url namespace="/secure/principal" action="updateprincipal" method="addRole" includeParams="none"/>';
            form.submit();
        }

        function addAttribute()
        {
            var form = document.attributesForm;
            form.action = '<ww:url namespace="/secure/principal" action="updateprincipal" method="addAttribute" includeParams="none" />';
            form.submit();
        }

    </script>

    <p class="headingInfo">
        <a href="<ww:url namespace="/secure/principal" action="addprincipal" method="default" includeParams="none"/>">
            <ww:property value="getText('menu.addprincipal.label')"/>
        </a>
        &nbsp; | &nbsp;
        <a href="<ww:url namespace="/secure/principal" action="removeprincipal" method="default" includeParams="none" ><ww:param name="directoryID" value="directoryID" /><ww:param name="name" value="name" /></ww:url>">
            <ww:property value="getText('menu.removeprincipal.label')"/>
        </a>
    </p>

    <h2>
        <ww:property value="getText('menu.viewprincipal.label')"/>
        &nbsp;&ndash;&nbsp;
        <ww:property value="name"/>
    </h2>

    <div class="page-content">

        <ul class="tabs">
            <li class="on" id="hreftab1">
                <a href="javascript:processTabs(1);">
                    <ww:property value="getText('menu.details.label')"/>
                </a>
            </li>

            <li id="hreftab2">
                <a href="javascript:processTabs(2);">
                    <ww:property value="getText('menu.attributes.label')"/>
                </a>
            </li>

            <li id="hreftab3">
                <a href="javascript:processTabs(3);">
                    <ww:property value="getText('menu.group.label')"/>
                </a>
            </li>


            <li id="hreftab4">
                <a href="javascript:processTabs(4);">
                    <ww:property value="getText('menu.role.label')"/>
                </a>
            </li>

        </ul>

        <div class="tabContent" id="tab1">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/secure/principal" action="updateprincipal" method="updateGeneral" includeParams="none" />">
                    <div class="formBody">

                        <ww:include value="/include/generic_errors.jsp"/>

                        <input type="hidden" name="tab" value="1"/>
                        <input type="hidden" name="name" value="<ww:property value="name" />"/>

                        <ww:include value="/include/generic_form_row.jsp">
                           <ww:param name="label" value="getText('principal.name.label')" />
                            <ww:param name="value">
                                    <ww:property value="name"/>
                            </ww:param>
                        </ww:include>

                        <ww:textfield name="email" size="50">
                            <ww:param name="label" value="getText('principal.email.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('principal.email.description')"/>
                            </ww:param>
                        </ww:textfield>

                        <ww:checkbox name="active" fieldValue="true">
                            <ww:param name="label" value="getText('principal.active.label')"/>
                        </ww:checkbox>

                        <ww:textfield name="firstname">
                            <ww:param name="label" value="getText('principal.firstname.label')"/>
                        </ww:textfield>

                        <ww:textfield name="lastname">
                            <ww:param name="label" value="getText('principal.lastname.label')"/>
                        </ww:textfield>

                        <ww:password name="password">
                            <ww:param name="label" value="getText('password.label')"/>
                            <ww:param name="description">
                                <ww:property value="getText('principal.editpassword.description')"/>
                            </ww:param>
                        </ww:password>

                        <ww:password name="passwordConfirm">
                            <ww:param name="label" value="getText('principal.passwordconfirm.label')"/>
                        </ww:password>
                    </div>

                    <div class="formFooter wizardFooter">
                        <div class="buttons">
                            <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/secure/principal" action="viewprincipal" method="default" includeParams="none"><ww:param name="directoryID" value="directoryID"/><ww:param name="name" value="name"/><ww:param name="tab" value="1"/></ww:url>';"/>
                        </div>
                    </div>

                </form>

            </div>

        </div>

        <div class="tabContent" id="tab2">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/secure/principal" action="updateprincipal" method="updateAttributes" includeParams="none" />" name="attributesForm">
                    <div class="formBody">

                        <ww:include value="/include/generic_errors.jsp"/>

                        <input type="hidden" name="tab" value="2"/>
                        <input type="hidden" name="name" value="<ww:property value="name" />"/>

                        <table id="attributesTable" class="formTable">
                            <tr>
                                <th width="40%">
                                    <ww:property value="getText('attribute.label')"/>
                                </th>
                                <th width="40%">
                                    <ww:property value="getText('values.label')"/>
                                </th>
                                <th width="20%">
                                    <ww:property value="getText('browser.action.label')"/>
                                </th>
                            </tr>

                            <ww:iterator value="principal.attributes" status="rowstatus">

                                <input type="hidden" name="attributes" value="<ww:property value="name" />"/>

                                <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                                <ww:else><tr class="even"></ww:else>
                                <td>
                                    <ww:property value="name"/>
                                </td>
                                <td>
                                    <ww:iterator value="values" status="valuestatus">
                                        <input type="text" name="<ww:property value="name" /><ww:property value="#valuestatus.count" />" value="<ww:property />" size="30"/><br/>
                                    </ww:iterator>
                                </td>
                                <td>
                                    <a href="<ww:url namespace="/secure/principal" action="updateprincipal" method="removeAttribute" includeParams="none" ><ww:param name="name" value="[1].name" /><ww:param name="attribute" value="name" /><ww:param name="tab" value="2"/></ww:url>"
                                       title="<ww:property value="getText('remove.label')"/>">
                                        <ww:property value="getText('remove.label')"/>
                                    </a>
                                </td>
                                </tr>

                            </ww:iterator>
                        </table>
                    </div>

                    <div class="formFooter wizardFooter">
                        <div class="buttons">
                            <ww:property value="getText('attribute.label')"/>
                            :&nbsp;<input type="text" name="attribute" size="15" value="<ww:property value="attribute" />"/>&nbsp;
                            <ww:property value="getText('value.label')"/>
                            :&nbsp;<input type="text" name="value" size="15" value="<ww:property value="value" />"/>&nbsp;
                            <input type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;" onClick="addAttribute();"/>
                            <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/secure/principal" action="viewprincipal" method="default" includeParams="none"><ww:param name="tab" value="2" /><ww:param name="name" value="name" /></ww:url>';"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>


        <div class="tabContent" id="tab3">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/secure/principal" action="updateprincipal" method="updateGroups" includeParams="none" />" name="groupsForm">
                    <div class="formBody">


                        <ww:include value="/include/generic_errors.jsp"/>

                        <p>
                            <ww:property value="getText('principal.groupmappings.text')"/>
                        </p>

                        <ww:set name="userName" value="[0].name"/>

                        <input type="hidden" name="tab" value="3"/>
                        <input type="hidden" name="name" value="<ww:property value="name" />"/>

                        <table id="groupsTable" class="formTable">
                            <tr>
                                <th width="64%">
                                    <ww:property value="getText('browser.group.label')"/>
                                </th>
                                <th width="36%">
                                    <ww:property value="getText('browser.action.label')"/>
                                </th>
                            </tr>

                            <ww:iterator value="subscribedGroups" status="rowstatus">

                                <ww:if test="#rowstatus.odd == true">
                                    <tr class="odd">
                                </ww:if>
                                <ww:else>
                                    <tr class="even">
                                </ww:else>

                                <td>
                                    <ww:property value="name"/>
                                </td>

                                <td>
                                    <a href="<ww:url namespace="/secure/principal" action="updateprincipal" method="removeGroup" includeParams="none" ><ww:param name="tab" value="3"/><ww:param name="removeGroup" value="name" /><ww:param name="name" value="[1].name" /></ww:url>">
                                    <ww:property value="getText('remove.label')"/></a>
                                </td>

                                </tr>

                            </ww:iterator>

                        </table>
                    </div>


                    <div class="formFooter wizardFooter">
                        <div class="buttons">
                            <ww:if test="unsubscribedGroups.size > 0">
                                <select name="unsubscribedGroup" style="width: 270px;">
                                    <ww:iterator value="unsubscribedGroups">
                                        <option value="<ww:property value="name" />">
                                            <ww:property value="name"/>
                                        </option>
                                    </ww:iterator>
                                </select>

                                <input id="add-group" type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;" onClick="addGroup();"/>
                            </ww:if>

                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/secure/principal" action="viewprincipal" method="default" includeParams="none" ><ww:param name="directoryID" value="[2].directoryID" /><ww:param name="name" value="userName"/><ww:param name="tab" value="3" /></ww:url>';"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="tabContent" id="tab4">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/secure/principal" action="updateprincipal" method="updateRoles" includeParams="none" />" name="rolesForm">
                    <div class="formBody">
                        <ww:include value="/include/generic_errors.jsp"/>

                        <p>
                            <ww:property value="getText('principal.rolemappings.text')"/>
                        </p>



                        <input type="hidden" name="tab" value="4"/>
                        <input type="hidden" name="name" value="<ww:property value="name" />"/>

                        <table id="rolesTable" class="formTable">
                            <tr>
                                <th width="64%">
                                    <ww:property value="getText('browser.role.label')"/>
                                </th>
                                <th width="36%">
                                    <ww:property value="getText('browser.action.label')"/>
                                </th>
                            </tr>

                            <ww:iterator value="subscribedRoles" status="rowstatus">

                                <ww:if test="#rowstatus.odd == true">
                                    <tr class="odd">
                                </ww:if>
                                <ww:else>
                                    <tr class="even">
                                </ww:else>

                                <td>
                                    <ww:property value="name"/>
                                </td>

                                <td>
                                    <a href="<ww:url namespace="/secure/principal" action="updateprincipal" method="removeRole" includeParams="none" ><ww:param name="tab" value="4" /><ww:param name="removeRole" value="name" /><ww:param name="name" value="[1].name" /></ww:url>">
                                        <ww:property value="getText('remove.label')"/>
                                    </a>
                                </td>

                                </tr>

                            </ww:iterator>

                        </table>
                    </div>

                    <div class="formFooter wizardFooter">
                        <div class="buttons">
                            <ww:if test="unsubscribedRoles.size > 0">
                                <select name="unsubscribedRole" style="width: 270px;">
                                    <ww:iterator value="unsubscribedRoles">
                                        <option value="<ww:property value="name" />">
                                            <ww:property value="name"/>
                                        </option>
                                    </ww:iterator>
                                </select>

                                <input type="button" class="button" value="<ww:property value="getText('add.label')"/> &raquo;" onClick="addRole();"/>
                            </ww:if>
                            <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                                   onClick="window.location='<ww:url namespace="/secure/principal" action="viewprincipal" method="default" includeParams="none" ><ww:param name="directoryID" value="directoryID"/><ww:param name="name" value="name"/><ww:param name="tab" value="4" /></ww:url>';"/>
                        </div>
                    </div>

              </form>
            </div>
        </div>

    </div>


</body>
</html>