<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>

<head>
    <title><ww:text name="menu.user.console.viewgroups.label"/></title>

    <meta name="section" content="user.console"/>
    <meta name="pagename" content="viewgroups"/>
    <meta name="help.url" content="<ww:text name="help.user.console.viewgroups"/>"/>
</head>

<body>

    <h2><ww:text name="menu.user.console.viewgroups.label"/></h2>

    <div class="page-content">
        <div class="crowdForm">

            <div class="formBody">

                <ww:component template="form_messages.jsp"/>

                <ww:if test="groups.empty">
                    <p><ww:text name="user.console.nogroups.text"/></p>
                </ww:if>
                <ww:else>
                    <p><ww:text name="user.console.groups.text"/></p>

                    <table class="formTable">
                        <tr>
                            <th><ww:text name="user.console.group.header"/></th>
                        </tr>
                        <ww:iterator value="groups">
                            <tr>
                                <td>
                                    <ww:property/>
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