<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:property value="getText('browser.directory.title')"/>
    </title>

    <meta name="section" content="directories"/>
    <meta name="pagename" content="browse"/>
    <meta name="help.url" content="<ww:property value="getText('help.directory.browse')"/>"/>    
</head>
<body>
    <h2>
        <ww:property value="getText('browser.directory.title')"/>
    </h2>

    <div class="crowdForm">

    <div class="formBodyNoTop">

        <ww:component template="form_messages.jsp"/>

        <form method="post" action="<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />">

            <p class="miniform">
                <ww:property value="getText('directory.name.label')"/>
                :&nbsp;<input type="text" name="name" size="15" value="<ww:property value="name" />"/>

                &nbsp;&nbsp;

                <ww:property value="getText('directory.active.label')"/>
                :&nbsp;
                <select name="active" style="width: 100px;">
                    <option value="">
                        <ww:property value="getText('all.label')"/>
                    </option>
                    <option value="true"
                            <ww:if test="active == 'true'">selected</ww:if>
                            >
                        <ww:property value="getText('active.label')"/>
                    </option>
                    <option value="false"
                            <ww:if test="active == 'false'">selected</ww:if>
                            >
                        <ww:property value="getText('inactive.label')"/>
                    </option>
                </select>

                &nbsp;&nbsp;

                <ww:property value="getText('browser.resultsperpage.label')"/>
                :
                <select name="resultsPerPage" style="width: 50px;">
                    <option value="10"<ww:if test="resultsPerPage == 10">selected</ww:if>>10</option>
                    <option value="20"<ww:if test="resultsPerPage == 20">selected</ww:if>>20</option>
                    <option value="50"<ww:if test="resultsPerPage == 50">selected</ww:if>>50</option>
                    <option value="100"<ww:if test="resultsPerPage == 100">selected</ww:if>>100</option>
                </select>
                &nbsp;&nbsp;&nbsp;
                <input type="submit" class="button" value="<ww:property value="getText('browser.filter.label')"/>"/>
                <input type="reset" class="button" value="<ww:property value="getText('browser.resetfilter.label')"/>" onclick="location.href='<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />';">
            </p>

        </form>

        <table id="directory-table">
            <tr>
                <th width="45%">
                    <ww:property value="getText('directory.name.label')"/>
                </th>
                <th width="10%">
                    <ww:property value="getText('directory.active.label')"/>
                </th>
                <th width="35%">
                    <ww:property value="getText('directory.type.label')"/>
                </th>
                <th width="10%">
                    <ww:property value="getText('browser.action.label')"/>
                </th>
            </tr>

            <ww:iterator value="results" status="rowstatus">
                <ww:if test="#rowstatus.count <= resultsPerPage">
                    <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                    <ww:else><tr class="even"></ww:else>
                    <td valign="top">
                        <ww:if test="type.code == 1">
                            <a href="<ww:url namespace="/console/secure/directory" action="viewinternal"><ww:param name="ID" value="ID" /></ww:url>" title="<ww:property value="getText('browser.view.label')"/>">
                        </ww:if>
                        <ww:elseif test="type.code == 2">
                            <a href="<ww:url namespace="/console/secure/directory" action="viewconnector" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>"
                               title="<ww:property value="getText('browser.view.label')"/>">
                        </ww:elseif>
                        <ww:elseif test="type.code == 3">
                            <a href="<ww:url namespace="/console/secure/directory" action="viewcustom" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>"
                               title="<ww:property value="getText('browser.view.label')"/>">
                        </ww:elseif>
                        <ww:elseif test="type.code == 4">
                            <a href="<ww:url namespace="/console/secure/directory" action="viewdelegated" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>"
                               title="<ww:property value="getText('browser.view.label')"/>">
                        </ww:elseif>
                        <ww:else>
                            <a href="<ww:url namespace="/console/secure/directory" action="viewcustom" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>" title="<ww:property value="getText('browser.view.label')"/>">
                        </ww:else>

                                <ww:property value="name"/>
                            </a>
                    </td>
                    <td valign="top">
                        <ww:property value="active"/>
                    </td>
                    <td valign="top">
                        <ww:property value="implementation.directoryType"/>
                    </td>
                    <td valign="top">
                        <ww:if test="type.code == 1">
                            <a href="<ww:url namespace="/console/secure/directory" action="viewinternal" method="default" ><ww:param name="ID" value="ID" /></ww:url>" title="<ww:property value="getText('browser.view.label')"/>">
                        </ww:if>
                        <ww:elseif test="type.code == 2">
                            <a href="<ww:url namespace="/console/secure/directory" action="viewconnector" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>"
                               title="<ww:property value="getText('browser.view.label')"/>">
                        </ww:elseif>
                        <ww:else>
                            <a href="<ww:url namespace="/console/secure/directory" action="viewcustom" method="default" includeParams="none" ><ww:param name="ID" value="ID" /></ww:url>" title="<ww:property value="getText('browser.view.label')"/>">
                        </ww:else>
                            <ww:property value="getText('browser.view.label')"/>
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

        <form name="next" method="post" action="<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />">
            <input type="hidden" name="ID" value="<ww:property value="ID" />"/>
            <input type="hidden" name="name" value="<ww:property value="name" />"/>
            <input type="hidden" name="active" value="<ww:property value="active" />"/>
            <input type="hidden" name="resultsStart" value="<ww:property value="nextResultsStart" />"/>
            <input type="hidden" name="resultsPerPage" value="<ww:property value="resultsPerPage" />"/>
        </form>

        <form name="previous" method="post" action="<ww:url namespace="/console/secure/directory" action="browse" includeParams="none" />">
            <input type="hidden" name="ID" value="<ww:property value="ID" />"/>
            <input type="hidden" name="name" value="<ww:property value="name" />"/>
            <input type="hidden" name="active" value="<ww:property value="active" />"/>
            <input type="hidden" name="resultsStart" value="<ww:property value="previousResultsStart" />"/>
            <input type="hidden" name="resultsPerPage" value="<ww:property value="resultsPerPage" />"/>
        </form>

    </div>

    </div>

</body>
</html>