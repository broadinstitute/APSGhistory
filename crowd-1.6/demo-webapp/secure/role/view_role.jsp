<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('menu.viewrole.label')"/></title>
        <meta name="section" content="roles" />
    </head>
    <body onload="init();">

        <jsp:include page="../../decorator/javascript_tabs.jsp">
                <jsp:param name="totalTabs" value="1" />
        </jsp:include>


    <p class="headingInfo">
        <a href="<ww:url namespace="/secure/role" action="addrole" method="default" includeParams="none" />">
            <ww:property value="getText('menu.addrole.label')"/>
        </a>
        &nbsp; | &nbsp;
        <a href="<ww:url namespace="/secure/role" action="removerole" method="default" includeParams="none"><ww:param name="directoryID" value="directoryID" /><ww:param name="name" value="name" /></ww:url>">
            <ww:property value="getText('menu.removerole.label')"/>
        </a>
    </p>

    <h2>
        <ww:property value="getText('menu.viewrole.label')"/>
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
        </ul>

        <div class="tabContent" id="tab1">

            <div class="crowdForm">
                <form method="post" action="<ww:url namespace="/secure/role" action="updaterole" method="updateGeneral" includeParams="none" />">
                    <div class="formBody">

                        <ww:include value="/include/generic_errors.jsp"/>

                        <input type="hidden" name="tab" value="1"/>
                        <input type="hidden" name="name" value="<ww:property value="name" />"/>


                        <ww:include value="/include/generic_form_row.jsp">
                            <ww:param name="label" value="getText('role.name.label')" />
                            <ww:param name="value">
                                <ww:property value="name"/>
                            </ww:param>
                        </ww:include>

                        <ww:include value="/include/generic_form_row.jsp">
                           <ww:param name="label" value="getText('role.description.label')" />
                            <ww:param name="value">
                                    <ww:property value="description"/>
                            </ww:param>
                        </ww:include>

                        <ww:include value="/include/generic_form_row.jsp">
                           <ww:param name="label" value="getText('role.active.label')" />
                            <ww:param name="value">
                                    <ww:property value="active"/>
                            </ww:param>
                        </ww:include>
                        
                    </div>

                </form>
            </div>
        </div>

    </div>
    </body>
</html>