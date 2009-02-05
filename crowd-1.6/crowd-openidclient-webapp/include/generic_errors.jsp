<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<ww:if test="containsErrorMessages()">
    <p class="warningBox">
    <ww:iterator value="actionErrors">
        <ww:property/><br/>
    </ww:iterator>
    </p>
</ww:if>

<ww:if test="containsActionMessages()">
    <p class="noteBox">
    <ww:iterator value="actionMessages">
        <ww:property/><br/>
    </ww:iterator>
    </p>
</ww:if>