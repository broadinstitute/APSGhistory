<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="sitemesh-page" prefix="page" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
        <ww:text name="menu.trustedproxies.label"/>
    </title>
    <meta name="section" content="administration"/>
    <meta name="pagename" content="trustedproxies"/>
    <meta name="help.url" content="<ww:text name="help.admin.trusted_proxies"/>"/>
</head>
<body>

<h2><ww:property value="getText('menu.trustedproxies.label')"/></h2>



    <div class="page-content">

        <div class="crowdForm">
            <form name="trustedProxyServers" method="post"
                  action="<ww:url namespace="/console/secure/admin" action="updatetrustedproxies" method="addAddress" includeParams="none" />">

                <div class="formBodyNoTop">

                    <ww:component template="form_messages.jsp"/>

                    <table id="addressesTable" class="formTable">
                        <tr>
                            <th width="64%">
                                <ww:property value="getText('browser.address.label')"/>
                            </th>
                            <th width="18%">
                                <ww:property value="getText('browser.action.label')"/>
                            </th>
                        </tr>

                        <ww:iterator value="addresses" status="rowstatus">

                            <ww:if test="#rowstatus.odd == true">
                                <tr class="odd">
                            </ww:if>
                            <ww:else>
                                <tr class="even">
                            </ww:else>

                            <td>
                                <ww:property/>
                            </td>

                            <td>
                                <a href="<ww:url namespace="/console/secure/admin" action="updatetrustedproxies" method="removeAddress" includeParams="none" ><ww:param name="address"><ww:property/></ww:param></ww:url>"
                                   title="<ww:property value="getText('remove.label')"/>">
                                    <ww:property value="getText('remove.label')"/>
                                </a>
                            </td>

                            </tr>

                        </ww:iterator>

                    </table>

                </div>

                <div class="formFooter wizardFooter">

                    <div class="buttons">
                        Address:&nbsp;<input type="text" name="address" size="20" style="width: 200px;" value=""/>&nbsp;
                        <input type="submit" class="button" value="<ww:property value="getText('add.label')"/> &raquo;"/>
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                               onClick="window.location='<ww:url namespace="/console/secure/admin" action="viewtrustedproxies" method="default" includeParams="none"></ww:url>';"/>
                    </div>
                </div>

            </form>

        </div>

    </div>

</body>
</html>
