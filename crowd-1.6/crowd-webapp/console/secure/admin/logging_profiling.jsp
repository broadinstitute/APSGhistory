<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="sitemesh-page" prefix="page" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('options.title')"/></title>
    <meta name="section" content="administration"/>
    <meta name="pagename" content="logging_profiling"/>
    <meta name="help.url" content="<ww:property value="getText('help.admin.logging_profiling')"/>"/>
</head>

<body>

<h2><ww:property value="getText('menu.loggingprofiling.label')"/></h2>

<div class="page-content">
<div class="crowdForm">
    <form id="profiling" method="post"
          action="<ww:url namespace="/console/secure/admin" action="loggingProfiling" method="updateProfiling" includeParams="none"/>"
          name="profiling">
        <h3><ww:property value="getText('loglevel.profiling')"/></h3>

        <div class="formBody">
            <div class="fieldDescription">
                <ww:property value="getText('loglevel.profiling.desc')"/>
            </div>
            <br>
            <center>
                <ww:property value="getText('loglevel.precursor')"/>
                <ww:if test="profilingOn == true">
                    <ww:property value="getText('common.words.on')"/>
                    &nbsp;
                    <input type="hidden" name="profilingOn" value="false"/>
                    <input type="submit" value="<ww:property value="getText('loglevel.profilingOff')"/>"/>
                </ww:if>
                <ww:else>
                    <ww:property value="getText('common.words.off')"/>
                    &nbsp;
                    <input type="hidden" name="profilingOn" value="true"/>
                    <input type="submit" value="<ww:property value="getText('loglevel.profilingOn')"/>"/>
                </ww:else>
            </center>
        </div>

    </form>

</div>
<div class="crowdForm">
    <form id="logging" method="post"
          action="<ww:url namespace="/console/secure/admin" action="loggingProfiling" method ="updateLogging" includeParams="none"/>"
          name="logging">
        <h3><ww:property value="getText('loglevel.logging.heading')"/></h3>

        <div class="fieldDescription">
            <ww:property value="getText('loglevel.logging.desc')"/>
        </div>
        <div class="formBody">

            <ww:component template="form_messages.jsp"/>

            <table class="formTable">
                <tr>
                    <th width="40%"><ww:property value="getText('loglevel.packageHeading')"/></th>
                    <th width="10%"><ww:property value="getText('loglevel.currentLevelHeading')"/></th>
                    <th width="10%"><ww:property value="getText('loglevel.newLevelHeading')"/></th>
                </tr>
                <ww:iterator value="entries">
                    <tr id="<ww:property value="clazz"/>">
                        <td><ww:property value="clazz"/>
                            <input type="hidden" name="classNames" value="<ww:property value="clazz"/>">
                        </td>
                        <td><ww:property value="level"/></td>
                        <td>
                            <select name="levelNames" style="width: 130px;">
                                <option value="ALL"
                                        <ww:if test="level == 'ALL'">selected</ww:if>
                                    >
                                    ALL
                                </option>
                                <option value="DEBUG"
                                        <ww:if test="level == 'DEBUG'">selected</ww:if>
                                    >
                                    DEBUG
                                </option>
                                <option value="INFO"
                                        <ww:if test="level == 'INFO'">selected</ww:if>
                                    >
                                    INFO
                                </option>
                                <option value="WARN"
                                        <ww:if test="level == 'WARN'">selected</ww:if>
                                    >
                                    WARN
                                </option>
                                <option value="FATAL"
                                        <ww:if test="level == 'FATAL'">selected</ww:if>
                                    >
                                    FATAL
                                </option>
                                <option value="ERROR"
                                        <ww:if test="level == 'ERROR'">selected</ww:if>
                                    >
                                    ERROR
                                </option>

                            </select>
                        </td>
                    </tr>
                </ww:iterator>
            </table>
            <input type="submit" name="updateLogging" value="<ww:property value="getText('loglevel.updatelogging')"/>">
            <input type="submit" name="profileName" value="<ww:property value="getText('loglevel.reverttodefault')"/>">
        </div>
    </form>
</div>
</div>
</body>
</html>