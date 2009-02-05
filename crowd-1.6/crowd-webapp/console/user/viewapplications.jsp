<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>

<head>
    <title><ww:text name="menu.user.console.viewapplications.label"/></title>

    <meta name="section" content="user.console"/>
    <meta name="pagename" content="viewapplications"/>
    <meta name="help.url" content="<ww:text name="help.user.console.viewapplications"/>"/>
</head>

<body>

    <h2><ww:text name="menu.user.console.viewapplications.label"/></h2>

    <div class="page-content">
        <div class="crowdForm">

            <div class="formBody">

                <ww:component template="form_messages.jsp"/>

                <ww:if test="applications.empty">
                    <p><ww:text name="user.console.noapplications.text"/></p>
                </ww:if>
                <ww:else>
                    <p><ww:text name="user.console.applications.text"/></p>

                    <table class="formTable">
                        <tr>
                            <th><ww:text name="user.console.application.header"/></th>
                            <th><ww:text name="user.console.description.header"/></th>
                        </tr>
                        <ww:iterator value="applications">
                            <tr>
                                <td>
                                    <ww:property value="name"/>
                                </td>
                                <td>
                                    <ww:property value="description"/>
                                </td>
                            </tr>
                        </ww:iterator>
                    </table>
                </ww:else>

            </div>

        </div>
    </div>

</body>
</html>