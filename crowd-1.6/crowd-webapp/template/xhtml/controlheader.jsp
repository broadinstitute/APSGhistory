<%@ taglib uri="/webwork" prefix="webwork" %>

<div class="fieldArea required">

    <webwork:if test="fieldErrors[parameters['name']] != null">
    <div class="errorBox">
        <webwork:iterator value="fieldErrors[parameters['name']]">
            <webwork:property /><br />
        </webwork:iterator>
    </div>
    </webwork:if>

    <label class="fieldLabelArea" for="<webwork:property value="parameters['name']"/>">

        <webwork:if test="parameters['required'] == true">
            <span class="required">*</span>
        </webwork:if>

        <webwork:property value="parameters['label']"/>:</label>

            <div class="fieldValueArea">
