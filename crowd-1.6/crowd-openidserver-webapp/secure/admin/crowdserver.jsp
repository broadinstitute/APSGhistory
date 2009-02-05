<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('crowdserver.label')"/></title>
        <meta name="section" content="administration" />
        <meta name="subsection" content="generalconfiguration" />
    </head>

    <body>

        <div class="crowdForm">

        <h2><ww:property value="getText('crowdserver.label')"/></h2>

        <div class="formBody">

        <ww:include value="/include/generic_errors.jsp"/>

            <div class="titleSection">
                <ww:text name="crowdserver.text"/>
            </div>            

            <ww:include value="/include/generic_form_row.jsp">
                <ww:param name="label" value="getText('crowdserver.application.label')" />
                <ww:param name="value">
                    <ww:property value="serverURL"/>
                </ww:param>
            </ww:include>

            <ww:include value="/include/generic_form_row.jsp">
                <ww:param name="label" value="getText('crowdserver.address.label')" />                
                <ww:param name="value">
                    <ww:property value="application"/>
                </ww:param>
            </ww:include>            

        </div>



        </div>



    </body>
</html>