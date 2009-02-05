    <%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="sitemesh-page" prefix="page" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
<head>
    <title>
    <ww:property value="getText('options.title')"/></title>
    <meta name="section" content="administration" />
    <meta name="pagename" content="licensing" />
    <meta name="help.url" content="<ww:property value="getText('help.admin.licensing')"/>"/>
</head>
    <body>
            <h2><ww:property value="getText('menu.licensing.label')"/></h2>
            <div class="page-content">
                    <div class="crowdForm">
                        <form id="licensing" method="post" action="<ww:url namespace="/console/secure/admin" action="licensing" method="update" includeParams="none"/>" name="licensing">
                            <div class="formBody">

                                <ww:component template="form_messages.jsp"/>

                                <ww:component template="form_row.jsp">
                                    <ww:param name="label" value="getText('license.organization.label')" />
                                    <ww:param name="value">
                                            <ww:property value="license.organisation.name" />
                                    </ww:param>
                                </ww:component>

                                <ww:component template="form_row.jsp">
                                    <ww:param name="label" value="getText('license.type.label')" />
                                    <ww:param name="value">
                                            <ww:property value="license.description" />
                                    </ww:param>
                                </ww:component>

                                <ww:component template="form_row.jsp">
                                    <ww:param name="label" value="getText('license.datepurchased.label')" />
                                    <ww:param name="value">
                                            <ww:date format="EEEE, dd MMM yyyy" name="license.purchaseDate"/>
                                    </ww:param>
                                </ww:component>

                                <ww:component template="form_row.jsp">
                                    <ww:param name="label" value="getText('license.supportperiod.label')" />
                                    <ww:param name="value">
                                            <ww:property value="getText('license.supportperiod.description')"/>&nbsp;<strong><ww:date format="EEEE, dd MMM yyyy" name="licenseExpiryDate"/></strong>
                                    </ww:param>
                                </ww:component>

                                <ww:if test="license.supportEntitlementNumber != null">
                                <ww:component template="form_row.jsp">
                                    <ww:param name="label" value="getText('license.sen.label')" />
                                    <ww:param name="value">
                                            <ww:property value="license.supportEntitlementNumber" />
                                    </ww:param>
                                </ww:component>
                                </ww:if>

                                <ww:if test="license.partner" >
                                    <ww:component template="form_row.jsp">
                                        <ww:param name="label" value="getText('license.partner.label')" />
                                        <ww:param name="value">
                                                <ww:property value="license.partner.name"/>
                                        </ww:param>
                                    </ww:component>
                                </ww:if>

                                <ww:component template="form_row.jsp">
                                    <ww:param name="label" value="getText('license.userlimit.label')" />
                                    <ww:param name="value">
                                        <ww:if test="license.unlimitedNumberOfUsers" >
                                            <ww:property value="getText('license.unlimited.label')"/>
                                        </ww:if>
                                        <ww:else>
                                            <ww:property value="license.maximumNumberOfUsers" />
                                        </ww:else>
                                    </ww:param>
                                </ww:component>

                                <ww:component template="form_row.jsp">
                                    <ww:param name="label" value="getText('license.userresources.label')" />
                                    <ww:param name="value">
                                        <span id="license-count"><ww:property value="currentResources" /></span>
                                    </ww:param>
                                    <ww:param name="description">
                                        <ww:text name="license.recalculate.total">
                                            <ww:param id="0"><a id="license-recalculate-total" href="<ww:url namespace="/console/secure/admin" action="licensing" method="recalculateUserLimit" includeParams="none"></ww:url>"></ww:param>
                                            <ww:param id="1"></a></ww:param>
                                            </ww:text>
                                    </ww:param>
                                </ww:component>

                                <ww:component template="form_row.jsp">
                                    <ww:param name="label" value="getText('systeminfo.serverid.label')" />
                                    <ww:param name="value">
                                            <ww:property value="serverId" />
                                    </ww:param>
                                </ww:component>

                                <ww:textarea name="key" rows="8" cols="60">
                                    <ww:param name="label" value="getText('license.key.label')" />
                                    <ww:param name="description">
                                        <ww:text name="license.key.description.1"/>
                                        <a href="<ww:url value="http://www.atlassian.com/ex/GenerateLicense.jspa" includeParams="none">
                                            <ww:param name="product" value="getText('application.name')" />
                                            <ww:param name="version" value="@com.atlassian.crowd.util.build.BuildUtils@BUILD_VERSION" />
                                            <ww:param name="sid" value="serverId" />
                                            <ww:param name="ref" value="'prod'" />
                                            </ww:url>">
                                            <ww:text name="license.key.description.2"/></a>
                                            &nbsp;<ww:text name="license.key.description.3">
                                                <ww:param id="0"><a  href="<ww:url value="http://my.atlassian.com/" includeParams="none"/>"></ww:param>
                                                <ww:param id="1"></a></ww:param>
                                            </ww:text>
                                    </ww:param>
                                </ww:textarea>
                            </div>

                            <div class="formFooter wizardFooter">
                                <div class="buttons">
                                    <input type="submit" class="button" value="<ww:property value="getText('update.label')"/> &raquo;"/>
                                    <input type="button" class="button" id="cancel" value="<ww:property value="getText('cancel.label')"/>" onClick="window.location='<ww:url namespace="/console/secure/admin" action="licensing" method="default" includeParams="none" ></ww:url>';"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>      
    </body>
</html>