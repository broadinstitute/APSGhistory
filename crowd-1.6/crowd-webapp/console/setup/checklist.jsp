<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="checklist.title"/>
    </title>
    <meta name="help.url" content="<ww:text name="help.setup.checklist"/>"/>
</head>
<body>


<div class="crowdForm">

    <div class="formTitle">
        <h2>
            <ww:text name="checklist.title"/>
        </h2>
    </div>

    <div class="formBody">
        <p>
            <ww:text name="checklist.welcome"/>
        </p>
        <p>
            <ww:text name="checklist.text">
                <ww:param name="0"><a href="<ww:text name="help.prefix"/><ww:text name="help.setup.checklist.install"/>" target="_crowdhelp"></ww:param>
                <ww:param name="1"></a></ww:param>
            </ww:text>
        </p>


        <table id="attributesTable" class="formTable">
            <tr>
                <th width="80%">

                </th>
                <th>
                    <ww:text name="checklist.status.label"/>
                </th>
            </tr>

            <tr>
                <td>
                    <b><ww:text name="checklist.jdk.text"/></b>
                    <br/>
                    <p><i><ww:text name="checklist.found.text"/>:</i> <ww:property value="jdkName"/></p>
                </td>
                <td align="center">
                    <ww:if test="jdk15">
                        <img src="<ww:url value="/console/images/icons/16x16/check.gif"/>" alt="OK" width="16" height="16"/>
                    </ww:if>
                    <ww:else>
                        <img src="<ww:url value="/console/images/icons/16x16/exclamation.png"/>" alt="ERROR" width="16" height="16"/>
                    </ww:else>
                </td>
            </tr>

            <tr>
                <td>
                    <b><ww:text name="checklist.servlet.text"/></b>
                    <br/>
                    <p><i><ww:text name="checklist.found.text"/>:</i> <ww:property value="serverName"/></p>
                </td>
                <td align="center">
                    <ww:if test="servlet24">
                        <img src="<ww:url value="/console/images/icons/16x16/check.gif"/>" alt="OK" width="16" height="16"/>
                    </ww:if>
                    <ww:else>
                        <img src="<ww:url value="/console/images/icons/16x16/exclamation.png"/>" alt="ERROR" width="16" height="16"/>
                    </ww:else>
                </td>
            </tr>

            <tr>
                <td>
                    <b><ww:text name="checklist.home.text"/></b>
                    <br/>
                    <ww:if test="!applicationHomeOk">
                        <p>
                            <ww:text name="checklist.home.invalid.1">
                                <ww:param id="0" value="'<i>'"/>
                                <ww:param id="1" value="crowdInitPropertiesLocation"/>
                                <ww:param id="2" value="'</i>'"/>
                            </ww:text>
                        </p>

                        <p><ww:text name="checklist.home.invalid.2"/></p>

                        <p><ww:text name="checklist.home.invalid.3"/></p>

                    </ww:if>
                    <ww:else>
                        <i><ww:text name="checklist.found.text"/></i>: <ww:property value="applicationHome"/>
                    </ww:else>
                </td>
                <td align="center">
                    <ww:if test="applicationHomeOk">
                        <img src="<ww:url value="/console/images/icons/16x16/check.gif"/>" alt="OK" width="16" height="16"/>
                    </ww:if>
                    <ww:else>
                        <img src="<ww:url value="/console/images/icons/16x16/exclamation.png"/>" alt="ERROR" width="16" height="16"/>
                    </ww:else>
                </td>
            </tr>

        </table>

    </div>

    <div class="formFooter wizardFooter">
        <div class="buttons">
            &nbsp;
        </div>
    </div>

</div>



</body>
</html>