<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="error.title"/>
    </title>
</head>

<body>
    <h2><ww:text name="error.title"/></h2>

    <p><ww:text name="error.text"/>:</p>

    <table class="formTable">
        <thead>
            <tr>
                <th><ww:text name="error.time.label" /></th>
                <th><ww:text name="error.level.label" /></th>
                <th><ww:text name="error.type.label" /></th>
                <th><ww:text name="error.description.label" /></th>
                <th><ww:text name="error.exception.label" /></th>
            </tr>
        </thead>
        <tbody>
            <ww:iterator value="events" id="event">
                <tr>
                    <td nowrap><ww:property value="date"/></td>
                    <td nowrap><ww:property value="level.level"/></td>
                    <td nowrap><ww:property value="key.type"/></td>
                    <td>
                        <ww:if test="key.type == 'license-too-old'">
                            <ww:text name="error.license.too.old.text">
                                <ww:param id="0"><a href="<ww:url includeParams="none" namespace="/console" action="license" method="default"/>"></ww:param>
                                <ww:param id="1"></a></ww:param>
                            </ww:text>
                        </ww:if>
                        <ww:elseif test="key.type == 'restart'">
                            <ww:text name="error.console.restart.text">
                                <ww:param id="0"><a href="<ww:url includeParams="none" namespace="/console" action="login" />"></ww:param>
                                <ww:param id="1"></a></ww:param>
                            </ww:text>
                        </ww:elseif>
                        <ww:else>
                            <ww:property value="desc"/>
                        </ww:else>
                    </td>
                    <td>
            <pre>
                <ww:if test="exception.exists">
                    <ww:property value="exception"/>
                </ww:if>
            </pre>
                    </td>

                </tr>
            </ww:iterator>
        </tbody>

    </table>
</body>
</html>