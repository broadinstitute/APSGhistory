<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<ww:if test="hasActionErrors()">
    <p class="warningBox">
    <ww:iterator value="actionErrors">
        <ww:property/><br/>
    </ww:iterator>
    </p>
</ww:if>

<ww:if test="containsActionMessages()">

    <ww:if test="actionMessageAlertColor == 'green'">
        <p class="successsBox">
    </ww:if>
    <ww:elseif test="actionMessageAlertColor == 'blue'">
        <p class="successsBox">
    </ww:elseif>
    <ww:else>
        <p class="noteBox">
    </ww:else>

    <ww:iterator value="actionMessages">
        <ww:property/><br/>
    </ww:iterator>

    </p>

</ww:if>