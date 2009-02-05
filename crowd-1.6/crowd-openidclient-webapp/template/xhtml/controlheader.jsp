<%@ taglib uri="/webwork" prefix="webwork" %>


<div class="fieldArea required">

    <div class="errorBox">
        <webwork:iterator value="fieldErrors[parameters['name']]">
            <webwork:property />
        </webwork:iterator>
    </div>

    <label class="fieldLabelArea" for="<webwork:property value="parameters['label']"/>">

        <webwork:if test="parameters['required'] == true">
            <span class="required">*</span>
        </webwork:if>

        <webwork:property value="parameters['label']"/>:</label>

            <div class="fieldValueArea">
