<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>

<ww:if test="actionErrors">
    <ww:iterator value="actionErrors">
        <p class="error" style="margin-top:10px;">
            <ww:property/>
            <br/>
        </p>
    </ww:iterator>
</ww:if>