<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('auth.record.title')"/></title>
        <meta name="section" content="home" />
        <meta name="subsection" content="authhistory" />
    </head>

    <body>

            <div class="crowdForm">
                <div class="formTitle">
                    <h2><ww:property value="getText('auth.record.title')"/></h2>
                </div>

                <div class="formBodyNoTop">

                    <p>
                        The following is a record of all authentication activity with external sites with your account.
                    </p>

                    <ww:if test="recordPager.totalResults > 0">

                        <table class="attributeTable" id="entryTable">
                            <tr class="attributePlainRow" height="30px">
                                <td class="attributePlainCell" width="150px">
                                    <b>Time</b>
                                </td>

                                <td class="attributePlainCell">
                                    <b>URL</b>
                                </td>

                                <td class="attributePlainCell" width="150px">
                                    <b>Action</b>
                                </td>
                            </tr>

                            <ww:iterator value="recordPager.items">
                                <tr class="attributeRow">
                                    <td class="attributeCellFirst" width="150px">
                                        <ww:property value="formatDate(createdDate)"/>
                                    </td>
                                    <td class="attributeCell">
                                        <a href="<ww:property value="site.url"/>"><ww:property value="site.url"/></a>
                                    </td>
                                    <td class="attributeCell">
                                        <ww:if test="authAction.code == 0">
                                            <ww:property value="getText('authaction.unknown.label')"/>
                                        </ww:if>
                                        <ww:elseif test="authAction.code == 1">
                                            <img class="historyIcon" src="<ww:url value="/images/icons/red.png"/>"/>
                                            <ww:property value="getText('authaction.deny.label')"/>
                                        </ww:elseif>
                                        <ww:elseif test="authAction.code == 2">
                                            <img class="historyIcon" src="<ww:url value="/images/icons/orange.png"/>"/>
                                            <ww:property value="getText('authaction.allow.label')"/>
                                        </ww:elseif>
                                        <ww:elseif test="authAction.code == 3">
                                            <img class="historyIcon" src="<ww:url value="/images/icons/green.png"/>"/>
                                            <ww:property value="getText('authaction.allowalways.label')"/>
                                        </ww:elseif>
                                        <ww:elseif test="authAction.code == 4">
                                            <img class="historyIcon" src="<ww:url value="/images/icons/green.png"/>"/>
                                            <ww:property value="getText('authaction.allowauto.label')"/>
                                        </ww:elseif>
                                        <ww:else>
                                            <img class="historyIcon" src="<ww:url value="/images/icons/green.png"/>"/>
                                            <ww:property value="getText('authaction.allowalways.label')"/>
                                        </ww:else>
                                    </td>
                                </tr>
                            </ww:iterator>

                        </table>
                    </ww:if>
                    <ww:else>
                        <p align="center">
                            <b>You have never authenticated with an external site.</b>
                        </p>
                    </ww:else>

                </div>

                <div class="formFooter wizardFooter" style="text-align:center;">                   
                    <ww:if test="recordPager.totalResults > recordPager.maxItemsPerPage">
                        <ww:if test="recordPager.currentPage > recordPager.leftMostPage">
                            <a href="<ww:url action="viewauthrecord"><ww:param name="startIndex" value="recordPager.maxItemsPerPage * (recordPager.currentPage - 2)"/></ww:url>">&lt;&lt; Prev</a> &nbsp;
                        </ww:if>
                        <ww:iterator value="recordPager.listOfPageNumbers" status="page">
                            <ww:if test="recordPager.currentPage == top">
                                <b><ww:property value="top"/></b> &nbsp;
                            </ww:if>
                            <ww:else>
                                <a href="<ww:url action="viewauthrecord"><ww:param name="startIndex" value="recordPager.maxItemsPerPage * (top - 1)"/></ww:url>"><ww:property value="top"/></a> &nbsp;
                            </ww:else>
                        </ww:iterator>
                        <ww:if test="recordPager.currentPage < recordPager.rightMostPage">
                            <a href="<ww:url action="viewauthrecord"><ww:param name="startIndex" value="recordPager.maxItemsPerPage * recordPager.currentPage"/></ww:url>">Next &gt;&gt;</a>
                        </ww:if>
                    </ww:if>
                    <ww:else>
                        &nbsp;
                    </ww:else>
                </div>

            </div>

    </body>
</html>