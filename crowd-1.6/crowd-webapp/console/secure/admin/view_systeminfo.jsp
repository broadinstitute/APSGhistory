<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:text name="systeminfo.title"/></title>
        <meta name="section" content="administration" />
        <meta name="pagename" content="systeminfo" />
        <meta name="help.url" content="<ww:property value="getText('help.admin.systeminfo')"/>"/>
    </head>

    <body>

        <div class="crowdForm">

            <div class="formTitle">
                <h3><ww:text name="systeminfo.title"/></h3>
            </div>

            <div class="formBody">
            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.date.label')" />
                <ww:param name="value">
                        <ww:date format="EEEE, dd MMM yyyy" name="systemTime"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.time.label')" />
                <ww:param name="value">
                        <ww:date format="HH:mm:ss" name="systemTime"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.timezone.label')" />
                <ww:param name="value">
                        <ww:property value="timeZone"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.javaversion.label')" />
                <ww:param name="value">
                        <ww:property value="javaVersion"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.javavendor.label')" />
                <ww:param name="value">
                        <ww:property value="javaVendor"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.jvmversion.label')" />
                <ww:param name="value">
                        <ww:property value="javaVMVersion"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.jvmvendor.label')" />
                <ww:param name="value">
                        <ww:property value="javaVMVendor"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.jvm.label')" />
                <ww:param name="value">
                        <ww:property value="javaRuntime"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.username.label')" />
                <ww:param name="value">
                        <ww:property value="applicationUsername"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.os.label')" />
                <ww:param name="value">
                        <ww:property value="operatingSystem"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.architecture.label')" />
                <ww:param name="value">
                        <ww:property value="architecture"/>
                </ww:param>
            </ww:component>
            </div>

            <div class="formTitle">
                <h3><ww:property value="getText('systeminfo.crowd.label')"/></h3>
            </div>

            <div class="formBody">
                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('systeminfo.home.label')" />
                    <ww:param name="value">
                            <ww:property value="crowdHome"/>
                    </ww:param>
                </ww:component>
            </div>

            <div class="formTitle">
                <h3><ww:property value="getText('systeminfo.statistics.label')"/></h3>
            </div>

            <div class="formBody">
            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.totalmemory.label')" />
                <ww:param name="value">
                        <ww:property value="totalMemory"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.usedmemory.label')" />
                <ww:param name="value">
                        <ww:property value="usedMemory"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.freememory.label')" />
                <ww:param name="value">
                        <ww:property value="freeMemory"/>
                </ww:param>
            </ww:component>
            </div>

            <div class="formTitle">
                <h3><ww:property value="getText('systeminfo.database.label')"/></h3>
            </div>

            <div class="formBody">
            <ww:if test="databaseDatasource">
                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('systeminfo.datasource.jndi.label')" />
                    <ww:param name="value">
                        <ww:property value="databaseDatasourceJndiName" />
                    </ww:param>
                </ww:component>
            </ww:if>
            <ww:else>
                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('systeminfo.jdbc.url.label')" />
                    <ww:param name="value">
                        <ww:property value="databaseJdbcUrl" />
                    </ww:param>
                </ww:component>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('systeminfo.jdbc.driver.label')" />
                    <ww:param name="value">
                        <ww:property value="databaseJdbcDriver" />
                    </ww:param>
                </ww:component>

                <ww:component template="form_row.jsp">
                    <ww:param name="label" value="getText('systeminfo.jdbc.username.label')" />
                    <ww:param name="value">
                        <ww:property value="databaseJdbcUsername" />
                    </ww:param>
                </ww:component>
            </ww:else>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.hibernate.dialect.label')" />
                <ww:param name="value">
                    <ww:property value="databaseHibernateDialect" />
                </ww:param>
            </ww:component>
            </div>


            <div class="formTitle">
                <h3><ww:property value="getText('systeminfo.runtimeinfo.label')"/></h3>
            </div>

            <div class="formBody">
            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.appserver.label')" />
                <ww:param name="value">
                        <ww:property value="applicationServer" />
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.version.label')" />
                <ww:param name="value"><ww:property value="@com.atlassian.crowd.util.build.BuildUtils@BUILD_VERSION"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.buildversion.label')" />
                <ww:param name="value"><ww:property value="@com.atlassian.crowd.util.build.BuildUtils@BUILD_NUMBER"/>
                </ww:param>
            </ww:component>

            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.builddate.label')" />
                <ww:param name="value"><ww:property value="@com.atlassian.crowd.util.build.BuildUtils@BUILD_DATE"/>
                </ww:param>
            </ww:component>
            </div>

            <div class="formTitle">
                <h3><ww:property value="getText('systeminfo.license.title')"/></h3>
            </div>

            <div class="formBody">
            <ww:component template="form_row.jsp">
                <ww:param name="label" value="getText('systeminfo.serverid.label')" />
                <ww:param name="value">
                        <ww:property value="serverId" />
                </ww:param>
            </ww:component>
            </div>
        
        </div>


    </body>
</html>