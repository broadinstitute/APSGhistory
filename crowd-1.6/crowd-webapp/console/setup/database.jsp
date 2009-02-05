<%@ taglib uri="/webwork" prefix="ww" %>

<html>
<head>
    <title>
        <ww:text name="database.title"/>
    </title>
    <meta name="help.url" content="<ww:property value="getText('help.setup.database')"/>"/>

    <script type="text/javascript">

        // javascript show/hide divs

        function clickEmbedded()
        {
            document.getElementById('jdbcConfigDiv').style.display = 'none';
            document.getElementById('datasourceConfigDiv').style.display = 'none';
        }

        function clickJDBC()
        {
            document.getElementById('jdbcConfigDiv').style.display = 'block';
            document.getElementById('datasourceConfigDiv').style.display = 'none';
        }

        function clickDatasource()
        {
            document.getElementById('jdbcConfigDiv').style.display = 'none';
            document.getElementById('datasourceConfigDiv').style.display = 'block';
        }
        
        function autoClick()
        {                        
            if (document.getElementById('radioDatasource').checked)
            {
                clickDatasource();
            }
            else if (document.getElementById('radioJdbc').checked)
            {
                clickJDBC();
            }
            else
            {
                clickEmbedded();
            }
        }

        // javascript data for prepopulation
                
        var drivers = new Array();
        var jdbcurls = new Array();
        var dialects = new Array();

        <ww:iterator value="databaseList">

            <ww:set name="dbDetails" value="getDatabaseDetails(key)"/>

            drivers['<ww:property value="key"/>'] = '<ww:property value="#dbDetails.driverClassName"/>';
            jdbcurls['<ww:property value="key"/>'] = '<ww:property value="#dbDetails.databaseUrl"/>';
            dialects['<ww:property value="key"/>'] = '<ww:property value="#dbDetails.dialect"/>';

        </ww:iterator>

        // javascript methods to perform prepopulation

        function prepopulateJdbc()
        {
            var selectedDatabase = document.getElementById('jdbcDatabaseType').value;
            document.getElementById('jdbcDriverClassName').value  = drivers[selectedDatabase];
            document.getElementById('jdbcUrl').value              = jdbcurls[selectedDatabase];
            document.getElementById('jdbcHibernateDialect').value = dialects[selectedDatabase];           
        }

        function prepopulateDatasource()
        {
            var selectedDatabase = document.getElementById('datasourceDatabaseType').value;
            document.getElementById('datasourceHibernateDialect').value = dialects[selectedDatabase];
        }

    </script>
</head>
<body onload="autoClick();">


<div class="crowdForm">

    <form method="post" action="<ww:url namespace="/console/setup" action="setupdatabase" method="update" />" name="database">

        <div class="formTitle">
            <h2>
               <ww:text name="database.title"/>
            </h2>
        </div>

        <div class="formBody">


            <p>
                <ww:if test="upgradeFromExistingDatabase">
                    <ww:text name="database.upgrade.text"/>
                </ww:if>
                <ww:else>
                    <ww:text name="database.text"/>
                </ww:else>
            </p>

            <ww:component template="form_messages.jsp"/>

            <!-- old school html required because webwork rendering isn't ubertacular -->


            <div class="vertical-options">

                <ww:if test="!upgradeFromExistingDatabase">
                    <input type="radio" id="radioEmbedded" name="databaseOption" value="<ww:property value="embeddedValue"/>" onclick="clickEmbedded();" <ww:if test="embeddedSelected">checked</ww:if>/>
                    <label for="radioEmbedded"><ww:text name="database.embedded.label"/></label>
                    <div class="vertical-option-description">
                        <ww:text name="database.embedded.description"/>
                    </div>

                    <br/>
                </ww:if>
                
                <input type="radio" id="radioJdbc" name="databaseOption" value="<ww:property value="jdbcValue"/>" onclick="clickJDBC();" <ww:if test="jdbcSelected">checked</ww:if>/>
                <label for="radioJdbc"><ww:text name="database.jdbc.label"/></label>
                <div class="vertical-option-description">
                    <ww:text name="database.jdbc.description"/>
                </div>
                <div class="vertical-option-content" id="jdbcConfigDiv">

                    <ww:select name="jdbcDatabaseType" list="databaseList" listKey="key" listValue="value" onchange="prepopulateJdbc();">
                        <ww:param name="label">
                            <ww:text name="database.select.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.select.description"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:select>

                    <ww:textfield name="jdbcDriverClassName" cssClass="long">
                        <ww:param name="label">
                            <ww:text name="database.driver.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.driver.description"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:textfield>

                    <ww:textfield name="jdbcUrl" cssClass="long">
                        <ww:param name="label">
                            <ww:text name="database.jdbc.url.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.jdbc.url.description"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:textfield>

                    <ww:textfield name="jdbcUsername">
                        <ww:param name="label">
                            <ww:text name="database.username.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.username.description"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:textfield>

                    <ww:textfield name="jdbcPassword">
                        <ww:param name="label">
                            <ww:text name="database.password.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.password.description"/>
                        </ww:param>
                    </ww:textfield>

                    <ww:textfield name="jdbcHibernateDialect" cssClass="long">
                        <ww:param name="label">
                            <ww:text name="database.dialect.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.dialect.description"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:textfield>

                    <ww:if test="!upgradeFromExistingDatabase">
                        <ww:checkbox name="jdbcOverwriteData">
                            <ww:param name="label">
                                <ww:text name="database.overwrite.label"/>
                            </ww:param>
                            <ww:param name="description">
                                <ww:text name="database.overwrite.description"/>
                            </ww:param>
                        </ww:checkbox>
                    </ww:if>

                </div>

                <br/>
                
                <input type="radio" id="radioDatasource" name="databaseOption" value="<ww:property value="datasourceValue"/>" onclick="clickDatasource();" <ww:if test="datasourceSelected">checked</ww:if>/>
                <label for="radioDatasource"><ww:text name="database.datasource.label"/></label>
                <div class="vertical-option-description">
                    <ww:text name="database.datasource.description"/>
                </div>
                <div class="vertical-option-content" id="datasourceConfigDiv">

                    <ww:select name="datasourceDatabaseType" list="databaseList" listKey="key" listValue="value" onchange="prepopulateDatasource();">
                        <ww:param name="label">
                            <ww:text name="database.select.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.select.description"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:select>

                    <ww:textfield name="datasourceJndiName" cssClass="long">
                        <ww:param name="label">
                            <ww:text name="database.jndi.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.jndi.description"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:textfield>

                    <ww:textfield name="datasourceHibernateDialect" cssClass="long">
                        <ww:param name="label">
                            <ww:text name="database.dialect.label"/>
                        </ww:param>
                        <ww:param name="description">
                            <ww:text name="database.dialect.description"/>
                        </ww:param>
                        <ww:param name="required" value="true"/>
                    </ww:textfield>

                    <ww:if test="!upgradeFromExistingDatabase">
                        <ww:checkbox name="datasourceOverwriteData">
                            <ww:param name="label">
                                <ww:text name="database.overwrite.label"/>
                            </ww:param>
                            <ww:param name="description">
                                <ww:text name="database.overwrite.description"/>
                            </ww:param>
                        </ww:checkbox>
                    </ww:if>

                </div>

                <br/>

            </div>



        </div>

        <div class="formFooter wizardFooter">
            <div class="buttons">
                <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
            </div>
        </div>

    </form>

</div>



</body>
</html>