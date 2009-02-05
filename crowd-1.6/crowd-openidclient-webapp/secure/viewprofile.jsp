<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:text name="viewprofile.title"/></title>

        <meta name="section" content="profile"/>
    </head>

    <body>

        <div class="crowdForm">

            <h2><ww:text name="viewprofile.title"/></h2>

            <div class="formBodyNoTop">

                <table id="identifierTable" class="formTable">
                    <tr>
                        <th width="20%">
                            <ww:text name="openid.label"/>
                        </th>
                        <td width="80%">
                            <img src="<ww:url value="/images/openid-login-bg.gif"/>" class="openid" alt="openid icon"/>
                            <a href="<ww:property value="openIDPrincipal.identifier" />"><ww:property value="openIDPrincipal.identifier" /></a>
                        </td>

                    </tr>
                </table>
                

                <ww:if test="!openIDPrincipal.attributesMap.empty">
                    <table id="attributesTable" class="formTable">
                        <tr>
                            <th width="30%">
                                <ww:text name="attribute.label"/>
                            </th>
                            <th width="70%">
                                <ww:text name="value.label"/>
                            </th>

                        </tr>

                        <ww:iterator value="openIDPrincipal.attributesMap" status="rowstatus">

                            <ww:if test="#rowstatus.odd == true"><tr class="odd"></ww:if>
                            <ww:else><tr class="even"></ww:else>
                            <td>
                                <ww:property value="key"/>
                            </td>
                            <td>
                                <ww:property value="value"/>
                            </td>
                            </tr>

                        </ww:iterator>
                    </table>
                </ww:if>

            </div>

            <div class="formFooter centerText">
                <ww:if test="!openIDPrincipal.attributesMap.empty">
                    <ww:text name="viewprofile.sreg.info"/>
                </ww:if>
                <ww:else>
                    <ww:text name="viewprofile.nosreg.info"/>
                </ww:else>      
            </div>
        </div>

    </body>
</html>