<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('menu.removeprincipal.label')"/></title>
        <meta name="section" content="principals" />
    </head>
    <body>


<div class="crowdForm">

    <div class="formTitle">
        <h2>
            <ww:property value="getText('menu.removeprincipal.label')"/>
            &nbsp;&ndash;&nbsp;
            <ww:property value="name"/>
        </h2>
    </div>

    <div class="formBody">
        <ww:include value="/include/generic_errors.jsp"/>

        <ww:include value="/include/generic_form_row.jsp">
           <ww:param name="warning" value="getText('principal.remove.text')" />
           <ww:param name="label" value="getText('principal.name.label')" />
           <ww:param name="value" value="name" />
           <ww:param name="description" value=""/>
        </ww:include>

    </div>
    <div class="formFooter wizardFooter">

        <div class="buttons">

            <form method="post" action="<ww:url namespace="/secure/principal" action="removeprincipal" method="update" includeParams="none" />">

                <input type="hidden" name="name" value="<ww:property value="name" />"/>

                <input type="submit" class="button" value="<ww:property value="getText('continue.label')"/> &raquo;"/>
                <input type="button" class="button" value="<ww:property value="getText('cancel.label')"/>"
                       onClick="window.location='<ww:url namespace="/secure/principal" action="viewprincipal" method="default" includeParams="none"><ww:param name="name" value="name" /></ww:url>';"/>
            </form>

        </div>

    </div>


</div>
    </body>
</html>