<%@ taglib uri="/webwork" prefix="ww" %>

<ww:if test="containsErrorMessages()">
    <p class="warningBox">
    <ww:iterator value="actionErrors">
        <ww:property escape="false"/><br/>
    </ww:iterator>
    </p>
</ww:if>

<ww:if test="containsActionMessages()">
    <ww:if test="actionMessageAlertColor == 'green'">
        <p class="successsBox">
    </ww:if>
    <ww:elseif test="actionMessageAlertColor == 'blue'">
        <p class="informationBox">
    </ww:elseif>
    <ww:else>
        <p class="noteBox">
    </ww:else>

    <ww:iterator value="actionMessages">
        <ww:property/><br/>
    </ww:iterator>
    </p>
</ww:if>

<ww:if test="#request['updateSuccessful'] || #parameters['updateSuccessful']">
    <p class="informationBox">
        <ww:property value="getText('updatesuccessful.label')"/>
    </p>
</ww:if>
