<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('browser.session.title')"/>
    </title>
    <meta name="section" content="sessions"/>
    <meta name="pagename" content="sessions"/>
    <meta name="help.url" content="<ww:property value="getText('help.admin.sessions.user')"/>"/>
</head>
<body>
    <h2>
        <ww:property value="getText('browser.session.title')"/>
    </h2>

    <div class="page-content">
        <ul class="tabs">
            <li>
                <a href="<ww:url namespace="/console/secure/session" action="browseapplicationsessions" includeParams="none" />">
                    <ww:property value="getText('session.application.title')"/>
                </a>
            </li>
            <li class="on">
                <a href="<ww:url namespace="/console/secure/session" action="browseusersessions" includeParams="none" />">
                    <ww:property value="getText('session.principal.title')"/>
                </a>
            </li>
        </ul>

        <div class="crowdForm">
            <div class="formBody">
                <ww:if test="actionErrors">
                    <ww:iterator value="actionErrors">
                        <p class="error">
                            <ww:property/>
                            <br/>
                        </p>
                    </ww:iterator>
                </ww:if>

                <form name="browse-principals" method="post" action="<ww:url namespace="/console/secure/session" action="browseusersessions" includeParams="none" />">

                    <p class="miniform">
                        <ww:property value="getText('browser.directory.label')"/>
                        :&nbsp;
                        <select name="selectedDirectoryID" style="width: 130px;">
                            <ww:iterator value="directories">
                                <option value="<ww:property value="ID" />"
                                        <ww:if test="ID == getSelectedDirectoryID()">selected</ww:if>
                                        >
                                    <ww:property value="name"/>
                                </option>
                            </ww:iterator>
                        </select>

                        &nbsp;&nbsp;

                        <ww:property value="getText('session.name.label')"/>
                        :&nbsp;<input type="text" name="name" size="15" value="<ww:property value="name" />"/>

                        &nbsp;&nbsp;

                        <ww:property value="getText('browser.resultsperpage.label')"/>
                        :
                        <select name="resultsPerPage" style="width: 60px;">
                            <option value="10"<ww:if test="resultsPerPage == 10">selected</ww:if>>10</option>
                            <option value="20"<ww:if test="resultsPerPage == 20">selected</ww:if>>20</option>
                            <option value="50"<ww:if test="resultsPerPage == 50">selected</ww:if>>50</option>
                            <option value="100"<ww:if test="resultsPerPage == 100">selected</ww:if>>100</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;
                        <input type="submit" class="button" value="<ww:property value="getText('browser.filter.label')"/>"/>
                        <input type="reset" class="button" value="<ww:property value="getText('browser.resetfilter.label')"/>" onclick="location.href='<ww:url namespace="/console/secure/session" action="browseusersessions" includeParams="none" />';">
                    </p>



                </form>

                <table id="pricipal-session-results">
                    <tr>
                        <th width="18%">
                            <ww:property value="getText('principal.name.label')"/>
                        </th>
                        <th width="18%">
                            <ww:property value="getText('browser.directory.label')"/>
                        </th>
                        <th width="22%">
                            <ww:property value="getText('session.initialization.label')"/>
                        </th>
                        <th width="22%">
                            <ww:property value="getText('session.lastaccessed.label')"/>
                        </th>
                        <th width="20%">
                            <ww:property value="getText('browser.action.label')"/>
                        </th>
                    </tr>

                    <ww:iterator value="results" status="rowstatus">
                        <ww:if test="#rowstatus.count <= resultsPerPage">
                            <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                            <ww:else><tr class="even"></ww:else>
                            <td valign="top">
                                <a href="<ww:url namespace="/console/secure/user" action="view" method="default" includeParams="none"><ww:param name="name" value="name" /><ww:param name="directoryID" value="directoryID" /></ww:url>"
                                   title="<ww:property value="getText('browser.view.label')"/>">
                                    <ww:property value="name"/>
                                </a>

                            </td>

                            <td valign="top">
                                <ww:if test="[0].directory(directoryID).type.code == 1">
                                    <a href="<ww:url namespace="/console/secure/directory" action="viewinternal"><ww:param name="ID" value="directoryID" /></ww:url>" title="<ww:property value="getText('browser.view.label')"/>">
                                </ww:if>
                                <ww:elseif test="[0].directory(directoryID).type.code == 2">
                                    <a href="<ww:url namespace="/console/secure/directory" action="viewconnector" includeParams="none" ><ww:param name="ID" value="directoryID" /></ww:url>"
                                       title="<ww:property value="getText('browser.view.label')"/>">
                                </ww:elseif>
                                <ww:elseif test="[0].directory(directoryID).type.code == 3">
                                    <a href="<ww:url namespace="/console/secure/directory" action="viewcustom" includeParams="none" ><ww:param name="ID" value="directoryID" /></ww:url>"
                                       title="<ww:property value="getText('browser.view.label')"/>">
                                </ww:elseif>
                                <ww:elseif test="[0].directory(directoryID).type.code == 4">
                                    <a href="<ww:url namespace="/console/secure/directory" action="viewdelegated" includeParams="none" ><ww:param name="ID" value="directoryID" /></ww:url>"
                                       title="<ww:property value="getText('browser.view.label')"/>">
                                </ww:elseif>
                                <ww:else>
                                    <a href="<ww:url namespace="/console/secure/directory" action="viewcustom" includeParams="none" ><ww:param name="ID" value="directoryID" /></ww:url>" title="<ww:property value="getText('browser.view.label')"/>">
                                </ww:else>
                                        <ww:property value="[0].directory(directoryID).name"/>
                                    </a>
                            </td>

                            <td valign="top">
                                <ww:bean name="com.opensymphony.webwork.util.DateFormatter" id="initializationTime">
                                    <ww:param name="time" value="[0].session.initialization"/>
                                    <ww:param name="format" value="'dd/M/yyyy HH:mm:ss'"/>
                                </ww:bean>
                                <ww:property value="#initializationTime.formattedDate"/>
                            </td>

                            <td valign="top">
                                <ww:bean name="com.opensymphony.webwork.util.DateFormatter" id="lastAccessed">
                                    <ww:param name="time" value="[0].session.lastAccessed"/>
                                    <ww:param name="format" value="'dd/M/yyyy HH:mm:ss'"/>
                                </ww:bean>
                                <ww:property value="#lastAccessed.formattedDate"/>
                            </td>

                            <td valign="top">
                                <a href="<ww:url namespace="/console/secure/user" action="view" method="default" includeParams="none"><ww:param name="name" value="name" /><ww:param name="directoryID" value="directoryID" /></ww:url>"
                                   title="<ww:property value="getText('browser.view.label')"/>">
                                    <ww:property value="getText('browser.view.label')"/>
                                </a>
                                |
                                <a href="<ww:url namespace="/console/secure/session" action="removeusersession" method="removePrincipalSession" includeParams="none" ><ww:param name="key" value="key" /></ww:url>"
                                   title="<ww:property value="getText('expire.label')"/>">
                                    <ww:property value="getText('expire.label')"/>
                                </a>
                            </td>
                            </tr>
                        </ww:if>
                    </ww:iterator>

                </table>

                <ww:if test="resultsStart != 0 || results.size > resultsPerPage">
                    <table class="pager">
                        <tr class="pager">
                            <td align="left" class="pager">
                                <ww:if test="resultsStart != 0">
                                    <a href="javascript: document.previous.submit()">&laquo;
                                        <ww:property value="getText('previous.label')"/>
                                    </a>
                                </ww:if>
                            </td>
                            <td align="right" class="pager">
                                <ww:if test="results.size > resultsPerPage">
                                    <a href="javascript: document.next.submit()">
                                        <ww:property value="getText('next.label')"/> &raquo;</a>
                                </ww:if>
                            </td>
                        </tr>
                    </table>
                </ww:if>

                <form name="next" method="post" action="<ww:url namespace="/console/secure/session" action="browseusersessions" includeParams="none"/>">
                    <input type="hidden" name="ID" value="<ww:property value="ID" />"/>
                    <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                    <input type="hidden" name="name" value="<ww:property value="name" />"/>
                    <input type="hidden" name="resultsStart" value="<ww:property value="nextResultsStart" />"/>
                    <input type="hidden" name="resultsPerPage" value="<ww:property value="resultsPerPage" />"/>
                </form>

                <form name="previous" method="post" action="<ww:url namespace="/console/secure/session" action="browseusersessions" includeParams="none"/>">
                    <input type="hidden" name="ID" value="<ww:property value="ID" />"/>
                    <input type="hidden" name="directoryID" value="<ww:property value="directoryID" />"/>
                    <input type="hidden" name="name" value="<ww:property value="name" />"/>
                    <input type="hidden" name="resultsStart" value="<ww:property value="previousResultsStart" />"/>
                    <input type="hidden" name="resultsPerPage" value="<ww:property value="resultsPerPage" />"/>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
