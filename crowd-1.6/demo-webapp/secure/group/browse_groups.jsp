<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('browser.group.title')"/></title>
        <meta name="section" content="groups" />
    </head>
    <body>


            <p class="headingInfo">
                <a id="add-group" href="<ww:url namespace="/secure/group" action="addgroup" method="default" includeParams="none"/>">
                    <ww:property value="getText('menu.addgroup.label')"/>
                </a>
            </p>

            <h2><ww:property value="getText('browser.group.title')"/></h2>

            <div class="page-content">
                <ww:if test="actionErrors">
                    <ww:iterator value="actionErrors">
                        <p class="error">
                            <ww:property /><br/>
                        </p>
                    </ww:iterator>
                </ww:if>

                <form method="post" action="<ww:url namespace="/secure/group" action="browsegroups" includeParams="none" />">

                    <p class="miniform">
                        <ww:property value="getText('group.name.label')"/>:&nbsp;<input type="text" name="name" size="15" value="<ww:property value="name" />" />

                        &nbsp;&nbsp;

                        <ww:property value="getText('group.active.label')"/>:&nbsp;
                        <select name="active" style="width: 100px;">
                            <option value=""><ww:property value="getText('none.label')"/></option>
                            <option value="true" <ww:if test="active == 'true'">selected</ww:if>><ww:property value="getText('active.label')"/></option>
                            <option value="false" <ww:if test="active == 'false'">selected</ww:if>><ww:property value="getText('inactive.label')"/></option>
                        </select>

                        &nbsp;&nbsp;

                        <ww:property value="getText('browser.resultsperpage.label')"/>:
                        <select name="resultsPerPage" style="width: 50px;">
                            <option value="10" <ww:if test="resultsPerPage == 10">selected</ww:if>>10</option>
                            <option value="20" <ww:if test="resultsPerPage == 20">selected</ww:if>>20</option>
                            <option value="50" <ww:if test="resultsPerPage == 50">selected</ww:if>>50</option>
                            <option value="100" <ww:if test="resultsPerPage == 100">selected</ww:if>>100</option>
                        </select>
                    </p>

                    <p style="text-align: center;">
                        <input type="submit" class="button" value="<ww:property value="getText('browser.filter.label')"/>" />
                        <input type="reset" class="button" value="<ww:property value="getText('browser.resetfilter.label')"/>" onclick="location.href='<ww:url namespace="/secure/group" action="browsegroups" includeParams="none" />';" >
                    </p>

                </form>

                <table>
                    <tr>
                        <th width="64%"><ww:property value="getText('group.name.label')"/></th>
                        <th width="33%"><ww:property value="getText('group.active.label')"/></th>
                        <th width="33%"><ww:property value="getText('browser.action.label')"/></th>
                    </tr>

                    <ww:iterator value="results" status="rowstatus">
                        <ww:if test="#rowstatus.count <= resultsPerPage">
                            <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                            <ww:else><tr class="even"></ww:else>
                                <td valign="top"><ww:property value="name" /></td>
                                <td valign="top"><ww:property value="active" /></td>
                                <td valign="top"><a id="view-group-<ww:property value="name"/>" href="<ww:url namespace="/secure/group" action="viewgroup" method="default" includeParams="none" ><ww:param name="name" value="name"/></ww:url>"><ww:property value="getText('browser.view.label')"/></a></td>
                            </tr>
                        </ww:if>
                    </ww:iterator>

                </table>

                <ww:if test="resultsStart != 0 || results.size > resultsPerPage">
                    <table class="pager">
                        <tr class="pager">
                            <td align="left" class="pager">
                                <ww:if test="resultsStart != 0">
                                    <a href="javascript: document.previous.submit()">&laquo; <ww:property value="getText('previous.label')"/></a>
                                </ww:if>
                            </td>
                            <td align="right" class="pager">
                                <ww:if test="results.size > resultsPerPage">
                                    <a href="javascript: document.next.submit()"><ww:property value="getText('next.label')"/> &raquo;</a>
                                </ww:if>
                            </td>
                        </tr>
                    </table>
                </ww:if>

                <form name="next" method="post" action="<ww:url namespace="/secure/group" action="browsegroups" includeParams="none"/>">
                    <input type="hidden" name="name" value="<ww:property value="name" />" />
                    <input type="hidden" name="active" value="<ww:property value="active" />" />
                    <input type="hidden" name="resultsStart" value="<ww:property value="nextResultsStart" />" />
                    <input type="hidden" name="resultsPerPage" value="<ww:property value="resultsPerPage" />" />
                </form>

                <form name="previous" method="post" action="<ww:url namespace="/secure/group" action="browsegroups" includeParams="none"/>">
                    <input type="hidden" name="name" value="<ww:property value="name" />" />
                    <input type="hidden" name="active" value="<ww:property value="active" />" />
                    <input type="hidden" name="resultsStart" value="<ww:property value="previousResultsStart" />" />
                    <input type="hidden" name="resultsPerPage" value="<ww:property value="resultsPerPage" />" />
                </form>
            </div>
    </body>
</html>
